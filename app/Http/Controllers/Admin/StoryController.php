<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Story;
use App\Models\Language;
use App\Models\StoryLevel;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Story::with('storyLevel.language');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('language_id')) {
            $query->whereHas('storyLevel', function ($q) use ($request) {
                $q->where('language_id', $request->language_id);
            });
        }

        $stories = $query->latest()->paginate(10);
        $languages = Language::all();

        return view('admin.stories.index', compact('stories', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = StoryLevel::with('language')->get();
        return view('admin.stories.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'story_level_id' => 'required|exists:story_levels,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:stories,slug',
            'content' => 'required|string',
            'arabic_comment' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image_url' => 'nullable|url',
            'audio_url' => 'nullable|url',
        ]);

        Story::create($validated);

        return redirect()->route('admin.stories.index')->with('success', 'Story created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $story = Story::findOrFail($id);
        $levels = StoryLevel::with('language')->get();
        return view('admin.stories.edit', compact('story', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $story = Story::findOrFail($id);
        
        $validated = $request->validate([
            'story_level_id' => 'required|exists:story_levels,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:stories,slug,' . $id,
            'content' => 'required|string',
            'arabic_comment' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'image_url' => 'nullable|url',
            'audio_url' => 'nullable|url',
        ]);

        $story->update($validated);

        return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully.');
    }
}
