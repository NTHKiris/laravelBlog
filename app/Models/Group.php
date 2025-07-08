<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'max_members',
        'is_active'
    ];

    public function users() {
        return $this->belongsToMany(User::class)
                    ->withPivot('joined_at','is_admin') ;
    }
    public function admin() {
        return $this->belongsToMany(User::class)
                    ->withPivot('joined_at', 'is_admin');
    }
    public function admins()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('joined_at', 'is_admin')
                    ->wherePivot('is_admin', true);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('joined_at', 'is_admin')
                    ->wherePivot('is_admin', false);
    }
}
