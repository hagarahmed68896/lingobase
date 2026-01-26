@extends('layouts.admin')

@section('title', 'Add New Story')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 1rem; border: 1px solid #e5e7eb; max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.stories.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Story Level</label>
            <select name="story_level_id" class="search-input" style="width: 100%;" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->language->name }} - {{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Title (English/Spanish)</label>
            <input type="text" name="title" class="search-input" style="width: 100%;" required placeholder="Story Title">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Slug</label>
            <input type="text" name="slug" class="search-input" style="width: 100%;" required placeholder="story-slug">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Excerpt / Summary</label>
            <textarea name="excerpt" class="search-input" style="width: 100%; height: 80px;" placeholder="Brief summary of the story..."></textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Full Content (Original)</label>
            <textarea name="content" class="search-input" style="width: 100%; height: 300px;" required placeholder="Story content..."></textarea>
        </div>

        <div style="margin-bottom: 1.5rem; background: #fffbeb; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #fde68a;">
            <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #92400e;">Arabic Comments (Illustrations)</label>
            <textarea name="arabic_comment" class="search-input" style="width: 100%; height: 150px; direction: rtl;" placeholder="تعليقات توضيحية باللغة العربية..."></textarea>
            <small style="color: #b45309; display: block; margin-top: 0.5rem;">This will be displayed only when the user switches to the Arabic language.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Image URL</label>
            <input type="url" name="image_url" class="search-input" style="width: 100%;" placeholder="https://example.com/image.jpg">
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Audio URL</label>
            <input type="url" name="audio_url" class="search-input" style="width: 100%;" placeholder="https://example.com/audio.mp3">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create Story</button>
            <a href="{{ route('admin.stories.index') }}" class="btn" style="background: #e5e7eb; color: #374151;">Cancel</a>
        </div>
    </form>
</div>
@endsection
