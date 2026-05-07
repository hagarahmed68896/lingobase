<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Language;
use App\Models\GrammarLesson;
use App\Models\Story;
use App\Models\UserGrammarProgress;
use App\Models\UserStoryProgress;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_languages' => Language::count(),
            'total_lessons' => GrammarLesson::count(),
            'total_stories' => Story::count(),
            'completed_lessons' => UserGrammarProgress::whereNotNull('completed_at')->count(),
            'completed_stories' => UserStoryProgress::whereNotNull('completed_at')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
