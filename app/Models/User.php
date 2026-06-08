<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'photo'];

    // No hashing — plain text password same as original
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }
}
