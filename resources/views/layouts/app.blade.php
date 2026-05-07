<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LingoBase - Master a New Language</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light Theme (Default) */
            --primary: #009150;
            --primary-dark: #007a43;
            --accent: #dcfce7;
            --bg-body: #f9fafb;
            --bg-card: #ffffff;
            --header-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --radius: 0.75rem;
            --nav-link: #1e293b;
            --nav-link-hover: #009150;
        }

        body.dark-mode {
            /* Dark Theme */
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --header-bg: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.3);
            --nav-link: #f1f5f9;
            --accent: #064e3b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            transition: background 0.3s ease, color 0.3s ease;
        }

        header {
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
            transition: background 0.3s ease;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--nav-link);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: var(--nav-link-hover);
        }

        main {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 2rem 1rem;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-main);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
        }
        
        .btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Dropdown Styles - Click Based */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: var(--bg-card);
            min-width: 180px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            z-index: 100;
            margin-top: 0.5rem;
            overflow: hidden;
            animation: fadeIn 0.1s ease-out;
        }

        .dropdown.active .dropdown-content {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-content a, .dropdown-content button {
            color: var(--text-main);
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
            text-align: start;
            width: 100%;
            background: none;
            border: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.1s;
        }

        .dropdown-content a:hover, .dropdown-content button:hover {
            background-color: #f3f4f6;
            color: var(--primary);
        }

        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-main);
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem;
            }
            .mobile-toggle {
                display: block;
            }
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                flex-direction: column;
                padding: 1rem;
                border-bottom: 1px solid var(--border);
                gap: 1rem;
                box-shadow: var(--shadow-md);
            }
            .nav-links.active {
                display: flex;
            }
            .nav-links .dropdown {
                width: 100%;
            }
            .dropdown-content {
                position: static;
                width: 100%;
                box-shadow: none;
                border: none;
                background: #f9fafb;
                margin-top: 0.5rem;
            }
        }
        
        .avatar-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 2rem;
            transition: background 0.2s;
        }
        
        .avatar-btn:hover {
            background-color: #f3f4f6;
        }

        .avatar-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--primary);
            object-fit: cover;
        }

        /* RTL Specific Adjustments */
        [dir="rtl"] .nav-links {
            left: auto;
            right: -100%;
        }
        [dir="rtl"] .nav-links.active {
            right: 0;
            left: auto;
        }
        [dir="rtl"] .dropdown-content {
            right: auto;
            left: 0;
        }
        [dir="rtl"] .btn-save svg, [dir="rtl"] a svg {
            transform: scaleX(-1);
        }
        [dir="rtl"] .btn-save svg.no-mirror, [dir="rtl"] a svg.no-mirror {
            transform: none;
        }

        .hidden {
            display: none !important;
        }

    </style>
    @yield('styles')
</head>
<body>
@php
    $localeLabels = ['en' => 'English', 'ar' => 'العربية', 'es' => 'Español'];
    $currentLabel = $localeLabels[app()->getLocale()] ?? 'English';
@endphp
    <header>
        <a href="/" class="logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            LingoBase
        </a>

        <button class="mobile-toggle" id="mobile-menu-toggle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <nav class="nav-links" id="nav-links">
            <a href="{{ route('grammar.index', ['language' => 'english']) }}">{{ __('messages.grammar_bank') }}</a>
            <a href="{{ route('stories.index', ['language' => 'english']) }}">{{ __('messages.stories') }}</a>
            

            <!-- Language Switcher -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: none; background: transparent; padding: 0.5rem 1rem; border-radius: 2rem; width: auto; height: 40px; transition: background 0.2s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span style="font-weight: 500; font-size: 0.95rem;">{{ $currentLabel }}</span>
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('lang.switch', 'en') }}">English</a>
                    <a href="{{ route('lang.switch', 'ar') }}">العربية</a>
                    <a href="{{ route('lang.switch', 'es') }}">Español</a>
                </div>
            </div>

            @auth
                <!-- Notifications -->
                <div class="dropdown" id="notification-dropdown">
                    <button class="btn dropdown-toggle" style="position: relative; padding: 0.5rem; border: none; background: transparent; color: var(--text-main);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span id="unread-count" class="hidden" style="position: absolute; top: 0; inset-inline-end: 0; background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid var(--header-bg);"></span>
                    </button>
                    <div class="dropdown-content" style="min-width: 320px; max-height: 480px; overflow-y: auto; padding: 0;">
                        <div style="padding: 1rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 700;">{{ __('messages.notifications') }}</span>
                            <button onclick="markAllRead()" style="font-size: 0.8rem; color: var(--primary); background: none; border: none; cursor: pointer; font-weight: 600;">{{ __('messages.mark_all_as_read') }}</button>
                        </div>
                        <div id="notification-list" style="max-height: 400px; overflow-y: auto;">
                            <!-- Notifications injected here -->
                            <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 1rem; opacity: 0.5;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <p>{{ __('messages.no_notifications_yet') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="avatar-btn dropdown-toggle">
                        <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=009150&color=fff' }}" alt="{{ Auth::user()->name }}" class="avatar-img">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('profile.index') }}">{{ __('messages.my_profile') }}</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">{{ __('messages.logout') }}</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="auth-btn-container">
                    <a href="{{ route('register') }}" class="btn" style="padding: 0.6rem 1.5rem; background: var(--primary); color: white; border-bottom: none; border-radius: 2rem;">{{ __('messages.sign_up') }}</a>
                </div>
            @endauth
        </nav>
    </header>

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer style="background-color: #004d2a; padding: 4rem 2rem; color: #fff;">
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem;">
            <!-- Brand -->
            <div>
                <a href="/" style="display: flex; align-items: center; gap: 0.5rem; color: white; text-decoration: none; font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    LingoBase
                </a>
                <p style="color: #a7f3d0; line-height: 1.6; margin: 0;">
                    {{ __('messages.brand_description') }}
                </p>
            </div>
            
            <!-- Quick Links -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <h4 style="font-size: 1.1rem; font-weight: 600; margin: 0 0 0.5rem 0;">{{ __('messages.explore') }}</h4>
                <a href="{{ route('grammar.index') }}" style="color: #e5e7eb; text-decoration: none; transition: opacity 0.2s; opacity: 0.9;">{{ __('messages.grammar_bank') }}</a>
                <a href="{{ route('stories.index') }}" style="color: #e5e7eb; text-decoration: none; transition: opacity 0.2s; opacity: 0.9;">{{ __('messages.stories') }}</a>
                <a href="{{ route('register') }}" style="color: #e5e7eb; text-decoration: none; transition: opacity 0.2s; opacity: 0.9;">{{ __('messages.get_started_footer') }}</a>
            </div>
            
            <!-- support -->
             <div style="display: flex; flex-direction: column; gap: 1rem;">
                <h4 style="font-size: 1.1rem; font-weight: 600; margin: 0 0 0.5rem 0;">{{ __('messages.support') }}</h4>
                <a href="{{ route('help') }}" style="color: #e5e7eb; text-decoration: none; opacity: 0.9;">{{ __('messages.help_center') }}</a>
                <a href="#" style="color: #e5e7eb; text-decoration: none; opacity: 0.9;">{{ __('messages.privacy_policy') }}</a>
                <a href="#" style="color: #e5e7eb; text-decoration: none; opacity: 0.9;">{{ __('messages.terms_of_service') }}</a>
            </div>
        </div>
        
        <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 4rem; padding-top: 2rem; color: #6ee7b7; font-size: 0.875rem;">
            &copy; {{ date('Y') }} LingoBase. {{ __('messages.all_rights_reserved') }}
        </div>
    </footer>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Logic
            const currentTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            if (currentTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }

            // Mobile Menu Toggle
            const mobileToggle = document.getElementById('mobile-menu-toggle');
            const navLinks = document.getElementById('nav-links');
            
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }

            // Dropdown Toggles
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                if (toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        
                        // Close other dropdowns
                        dropdowns.forEach(d => {
                            if (d !== dropdown) d.classList.remove('active');
                        });
                        
                        dropdown.classList.toggle('active');
                    });
                }
            });

            // Close on click outside
            document.addEventListener('click', function() {
                dropdowns.forEach(d => d.classList.remove('active'));
                if (navLinks) navLinks.classList.remove('active');
            });

            // Prevent closing when clicking inside dropdown content
            const dropdownContents = document.querySelectorAll('.dropdown-content');
            dropdownContents.forEach(content => {
                content.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            @auth
                // Notifications Logic
                fetchNotifications();
                setInterval(fetchNotifications, 60000); // Polling every minute

                const notificationDropdown = document.getElementById('notification-dropdown');
                if (notificationDropdown) {
                    const toggle = notificationDropdown.querySelector('.dropdown-toggle');
                    toggle.addEventListener('click', function() {
                        if (notificationDropdown.classList.contains('active')) {
                            // Fetch again when opening
                            fetchNotifications();
                        }
                    });
                }
            @endauth
        });

        @auth
        async function fetchNotifications() {
            try {
                const res = await fetch('/api/notifications', {
                    headers: { 'Authorization': 'Bearer ' + '{{ Auth::user()->api_token ?? "" }}', 'Accept': 'application/json' }
                });
                const response = await res.json();
                if (response.status) {
                    updateNotificationUI(response.data);
                }
            } catch (e) { console.error("Error fetching notifications", e); }
        }

        // Helper function to update the notification badge visibility and count
        function updateNotificationBadge(unreadCount) {
            const badge = document.getElementById('unread-count'); // Keep existing ID
            if (badge) {
                if (unreadCount > 0) {
                    badge.innerText = unreadCount;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                    badge.innerText = ''; // Clear text when hidden
                }
            }
        }

        function updateNotificationUI(data) {
            const list = document.getElementById('notification-list');
            
            // Use the new helper function to update the badge
            updateNotificationBadge(data.unread_count);

            if (data.notifications.length === 0) {
                list.innerHTML = `
                    <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 1rem; opacity: 0.5;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <p>{{ __('messages.no_notifications_yet') }}</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = '';
            data.notifications.forEach(notif => {
                const item = document.createElement('div');
                item.style.padding = '1rem';
                item.style.borderBottom = '1px solid var(--border-color)';
                item.style.background = notif.read_at ? 'transparent' : 'var(--accent)';
                item.style.cursor = 'pointer';
                item.style.transition = 'background 0.2s';
                
                const time = new Date(notif.created_at).toLocaleDateString();
                
                item.innerHTML = `
                    <div style="display: flex; gap: 0.75rem;">
                        <div style="background: var(--primary); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 0.9rem; margin-bottom: 0.25rem; color: var(--text-main);">${notif.data.title || '{{ __('messages.notifications') }}'}</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.4; margin-bottom: 0.5rem;">${notif.data.message}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); opacity: 0.8;">${time}</div>
                        </div>
                    </div>
                `;
                
                item.onclick = () => markRead(notif.id);
                list.appendChild(item);
            });
        }

        async function markRead(id) {
            try {
                await fetch(`/api/notifications/${id}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                fetchNotifications();
            } catch (e) { console.error(e); }
        }

        async function markAllRead() {
            try {
                await fetch('/api/notifications/read-all', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                fetchNotifications();
            } catch (e) { console.error(e); }
        }
        @endauth
    </script>
</body>
</html>
