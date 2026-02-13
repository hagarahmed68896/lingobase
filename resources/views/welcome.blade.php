@extends('layouts.app')

@section('hero')
<style>
    .bubble-bg {
        background-color: var(--bg-body);
        background-image: 
            radial-gradient(circle at 15% 50%, rgba(0, 145, 80, 0.05) 0%, transparent 25%),
            radial-gradient(circle at 85% 30%, rgba(0, 145, 80, 0.05) 0%, transparent 25%);
        background-attachment: fixed;
    }
</style>
<div class="hero-section bubble-bg" style="padding: 6rem 2rem; overflow: hidden; position: relative;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1.2fr 1fr; gap: 4rem; align-items: center; text-align: start;">
        <div class="hero-text-content">
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); color: var(--text-main); line-height: 1.1; margin-bottom: 2rem; font-weight: 800; letter-spacing: -0.04em;">
                {{ __('messages.hero_title') }} <br>
                <span style="color: var(--primary); position: relative;">
                    {{ __('messages.hero_subtitle') }}
                    <svg style="position: absolute; bottom: -8px; inset-inline-start: 0; width: 100%; height: 12px; {{ app()->getLocale() == 'ar' ? 'transform: scaleX(-1);' : '' }}" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 80 Q 50 100 100 80" stroke="var(--primary)" stroke-width="8" fill="none" opacity="0.2"/></svg>
                </span>
            </h1>
            <p style="font-size: 1.35rem; color: var(--text-muted); margin-bottom: 3.5rem; line-height: 1.7; max-width: 540px; font-weight: 450;">
                {{ __('messages.hero_description') }}
            </p>
            
            <div style="display: flex; gap: 1.25rem; flex-wrap: wrap;">
                @guest
                    <a href="{{ route('register') }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--primary); color: white; display: flex; align-items: center; gap: 0.75rem; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(0, 145, 80, 0.3);">
                        {{ __('messages.get_started') }}
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('grammar.placement') }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--bg-card); color: var(--primary); border: 2px solid var(--border-color); font-weight: 700;">Take Placement Test</a>
                @else
                    <a href="{{ route('grammar.index') }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--primary); color: white; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(0, 145, 80, 0.3);">{{ __('messages.continue_learning') }}</a>
                    <a href="{{ route('grammar.placement') }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--bg-card); color: var(--primary); border: 2px solid var(--border-color); font-weight: 700;">Retake Placement Test</a>
                @endguest
            </div>
        </div>

        <div class="hero-visual" style="position: relative;">
            <div style="position: absolute; inset: -20px; background: radial-gradient(circle, var(--accent) 0%, transparent 70%); border-radius: 50%; z-index: -1;"></div>
            <img src="{{ asset('images/hero_illustration.png') }}" alt="Master English Illustration" style="width: 100%; border-radius: 2rem; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.1)); animation: float 6s ease-in-out infinite;">
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .hero-visual img { transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .hero-visual:hover img { transform: scale(1.02) rotate(1deg); }
    
    @media (max-width: 968px) {
        .hero-section > div { grid-template-columns: 1fr !important; text-align: center !important; gap: 3rem !important; }
        .hero-text-content p { margin-left: auto; margin-right: auto; }
        .hero-text-content div { justify-content: center; }
        .hero-visual { order: -1; max-width: 500px; margin: 0 auto; }
    }
</style>
@endsection

@section('content')
<div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; padding: 2rem 0;">
    <!-- Feature 1: Grammar -->
    <div class="card" style="display: flex; flex-direction: column; align-items: flex-start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem; color: var(--text-main);">{{ __('messages.grammar_bank') }}</h3>
        <p style="color: var(--text-muted); margin: 0;">{{ __('messages.grammar_bank_desc') }}</p>
        <a href="{{ route('grammar.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto; display: flex; align-items: center; gap: 0.5rem;">{{ __('messages.explore_grammar') }} <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>

    <!-- Feature 2: Stories -->
    <div class="card" style="display: flex; flex-direction: column; align-items: flex-start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: #e0f2fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2-2z"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem;">{{ __('messages.stories') }}</h3>
        <p style="color: var(--text-light); margin: 0;">{{ __('messages.stories_desc') }}</p>
        <a href="{{ route('stories.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto; display: flex; align-items: center; gap: 0.5rem;">{{ __('messages.read_stories') }} <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>

    <!-- Feature 3: Progress -->
    <div class="card" style="display: flex; flex-direction: column; align-items: flex-start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: #fef9c3; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ca8a04;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v-6M6 20V10M18 20V4"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem;">{{ __('messages.track_progress') }}</h3>
        <p style="color: var(--text-light); margin: 0;">{{ __('messages.track_progress_desc') }}</p>
        @auth
            <a href="{{ route('profile.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto; display: flex; align-items: center; gap: 0.5rem;">{{ __('messages.view_profile') }} <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        @else
            <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto; display: flex; align-items: center; gap: 0.5rem;">{{ __('messages.start_tracking') }} <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        @endauth
    </div>
</div>

@endsection
@push('scripts')
<script>
    // Any extra scripts
</script>
@endpush
