<?php

namespace Tests\Feature\NewsLetter;

use App\Models\Newsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewsLetterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $path = "/api/newsletter";

    public function test_it_should_subscribe_a_new_registry_newsletter(): void
    {
        $response = $this->postJson($this->path, [
            'email' => $this->faker->email()
        ]);

        $response->dump();

        $response->assertNoContent();
    }

    public function test_it_should_return_422_when_email_already_exists():void
    {
        $newsLetter = Newsletter::factory()->create();

        $response = $this->postJson($this->path, [
            'email' => $newsLetter->email,
        ]);

        $response->assertUnprocessable();
    }
}
