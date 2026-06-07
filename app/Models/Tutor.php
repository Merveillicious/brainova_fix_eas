<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = ['user_id', 'subject_id', 'name', 'bio', 'tarif', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
