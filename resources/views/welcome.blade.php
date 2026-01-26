@extends('layouts.app')

@section('hero')
<style>
    .bubble-bg {
        background-color: #f9fafb;
        background-image: 
            radial-gradient(circle at 15% 50%, rgba(0, 145, 80, 0.08) 0%, transparent 25%),
            radial-gradient(circle at 85% 30%, rgba(0, 145, 80, 0.08) 0%, transparent 25%);
        background-attachment: fixed;
    }
</style>
<div class="hero-section bubble-bg" style="text-align: center; padding: 6rem 1rem; border-bottom: 1px solid #e5e7eb;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 3.5rem; color: var(--text-main); line-height: 1.1; margin-bottom: 1.5rem; font-weight: 800;">
            {{ __('messages.hero_title') }} <br><span style="color: var(--primary);">{{ __('messages.hero_subtitle') }}</span>
        </h1>
        <p style="font-size: 1.25rem; color: var(--text-light); margin-bottom: 2.5rem; line-height: 1.6;">
            {{ __('messages.hero_description') }}
        </p>
        
        @guest
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem; border-radius: 2rem;">{{ __('messages.get_started') }}</a>
            </div>
        @else
            <a href="{{ route('grammar.index') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem; border-radius: 2rem;">{{ __('messages.continue_learning') }}</a>
        @endguest
    </div>
</div>
@endsection

@section('content')
<div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; padding: 2rem 0;">
    <!-- Feature 1: Grammar -->
    <div class="card" style="display: flex; flex-direction: column; align-items: start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem;">{{ __('messages.grammar_bank') }}</h3>
        <p style="color: var(--text-light); margin: 0;">{{ __('messages.grammar_bank_desc') }}</p>
        <a href="{{ route('grammar.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto;">{{ __('messages.explore_grammar') }} &rarr;</a>
    </div>

    <!-- Feature 2: Stories -->
    <div class="card" style="display: flex; flex-direction: column; align-items: start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: #e0f2fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2-2z"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem;">{{ __('messages.stories') }}</h3>
        <p style="color: var(--text-light); margin: 0;">{{ __('messages.stories_desc') }}</p>
        <a href="{{ route('stories.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto;">{{ __('messages.read_stories') }} &rarr;</a>
    </div>

    <!-- Feature 3: Progress -->
    <div class="card" style="display: flex; flex-direction: column; align-items: start; gap: 1rem;">
        <div style="width: 48px; height: 48px; background: #fef9c3; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ca8a04;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v-6M6 20V10M18 20V4"></path></svg>
        </div>
        <h3 style="margin: 0; font-size: 1.5rem;">{{ __('messages.track_progress') }}</h3>
        <p style="color: var(--text-light); margin: 0;">{{ __('messages.track_progress_desc') }}</p>
        @auth
            <a href="{{ route('profile.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto;">{{ __('messages.view_profile') }} &rarr;</a>
        @else
            <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: auto;">{{ __('messages.start_tracking') }} &rarr;</a>
        @endauth
    </div>
</div>
@endsection
