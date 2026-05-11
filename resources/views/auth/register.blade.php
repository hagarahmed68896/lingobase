@extends('layouts.app')

@section('styles')
<style>
    header, footer {
        display: none !important;
    }

    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .auth-container {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        position: relative;
        transition: background 0.5s ease;
        overflow: hidden;
    }

    /* Theme-specific backgrounds */
    body:not(.dark-mode) .auth-container {
        background-image: url('/images/auth-bg-languages-light.png');
    }
    body.dark-mode .auth-container {
        background-image: url('/images/auth-bg-languages.png');
    }

    .auth-container::before {
        content: '';
        position: absolute;
        inset: 0;
        backdrop-filter: blur(2px);
        z-index: 1;
    }

    body:not(.dark-mode) .auth-container::before {
        background: rgba(255, 255, 255, 0.1);
    }
    body.dark-mode .auth-container::before {
        background: rgba(9, 21, 16, 0.4);
    }

    /* Floating Blurred Hero Accents */
    .hero-blur-bg {
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.4;
        z-index: 2;
        pointer-events: none;
        animation: pulse 10s infinite alternate;
    }

    .hero-blur-1 {
        top: -100px;
        right: -100px;
        background: url('/Gemini_Generated_Image_4b69q14b69q14b69-Picsart-BackgroundRemover (1).png') no-repeat center;
        background-size: contain;
    }

    .hero-blur-2 {
        bottom: -100px;
        left: -100px;
        background: url('/Gemini_Generated_Image_od4g5aod4g5aod4g-Picsart-BackgroundRemover.png') no-repeat center;
        background-size: contain;
    }

    @keyframes pulse {
        0% { transform: scale(1) rotate(0deg); opacity: 0.3; }
        100% { transform: scale(1.2) rotate(10deg); opacity: 0.5; }
    }

    /* Logo & Theme Toggle */
    .auth-nav {
        position: absolute;
        top: 2rem;
        left: 2rem;
        right: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 20;
    }

    .auth-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        font-weight: 900;
        text-decoration: none;
        letter-spacing: -0.04em;
        transition: transform 0.3s;
    }
    .auth-logo:hover { transform: scale(1.05); }

    body:not(.dark-mode) .auth-logo { color: #004d2a; }
    body.dark-mode .auth-logo { color: #f0fcf6; }

    .theme-toggle-btn {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.75rem;
        border-radius: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .theme-toggle-btn:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-2px); }

    body.dark-mode .theme-toggle-btn {
        background: rgba(0, 0, 0, 0.2);
        border-color: rgba(52, 211, 153, 0.2);
    }

    .theme-toggle-btn svg { width: 20px; height: 20px; }
    .sun-icon { display: block; color: #f59e0b; }
    .moon-icon { display: none; color: #94a3b8; }

    body.dark-mode .sun-icon { display: none; }
    body.dark-mode .moon-icon { display: block; color: #34d399; }

    .auth-card {
        width: 100%;
        max-width: 480px;
        padding: 3.5rem 2.5rem;
        border-radius: 2.5rem;
        position: relative;
        overflow: visible;
        animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(30px);
        z-index: 10;
        transition: all 0.5s ease;
    }

    /* Card theme adjustments */
    body:not(.dark-mode) .auth-card {
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(0, 145, 80, 0.15);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
    }
    body.dark-mode .auth-card {
        background: rgba(13, 32, 24, 0.8);
        border: 2px solid rgba(52, 211, 153, 0.2);
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
    }

    .auth-card::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: linear-gradient(135deg, #34d399, #009150);
        border-radius: 2.5rem;
        z-index: -1;
        filter: blur(15px);
        opacity: 0.3;
    }

    @keyframes slideUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .auth-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .auth-title {
        font-size: 2.25rem;
        font-weight: 900;
        margin-bottom: 0.75rem;
        letter-spacing: -0.04em;
    }
    body:not(.dark-mode) .auth-title { color: #004d2a; }
    body.dark-mode .auth-title { 
        color: #f0fcf6; 
        text-shadow: 0 0 10px rgba(52, 211, 153, 0.5);
    }

    .auth-subtitle {
        font-size: 1rem;
        font-weight: 500;
    }
    body:not(.dark-mode) .auth-subtitle { color: #4b5563; }
    body.dark-mode .auth-subtitle { color: #9ca8a2; }

    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-group input {
        width: 100%;
        padding: 1.15rem 1.5rem;
        padding-top: 1.65rem;
        border-radius: 1.25rem;
        font-size: 1rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
    }

    body:not(.dark-mode) .input-group input {
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid #e5e7eb;
        color: #111827;
    }
    body.dark-mode .input-group input {
        background: rgba(0, 0, 0, 0.3);
        border: 2px solid rgba(52, 211, 153, 0.1);
        color: white;
    }

    .input-group input:focus {
        outline: none;
        border-color: #34d399;
        transform: translateY(-2px);
    }
    body:not(.dark-mode) .input-group input:focus {
        box-shadow: 0 0 20px rgba(0, 145, 80, 0.05);
        background: white;
    }
    body.dark-mode .input-group input:focus {
        box-shadow: 0 0 20px rgba(52, 211, 153, 0.2);
        background: rgba(0, 0, 0, 0.5);
    }

    .input-group label {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
        pointer-events: none;
        font-size: 1rem;
        font-weight: 500;
    }
    body:not(.dark-mode) .input-group label { color: #6b7280; }
    body.dark-mode .input-group label { color: rgba(156, 168, 162, 0.6); }

    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
        top: 0.75rem;
        font-size: 0.75rem;
        color: #34d399;
        font-weight: 700;
    }

    .btn-submit {
        width: 100%;
        padding: 1.1rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #34d399, #009150);
        color: #091510;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 20px rgba(0, 145, 80, 0.3);
        margin-top: 1.5rem;
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0, 145, 80, 0.4);
        filter: brightness(1.1);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 1rem;
    }
    body:not(.dark-mode) .auth-footer { color: #4b5563; }
    body.dark-mode .auth-footer { color: #9ca8a2; }

    .auth-footer a {
        color: #34d399;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
    }

    .auth-footer a:hover {
        color: var(--primary);
        text-shadow: 0 0 10px rgba(52, 211, 153, 0.4);
    }

    .error-msg {
        color: #ff4b4b;
        font-size: 0.85rem;
        margin-top: 0.4rem;
        padding-left: 0.5rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <!-- Blurred Background Accents -->
    <div class="hero-blur-bg hero-blur-1"></div>
    <div class="hero-blur-bg hero-blur-2"></div>

    <!-- Auth Navigation -->
    <div class="auth-nav">
        <a href="/" class="auth-logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            LingoBase
        </a>

        <button id="auth-theme-toggle" class="theme-toggle-btn" title="Toggle Theme">
            <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="18.36" x2="5.64" y2="16.93"></line>
                <line x1="18.36" y1="4.22" x2="19.78" y2="5.64"></line>
            </svg>
            <svg class="moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </button>
    </div>

    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Create Account </h2>
            <p class="auth-subtitle">Join us and start learning today.</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="input-group">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder=" ">
                <label for="name">Full Name</label>
                @error('name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required placeholder=" ">
                <label for="email">Email Address</label>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input id="password" type="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group" style="margin-bottom: 0;">
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder=" ">
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <button type="submit" class="btn-submit">
                Create Account
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
            
            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('auth-theme-toggle');
        const body = document.body;

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Optional: Dispatch event if other components listen for theme changes
            window.dispatchEvent(new Event('themeChanged'));
        });
    });
</script>
@endsection
