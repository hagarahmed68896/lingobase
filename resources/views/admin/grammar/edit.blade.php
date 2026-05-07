@extends('layouts.admin')

@section('title', 'Edit Grammar Lesson')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0;">Edit Grammar Lesson</h1>
            <p style="color: #6b7280; font-size: 0.95rem; margin: 0.25rem 0 0 0;">Updating reference material for students.</p>
        </div>
        <a href="{{ route('admin.grammar.index') }}" style="color: #6b7280; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#6b7280'">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.grammar.update', $lesson) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column: Main Content -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #374151; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Main Content
                    </h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Lesson Title</label>
                        <input type="text" name="title" class="search-input" style="width: 100%;" required value="{{ $lesson->title }}">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Explanation (Direct Instruction)</label>
                        <textarea name="explanation" class="search-input" style="width: 100%; height: 350px; line-height: 1.6; resize: vertical;" required>{{ $lesson->explanation }}</textarea>
                    </div>
                </div>

                <!-- Arabic Illustration Section -->
                <div style="background: #fffbeb; padding: 2rem; border-radius: 1.5rem; border: 1px solid #fde68a; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #92400e; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                        Arabic Illustration (Tips & Comments)
                    </h3>
                    <p style="color: #b45309; font-size: 0.85rem; margin: -1rem 0 1.5rem 0;">Helping learners understand context through their native language.</p>
                    
                    <textarea name="arabic_explanation" class="search-input" style="width: 100%; height: 200px; direction: rtl; line-height: 1.8; border-color: #fde68a;">{{ $lesson->arabic_explanation }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #374151; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        Lesson Settings
                    </h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Language & Level</label>
                        <select name="grammar_level_id" class="search-input" style="width: 100%;" required>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $lesson->grammar_level_id == $level->id ? 'selected' : '' }}>
                                    {{ $level->language->name }} - {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">URL Slug</label>
                        <input type="text" name="slug" class="search-input" style="width: 100%; font-family: monospace; font-size: 0.9rem;" required value="{{ $lesson->slug }}">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #4b5563; margin-bottom: 0.5rem;">Display Order</label>
                        <input type="number" name="order" class="search-input" style="width: 100%;" value="{{ $lesson->order }}" required>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 0 0 1.5rem 0;">

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; border-radius: 0.75rem; font-size: 1rem; font-weight: 800;">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.grammar.index') }}" class="btn" style="width: 100%; margin-top: 0.75rem; background: #f3f4f6; color: #4b5563; padding: 1rem; border-radius: 0.75rem; text-align: center; text-decoration: none; font-weight: 600;">
                        Discard Changes
                    </a>
                </div>
                
                <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border: 1px solid #fee2e2; text-align: center;">
                     <div style="font-size: 0.85rem; color: #991b1b; font-weight: 700; margin-bottom: 0.25rem;">Meta Information</div>
                    <div style="font-size: 0.75rem; color: #ef4444; line-height: 1.5;">
                        Created: {{ $lesson->created_at->format('M d, Y') }}<br>
                        Last updated: {{ $lesson->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
