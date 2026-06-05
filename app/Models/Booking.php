<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'student_id', 'schedule_id', 'tanggal_booking',
        'metode_pembayaran', 'status_pembayaran', 'status_booking'
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
