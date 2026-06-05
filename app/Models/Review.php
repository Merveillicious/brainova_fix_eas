<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['booking_id', 'student_id', 'tutor_id', 'rating', 'komentar'];

    public function booking()  { return $this->belongsTo(Booking::class); }
    public function student()  { return $this->belongsTo(Student::class); }
    public function tutor()    { return $this->belongsTo(Tutor::class); }
}
