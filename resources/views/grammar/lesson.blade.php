@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .lesson-header {
        background: #f9fafb;
        padding: 4rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .header-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lesson-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin: 0 0 0.5rem 0;
    }
    .back-link {
        color: #6b7280;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .back-link:hover {
        color: #009150;
    }
    .lesson-layout {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }
    .content-card {
        background: white;
        border-radius: 1.5rem;
        padding: 3rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .lesson-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #374151;
    }
    .quiz-sidebar {
        position: sticky;
        top: 6rem;
    }
    .quiz-card {
        background: white;
        border-radius: 1.5rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .quiz-header {
        background: #009150;
        padding: 1.5rem;
        color: white;
    }
    .quiz-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
    }
    .quiz-body {
        padding: 1.5rem;
    }
    .question-item {
        margin-bottom: 2rem;
    }
    .question-text {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #111827;
    }
    .option-label {
        display: block;
        padding: 0.75rem 1rem;
        border: 2px solid #f3f4f6;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .option-label:hover {
        border-color: #d1d5db;
        background: #f9fafb;
    }
    .option-label.selected {
        border-color: #009150;
        background: #ecfdf5;
    }
    .option-label.correct {
        border-color: #10b981;
        background: #d1fae5;
        color: #065f46;
    }
    .option-label.incorrect {
        border-color: #ef4444;
        background: #fee2e2;
        color: #991b1b;
    }
    .check-btn {
        width: 100%;
        background: #009150;
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .check-btn:hover {
        background: #007a43;
    }
    .result-box {
        margin-top: 1.5rem;
        padding: 1rem;
        border-radius: 0.75rem;
        text-align: center;
        font-weight: 700;
        display: none;
    }
    @media (max-width: 1024px) {
        .lesson-layout { grid-template-columns: 1fr; }
        .quiz-sidebar { position: static; }
    }
</style>
@endsection

@section('content')
<div class="lesson-header">
    <div class="header-content">
        <div>
            <a href="{{ route('grammar.level', [$language->slug, $level->slug]) }}" class="back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to {{ $level->name }}
            </a>
            <h1 class="lesson-title">{{ $lesson->title }}</h1>
            <div style="display: flex; gap: 0.5rem;">
                <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.8rem; font-weight: 600;">{{ $language->name }}</span>
                <span style="background: #fae8ff; color: #a21caf; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.8rem; font-weight: 600;">{{ $level->name }}</span>
            </div>
        </div>
    </div>
</div>

<div class="lesson-layout">
    <div class="content-card">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #f3f4f6;">Lesson Content</h2>
        <div class="lesson-text">
            {!! nl2br(e($lesson->explanation)) !!}
        </div>

        @if(app()->getLocale() == 'ar' && $lesson->arabic_explanation)
            <div class="arabic-illustration" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px dashed #e5e7eb; direction: rtl; text-align: right;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 1rem;">توضيح بالعربية</h3>
                <div style="font-size: 1.1rem; line-height: 1.8; color: #4b5563;">
                    {!! nl2br(e($lesson->arabic_explanation)) !!}
                </div>
            </div>
        @endif
    </div>

    <div class="quiz-sidebar">
        <div class="quiz-card">
            <div class="quiz-header">
                <h3 class="quiz-title">Quiz Yourself</h3>
                <p style="margin: 0.25rem 0 0 0; opacity: 0.9; font-size: 0.9rem;">Test your knowledge!</p>
            </div>
            <div class="quiz-body">
                @if($lesson->quiz && $lesson->quiz->questions->count() > 0)
                    <div id="quiz-form">
                        @foreach($lesson->quiz->questions as $question)
                        <div class="question-item" data-id="{{ $question->id }}">
                            <p class="question-text">{{ $loop->iteration }}. {{ $question->question }}</p>
                            @foreach($question->options as $option)
                            <label class="option-label">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}" data-correct="{{ $option->is_correct ? 'true' : 'false' }}" style="margin-right: 0.5rem;">
                                {{ $option->option_text }}
                            </label>
                            @endforeach
                        </div>
                        @endforeach
                        
                        <button id="check-btn" class="check-btn">Check Answers</button>
                        <div id="result-box" class="result-box"></div>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem 0; color: #6b7280;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <p>No quiz available for this lesson yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Styling radio buttons
    const options = document.querySelectorAll('.option-label');
    options.forEach(opt => {
        opt.addEventListener('click', function() {
            // Find all options in this question and remove selected
            const questionItem = this.closest('.question-item');
            questionItem.querySelectorAll('.option-label').forEach(o => o.classList.remove('selected'));
            // Add selected to clicked
            this.classList.add('selected');
            // Check the radio input
            this.querySelector('input').checked = true;
        });
    });

    const checkBtn = document.getElementById('check-btn');
    if (checkBtn) {
        checkBtn.addEventListener('click', function() {
            const questions = document.querySelectorAll('.question-item');
            let correctCount = 0;
            let answeredCount = 0;
            
            questions.forEach(q => {
                const selectedInput = q.querySelector('input:checked');
                
                // Reset styles
                q.querySelectorAll('.option-label').forEach(l => {
                    l.classList.remove('correct', 'incorrect');
                });

                if (selectedInput) {
                    answeredCount++;
                    const isCorrect = selectedInput.dataset.correct === 'true';
                    const selectedLabel = selectedInput.closest('.option-label');
                    
                    if (isCorrect) {
                        selectedLabel.classList.add('correct');
                        correctCount++;
                    } else {
                        selectedLabel.classList.add('incorrect');
                        // Highlight correct answer
                        const correctInput = q.querySelector('input[data-correct="true"]');
                        if (correctInput) {
                            correctInput.closest('.option-label').classList.add('correct');
                        }
                    }
                }
            });

            const resultBox = document.getElementById('result-box');
            resultBox.style.display = 'block';
            
            if (answeredCount < questions.length) {
                resultBox.style.background = '#fef3c7';
                resultBox.style.color = '#92400e';
                resultBox.innerHTML = `Please answer all ${questions.length} questions.`;
            } else {
                const percentage = Math.round((correctCount / questions.length) * 100);
                if (percentage >= 70) {
                    resultBox.style.background = '#d1fae5';
                    resultBox.style.color = '#065f46';
                    resultBox.innerHTML = `Great job! You scored ${percentage}% (${correctCount}/${questions.length})`;
                } else {
                    resultBox.style.background = '#fee2e2';
                    resultBox.style.color = '#991b1b';
                    resultBox.innerHTML = `Keep practicing! You scored ${percentage}% (${correctCount}/${questions.length})`;
                }
            }
        });
    }
});
</script>
@endsection
