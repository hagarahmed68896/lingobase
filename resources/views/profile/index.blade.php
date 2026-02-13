@extends('layouts.app')

@section('styles')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Sidebar */
    .sidebar {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        overflow: hidden;
        height: fit-content;
    }
    .sidebar-user {
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-body);
    }
    .user-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #009150 0%, #006b3a 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .sidebar-nav {
        padding: 0.5rem;
    }
    .nav-btn {
        width: 100%;
        text-align: start;
        padding: 0.75rem 1rem;
        margin-bottom: 0.25rem;
        border-radius: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
        background: transparent;
    }
    .nav-btn:hover {
        background: var(--accent);
        color: var(--text-main);
    }
    .nav-btn.active {
        background: var(--accent);
        color: var(--primary);
    }

    /* Main Content */
    .content-area {
        background: transparent;
        border: none;
        padding: 0;
        min-height: 500px;
    }
    .section-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Card Styling */
    .profile-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 1.25rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .profile-card:hover {
        box-shadow: var(--shadow-md);
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.25rem;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-main);
    }
    .card-icon {
        width: 40px;
        height: 40px;
        background: var(--accent);
        color: var(--primary);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.6rem;
        color: var(--text-main);
        font-size: 0.95rem;
    }
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--border-color);
        background: var(--bg-body);
        color: var(--text-main);
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 145, 80, 0.1);
        background: var(--bg-card);
    }
    .btn-save {
        background: var(--primary);
        color: white;
        padding: 0.875rem 2.5rem;
        border-radius: 0.75rem;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 145, 80, 0.2);
    }
    .btn-save:hover {
        background: #007a43;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 145, 80, 0.3);
    }

    /* Custom Checkbox/Switch */
    .switch-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: var(--bg-body);
        border-radius: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider { background-color: var(--primary); }
    input:focus + .slider { box-shadow: 0 0 1px var(--primary); }
    input:checked + .slider:before { transform: translateX(24px); }
    [dir="rtl"] .slider:before {
        left: auto;
        right: 4px;
    }
    [dir="rtl"] input:checked + .slider:before {
        transform: translateX(-24px);
    }

    /* Favorites Tabs */
    .fav-tabs {
        display: flex;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }
    .fav-tab {
        padding: 1rem 1.5rem;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        color: var(--text-muted);
        font-weight: 600;
        transition: all 0.2s;
    }
    .fav-tab:hover {
        color: var(--primary);
        background: var(--accent);
    }
    .fav-tab.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .item-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
    }
    .item-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    .item-tag {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.3rem 0.75rem;
        border-radius: 2rem;
        background: var(--accent);
        color: var(--primary);
        margin-bottom: 1rem;
        display: inline-block;
    }

    .hidden { display: none; }

    /* Avatar Modal */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        animation: fadeIn 0.2s ease-out;
    }
    .modal-backdrop.active { display: flex; }
    
    .avatar-modal {
        background: var(--bg-card);
        border-radius: 1.5rem;
        width: 100%;
        max-width: 400px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95);
        transition: transform 0.2s ease-out;
        border: 1px solid var(--border-color);
    }
    .modal-backdrop.active .avatar-modal { transform: scale(1); }
    
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title { font-weight: 700; font-size: 1.1rem; color: var(--text-main); margin: 0; }
    .close-modal { background: none; border: none; cursor: pointer; color: #9ca3af; transition: color 0.1s; }
    .close-modal:hover { color: #4b5563; }
    
    .modal-content-p { padding: 2rem; text-align: center; }
    .preview-avatar-large {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 2rem;
        border: 4px solid var(--border-color);
        background: linear-gradient(135deg, #009150 0%, #006b3a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
        font-weight: 700;
    }
    
    .modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding: 0 1.5rem 1.5rem;
    }
    .modal-btn {
        padding: 0.75rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid var(--border-color);
        background: var(--bg-body);
        color: var(--text-main);
    }
    .modal-btn:hover { background: var(--bg-card); border-color: var(--primary); }
    .modal-btn.danger { color: #ef4444; border-color: #fecaca; }
    .modal-btn.danger:hover { background: #fef2f2; }
    .modal-btn.primary { background: var(--primary); color: white; border-color: var(--primary); }
    .modal-btn.primary:hover { background: #007a43; }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1rem;
        }

        .sidebar {
            position: sticky;
            top: 1rem;
            z-index: 10;
        }

        .sidebar-nav {
            display: flex;
            overflow-x: auto;
            padding: 0.5rem;
            gap: 0.5rem;
        }

        .nav-btn {
            white-space: nowrap;
            flex-shrink: 0;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .nav-btn svg {
            display: none;
        }

        .content-area {
            padding: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .grid-2 {
            grid-template-columns: 1fr !important;
        }

        .cards-grid {
            grid-template-columns: 1fr !important;
        }

        .fav-tabs {
            flex-wrap: wrap;
        }

        .fav-tab {
            flex: 1;
            text-align: center;
            min-width: 120px;
        }

        .modal-backdrop {
            padding: 0.5rem;
        }

        .avatar-modal {
            max-width: 100%;
        }

        .modal-content-p {
            padding: 1.5rem;
        }

        .preview-avatar-large {
            width: 120px;
            height: 120px;
            font-size: 3rem;
        }
    }

    @media (max-width: 480px) {
        .profile-container {
            padding: 0.5rem;
        }

        .content-area {
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .sidebar {
            border-radius: 0.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .form-control {
            font-size: 16px; /* Prevents zoom on iOS */
        }

        .btn-save {
            width: 100%;
            padding: 1rem;
        }

        .modal-actions {
            grid-template-columns: 1fr;
        }

        .modal-btn {
            width: 100%;
        }

        .preview-avatar-large {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
    }

</style>
@endsection

@section('content')
<div class="profile-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-user">
            <div style="position: relative; width: 80px; margin: 0 auto 1rem;">
                <div class="user-avatar" onclick="openAvatarModal()" style="cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <button onclick="openAvatarModal()" style="position: absolute; bottom: 0; inset-inline-end: 0; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-main); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
            </div>
            <h3 style="margin: 0; font-size: 1.1rem;">{{ $user->name }}</h3>
            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">{{ $user->email }}</p>
        </div>
        <div class="sidebar-nav">
            <button onclick="switchSection('personal')" id="nav-personal" class="nav-btn active">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Profile Settings
            </button>
            <button onclick="switchSection('favorites')" id="nav-favorites" class="nav-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                {{ __('messages.my_favorites') }}
            </button>
            <button onclick="switchSection('progress')" id="nav-progress" class="nav-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10"></path><path d="M18 20V4"></path><path d="M6 20v-4"></path></svg>
                {{ __('messages.my_progress') }}
            </button>
            <button onclick="switchSection('settings')" id="nav-settings" class="nav-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                {{ __('messages.settings') }}
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-area">
        @if(session('success'))
            <div style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #10b981;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #ef4444;">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Personal Info Section -->
        <div id="section-personal">
            <h2 class="section-title">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Profile Settings
            </h2>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Account Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.account_details') }}</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">{{ __('messages.full_name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">{{ __('messages.email_address') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.contact_information') }}</h3>
                    </div>
                    
                    <div class="form-group" style="max-width: 400px;">
                        <label class="form-label">{{ __('messages.phone_number') }}</label>
                        <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+1234567890">
                    </div>
                </div>

                <!-- Security Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.security_password') }}</h3>
                    </div>
                    
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('messages.leave_blank_password') }}</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">{{ __('messages.new_password') }}</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">{{ __('messages.confirm_password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div style="text-align: end; margin-top: 1rem;">
                    <button type="submit" class="btn-save">
                        {{ __('messages.update_profile') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Favorites Section -->
        <div id="section-favorites" class="hidden">
            <h2 class="section-title">{{ __('messages.my_favorites') }}</h2>
            
            <div class="fav-tabs">
                <div onclick="switchFavTab('lessons')" id="tab-lessons" class="fav-tab active">{{ __('messages.grammar_lessons') }}</div>
                <div onclick="switchFavTab('stories')" id="tab-stories" class="fav-tab">{{ __('messages.stories') }}</div>
            </div>

            <!-- Lessons Grid -->
            <div id="content-lessons">
                @if(isset($favLessons) && count($favLessons) > 0)
                    <div class="cards-grid">
                        @foreach($favLessons as $fav)
                            @php $lesson = $fav->favoritable; @endphp
                            @if($lesson)
                            <div class="item-card" style="position: relative;">
                                <button onclick="toggleFavorite('grammar_lesson', {{ $lesson->id }}, this)" style="position: absolute; top: 1rem; inset-inline-end: 1rem; background: none; border: none; cursor: pointer; color: #ef4444; z-index: 10;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                                <a href="{{ route('grammar.lesson', ['language' => $lesson->grammarLevel->language->slug, 'level' => $lesson->grammarLevel->slug, 'lesson' => $lesson->slug]) }}" style="text-decoration: none; color: inherit; display: block;">
                                    <span class="item-tag">Grammar</span>
                                    <h4 style="margin: 0 0 0.5rem 0;">{{ $lesson->title }}</h4>
                                    <div style="color: #6b7280; font-size: 0.9rem;">Master this essential grammar rule.</div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; color: #6b7280; padding: 2rem;">
                        {{ __('messages.no_fav_lessons') }}
                    </div>
                @endif
            </div>

            <!-- Stories Grid -->
            <div id="content-stories" class="hidden">
                @if(isset($favStories) && count($favStories) > 0)
                    <div class="cards-grid">
                        @foreach($favStories as $fav)
                            @php $story = $fav->favoritable; @endphp
                            @if($story)
                            <div class="item-card" style="position: relative;">
                                <button onclick="toggleFavorite('story', {{ $story->id }}, this)" style="position: absolute; top: 1rem; inset-inline-end: 1rem; background: none; border: none; cursor: pointer; color: #ef4444; z-index: 10;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                                <a href="{{ route('stories.show', ['language' => $story->storyLevel->language->slug, 'level' => $story->storyLevel->slug, 'story' => $story->slug]) }}" style="text-decoration: none; color: inherit; display: block;">
                                    <span class="item-tag">Story</span>
                                    <h4 style="margin: 0 0 0.5rem 0;">{{ $story->title }}</h4>
                                    <div style="color: #6b7280; font-size: 0.9rem;">Read this engaging story.</div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; color: #6b7280; padding: 2rem;">
                        {{ __('messages.no_fav_stories') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Progress Section -->
        <div id="section-progress" class="hidden">
            <h2 class="section-title">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20V10"></path><path d="M18 20V4"></path><path d="M6 20v-4"></path></svg>
                {{ __('messages.my_progress') }}
            </h2>
            
            <div class="profile-card">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: var(--text-main);">{{ __('messages.placement_test_status') }}</h3>
                        <p style="margin: 0.25rem 0 0 0; color: var(--text-muted); font-size: 0.95rem;">Determined based on your latest activity</p>
                    </div>
                    @if($latestPlacementTest)
                        <div style="text-align: end;">
                            <span style="background: var(--primary); color: white; padding: 0.5rem 1.25rem; border-radius: 2rem; font-weight: 700; font-size: 0.85rem; display: inline-block;">
                                {{ __('messages.active_level') }}
                            </span>
                            <div style="color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem;">{{ __('messages.updated_at') }} {{ $latestPlacementTest->updated_at->diffForHumans() }}</div>
                        </div>
                    @endif
                </div>

                @if($latestPlacementTest)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 3rem; align-items: start;">
                        <!-- Level Circle -->
                        <div style="text-align: center;">
                            <div style="width: 180px; height: 180px; border-radius: 50%; border: 10px solid var(--accent); display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 0 auto 1.5rem; background: var(--bg-card); box-shadow: inset 0 2px 10px rgba(0,0,0,0.05);">
                                <div style="font-size: 1rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: -0.25rem;">{{ __('messages.level') }}</div>
                                <div style="font-size: 4rem; font-weight: 900; color: var(--primary); line-height: 1;">{{ $latestPlacementTest->detected_level }}</div>
                            </div>
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">{{ __('messages.overall_score') }}: {{ round($latestPlacementTest->percentage) }}%</div>
                            <a href="{{ route('grammar.placement') }}" style="display: inline-block; margin-top: 1.5rem; color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.9rem; border-bottom: 2px solid var(--primary);">{{ __('messages.retake_assessment') }} &rarr;</a>
                        </div>

                        <!-- Recommendations -->
                        <div>
                            <h4 style="margin: 0 0 1.5rem 0; font-size: 1.1rem; font-weight: 800; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.5rem;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--primary);"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                {{ __('messages.recommended_steps') }}
                            </h4>
                            
                            @if(isset($recommendations) && count($recommendations) > 0)
                                <div style="display: grid; gap: 1rem;">
                                    @foreach($recommendations as $rec)
                                        <a href="{{ route('grammar.lesson', ['language' => $rec->grammarLevel->language->slug, 'level' => $rec->grammarLevel->slug, 'lesson' => $rec->slug]) }}" 
                                           style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; background: var(--bg-body); border: 1px solid var(--border-color); border-radius: 1rem; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.borderColor='var(--primary)'; this.style.background='var(--bg-card)'; this.style.transform='translateX(4px)'"
                                           onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='var(--bg-body)'; this.style.transform='none'">
                                            <div>
                                                <div style="font-weight: 700; color: var(--text-main); font-size: 1.05rem;">{{ $rec->title }}</div>
                                                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.25rem;">Grammar Lesson • {{ $latestPlacementTest->detected_level }}</div>
                                            </div>
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--text-muted);"><path d="M9 18l6-6-6-6"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #64748b; font-style: italic;">Complete more lessons to see personalized suggestions here.</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem 1rem;">
                        <div style="width: 80px; height: 80px; background: var(--bg-body); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M12 20V10"></path><path d="M18 20V4"></path><path d="M6 20v-4"></path></svg>
                        </div>
                        <h4 style="margin: 0 0 0.75rem 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">{{ __('messages.no_assessment_data') }}</h4>
                        <p style="color: var(--text-muted); margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">{{ __('messages.no_assessment_desc') }}</p>
                        <a href="{{ route('grammar.placement') }}" class="btn-save" style="display: inline-block; text-decoration: none; border-radius: 2rem; padding: 1rem 2.5rem;">{{ __('messages.start_placement_test') }}</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Settings Section -->
        <div id="section-settings" class="hidden">
            <h2 class="section-title">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                {{ __('messages.settings') }}
            </h2>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Appearance Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.appearance') }}</h3>
                    </div>
                    
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">{{ __('messages.appearance_desc') }}</p>
                    
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button type="button" onclick="setGlobalTheme('light')" class="theme-choice-btn" id="theme-btn-light">
                            <div style="width: 100%; height: 60px; background: #f9fafb; border-radius: 0.75rem; margin-bottom: 0.5rem; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 40px; height: 10px; background: #e5e7eb; border-radius: 1rem;"></div>
                            </div>
                            <span style="font-weight: 600; font-size: 0.9rem;">{{ __('messages.light_mode') }}</span>
                        </button>
                        
                        <button type="button" onclick="setGlobalTheme('dark')" class="theme-choice-btn" id="theme-btn-dark">
                            <div style="width: 100%; height: 60px; background: #0f172a; border-radius: 0.75rem; margin-bottom: 0.5rem; border: 1px solid #334155; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 40px; height: 10px; background: #334155; border-radius: 1rem;"></div>
                            </div>
                            <span style="font-weight: 600; font-size: 0.9rem;">{{ __('messages.dark_mode') }}</span>
                        </button>
                    </div>
                </div>

                <!-- Language Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.language_preferences') }}</h3>
                    </div>
                    
                    <div class="form-group" style="max-width: 400px;">
                        <label class="form-label">{{ __('messages.preferred_language') }}</label>
                        <select name="language" class="form-control">
                            <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ $user->language == 'ar' ? 'selected' : '' }}>Arabic (العربية)</option>
                            <option value="es" {{ $user->language == 'es' ? 'selected' : '' }}>Spanish (Español)</option>
                        </select>
                    </div>
                </div>

                <!-- Notifications Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <h3 class="card-title">{{ __('messages.notifications') }}</h3>
                    </div>

                    <div class="switch-group">
                        <div>
                            <div style="font-weight: 700; color: var(--text-main);">{{ __('messages.in_app_notifications') }}</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">{{ __('messages.in_app_notif_desc') }}</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="in_app_notifications" value="1" {{ $user->in_app_notifications ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="switch-group">
                        <div>
                            <div style="font-weight: 700; color: var(--text-main);">{{ __('messages.email_updates') }}</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">{{ __('messages.email_updates_desc') }}</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="email_notifications" value="1" {{ $user->email_notifications ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn-save">{{ __('messages.save_settings') }}</button>
                </div>
            </form>

            <style>
                .theme-choice-btn {
                    flex: 1;
                    min-width: 140px;
                    max-width: 180px;
                    background: var(--bg-card);
                    border: 2px solid var(--border-color);
                    padding: 0.75rem;
                    border-radius: 1rem;
                    cursor: pointer;
                    transition: all 0.2s;
                    color: var(--text-main);
                    text-align: center;
                }
                .theme-choice-btn:hover {
                    border-color: var(--primary);
                    background: var(--bg-body);
                }
                .theme-choice-btn.active {
                    border-color: var(--primary);
                    background: var(--accent);
                }
            </style>
        </div>

    </div>
</div>

<script>
    function switchSection(section) {
        document.querySelectorAll('.nav-btn').forEach(el => el.classList.remove('active'));
        const activeNav = document.getElementById('nav-' + section);
        if (activeNav) activeNav.classList.add('active');
        
        document.getElementById('section-personal').classList.add('hidden');
        document.getElementById('section-favorites').classList.add('hidden');
        document.getElementById('section-progress').classList.add('hidden');
        const settingsSection = document.getElementById('section-settings');
        if (settingsSection) settingsSection.classList.add('hidden');
        
        document.getElementById('section-' + section).classList.remove('hidden');

        if (section === 'settings') {
            syncThemeButtons();
        }
    }

    function setGlobalTheme(theme) {
        const body = document.body;
        const isDark = theme === 'dark';
        
        if (isDark) {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
        
        localStorage.setItem('theme', theme);
        
        // Sync with header toggle icons
        const sunIcon = document.getElementById('theme-sun');
        const moonIcon = document.getElementById('theme-moon');
        if (sunIcon && moonIcon) {
            if (isDark) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }
        
        syncThemeButtons();
    }

    function syncThemeButtons() {
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.querySelectorAll('.theme-choice-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById('theme-btn-' + currentTheme);
        if (activeBtn) activeBtn.classList.add('active');
    }

    function switchFavTab(tab) {
        document.querySelectorAll('.fav-tab').forEach(el => el.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('content-lessons').classList.add('hidden');
        document.getElementById('content-stories').classList.add('hidden');
        document.getElementById('content-' + tab).classList.remove('hidden');
    }

    async function toggleFavorite(type, id, btn) {
        try {
            const response = await fetch('{{ route('favorites.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id, type })
            });
            
            const data = await response.json();
            if (data.status === 'removed') {
                // If removed, hide the card
                btn.closest('.item-card').style.opacity = '0';
                setTimeout(() => {
                    btn.closest('.item-card').style.display = 'none';
                }, 300);
            } else if (data.status === 'added') {
                // This shouldn't really happen on the profile favorites page, but for safety:
                btn.querySelector('svg').style.color = '#ef4444';
            }
        } catch (error) {
            console.error(error);
        }
    }

    // Avatar Management Logic
    let selectedFile = null;
    let previewMode = false;

    function openAvatarModal() {
        document.getElementById('avatar-modal-backdrop').classList.add('active');
        document.body.style.overflow = 'hidden';
        resetPreview();
    }

    function closeAvatarModal() {
        document.getElementById('avatar-modal-backdrop').classList.remove('active');
        document.body.style.overflow = '';
        resetPreview();
    }

    function resetPreview() {
        selectedFile = null;
        previewMode = false;
        document.getElementById('preview-actions').classList.add('hidden');
        document.getElementById('default-actions').classList.remove('hidden');
        
        // Reset preview image to original
        const previewImg = document.getElementById('preview-avatar-img');
        const originalSrc = previewImg.getAttribute('data-original-src');
        if (originalSrc) {
            previewImg.src = originalSrc;
        }
    }

    function triggerAvatarChange() {
        document.getElementById('avatar-input-hidden').click();
    }

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            return;
        }

        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size must be less than 2MB');
            return;
        }

        selectedFile = file;
        previewMode = true;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('preview-avatar-large');
            const previewImg = document.getElementById('preview-avatar-img');
            
            if (previewImg) {
                previewImg.src = e.target.result;
            } else {
                // Create img if it doesn't exist
                previewContainer.innerHTML = `<img id="preview-avatar-img" src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            }

            // Show save/cancel buttons
            document.getElementById('default-actions').classList.add('hidden');
            document.getElementById('preview-actions').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function saveAvatar() {
        if (!selectedFile) return;

        const formData = new FormData();
        formData.append('avatar', selectedFile);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        // Show loading state
        const saveBtn = document.querySelector('#preview-actions .modal-btn.primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-spin"><circle cx="12" cy="12" r="10" opacity="0.25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" opacity="0.75"/></svg> Saving...';
        saveBtn.disabled = true;

        fetch('{{ route('profile.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error response:', text);
                    throw new Error('Upload failed: ' + response.status);
                });
            }
            return response.text();
        })
        .then((data) => {
            console.log('Success! Reloading page...');
            // Reload page to show updated avatar
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to upload avatar: ' + error.message + '\nCheck browser console for details.');
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        });
    }

    function cancelPreview() {
        resetPreview();
    }

    function removeAvatar() {
        const formData = new FormData();
        formData.append('remove_avatar', '1');
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        fetch('{{ route('profile.update') }}', {
            method: 'POST',
            body: formData
        })
        .then(() => window.location.reload())
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to remove avatar. Please try again.');
        });
    }

    // Close on backdrop click
    document.getElementById('avatar-modal-backdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeAvatarModal();
    });
</script>

<!-- Avatar Management Modal -->
<div id="avatar-modal-backdrop" class="modal-backdrop">
    <div class="avatar-modal">
        <div class="modal-header">
            <h3 class="modal-title">{{ __('messages.profile_picture') }}</h3>
            <button class="close-modal" onclick="closeAvatarModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-content-p">
            <div id="preview-avatar-large" class="preview-avatar-large">
                @if($user->avatar)
                    <img id="preview-avatar-img" data-original-src="{{ Storage::url($user->avatar) }}" src="{{ Storage::url($user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <span id="preview-avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @endif
            </div>
            <p style="color: #6b7280; font-size: 0.9rem; margin-top: -1rem;">Update your profile picture to help people recognize you.</p>
        </div>
        
        <!-- Default Actions -->
        <div id="default-actions" class="modal-actions">
            @if($user->avatar)
                <button class="modal-btn danger" onclick="removeAvatar()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    {{ __('messages.remove_photo') }}
                </button>
            @endif
            <button class="modal-btn primary" onclick="triggerAvatarChange()" style="{{ !$user->avatar ? 'grid-column: span 2' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                {{ __('messages.change_photo') }}
            </button>
        </div>

        <!-- Preview Actions (Hidden by default) -->
        <div id="preview-actions" class="modal-actions hidden">
            <button class="modal-btn" onclick="cancelPreview()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                {{ __('messages.cancel') }}
            </button>
            <button class="modal-btn primary" onclick="saveAvatar()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ __('messages.save') }}
            </button>
        </div>
    </div>
</div>

<!-- Hidden Avatar Input -->
<input type="file" id="avatar-input-hidden" accept="image/*" onchange="handleFileSelect(event)" class="hidden">
@endsection
