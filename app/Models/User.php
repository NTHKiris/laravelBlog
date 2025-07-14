<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function hasRole($role)
    {
        if (!$this->role)
            return false;
        return $this->role->slug === $role;
    }
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function avatar()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'avatar');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
