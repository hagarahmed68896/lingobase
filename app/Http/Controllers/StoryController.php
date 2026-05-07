<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\StoryLevel;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
         // Load languages with levels, and levels with stories filtered by search
         $languages = Language::with(['storyLevels.stories' => function($query) use ($request) {
            if ($request->has('search') && $request->search != '') {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
        }])->get();

        // If searching, filter out empty levels/languages
        if ($request->has('search') && $request->search != '') {
            $languages->each(function($language) {
                $language->setRelation('storyLevels', $language->storyLevels->filter(function($level) {
                    return $level->stories->isNotEmpty();
                }));
            });
            
            $languages = $languages->filter(function($language) {
                return $language->storyLevels->isNotEmpty();
            });
        }

        return view('stories.index', compact('languages'));
    }

    public function showLevel($languageSlug, $levelSlug)
    {
        $language = Language::where('slug', $languageSlug)->firstOrFail();
        $level = StoryLevel::where('slug', $levelSlug)
            ->where('language_id', $language->id)
            ->with('stories')
            ->firstOrFail();

        return view('stories.level', compact('language', 'level'));
    }

    public function showStory($languageSlug, $levelSlug, $storySlug)
    {
        $language = Language::where('slug', $languageSlug)->firstOrFail();
        $level = StoryLevel::where('slug', $levelSlug)
            ->where('language_id', $language->id)
            ->firstOrFail();
        $story = Story::where('slug', $storySlug)
            ->where('story_level_id', $level->id)
            ->firstOrFail();

        return view('stories.show', compact('language', 'level', 'story'));
    }
}
