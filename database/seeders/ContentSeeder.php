<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\GrammarLevel;
use App\Models\GrammarLesson;
use App\Models\GrammarQuiz;
use App\Models\GrammarQuestion;
use App\Models\GrammarOption;
use App\Models\StoryLevel;
use App\Models\Story;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run()
    {
        // Create English Language
        $english = Language::firstOrCreate(
            ['code' => 'en'],
            ['name' => 'English', 'slug' => 'english']
        );

        // --- GRAMMAR ---
        $grammarLevels = ['A1' => 'Beginner', 'A2' => 'Elementary', 'B1' => 'Intermediate', 'B2' => 'Upper Intermediate'];
        
        foreach ($grammarLevels as $code => $name) {
            $level = GrammarLevel::firstOrCreate(
                ['slug' => Str::slug($code)],
                ['language_id' => $english->id, 'name' => "$code - $name"]
            );

            // Create 3 Lessons per Level
            for ($i = 1; $i <= 3; $i++) {
                $lesson = GrammarLesson::updateOrCreate(
                    ['slug' => Str::slug("lesson-$code-$i")],
                    [
                        'grammar_level_id' => $level->id,
                        'title' => "$name Grammar Lesson $i",
                        'order' => $i,
                        'explanation' => '<p>This is a <strong>comprehensive</strong> explanation of the grammar rule. It covers usage, exceptions, and examples.</p><ul><li>Example 1: I am learning.</li><li>Example 2: He is playing.</li></ul><p>Remember this rule!</p>',
                    ]
                );

                // Create Quiz
                $quiz = GrammarQuiz::updateOrCreate(
                    ['grammar_lesson_id' => $lesson->id],
                    ['title' => "Quiz for Lesson $i"]
                );

                // Create 3 Questions per Quiz
                // Check if questions exist first to avoid duplication on re-seed
                 if ($quiz->questions()->count() == 0) {
                    for ($q = 1; $q <= 3; $q++) {
                        $question = GrammarQuestion::create([
                            'grammar_quiz_id' => $quiz->id,
                            'question' => "What is the correct form for question $q?",
                            'type' => 'multiple_choice'
                        ]);

                        // Create Options
                        GrammarOption::create(['grammar_question_id' => $question->id, 'option_text' => 'Option A (Correct)', 'is_correct' => true]);
                        GrammarOption::create(['grammar_question_id' => $question->id, 'option_text' => 'Option B', 'is_correct' => false]);
                        GrammarOption::create(['grammar_question_id' => $question->id, 'option_text' => 'Option C', 'is_correct' => false]);
                        GrammarOption::create(['grammar_question_id' => $question->id, 'option_text' => 'Option D', 'is_correct' => false]);
                    }
                }
            }
        }

        // --- STORIES ---
        $storyLevels = ['Beginner', 'Intermediate', 'Advanced'];
        
        foreach ($storyLevels as $lvlName) {
            $level = StoryLevel::firstOrCreate(
                ['slug' => Str::slug($lvlName)],
                ['language_id' => $english->id, 'name' => $lvlName]
            );

            // Create 3 Stories per Level
            for ($i = 1; $i <= 3; $i++) {
                Story::updateOrCreate(
                    ['slug' => Str::slug("story-$lvlName-$i")],
                    [
                        'story_level_id' => $level->id,
                        'title' => "The $lvlName Adventure Part $i",
                        'content' => "<p>Once upon a time, there was a student learning English at the $lvlName level. It was a sunny day...</p><p>They walked through the forest of vocabulary and climbed the mountain of grammar.</p><p>The End.</p>",
                        'excerpt' => "A thrilling story about learning English at the $lvlName level...",
                        'image_url' => 'https://source.unsplash.com/random/800x600?nature,book',
                    ]
                );
            }
        }
    }
}
