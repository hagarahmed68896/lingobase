@extends('layouts.app')

@section('styles')
<style>
    .auth-container {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: radial-gradient(circle at top right, var(--accent) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(0, 145, 80, 0.05) 0%, transparent 40%);
    }

    .auth-card {
        width: 100%;
        max-width: 420px;
        background: var(--bg-card);
        padding: 3rem 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1), 0 0 20px -5px rgba(0, 145, 80, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(10px);
    }

    /* Dark mode adjustments for auth card */
    body.dark-mode .auth-card {
        border: 1px solid var(--border-color);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5), 0 0 20px -5px rgba(0, 145, 80, 0.1);
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #34d399);
    }

    @keyframes slideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .auth-title {
        color: var(--text-main);
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .input-group {
        position: relative;
        margin-bottom: 1.75rem;
    }

    .input-group input {
        width: 100%;
        padding: 1rem 1.25rem;
        padding-top: 1.5rem;
        border: 2px solid var(--border-color);
        background: var(--bg-body);
        color: var(--text-main);
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .input-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 145, 80, 0.1);
        background: var(--bg-card);
    }

    .input-group label {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        transition: all 0.3s ease;
        pointer-events: none;
        font-size: 1rem;
        background: transparent;
    }

    /* Floating label effects */
    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
        top: 0.6rem;
        font-size: 0.75rem;
        color: var(--primary);
        font-weight: 600;
    }

    body[dir="rtl"] .input-group label {
        left: auto;
        right: 1.25rem;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 145, 80, 0.2), 0 2px 4px -1px rgba(0, 145, 80, 0.1);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 145, 80, 0.3), 0 4px 6px -2px rgba(0, 145, 80, 0.15);
    }

    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px -1px rgba(0, 145, 80, 0.2);
    }

    .btn-submit svg {
        transition: transform 0.3s ease;
    }

    .btn-submit:hover svg {
        transform: translateX(4px);
    }

    body[dir="rtl"] .btn-submit:hover svg {
        transform: translateX(-4px);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .auth-footer a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        position: relative;
        transition: color 0.3s ease;
    }

    .auth-footer a::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: var(--primary);
        transform-origin: bottom right;
        transition: transform 0.3s ease-out;
    }

    .auth-footer a:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    .error-msg {
        color: #ef4444;
        font-size: 0.85rem;
        display: block;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Welcome Back 👋</h2>
            <p class="auth-subtitle">Log in to continue your learning journey.</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="input-group">
                <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus placeholder=" ">
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

            <button type="submit" class="btn-submit">
                Log In
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>

            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Sign up now</a>
            </div>
        </form>
    </div>
</div>
@endsection
