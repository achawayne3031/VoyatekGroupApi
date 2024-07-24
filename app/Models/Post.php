<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [
        'blog_id',
        'title',
        'description',
        'image_url',
        'editor',
        'total_views',
        'total_likes'
    ];


    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }


    public function post_comment()
    {
        return $this->hasMany(PostComments::class, 'post_id', 'id');
    }
    

    public function post_like()
    {
        return $this->hasMany(PostLikes::class, 'post_id', 'id');
    }
    



    

}
