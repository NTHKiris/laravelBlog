<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;


    public function users()
    {
        return $this->morphedByMany(User::class, 'notiable')
            ->withPivot('read_at')
            ->withTimestamps();
        ;
    }
    public function teachers()
    {
        return $this->morphedByMany(Teacher::class, 'notiable')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
