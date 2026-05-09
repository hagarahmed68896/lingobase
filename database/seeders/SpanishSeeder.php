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

class SpanishSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Spanish Language
        $spanish = Language::firstOrCreate(
            ['code' => 'es'],
            ['name' => 'Spanish', 'slug' => 'spanish']
        );

        // 2. Grammar Levels & Lessons
        $levels = [
            'A1 - Beginner' => [
                'slug' => 'a1-beginner',
                'lessons' => [
                    ['title' => 'Ser vs. Estar', 'desc' => 'Two ways to say "to be" in Spanish', 'slug' => 'ser-vs-estar'],
                    ['title' => 'Nouns & Gender', 'desc' => 'Masculine and feminine nouns', 'slug' => 'nouns-gender'],
                    ['title' => 'Present Tense (Presente)', 'desc' => 'Regular -ar, -er, -ir verbs', 'slug' => 'presente'],
                    ['title' => 'Definite & Indefinite Articles', 'desc' => 'El, la, los, las, un, una', 'slug' => 'articles'],
                    ['title' => 'Personal Pronouns', 'desc' => 'Yo, tú, él, ella, nosotros...', 'slug' => 'personal-pronouns'],
                    ['title' => 'Numbers & Days', 'desc' => 'Counting and days of the week', 'slug' => 'numbers-days'],
                    ['title' => 'Greetings & Introductions', 'desc' => 'Hola, ¿cómo te llamas?', 'slug' => 'greetings'],
                    ['title' => 'Question Words', 'desc' => '¿Qué?, ¿Quién?, ¿Dónde?, ¿Cuándo?', 'slug' => 'question-words'],
                ]
            ],
            'A2 - Elementary' => [
                'slug' => 'a2-elementary',
                'lessons' => [
                    ['title' => 'Past Tense (Pretérito Indefinido)', 'desc' => 'Completed past actions', 'slug' => 'preterito-indefinido'],
                    ['title' => 'Imperfect Tense (Pretérito Imperfecto)', 'desc' => 'Ongoing past states and habits', 'slug' => 'preterito-imperfecto'],
                    ['title' => 'Reflexive Verbs', 'desc' => 'Levantarse, llamarse, bañarse...', 'slug' => 'reflexive-verbs'],
                    ['title' => 'Prepositions', 'desc' => 'A, de, en, con, por, para', 'slug' => 'prepositions'],
                    ['title' => 'Comparatives & Superlatives', 'desc' => 'Más, menos, tan... como', 'slug' => 'comparatives'],
                    ['title' => 'Direct & Indirect Object Pronouns', 'desc' => 'Lo, la, le, me, te...', 'slug' => 'object-pronouns'],
                    ['title' => 'Future with IR + a', 'desc' => 'Voy a + infinitive', 'slug' => 'future-ir-a'],
                ]
            ],
            'B1 - Intermediate' => [
                'slug' => 'b1-intermediate',
                'lessons' => [
                    ['title' => 'Subjunctive Mood (Present)', 'desc' => 'Wishes, doubts and emotions', 'slug' => 'subjunctive-present'],
                    ['title' => 'Future Simple (Futuro Simple)', 'desc' => 'Predictions and future plans', 'slug' => 'futuro-simple'],
                    ['title' => 'Conditional (Condicional Simple)', 'desc' => 'Would + verb in Spanish', 'slug' => 'condicional-simple'],
                    ['title' => 'Present Perfect (Pretérito Perfecto)', 'desc' => 'He, has, ha + participio', 'slug' => 'preterito-perfecto'],
                    ['title' => 'Relative Clauses', 'desc' => 'Que, quien, donde, lo que', 'slug' => 'relative-clauses'],
                    ['title' => 'Por vs. Para', 'desc' => 'Two translations of "for"', 'slug' => 'por-vs-para'],
                    ['title' => 'Ser vs. Estar (Advanced)', 'desc' => 'Deeper nuances and exceptions', 'slug' => 'ser-estar-advanced'],
                ]
            ],
            'B2 - Upper Intermediate' => [
                'slug' => 'b2-upper-intermediate',
                'lessons' => [
                    ['title' => 'Past Subjunctive (Subjuntivo Pasado)', 'desc' => 'Hypothetical past situations', 'slug' => 'subjuntivo-pasado'],
                    ['title' => 'Conditional Perfect', 'desc' => 'Habría + participio', 'slug' => 'condicional-perfecto'],
                    ['title' => 'Passive Voice (Voz Pasiva)', 'desc' => 'Ser + participio constructions', 'slug' => 'voz-pasiva'],
                    ['title' => 'Reported Speech (Estilo Indirecto)', 'desc' => 'Saying what others said', 'slug' => 'estilo-indirecto'],
                    ['title' => 'Advanced Subjunctive', 'desc' => 'Complex subordinate clauses', 'slug' => 'subjuntivo-avanzado'],
                ]
            ],
        ];

        foreach ($levels as $levelName => $data) {
            // Skip if level already exists for this language
            $level = GrammarLevel::firstOrCreate(
                ['slug' => $data['slug'], 'language_id' => $spanish->id],
                ['name' => $levelName]
            );

            foreach ($data['lessons'] as $index => $l) {
                $lesson = GrammarLesson::firstOrCreate(
                    ['slug' => $l['slug'], 'grammar_level_id' => $level->id],
                    [
                        'title' => $l['title'],
                        'explanation' => "## {$l['title']}\n\n**{$l['desc']}**\n\n### Explicación:\nEsta lección cubre uno de los temas fundamentales del español. Es esencial practicar y memorizar estas reglas para dominar el idioma.\n\n### Ejemplos:\n- **Ejemplo 1**: Una oración de práctica relacionada con \"{$l['title']}\".\n- **Ejemplo 2**: Otra oración para ilustrar el uso correcto.\n- **Ejemplo 3**: Un ejemplo adicional con contexto real.\n\n### Práctica:\nIntenta crear tus propias oraciones usando las reglas aprendidas en esta lección.",
                        'order' => $index + 1,
                    ]
                );

                // Create Quiz for each lesson
                $quiz = GrammarQuiz::firstOrCreate(
                    ['grammar_lesson_id' => $lesson->id],
                    ['title' => "Quiz: {$l['title']}"]
                );

                // Only add questions if quiz is newly created (no existing questions)
                if ($quiz->questions()->count() === 0) {
                    for ($i = 1; $i <= 3; $i++) {
                        $q = GrammarQuestion::create([
                            'grammar_quiz_id' => $quiz->id,
                            'question' => "Question $i about {$l['title']}?",
                            'type' => 'multiple_choice',
                        ]);
                        GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Correct Answer', 'is_correct' => true]);
                        GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Wrong Answer 1', 'is_correct' => false]);
                        GrammarOption::create(['grammar_question_id' => $q->id, 'option_text' => 'Wrong Answer 2', 'is_correct' => false]);
                    }
                }
            }
        }

        // 3. Story Levels & Stories
        $storyLevels = [
            'A1 Stories' => [
                'slug' => 'a1-stories',
                'stories' => [
                    ['title' => 'El Perro Perdido', 'slug' => 'el-perro-perdido', 'excerpt' => 'Un niño busca a su perro en el parque.', 'img' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Mi Familia', 'slug' => 'mi-familia', 'excerpt' => 'Presentando a los miembros de la familia.', 'img' => 'https://images.unsplash.com/photo-1511895426328-dc8714191011?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'El Mercado', 'slug' => 'el-mercado', 'excerpt' => 'Comprando frutas y verduras frescas.', 'img' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Una Mañana Tranquila', 'slug' => 'una-manana-tranquila', 'excerpt' => 'El desayuno en casa con la familia.', 'img' => 'https://images.unsplash.com/photo-1504198458649-3128b932f49e?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'La Escuela Nueva', 'slug' => 'la-escuela-nueva', 'excerpt' => 'El primer día en una escuela nueva.', 'img' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'A2 Stories' => [
                'slug' => 'a2-stories',
                'stories' => [
                    ['title' => 'El Fin de Semana', 'slug' => 'el-fin-de-semana', 'excerpt' => 'Planes para el fin de semana con amigos.', 'img' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'El Restaurante', 'slug' => 'el-restaurante', 'excerpt' => 'Pidiendo comida en un restaurante español.', 'img' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Vacaciones en la Playa', 'slug' => 'vacaciones-playa', 'excerpt' => 'Una semana perfecta en la costa.', 'img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'El Nuevo Trabajo', 'slug' => 'el-nuevo-trabajo', 'excerpt' => 'Comenzando un nuevo empleo en la ciudad.', 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'La Fiesta de Cumpleaños', 'slug' => 'la-fiesta-cumpleanos', 'excerpt' => 'Celebrando con amigos y familia.', 'img' => 'https://images.unsplash.com/photo-1530103862676-de3c9a59af38?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'B1 Stories' => [
                'slug' => 'b1-stories',
                'stories' => [
                    ['title' => 'El Viaje a Madrid', 'slug' => 'el-viaje-madrid', 'excerpt' => 'Explorando la capital de España.', 'img' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'La Entrevista de Trabajo', 'slug' => 'entrevista-trabajo', 'excerpt' => 'Preparándose para una entrevista importante.', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'El Apartamento Nuevo', 'slug' => 'apartamento-nuevo', 'excerpt' => 'Mudándose a una nueva ciudad.', 'img' => 'https://images.unsplash.com/photo-1524850011238-e3d235c7d4c9?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'La Receta Secreta', 'slug' => 'la-receta-secreta', 'excerpt' => 'El misterio de una antigua receta familiar.', 'img' => 'https://images.unsplash.com/photo-1556910103-1c02745a30bf?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
            'B2 Stories' => [
                'slug' => 'b2-stories',
                'stories' => [
                    ['title' => 'El Negocio Familiar', 'slug' => 'negocio-familiar', 'excerpt' => 'Salvando la empresa familiar de la crisis.', 'img' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'Choque Cultural', 'slug' => 'choque-cultural', 'excerpt' => 'Adaptándose a una nueva cultura.', 'img' => 'https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&w=400&q=80'],
                    ['title' => 'La Decisión', 'slug' => 'la-decision', 'excerpt' => 'Elegir entre el corazón y la razón.', 'img' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=400&q=80'],
                ]
            ],
        ];

        foreach ($storyLevels as $levelName => $data) {
            $sLevel = StoryLevel::firstOrCreate(
                ['slug' => $data['slug'], 'language_id' => $spanish->id],
                ['name' => $levelName]
            );

            foreach ($data['stories'] as $s) {
                Story::firstOrCreate(
                    ['slug' => $s['slug'], 'story_level_id' => $sLevel->id],
                    [
                        'title' => $s['title'],
                        'content' => "# {$s['title']}\n\nEsta es una historia de práctica para aprender español. {$s['excerpt']}\n\n---\n\nEra una mañana tranquila cuando todo comenzó. Los personajes de esta historia te ayudarán a practicar el vocabulario y las estructuras gramaticales aprendidas en las lecciones.\n\n**Continúa leyendo para mejorar tu español...**\n\nLa historia se desarrolla de manera interesante, presentando situaciones cotidianas que te ayudarán a comprender mejor el idioma en contextos reales.",
                        'excerpt' => $s['excerpt'],
                        'image_url' => $s['img'],
                        'audio_url' => null,
                    ]
                );
            }
        }
    }
}
