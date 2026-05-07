@extends('layouts.app')

@section('hero')
<div class="bubble-bg" style="padding: 6rem 2rem; background: var(--bg-body); text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 3rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem;">How can we <span style="color: var(--primary);">help you?</span></h1>
        <p style="font-size: 1.25rem; color: var(--text-muted); line-height: 1.7;">Browse our frequently asked questions or get in touch with our support team.</p>
    </div>
</div>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding-top: 4rem;">
    <!-- Simple FAQ -->
    <div style="margin-bottom: 6rem;">
        <h2 style="font-size: 2rem; font-weight: 800; color: var(--text-main); margin-bottom: 2.5rem; text-align: center;">Frequently Asked Questions</h2>
        <div style="display: grid; gap: 1.5rem;">
            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.75rem;">How do I determine my English level?</h3>
                <p style="color: var(--text-muted); margin: 0;">You can take our adaptive Placement Test from the dashboard or your profile. It takes about 30 minutes and evaluates your grammar, vocabulary, listening, and reading skills.</p>
            </div>
            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 0.75rem;">Can I retake the placement test?</h3>
                <p style="color: #64748b; margin: 0;">Yes, you can retake the assessment every 24 hours to track your progress as you learn.</p>
            </div>
            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 0.75rem;">Are the stories appropriate for my level?</h3>
                <p style="color: #64748b; margin: 0;">Our stories are categorized by CEFR levels (A1-C1). After taking the placement test, we'll recommend content that matches your current proficiency.</p>
            </div>
        </div>
    </div>

    <!-- Contact Form (Relocated) -->
    <div id="contact-team" style="padding: 6rem 3rem; background: var(--bg-card); border-radius: 2.5rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); display: grid; grid-template-columns: 1fr 1.5fr; gap: 5rem; align-items: start;">
        <div>
            <h2 style="font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem;">Still need <br><span style="color: var(--primary);">support?</span></h2>
            <p style="color: var(--text-muted); line-height: 1.7; font-size: 1.1rem; margin-bottom: 3rem;">Our team is ready to help you with any technical issues or learning questions.</p>
            
            <div style="display: flex; gap: 1.25rem; align-items: center;">
                <div style="width: 52px; height: 52px; background: var(--accent); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div>
                    <div style="font-weight: 700; color: var(--text-main);">Email Us</div>
                    <div style="color: var(--text-muted);">hagarahmed00999@gmail.com</div>
                </div>
            </div>
        </div>

        <div>
            @if(session('success'))
                <div style="background: #009150; color: white; padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 0.75rem; color: var(--text-main);">Your Name</label>
                        <input type="text" name="name" required style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--border-color); background: var(--bg-body); color: var(--text-main); border-radius: 1rem; font-size: 1rem; transition: all 0.2s;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='var(--bg-card)';" placeholder="John Doe">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 0.75rem; color: var(--text-main);">Email Address</label>
                        <input type="email" name="email" required style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--border-color); background: var(--bg-body); color: var(--text-main); border-radius: 1rem; font-size: 1rem; transition: all 0.2s;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='var(--bg-card)';" placeholder="john@example.com">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 0.75rem; color: var(--text-main);">Your Message</label>
                        <textarea name="message" required rows="4" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--border-color); background: var(--bg-body); color: var(--text-main); border-radius: 1rem; font-size: 1rem; transition: all 0.2s; resize: none;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='var(--bg-card)';" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" style="background: var(--primary); color: white; padding: 1.25rem; border-radius: 1rem; font-weight: 700; font-size: 1.1rem; border: none; cursor: pointer; transition: all 0.2s; margin-top: 1rem;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 968px) {
        #contact-team { grid-template-columns: 1fr; padding: 3rem 1.5rem; gap: 3rem; }
    }
</style>
@endsection
