<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'WDC Construction Project System')
    </title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app-layout.css') }}">
    @if (request()->routeIs('activity_logs.*'))
    <link rel="stylesheet" href="{{ asset('css/activity-logs.css') }}">
    @endif  
    {{-- Icons --}}
    <link rel="icon" type="image" href="{{ asset('public/image/favicon.png') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
</head>

<body>

    <div class="app-container">

        {{-- =========================
             SIDEBAR
        ========================== --}}
        <aside class="sidebar" id="sidebar">

            {{-- Logo / Company Name --}}
            <div class="sidebar-header">

                <div class="company-logo">
                    <i class="fa-solid fa-building"></i>
                </div>

                <div class="company-info">
                    <h2>WDC Construction</h2>
                    <span>Project Directory</span>
                </div>

            </div>


            {{-- Navigation --}}
            <nav class="sidebar-navigation">

                <div class="nav-section-title">
                    MAIN MENU
                </div>

               
<a href="{{ route('dashboard') }}"
   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

    <i class="fa-solid fa-house"></i>

    <span>Dashboard</span>

</a>


<a href="{{ route('projects.index') }}"
   class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">

    <i class="fa-solid fa-folder"></i>

    <span>Projects</span>

    <span class="nav-count">
        {{ \App\Models\Project::count() }}
    </span>
   

</a>

    @if(auth()->check() && auth()->user()->role === 'administrator')
    <a href="{{ route('users.index') }}"
       class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="fa-solid fa-users"></i>
        <span>Users</span>
    </a>
    @endif




                <div class="nav-section-title">
                    MANAGEMENT
                </div>


    @if(auth()->check() && in_array(auth()->user()->role, ['administrator', 'manager']))
    <a href="{{ route('archive.index') }}"
       class="nav-item {{ request()->routeIs('archive.*') ? 'active' : '' }}">
        <i class="fa-solid fa-box-archive"></i>
        <span>Archive</span>
    </a>
@endif

                <a href="{{ route('reports.index') }}"
   class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">

    <i class="fa-solid fa-chart-line"></i>

    <span>Reports</span>
    @if (auth()->user()->role === 'administrator')

    <a href="{{ route('activity_logs.index') }}"
       class="nav-item {{ request()->routeIs('activity_logs.*') ? 'active' : '' }}">

        <i class="fa-solid fa-clock-rotate-left"></i>

        <span>User Logs</span>

    </a>

@endif
</a>



            </nav>


            {{-- Sidebar Footer --}}
            <div class="sidebar-footer">

                <div class="system-status">

                    <span class="status-dot"></span>

                    <span>Team 1</span>

                </div>

            </div>

        </aside>


        {{-- =========================
             MAIN AREA
        ========================== --}}
        <main class="main-content">

            {{-- TOPBAR --}}
            <header class="topbar">

                {{-- Mobile / Sidebar Toggle --}}
                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle">

                    <i class="fa-solid fa-bars"></i>

                </button>


                {{-- Page Title --}}
                <div class="topbar-title">

                    <h1>
                        @yield('page-title', 'Dashboard')
                    </h1>

                </div>


                {{-- Right Side --}}
                 <div class="topbar-actions">

                    {{-- Notification --}}
                    <button class="icon-button">

                        {{-- <i class="fa-regular fa-bell"></i>

                        <span class="notification-badge">
                            3
                        </span> --}}

                    </button> 


                   {{-- User Menu --}}
<div class="user-menu" id="userMenu">

    <button
        type="button"
        class="user-menu-trigger"
        id="userMenuTrigger"
        aria-expanded="false"
    >

        <div class="user-avatar">
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="user-details">

            <strong>
                {{ auth()->user()->name }}
            </strong>

            <span>
                {{ ucfirst(auth()->user()->role) }}
            </span>

        </div>

        <i class="fa-solid fa-chevron-down user-arrow"></i>

    </button>


    {{-- User Dropdown --}}
    <div class="user-dropdown" id="userDropdown">

        <div class="user-dropdown-header">

            <div class="user-dropdown-avatar">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>
                <strong>
                    {{ auth()->user()->name }}
                </strong>

                <span>
                    {{ auth()->user()->email }}
                </span>
            </div>

        </div>


        <div class="user-dropdown-divider"></div>


        <div class="user-dropdown-role">

            <i class="fa-solid fa-shield-halved"></i>

            <span>
                {{ ucfirst(auth()->user()->role) }}
            </span>

        </div>


        <div class="user-dropdown-divider"></div>


        {{-- Logout --}}
        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >
            @csrf

            <button
                type="submit"
                class="user-dropdown-item user-dropdown-logout"
            >
                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>
            </button>

        </form>

    </div>

</div>

                </div>

            </header>


            {{-- =========================
                 PAGE CONTENT
            ========================== --}}
            <section class="page-content" id="pageContent">

                {{-- Breadcrumb --}}
                <div class="breadcrumb">

                    <span>
                        WDC Construction Project System
                    </span>

                    <i class="fa-solid fa-chevron-right"></i>

                    <strong>
                        @yield('page-title', 'Dashboard')
                    </strong>

                </div>


                {{-- Actual Page Content --}}
                <div class="content-wrapper">

                    @if(session('success'))
                        <div class="global-alert global-alert-success">
                                <i class="fa-solid fa-circle-check"></i>

                                                    <span>
                                            {{ session('success') }}
                                                                </span>
                        </div>
                        @endif

@if(session('error'))
    <div class="global-alert global-alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>

        <span>
            {{ session('error') }}
        </span>
    </div>
@endif



                    @yield('content')

                </div>

            </section>

        </main>

    </div>


    {{-- =========================
         MOBILE SIDEBAR OVERLAY
    ========================== --}}
    <div
        class="sidebar-overlay"
        id="sidebarOverlay">
    </div>


    {{-- =========================
         JAVASCRIPT
    ========================== --}}
    <script src="{{ asset('js/app-layout.js') }}"></script>

    @stack('scripts')

</body>
</html>

