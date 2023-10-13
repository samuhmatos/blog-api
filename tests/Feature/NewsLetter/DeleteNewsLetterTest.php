<?php

namespace Tests\Feature\NewsLetter;

use App\Models\Newsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteNewsLetterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $path = "/api/newsletter/unsubscribe/";

    protected function path(string $email, string|null $token = null):string
    {
        if($token){
            return "/api/newsletter/unsubscribe/{$email}?token={$token}";
        }

        return "/api/newsletter/unsubscribe/{$email}";
    }

    public function test_it_should_unsubscribe_from_newsletter(): void
    {
        $newsLetter = Newsletter::factory()->create();

        $response = $this->deleteJson($this->path($newsLetter->email, $newsLetter->token));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_providing_wrong_email():void
    {
        $newsLetter = Newsletter::factory()->create();

        $response = $this->deleteJson($this->path($this->faker()->email, $newsLetter->token));

        $response->assertNotFound();

    }

    public function test_it_should_return_404_when_not_providing_token():void
    {
        $newsLetter = Newsletter::factory()->create();

        $response = $this->deleteJson($this->path($newsLetter->email));

        $response->assertNotFound();

    }

    public function test_it_should_return_404_when_providing_wrong_token():void
    {
        $newsLetter = Newsletter::factory()->create();

        $response = $this->deleteJson($this->path($newsLetter->email, $this->faker->text()));

        $response->assertNotFound();
    }
}
