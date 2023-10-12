<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_it_should_update_a_post(): void
    {
        $categories = PostCategory::factory()->count(3)->create();
        $user = User::factory()->set('is_admin', true)->create();
        $post = Post::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');


        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $categories->random()->id
        ];

        $response = $this->actingAs($user)->putJson("/api/post/$post->id", $newPost);

        $response->assertOk();
    }
    public function test_it_should_return_422_when_not_providing_data():void
    {
        $categories = PostCategory::factory()->count(3)->create();
        $user = User::factory()->set('is_admin', true)->create();
        $post = Post::factory()->create();


        $response = $this->actingAs($user)->putJson("/api/post/$post->id");

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(){
        $categories = PostCategory::factory()->count(3)->create();
        $user = User::factory()->set('is_admin', true)->create();
        $post = Post::factory()->create();


        $response = $this->putJson("/api/post/$post->id");


        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        User::factory()->set('is_admin', true)->create();
        $user = User::factory()->set('is_admin', false)->create();
        $categories = PostCategory::factory()->count(2)->create();
        $post = Post::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $categories->random()->id
        ];

        $response = $this->actingAs($user)->putJson("/api/post/$post->id", $newPost);

        $response->assertForbidden();
    }

    public function test_it_should_return_404_when_post_not_found():void
    {
        User::factory()->set('is_admin', true)->create();
        $user = User::factory()->set('is_admin', false)->create();
        $categories = PostCategory::factory()->count(2)->create();
        $post = Post::factory()->create();

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $categories->random()->id
        ];

        $response = $this->actingAs($user)->putJson("/api/post/1000", $newPost);

        $response->assertNotFound();
    }
}
