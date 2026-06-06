{{-- resources/views/admin/partials/sidebar.blade.php --}}
@php
    $currentRoute = Route::currentRouteName();
    $adminName = session('user.name') ?? 'Admin Brainova';
    
    // Calculate pending counts to ensure they're available on all admin pages
    $tutorPendingCount = \App\Models\Tutor::where('status', 'pending')->count();
    $paymentPendingCount = \App\Models\Payment::where('status', 'menunggu')->count();
@endphp

<aside class="siswa-sidebar">
    <div class="sidebar-profile">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($adminName) }}&background=000&color=fff&size=128"
             class="sidebar-avatar" alt="Avatar">
        <div class="sidebar-name">{{ explode(' ', trim($adminName))[0] }}</div>
        <div class="sidebar-role" style="background:#000; color:#FBBF24;">ADMIN</div>
    </div>

    <nav class="sidebar-nav">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            Dashboard
        </a>

        {{-- Kelola Tutor --}}
        <a href="{{ route('admin.kelola-tutor') }}"
           class="sidebar-link {{ $currentRoute === 'admin.kelola-tutor' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Kelola Tutor
            @if($tutorPendingCount > 0)
                <span style="background: #ef4444; color: #fff; padding: 2px 6px; border-radius: 9999px; font-size: 11px; margin-left: auto;">{{ $tutorPendingCount }}</span>
            @endif
        </a>

        {{-- Kelola Pembayaran --}}
        <a href="{{ route('admin.kelola-pembayaran') }}"
           class="sidebar-link {{ $currentRoute === 'admin.kelola-pembayaran' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                <line x1="2" y1="10" x2="22" y2="10"></line>
            </svg>
            Kelola Pembayaran
            @if($paymentPendingCount > 0)
                <span style="background: #ef4444; color: #fff; padding: 2px 6px; border-radius: 9999px; font-size: 11px; margin-left: auto;">{{ $paymentPendingCount }}</span>
            @endif
        </a>
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" style="margin-top:auto; padding:24px;">
        @csrf
        <button type="submit" class="btn-outline"
                style="width:100%; border-color:transparent; color:#ef4444; font-weight:600;">
            Log out
        </button>
    </form>
</aside>
