<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdatePostTest extends PostBase
{
    use RefreshDatabase, WithFaker;

    protected function path(int $postId):string
    {
        return "/api/post/$postId";
    }

    public function test_it_should_update_a_post(): void
    {
        $data = $this->init();
        $category = $data['category'];
        $user = $data['user'];
        $post = $data['post'];

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');


        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $category->id
        ];

        $response = $this->actingAs($user)
            ->putJson($this->path($post->id), $newPost);

        $response->assertOk();
    }
    public function test_it_should_return_422_when_not_providing_data():void
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->putJson($this->path($post->id));

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated()
    {
        $data = $this->init();
        $post = $data['post'];

        $response = $this->putJson($this->path($post->id));


        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $data = $this->init();
        $category = $data['category'];
        $user = $data['userComum'];
        $post = $data['post'];

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $category->id
        ];

        $response = $this->actingAs($user)->putJson($this->path($post->id), $newPost);

        $response->assertForbidden();
    }

    public function test_it_should_return_404_when_post_not_found():void
    {
        $data = $this->init();
        $category = $data['category'];
        $user = $data['userComum'];

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $newPost = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => rand(1,2) == 2 ? true : false,
            'category_id'=> $category->id
        ];

        $response = $this->actingAs($user)->putJson("/api/post/1000", $newPost);

        $response->assertNotFound();
    }
}
