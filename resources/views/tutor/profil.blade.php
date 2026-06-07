<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Brainova</title>
    @vite('resources/css/app.css')
</head>
<body class="auth-body">
<header class="app-topbar">
    <a href="{{ route('tutor.dashboard') }}" class="app-brand">
        Brainova
    </a>
</header>
<div class="auth-container">
        <a href="{{ route('tutor.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
        <h1 class="auth-title">Edit Profil Tutor</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="notice">
            💡 <strong>Perubahan profil</strong> akan langsung disimpan ke database.
        </div>

        <form method="POST" action="{{ route('tutor.profil.update') }}">
            @csrf
            <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">

            <div class="form-group">
                <label for="subject_id">Mata Pelajaran</label>
                <select id="subject_id" name="subject_id" class="input-field" required>
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}" {{ $s->id == $tutor->subject_id ? 'selected' : '' }}>{{ $s->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="bio">Bio / Deskripsi</label>
                <textarea id="bio" name="bio" class="input-field" placeholder="Ceritakan pengalaman mengajar kamu">{{ $tutor->bio }}</textarea>
            </div>
            <div class="form-group">
                <label for="tarif">Tarif per Sesi (Rp)</label>
                <input type="number" id="tarif" name="tarif" class="input-field" value="{{ $tutor->tarif }}" min="0" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
