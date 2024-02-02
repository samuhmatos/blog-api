<?php

namespace Tests\Feature\PostCommentReport;

use App\Models\PostComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\TestBase;

class CreatePostCommentReportTest extends TestBase
{
    use RefreshDatabase, WithFaker;

    public PostComment $postComment;

    const path = "/api/comment/report";

    public function test_it_should_create_a_post_comment_report(): void
    {
        $params = [
            'message' => $this->faker->text(),
            'comment_id' => $this->postComment->id
        ];

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::path, $params);

        $response->assertNoContent();
    }

    public function test_it_should_return_422_error_when_providing_wrong_data():void
    {
        $params = [
            'message' => 2,
            'comment_id' => 1000
        ];

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::path, $params);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_unauthorized():void
    {
        $params = [
            'message' => $this->faker->text(),
            'comment_id' => $this->postComment->id
        ];

        $response = $this->postJson(self::path, $params);

        $response->assertUnauthorized();
    }
}
