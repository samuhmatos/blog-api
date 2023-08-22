<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->text(100);
        return [
            'name'=> $name,
            'slug'=> Str::slug($name),
            'description'=> fake()->text(),
            'image_url'=> fake()->imageUrl(),
        ];
    }
}
