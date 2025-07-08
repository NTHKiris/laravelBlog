<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Symfony\Component\HttpKernel\EventListener\ProfilerListener;
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
        'country_id'
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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function postCategory()
    {
        return $this->hasOneThrough(
            Category::class,    // 1. Model cuối cùng muốn lấy
            Post::class,        // 2. Model trung gian
            'user_id',          // 3. posts.user_id (liên kết với users)
            'id',               // 4. categories.id (primary key của categories)
            'id',               // 5. users.id (primary key của users)
            'category_id'       // 6. posts.category_id (liên kết với categories)
        );
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('joined_at', 'is_admin');
    }

    public function adminGroup()
    {
        return $this->belongsToMany(Group::class)->withPivot('joined_at', 'is_admin')->wherePivot('is_admin', true);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function latestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }
    public function oldestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }
    public function ImageHighestId()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany('id', 'max');
    }
    public function Notifications()
    {
        return $this->morphToMany(Notification::class, 'notiable')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        if (is_array($role)) {
            return $this->roles->whereIn('slug', $role)->count() > 0;
        }
        return $this->roles->contains($role);
    }
    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}

