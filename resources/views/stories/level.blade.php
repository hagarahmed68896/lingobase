@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .header-section {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://source.unsplash.com/random/1920x400?nature,forest') no-repeat center center;
        background-size: cover;
        padding: 6rem 2rem;
        text-align: center;
        color: white;
    }
    .breadcrumb {
        margin-bottom: 2rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
    }
    .breadcrumb a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        opacity: 0.9;
    }
    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }
    .page-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .content-wrapper {
        max-width: 95%;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    .stories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
    .story-card {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #f3f4f6;
    }
    .story-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        border-color: #d1d5db;
    }
    .story-img-container {
        height: 240px;
        overflow: hidden;
    }
    .story-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .story-card:hover .story-img {
        transform: scale(1.05);
    }
    .card-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .story-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: #111827;
        line-height: 1.2;
    }
    .story-excerpt {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        flex-grow: 1;
    }
    .read-btn {
        width: 100%;
        padding: 1rem;
        background: #009150;
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
        text-align: center;
        text-decoration: none;
        display: block;
    }
    .read-btn:hover {
        background: #007a43;
    }
</style>
@endsection

@section('content')
<div class="header-section">
    <nav class="breadcrumb">
        <a href="{{ route('stories.index') }}">Stories</a>
        <span>/</span>
        <span>{{ $language->name }}</span>
        <span>/</span>
        <span>{{ $level->name }}</span>
    </nav>
    <h1 class="page-title">{{ $level->name }} Stories</h1>
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
