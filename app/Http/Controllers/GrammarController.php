<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\GrammarLevel;
use App\Models\GrammarLesson;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function index(Request $request)
    {
        // Load languages with levels, and levels with lessons filtered by search
        $languages = Language::with(['grammarLevels.lessons' => function($query) use ($request) {
            if ($request->has('search') && $request->search != '') {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
        }])->get();

        // If searching, we might want to filter out languages/levels that have no matching lessons
        if ($request->has('search') && $request->search != '') {
            $languages->each(function($language) {
                $language->setRelation('grammarLevels', $language->grammarLevels->filter(function($level) {
                    return $level->lessons->isNotEmpty();
                }));
            });
            
             $languages = $languages->filter(function($language) {
                return $language->grammarLevels->isNotEmpty();
            });
        }

        return view('grammar.index', compact('languages'));
    }

    public function showLevel($languageSlug, $levelSlug)
    {
        $language = Language::where('slug', $languageSlug)->firstOrFail();
        $level = GrammarLevel::where('slug', $levelSlug)
            ->where('language_id', $language->id)
            ->with('lessons')
            ->firstOrFail();

        return view('grammar.level', compact('language', 'level'));
    }

    public function showLesson($languageSlug, $levelSlug, $lessonSlug)
    {
        $language = Language::where('slug', $languageSlug)->firstOrFail();
        $level = GrammarLevel::where('slug', $levelSlug)
            ->where('language_id', $language->id)
            ->firstOrFail();
        $lesson = GrammarLesson::where('slug', $lessonSlug)
            ->where('grammar_level_id', $level->id)
            ->firstOrFail();

        return view('grammar.lesson', compact('language', 'level', 'lesson'));
    }

    public function showQuiz($languageSlug, $levelSlug, $lessonSlug)
    {
        $language = Language::where('slug', $languageSlug)->firstOrFail();
        $level = GrammarLevel::where('slug', $levelSlug)
            ->where('language_id', $language->id)
            ->firstOrFail();
        $lesson = GrammarLesson::where('slug', $lessonSlug)
            ->where('grammar_level_id', $level->id)
            ->with(['quiz.questions.options'])
            ->firstOrFail();

        if (!$lesson->quiz) {
            return redirect()->back()->with('error', 'Quiz not found.');
        }

        return view('grammar.quiz', compact('language', 'level', 'lesson'));
    }
}
