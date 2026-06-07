<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id');
            $table->decimal('jumlah', 12, 2);
            $table->enum('metode', ['transfer_bank', 'gopay', 'ovo', 'dana'])->default('transfer_bank');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik');
            $table->enum('status', ['pending', 'diproses', 'berhasil', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->foreign('tutor_id')->references('id')->on('tutors')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
