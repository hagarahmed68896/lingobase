<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add language_id to placement_questions
        Schema::table('placement_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('placement_questions', 'language_id')) {
                // Add the column, nullable first to avoid breaking existing data
                $table->foreignId('language_id')->nullable()->constrained('languages')->nullOnDelete();
            }
        });

        // 2. Add language_id to user_placement_tests
        Schema::table('user_placement_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('user_placement_tests', 'language_id')) {
                // Add the column, nullable first
                $table->foreignId('language_id')->nullable()->constrained('languages')->nullOnDelete();
            }
        });
        
        // 3. Map existing records to English if English exists
        $english = \Illuminate\Support\Facades\DB::table('languages')->where('slug', 'en')->first();
        if ($english) {
            \Illuminate\Support\Facades\DB::table('placement_questions')
                ->whereNull('language_id')
                ->update(['language_id' => $english->id]);

            \Illuminate\Support\Facades\DB::table('user_placement_tests')
                ->whereNull('language_id')
                ->update(['language_id' => $english->id]);
        }
    }

    public function down(): void
    {
        Schema::table('user_placement_tests', function (Blueprint $table) {
            if (Schema::hasColumn('user_placement_tests', 'language_id')) {
                $table->dropForeign(['language_id']);
                $table->dropColumn('language_id');
            }
        });

        Schema::table('placement_questions', function (Blueprint $table) {
            if (Schema::hasColumn('placement_questions', 'language_id')) {
                $table->dropForeign(['language_id']);
                $table->dropColumn('language_id');
            }
        });
    }
};
