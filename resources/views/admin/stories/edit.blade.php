@extends('layouts.admin')

@section('title', 'Edit Story')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0;">Edit Story</h1>
            <p style="color: #6b7280; font-size: 0.95rem; margin: 0.25rem 0 0 0;">Updating your reading selection for learners.</p>
        </div>
        <a href="{{ route('admin.stories.index') }}" style="color: #6b7280; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#6b7280'">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.stories.update', $story) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column: Main Content -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #374151; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"/></svg>
                        Story Content
                    </h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Story Title</label>
                        <input type="text" name="title" class="search-input" style="width: 100%;" required value="{{ $story->title }}">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Excerpt / Short Summary</label>
                        <textarea name="excerpt" class="search-input" style="width: 100%; height: 80px; line-height: 1.5;">{{ $story->excerpt }}</textarea>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Full Story Body</label>
                        <textarea name="content" class="search-input" style="width: 100%; height: 450px; line-height: 1.7; resize: vertical;" required>{{ $story->content }}</textarea>
                    </div>
                </div>

                <!-- Arabic Illustration Section -->
                <div style="background: #fffbeb; padding: 2rem; border-radius: 1.5rem; border: 1px solid #fde68a; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #92400e; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                        Arabic Comment (Local Translation/Help)
                    </h3>
                    <p style="color: #b45309; font-size: 0.85rem; margin: -1rem 0 1.5rem 0;">Helping learners understand context through their native language.</p>
                    
                    <textarea name="arabic_comment" class="search-input" style="width: 100%; height: 200px; direction: rtl; line-height: 1.8; border-color: #fde68a;">{{ $story->arabic_comment }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings & Media -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #374151; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Story Setup
                    </h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Language & Level</label>
                        <select name="story_level_id" class="search-input" style="width: 100%;" required>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $story->story_level_id == $level->id ? 'selected' : '' }}>
                                    {{ $level->language->name }} - {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">URL Slug</label>
                        <input type="text" name="slug" class="search-input" style="width: 100%; font-family: monospace;" required value="{{ $story->slug }}">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Image URL</label>
                        <input type="url" name="image_url" class="search-input" style="width: 100%;" value="{{ $story->image_url }}">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Audio URL (Optional)</label>
                        <input type="url" name="audio_url" class="search-input" style="width: 100%;" value="{{ $story->audio_url }}">
                    </div>

                    <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 0 0 1.5rem 0;">

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; border-radius: 0.75rem; font-size: 1rem; font-weight: 800;">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.stories.index') }}" class="btn" style="width: 100%; margin-top: 0.75rem; background: #f3f4f6; color: #4b5563; padding: 1rem; border-radius: 0.75rem; text-align: center; text-decoration: none; font-weight: 600;">
                        Discard Changes
                    </a>
                </div>
                
                <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border: 1px solid #fee2e2; text-align: center;">
                     <div style="font-size: 0.85rem; color: #991b1b; font-weight: 700; margin-bottom: 0.25rem;">Meta Information</div>
                    <div style="font-size: 0.75rem; color: #ef4444; line-height: 1.5;">
                        Created: {{ $story->created_at->format('M d, Y') }}<br>
                        Last updated: {{ $story->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
