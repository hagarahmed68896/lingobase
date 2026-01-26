<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GrammarLesson;
use App\Models\Language;
use App\Models\GrammarLevel;

class GrammarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GrammarLesson::with('grammarLevel.language');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('language_id')) {
            $query->whereHas('grammarLevel', function ($q) use ($request) {
                $q->where('language_id', $request->language_id);
            });
        }

        $lessons = $query->latest()->paginate(10);
        $languages = Language::all();

        return view('admin.grammar.index', compact('lessons', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = GrammarLevel::with('language')->get();
        return view('admin.grammar.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grammar_level_id' => 'required|exists:grammar_levels,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:grammar_lessons,slug',
            'explanation' => 'required|string',
            'arabic_explanation' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        GrammarLesson::create($validated);

        return redirect()->route('admin.grammar.index')->with('success', 'Lesson created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lesson = GrammarLesson::findOrFail($id);
        $levels = GrammarLevel::with('language')->get();
        return view('admin.grammar.edit', compact('lesson', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lesson = GrammarLesson::findOrFail($id);
        
        $validated = $request->validate([
            'grammar_level_id' => 'required|exists:grammar_levels,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:grammar_lessons,slug,' . $id,
            'explanation' => 'required|string',
            'arabic_explanation' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.grammar.index')->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = GrammarLesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.grammar.index')->with('success', 'Lesson deleted successfully.');
    }
}
