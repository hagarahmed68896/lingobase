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
use App\Models\Language;

class PlacementTestController extends Controller
{
    // Settings will be fetched from database

    public function start(Request $request, $languageSlug)
    {
        $request->validate([]);

        try {
            DB::beginTransaction();

            $language = Language::where('slug', $languageSlug)
                ->orWhere('code', $languageSlug)
                ->firstOrFail();
            $languageId = $language->id;

            $user = Auth::user();
            $userId = $user ? $user->id : null;

            // 1. Select Grammar Questions
            $grammarQuestions = $this->selectGrammarQuestions($languageId);

            // 2. Select Listening Questions
            $listeningQuestions = PlacementQuestion::where('section', 'listening')
                ->where('language_id', $languageId)
                ->inRandomOrder()->limit(2)->pluck('id')->toArray();

            // 3. Select Reading Questions
            $readingQuestions = PlacementQuestion::where('section', 'reading')
                ->where('language_id', $languageId)
                ->inRandomOrder()->limit(2)->pluck('id')->toArray();

            // Merge sequences: Grammar -> Listening -> Reading
            $questionSequence = array_merge($grammarQuestions, $listeningQuestions, $readingQuestions);

            // Create Test Session
            $test = PlacementTest::create([
                'user_id' => $userId,
                'language_id' => $languageId,
                'status' => 'in_progress',
                'question_sequence' => $questionSequence,
                'current_question_index' => 0,
                'total_score' => 0
            ]);

            if (!$userId) {
                session()->put('guest_placement_test_id', $test->id);
            }

            DB::commit();

            if (empty($questionSequence)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No questions found for the placement test. Please contact administrator.'
                ], 404);
            }

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

    private function selectGrammarQuestions($languageId)
    {
        $selectedIds = [];
        $usedSkills = []; 
        
        $levelsMap = [
            'A1' => ['A1'],
            'A2' => ['A2'],
            'B1' => ['B1'],
            'B2' => ['B2', 'B2+', 'C1']
        ];

        $grammarQuotas = [
            'A1' => 6, 'A2' => 6, 'B1' => 4, 'B2' => 4
        ];

        foreach ($grammarQuotas as $quotaGroup => $count) {
            $levels = $levelsMap[$quotaGroup];
            
            $pool = PlacementQuestion::where('section', 'grammar')
                ->where('language_id', $languageId)
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

    public function getQuestion(Request $request, $languageSlug, $testId)
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

    public function navigateToQuestion(Request $request, $languageSlug, $testId)
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

    public function completeTest(Request $request, $languageSlug, $testId)
    {
        $test = PlacementTest::findOrFail($testId);
        return $this->finishTest($test);
    }

    public function submitAnswer(Request $request, $languageSlug, $testId)
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
            
            // Calculate dynamic points based on new rules
            $dynamicPoints = 0;
            if ($question->section == 'reading' || $question->section == 'listening') {
                $dynamicPoints = 5;
            } else {
                if (in_array($question->level, ['A1'])) $dynamicPoints = 1;
                elseif (in_array($question->level, ['A2'])) $dynamicPoints = 2;
                elseif (in_array($question->level, ['B1'])) $dynamicPoints = 3;
                elseif (in_array($question->level, ['B2', 'B2+', 'C1'])) $dynamicPoints = 4;
                else $dynamicPoints = 1;
            }

            $pointsEarned = $isCorrect ? $dynamicPoints : 0;
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
        $a1_correct = 0;
        $a2_correct = 0;
        $b1_correct = 0;
        $b2_correct = 0;
        $reading_listening_score = 0;
        
        $totalPotential = 66; // Fixed max score based on new rules

        // Calculate breakdown
        $answers = PlacementAnswer::where('user_placement_test_id', $test->id)->get();
        
        foreach ($answers as $ans) {
            if ($ans->is_correct) {
                $q = PlacementQuestion::find($ans->placement_question_id);
                if ($q) {
                    if ($q->section == 'reading' || $q->section == 'listening') {
                        $reading_listening_score += 5;
                    } else {
                        if (in_array($q->level, ['A1'])) $a1_correct++;
                        elseif (in_array($q->level, ['A2'])) $a2_correct++;
                        elseif (in_array($q->level, ['B1'])) $b1_correct++;
                        elseif (in_array($q->level, ['B2', 'B2+', 'C1'])) $b2_correct++;
                    }
                }
            }
        }

        // Calculate overall percentage
        $percentage = $totalPotential > 0 ? round(($test->total_score / $totalPotential) * 100, 2) : 0;

        $score = $test->total_score;
        $finalLevel = 'A0';
        $label = 'Absolute Beginner';

        // Evaluate from top-down to bottom-up to assign highest level based on gates
        if ($b2_correct >= 2 && $reading_listening_score >= 14 && $score >= 55) {
            $finalLevel = 'B2';
            $label = 'Upper-Intermediate';
        } elseif ($b1_correct >= 2 && $reading_listening_score >= 10 && $b2_correct < 2) {
            $finalLevel = 'B1';
            $label = 'Intermediate';
        } elseif ($a2_correct >= 4 && $b1_correct < 2) {
            $finalLevel = 'A2';
            $label = 'Elementary';
        } elseif ($a1_correct >= 3 && $a1_correct <= 6 && $a2_correct < 4) {
            $finalLevel = 'A1';
            $label = 'Beginner';
        } else {
            // Default fallback if they don't cleanly fit a gate, use bottom-up approximation
            if ($b2_correct >= 2 && $reading_listening_score >= 14 && $score >= 55) {
                $finalLevel = 'B2';
                $label = 'Upper-Intermediate';
            } elseif ($b1_correct >= 2 && $reading_listening_score >= 10) {
                $finalLevel = 'B1';
                $label = 'Intermediate';
            } elseif ($a2_correct >= 4) {
                $finalLevel = 'A2';
                $label = 'Elementary';
            } elseif ($a1_correct >= 3) {
                $finalLevel = 'A1';
                $label = 'Beginner';
            } else {
                $finalLevel = 'A0';
                $label = 'Absolute Beginner';
            }
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
        $levelModel = GrammarLevel::where('language_id', $test->language_id)
            ->where('slug', 'LIKE', "%" . strtolower($finalLevel) . "%")
            ->first();
        // Fallback for A0 to A1 lessons
        if (!$levelModel && $finalLevel == 'A0') {
            $levelModel = GrammarLevel::where('language_id', $test->language_id)
                ->where('slug', 'LIKE', "%a1%")
                ->first();
        }
        
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
                'section_breakdown' => [
                    'A1_correct' => $a1_correct,
                    'A2_correct' => $a2_correct,
                    'B1_correct' => $b1_correct,
                    'B2_correct' => $b2_correct,
                    'Reading_Listening_score' => $reading_listening_score
                ],
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
