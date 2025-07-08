<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->chaperone();
    }
    public function latestComment()
    {
        return $this->hasOne(Comment::class)->latestOfMany();
    }
    public function oldestComment()
    {
        return $this->hasOne(Comment::class)->oldestOfMany();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
