@extends('layouts.admin')

@section('title', 'Manage Quiz: ' . $lesson->title)

@section('content')
<div class="table-container" style="border: none; background: transparent; box-shadow: none; overflow: visible;">
    <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.5rem; position: relative; z-index: 1;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: #fef3c7; color: #92400e; padding: 0.4rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Lesson Quiz
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2;">{{ $lesson->title }}</h1>
                <p style="color: #6b7280; font-size: 1rem; margin: 0.5rem 0 0 0;">Manage questions for the localized grammar quiz.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.grammar.index') }}" class="btn" style="background: #f3f4f6; color: #374151; padding: 0.875rem 1.75rem; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 700;">
                    Back
                </a>
                <a href="{{ route('admin.grammar.quiz.create', $lesson) }}" class="btn btn-primary" style="padding: 0.875rem 1.75rem; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 700; box-shadow: 0 4px 14px 0 rgba(0, 145, 80, 0.25);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                    Add Question
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #ecfdf5; border-left: 4px solid #059669; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; gap: 1.5rem;">
            @forelse($questions as $question)
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1.25rem; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='white'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none';">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <span style="background: #e2e8f0; color: #475569; width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800;">Q</span>
                            <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">{{ $question->question }}</h4>
                        </div>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; padding-left: 2rem;">
                            @foreach($question->options as $option)
                                <div style="font-size: 0.85rem; padding: 0.25rem 0.75rem; border-radius: 999px; background: {{ $option->is_correct ? '#ecfdf5' : '#ffffff' }}; border: 1px solid {{ $option->is_correct ? '#059669' : '#e5e7eb' }}; color: {{ $option->is_correct ? '#065f46' : '#64748b' }}; font-weight: {{ $option->is_correct ? '700' : '500' }};">
                                    {{ $option->option_text }}
                                    @if($option->is_correct)
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="margin-left: 4px;"><path d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem; margin-left: 2rem;">
                        <a href="{{ route('admin.grammar.quiz.edit', $question) }}" style="background: white; border: 1px solid #e2e8f0; color: #64748b; padding: 0.625rem; border-radius: 0.75rem; transition: all 0.2s;" title="Edit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.grammar.quiz.destroy', $question) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: white; border: 1px solid #fecdd3; color: #f43f5e; padding: 0.625rem; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s;" title="Delete">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem 2rem; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 1.5rem; color: #94a3b8;">
                    <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">No questions for this quiz yet.</p>
                    <a href="{{ route('admin.grammar.quiz.create', $lesson) }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Add the first question</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
