<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Run the Spanish seeder as part of the migration
        // This is safe to run multiple times because SpanishSeeder uses firstOrCreate
        $seeder = new \Database\Seeders\SpanishSeeder();
        $seeder->run();
    }

    public function down(): void
    {
        // Optionally remove Spanish data on rollback
        $spanish = \App\Models\Language::where('code', 'es')->first();
        if ($spanish) {
            // Grammar levels cascade deletes lessons, quizzes, options
            $spanish->grammarLevels()->each(fn($l) => $l->lessons()->each(fn($lesson) => $lesson->quiz()->delete()));
            $spanish->grammarLevels()->delete();

            // Story levels cascade deletes stories
            $spanish->storyLevels()->delete();

            $spanish->delete();
        }
    }
};
