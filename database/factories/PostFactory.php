<?php

namespace Database\Factories;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->where('is_admin',1)->get();
        $category = PostCategory::all();

        $title = fake()->text(150);
        
        return [
            'title'=> $title,
            'sub_title'=> fake()->text(),
            'slug'=> Str::slug($title),
            'content' => fake()->text(),
            'image_url'=> fake()->imageUrl(),
            'views'=> rand(),
            'category_id'=> $category->random()->id,
            'author_id'=> $users->random()->id, // the first 2 users are admin,
        ];
    }
}
