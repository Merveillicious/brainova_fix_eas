<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Subject;

class TutorController extends Controller
{
    public function dashboard()
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $bookings = collect();
        if ($tutor) {
            $bookings = Booking::with(['schedule', 'student.user', 'payment'])
                ->whereHas('schedule', fn($q) => $q->where('tutor_id', $tutor->id))
                ->orderByDesc('id')
                ->get();
        }

        return view('tutor.dashboard', compact('tutor', 'bookings'));
    }

    public function profil()
    {
        $userId   = session('user.id');
        $tutor    = Tutor::with('subject')->where('user_id', $userId)->first();
        $subjects = Subject::orderBy('nama_mapel')->get();

        if (!$tutor) {
            return redirect()->route('tutor.dashboard')->with('error', 'Profil tutor tidak ditemukan.');
        }

        return view('tutor.profil', compact('tutor', 'subjects'));
    }

    public function updateProfil(Request $request)
    {
        $tutorId   = intval($request->input('tutor_id'));
        $subjectId = intval($request->input('subject_id'));
        $bio       = trim($request->input('bio', ''));
        $tarif     = intval($request->input('tarif', 0));

        Tutor::where('id', $tutorId)->update([
            'subject_id' => $subjectId,
            'bio'        => $bio,
            'tarif'      => $tarif,
        ]);

        return redirect()->route('tutor.profil')->with('success', 'Profil tutor berhasil diperbarui.');
    }

    public function jadwal(Request $request)
    {
        $userId = session('user.id');
        $tutor  = Tutor::with('subject')->where('user_id', $userId)->first();

        $today    = now()->format('Y-m-d');
        $maxDate  = now()->addDays(7)->format('Y-m-d');
        $schedules = collect();
        $editItem  = null;

        if ($tutor) {
            $query = Schedule::with('bookings')
                ->where('tutor_id', $tutor->id)
                ->where(function ($q) use ($today, $maxDate) {
                    $q->whereNull('tanggal')
                      ->orWhereBetween('tanggal', [$today, $maxDate]);
                })
                ->orderBy('tanggal')
                ->orderBy('jam_mulai');

            $schedules = $query->get()->map(function ($sc) {
                $sc->total_booking = $sc->bookings
                    ->whereIn('status_booking', ['pending', 'diterima'])
                    ->count();
                return $sc;
            });

            if ($request->has('edit')) {
                $editId   = intval($request->query('edit'));
                $editItem = Schedule::where('id', $editId)
                    ->where('tutor_id', $tutor->id)
                    ->first();
            }
        }

        $daysId   = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $monthsId = ['January' => 'Jan', 'February' => 'Feb', 'March' => 'Mar', 'April' => 'Apr', 'May' => 'Mei', 'June' => 'Jun', 'July' => 'Jul', 'August' => 'Agu', 'September' => 'Sep', 'October' => 'Okt', 'November' => 'Nov', 'December' => 'Des'];

        $weekDays  = [];
        for ($i = 0; $i <= 7; $i++) {
            $weekDays[] = now()->addDays($i)->format('Y-m-d');
        }

        $activeDate = $request->query('date', $today);
        if ($activeDate < $today || $activeDate > $maxDate) {
            $activeDate = $today;
        }

        $schedByDate = $schedules->groupBy('tanggal');
        $activeScheds = $schedByDate->get($activeDate, collect());

        return view('tutor.jadwal', compact(
            'tutor', 'schedules', 'editItem',
            'today', 'maxDate', 'weekDays', 'activeDate',
            'activeScheds', 'schedByDate', 'daysId', 'monthsId'
        ));
    }

    public function createJadwal(Request $request)
    {
        $userId  = session('user.id');
        $tutor   = Tutor::where('user_id', $userId)->first();
        $today   = now()->format('Y-m-d');
        $maxDate = now()->addDays(7)->format('Y-m-d');
        $daysId  = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $tanggal    = $request->input('tanggal', '');
        $jamMulai   = $request->input('jam_mulai', '');
        $jamSelesai = $request->input('jam_selesai', '');
        $kuota      = max(1, intval($request->input('kuota', 1)));

        if ($tanggal < $today || $tanggal > $maxDate) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tanggal harus dalam rentang hari ini hingga 7 hari ke depan.');
        }
        if (empty($jamMulai) || empty($jamSelesai)) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam mulai dan jam selesai harus diisi.');
        }
        if ($jamSelesai <= $jamMulai) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        // Cek bentrok
        $bentrok = Schedule::where('tutor_id', $tutor->id)
            ->where('tanggal', $tanggal)
            ->where('status', '!=', 'nonaktif')
            ->where('jam_mulai', '<', $jamSelesai)
            ->where('jam_selesai', '>', $jamMulai)
            ->exists();

        if ($bentrok) {
            return redirect()->route('tutor.jadwal')->with('error', 'Terdapat jadwal yang bentrok pada tanggal dan waktu tersebut.');
        }

        $hari = $daysId[date('l', strtotime($tanggal))] ?? 'Senin';

        Schedule::create([
            'tutor_id'    => $tutor->id,
            'subject_id'  => $tutor->subject_id,
            'hari'        => $hari,
            'tanggal'     => $tanggal,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'kuota'       => $kuota,
            'status'      => 'tersedia',
        ]);

        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->input('schedule_id'));
        $today      = now()->format('Y-m-d');
        $maxDate    = now()->addDays(7)->format('Y-m-d');
        $daysId     = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $tanggal    = $request->input('tanggal');
        $jamMulai   = $request->input('jam_mulai');
        $jamSelesai = $request->input('jam_selesai');
        $status     = $request->input('status', 'tersedia');
        $kuota      = max(1, intval($request->input('kuota', 1)));

        if (!in_array($status, ['tersedia', 'nonaktif'])) $status = 'tersedia';
        if ($tanggal < $today || $tanggal > $maxDate) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tanggal harus dalam rentang hari ini hingga 7 hari ke depan.');
        }
        if ($jamSelesai <= $jamMulai) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        $hari = $daysId[date('l', strtotime($tanggal))] ?? 'Senin';
        $schedule->update(['hari' => $hari, 'tanggal' => $tanggal, 'jam_mulai' => $jamMulai, 'jam_selesai' => $jamSelesai, 'kuota' => $kuota, 'status' => $status]);

        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function deleteJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->input('schedule_id'));

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $bookingAktif = $schedule->bookings()->whereIn('status_booking', ['pending', 'diterima'])->exists();
        if ($bookingAktif) {
            return redirect()->route('tutor.jadwal')->with('error', 'Tidak dapat menghapus jadwal yang memiliki booking aktif.');
        }

        $schedule->delete();
        return redirect()->route('tutor.jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function toggleStatusJadwal(Request $request)
    {
        $userId     = session('user.id');
        $tutor      = Tutor::where('user_id', $userId)->first();
        $scheduleId = intval($request->query('id'));

        if (!$tutor) {
            return redirect()->route('tutor.jadwal')->with('error', 'Profil tutor tidak ditemukan.');
        }

        $schedule = Schedule::where('id', $scheduleId)->where('tutor_id', $tutor->id)->first();
        if (!$schedule) {
            return redirect()->route('tutor.jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $newStatus = ($schedule->status === 'nonaktif') ? 'tersedia' : 'nonaktif';
        $schedule->update(['status' => $newStatus]);

        return redirect()->route('tutor.jadwal', ['date' => $request->query('date')])->with('success', 'Status jadwal berhasil diubah.');
    }

    public function updateStatusBooking(Request $request)
    {
        $bookingId     = intval($request->input('booking_id'));
        $statusBooking = $request->input('status_booking');

        if (!in_array($statusBooking, ['pending', 'diterima', 'selesai', 'batal'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        $booking = \App\Models\Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status_booking' => $statusBooking]);
        }

        return redirect()->route('tutor.dashboard')->with('success', 'Status booking berhasil diperbarui.');
    }
}
