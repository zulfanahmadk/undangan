<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    @yield('extra-css')
</head>
<body>
    <div class="admin-container">
        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Dashboard</h2>
                <button class="sidebar-toggle-btn" id="sidebarToggleBtn" onclick="toggleSidebar()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">📊</span>
                    <span class="menu-label">Dashboard</span>
                </a>
                <a href="{{ route('admin.guests') }}" class="menu-item {{ request()->routeIs('admin.guests') ? 'active' : '' }}">
                    <span class="menu-icon">👥</span>
                    <span class="menu-label">Daftar Tamu</span>
                </a>
                <a href="{{ route('admin.wishes') }}" class="menu-item {{ request()->routeIs('admin.wishes') ? 'active' : '' }}">
                    <span class="menu-icon">💌</span>
                    <span class="menu-label">Ucapan & Doa</span>
                </a>
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <span class="menu-icon">👤</span>
                        <span class="menu-label">Admin User</span>
                    </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <a href="/" class="menu-item">
                    <span class="menu-icon">👁️</span>
                    <span class="menu-label">Lihat Undangan</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header with User Menu -->
            <header class="admin-header">
                <div class="header-spacer"></div>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-icon">👤</div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <button class="user-menu-btn" id="userMenuBtn">
                        <span class="dropdown-icon">▼</span>
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            🚪 Keluar
                        </a>
                    </div>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </header>

            <div class="main-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/admin-layout.js') }}"></script>

    @yield('extra-js')
</body>
</html>
