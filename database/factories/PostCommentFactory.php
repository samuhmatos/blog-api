<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComment>
 */
class PostCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actualData = PostComment::all();
        $users = User::query()->where('is_admin',1)->get();
        $posts = Post::all();

        return [
            'user_id'=>  $users->random()->id,
            'post_id'=>  $posts->random()->id,
            'parent_id'=> rand(1,3) == 2 && $actualData->count() > 0 ? $actualData->random()->id : null,
            'comment'=> fake()->realText()
        ];
    }
}
