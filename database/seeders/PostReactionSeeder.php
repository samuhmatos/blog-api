<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        for ($i = 0; $i < 150; $i++) {
            $user = $users->random();
            $post = $posts->random();

            if(!$this->alreadyExistUserReaction($user,$post)){
                PostReaction::factory()
                    ->set('user_id', $user->id)
                    ->set('post_id', $post->id)
                    ->create();
            }

        }
    }

    private function alreadyExistUserReaction(User $user, Post $post):Bool
    {
        $reaction = PostReaction::query()
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->get();

        return $reaction->count() >= 1 ? true : false;
    }
}
