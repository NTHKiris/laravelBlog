<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function Notifications()
    {
        return $this->morphToMany(Notification::class, 'notiable')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
