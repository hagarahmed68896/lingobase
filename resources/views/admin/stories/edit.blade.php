@extends('layouts.admin')

@section('title', 'Edit Story')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 1rem; border: 1px solid #e5e7eb; max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.stories.update', $story) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Story Level</label>
            <select name="story_level_id" class="search-input" style="width: 100%;" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" {{ $story->story_level_id == $level->id ? 'selected' : '' }}>
                        {{ $level->language->name }} - {{ $level->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Title (English/Spanish)</label>
            <input type="text" name="title" class="search-input" style="width: 100%;" required value="{{ $story->title }}">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Slug</label>
            <input type="text" name="slug" class="search-input" style="width: 100%;" required value="{{ $story->slug }}">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Excerpt / Summary</label>
            <textarea name="excerpt" class="search-input" style="width: 100%; height: 80px;">{{ $story->excerpt }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Full Content (Original)</label>
            <textarea name="content" class="search-input" style="width: 100%; height: 300px;" required>{{ $story->content }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem; background: #fffbeb; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #fde68a;">
            <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #92400e;">Arabic Comments (Illustrations)</label>
            <textarea name="arabic_comment" class="search-input" style="width: 100%; height: 150px; direction: rtl;">{{ $story->arabic_comment }}</textarea>
            <small style="color: #b45309; display: block; margin-top: 0.5rem;">This will be displayed only when the user switches to the Arabic language.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Image URL</label>
            <input type="url" name="image_url" class="search-input" style="width: 100%;" value="{{ $story->image_url }}">
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Audio URL</label>
            <input type="url" name="audio_url" class="search-input" style="width: 100%;" value="{{ $story->audio_url }}">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Story</button>
            <a href="{{ route('admin.stories.index') }}" class="btn" style="background: #e5e7eb; color: #374151;">Cancel</a>
        </div>
    </form>
</div>
@endsection
