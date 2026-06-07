{{-- resources/views/admin/partials/sidebar.blade.php --}}
@php
    $currentRoute = Route::currentRouteName();
    $adminName = session('user.name') ?? 'Admin Brainova';
    $tutorPendingCount    = \App\Models\Tutor::where('status', 'pending')->count();
    $paymentPendingCount  = \App\Models\Payment::where('status', 'menunggu')->count();
    $withdrawalPendingCount = \App\Models\Withdrawal::where('status', 'pending')->count();
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
                <span style="background:#ef4444;color:#fff;padding:2px 6px;border-radius:9999px;font-size:11px;margin-left:auto;">{{ $tutorPendingCount }}</span>
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
                <span style="background:#ef4444;color:#fff;padding:2px 6px;border-radius:9999px;font-size:11px;margin-left:auto;">{{ $paymentPendingCount }}</span>
            @endif
        </a>

        {{-- Kelola Penarikan --}}
        <a href="{{ route('admin.kelola-penarikan') }}"
           class="sidebar-link {{ $currentRoute === 'admin.kelola-penarikan' ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
            Kelola Penarikan
            @if($withdrawalPendingCount > 0)
                <span style="background:#ef4444;color:#fff;padding:2px 6px;border-radius:9999px;font-size:11px;margin-left:auto;">{{ $withdrawalPendingCount }}</span>
            @endif
        </a>

        {{-- Logout --}}
        <div style="padding: 4px 16px; margin-top: 4px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        style="width:100%;display:flex;align-items:center;gap:12px;padding:10px 12px;background:none;border:none;border-radius:10px;font-size:14px;font-weight:600;color:#ef4444;cursor:pointer;font-family:inherit;transition:background .15s;"
                        onmouseover="this.style.background='#fef2f2'"
                        onmouseout="this.style.background='none'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Log out
                </button>
            </form>
        </div>
    </nav>
</aside>