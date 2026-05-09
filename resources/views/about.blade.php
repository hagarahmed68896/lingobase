@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
    
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem;">
            {{ __('messages.about_lingobase') }}
        </h1>
        <p style="font-size: 1.15rem; color: var(--text-muted); line-height: 1.6; max-width: 600px; margin: 0 auto;">
            {{ __('messages.brand_description') }}
        </p>
    </div>

    <div class="card" style="padding: 2.5rem; margin-bottom: 3rem; text-align: center;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary); margin-bottom: 1.5rem;">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">
            Our Mission
        </h2>
        <p style="font-size: 1.05rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 2rem;">
            At LingoBase, we believe that mastering a language should be engaging, structured, and accessible. Our platform is designed to combine the essential foundations of grammar with the immersive experience of reading stories tailored to your specific level. Whether you are a beginner taking your first steps or an advanced learner looking to polish your skills, we provide the tools you need to succeed.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; text-align: left; margin-top: 2rem;">
            <div style="background: var(--bg-body); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <div style="font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; font-size: 1.1rem;">Interactive Learning</div>
                <div style="color: var(--text-muted); font-size: 0.95rem;">Test your knowledge immediately after every lesson with integrated quizzes.</div>
            </div>
            <div style="background: var(--bg-body); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <div style="font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; font-size: 1.1rem;">Contextual Reading</div>
                <div style="color: var(--text-muted); font-size: 0.95rem;">See vocabulary and grammar rules applied naturally in engaging stories.</div>
            </div>
            <div style="background: var(--bg-body); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <div style="font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; font-size: 1.1rem;">Progress Tracking</div>
                <div style="color: var(--text-muted); font-size: 0.95rem;">Save your favorite lessons and watch your proficiency grow over time.</div>
            </div>
        </div>
    </div>

    <!-- Separate Action Button Section -->
    <div style="text-align: center; padding: 2rem; background: var(--accent); border-radius: 1.5rem; border: 1px dashed var(--primary);">
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">
            Ready to dive in?
        </h3>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Start your learning journey today by exploring our completely free resources.
        </p>
        <a href="{{ route('grammar.index', ['language' => 'english']) }}" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2.5rem; border-radius: 2rem; box-shadow: 0 4px 14px rgba(0, 145, 80, 0.3);">
            {{ __('messages.get_started') }} &rarr;
        </a>
    </div>

</div>
@endsection
