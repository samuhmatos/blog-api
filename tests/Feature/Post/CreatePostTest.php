<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_should_create_a_post(): void
    {
        $user = User::factory()->set('is_admin', true)->create();

        Template::factory()->create();
        $category = PostCategory::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');


        $post = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'category_id'=> $category->id
        ];

        $response = $this->actingAs($user)->postJson('/api/post', $post);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $response = $this->actingAs($user)->postJson('/api/post', []);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(){
        $user = User::factory()->set('is_admin', true)->create();

        Template::factory()->create();
        PostCategory::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');


        $post = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'category_id'=> 1
        ];

        $response = $this->postJson('/api/post', $post);

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();

        Template::factory()->create();
        $category = PostCategory::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');


        $post = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'category_id'=> $category->id
        ];

        $response = $this->actingAs($user)->postJson('/api/post', $post);

        $response->assertForbidden();
    }

    public function test_it_should_add_user_view_to_post()
    {
        User::factory()->set('is_admin', true)->create();
        $user = User::factory()->create();

        Template::factory()->create();
        PostCategory::factory()->create();

        $post = Post::factory()->set('views', 0)->create();

        $this->postJson("/api/post/{$post->id}/view")
            ->assertCreated();
    }
}
