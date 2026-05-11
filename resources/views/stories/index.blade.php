@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .hero-section {
        background: #004d2a;
        padding: 4rem 2rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom-left-radius: 2rem;
        border-bottom-right-radius: 2rem;
    }
    .hero-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 50%, rgba(52, 211, 153, 0.05) 0%, transparent 70%);
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        margin: 0 auto;
    }
    .hero-title {
        font-size: 2.75rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }
    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.8;
        margin-bottom: 2.5rem;
        font-weight: 400;
    }
    .search-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        padding: 0.4rem;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        max-width: 550px;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .search-container:focus-within {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 145, 80, 0.2);
    }
    .search-input {
        flex: 1;
        border: none;
        padding: 0.85rem 1.5rem;
        font-size: 1rem;
        outline: none;
        background: transparent;
        color: white;
    }
    .search-btn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.85rem 1.75rem;
        border-radius: 1rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .search-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
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

    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 1.5rem;
    }
    .level-section {
        margin-bottom: 5rem;
    }
    .level-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
    }
    .level-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .see-more-link {
        background: linear-gradient(135deg, #009150 0%, #007a43 100%);
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        padding: 0.5rem 1rem;
        border: 2px solid transparent;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }
    .see-more-link:hover {
        background: linear-gradient(135deg, #007a43 0%, #006837 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 145, 80, 0.3);
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
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }
    .story-img-container {
        height: 220px;
        overflow: hidden;
        position: relative;
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
    .story-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 2rem 1rem 1rem;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .story-card:hover .story-overlay {
        opacity: 1;
    }
    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .story-tag {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #009150;
        margin-bottom: 0.5rem;
    }
    .story-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: var(--text-main);
        line-height: 1.3;
    }
    .story-excerpt {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .fav-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--bg-card);
        opacity: 0.9;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: var(--shadow-sm);
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
        <div class="dynamic-badge">
            <span style="display: block; width: 8px; height: 8px; background: #34d399; border-radius: 50%;"></span>
            {{ __('messages.stories') }}
        </div>
        <h1 class="hero-title">{{ __('messages.discover_stories') }}</h1>
        <p class="hero-subtitle">{{ __('messages.stories_subtitle') }}</p>
        
        <form action="{{ route('stories.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_stories') }}" class="search-input">
            <button type="submit" class="search-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                {{ __('messages.find_stories') }}
            </button>
        </form>
    </div>
</div>

<div class="content-wrapper">
    @foreach($languages as $language)
        @foreach($language->storyLevels as $level)
            @if($level->stories->count() > 0)
            <div class="level-section">
                <div class="level-header">
                    <h2 class="level-title">{{ $level->name }} {{ __('messages.stories') }}</h2>
                    <a href="{{ route('stories.level', [$language->slug, $level->slug]) }}" class="see-more-link">{{ __('messages.see_all') }}</a>
                </div>
                
                <div class="stories-grid">
                    @foreach($level->stories->take(3) as $story)
                    <div class="story-card">
                        <button onclick="toggleFavorite(this, {{ $story->id }}, 'story'); event.preventDefault();" class="fav-btn">
                            @php
                                $isFavorited = auth()->check() && auth()->user()->favorites()->where('favoritable_id', $story->id)->where('favoritable_type', 'App\Models\Story')->exists();
                            @endphp
                            <svg width="20" height="20" viewBox="0 0 24 24" 
                                fill="{{ $isFavorited ? '#ef4444' : 'none' }}" 
                                stroke="{{ $isFavorited ? '#ef4444' : '#6b7280' }}" 
                                stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>

                        <a href="{{ route('stories.show', [$language->slug, $level->slug, $story->slug]) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                            <div class="story-img-container">
                                <img src="{{ Str::startsWith($story->image_url, 'http') ? $story->image_url : 'https://source.unsplash.com/random/800x600?' . urlencode($story->title) }}" alt="{{ $story->title }}" class="story-img">
                                <div class="story-overlay">
                                    <span style="color: white; font-weight: 600;">{{ __('messages.read_now') }} &rarr;</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="story-tag">{{ $level->name }}</span>
                                <h3 class="story-title">{{ $story->title }}</h3>
                                <p class="story-excerpt">{{ Str::limit($story->excerpt, 80) }}</p>
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
