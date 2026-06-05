<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Alter users table to add role column
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa', 'tutor'])->default('siswa')->after('email');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel')->unique();
        });

        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('subject_id');
            $table->string('name');
            $table->text('bio')->nullable();
            $table->integer('tarif')->default(0);
            $table->enum('status', ['pending', 'aktif', 'ditolak'])->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('subject_id')->references('id')->on('subjects')->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('subject_id');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota')->default(1);
            $table->enum('status', ['tersedia', 'penuh', 'nonaktif'])->default('tersedia');
            $table->timestamps();
            $table->foreign('tutor_id')->references('id')->on('tutors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('subject_id')->references('id')->on('subjects')->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('schedule_id');
            $table->dateTime('tanggal_booking')->useCurrent();
            $table->enum('metode_pembayaran', ['transfer', 'ewallet'])->default('transfer');
            $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'ditolak'])->default('menunggu');
            $table->enum('status_booking', ['pending', 'diterima', 'selesai', 'batal'])->default('pending');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('schedule_id')->references('id')->on('schedules')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->unique();
            $table->decimal('jumlah', 12, 2)->default(0);
            $table->enum('metode', ['transfer', 'ewallet'])->default('transfer');
            $table->enum('status', ['menunggu', 'berhasil', 'gagal'])->default('menunggu');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('tutors');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('students');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
