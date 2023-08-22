<?php

namespace Database\Seeders;

use App\Models\PostReaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostReaction::factory()->count(100)->create();
    }
}
