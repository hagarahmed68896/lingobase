@extends('layouts.admin')

@section('title', 'Edit Placement Question')

@section('content')
<style>
    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.5rem;
        letter-spacing: 0.05em;
    }
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.2s;
        box-sizing: border-box;
        background: #f8fafc;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 145, 80, 0.15);
        outline: none;
        background: white;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .option-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    .option-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .option-radio {
        appearance: none;
        width: 24px;
        height: 24px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        margin-top: 0.4rem;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }
    .option-radio:checked {
        border-color: var(--primary);
        background: var(--primary);
    }
    .option-radio:checked::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .option-radio:checked + label .option-status {
        color: var(--primary);
        font-weight: 700;
    }
    .option-card.is-correct {
        border-color: var(--primary);
        background: #f0fdf4;
    }
</style>

<div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.025); overflow: hidden;">
    
    <div style="background: linear-gradient(to right, #009150, #059669); padding: 2rem 2.5rem; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 0.5rem 0;">Edit Assessment Question</h1>
                <p style="margin: 0; opacity: 0.9; font-size: 1.05rem;">Modifying question ID #{{ $placementQuestion->id }}</p>
            </div>
            <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700; font-size: 0.85rem;">
                {{ $placementQuestion->level }} • {{ ucfirst($placementQuestion->section) }}
            </div>
        </div>
    </div>

    <form action="{{ route('admin.placement-questions.update', $placementQuestion) }}" method="POST" enctype="multipart/form-data" style="padding: 2.5rem;">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; font-weight: 700;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Please fix the following errors
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.9rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 2.5rem; margin-bottom: 2rem;">
            <!-- Column 1: Metadata -->
            <div>
                <h3 class="section-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Question Metadata
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label>CEFR Level</label>
                        <select name="level" class="form-control" required>
                            <option value="">Select Level</option>
                            @foreach($levels as $level)
                                <option value="{{ $level }}" {{ old('level', $placementQuestion->level) == $level ? 'selected' : '' }}>Level {{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Test Section</label>
                        <select name="section" class="form-control" required>
                            <option value="">Select Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section }}" {{ old('section', $placementQuestion->section) == $section ? 'selected' : '' }}>{{ ucfirst($section) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label>Points / Weight</label>
                    <input type="number" step="0.01" min="0.1" name="points" class="form-control" value="{{ old('points', rtrim(rtrim($placementQuestion->points, '0'), '.')) }}" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label>Primary Skill (Optional)</label>
                        <input type="text" name="skill" class="form-control" value="{{ old('skill', $placementQuestion->skill) }}" placeholder="e.g. Verb Tense">
                    </div>
                    <div class="form-group">
                        <label>Sub Skill (Optional)</label>
                        <input type="text" name="sub_skill" class="form-control" value="{{ old('sub_skill', $placementQuestion->sub_skill) }}" placeholder="e.g. Present Perfect">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label>Distractor Logic (Optional)</label>
                    <input type="text" name="distractor_logic" class="form-control" value="{{ old('distractor_logic', $placementQuestion->distractor_logic) }}" placeholder="Explanation of wrong options">
                </div>

                <div class="form-group">
                    <label>Audio File (Optional)</label>
                    @if($placementQuestion->media_url)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.25rem; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.9rem; color: #0f172a;">Current Audio File</div>
                                    <a href="{{ $placementQuestion->media_url }}" target="_blank" style="font-size: 0.8rem; color: var(--primary); text-decoration: none;">Listen / Download</a>
                                </div>
                            </div>
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #dc2626; cursor: pointer; background: #fef2f2; padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-weight: 600; margin: 0; text-transform: none; letter-spacing: 0;">
                                <input type="checkbox" name="remove_media" value="1"> Remove
                            </label>
                        </div>
                    @endif
                    <div style="border: 2px dashed #cbd5e1; border-radius: 1rem; padding: 1.5rem; text-align: center; background: #f8fafc;">
                        <input type="file" name="media_file" accept=".mp3,.wav,.ogg" style="max-width: 100%;">
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.8rem; color: #64748b;">Upload new to replace existing.</p>
                    </div>
                </div>
            </div>

            <!-- Column 2: Content -->
            <div>
                <h3 class="section-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Question & Answers
                </h3>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label>Question Content / Text</label>
                    <textarea name="question_text" class="form-control" style="min-height: 120px; resize: vertical;" required>{{ old('question_text', $placementQuestion->question_text) }}</textarea>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <label style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin: 0;">Multiple Choice Options</label>
                        <span style="font-size: 0.75rem; background: #e2e8f0; padding: 0.2rem 0.6rem; border-radius: 1rem; font-weight: 600; color: #475569;">Select the correct answer</span>
                    </div>

                    <div id="options-container">
                        @php
                            // Ensure we always show 4 fields even if fewer exist in DB
                            $options = $placementQuestion->options;
                            for($j = $options->count(); $j < 4; $j++) {
                                $options->push(new \App\Models\PlacementOption());
                            }
                        @endphp
                        
                        @foreach($options as $i => $option)
                            @php
                                $isChecked = false;
                                if(old('correct_option') !== null) {
                                    $isChecked = old('correct_option') == $i;
                                } else {
                                    $isChecked = $option->is_correct;
                                }
                            @endphp
                        <div class="option-card {{ $isChecked ? 'is-correct' : '' }}" id="option-card-{{ $i }}">
                            @if($option->id)
                                <input type="hidden" name="options[{{ $i }}][id]" value="{{ $option->id }}">
                            @endif
                            <input type="radio" name="correct_option" value="{{ $i }}" class="option-radio" id="radio-{{ $i }}" {{ $isChecked ? 'checked' : '' }} required onchange="updateOptionStyles()">
                            <label for="radio-{{ $i }}" style="flex: 1; cursor: pointer;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <strong style="color: #1e293b; font-size: 0.95rem;">Option {{ chr(65 + $i) }}</strong>
                                    <span class="option-status" style="font-size: 0.75rem; color: {{ $isChecked ? 'var(--primary)' : '#94a3b8' }}; font-weight: {{ $isChecked ? '700' : '600' }}; text-transform: uppercase;">
                                        {{ $isChecked ? 'Correct Answer' : 'Incorrect Answer' }}
                                    </span>
                                </div>
                                <input type="text" name="options[{{ $i }}][text]" class="form-control" value="{{ old("options.{$i}.text", $option->option_text) }}" required style="background: white;">
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid #e2e8f0; margin-top: 1rem; padding-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.placement-questions.index') }}" class="btn" style="background: white; border: 2px solid #e2e8f0; color: #64748b; padding: 0.875rem 2rem; border-radius: 1rem;">Cancel</a>
            <button type="submit" class="btn btn-primary" style="padding: 0.875rem 2rem; border-radius: 1rem; font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px 0 rgba(0, 145, 80, 0.25);">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Update Question Settings
            </button>
        </div>
    </form>
</div>

<script>
    function updateOptionStyles() {
        document.querySelectorAll('.option-card').forEach(card => card.classList.remove('is-correct'));
        document.querySelectorAll('.option-status').forEach(status => {
            status.textContent = 'Incorrect Answer';
            status.style.color = '#94a3b8';
            status.style.fontWeight = '600';
        });

        const checkedRadio = document.querySelector('.option-radio:checked');
        if(checkedRadio) {
            const parentCard = checkedRadio.closest('.option-card');
            parentCard.classList.add('is-correct');
            const statusNode = parentCard.querySelector('.option-status');
            statusNode.textContent = 'Correct Answer';
            statusNode.style.color = 'var(--primary)';
            statusNode.style.fontWeight = '700';
        }
    }
</script>
@endsection
