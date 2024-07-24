<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

     



        $this->call(PostCommentSeeder::class);
        $this->call(PostLikeSeeder::class);

        
        \App\Models\PostLikes::factory(10)->create();
        \App\Models\PostComments::factory(10)->create();



       //  \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
