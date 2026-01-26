@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .hero-section {
        background: linear-gradient(135deg, #006837 0%, #008f4d 50%, #005a2e 100%);
        padding: 3.5rem 2rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .hero-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.5;
    }
    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        margin: 0 auto;
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        letter-spacing: -0.05rem;
    }
    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }
    .search-container {
        background: white;
        padding: 0.5rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .search-input {
        flex: 1;
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        outline: none;
        border-radius: 999px;
    }
    .search-btn {
        background: #009150;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 999px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }
    .search-btn:hover {
        background: #007a43;
    }
    .content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2.5rem 2rem;
    }
    .level-section {
        margin-bottom: 4rem;
    }
    .level-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
        padding-left: 1.5rem;
    }
    .level-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: #009150;
        border-radius: 5px;
    }
    .level-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    .see-more-link {
        background: linear-gradient(135deg, #009150 0%, #007a43 100%);
        color: white;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }
    .see-more-link:hover {
        background: linear-gradient(135deg, #007a43 0%, #006837 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 145, 80, 0.3);
    }
    .lessons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }
    .lesson-card {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }
    .lesson-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #dcfce7;
    }
    .card-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        color: #111827;
        line-height: 1.3;
        padding-right: 2rem;
    }
    .card-excerpt {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    .card-footer {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }
    .lesson-meta {
        font-size: 0.875rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .start-btn {
        color: #009150;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .fav-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 5;
        padding: 0;
        transition: transform 0.2s;
    }
    .fav-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="hero-section">
    <div class="hero-bg-pattern"></div>
    <div class="hero-content">
        <h1 class="hero-title">{{ __('messages.master_grammar') }}</h1>
        <p class="hero-subtitle">{{ __('messages.grammar_subtitle') }}</p>
        
        <form action="{{ route('grammar.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_topics') }}" class="search-input">
            <button type="submit" class="search-btn">{{ __('messages.search') }}</button>
        </form>
    </div>
</div>

<div class="content-wrapper">
    @foreach($languages as $language)
        @foreach($language->grammarLevels as $level)
            @if($level->lessons->count() > 0)
            <div class="level-section">
                <div class="level-header">
                    <h2 class="level-title">{{ $level->name }}</h2>
                    <a href="{{ route('grammar.level', [$language->slug, $level->slug]) }}" class="see-more-link">
                        {{ __('messages.view_all_lessons') }} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
                
                <div class="lessons-grid">
                    @foreach($level->lessons->take(3) as $lesson)
                    <div class="lesson-card">
                        @auth
                        <button onclick="toggleFavorite(this, {{ $lesson->id }}, 'grammar_lesson'); event.preventDefault();" class="fav-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" 
                                fill="{{ auth()->user()->favorites()->where('favoritable_id', $lesson->id)->where('favoritable_type', 'App\Models\GrammarLesson')->exists() ? '#ef4444' : 'none' }}" 
                                stroke="{{ auth()->user()->favorites()->where('favoritable_id', $lesson->id)->where('favoritable_type', 'App\Models\GrammarLesson')->exists() ? '#ef4444' : '#d1d5db' }}" 
                                stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        @endauth

                        <a href="{{ route('grammar.lesson', [$language->slug, $level->slug, $lesson->slug]) }}" style="text-decoration: none; display: flex; flex-direction: column; flex-grow: 1;">
                            <div class="card-body">
                                <h3 class="card-title">{{ $lesson->title }}</h3>
                                <div class="card-excerpt">{{ Str::limit(strip_tags($lesson->explanation), 100) }}</div>
                                <div class="card-footer">
                                    <div class="lesson-meta">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        {{ __('messages.lesson') }} {{ $loop->iteration }}
                                    </div>
                                    <span class="start-btn">{{ __('messages.start_learning') }} &rarr;</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @endforeach
</div>

<script>
async function toggleFavorite(btn, id, type) {
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
        const svg = btn.querySelector('svg');
        
        if (data.status === 'added') {
            svg.setAttribute('fill', '#ef4444');
            svg.setAttribute('stroke', '#ef4444');
        } else {
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', '#d1d5db');
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    }
}
</script>
@endsection
