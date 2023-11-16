<?php

namespace Database\Seeders;

use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $comments = PostComment::all();

        for ($i = 0; $i < 60; $i++) {
            $user = $users->random();
            $comment = $comments->random();

            if(!$this->alreadyExistUserReaction($user, $comment)) {
                PostCommentReaction::factory()
                    ->set('user_id', $user->id)
                    ->set('comment_id', $comment->id)
                    ->create();
            }

        }
    }

    private function alreadyExistUserReaction(User $user, PostComment $comments):Bool
    {
        $reaction = PostCommentReaction::query()
            ->where('user_id', $user->id)
            ->where('comment_id', $comments->id)
            ->get();

        return $reaction->count() >= 1 ? true : false;
    }
}
