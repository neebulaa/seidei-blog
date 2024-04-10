<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Post::factory(10)->create();
        Tag::create([
            "name" => "Web",
            "slug" => 'web'
        ]);

        Tag::create([
            "name" => "Personal",
            "slug" => 'personal'
        ]);

        Tag::create([
            "name" => "Post",
            "slug" => 'post'
        ]);

        PostTag::factory(10)->create();
    }
}
