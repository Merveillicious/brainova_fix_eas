<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tutor - Brainova</title>
    <link rel="stylesheet" href="{{ asset('css/brainova.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">Brainova</a>
        <div class="navbar-right">
            <span class="badge-role">Admin</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper" style="max-width:800px">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
        <h1 class="page-title">Kelola Tutor</h1>
        <p class="sub-text">Approve atau tolak pendaftaran tutor.</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($tutors->isEmpty())
            <div class="empty-state">Belum ada tutor terdaftar.</div>
        @else
            @foreach($tutors as $t)
                <div class="card">
                    <div class="card-label">
                        {{ $t->name }}
                        <span class="badge-status badge-{{ $t->status }}">{{ $t->status }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $t->user->email ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mata Pelajaran</span>
                        <span class="info-value">{{ $t->subject->nama_mapel ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Bio</span>
                        <span class="info-value">{{ $t->bio ?: '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tarif</span>
                        <span class="info-value">Rp {{ number_format($t->tarif, 0, ',', '.') }}</span>
                    </div>
                    <div class="btn-group">
                        @if($t->status === 'pending')
                            <form method="POST" action="{{ route('admin.tutor.status') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="tutor_id" value="{{ $t->id }}">
                                <input type="hidden" name="status" value="aktif">
                                <button type="submit" class="btn-approve">✓ Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.tutor.status') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="tutor_id" value="{{ $t->id }}">
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn-reject">✕ Tolak</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.tutor.delete') }}" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus tutor ini?')">
                            @csrf
                            <input type="hidden" name="tutor_id" value="{{ $t->id }}">
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
