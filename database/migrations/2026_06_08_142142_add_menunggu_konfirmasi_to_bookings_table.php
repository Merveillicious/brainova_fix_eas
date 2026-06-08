<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status_pembayaran dari ENUM ke VARCHAR agar lebih fleksibel
        DB::statement("ALTER TABLE bookings MODIFY status_pembayaran VARCHAR(30) NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY status_pembayaran ENUM('menunggu','dibayar','ditolak') NOT NULL DEFAULT 'menunggu'");
    }
};
