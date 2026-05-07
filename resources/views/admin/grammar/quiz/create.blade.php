@extends('layouts.admin')

@section('title', 'Add Quiz Question - ' . $lesson->title)

@section('content')
<div class="table-container" style="border: none; background: transparent; box-shadow: none; overflow: visible;">
    <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0;">Add New Question</h1>
            <p style="color: #6b7280; font-size: 0.95rem; margin-top: 0.25rem;">For lesson: {{ $lesson->title }}</p>
        </div>

        <form action="{{ route('admin.grammar.quiz.store', $lesson) }}" method="POST" id="question-form">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-transform: uppercase; margin-bottom: 0.75rem; letter-spacing: 0.05em;">Question Text</label>
                <textarea name="question" class="search-input" style="width: 100%; height: 100px; border-radius: 0.75rem; padding: 1rem; resize: none;" placeholder="Enter the question here..." required>{{ old('question') }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Answer Options</label>
                    <button type="button" id="add-option" style="background: #ecfdf5; color: #059669; border: none; padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                        Add Option
                    </button>
                </div>

                <div id="options-container" style="display: grid; gap: 1rem;">
                    <div class="option-row" style="display: flex; align-items: center; gap: 1rem; background: #f8fafc; padding: 1rem; border-radius: 1rem; border: 1px solid #e2e8f0;">
                         <input type="radio" name="correct_option" value="0" required checked style="width: 20px; height: 20px; accent-color: var(--primary);">
                         <input type="text" name="options[0][text]" class="search-input" style="flex: 1; border-radius: 0.5rem;" placeholder="Option 1" required>
                         <div style="width: 32px;"></div>
                    </div>
                    <div class="option-row" style="display: flex; align-items: center; gap: 1rem; background: #f8fafc; padding: 1rem; border-radius: 1rem; border: 1px solid #e2e8f0;">
                         <input type="radio" name="correct_option" value="1" style="width: 20px; height: 20px; accent-color: var(--primary);">
                         <input type="text" name="options[1][text]" class="search-input" style="flex: 1; border-radius: 0.5rem;" placeholder="Option 2" required>
                         <button type="button" class="remove-option" style="color: #ef4444; background: none; border: none; cursor: pointer;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('admin.grammar.quiz.index', $lesson) }}" class="btn" style="background: #f3f4f6; color: #374151;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Save Question</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('options-container');
        const addButton = document.getElementById('add-option');
        let optionCount = 2;

        addButton.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'option-row';
            div.style.cssText = 'display: flex; align-items: center; gap: 1rem; background: #f8fafc; padding: 1rem; border-radius: 1rem; border: 1px solid #e2e8f0;';
            div.innerHTML = `
                <input type="radio" name="correct_option" value="${optionCount}" style="width: 20px; height: 20px; accent-color: var(--primary);">
                <input type="text" name="options[${optionCount}][text]" class="search-input" style="flex: 1; border-radius: 0.5rem;" placeholder="Option ${optionCount + 1}" required>
                <button type="button" class="remove-option" style="color: #ef4444; background: none; border: none; cursor: pointer;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            `;
            container.appendChild(div);
            optionCount++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-option')) {
                const row = e.target.closest('.option-row');
                if (container.children.length > 2) {
                    row.remove();
                    reindexOptions();
                } else {
                    alert('At least 2 options are required.');
                }
            }
        });

        function reindexOptions() {
            const rows = container.querySelectorAll('.option-row');
            optionCount = rows.length;
            rows.forEach((row, index) => {
                const radio = row.querySelector('input[type="radio"]');
                const text = row.querySelector('input[type="text"]');
                radio.value = index;
                text.name = `options[${index}][text]`;
                text.placeholder = `Option ${index + 1}`;
            });
        }
    });
</script>
@endsection
