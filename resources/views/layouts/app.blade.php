<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LingoBase - Master a New Language</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #009150; /* Spanish Green */
            --primary-dark: #007a43;
            --accent: #dcfce7; /* Light Green Accent */
            --text-main: #1f2937;
            --text-light: #6b7280;
            --bg-body: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 0.75rem;
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
        }

        header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s;
        }
        
        .logo:hover {
            opacity: 0.9;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }

        main {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 2rem 1rem;
        }

        footer {
            background: var(--primary);
            color: #d1d5db;
            padding: 4rem 2rem;
            margin-top: auto;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent);
        }

        .btn {
            background: var(--white);
            border: 1px solid var(--border);
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
            background-color: var(--white);
            min-width: 180px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
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
            text-align: left;
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

    </style>
    @yield('styles')
</head>
<body>
    <header>
        <a href="/" class="logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            LingoBase
        </a>

        <button class="mobile-toggle" id="mobile-menu-toggle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <nav class="nav-links" id="nav-links">
            <a href="{{ route('grammar.index') }}">{{ __('messages.grammar_bank') }}</a>
            <a href="{{ route('stories.index') }}">{{ __('messages.stories') }}</a>
            
            <!-- Language Switcher -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" style="display: flex; align-items: center; gap: 0.5rem; border: none; background: #f3f4f6; padding: 0.5rem 0.75rem; border-radius: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('lang.switch', 'en') }}">English</a>
                    <a href="{{ route('lang.switch', 'ar') }}">العربية</a>
                    <a href="{{ route('lang.switch', 'es') }}">Español</a>
                </div>
            </div>

            @auth
                <div class="dropdown">
                    <button class="avatar-btn dropdown-toggle">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=009150&color=fff" alt="{{ Auth::user()->name }}" class="avatar-img">
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
                    <a href="{{ route('register') }}" class="btn" style="padding: 0.5rem 1.25rem; font-size: 0.9rem; color: #009150; border: 1px solid #009150;">{{ __('messages.sign_up') }}</a>
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
                <span style="color: #e5e7eb; cursor: pointer; opacity: 0.9;">{{ __('messages.help_center') }}</span>
                <span style="color: #e5e7eb; cursor: pointer; opacity: 0.9;">{{ __('messages.privacy_policy') }}</span>
                <span style="color: #e5e7eb; cursor: pointer; opacity: 0.9;">{{ __('messages.terms_of_service') }}</span>
            </div>
        </div>
        
        <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 4rem; padding-top: 2rem; color: #6ee7b7; font-size: 0.875rem;">
            &copy; {{ date('Y') }} LingoBase. {{ __('messages.all_rights_reserved') }}
        </div>
    </footer>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>
