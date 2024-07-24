<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostComments;



class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        PostComments::create([
            'editor' => 'John doe',
            'post_id' => '4',
            'comment' => "testing"
        ]);
    }
}
