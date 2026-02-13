@extends('layouts.app')

@section('content')
<div style="background: white; border-bottom: 1px solid #e5e7eb; margin: -2rem -1rem 2rem -1rem; padding: 2rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="font-size: 2rem; color: #111827; margin: 0;">My Favorites</h1>
        <p style="color: #6b7280; margin-top: 0.5rem;">Your collection of saved lessons and stories.</p>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    @if($favorites->isEmpty())
        <div style="text-align: center; padding: 4rem 1rem; color: #6b7280;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <p style="font-size: 1.1rem; font-weight: 500;">You haven't added any favorites yet.</p>
            <p>Explore <a href="{{ route('grammar.index') }}">Grammar</a> or <a href="{{ route('stories.index') }}">Stories</a> to start building your collection.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($favorites as $favorite)
                @php
                    $item = $favorite->favoritable;
                @endphp
                
                @if($favorite->favoritable_type == 'App\Models\GrammarLesson')
                    <div class="card" style="padding: 1.5rem; position: relative;">
                         <button onclick="toggleFavorite(this, {{ $item->id }}, 'grammar_lesson')" 
                            style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; cursor: pointer;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        <span style="display: inline-block; background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.75rem;">Grammar</span>
                        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;">
                            <a href="{{ route('grammar.lesson', [$item->grammarLevel->language->slug, $item->grammarLevel->slug, $item->slug]) }}" style="color: inherit; text-decoration: none;">
                                {{ $item->title }}
                            </a>
                        </h3>
                        <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">{{ Str::limit(strip_tags($item->explanation), 80) }}</p>
                    </div>
                @elseif($favorite->favoritable_type == 'App\Models\Story')
                    <div class="card" style="padding: 0; overflow: hidden; position: relative;">
                         <button onclick="toggleFavorite(this, {{ $item->id }}, 'story')" 
                            style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.8); border-radius: 50%; padding: 0.25rem; border: none; cursor: pointer; z-index: 10; display: flex;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        <div style="height: 140px; background: #e5e7eb; position: relative;">
                            <img src="{{ Str::startsWith($item->image_url, 'http') ? $item->image_url : 'https://source.unsplash.com/random/800x600?' . urlencode($item->title) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; bottom: 0.5rem; left: 0.5rem; background: rgba(0,0,0,0.6); color: white; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;">Story</span>
                        </div>
                        <div style="padding: 1.25rem;">
                            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;">
                                <a href="{{ route('stories.show', [$item->storyLevel->language->slug, $item->storyLevel->slug, $item->slug]) }}" style="color: inherit; text-decoration: none;">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">{{ Str::limit($item->excerpt, 80) }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<script>
async function toggleFavorite(btn, id, type) {
    if (!confirm('Remove from favorites?')) return;
    
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
        
        if (data.status === 'removed') {
            // Remove the card from the grid
            const card = btn.closest('.card');
            card.remove();
            
            // Check if grid is empty
            // (Optional: Reload page or show empty state if no cards left)
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    }
}
</script>
@endsection
