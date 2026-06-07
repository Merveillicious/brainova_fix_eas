<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'tutor_id', 'jumlah', 'metode', 'nomor_rekening',
        'nama_pemilik', 'status', 'catatan', 'processed_at',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
