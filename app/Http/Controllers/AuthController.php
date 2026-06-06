<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Tutor;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user')) {
            return $this->redirectByRole(session('user.role'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email    = trim($request->input('email', ''));
        $password = $request->input('password', '');

        if (empty($email) || empty($password)) {
            return back()->with('error', 'Email dan password harus diisi.');
        }

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('user', [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]);

            if ($request->filled('remember')) {
                cookie('remember_user', $user->email, 60 * 24 * 30);
            }

            return $this->redirectByRole($user->role);
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function showRegister(Request $request)
    {
        if (session('user')) {
            return $this->redirectByRole(session('user.role'));
        }
        $tab      = ($request->query('role') === 'tutor') ? 'tutor' : 'siswa';
        $subjects = Subject::orderBy('nama_mapel')->get();
        return view('auth.register', compact('tab', 'subjects'));
    }

    public function register(Request $request)
    {
        $regType  = $request->input('reg_type', 'siswa');
        $name     = trim($request->input('name', ''));
        $email    = trim($request->input('email', ''));
        $phone    = trim($request->input('phone', ''));
        $password = $request->input('password', '');
        $password_confirmation = $request->input('password_confirmation', '');

        if (empty($name) || empty($email) || empty($password)) {
            return back()->with('error', 'Semua field wajib harus diisi.')->with('tab', $regType);
        }

        if ($password !== $password_confirmation) {
            return back()->with('error', 'Konfirmasi password tidak cocok.')->with('tab', $regType);
        }

        if (User::where('email', $email)->exists()) {
            return back()->with('error', 'Email sudah terdaftar.')->with('tab', $regType);
        }

        $role = ($regType === 'tutor') ? 'tutor' : 'siswa';

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => Hash::make($password),
            'role'     => $role,
        ]);

        if ($role === 'siswa') {
            Student::create(['user_id' => $user->id, 'name' => $name]);
        } elseif ($role === 'tutor') {
            Tutor::create([
                'user_id'    => $user->id,
                'subject_id' => intval($request->input('subject_id', 1)),
                'name'       => $name,
                'bio'        => trim($request->input('bio', '')),
                'tarif'      => intval($request->input('tarif', 0)),
                'status'     => 'pending',
            ]);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            'tutor' => redirect()->route('tutor.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
