<?php

namespace Tests\Feature\Template;

use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_the_specific_template(): void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $template = Template::factory()->create();
        $template->load('categories');

        $response = $this->actingAs($user)->getJson("/api/template/{$template->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment($template->toArray());
    }

    public function test_it_should_return_template_list(): void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $template = Template::factory()->count(10)->create();
        $template->load('categories');

        $response = $this->actingAs($user)->getJson("/api/template/");

        $response->assertStatus(200);
        $response->assertJsonIsArray();
    }
}
