<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\Payment;
use App\Models\Review;

class SiswaController extends Controller
{
    public function dashboard(Request $request)
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $bookings = collect();
        if ($student) {
            $bookings = Booking::with(['schedule.tutor', 'schedule.subject', 'payment'])
                ->where('student_id', $student->id)
                ->orderByDesc('id')
                ->get();
        }

        // Filter params (sama seperti cariTutor)
        $keyword    = trim($request->input('keyword', ''));
        $minHarga   = (int) $request->input('min_harga', 0);
        $maxHarga   = (int) $request->input('max_harga', 0);
        $sort       = $request->input('sort', 'relevansi');
        $subjectIds = $request->input('subject', []);

        $query = Tutor::with(['subject', 'reviews'])
            ->where('status', 'aktif')
            ->whereHas('schedules', fn($q) => $q->where('status', 'tersedia'));

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhereHas('subject', fn($sq) => $sq->where('nama_mapel', 'like', "%{$keyword}%"))
                  ->orWhere('bio', 'like', "%{$keyword}%");
            });
        }

        if (!empty($subjectIds)) {
            $query->whereIn('subject_id', $subjectIds);
        }

        if ($minHarga > 0) {
            $query->where('tarif', '>=', $minHarga);
        }
        if ($maxHarga > 0 && $maxHarga < 500000) {
            $query->where('tarif', '<=', $maxHarga);
        }

        $query = match ($sort) {
            'harga_asc'  => $query->orderBy('tarif', 'asc'),
            'harga_desc' => $query->orderBy('tarif', 'desc'),
            'rating'     => $query->withCount('reviews')->orderByDesc('reviews_count'),
            default      => $query->orderBy('name', 'asc'),
        };

        $tutors   = $query->get();
        $subjects = \App\Models\Subject::orderBy('nama_mapel')->get();

        return view('siswa.dashboard', compact(
            'bookings', 'student', 'tutors', 'subjects',
            'keyword', 'minHarga', 'maxHarga', 'sort', 'subjectIds'
        ));
    }

    public function jadwalKelas()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $aktif    = collect();
        $riwayat  = collect();

        if ($student) {
            $semua = Booking::with(['schedule.tutor', 'schedule.subject', 'payment'])
                ->where('student_id', $student->id)
                ->orderByDesc('id')
                ->get();

            $aktif   = $semua->whereIn('status_booking', ['pending', 'diterima']);
            $riwayat = $semua->whereIn('status_booking', ['selesai', 'batal']);
        }

        return view('siswa.jadwal-kelas', compact('student', 'aktif', 'riwayat'));
    }

    public function pembayaran()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $payments = collect();
        if ($student) {
            $payments = Payment::with(['booking.schedule.tutor', 'booking.schedule.subject'])
                ->whereHas('booking', fn($q) => $q->where('student_id', $student->id))
                ->orderByDesc('created_at')
                ->paginate(8);
        }

        return view('siswa.pembayaran', compact('student', 'payments'));
    }

    public function pesan(Request $request)
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        // Daftar tutor yang pernah di-booking
        $tutors = collect();
        $messages = collect();
        $activeTutor = null;
        $activeTutorUserId = null;

        if ($student) {
            $tutors = Booking::with('schedule.tutor.user')
                ->where('student_id', $student->id)
                ->get()
                ->pluck('schedule.tutor')
                ->filter()
                ->unique('id')
                ->values();

            // Ambil pesan dengan tutor yang dipilih
            $activeTutorId = $request->query('tutor');
            if ($activeTutorId) {
                $activeTutor = Tutor::with('user')->find($activeTutorId);
                if ($activeTutor) {
                    $activeTutorUserId = $activeTutor->user_id;
                    $messages = \App\Models\Message::where(function ($q) use ($userId, $activeTutorUserId) {
                        $q->where('sender_id', $userId)->where('receiver_id', $activeTutorUserId);
                    })->orWhere(function ($q) use ($userId, $activeTutorUserId) {
                        $q->where('sender_id', $activeTutorUserId)->where('receiver_id', $userId);
                    })->orderBy('created_at')->get();

                    // Tandai pesan sebagai sudah dibaca
                    \App\Models\Message::where('sender_id', $activeTutorUserId)
                        ->where('receiver_id', $userId)
                        ->where('is_read', false)
                        ->update(['is_read' => true]);
                }
            }
        }

        return view('siswa.pesan', compact('student', 'tutors', 'messages', 'activeTutor', 'activeTutorUserId'));
    }

    public function kirimPesan(Request $request)
    {
        $userId    = session('user.id');
        $body      = trim($request->input('body', ''));
        $receiverId = intval($request->input('receiver_id'));

        if (empty($body) || !$receiverId) {
            return back()->with('error', 'Pesan tidak boleh kosong.');
        }

        \App\Models\Message::create([
            'sender_id'   => $userId,
            'receiver_id' => $receiverId,
            'body'        => $body,
        ]);

        // Redirect ke pesan dengan tutor yang sama
        $tutor = Tutor::where('user_id', $receiverId)->first();
        return redirect()->route('siswa.pesan', ['tutor' => $tutor?->id ?? ''])
            ->with('success', 'Pesan terkirim.');
    }

    public function pengaturan()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();
        $user    = \App\Models\User::find($userId);

        return view('siswa.pengaturan', compact('student', 'user'));
    }

    public function updateProfil(Request $request)
    {
        $userId = session('user.id');
        $user   = \App\Models\User::find($userId);

        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $user->update([
            'name'  => trim($request->input('name', $user->name)),
            'phone' => trim($request->input('phone', '')),
        ]);

        // Update session name
        $request->session()->put('user.name', $user->name);

        // Update student name too
        $student = Student::where('user_id', $userId)->first();
        if ($student) $student->update(['name' => $user->name]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateSandi(Request $request)
    {
        $userId      = session('user.id');
        $user        = \App\Models\User::find($userId);
        $sandiLama   = $request->input('sandi_lama', '');
        $sandiBaru   = $request->input('sandi_baru', '');
        $konfirmasi  = $request->input('konfirmasi_sandi', '');

        if (!\Illuminate\Support\Facades\Hash::check($sandiLama, $user->password)) {
            return back()->with('error_sandi', 'Kata sandi saat ini salah.');
        }
        if (strlen($sandiBaru) < 8) {
            return back()->with('error_sandi', 'Kata sandi baru minimal 8 karakter.');
        }
        if ($sandiBaru !== $konfirmasi) {
            return back()->with('error_sandi', 'Konfirmasi kata sandi tidak cocok.');
        }

        $user->update(['password' => \Illuminate\Support\Facades\Hash::make($sandiBaru)]);

        return back()->with('success_sandi', 'Kata sandi berhasil diperbarui!');
    }

    public function ulasan()
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        $perluDinilai = collect();
        $riwayatUlasan = collect();

        if ($student) {
            // Booking selesai yang belum diulas
            $reviewedBookingIds = Review::where('student_id', $student->id)->pluck('booking_id');

            $perluDinilai = Booking::with(['schedule.tutor', 'schedule.subject'])
                ->where('student_id', $student->id)
                ->where('status_booking', 'selesai')
                ->whereNotIn('id', $reviewedBookingIds)
                ->orderByDesc('id')
                ->get();

            $riwayatUlasan = Review::with(['booking.schedule.tutor', 'booking.schedule.subject'])
                ->where('student_id', $student->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return view('siswa.ulasan', compact('student', 'perluDinilai', 'riwayatUlasan'));
    }

    public function storeUlasan(Request $request)
    {
        $userId    = session('user.id');
        $bookingId = intval($request->input('booking_id'));
        $rating    = max(1, min(5, intval($request->input('rating', 5))));
        $komentar  = trim($request->input('komentar', ''));

        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $booking = Booking::with('schedule')
            ->where('id', $bookingId)
            ->where('student_id', $student->id)
            ->where('status_booking', 'selesai')
            ->first();

        if (!$booking) {
            return back()->with('error', 'Booking tidak valid.');
        }

        if (Review::where('booking_id', $bookingId)->exists()) {
            return back()->with('error', 'Kelas ini sudah pernah diulas.');
        }

        Review::create([
            'booking_id' => $bookingId,
            'student_id' => $student->id,
            'tutor_id'   => $booking->schedule->tutor_id,
            'rating'     => $rating,
            'komentar'   => $komentar,
        ]);

        return redirect()->route('siswa.ulasan')->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }

    public function cariTutor(Request $request)
    {
        $keyword    = trim($request->input('keyword', ''));
        $minHarga   = (int) $request->input('min_harga', 0);
        $maxHarga   = (int) $request->input('max_harga', 0); // 0 = unlimited
        $sort       = $request->input('sort', 'relevansi');
        $subjectIds = $request->input('subject', []);

        $query = Tutor::with(['subject', 'reviews'])
            ->where('status', 'aktif')
            ->whereHas('schedules', fn($q) => $q->where('status', 'tersedia'));

        // Filter: keyword (nama tutor atau mata pelajaran)
        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhereHas('subject', fn($sq) => $sq->where('nama_mapel', 'like', "%{$keyword}%"))
                  ->orWhere('bio', 'like', "%{$keyword}%");
            });
        }

        // Filter: mata pelajaran (checkbox)
        if (!empty($subjectIds)) {
            $query->whereIn('subject_id', $subjectIds);
        }

        // Filter: harga min
        if ($minHarga > 0) {
            $query->where('tarif', '>=', $minHarga);
        }
        // Filter: harga max (abaikan jika 500000 = unlimited)
        if ($maxHarga > 0 && $maxHarga < 500000) {
            $query->where('tarif', '<=', $maxHarga);
        }

        // Sort
        $query = match ($sort) {
            'harga_asc'  => $query->orderBy('tarif', 'asc'),
            'harga_desc' => $query->orderBy('tarif', 'desc'),
            'rating'     => $query->withCount('reviews')->orderByDesc('reviews_count'),
            default      => $query->orderBy('name', 'asc'),
        };

        $tutors   = $query->get();
        $subjects = \App\Models\Subject::orderBy('nama_mapel')->get();

        return view('siswa.cari-tutor', compact('tutors', 'subjects', 'keyword', 'minHarga', 'maxHarga', 'sort', 'subjectIds'));
    }

    public function tutorProfil($id)
    {
        $tutor = Tutor::with('subject')->findOrFail($id);
        
        $schedules = Schedule::where('tutor_id', $id)
            ->where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.profil-tutor', compact('tutor', 'schedules'));
    }

    public function checkout(Request $request)
    {
        $scheduleId = intval($request->input('schedule_id'));
        $schedule = Schedule::with(['tutor.subject', 'subject'])->findOrFail($scheduleId);
        
        return view('siswa.checkout', compact('schedule'));
    }

    public function booking(Request $request)
    {
        $userId      = session('user.id');
        $scheduleId  = intval($request->input('schedule_id'));
        $metode      = $request->input('metode_pembayaran', 'transfer');

        if (!in_array($metode, ['transfer', 'ewallet'])) {
            $metode = 'transfer';
        }

        // Cari atau buat student record otomatis jika belum ada
        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            $user = \App\Models\User::find($userId);
            if (!$user) {
                return redirect()->route('siswa.dashboard')->with('error', 'Sesi tidak valid. Silakan login ulang.');
            }
            $student = Student::create([
                'user_id' => $userId,
                'name'    => $user->name,
            ]);
        }

        if (!$scheduleId) {
            return redirect()->back()->with('error', 'Jadwal tidak dipilih.');
        }

        $schedule = Schedule::with('tutor')->find($scheduleId);
        if (!$schedule) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        if ($schedule->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Jadwal ini sudah tidak tersedia. Silakan pilih jadwal lain.');
        }

        $existing = Booking::where('student_id', $student->id)
            ->where('schedule_id', $scheduleId)
            ->whereIn('status_booking', ['pending', 'diterima'])
            ->first();

        if ($existing) {
            // Sudah ada booking aktif → langsung ke gateway
            return redirect()->route('siswa.gateway', $existing->id)
                ->with('info', 'Kamu sudah memiliki booking aktif untuk jadwal ini.');
        }

        $b = DB::transaction(function () use ($student, $scheduleId, $metode, $schedule) {
            $booking = Booking::create([
                'student_id'        => $student->id,
                'schedule_id'       => $scheduleId,
                'tanggal_booking'   => now(),
                'metode_pembayaran' => $metode,
                'status_pembayaran' => 'menunggu',
                'status_booking'    => 'pending',
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'jumlah'     => ($schedule->tutor->tarif ?? 150000) + 4000,
                'metode'     => $metode,
                'status'     => 'menunggu',
            ]);

            return $booking;
        });

        return redirect()->route('siswa.gateway', $b->id);
    }

    public function gateway($id)
    {
        $userId = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->route('siswa.dashboard');
        }
        
        $booking = Booking::with(['schedule.tutor', 'schedule.subject'])
            ->where('id', $id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        return view('siswa.gateway', compact('booking'));
    }

    public function cancelBooking(Request $request)
    {
        $userId    = session('user.id');
        $bookingId = intval($request->input('booking_id'));

        $student = Student::where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $booking = Booking::where('id', $bookingId)->where('student_id', $student->id)->first();
        if (!$booking) {
            return redirect()->route('siswa.dashboard')->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking->status_booking !== 'pending') {
            return redirect()->route('siswa.dashboard')->with('error', 'Hanya booking dengan status pending yang bisa dibatalkan.');
        }

        $booking->update(['status_booking' => 'batal']);
        Payment::where('booking_id', $bookingId)->update(['status' => 'gagal']);

        return redirect()->route('siswa.dashboard')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function confirmPayment(Request $request, $id)
    {
        $userId  = session('user.id');
        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $booking = Booking::with(['schedule', 'payment'])
            ->where('id', $id)
            ->where('student_id', $student->id)
            ->first();

        if (!$booking) {
            return redirect()->route('siswa.dashboard')->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking->status_booking === 'batal') {
            return redirect()->route('siswa.dashboard')->with('error', 'Booking sudah dibatalkan.');
        }

        // Update payment status → berhasil
        if ($booking->payment) {
            $booking->payment->update([
                'status'  => 'berhasil',
                'paid_at' => now(),
            ]);
        }

        // Update booking status_pembayaran → dibayar, status_booking → diterima
        $booking->update([
            'status_pembayaran' => 'dibayar',
            'status_booking'    => 'diterima',
        ]);

        return redirect()->route('siswa.jadwal')
            ->with('success', '✅ Pembayaran berhasil dikonfirmasi! Booking Anda sedang diproses tutor.');
    }
}
