@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 4rem auto; background: var(--bg-card); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
    <h2 style="text-align: center; color: var(--text-main); margin-bottom: 2rem;">Welcome Back</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--text-main); font-weight: 500;">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box;">
            @error('email')
                <span style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 2rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem; color: var(--text-main); font-weight: 500;">Password</label>
            <input id="password" type="password" name="password" required
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); background: var(--bg-body); color: var(--text-main); border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box;">
            @error('password')
                <span style="color: #ef4444; font-size: 0.875rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; justify-content: center;">
            Log In
        </button>

        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-muted);">Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Sign up</a></p>
        </div>
    </form>
</div>
@endsection
