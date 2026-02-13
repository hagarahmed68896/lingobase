<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlacementQuestion;
use App\Models\PlacementOption;
use Illuminate\Support\Facades\DB;

class PlacementTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing data to prevent duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PlacementQuestion::truncate();
        PlacementOption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->importGrammarQuestions();
        $this->importVocabularyQuestions();
        $this->createPlaceholderSections();
    }

    private function importGrammarQuestions()
    {
        $csvPath = 'c:\Users\eng.Hagar Ahmed\Downloads\Present Perfect Skill Mapping - Grammar Qustions Bank.csv';
        if (!file_exists($csvPath)) {
            $this->command->error("Grammar CSV not found at: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header

        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            if (empty($row[0])) continue;

            $level = trim($row[0]);
            
            // Set points to 0.2 for grammar to help hit 9.0 total
            $points = 0.2;
            
            $questionText = trim($row[3]);
            
            $question = PlacementQuestion::create([
                'level' => $level,
                'section' => 'grammar',
                'question_text' => $questionText,
                'points' => $points,
                'skill' => trim($row[9] ?? ''),
                'sub_skill' => trim($row[10] ?? ''),
                'distractor_logic' => trim($row[8] ?? ''),
                'question_type' => 'multiple_choice',
            ]);

            $options = [
                'A' => trim($row[4] ?? ''),
                'B' => trim($row[5] ?? ''),
                'C' => trim($row[6] ?? ''),
            ];

            $correctOptionLetter = trim($row[7] ?? 'A');

            foreach ($options as $letter => $text) {
                if (empty($text)) continue;
                PlacementOption::create([
                    'placement_question_id' => $question->id,
                    'option_text' => $text,
                    'is_correct' => (strtoupper($letter) === strtoupper($correctOptionLetter)),
                ]);
            }
            $count++;
        }
        fclose($file);
        $this->command->info("Imported $count Grammar questions.");
    }

    private function importVocabularyQuestions()
    {
        $csvPath = 'c:\Users\eng.Hagar Ahmed\Downloads\B2 Vocabulary Batch Processing - B2 Vocabulary Batch Processing.csv';
        if (!file_exists($csvPath)) {
            $this->command->error("Vocabulary CSV not found at: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header

        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
             if (empty($row[0])) continue;

             $level = trim($row[1]);
             $category = trim($row[2]);
             
             // Set points to approx 0.2133 for vocabulary to hit 9.0 total (7.2 / 35 questions total for G+V)
             // Actually, 20 questions * 0.2 = 4.0. 15 questions * 0.2133 = 3.2. Total = 7.2.
             $points = 0.2133;
             
             $questionText = trim($row[4]);
             $logic = trim($row[9] ?? '');
             
             $skill = 'Vocabulary';
             if (strpos($logic, ':') !== false) {
                 $parts = explode(':', $logic);
                 $skill = trim($parts[0]);
             } else {
                 $skill = $logic;
             }

            $finalSkill = 'General';
            if (stripos($skill, 'Collocation') !== false) $finalSkill = 'Collocation';
            elseif (stripos($skill, 'Idiom') !== false) $finalSkill = 'Collocation';
            elseif (stripos($skill, 'Phrasal Verb') !== false) $finalSkill = 'Phrasal Verb';
            elseif (stripos($skill, 'Precision') !== false) $finalSkill = 'Context';
            elseif (stripos($skill, 'Multi-Meaning') !== false) $finalSkill = 'Context';
            elseif (stripos($skill, 'Antonym') !== false) $finalSkill = 'Logic';
            else $finalSkill = 'Context';

             $question = PlacementQuestion::create([
                'level' => $level,
                'section' => 'vocabulary',
                'question_text' => $questionText,
                'points' => $points,
                'vocab_category' => $category,
                'skill' => $finalSkill,
                'sub_skill' => $skill, 
                'distractor_logic' => $logic,
                'question_type' => 'multiple_choice',
            ]);

            $options = [
                'A' => trim($row[5] ?? ''),
                'B' => trim($row[6] ?? ''),
                'C' => trim($row[7] ?? ''),
            ];
            
            $correctOptionLetter = trim($row[8] ?? 'A');

            foreach ($options as $letter => $text) {
                if (empty($text)) continue;
                PlacementOption::create([
                    'placement_question_id' => $question->id,
                    'option_text' => $text,
                    'is_correct' => (strtoupper($letter) === strtoupper($correctOptionLetter)),
                ]);
            }
            $count++;
        }
        fclose($file);
        $this->command->info("Imported $count Vocabulary questions.");
    }

    private function createPlaceholderSections()
    {
        // Listening Section (4 questions as per request)
        for ($i = 1; $i <= 4; $i++) {
            $q = PlacementQuestion::create([
                'level' => 'B1',
                'section' => 'listening',
                'question_text' => "Listening Question $i: [Placeholder for Audio Clip] What did the speaker imply about the meeting?",
                'points' => 0.225, // As per user request
                'media_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'question_type' => 'multiple_choice',
            ]);
            
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'It was cancelled', 'is_correct' => false]);
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'It was delayed', 'is_correct' => true]);
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'It was successful', 'is_correct' => false]);
        }

        // Reading Section (4 questions as per request)
        for ($i = 1; $i <= 4; $i++) {
            $text = "Reading Text Placeholder $i: The rapid development of AI has transformed many industries...";
            $q = PlacementQuestion::create([
                'level' => 'B2',
                'section' => 'reading',
                'question_text' => "$text\n\nQuestion: What is the main idea?",
                'points' => 0.225, // As per user request
                'question_type' => 'multiple_choice',
            ]);
            
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'AI is dangerous', 'is_correct' => false]);
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'Industries are changing due to AI', 'is_correct' => true]);
            PlacementOption::create(['placement_question_id' => $q->id, 'option_text' => 'Development is slow', 'is_correct' => false]);
        }
        
        $this->command->info("Created 4 Listening and 4 Reading placeholder questions with 0.225 points each.");
    }
}
