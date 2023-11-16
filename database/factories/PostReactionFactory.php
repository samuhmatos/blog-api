<?php

namespace Database\Factories;

use App\Enums\ReactionType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostReaction>
 */
class PostReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $users = User::query()->where('is_admin',1)->get();
        // $posts = Post::all();

        return [
            // 'user_id'=> $users->random()->id,
            // 'post_id'=> $posts->random()->id,
            'type'=> rand(0,1) == 1 ? ReactionType::LIKE : ReactionType::UNLIKE
        ];
    }
}
