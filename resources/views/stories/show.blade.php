@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .reader-hero {
        height: 60vh;
        min-height: 400px;
        position: relative;
        background-position: center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    .reader-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.8));
    }
    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 900px;
        padding: 2rem;
    }
    .story-meta {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .meta-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid rgba(255,255,255,0.3);
    }
    .story-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    .back-nav {
        position: absolute;
        top: 2rem;
        left: 2rem;
        z-index: 20;
    }
    .back-link {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        background: rgba(0,0,0,0.3);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        transition: background 0.2s;
    }
    .back-link:hover {
        background: rgba(0,0,0,0.5);
    }
    .reader-content {
        max-width: 800px;
        margin: -4rem auto 4rem;
        background: white;
        border-radius: 2px;
        padding: 4rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08); /* Minimal shadow */
        position: relative;
        z-index: 20;
    }
    .audio-player {
        background: #f8fafc;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    .play-icon-box {
        width: 48px;
        height: 48px;
        background: #009150;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }
    .text-content {
        font-family: 'Merriweather', 'Georgia', serif;
        font-size: 1.25rem;
        line-height: 2;
        color: #334155;
    }
    .text-content p {
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .story-title { font-size: 2.5rem; }
        .reader-content { padding: 2rem; margin-top: -2rem; width: 90%; }
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="reader-hero" style="background-image: url('{{ $story->image_url ?? 'https://source.unsplash.com/random/1920x1080?nature,book' }}');">
    <div class="back-nav">
        <a href="{{ route('stories.level', [$language->slug, $level->slug]) }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to {{ $level->name }}
        </a>
    </div>
    
    <div class="hero-content">
        <div class="story-meta">
            <span class="meta-badge">{{ $language->name }}</span>
            <span class="meta-badge">{{ $level->name }}</span>
        </div>
        <h1 class="story-title">{{ $story->title }}</h1>
    </div>
</div>

<article class="reader-content">
    @if($story->audio_url)
        <div class="audio-player">
            <div class="play-icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </div>
            <div style="flex-grow: 1;">
                <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">Listen to Story</h4>
                <audio controls style="width: 100%; height: 32px;">
                    <source src="{{ $story->audio_url }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    @endif

    <div class="text-content">
        {!! $story->content !!}
    </div>

    @if(app()->getLocale() == 'ar' && $story->arabic_comment)
        <div class="arabic-illustration" style="margin-top: 4rem; padding: 2rem; background: #f0fdf4; border-radius: 1rem; direction: rtl; text-align: right; border: 1px solid #dcfce7;">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: #15803d; margin-bottom: 1rem;">تعليق توضيحي</h3>
            <div style="font-size: 1.1rem; line-height: 1.8; color: #166534;">
                {!! nl2br(e($story->arabic_comment)) !!}
            </div>
        </div>
    @endif
    
    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #e2e8f0; text-align: center;">
        <h3 style="margin-bottom: 1rem;">Enjoyed this story?</h3>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <a href="{{ route('stories.level', [$language->slug, $level->slug]) }}" class="btn">Read Another Story</a>
            @auth
            <button onclick="toggleFavorite(this, {{ $story->id }}, 'story')" class="btn" style="border-color: #e2e8f0; display: flex; gap: 0.5rem;">
                 <svg width="20" height="20" viewBox="0 0 24 24" 
                    fill="{{ auth()->user()->favorites()->where('favoritable_id', $story->id)->where('favoritable_type', 'App\Models\Story')->exists() ? '#ef4444' : 'none' }}" 
                    stroke="{{ auth()->user()->favorites()->where('favoritable_id', $story->id)->where('favoritable_type', 'App\Models\Story')->exists() ? '#ef4444' : '#6b7280' }}" 
                    stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                Favorite
            </button>
            @endauth
        </div>
    </div>
</article>

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
            svg.setAttribute('stroke', '#6b7280');
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    }
}
</script>
@endsection
