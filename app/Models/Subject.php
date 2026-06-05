<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    protected $fillable = ['nama_mapel'];

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
