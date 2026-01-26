<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\GrammarLesson;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('favoritable')->latest()->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:grammar_lesson,story'
        ]);

        $modelClass = match($request->type) {
            'grammar_lesson' => GrammarLesson::class,
            'story' => Story::class,
        };

        $model = $modelClass::findOrFail($request->id);
        
        $favorite = Auth::user()->favorites()->where('favoritable_id', $model->id)->where('favoritable_type', $modelClass)->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Auth::user()->favorites()->create([
                'favoritable_id' => $model->id,
                'favoritable_type' => $modelClass
            ]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
