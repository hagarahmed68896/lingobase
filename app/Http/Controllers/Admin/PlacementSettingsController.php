<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlacementSetting;
use Illuminate\Http\Request;

class PlacementSettingsController extends Controller
{
    public function index()
    {
        $grammarQuotas = PlacementSetting::getValue('grammar_quotas', [
            'A1/A2' => 9,
            'B1' => 6,
            'B2' => 5,
            'C1' => 4
        ]);

        $vocabQuotas = PlacementSetting::getValue('vocab_quotas', [
            'Normal' => 7,
            'Extra' => 4
        ]);

        $otherQuotas = PlacementSetting::getValue('other_quotas', [
            'listening' => 4,
            'reading' => 4
        ]);

        return view('admin.placement_settings.index', compact('grammarQuotas', 'vocabQuotas', 'otherQuotas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'grammar_quotas' => 'required|array',
            'vocab_quotas' => 'required|array',
            'other_quotas' => 'required|array',
        ]);

        PlacementSetting::updateOrCreate(['key' => 'grammar_quotas'], ['value' => $request->grammar_quotas]);
        PlacementSetting::updateOrCreate(['key' => 'vocab_quotas'], ['value' => $request->vocab_quotas]);
        PlacementSetting::updateOrCreate(['key' => 'other_quotas'], ['value' => $request->other_quotas]);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
