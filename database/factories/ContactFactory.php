<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'=> fake()->unique()->safeEmail(),
            'name'=> fake()->name(),
            'phone'=> fake()->phoneNumber(),
            'subject'=> fake()->realText(80),
            'message'=> fake()->realText(255)
        ];
    }
}
