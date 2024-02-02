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
            NewsLetterSeeder::class,
            PostCategorySeeder::class,
            PostSeeder::class,
            PostReactionSeeder::class,
            PostCommentSeeder::class,
            PostCommentReportSeeder::class,
            PostCommentReactionSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
