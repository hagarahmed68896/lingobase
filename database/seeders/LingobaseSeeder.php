<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Language;
use App\Models\GrammarLevel;
use App\Models\GrammarLesson;
use App\Models\GrammarQuiz;
use App\Models\GrammarQuestion;
use App\Models\GrammarOption;
use App\Models\StoryLevel;
use App\Models\Story;

class LingobaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default User if not exists
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // 2. Create English Language
        $english = Language::firstOrCreate(
            ['code' => 'en'],
            ['name' => 'English', 'slug' => 'english']
        );

        // 3. Grammar Levels & Lessons (Expanded)
        $levels = [
            'A1 - Beginner' => [
                'slug' => 'a1-beginner',
                'lessons' => [
                    ['title' => 'Present Simple', 'desc' => 'Daily routines and facts', 'slug' => 'present-simple'],
                    ['title' => 'Articles: A, An, The', 'desc' => 'Identifying objects', 'slug' => 'articles'],
                    ['title' => 'Personal Pronouns', 'desc' => 'I, You, He, She, It', 'slug' => 'personal-pronouns'],
                    ['title' => 'Verb To Be', 'desc' => 'Am, Is, Are', 'slug' => 'verb-to-be'],
                    ['title' => 'Plural Nouns', 'desc' => 'Regular and irregular plurals', 'slug' => 'plural-nouns'],
                    ['title' => 'Possessive Adjectives', 'desc' => 'My, your, his, her', 'slug' => 'possessive-adjectives'],
                    ['title' => 'Basic Question Words', 'desc' => 'Who, what, where, when', 'slug' => 'question-words'],
                    ['title' => 'Demonstratives', 'desc' => 'This, that, these, those', 'slug' => 'demonstratives'],
                ]
            ],
            'A2 - Elementary' => [
                'slug' => 'a2-elementary',
                'lessons' => [
                    ['title' => 'Past Simple', 'desc' => 'Completed past actions', 'slug' => 'past-simple'],
                    ['title' => 'Prepositions of Place', 'desc' => 'In, On, At, Under', 'slug' => 'prepositions-place'],
                    ['title' => 'Comparatives', 'desc' => 'Better, Faster, Stronger', 'slug' => 'comparatives'],
                    ['title' => 'Future with Will', 'desc' => 'Promises and predictions', 'slug' => 'future-will'],
                    ['title' => 'Present Continuous', 'desc' => 'Actions happening now', 'slug' => 'present-continuous'],
                    ['title' => 'Adverbs of Frequency', 'desc' => 'Always, sometimes, never', 'slug' => 'adverbs-frequency'],
                    ['title' => 'Can and Could', 'desc' => 'Ability and possibility', 'slug' => 'can-could'],
                ]
            ],
            'B1 - Intermediate' => [
                'slug' => 'b1-intermediate',
                'lessons' => [
                    ['title' => 'Present Perfect', 'desc' => 'Experiences and changes', 'slug' => 'present-perfect'],
                    ['title' => 'Conditionals: Zero & First', 'desc' => 'Real possibilities', 'slug' => 'conditionals-0-1'],
                    ['title' => 'Modal Verbs', 'desc' => 'Can, Must, Should', 'slug' => 'modal-verbs'],
                    ['title' => 'Passive Voice', 'desc' => 'Focus on action, not doer', 'slug' => 'passive-voice'],
                    ['title' => 'Relative Clauses', 'desc' => 'Who, which, that', 'slug' => 'relative-clauses'],
                    ['title' => 'Used To', 'desc' => 'Past habits and states', 'slug' => 'used-to'],
                    ['title' => 'Past Continuous', 'desc' => 'Actions in progress in past', 'slug' => 'past-continuous'],
                ]
            ],
            'B2 - Upper Intermediate' => [
                'slug' => 'b2-upper-intermediate',
                'lessons' => [
                    ['title' => 'Second Conditional', 'desc' => 'Hypothetical situations', 'slug' => 'second-conditional'],
                    ['title' => 'Third Conditional', 'desc' => 'Regrets about the past', 'slug' => 'third-conditional'],
                    ['title' => 'Reported Speech', 'desc' => 'Saying what others said', 'slug' => 'reported-speech'],
                    ['title' => 'Future Perfect', 'desc' => 'Completed by a future time', 'slug' => 'future-perfect'],
                    ['title' => 'Mixed Conditionals', 'desc' => 'Past cause, present result', 'slug' => 'mixed-conditionals'],
                ]
            ]
        ];

        foreach ($levels as $levelName => $data) {
            $level = GrammarLevel::create([
                'language_id' => $english->id,
                'name' => $levelName,
                'slug' => $data['slug']
            ]);

            foreach ($data['lessons'] as $index => $l) {
                $lesson = GrammarLesson::create([
                    'grammar_level_id' => $level->id,
                    'title' => $l['title'],
                    'slug' => $l['slug'],
                    'explanation' => "## {$l['title']}\n\nThis lesson covers **{$l['desc']}**. \n\n### Examples:\n- Example sentence 1 related to {$l['title']}.\n- Example sentence 2 related to {$l['title']}.\n\n### Explanation:\nHere is a detailed explanation of the grammar rule. It is important to practice this to master English.",
                    'order' => $index + 1
                ]);

                // Create Quiz
                $quiz = GrammarQuiz::create(['grammar_lesson_id' => $lesson->id, 'title' => "Quiz: {$l['title']}"]);
                
                // Add 3 Questions per quiz
                for ($i = 1; $i <= 3; $i++) {
                    $q = GrammarQuestion::create(['grammar_quiz_id' => $quiz->id, 'question' => "Question $i about {$l['title']}?", 'type' => 'multiple_choice']);
                    GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Correct Answer', 'is_correct' => true]);
                    GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Wrong Answer 1', 'is_correct' => false]);
                    GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Wrong Answer 2', 'is_correct' => false]);
                }
            }
        }

        // 4. Story Levels & Stories (Expanded)
        $storyLevels = [
            'A1 Stories' => [
                'slug' => 'a1-stories',
                'stories' => [
                    ['title' => 'The Lost Key', 'slug' => 'the-lost-key', 'excerpt' => 'A mystery about a missing key.', 'img' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'My First Pet', 'slug' => 'my-first-pet', 'excerpt' => 'Choosing a puppy.', 'img' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Sunny Morning', 'slug' => 'sunny-morning', 'excerpt' => 'A beautiful day in the park.', 'img' => 'https://images.unsplash.com/photo-1504198458649-3128b932f49e?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'The Blue Car', 'slug' => 'the-blue-car', 'excerpt' => 'Dad buys a new car.', 'img' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Lisa\'s Birthday', 'slug' => 'lisas-birthday', 'excerpt' => 'A surprise party for Lisa.', 'img' => 'https://images.unsplash.com/photo-1530103862676-de3c9a59af38?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'A2 Stories' => [
                'slug' => 'a2-stories',
                'stories' => [
                    ['title' => 'Coffee & Conversation', 'slug' => 'coffee-conversation', 'excerpt' => 'Two friends catching up.', 'img' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'The Weekend Trip', 'slug' => 'weekend-trip', 'excerpt' => 'A spontaneous adventure.', 'img' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Cooking Dinner', 'slug' => 'cooking-dinner', 'excerpt' => 'Trying a new recipe.', 'img' => 'https://images.unsplash.com/photo-1556910103-1c02745a30bf?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Lost at the Airport', 'slug' => 'lost-at-airport', 'excerpt' => 'Navigating a busy terminal.', 'img' => 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'The New Neighbor', 'slug' => 'the-new-neighbor', 'excerpt' => 'Making friends next door.', 'img' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'B1 Stories' => [
                'slug' => 'b1-stories',
                'stories' => [
                    ['title' => 'The Job Interview', 'slug' => 'job-interview', 'excerpt' => 'Preparing for a big day.', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Moving Abroad', 'slug' => 'moving-abroad', 'excerpt' => 'Starting a new life in Spain.', 'img' => 'https://images.unsplash.com/photo-1524850011238-e3d235c7d4c9?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'The Art Gallery', 'slug' => 'the-art-gallery', 'excerpt' => 'Discussing modern art.', 'img' => 'https://images.unsplash.com/photo-1518998053901-5348d3969105?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'A unexpected letter', 'slug' => 'unexpected-letter', 'excerpt' => 'News from an old friend.', 'img' => 'https://images.unsplash.com/photo-1579294800883-fa5278c2278e?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'B2 Stories' => [
                'slug' => 'b2-stories',
                'stories' => [
                    ['title' => 'The Entrepreneur', 'slug' => 'the-entrepreneur', 'excerpt' => 'Building a business from scratch.', 'img' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Cultural Shock', 'slug' => 'cultural-shock', 'excerpt' => 'Adapting to new traditions.', 'img' => 'https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'The Scientific Breakthrough', 'slug' => 'scientific-breakthrough', 'excerpt' => 'A discovery that changed everything.', 'img' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=400&q=80'],
                ]
            ]
        ];

        foreach ($storyLevels as $levelName => $data) {
            $sLevel = StoryLevel::create([
                'language_id' => $english->id,
                'name' => $levelName,
                'slug' => $data['slug']
            ]);

            foreach ($data['stories'] as $s) {
                Story::create([
                    'story_level_id' => $sLevel->id,
                    'title' => $s['title'],
                    'slug' => $s['slug'],
                    'content' => "This is a placeholder for the full story of **{$s['title']}**. \n\nIt was a dark and stormy night... (Content continues for reading practice).",
                    'excerpt' => $s['excerpt'],
                    'image_url' => $s['img'],
                    'audio_url' => null
                ]);
            }
        }
    }
}
