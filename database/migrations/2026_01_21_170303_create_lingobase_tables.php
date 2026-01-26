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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10);
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('grammar_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('grammar_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_level_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('explanation');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('grammar_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_lesson_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('grammar_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->string('type')->default('multiple_choice');
            $table->timestamps();
        });

        Schema::create('grammar_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_question_id')->constrained()->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('story_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_level_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('image_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });

        Schema::create('user_grammar_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('grammar_lesson_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_story_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('story_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_story_progress');
        Schema::dropIfExists('user_grammar_progress');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('story_levels');
        Schema::dropIfExists('grammar_options');
        Schema::dropIfExists('grammar_questions');
        Schema::dropIfExists('grammar_quizzes');
        Schema::dropIfExists('grammar_lessons');
        Schema::dropIfExists('grammar_levels');
        Schema::dropIfExists('languages');
    }
};
