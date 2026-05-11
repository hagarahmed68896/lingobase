@extends('layouts.app')

@section('hero')
<style>
    .bubble-bg {
        background-color: transparent;
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
                    <a href="{{ route('grammar.placement', ['language' => 'en']) }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--bg-card); color: var(--primary); border: 2px solid var(--border-color); font-weight: 700;">Evaluate your Language Now</a>
                @else
                    <a href="{{ route('grammar.index') }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--primary); color: white; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(0, 145, 80, 0.3);">{{ __('messages.continue_learning') }}</a>
                    <a href="{{ route('grammar.placement', ['language' => 'en']) }}" class="btn" style="padding: 1.15rem 2.5rem; font-size: 1.1rem; border-radius: 3rem; background: var(--bg-card); color: var(--primary); border: 2px solid var(--border-color); font-weight: 700;">Re-evaluate your Language Now</a>
                @endguest
            </div>
        </div>

        <div class="hero-visual" style="position: relative; text-align: center; display: flex; justify-content: center;">
            <!-- Light Mode Image -->
            <img src="{{ asset('Gemini_Generated_Image_4b69q14b69q14b69-Picsart-BackgroundRemover (1).png') }}" alt="LingoBase Illustration Light" class="hero-img-light" style="max-width: 500px; width: 100%; height: auto; border-radius: 2rem; animation: float 6s ease-in-out infinite;">
            
            <!-- Dark Mode Image -->
            <img src="{{ asset('Gemini_Generated_Image_od4g5aod4g5aod4g-Picsart-BackgroundRemover.png') }}" alt="LingoBase Illustration Dark" class="hero-img-dark" style="max-width: 500px; width: 100%; height: auto; border-radius: 2rem; animation: float 6s ease-in-out infinite; display: none;">
        </div>
    </div>
</div>

<style>
    /* Theme toggling for hero images */
    body.dark-mode .hero-img-light { display: none !important; }
    body.dark-mode .hero-img-dark { display: block !important; }

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

{{-- Free Resources by Language --}}
<div style="margin-top: 4rem; padding-top: 3rem; border-top: 1px solid var(--border-color);">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <h2 style="font-size: 2rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.75rem;">Free Resources</h2>
        <p style="color: var(--text-muted); font-size: 1.05rem;">Choose a language and start learning today — completely free.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

        {{-- English Card --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 2rem; display: flex; flex-direction: column; gap: 1.25rem; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(0,145,80,0.12)'" onmouseout="this.style.boxShadow='none'">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 2.5rem;">🇬🇧</span>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--text-main);">English</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Grammar · Stories · Placement Test</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('grammar.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-main); text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: var(--bg-body); border: 1px solid var(--border-color); font-weight: 600; font-size: 0.9rem; transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Grammar Bank
                </a>
                <a href="{{ route('stories.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-main); text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: var(--bg-body); border: 1px solid var(--border-color); font-weight: 600; font-size: 0.9rem; transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2-2z"/></svg>
                    Reading Stories
                </a>
                <a href="{{ route('grammar.placement', ['language' => 'english']) }}" style="display: flex; align-items: center; gap: 0.5rem; color: white; text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: var(--primary); font-weight: 700; font-size: 0.9rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Placement Test
                </a>
            </div>
        </div>

        {{-- Spanish Card --}}
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 2rem; display: flex; flex-direction: column; gap: 1.25rem; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(220,38,38,0.1)'" onmouseout="this.style.boxShadow='none'">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 2.5rem;">🇪🇸</span>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--text-main);">Spanish</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Gramática · Historias · Examen de Nivel</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('grammar.index', ['language' => 'spanish']) }}" style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-main); text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: var(--bg-body); border: 1px solid var(--border-color); font-weight: 600; font-size: 0.9rem; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#dc2626'" onmouseout="this.style.borderColor='var(--border-color)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Banco de Gramática
                </a>
                <a href="{{ route('stories.index', ['language' => 'spanish']) }}" style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-main); text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: var(--bg-body); border: 1px solid var(--border-color); font-weight: 600; font-size: 0.9rem; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#dc2626'" onmouseout="this.style.borderColor='var(--border-color)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2-2z"/></svg>
                    Historias de Lectura
                </a>
                <a href="{{ route('grammar.placement', ['language' => 'spanish']) }}" style="display: flex; align-items: center; gap: 0.5rem; color: white; text-decoration: none; padding: 0.6rem 0.9rem; border-radius: 0.75rem; background: #dc2626; font-weight: 700; font-size: 0.9rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Examen de Nivel
                </a>
            </div>
        </div>

    </div>
</div>
{{-- Reviews / Testimonials Section --}}
<div style="margin-top: 5rem; padding-top: 4rem; border-top: 1px solid var(--border-color); padding-bottom: 2rem;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem;">Testimonials</span>
        <h2 style="font-size: 2.25rem; font-weight: 800; color: var(--text-main); margin-top: 0.5rem; margin-bottom: 1rem;">What Our Learners Say</h2>
        <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Discover how LingoBase has helped thousands of students achieve fluency with our modern approach.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Review 1 -->
        <div class="review-card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 2rem; position: relative; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px -10px rgba(0, 145, 80, 0.12)'; this.style.borderColor='var(--primary)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'; this.style.borderColor='var(--border-color)';">
            <div style="position: absolute; top: -15px; right: 2rem; background: var(--primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            <div style="display: flex; gap: 0.25rem; color: #fbbf24; margin-bottom: 1.25rem;">
                @for($i=0; $i<5; $i++)
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p style="color: var(--text-main); font-size: 1.05rem; line-height: 1.6; margin-bottom: 2rem; font-style: italic;">"The placement test was incredibly accurate. LingoBase helped me identify my weak points, and the grammar bank explanations are so clear!"</p>
            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <img src="https://ui-avatars.com/api/?name=Sarah+M&background=009150&color=fff&rounded=true" alt="Sarah M." style="width: 48px; height: 48px; border-radius: 50%;">
                <div>
                    <div style="font-weight: 700; color: var(--text-main);">Sarah M.</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Learning English</div>
                </div>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="review-card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 2rem; position: relative; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px -10px rgba(0, 145, 80, 0.12)'; this.style.borderColor='var(--primary)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'; this.style.borderColor='var(--border-color)';">
            <div style="position: absolute; top: -15px; right: 2rem; background: var(--primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            <div style="display: flex; gap: 0.25rem; color: #fbbf24; margin-bottom: 1.25rem;">
                @for($i=0; $i<5; $i++)
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p style="color: var(--text-main); font-size: 1.05rem; line-height: 1.6; margin-bottom: 2rem; font-style: italic;">"Learning Spanish has never been easier. The UI is smooth, the stories are engaging, and I actually enjoy studying now!"</p>
            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <img src="https://ui-avatars.com/api/?name=Ahmed+K&background=009150&color=fff&rounded=true" alt="Ahmed K." style="width: 48px; height: 48px; border-radius: 50%;">
                <div>
                    <div style="font-weight: 700; color: var(--text-main);">Ahmed K.</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Learning Spanish</div>
                </div>
            </div>
        </div>

        <!-- Review 3 -->
        <div class="review-card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 2rem; position: relative; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px -10px rgba(0, 145, 80, 0.12)'; this.style.borderColor='var(--primary)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'; this.style.borderColor='var(--border-color)';">
            <div style="position: absolute; top: -15px; right: 2rem; background: var(--primary); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            <div style="display: flex; gap: 0.25rem; color: #fbbf24; margin-bottom: 1.25rem;">
                @for($i=0; $i<5; $i++)
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p style="color: var(--text-main); font-size: 1.05rem; line-height: 1.6; margin-bottom: 2rem; font-style: italic;">"The best free resource out there! The design is stunning and the user experience feels premium. Tracking my progress is so motivating."</p>
            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <img src="https://ui-avatars.com/api/?name=Lina+A&background=009150&color=fff&rounded=true" alt="Lina A." style="width: 48px; height: 48px; border-radius: 50%;">
                <div>
                    <div style="font-weight: 700; color: var(--text-main);">Lina A.</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Learning English</div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('scripts')
<script>
    // Any extra scripts
</script>
@endpush
