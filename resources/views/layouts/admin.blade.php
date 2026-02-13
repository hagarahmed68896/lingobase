<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LingoBase</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --bg-sidebar: #111827;
            --bg-body: #f9fafb;
            --primary: #009150;
            --primary-hover: #007641;
        }

        body {
            background-color: var(--bg-body);
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-sidebar);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1.5rem;
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-item:hover, .nav-item.active {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
        }

        .nav-item.active {
            border-left: 4px solid var(--primary);
            padding-left: calc(1.5rem - 4px);
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-content {
            padding: 2rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-container {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            width: 100%;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Mobile Adjustments */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #374151;
            padding: 0.5rem;
        }

        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 0px;
            }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 260px;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-menu-btn {
                display: block;
            }
            .top-bar {
                padding: 0 1rem;
            }
        }

        @media (max-width: 640px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
            .table-header {
                flex-direction: column;
                align-items: stretch;
            }
            .search-input {
                width: 100%;
            }
        }

        .search-input {
            padding: 0.625rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            width: 300px;
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 145, 80, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-blue { background: #dbeafe; color: #1e40af; }

        /* Pagination Styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
            align-items: center;
        }

        .page-item {
            display: inline-block;
        }

        .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            background: white;
            color: #374151;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .page-item.disabled .page-link {
            background: #f9fafb;
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #f3f4f6;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="/" class="logo">
                <span style="color: var(--primary);">Lingo</span>Base
                <small style="font-size: 0.7rem; color: #6b7280;">ADMIN</small>
            </a>
            <button class="mobile-menu-btn" id="close-sidebar" style="color: white; lg:display:none;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.languages.index') }}" class="nav-item {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                Languages
            </a>
            <a href="{{ route('admin.grammar.index') }}" class="nav-item {{ request()->routeIs('admin.grammar.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253"></path></svg>
                Grammar
            </a>
            <a href="{{ route('admin.stories.index') }}" class="nav-item {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 11V9m-4 5V9m-4 5V9"></path></svg>
                Stories
            </a>
        </nav>
        <div style="padding: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="background: none; border: none; width: 100%; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div id="sidebar-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:999;"></div>

    <div class="main-content">
        <div class="top-bar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-menu-btn" id="open-sidebar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">@yield('title')</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-weight: 600; display: inline-block;">{{ auth()->user()->name }}</span>
                <div style="width: 32px; height: 32px; background: #e5e7eb; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #6b7280;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
            }

            if (openBtn) openBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
