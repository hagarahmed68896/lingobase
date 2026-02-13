<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PlacementQuestion;
use App\Models\PlacementTest;
use App\Models\PlacementAnswer;
use App\Models\GrammarLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PlacementTestController extends Controller
{
    // Grammar Level Distribution Quotas (20 total)
    const GRAMMAR_QUOTAS = [
        'A1/A2' => 9,
        'B1' => 6,
        'B2' => 5,
        'C1' => 4
    ];

    // Vocabulary Quotas (15 total)
    const VOCAB_QUOTAS = [
        'Normal' => 7,
        'Extra' => 4
    ];

    public function start(Request $request)
    {
        $request->validate([]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $userId = $user ? $user->id : null;

            $user = Auth::user();
            $userId = $user ? $user->id : null;

            // 1. Select Grammar Questions (20 Total)
            $grammarQuestions = $this->selectGrammarQuestions();

            // 2. Select Vocabulary Questions (15 Total)
            $vocabQuestions = $this->selectVocabQuestions();

            // 3. Select Listening Questions (4 Total)
            $listeningQuestions = PlacementQuestion::where('section', 'listening')->inRandomOrder()->limit(4)->pluck('id')->toArray();

            // 4. Select Reading Questions (4 Total)
            $readingQuestions = PlacementQuestion::where('section', 'reading')->inRandomOrder()->limit(4)->pluck('id')->toArray();

            // Merge sequences: Grammar -> Vocab -> Listening -> Reading
            $questionSequence = array_merge($grammarQuestions, $vocabQuestions, $listeningQuestions, $readingQuestions);

            // Create Test Session
            $test = PlacementTest::create([
                'user_id' => $userId,
                'status' => 'in_progress',
                'question_sequence' => $questionSequence,
                'current_question_index' => 0,
                'total_score' => 0
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Test started successfully',
                'data' => [
                    'test_id' => $test->id,
                    'total_questions' => count($questionSequence),
                    'first_question' => $this->getQuestionDetails($questionSequence[0], 1, count($questionSequence), $test->id),
                    'all_questions' => $this->getAllQuestionsStatus($test)
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function selectGrammarQuestions()
    {
        $selectedIds = [];
        $usedSkills = []; 
        
        $levelsMap = [
            'A1/A2' => ['A1', 'A2'],
            'B1' => ['B1'],
            'B2' => ['B2', 'B2+'],
            'C1' => ['C1']
        ];

        foreach (self::GRAMMAR_QUOTAS as $quotaGroup => $count) {
            $levels = $levelsMap[$quotaGroup];
            
            $pool = PlacementQuestion::where('section', 'grammar')
                ->whereIn('level', $levels)
                ->inRandomOrder()
                ->get();

            $groupSelected = 0;
            
            foreach ($pool as $question) {
                if ($groupSelected >= $count) break;

                $skill = $question->skill;

                // Constraint: Unique Skill
                if (!in_array($skill, $usedSkills)) {
                    $selectedIds[] = $question->id;
                    $usedSkills[] = $skill;
                    $groupSelected++;
                }
            }
        }

        return $selectedIds;
    }

    private function selectVocabQuestions()
    {
        // 11 Questions: 7 Normal, 4 Extra
        $selectedIds = [];
        $usedIds = [];

        // Select 7 Normal category questions
        $normalQuestions = PlacementQuestion::where('section', 'vocabulary')
            ->where('vocab_category', 'Normal')
            ->inRandomOrder()
            ->limit(7)
            ->pluck('id')
            ->toArray();

        $selectedIds = array_merge($selectedIds, $normalQuestions);
        $usedIds = array_merge($usedIds, $normalQuestions);

        // Select 4 Extra category questions
        $extraQuestions = PlacementQuestion::where('section', 'vocabulary')
            ->where('vocab_category', 'Extra')
            ->whereNotIn('id', $usedIds)
            ->inRandomOrder()
            ->limit(4)
            ->pluck('id')
            ->toArray();

        $selectedIds = array_merge($selectedIds, $extraQuestions);

        return $selectedIds;
    }

    public function getQuestion(Request $request, $testId)
    {
        $test = PlacementTest::findOrFail($testId);
        
        // Security check for user ownership if logged in
        // if ($test->user_id && $test->user_id != auth()->id()) abort(403);

        $sequence = $test->question_sequence;
        $currentIndex = $test->current_question_index;

        if ($currentIndex >= count($sequence)) {
             return response()->json(['status' => false, 'message' => 'Test already completed', 'completed' => true]);
        }

        $questionId = $sequence[$currentIndex];
        return response()->json([
            'status' => true,
            'data' => $this->getQuestionDetails($questionId, $currentIndex + 1, count($sequence), $test->id)
        ]);
    }

    public function navigateToQuestion(Request $request, $testId)
    {
        $request->validate([
            'question_index' => 'required|integer|min:0'
        ]);

        $test = PlacementTest::findOrFail($testId);
        $questionIndex = $request->question_index;

        if ($questionIndex >= count($test->question_sequence)) {
            return response()->json(['status' => false, 'message' => 'Invalid question index'], 400);
        }

        $questionId = $test->question_sequence[$questionIndex];
        
        return response()->json([
            'status' => true,
            'data' => $this->getQuestionDetails($questionId, $questionIndex + 1, count($test->question_sequence), $test->id)
        ]);
    }

    public function completeTest(Request $request, $testId)
    {
        $test = PlacementTest::findOrFail($testId);
        return $this->finishTest($test);
    }

    public function submitAnswer(Request $request, $testId)
    {
        $request->validate([
            'question_id' => 'required|exists:placement_questions,id',
            'option_id' => 'nullable|exists:placement_options,id'
        ]);

        $test = PlacementTest::findOrFail($testId);
        
        // Validate question belongs to this test
        if (!in_array($request->question_id, $test->question_sequence)) {
            return response()->json(['status' => false, 'message' => 'Invalid question for this test'], 400);
        }

        $question = PlacementQuestion::find($request->question_id);
        
        $isCorrect = false;
        $pointsEarned = 0;
        $selectedOptionId = null;

        if ($request->option_id) {
            $option = \App\Models\PlacementOption::find($request->option_id);
            $isCorrect = $option->is_correct;
            $pointsEarned = $isCorrect ? $question->points : 0;
            $selectedOptionId = $option->id;
        }

        // Check if answer already exists
        $existingAnswer = PlacementAnswer::where('user_placement_test_id', $test->id)
            ->where('placement_question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            // Update existing answer
            $oldPoints = $existingAnswer->points_earned;
            
            $existingAnswer->update([
                'selected_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned
            ]);

            // Recalculate scores
            $test->total_score = $test->total_score - $oldPoints + $pointsEarned;
            
            if ($question->section == 'grammar') {
                $test->grammar_score = $test->grammar_score - $oldPoints + $pointsEarned;
            }
            if ($question->section == 'vocabulary') {
                $test->vocabulary_score = $test->vocabulary_score - $oldPoints + $pointsEarned;
            }
        } else {
            // Create new answer
            PlacementAnswer::create([
                'user_placement_test_id' => $test->id,
                'placement_question_id' => $question->id,
                'selected_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned
            ]);

            // Update Stats
            $test->total_score += $pointsEarned;
            if ($question->section == 'grammar') $test->grammar_score += $pointsEarned;
            if ($question->section == 'vocabulary') $test->vocabulary_score += $pointsEarned;
        }
        
        $test->save();

        // Get all answered question IDs
        $answeredQuestions = PlacementAnswer::where('user_placement_test_id', $test->id)
            ->pluck('placement_question_id')
            ->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Answer saved',
            'data' => [
                'answered_questions' => $answeredQuestions,
                'total_answered' => count($answeredQuestions),
                'total_questions' => count($test->question_sequence)
            ]
        ]);
    }

    private function finishTest(PlacementTest $test)
    {
        $totalPotential = 0;
        foreach ($test->question_sequence as $qid) {
             $q = PlacementQuestion::find($qid);
             if ($q) $totalPotential += $q->points;
        }

        // Calculate overall percentage
        $percentage = $totalPotential > 0 ? round(($test->total_score / $totalPotential) * 100, 2) : 0;

        $score = $test->total_score;
        $finalLevel = 'A1';
        $label = 'Beginner';

        if ($score >= 0 && $score <= 0.8) {
            $finalLevel = 'A1';
            $label = 'Beginner';
        } elseif ($score > 0.8 && $score <= 1.5) {
            $finalLevel = 'A1+';
            $label = 'High Beginner';
        } elseif ($score > 1.5 && $score <= 2.5) {
            $finalLevel = 'A2';
            $label = 'Elementary';
        } elseif ($score > 2.5 && $score <= 3.5) {
            $finalLevel = 'A2+';
            $label = 'High Elementary';
        } elseif ($score > 3.5 && $score <= 4.8) {
            $finalLevel = 'B1';
            $label = 'Intermediate';
        } elseif ($score > 4.8 && $score <= 6.2) {
            $finalLevel = 'B1+';
            $label = 'High Intermediate';
        } elseif ($score > 6.2 && $score <= 7.5) {
            $finalLevel = 'B2';
            $label = 'Upper-Intermediate';
        } elseif ($score > 7.5 && $score <= 9.0) {
            $finalLevel = 'C1';
            $label = 'Advanced';
        }
        
        $test->detected_level = $finalLevel;
        $test->status = 'completed';
        $test->save();

        // Trigger Notification
        if ($test->user) {
            $test->user->notify(new \App\Notifications\TestCompletedNotification([
                'level' => $finalLevel,
                'score' => round($test->total_score, 1)
            ]));
        }

        // Get recommendations based on level
        $recommendations = [];
        $levelModel = GrammarLevel::where('slug', 'LIKE', "%" . strtolower($finalLevel) . "%")->first();
        if ($levelModel) {
            $lessons = $levelModel->lessons()->limit(3)->get();
            foreach ($lessons as $lesson) {
                $recommendations[] = [
                    'title' => $lesson->title,
                    'level' => $finalLevel,
                    'url' => route('grammar.lesson', [
                        'language' => $levelModel->language->slug,
                        'level' => $levelModel->slug,
                        'lesson' => $lesson->slug
                    ])
                ];
            }
        }

        return response()->json([
            'status' => true,
            'completed' => true,
            'data' => [
                'total_score' => round($test->total_score, 1),
                'total_potential' => round($totalPotential, 1),
                'percentage' => $percentage,
                'detected_level' => $finalLevel,
                'grammar_score' => round($test->grammar_score, 1),
                'vocab_score' => round($test->vocabulary_score, 1),
                'recommendations' => $recommendations
            ]
        ]);
    }

    private function getQuestionDetails($id, $index = 1, $total = 0, $testId = null)
    {
        $q = PlacementQuestion::with('options')->find($id);
        
        $data = [
            'id' => $q->id,
            'text' => $q->question_text,
            'section' => $q->section,
            'media_url' => $q->media_url,
            'options' => $q->options->map(function($opt) {
                return ['id' => $opt->id, 'text' => $opt->option_text];
            }),
            'progress' => [
                'current' => $index,
                'total' => $total
            ],
            'answered' => false,
            'selected_option_id' => null
        ];

        // Check if this question has been answered
        if ($testId) {
            $answer = PlacementAnswer::where('user_placement_test_id', $testId)
                ->where('placement_question_id', $id)
                ->first();
            
            if ($answer) {
                $data['answered'] = true;
                $data['selected_option_id'] = $answer->selected_option_id;
            }
        }

        return $data;
    }

    private function getAllQuestionsStatus(PlacementTest $test)
    {
        $answeredQuestions = PlacementAnswer::where('user_placement_test_id', $test->id)
            ->pluck('placement_question_id')
            ->toArray();

        $questions = [];
        foreach ($test->question_sequence as $index => $questionId) {
            $question = PlacementQuestion::find($questionId);
            $questions[] = [
                'index' => $index,
                'id' => $questionId,
                'section' => $question->section,
                'answered' => in_array($questionId, $answeredQuestions)
            ];
        }

        return $questions;
    }
}
