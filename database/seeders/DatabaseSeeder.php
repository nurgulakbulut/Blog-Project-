<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        
        foreach (Category::all() as $category) {
            $category->followers()->attach(
                User::inRandomOrder()->take(rand(1, 6))->pluck('id')
            );
        }

        \App\Models\Post::factory(50)->create();
        \App\Models\Tag::factory(20)->create();

        foreach (Post::all() as $post) {
            $post->tags()->attach(
                Tag::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        }

    }
}
