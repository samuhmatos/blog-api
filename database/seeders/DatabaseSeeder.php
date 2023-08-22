<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TemplateSeeder::class,
            PostCategorySeeder::class,
            PostSeeder::class,
            PostReactionSeeder::class,
            PostCommentSeeder::class,
            PostCommentReactionSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
