<?php

namespace Tests\Feature\Contact;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use WithFaker;
    public function test_it_should_create_a_contact(): void
    {
        $response = $this->postJson('/api/contact', [
            'email'=> $this->faker->email(),
            'name' => $this->faker->name(),
            'phone'=> $this->faker->phoneNumber(),
            'subject' => $this->faker->realText(100),
            'message' => $this->faker->realText(250),
        ]);

        $response->assertNoContent();
    }

    public function test_it_should_return_422_when_providing_wrong_data(): void
    {
        $response = $this->postJson('/api/contact');

        $response->assertUnprocessable();
    }
}
