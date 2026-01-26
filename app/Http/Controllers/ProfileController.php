<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent activity - you can expand this later with actual data
        $recentActivity = [];

        return view('profile.index', compact('user', 'recentActivity'));
    }
}
