@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .lesson-header {
        background: var(--bg-body);
        padding: 4rem 2rem;
        border-bottom: 1px solid var(--border-color);
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
        color: var(--text-main);
        margin: 0 0 0.5rem 0;
    }
    .back-link {
        color: var(--text-muted);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .back-link:hover {
        color: var(--primary);
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
        background: var(--bg-card);
        border-radius: 1.5rem;
        padding: 3rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }
    .lesson-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: var(--text-main);
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
        border: 2px solid var(--border-color);
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
        color: var(--text-main);
    }
    .option-label:hover {
        border-color: var(--text-muted);
        background: var(--bg-body);
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
    .progress-fill {
        height: 100%;
        background: #009150;
        width: 0%;
        transition: width 0.3s;
    }
    .quiz-start-btn:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
        background: #fdfdfd;
    }
    .quiz-start-btn:active {
        transform: translateY(-2px) scale(0.98);
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
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.8rem; font-weight: 600;">{{ $language->name }}</span>
                <span style="background: #fae8ff; color: #a21caf; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.8rem; font-weight: 600;">{{ $level->name }}</span>
            </div>
        </div>
        <div>
            <button onclick="toggleFavorite(this, {{ $lesson->id }}, 'grammar_lesson')" 
                    class="btn" 
                    style="background: white; border: 1px solid #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 700; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                @php
                    $isFavorited = auth()->check() && auth()->user()->favorites()->where('favoritable_id', $lesson->id)->where('favoritable_type', 'App\Models\GrammarLesson')->exists();
                @endphp
                <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $isFavorited ? '#ef4444' : 'none' }}" stroke="{{ $isFavorited ? '#ef4444' : 'currentColor' }}" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span>{{ $isFavorited ? 'Saved to Favorites' : 'Add to Favorites' }}</span>
            </button>
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
        <div class="quiz-card" style="border: 1px solid #e5e7eb; background: white; padding: 2.5rem 2rem; text-align: center; position: relative; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border-radius: 1.5rem;">
            
            <div style="width: 72px; height: 72px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid #d1fae5;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#009150" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            
            <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; color: #111827;">Ready to Quiz?</h3>
            <p style="color: #6b7280; margin-bottom: 2.5rem; font-size: 1rem; line-height: 1.5;">Master "{{ $lesson->title }}" and track your progress!</p>
            
            <a href="{{ route('grammar.quiz', [$language->slug, $level->slug, $lesson->slug]) }}" 
               onclick="return checkAuth(event)"
               class="btn quiz-start-btn" 
               style="background: #009150; color: white; width: 100%; justify-content: center; padding: 1rem 1.5rem; border-radius: 1rem; font-size: 1.1rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 145, 80, 0.3); transition: all 0.2s; border: none;">
                <span>Start Lesson Quiz</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            
            @guest
                <p style="margin-top: 1.25rem; font-size: 0.85rem; color: #9ca3af; font-weight: 500;">Please log in to save your results</p>
            @endguest
        </div>
        
        <div style="margin-top: 2rem; background: white; border: 1px solid #e5e7eb; border-radius: 1.5rem; padding: 1.5rem;">
            <h4 style="font-weight: 700; margin: 0 0 1rem 0;">Key Takeaways</h4>
            <ul style="padding-left: 1.25rem; margin: 0; color: #6b7280; font-size: 0.9rem; line-height: 1.6;">
                <li>Understand the core rules</li>
                <li>Practice with real examples</li>
                <li>Complete the interactive quiz</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function checkAuth(e) {
    @guest
        e.preventDefault();
        window.location.href = "{{ route('login') }}";
        return false;
    @endguest
    return true;
}

async function toggleFavorite(btn, id, type) {
    @guest
        if (confirm('Please log in to add favorites.')) {
            window.location.href = "{{ route('login') }}";
        }
        return;
    @endguest

    try {
        const response = await fetch("{{ route('favorites.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id, type })
        });
        
        const data = await response.json();
        const icon = btn.querySelector('svg');
        const span = btn.querySelector('span');
        
        if (data.status === 'added') {
            icon.setAttribute('fill', '#ef4444');
            icon.setAttribute('stroke', '#ef4444');
            span.innerText = 'Saved to Favorites';
        } else {
            icon.setAttribute('fill', 'none');
            icon.setAttribute('stroke', 'currentColor');
            span.innerText = 'Add to Favorites';
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    }
}
</script>
@endsection
