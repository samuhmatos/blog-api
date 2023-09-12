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
        $users = User::all();
        $posts = Post::all();

        $randomPost = $posts->random()->id;
        $randomUser = $users->random()->id;

        return [
            'user_id'=>  $randomUser,
            'post_id'=>  $randomPost,
            'parent_id'=> null,
            'comment'=> fake()->realText()
        ];
    }


}
