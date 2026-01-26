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
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.5;
    }
    .hero-content {
        max-width: 800px;
        margin: 0 auto;
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }
    .search-container {
        background: rgba(255,255,255,0.95);
        padding: 0.5rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        max-width: 600px;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .search-input {
        flex: 1;
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        outline: none;
        background: transparent;
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
        max-width: 95%; /* Very wide container */
        margin: 0 auto;
        padding: 2.5rem 2rem;
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
        color: #1f2937;
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
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
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
        color: #111827;
        line-height: 1.3;
    }
    .story-excerpt {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }
    .fav-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255,255,255,0.9);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .fav-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">{{ __('messages.discover_stories') }}</h1>
        <p class="hero-subtitle">{{ __('messages.stories_subtitle') }}</p>
        
        <form action="{{ route('stories.index') }}" method="GET" class="search-container">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_stories') }}" class="search-input">
            <button type="submit" class="search-btn">{{ __('messages.find_stories') }}</button>
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
                        @auth
                        <button onclick="toggleFavorite(this, {{ $story->id }}, 'story'); event.preventDefault();" class="fav-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" 
                                fill="{{ auth()->user()->favorites()->where('favoritable_id', $story->id)->where('favoritable_type', 'App\Models\Story')->exists() ? '#ef4444' : 'none' }}" 
                                stroke="{{ auth()->user()->favorites()->where('favoritable_id', $story->id)->where('favoritable_type', 'App\Models\Story')->exists() ? '#ef4444' : '#6b7280' }}" 
                                stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        @endauth

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
