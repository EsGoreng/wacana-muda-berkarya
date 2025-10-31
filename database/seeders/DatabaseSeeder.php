<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Category::create([
        //     'name' => 'Web Design',
        //     'slug' => 'web-design',
        // ]);

        // Post::create([
        //     'title' => 'Artikel 1',
        //     'author_id' => 1,
        //     'category_id' => 1,
        //     'slug' => 'judul-artikel-1',
        //     'body' => '"Lorem ipsum" is a placeholder text used in graphic design and publishing to show the visual form of a document or typeface without relying on meaningful content. It is derived from a classical Latin text but is intentionally nonsensical, making it useful for demonstrating design layouts while keeping the focus on the visual elements rather than the words themselves.'
        // ]);

        $this->call([CategorySeeder::class, UserSeeder::class]);
        
        Post::factory(100)->recycle([
            Category::all(),
            User::all(),
        ])->create();
    }
}
