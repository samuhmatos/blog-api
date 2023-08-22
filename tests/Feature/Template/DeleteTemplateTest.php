<?php

namespace Tests\Feature\Template;

use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class DeleteTemplateTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_it_should_delete_the_template(): void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $template = Template::factory()->create();


        $response = $this->actingAs($user)->deleteJson("/api/template/{$template->id}");

        $response->assertNoContent();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson("/api/template/{$template->id}");

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();
        $template = Template::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/template/{$template->id}");

        $response->assertForbidden();
    }

    public function test_it_should_return_404_when_providing_unexisting_template():void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $response = $this->actingAs($user)->deleteJson("/api/template/200");

        $response->assertNotFound();
    }
}
