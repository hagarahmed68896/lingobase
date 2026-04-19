<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlacementQuestion;
use App\Models\PlacementOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlacementQuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = PlacementQuestion::query();

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('search')) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        $questions = $query->orderBy('id', 'desc')->paginate(15);
        
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1'];
        $sections = ['grammar', 'vocabulary', 'reading', 'listening'];

        $stats = [];
        foreach ($sections as $section) {
            $stats[$section] = \App\Models\PlacementQuestion::where('section', $section)->count();
        }

        return view('admin.placement_questions.index', compact('questions', 'levels', 'sections', 'stats'));
    }

    public function create()
    {
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1'];
        $sections = ['grammar', 'vocabulary', 'reading', 'listening'];
        
        return view('admin.placement_questions.create', compact('levels', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|string',
            'section' => 'required|string',
            'question_text' => 'required|string',
            'points' => 'required|numeric|min:0.1',
            'skill' => 'nullable|string',
            'sub_skill' => 'nullable|string',
            'vocab_category' => 'nullable|string',
            'media_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // 10MB max audio
            'distractor_logic' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $data = $request->only(['level', 'section', 'question_text', 'points', 'skill', 'sub_skill', 'vocab_category', 'distractor_logic']);
        
        if ($request->hasFile('media_file')) {
            $path = $request->file('media_file')->store('placement_audio', 'public');
            $data['media_url'] = '/storage/' . $path;
        }

        $question = PlacementQuestion::create($data);

        foreach ($request->options as $index => $option) {
            PlacementOption::create([
                'placement_question_id' => $question->id,
                'option_text' => $option['text'],
                'is_correct' => $index == $request->correct_option,
            ]);
        }

        return redirect()->route('admin.placement-questions.index')->with('success', 'Question added successfully.');
    }

    public function edit(PlacementQuestion $placementQuestion)
    {
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1'];
        $sections = ['grammar', 'vocabulary', 'reading', 'listening'];
        $placementQuestion->load('options');
        
        return view('admin.placement_questions.edit', compact('placementQuestion', 'levels', 'sections'));
    }

    public function update(Request $request, PlacementQuestion $placementQuestion)
    {
        $validated = $request->validate([
            'level' => 'required|string',
            'section' => 'required|string',
            'question_text' => 'required|string',
            'points' => 'required|numeric|min:0.1',
            'skill' => 'nullable|string',
            'sub_skill' => 'nullable|string',
            'vocab_category' => 'nullable|string',
            'media_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'remove_media' => 'nullable|boolean',
            'distractor_logic' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'options.*.id' => 'nullable|exists:placement_options,id',
            'correct_option' => 'required|integer',
        ]);

        $data = $request->only(['level', 'section', 'question_text', 'points', 'skill', 'sub_skill', 'vocab_category', 'distractor_logic']);
        
        if ($request->has('remove_media') && $request->remove_media) {
            if ($placementQuestion->media_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $placementQuestion->media_url));
            }
            $data['media_url'] = null;
        } elseif ($request->hasFile('media_file')) {
            if ($placementQuestion->media_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $placementQuestion->media_url));
            }
            $path = $request->file('media_file')->store('placement_audio', 'public');
            $data['media_url'] = '/storage/' . $path;
        }

        $placementQuestion->update($data);

        $existingOptionIds = $placementQuestion->options()->pluck('id')->toArray();
        $submittedOptionIds = [];

        foreach ($request->options as $index => $optionData) {
            $isCorrect = ($index == $request->correct_option);
            
            if (!empty($optionData['id']) && in_array($optionData['id'], $existingOptionIds)) {
                PlacementOption::where('id', $optionData['id'])->update([
                    'option_text' => $optionData['text'],
                    'is_correct' => $isCorrect,
                ]);
                $submittedOptionIds[] = $optionData['id'];
            } else {
                $newOption = PlacementOption::create([
                    'placement_question_id' => $placementQuestion->id,
                    'option_text' => $optionData['text'],
                    'is_correct' => $isCorrect,
                ]);
                $submittedOptionIds[] = $newOption->id;
            }
        }

        $toDelete = array_diff($existingOptionIds, $submittedOptionIds);
        if (!empty($toDelete)) {
            PlacementOption::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.placement-questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(PlacementQuestion $placementQuestion)
    {
        if ($placementQuestion->media_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $placementQuestion->media_url));
        }
        $placementQuestion->delete();
        return redirect()->back()->with('success', 'Question deleted successfully.');
    }
}
