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
        $query = PlacementQuestion::with('language');

        if ($request->filled('language_id')) {
            $query->where('language_id', $request->language_id);
        }

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
            $statsQuery = \App\Models\PlacementQuestion::where('section', $section);
            if ($request->filled('language_id')) {
                $statsQuery->where('language_id', $request->language_id);
            }
            $stats[$section] = $statsQuery->count();
        }
        $languages = \App\Models\Language::all();

        return view('admin.placement_questions.index', compact('questions', 'levels', 'sections', 'stats', 'languages'));
    }

    public function create()
    {
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1'];
        $sections = ['grammar', 'vocabulary', 'reading', 'listening'];
        $languages = \App\Models\Language::all();
        
        return view('admin.placement_questions.create', compact('levels', 'sections', 'languages'));
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
            'language_id' => 'required|exists:languages,id',
        ]);

        $data = $request->only(['level', 'section', 'question_text', 'points', 'skill', 'sub_skill', 'vocab_category', 'distractor_logic', 'language_id']);
        
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
        $languages = \App\Models\Language::all();
        $placementQuestion->load('options');
        
        return view('admin.placement_questions.edit', compact('placementQuestion', 'levels', 'sections', 'languages'));
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
            'language_id' => 'required|exists:languages,id',
        ]);

        $data = $request->only(['level', 'section', 'question_text', 'points', 'skill', 'sub_skill', 'vocab_category', 'distractor_logic', 'language_id']);
        
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

    public function import(Request $request)
    {
        $request->validate([
            'language_id' => 'required|exists:languages,id',
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        if (!$header) {
            return redirect()->back()->with('error', 'Invalid CSV file format.');
        }

        // Clean BOM if exists from first column
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);
        $header = array_map('trim', $header);
        
        $count = 0;
        
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($header) !== count($row)) continue;
                
                $data = array_combine($header, $row);
                
                $questionText = trim($data['Question_Text'] ?? '');
                if (!$questionText) continue;

                $section = strtolower(trim($data['Type'] ?? 'grammar'));
                if (!in_array($section, ['grammar', 'vocabulary', 'reading', 'listening'])) {
                    $section = 'grammar';
                }

                $question = PlacementQuestion::create([
                    'language_id' => $request->language_id,
                    'level' => trim($data['Level'] ?? 'A1'),
                    'section' => $section,
                    'question_text' => $questionText,
                    'distractor_logic' => trim($data['Distractor_Logic'] ?? ''),
                    'points' => 1,
                    'skill' => trim($data['UID'] ?? ''),
                ]);

                $options = [
                    'A' => $data['Option_A'] ?? null,
                    'B' => $data['Option_B'] ?? null,
                    'C' => $data['Option_C'] ?? null,
                ];
                
                $correctLetter = strtoupper(trim($data['Correct'] ?? ''));

                foreach ($options as $letter => $text) {
                    if (!empty(trim($text))) {
                        PlacementOption::create([
                            'placement_question_id' => $question->id,
                            'option_text' => trim($text),
                            'is_correct' => ($letter === $correctLetter)
                        ]);
                    }
                }
                $count++;
            }
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', "Successfully imported {$count} questions!");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
        } finally {
            fclose($handle);
        }
    }
}
