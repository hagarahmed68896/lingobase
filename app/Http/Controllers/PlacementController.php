<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PlacementTest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PlacementController extends Controller
{
    public function index($languageSlug)
    {
        $language = \App\Models\Language::where('slug', $languageSlug)
            ->orWhere('code', $languageSlug)
            ->firstOrFail();
        return view('grammar.placement', [
            'cooldownMinutes' => 0,
            'language' => $language
        ]);
    }
}
