@extends('layouts.admin')

@section('title', 'Manage Placement Tests')

@section('content')
<div class="table-container" style="border: none; background: transparent; box-shadow: none; overflow: visible;">
    <!-- Modern Header & Filters -->
    <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; border: 1px solid #e5e7eb; margin-bottom: 2rem; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
        <!-- Decorative background element -->
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(0,145,80,0.05) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; pointer-events: none;"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.5rem; position: relative; z-index: 1;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ecfdf5; color: #059669; padding: 0.4rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Evaluation System
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2;">Placement Questions</h1>
                <p style="color: #6b7280; font-size: 1rem; margin: 0.5rem 0 0 0; max-width: 500px;">Curate and manage the adaptive placement test questions across all levels and sections.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.placement-settings.index') }}" class="btn" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 0.875rem 1.5rem; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 700; transition: all 0.3s ease;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Settings
                </a>
                <a href="{{ route('admin.placement-questions.create') }}" class="btn btn-primary" style="padding: 0.875rem 1.75rem; border-radius: 1rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 700; font-size: 0.95rem; box-shadow: 0 4px 14px 0 rgba(0, 145, 80, 0.25); transition: all 0.3s ease;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Create Question
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
            @foreach($stats as $section => $count)
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 0.75rem 1.25rem; border-radius: 1rem; display: flex; align-items: center; gap: 1rem; min-width: 160px;">
                    <div style="background: white; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <span style="font-weight: 800; color: var(--primary); font-size: 0.8rem;">{{ strtoupper(substr($section, 0, 1)) }}</span>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">{{ $section }}</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #1e293b;">{{ $count }} <small style="font-size: 0.65rem; color: #64748b;">Questions</small></div>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.placement-questions.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; align-items: end; position: relative; z-index: 1;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #4b5563; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Search Keyword</label>
                <div style="position: relative;">
                    <div style="position: absolute; inset-y: 0; left: 0; padding-left: 1rem; display: flex; align-items: center; pointer-events: none;">
                        <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" class="search-input" style="width: 100%; padding-left: 2.5rem; border-radius: 0.75rem; border-color: #e5e7eb; padding-top: 0.75rem; padding-bottom: 0.75rem;" placeholder="E.g. Identify the synonym..." value="{{ request('search') }}">
                </div>
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #4b5563; margin-bottom: 0.5rem; letter-spacing: 0.05em;">CEFR Level</label>
                <select name="level" class="search-input" style="width: 100%; border-radius: 0.75rem; border-color: #e5e7eb; padding-top: 0.75rem; padding-bottom: 0.75rem; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">All Levels</option>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>Level {{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #4b5563; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Test Section</label>
                <select name="section" class="search-input" style="width: 100%; border-radius: 0.75rem; border-color: #e5e7eb; padding-top: 0.75rem; padding-bottom: 0.75rem; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                        <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>{{ ucfirst($section) }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; border-radius: 0.75rem; padding: 0.75rem 1rem;">Filter Results</button>
                @if(request('search') || request('level') || request('section'))
                    <a href="{{ route('admin.placement-questions.index') }}" class="btn" style="background: #f3f4f6; color: #374151; padding: 0.75rem 1rem; border-radius: 0.75rem; text-decoration: none;" title="Reset Filters">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    @if(session('success'))
        <div style="background: #ecfdf5; border-left: 4px solid #059669; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem;">
            <svg width="24" height="24" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Premium Table Layout -->
    <div style="background: white; border-radius: 1.5rem; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); position: relative;">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; width: 60px;">ID</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0;">Question Content</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0;">Level</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0;">Section</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0;">Points</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0;">Actions</th>
                    </tr>
                </thead>
                <tbody style="background: white;">
                    @forelse($questions as $question)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'; this.style.transform='scale(1.002)';" onmouseout="this.style.background='white'; this.style.transform='scale(1)';">
                            <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="font-family: monospace; color: #94a3b8; font-weight: 600;">#{{ $question->id }}</span>
                            </td>
                            <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <div style="font-weight: 600; color: #1e293b; font-size: 0.95rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 400px;">
                                        {{ $question->question_text }}
                                    </div>
                                    @if($question->skill || $question->sub_skill)
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        @if($question->skill)
                                        <span style="font-size: 0.7rem; background: #f1f5f9; color: #475569; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-weight: 600;">{{ $question->skill }}</span>
                                        @endif
                                        @if($question->sub_skill)
                                        <span style="font-size: 0.7rem; background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 0.15rem 0.5rem; border-radius: 0.25rem;">{{ $question->sub_skill }}</span>
                                        @endif
                                        @if($question->media_url)
                                        <span style="color: var(--primary);" title="Contains Audio/Media">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 1.5rem; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                @php
                                    $levelColors = [
                                        'A1' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fca5a5'],
                                        'A2' => ['bg' => '#fff7ed', 'text' => '#ea580c', 'border' => '#fdba74'],
                                        'B1' => ['bg' => '#fefce8', 'text' => '#ca8a04', 'border' => '#fde047'],
                                        'B2' => ['bg' => '#f0fdf4', 'text' => '#16a34a', 'border' => '#86efac'],
                                        'C1' => ['bg' => '#eff6ff', 'text' => '#2563eb', 'border' => '#93c5fd'],
                                        'C2' => ['bg' => '#f5f3ff', 'text' => '#7c3aed', 'border' => '#c4b5fd'],
                                    ];
                                    $color = $levelColors[$question->level] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'];
                                @endphp
                                <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; padding: 0.35rem 0.75rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px;">
                                    {{ $question->level }}
                                </span>
                            </td>
                            <td style="padding: 1.5rem; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                @php
                                    $sectionStyles = [
                                        'grammar' => ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"></path>', 'color' => '#8b5cf6'],
                                        'vocabulary' => ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>', 'color' => '#f59e0b'],
                                        'reading' => ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"></path>', 'color' => '#06b6d4'],
                                        'listening' => ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>', 'color' => '#ec4899'],
                                    ];
                                    $style = $sectionStyles[$question->section] ?? ['icon' => '', 'color' => '#64748b'];
                                @endphp
                                <div style="display: inline-flex; align-items: center; gap: 0.35rem; color: {{ $style['color'] }}; font-weight: 600; font-size: 0.85rem; text-transform: capitalize;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">{!! $style['icon'] !!}</svg>
                                    {{ $question->section }}
                                </div>
                            </td>
                            <td style="padding: 1.5rem; text-align: center; border-bottom: 1px solid #f1f5f9;">
                                <div style="display: inline-flex; justify-content: center; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; width: 40px; height: 40px; border-radius: 50%; color: #334155; font-weight: 800; font-family: monospace; font-size: 0.9rem;">
                                    {{ rtrim(rtrim($question->points, '0'), '.') }}
                                </div>
                            </td>
                            <td style="padding: 1.5rem; text-align: right; border-bottom: 1px solid #f1f5f9;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('admin.placement-questions.edit', $question) }}" style="background: white; border: 1px solid #e2e8f0; color: #64748b; padding: 0.5rem; border-radius: 0.5rem; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Edit Question" onmouseover="this.style.color='var(--primary)'; this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.placement-questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this question?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: white; color: #f43f5e; border: 1px solid #fecdd3; padding: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Delete Question" onmouseover="this.style.background='#f43f5e'; this.style.color='white'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.color='#f43f5e'; this.style.transform='translateY(0)';">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 5rem 2rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; color: #94a3b8;">
                                    <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div style="font-weight: 700; font-size: 1.25rem; color: #475569;">No questions found</div>
                                    <p style="margin: 0; font-size: 0.95rem; max-width: 300px;">Get started by adding a new placement test question or adjusting your current filters.</p>
                                    <a href="{{ route('admin.placement-questions.create') }}" class="btn btn-primary" style="margin-top: 1rem; border-radius: 0.75rem;">Create First Question</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
            <div style="padding: 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <div class="pagination-container">
                    <div class="pagination-info" style="font-weight: 500; color: #64748b;">
                        Showing <strong style="color: #1e293b;">{{ $questions->firstItem() }}</strong> to <strong style="color: #1e293b;">{{ $questions->lastItem() }}</strong> of <strong style="color: #1e293b;">{{ $questions->total() }}</strong> entries
                    </div>
                    {{ $questions->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
