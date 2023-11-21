<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreatePostTest extends PostBase
{
    use RefreshDatabase;

    protected $path = "/api/post";

    public function test_it_should_create_a_post(): void
    {
        $data = $this->init();
        $category = $data['category'];
        $user = $data['user'];

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $post = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'is_draft' => false,
            'category_id'=> $category->id,
            'img_content_list' => [
                "http://localhost:8000/storage/uploads/posts/contents/DQEd39K3i4zZNhx1sYO1utsoArRVnL1lSE0ZNx6T.jpg"
            ]
        ];

        $response = $this->actingAs($user)->postJson($this->path, $post);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $data = $this->init();
        $user = $data['user'];

        $response = $this->actingAs($user)->postJson($this->path);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(){
        $this->init();

        $response = $this->postJson($this->path,);

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $data = $this->init();
        $category = $data['category'];
        $user = $data['userComum'];

        Storage::fake('post_banner');
        $file = UploadedFile::fake()->image('post_banner.jpg');

        $post = [
            'title' => "This is the title's post",
            'sub_title'=> "This is the sub title's post",
            'content' => "This is the content of the post",
            'banner'=> $file,
            'category_id'=> $category->id,
            'is_draft' => rand(1,2) == 2 ? true : false,
        ];

        $response = $this->actingAs($user)->postJson($this->path, $post);

        $response->assertForbidden();
    }

}
