@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #009150;
        --primary-dark: #006b3a;
        --primary-light: #d1fae5;
        --bg-gray: #f8fafc;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.18);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-gray);
        color: var(--text-main);
        background-image:
            radial-gradient(at 0% 0%, rgba(0, 145, 80, 0.05) 0px, transparent 50%),
            radial-gradient(at 50% 0%, rgba(0, 145, 80, 0.03) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(0, 145, 80, 0.05) 0px, transparent 50%);
    }

    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .app-viewport {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 3rem 1rem;
        min-height: calc(100vh - 64px);
    }

    /* Hide Sidebar for Premium Layout */
    .sidebar-wrapper {
        display: none !important;
    }

    /* Premium Quiz Card */
    .quiz-surface {
        width: 100%;
        max-width: 850px;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 600px;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .quiz-header {
        padding: 2.5rem 3rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Modern Progress Bar */
    .progress-container {
        width: 100%;
        height: 8px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), #10b981);
        width: 0%;
        transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 0 10px rgba(0, 145, 80, 0.3);
    }

    .quiz-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .counter-badge {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary);
        background: var(--primary-light);
        padding: 0.4rem 1rem;
        border-radius: 999px;
    }

    .timer-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        color: var(--text-main);
        background: #f1f5f9;
        padding: 0.4rem 1rem;
        border-radius: 999px;
    }

    .quiz-body {
        padding: 1.5rem 3rem 3rem;
        flex: 1;
    }

    .question-h {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.3;
        margin-bottom: 2.5rem;
        letter-spacing: -0.02em;
    }

    /* Interactive Options */
    .options-stack {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    @media (max-width: 640px) {
        .options-stack { grid-template-columns: 1fr; }
        .quiz-header, .quiz-body, .quiz-footer { padding-left: 1.5rem; padding-right: 1.5rem; }
    }

    .opt-box {
        position: relative;
        padding: 1.5rem;
        background: white;
        border: 2px solid #f1f5f9;
        border-radius: 1.25rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .opt-box:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .opt-box.selected {
        border-color: var(--primary);
        background: #f0fdf4;
        box-shadow: 0 0 0 1px var(--primary);
    }

    .opt-box.selected .opt-radio {
        border-color: var(--primary);
        background: var(--primary);
    }

    .opt-radio {
        width: 24px;
        height: 24px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .opt-radio::after {
        content: '';
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .opt-box.selected .opt-radio::after {
        transform: scale(1);
    }

    .opt-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .quiz-footer {
        padding: 1.5rem 3rem 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-lux {
        padding: 1rem 2rem;
        border-radius: 1.25rem;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .btn-lux-primary {
        background: var(--primary);
        color: white;
    }

    .btn-lux-primary:hover:not(:disabled) {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 145, 80, 0.4);
    }

    .btn-lux-outline {
        background: #f8fafc;
        color: var(--text-main);
        border: 1px solid #e2e8f0;
    }

    .btn-lux-outline:hover:not(:disabled) {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .btn-lux:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Onboarding Overhaul */
    .onboard-lux {
        max-width: 700px;
        background: white;
        padding: 4rem 3rem;
        border-radius: 2.5rem;
        box-shadow: var(--card-shadow);
        text-align: center;
    }

    /* Loading Spinner */
    .spinner-lux {
        width: 60px;
        height: 60px;
        border: 5px solid #f1f5f9;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
        margin: 0 auto 2rem;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Results Premium */
    .res-card {
        background: white;
        padding: 4rem;
        border-radius: 3rem;
        box-shadow: var(--card-shadow);
        max-width: 600px;
        text-align: center;
    }

    .res-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
        border: 12px solid white;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.05), 0 15px 30px rgba(0, 145, 80, 0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 3rem;
    }

    .res-perc { font-size: 3.5rem; font-weight: 900; color: var(--primary); line-height: 1; }
    .res-lvl { font-size: 1.25rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem; }

    .audio-lux {
        background: #f1f5f9;
        border-radius: 1.25rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Dark Mode */
    body.dark-mode {
        --bg-gray: #0b1120;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --glass-bg: rgba(30, 41, 59, 0.8);
        --glass-border: rgba(255, 255, 255, 0.05);
    }
    body.dark-mode .opt-box { background: #1e293b; border-color: #334155; }
    body.dark-mode .opt-box:hover { border-color: var(--primary); background: #334155; }
    body.dark-mode .opt-box.selected { background: #064e3b; border-color: var(--primary); }
    body.dark-mode .timer-pill { background: #1e293b; }
    body.dark-mode .btn-lux-outline { background: #1e293b; border-color: #334155; color: white; }
    body.dark-mode .res-card, body.dark-mode .onboard-lux { background: #1e293b; }
    body.dark-mode .res-circle { background: linear-gradient(135deg, #064e3b 0%, #1e293b 100%); }
    /* Layout structure */
    .app-viewport {
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Changed from center to stabilize top position */
        padding-top: 2rem;
        min-height: calc(100vh - 64px);
        background: var(--bg-body);
    }

    .sidebar-wrapper {
        width: 340px;
        background: white;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 64px);
        position: sticky;
        top: 64px;
        z-index: 10;
    }
    .sidebar-lux {
        background: var(--bg-card);
        border-right: 1px solid var(--border-color);
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        overflow-y: auto;
    }
    .q-dot {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--bg-body);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--text-muted);
    }
    @media (max-width: 1024px) {
        .app-viewport { flex-direction: column; }
        .sidebar-wrapper { 
            width: 100%; 
            height: auto; 
            position: relative; 
            top: 0;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }

    /* Sidebar Content */
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .timer-badge-lg {
        background: #f1f5f9;
        padding: 1rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .timer-val {
        font-size: 1.5rem;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        color: var(--text-main);
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .section-group {
        margin-bottom: 2rem;
    }

    .section-title {
        display: none;
    }

    .q-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.5rem;
    }

    .q-chip {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
    }

    .q-chip:hover:not(.disabled) {
        border-color: var(--primary);
        color: var(--primary);
        background: white;
    }

    .q-chip.answered {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .q-chip.current {
        border-color: var(--primary);
        border-width: 2px;
        color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .q-chip.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Quiz Card Styling */
    .quiz-surface {
        width: 100%;
        max-width: 800px;
        background: white;
        border-radius: 1.5rem;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        min-height: 550px; /* Added to prevent height jumping */
        transition: opacity 0.3s ease; /* Added for smooth transitions */
    }

    .quiz-header {
        padding: 1.5rem 2.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(to right, #ffffff, #f8fafc);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .quiz-body {
        padding: 2rem 2.5rem;
        overflow-y: auto; /* Allow scrolling within the question area if needed */
        flex: 1;
    }

    .tag {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background: var(--primary-light);
        color: var(--primary-dark);
        text-transform: uppercase;
    }

    .question-h {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1.4;
        margin-bottom: 2rem;
        word-break: break-word; /* Fix for long text */
    }

    .options-stack {
        display: grid;
        gap: 1rem;
    }

    .opt-box {
        position: relative;
        padding: 1.25rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .option-card-lux {
        background: var(--bg-card);
        border: 2px solid var(--border-color);
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--text-main);
    }
    .option-card-lux:hover {
        border-color: var(--primary);
        background: var(--accent);
    }
    .option-card-lux.selected {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .main-content-lux {
        background: var(--bg-body);
        padding: 3rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        flex: 1;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
    .question-card-lux {
        background: var(--bg-card);
        border-radius: 2rem;
        padding: 3.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        max-width: 850px;
        margin: auto;
        width: 100%;
    }
    .opt-box:hover {
        border-color: var(--primary);
        background: var(--bg-gray);
    }

    .opt-box.selected {
        border-color: var(--primary);
        background: #f0fdf4;
        box-shadow: 0 0 0 1px var(--primary);
    }

    .opt-radio {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .opt-box.selected .opt-radio {
        border-color: var(--primary);
        background: var(--primary);
    }

    .opt-radio::after {
        content: '';
        width: 8px;
        height: 8px;
        background: var(--bg-card);
        border-radius: 50%;
        display: none;
    }

    .opt-box.selected .opt-radio::after {
        display: block;
    }

    .opt-text {
        font-size: 1.05rem;
        font-weight: 500;
        color: var(--text-main);
    }

    .quiz-footer {
        padding: 1.5rem 2.5rem;
        background: var(--bg-body);
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .btn-lux {
        padding: 0.875rem 1.75rem;
        border-radius: 0.875rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
    }

    .btn-lux-primary {
        background: var(--primary);
        color: white;
    }

    .btn-lux-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }

    .btn-lux-outline {
        background: var(--bg-card);
        color: var(--text-main);
        border: 1px solid var(--border-color);
    }

    .btn-lux-outline:hover { background: var(--accent); border-color: var(--primary); }

    .btn-lux:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* Custom Onboarding */
    .onboard-vibe {
        max-width: 900px;
        margin: 0 auto;
        padding: 4rem 1.5rem;
        text-align: center;
        color: var(--text-main);
    }
    .onboard-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        padding: 3rem;
        box-shadow: var(--shadow-sm);
        margin-top: 3rem;
        text-align: start;
    }
    /* Animations */
    .fade-swipe-enter { opacity: 0; transform: translateX(10px); }
    .fade-swipe-active { transition: all 0.3s ease; opacity: 1; transform: translateX(0); }

    .hidden { display: none !important; }

    /* Results */
    .res-circle {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 8px solid var(--primary-light);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }

    .res-perc { font-size: 3rem; font-weight: 800; color: var(--primary); line-height: 1; }
    .res-lvl { font-size: 1.1rem; font-weight: 700; color: var(--text-muted); margin-top: 0.25rem; }

    .audio-lux {
        background: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 2rem;
        min-height: 105px; /* Consistent height for audio block */
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Dark Mode Overrides for Placement Page */
    body.dark-mode {
        --bg-gray: #0f172a;
        --text-main: #f1f5f9;
        --text-muted: #94a3b8;
    }
    body.dark-mode .sidebar-wrapper,
    body.dark-mode .quiz-surface,
    body.dark-mode #scene-intro > div,
    body.dark-mode #scene-final > div {
        background: #1e293b;
        border-color: #334155;
    }
    body.dark-mode .sidebar-header,
    body.dark-mode .quiz-header,
    body.dark-mode .quiz-footer,
    body.dark-mode .timer-badge-lg {
        background: #1e293b;
        border-color: #334155;
    }
    body.dark-mode .opt-box {
        border-color: #334155;
    }
    body.dark-mode .opt-box:hover {
        background: #334155;
    }
    body.dark-mode .opt-box.selected {
        background: #064e3b;
        border-color: var(--primary);
    }
    body.dark-mode .q-chip {
        background: #1e293b;
        border-color: #334155;
    }
</style>
@endsection

@section('content')
<div class="app-viewport">
    <!-- Main Content Area -->
    <div class="main-wrapper" id="main-scene">
        
        <!-- Onboarding / Intro -->
        <div id="scene-intro" class="onboard-lux">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.2;">Determine Your <span style="color: #009150;">English Level</span></h2>
            <p style="color: #64748b; font-size: 1.2rem; line-height: 1.7; margin-bottom: 2.5rem;">{{ __('messages.placement_intro') }}</p>
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 3rem; text-align: left; background: #f8fafc; padding: 2rem; border-radius: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="background: var(--primary); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">✓</div>
                    <p style="margin: 0; font-weight: 600; color: var(--text-main);">Grammar & Vocabulary assessment</p>
                </div>
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="background: var(--primary); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">✓</div>
                    <p style="margin: 0; font-weight: 600; color: var(--text-main);">Reading & Listening sections</p>
                </div>
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="background: var(--primary); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">✓</div>
                    <p style="margin: 0; font-weight: 600; color: var(--text-main);">Personalized level results instantly</p>
                </div>
            </div>
            
            <button onclick="handleLaunch()" class="btn-lux btn-lux-primary" style="padding: 1.25rem 4rem; font-size: 1.1rem;">
                Start Assessment
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>

        <!-- Question View (Glassmorphic) -->
        <div id="scene-test" class="quiz-surface hidden" style="opacity: 0;">
            <div class="quiz-header">
                <div class="progress-container">
                    <div id="progress-bar" class="progress-fill"></div>
                </div>
                <div class="quiz-meta">
                    <span id="answered-stat" class="counter-badge">Question 1 / 43</span>
                    <div id="global-timer" class="timer-pill">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span id="timer-text">30:00</span>
                    </div>
                </div>
            </div>
            
            <div class="quiz-body" id="q-body-container">
                <!-- Listening content if applicable -->
                <div id="audio-ui" class="audio-lux hidden">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="background: var(--primary); color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
                        </div>
                        <span style="font-weight: 700; font-size: 0.95rem; color: var(--text-main);">Listen Carefully</span>
                    </div>
                    <audio id="audio-ref" controls style="width: 100%; border-radius: 10px;"></audio>
                </div>

                <div id="q-txt" class="question-h">...</div>
                
                <div id="opts-stack" class="options-stack">
                    <!-- Options injected here -->
                </div>
            </div>

            <div class="quiz-footer">
                <button onclick="navPrev()" id="btn-back" class="btn-lux btn-lux-outline">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Previous
                </button>
                <div style="display: flex; gap: 1rem;">
                    <button onclick="navNext()" id="btn-cont" class="btn-lux btn-lux-primary">
                        Next Question
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                    <button id="btn-final-done" onclick="completeAssessment()" class="btn-lux btn-lux-primary hidden" style="background: #000;">
                        Submit & View Results
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Result View -->
        <div id="scene-final" class="res-card hidden">
            <div style="font-size: 5rem; margin-bottom: 2rem;">🏆</div>
            <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">Excellent Work!</h2>
            <p style="color: var(--text-muted); font-size: 1.15rem; margin-bottom: 3.5rem;">Your linguistic profile has been successfully evaluated.</p>
            
            <div class="res-circle">
                <div class="res-perc"><span id="res-val">0</span>%</div>
                <div class="res-lvl" id="res-lvl-label">Level --</div>
            </div>

            <div id="recommendations-area" style="margin-bottom: 4rem;">
                <!-- Recommendations injected here -->
            </div>

            <a href="{{ route('profile.index') }}" class="btn-lux btn-lux-primary" style="text-decoration: none; padding: 1.25rem 4rem;">
                Continue to Dashboard
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Loading View -->
        <div id="scene-loading" class="hidden" style="text-align: center; padding: 5rem;">
            <div class="spinner-lux"></div>
            <p id="loading-msg" style="color: var(--text-main); font-weight: 700; font-size: 1.2rem; letter-spacing: -0.01em;">Preparing your personalized test...</p>
        </div>

    </div>
</div>

<script>
    // State management
    let testId = null;
    let testViewActive = false;
    let currentIndex = 0;
    let totalQs = 43;
    let answered = new Set();
    let timeLeft = 30 * 60;
    let timerId = null;
    let activeQ = null;
    let busy = false;

    const isLoggedIn = @json(Auth::check());

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('start') === '1' && isLoggedIn) {
            launchAssessment();
        }
    });

    function handleLaunch() {
        if (!isLoggedIn) {
            // Redirect to login and come back to start the test
            window.location.href = "{{ route('login') }}?redirect_to=" + encodeURIComponent("{{ route('grammar.placement') }}?start=1");
            return;
        }
        launchAssessment();
    }

    async function launchAssessment() {
        const sceneTest = document.getElementById('scene-test');
        sceneTest.style.opacity = '0';
        
        showView('scene-loading');

        try {
            const res = await fetch('/grammar/placement-test/start', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({})
            });
            const data = await res.json();
            
            if (data.status) {
                testId = data.data.test_id;
                testViewActive = true;
                totalQs = data.data.total_questions;
                buildSidebar();
                renderQuestion(data.data.first_question);
                startTimer();
                
                // document.getElementById('side-nav').classList.remove('hidden');
                showView('scene-test');
            } else {
                alert(data.message);
                showView('scene-intro');
            }
        } catch (e) {
            console.error(e);
            showView('scene-intro');
        }
    }

    function buildSidebar() {
        // Sidebar grid removed in premium layout
    }

    function updateStat() {
        const progress = ((currentIndex + 1) / totalQs) * 100;
        document.getElementById('progress-bar').style.width = `${progress}%`;
        document.getElementById('answered-stat').innerText = `Question ${currentIndex + 1} / ${totalQs}`;
    }

    async function renderQuestion(q) {
        const sceneTest = document.getElementById('scene-test');
        sceneTest.style.opacity = '0';
        
        activeQ = q;
        currentIndex = q.progress.current - 1; // RESTORED THIS LINE
        
        // Update labels
        // document.getElementById('q-idx-label').innerText = q.progress.current; // Removed legacy ID
        document.getElementById('q-txt').innerText = q.text;

        // Nav buttons
        document.getElementById('btn-back').disabled = (currentIndex === 0);
        document.getElementById('btn-cont').classList.toggle('hidden', currentIndex === totalQs - 1);
        document.getElementById('btn-final-done').classList.toggle('hidden', !(currentIndex === totalQs - 1 && answered.size === totalQs));

        // Audio 
        const audioUi = document.getElementById('audio-ui');
        const audioRef = document.getElementById('audio-ref');
        if (q.section === 'listening' && q.media_url) {
            audioUi.classList.remove('hidden');
            audioRef.src = q.media_url;
        } else {
            audioUi.classList.add('hidden');
            audioRef.pause();
        }

        // Options
        const optStack = document.getElementById('opts-stack');
        optStack.innerHTML = '';
        q.options.forEach(opt => {
            const div = document.createElement('div');
            div.className = `opt-box ${q.selected_option_id == opt.id ? 'selected' : ''}`;
            div.innerHTML = `
                <div class="opt-radio"></div>
                <div class="opt-text">${opt.text}</div>
            `;
            div.onclick = () => selectOption(opt.id, div);
            optStack.appendChild(div);
        });

        // Sidebar sync removed in premium layout
        
        if (q.answered) {
            answered.add(currentIndex);
        }
        updateStat();

        showView('scene-test');
        setTimeout(() => {
            sceneTest.style.opacity = '1';
        }, 50);
    }

    async function selectOption(optId, el) {
        if (busy) return;
        
        document.querySelectorAll('.opt-box').forEach(x => x.classList.remove('selected'));
        el.classList.add('selected');

        busy = true;
        try {
            const res = await fetch(`/grammar/placement-test/${testId}/answer`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ question_id: activeQ.id, option_id: optId })
            });
            const data = await res.json();
            if (data.status) {
                answered.add(currentIndex);
                // document.getElementById(`chip-${currentIndex}`).classList.add('answered'); // Removed legacy ID
                updateStat();

                // if last node and all done, show finish
                if (currentIndex === totalQs - 1 && answered.size === totalQs) {
                    document.getElementById('btn-final-done').classList.remove('hidden');
                    document.getElementById('btn-cont').classList.add('hidden');
                }
            }
        } finally {
            busy = false;
        }
    }

    async function jumpTo(idx) {
        if (busy || idx === currentIndex) return;
        showView('scene-loading');
        document.getElementById('loading-msg').innerText = `Navigating to question ${idx + 1}...`;

        try {
            const res = await fetch(`/grammar/placement-test/${testId}/navigate`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ question_index: idx })
            });
            const data = await res.json();
            if (data.status) {
                renderQuestion(data.data);
            }
        } catch (e) {
            showView('scene-test');
        }
    }

    function navNext() {
        if (currentIndex < totalQs - 1) jumpTo(currentIndex + 1);
    }

    function navPrev() {
        if (currentIndex > 0) jumpTo(currentIndex - 1);
    }

    // Anti-cheating: Submit if tab changed or hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && testViewActive) {
            console.warn("Tab switch detected. Auto-submitting test.");
            completeAssessment();
        }
    });

    async function completeAssessment() {
        if (!testViewActive) return; // Prevent double submission
        testViewActive = false; // New: Set to false immediately to prevent further calls
        
        showView('scene-loading');
        document.getElementById('loading-msg').innerText = "Analyzing your performance...";

        try {
            const res = await fetch(`/grammar/placement-test/${testId}/complete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            if (data.status) {
                displayResults(data.data);
            }
        } catch (e) {
            showView('scene-test');
        }
    }

    function displayResults(data) {
        if (timerId) clearInterval(timerId);
        // document.getElementById('side-nav').classList.add('hidden');
        
        document.getElementById('res-val').innerText = Math.round(data.percentage);
        document.getElementById('res-lvl-label').innerText = `Level ${data.detected_level}`;

        // Recommended Lessons section
        if (data.recommendations && data.recommendations.length > 0) {
            let recHtml = '<h3 style="margin: 2rem 0 1rem; font-size: 1.25rem; font-weight: 700;">Recommended Lessons</h3><div style="display: grid; gap: 1rem;">';
            data.recommendations.forEach(rec => {
                recHtml += `
                    <a href="${rec.url}" class="opt-box" style="text-decoration: none; justify-content: space-between;">
                        <span style="font-weight: 600;">${rec.title}</span>
                        <span class="tag">${rec.level}</span>
                    </a>
                `;
            });
            recHtml += '</div>';
            document.getElementById('recommendations-area').innerHTML = recHtml;
        }

        showView('scene-final');
    }

    function startTimer() {
        if (timerId) clearInterval(timerId);
        const timerText = document.getElementById('timer-text');
        
        timerId = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(timerId);
                timeLeft = 0;
                completeAssessment(); // auto submit
            }

            const m = Math.floor(timeLeft / 60);
            const s = timeLeft % 60;
            timerText.innerText = `${m}:${s.toString().padStart(2, '0')}`;
            
            if (timeLeft < 60) {
                document.getElementById('global-timer').style.background = '#fef2f2';
                timerText.style.color = '#ef4444';
            }
        }, 1000);
    }

    function showView(id) {
        ['scene-intro', 'scene-test', 'scene-final', 'scene-loading'].forEach(v => {
            document.getElementById(v).classList.add('hidden');
        });
        document.getElementById(id).classList.remove('hidden');
    }
</script>
@endsection
