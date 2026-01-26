@extends('layouts.app')

@section('styles')
<style>
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .header-section {
        background: #f9fafb;
        padding: 4rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
    }
    .breadcrumb {
        margin-bottom: 2rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.9rem;
    }
    .breadcrumb a {
        color: #009150;
        text-decoration: none;
        font-weight: 500;
    }
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 1rem;
    }
    .page-subtitle {
        color: #4b5563;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }
    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    .lessons-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .lesson-item {
        display: flex;
        align-items: center;
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    .lesson-item:hover {
        border-color: #009150;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transform: translateX(4px);
    }
    .lesson-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #d1d5db;
        margin-right: 2rem;
        min-width: 40px;
    }
    .lesson-info {
        flex-grow: 1;
    }
    .lesson-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    .lesson-desc {
        color: #6b7280;
        font-size: 0.95rem;
    }
    .lesson-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .status-badge {
        font-size: 0.8rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        background: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="header-section">
    <nav class="breadcrumb">
        <a href="{{ route('grammar.index') }}">Grammar Bank</a>
        <span>/</span>
        <span>{{ $language->name }}</span>
        <span>/</span>
        <span style="color: #6b7280;">{{ $level->name }}</span>
    </nav>
    <h1 class="page-title">{{ $level->name }} Grammar</h1>
    <p class="page-subtitle">Master the essential grammar rules for this level. Complete all lessons to advance.</p>
</div>

<div class="content-wrapper">
    <div class="lessons-list">
        @foreach($level->lessons as $lesson)
        <a href="{{ route('grammar.lesson', [$language->slug, $level->slug, $lesson->slug]) }}" class="lesson-item">
            <span class="lesson-number">{{ sprintf('%02d', $loop->iteration) }}</span>
            <div class="lesson-info">
                <h3 class="lesson-title">{{ $lesson->title }}</h3>
                <p class="lesson-desc">Click to start this lesson</p>
            </div>
            <div class="lesson-actions">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#009150" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
