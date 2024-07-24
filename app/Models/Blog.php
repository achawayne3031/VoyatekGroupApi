<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'editor',
        'total_views'
    ];


    public function post()
    {
        return $this->hasMany(Post::class, 'blog_id', 'id');
    }
    
}
