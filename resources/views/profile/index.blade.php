@extends('layouts.app')

@section('styles')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 2rem;
    }

    .sidebar {
        background: white;
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .sidebar-item {
        display: block;
        padding: 0.875rem 1.5rem;
        color: var(--text-main);
        text-decoration: none;
        border-bottom: 1px solid var(--border);
        transition: background 0.1s;
    }

    .sidebar-item:last-child {
        border-bottom: none;
    }

    .sidebar-item:hover {
        background: #f9fafb;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, #009150 0%, #007a43 100%);
        color: white;
    }

    .card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: white;
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .welcome-card {
        background: linear-gradient(135deg, #009150 0%, #007a43 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="sidebar">
        <a href="#" class="sidebar-item active">Overview</a>
        <a href="{{ route('grammar.index') }}" class="sidebar-item">Grammar Bank</a>
        <a href="{{ route('stories.index') }}" class="sidebar-item">Stories</a>
        <a href="{{ route('favorites.index') }}" class="sidebar-item">My Favorites</a>
    </div>

    <div class="main-content">
        <div class="welcome-card">
            <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem;">Welcome back, {{ $user->name }}! 👋</h2>
            <p style="margin: 0; opacity: 0.9;">Ready to continue your English learning journey?</p>
        </div>

        <div class="grid-2">
            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1rem;">Personal Info</h3>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4338ca 0%, #312e81 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                        <div style="color: #6b7280; font-size: 0.9rem;">{{ $user->email }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 1rem;">Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('grammar.index') }}" class="btn btn-primary" style="justify-content: center;">Browse Grammar Lessons</a>
                    <a href="{{ route('stories.index') }}" class="btn" style="justify-content: center;">Read Stories</a>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 1rem;">Your Learning Journey</h3>
            @if(count($recentActivity) > 0)
                <div class="activity-list">
                    @foreach($recentActivity as $activity)
                    <div class="activity-item">
                        <div>
                            <span style="color: #059669; font-weight: 500;">{{ $activity['type'] }}:</span> 
                            {{ $activity['title'] }}
                        </div>
                        <span style="color: #6b7280; font-size: 0.9rem;">{{ $activity['date'] }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem; color: #6b7280;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.3;">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">Start your learning journey today!</p>
                    <a href="{{ route('grammar.placement') }}" class="btn btn-primary">Take Placement Test</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
