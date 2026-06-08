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

    /**
     * Get the photo URL — actual upload if exists, otherwise ui-avatars fallback.
     */
    public function getPhotoUrlAttribute(): string
    {
        $photo = $this->user?->photo;
        if ($photo && file_exists(public_path('storage/photos/' . $photo))) {
            return asset('storage/photos/' . $photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff';
    }
}
