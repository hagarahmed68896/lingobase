<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('grammar_lessons', function (Blueprint $table) {
            $table->text('arabic_explanation')->nullable()->after('explanation');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->text('arabic_comment')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grammar_lessons', function (Blueprint $table) {
            $table->dropColumn('arabic_explanation');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('arabic_comment');
        });
    }
};
