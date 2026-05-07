<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarLesson;
use App\Models\GrammarQuiz;
use App\Models\GrammarQuestion;
use App\Models\GrammarOption;
use Illuminate\Http\Request;

class GrammarQuizController extends Controller
{
    public function index(GrammarLesson $lesson)
    {
        $quiz = GrammarQuiz::firstOrCreate(
            ['grammar_lesson_id' => $lesson->id],
            ['title' => $lesson->title . ' Quiz']
        );

        $questions = $quiz->questions()->with('options')->get();

        return view('admin.grammar.quiz.index', compact('lesson', 'quiz', 'questions'));
    }

    public function create(GrammarLesson $lesson)
    {
        return view('admin.grammar.quiz.create', compact('lesson'));
    }

    public function store(Request $request, GrammarLesson $lesson)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $quiz = GrammarQuiz::firstOrCreate(
            ['grammar_lesson_id' => $lesson->id],
            ['title' => $lesson->title . ' Quiz']
        );

        $question = GrammarQuestion::create([
            'grammar_quiz_id' => $quiz->id,
            'question' => $validated['question'],
            'type' => 'multiple_choice'
        ]);

        foreach ($validated['options'] as $index => $optionData) {
            GrammarOption::create([
                'grammar_question_id' => $question->id,
                'option_text' => $optionData['text'],
                'is_correct' => $index == $validated['correct_option']
            ]);
        }

        return redirect()->route('admin.grammar.quiz.index', $lesson)->with('success', 'Question added successfully.');
    }

    public function edit(GrammarQuestion $question)
    {
        $question->load('options');
        $lesson = $question->quiz->lesson;
        return view('admin.grammar.quiz.edit', compact('question', 'lesson'));
    }

    public function update(Request $request, GrammarQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'options.*.id' => 'nullable|exists:grammar_options,id',
            'correct_option' => 'required|integer',
        ]);

        $question->update(['question' => $validated['question']]);

        $existingOptionIds = $question->options()->pluck('id')->toArray();
        $submittedOptionIds = [];

        foreach ($validated['options'] as $index => $optionData) {
            $isCorrect = ($index == $validated['correct_option']);
            
            if (!empty($optionData['id']) && in_array($optionData['id'], $existingOptionIds)) {
                GrammarOption::where('id', $optionData['id'])->update([
                    'option_text' => $optionData['text'],
                    'is_correct' => $isCorrect
                ]);
                $submittedOptionIds[] = $optionData['id'];
            } else {
                $newOption = GrammarOption::create([
                    'grammar_question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'is_correct' => $isCorrect
                ]);
                $submittedOptionIds[] = $newOption->id;
            }
        }

        GrammarOption::where('grammar_question_id', $question->id)
            ->whereNotIn('id', $submittedOptionIds)
            ->delete();

        return redirect()->route('admin.grammar.quiz.index', $question->quiz->lesson_id)->with('success', 'Question updated successfully.');
    }

    public function destroy(GrammarQuestion $question)
    {
        $lessonId = $question->quiz->grammar_lesson_id;
        $question->delete();
        return redirect()->route('admin.grammar.quiz.index', $lessonId)->with('success', 'Question deleted successfully.');
    }
}
