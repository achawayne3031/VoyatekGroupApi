<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $fillable = [
        'post_id',
        'comment',
        'editor',
    ];


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
