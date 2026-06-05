<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['tutor_id', 'subject_id', 'hari', 'tanggal', 'jam_mulai', 'jam_selesai', 'kuota', 'status'];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
