<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find English language - try both code and slug
        $english = DB::table('languages')->where('code', 'en')->first();
        if (!$english) {
            $english = DB::table('languages')->where('slug', 'english')->first();
        }

        if ($english) {
            // Backfill any placement questions that still have NULL language_id
            DB::table('placement_questions')
                ->whereNull('language_id')
                ->update(['language_id' => $english->id]);

            // Backfill any user placement tests that still have NULL language_id
            DB::table('user_placement_tests')
                ->whereNull('language_id')
                ->update(['language_id' => $english->id]);
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};
