@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="stat-grid">
    <!-- Total Users -->
    <div class="stat-card">
        <div class="stat-icon" style="background: #eef2ff; color: #4338ca;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Total Users</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ $stats['total_users'] }}</div>
        </div>
    </div>

    <!-- Total Languages -->
    <div class="stat-card">
        <div class="stat-icon" style="background: #fdf2f8; color: #be185d;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Languages</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ $stats['total_languages'] }}</div>
        </div>
    </div>

    <!-- Total Lessons -->
    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdf4; color: #15803d;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Grammar Lessons</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ $stats['total_lessons'] }}</div>
        </div>
    </div>

    <!-- Total Stories -->
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff7ed; color: #c2410c;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 11V9m-4 5V9m-4 5V9"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Stories</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ $stats['total_stories'] }}</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <div class="table-container">
        <div class="table-header">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700;">Recent Progress</h3>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #6b7280;">Grammar Completions</span>
                    <span class="badge badge-success">{{ $stats['completed_lessons'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #6b7280;">Story Completions</span>
                    <span class="badge badge-blue">{{ $stats['completed_stories'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e5e7eb;">
        <h3 style="margin: 0 0 1rem; font-size: 1.1rem; font-weight: 700;">Quick Actions</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            <a href="{{ route('admin.languages.index') }}" class="btn btn-primary">Add Language</a>
            <a href="{{ route('admin.grammar.index') }}" class="btn btn-primary">New Lesson</a>
            <a href="{{ route('admin.stories.index') }}" class="btn btn-primary">New Story</a>
        </div>
    </div>
</div>
@endsection
