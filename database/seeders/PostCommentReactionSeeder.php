<?php

namespace Database\Seeders;

use App\Models\PostCommentReaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostCommentReaction::factory()->count(30)->create();
    }
}
