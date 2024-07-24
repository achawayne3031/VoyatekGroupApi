<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLikes extends Model
{
    use HasFactory;

    protected $table = 'post_likes';

    protected $fillable = [
        'post_id',
        'editor',
    ];
}