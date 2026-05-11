@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .header-section {
        background: #004d2a;
        padding: 4rem 2rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom-left-radius: 2rem;
        border-bottom-right-radius: 2rem;
    }
    .header-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 50%, rgba(52, 211, 153, 0.05) 0%, transparent 70%);
        z-index: 1;
    }
    .breadcrumb {
        position: relative;
        z-index: 10;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
        font-weight: 500;
    }
    .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .breadcrumb a:hover {
        opacity: 0.8;
    }
    .page-title {
        position: relative;
        z-index: 10;
        font-size: 2.75rem;
        font-weight: 800;
        margin-bottom: 0;
        letter-spacing: -0.02em;
    }
    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 1.5rem;
    }
    .stories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
    }
    .story-card {
        background: var(--bg-card);
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .story-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }
    .story-img-container {
        height: 220px;
        overflow: hidden;
    }
    .story-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .story-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        color: var(--text-main);
    }
    .story-excerpt {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .read-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        background: var(--primary);
        color: white;
        border-radius: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .story-card:hover .read-btn {
        background: var(--primary-dark);
    }

    /* Small dynamic badge */
    .dynamic-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(52, 211, 153, 0.15);
        color: #34d399;
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(52, 211, 153, 0.2);
        animation: pulse-badge 2s infinite;
    }
    @keyframes pulse-badge {
        0% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(52, 211, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
    }
</style>
@endsection

@section('content')
<div class="header-section">
    <div class="header-bg-pattern"></div>
    <div class="header-content">
        <div class="dynamic-badge">
            <span style="display: block; width: 8px; height: 8px; background: #34d399; border-radius: 50%;"></span>
            {{ $language->name }} Stories
        </div>
        <nav class="breadcrumb">
            <a href="{{ route('stories.index') }}">Stories</a>
            <span>/</span>
            <span>{{ $language->name }}</span>
            <span>/</span>
            <span style="color: white;">{{ $level->name }}</span>
        </nav>
        <h1 class="page-title">{{ $level->name }} Stories</h1>
    </div>
</div>

<div class="content-wrapper">
    <div class="stories-grid">
        @foreach($level->stories as $story)
        <a href="{{ route('stories.show', [$language->slug, $level->slug, $story->slug]) }}" style="text-decoration: none; color: inherit;">
            <div class="story-card">
                <div class="story-img-container">
                    <img src="{{ Str::startsWith($story->image_url, 'http') ? $story->image_url : 'https://source.unsplash.com/random/800x600?' . urlencode($story->title) }}" alt="{{ $story->title }}" class="story-img">
                </div>
                <div class="card-body">
                    <h3 class="story-title">{{ $story->title }}</h3>
                    <p class="story-excerpt">{{ Str::limit($story->excerpt ?? $story->content, 120) }}</p>
                    <span class="read-btn">Start Reading</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
