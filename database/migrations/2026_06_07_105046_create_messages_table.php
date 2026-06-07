<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');   // users.id
            $table->unsignedBigInteger('receiver_id'); // users.id
            $table->text('body');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['sender_id', 'receiver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
