<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCommentReaction>
 */
class PostCommentReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $users = User::query()->where('is_admin',0)->get();
        // $commentID = PostComment::all();

        return [
            // 'user_id'=> $users->random()->id,
            // 'comment_id'=> $commentID->random()->id,
            'type'=> rand(0,1) == 1 ? 'LIKE' : "UNLIKE"
        ];
    }
}
