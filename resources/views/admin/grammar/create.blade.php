@extends('layouts.admin')

@section('title', 'Add New Grammar Lesson')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 1rem; border: 1px solid #e5e7eb; max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.grammar.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Grammar Level</label>
            <select name="grammar_level_id" class="search-input" style="width: 100%;" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->language->name }} - {{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Title (English/Spanish)</label>
            <input type="text" name="title" class="search-input" style="width: 100%;" required placeholder="e.g. Present Continuous">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Slug</label>
            <input type="text" name="slug" class="search-input" style="width: 100%;" required placeholder="e.g. present-continuous">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Explanation (Original)</label>
            <textarea name="explanation" class="search-input" style="width: 100%; height: 200px;" required placeholder="Content in the target language..."></textarea>
        </div>

        <div style="margin-bottom: 1.5rem; background: #fffbeb; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #fde68a;">
            <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #92400e;">Arabic Illustration (Comments)</label>
            <textarea name="arabic_explanation" class="search-input" style="width: 100%; height: 150px; direction: rtl;" placeholder="توضيح باللغة العربية لمساعدة المتعلم..."></textarea>
            <small style="color: #b45309; display: block; margin-top: 0.5rem;">This will be displayed only when the user switches to the Arabic language.</small>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Display Order</label>
            <input type="number" name="order" class="search-input" style="width: 100px;" value="1" required>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create Lesson</button>
            <a href="{{ route('admin.grammar.index') }}" class="btn" style="background: #e5e7eb; color: #374151;">Cancel</a>
        </div>
    </form>
</div>
@endsection
