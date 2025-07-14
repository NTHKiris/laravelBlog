<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
        'category_id',

    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function thumpnail()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'thumpnail');
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
