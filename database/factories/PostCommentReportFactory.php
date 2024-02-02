<?php

namespace Database\Factories;

use App\Enums\ReportsType;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCommentReport>
 */
class PostCommentReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment_id' => PostComment::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'message' => fake()->text(),
        ];
    }
}
