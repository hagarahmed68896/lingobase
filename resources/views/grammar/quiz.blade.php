@extends('layouts.app')

@section('styles')
<style>
    .quiz-page-header {
        background: var(--bg-body);
        padding: 3rem 2rem;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
    }
    .quiz-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    .question-card {
        background: var(--bg-card);
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
    }
    .question-head {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .question-number {
        width: 32px;
        height: 32px;
        background: #009150;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .question-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .option-item {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--text-main);
    }
    .option-item:hover {
        border-color: var(--text-muted);
        background: var(--bg-body);
    }
    .option-item.selected {
        border-color: #009150;
        background: #ecfdf5;
    }
    .option-item.correct {
        border-color: #10b981;
        background: #d1fae5;
        color: #065f46;
    }
    .option-item.incorrect {
        border-color: #ef4444;
        background: #fee2e2;
        color: #991b1b;
    }
    .option-radio {
        width: 20px;
        height: 20px;
        margin-right: 1rem;
        accent-color: #009150;
    }
    .submit-container {
        position: sticky;
        bottom: 2rem;
        background: var(--bg-card);
        padding: 1.5rem;
        border-radius: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 4rem;
    }
    .btn-submit {
        background: #009150;
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 0.75rem;
        font-weight: 800;
        border: none;
        cursor: pointer;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        background: #007a43;
    }
    .result-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.8);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .result-modal {
        background: white;
        padding: 3rem;
        border-radius: 2rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }
    .progress-bar {
        height: 8px;
        background: var(--border-color);
        border-radius: 4px;
        width: 200px;
        margin: 1rem auto;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: var(--primary);
        width: 0%;
        transition: width 0.3s;
    }
</style>
@endsection

@section('content')
<div class="quiz-page-header">
    <a href="{{ route('grammar.lesson', [$language->slug, $level->slug, $lesson->slug]) }}" style="color: #6b7280; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1rem; font-weight: 600;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Lesson
    </a>
    <h1 style="font-size: 2.5rem; font-weight: 900; color: var(--text-main); margin: 0;">{{ $lesson->title }} - Quiz</h1>
    <p style="color: var(--text-muted); margin: 0.5rem 0 0 0;">Show us what you've learned!</p>
</div>

<div class="quiz-container">
    <div id="quiz-flow">
        @foreach($lesson->quiz->questions as $question)
        <div class="question-card" data-id="{{ $question->id }}">
            <div class="question-head">
                <div class="question-number">{{ $loop->iteration }}</div>
                <h2 class="question-text">{{ $question->question }}</h2>
            </div>
            
            <div class="options-list">
                @foreach($question->options as $option)
                <label class="option-item">
                    <input type="radio" name="q_{{ $question->id }}" value="{{ $option->id }}" data-correct="{{ $option->is_correct ? 'true' : 'false' }}" class="option-radio">
                    <span style="font-size: 1.05rem; font-weight: 500;">{{ $option->option_text }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="submit-container">
        <div style="display: flex; flex-direction: column;">
            <span id="answered-count" style="font-weight: 700; color: #111827;">0 / {{ $lesson->quiz->questions->count() }} answered</span>
            <div class="progress-bar">
                <div id="progress-fill" class="progress-fill"></div>
            </div>
        </div>
        <button id="final-submit" class="btn-submit">Finish Quiz</button>
    </div>
</div>

<div id="result-overlay" class="result-overlay">
    <div class="result-modal">
        <div id="result-icon" style="margin-bottom: 1.5rem;"></div>
        <h2 id="result-title" style="font-size: 2rem; margin: 0 0 1rem 0;">Excellent!</h2>
        <p id="result-text" style="color: #6b7280; font-size: 1.1rem; margin-bottom: 2rem;">You scored 100% on this quiz.</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('grammar.lesson', [$language->slug, $level->slug, $lesson->slug]) }}" class="btn" style="background: #f3f4f6; color: #374151; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.75rem; font-weight: 700;">Review Lesson</a>
            <a href="{{ route('grammar.index') }}" class="btn" style="background: #009150; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.75rem; font-weight: 700;">Next Challenge</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question-card');
    const progressFill = document.getElementById('progress-fill');
    const answeredText = document.getElementById('answered-count');
    const finalSubmit = document.getElementById('final-submit');
    const total = questions.length;

    // Option selection
    document.querySelectorAll('.option-item').forEach(item => {
        item.addEventListener('click', function() {
            const card = this.closest('.question-card');
            card.querySelectorAll('.option-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input').checked = true;
            
            updateProgress();
        });
    });

    function updateProgress() {
        const answered = document.querySelectorAll('input:checked').length;
        const percent = (answered / total) * 100;
        progressFill.style.width = percent + '%';
        answeredText.innerText = `${answered} / ${total} answered`;
    }

    finalSubmit.addEventListener('click', function() {
        const answered = document.querySelectorAll('input:checked');
        if (answered.length < total) {
            alert('Please answer all questions before submitting.');
            return;
        }

        let correct = 0;
        questions.forEach(q => {
            const selected = q.querySelector('input:checked');
            const isCorrect = selected.dataset.correct === 'true';
            
            q.querySelectorAll('.option-item').forEach(opt => {
                const radio = opt.querySelector('input');
                if (radio.dataset.correct === 'true') opt.classList.add('correct');
                if (radio === selected && !isCorrect) opt.classList.add('incorrect');
            });

            if (isCorrect) correct++;
        });

        const score = Math.round((correct / total) * 100);
        showResult(score, correct, total);
    });

    function showResult(score, correct, total) {
        const overlay = document.getElementById('result-overlay');
        const title = document.getElementById('result-title');
        const text = document.getElementById('result-text');
        const icon = document.getElementById('result-icon');

        overlay.style.display = 'flex';
        text.innerText = `You correctly answered ${correct} out of ${total} questions (${score}%).`;

        if (score >= 80) {
            title.innerText = "Fantastic Work!";
            icon.innerHTML = '<svg width="80" height="80" viewBox="0 0 24 24" fill="#009150"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } else if (score >= 50) {
            title.innerText = "Good Effort!";
            icon.innerHTML = '<svg width="80" height="80" viewBox="0 0 24 24" fill="#fbbf24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } else {
            title.innerText = "Keep Practicing!";
            icon.innerHTML = '<svg width="80" height="80" viewBox="0 0 24 24" fill="#ef4444"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        }
    }
});
</script>
@endsection
