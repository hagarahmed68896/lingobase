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
        Schema::create('placement_questions', function (Blueprint $table) {
            $table->id();
            $table->string('level'); // A1, A2, B1, B2, C1
            $table->string('section')->default('grammar'); // grammar, vocabulary, reading, listening
            $table->text('question_text');
            $table->decimal('points', 3, 1); // 0.1 to 0.4
            
            // For Grammar
            $table->string('skill')->nullable();
            $table->string('sub_skill')->nullable();
            
            // For Vocabulary
            $table->string('vocab_category')->nullable(); // Normal, Extra
            
            $table->string('media_url')->nullable();
            $table->string('question_type')->default('multiple_choice');
            $table->text('distractor_logic')->nullable();
            
            $table->timestamps();
            
            // Index for faster random selection
            $table->index(['level', 'section']);
        });

        Schema::create('placement_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_question_id')->constrained()->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('user_placement_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_score', 5, 2)->default(0);
            $table->decimal('grammar_score', 5, 2)->default(0);
            $table->decimal('vocabulary_score', 5, 2)->default(0);
            $table->string('detected_level')->nullable();
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->json('question_sequence')->nullable(); // Stores the unique sequence of Question IDs
            $table->integer('current_question_index')->default(0);
            $table->timestamps();
        });

        Schema::create('user_placement_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_placement_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('placement_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('selected_option_id')->nullable()->constrained('placement_options')->nullOnDelete();
            $table->boolean('is_correct')->default(false);
            $table->decimal('points_earned', 3, 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_placement_answers');
        Schema::dropIfExists('user_placement_tests');
        Schema::dropIfExists('placement_options');
        Schema::dropIfExists('placement_questions');
    }
};
