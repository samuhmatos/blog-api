<?php

namespace Tests\Feature\PostCommentReport;

use App\Enums\ReportsType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\TestBase;

class UpdatePostCommentReportTest extends TestBase
{
    use RefreshDatabase, WithFaker;

    protected function path(int $reportId): string
    {
        return "/api/comment/report/{$reportId}";
    }

    public function test_it_should_update_a_post_comment_report(): void
    {
        $params = [
            'status' => ReportsType::random(),
        ];

        $response = $this->actingAs($this->adminUser)
            ->putJson(
                $this->path($this->postCommentReport->id),
                $params
            );

        $response->assertNoContent();
    }

    public function test_it_should_return_422_error_when_providing_wrong_data():void
    {
        $response = $this->actingAs($this->adminUser)
            ->putJson($this->path($this->postCommentReport->id));

            $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_unauthorized():void
    {
        $params = [
            'status' => ReportsType::random(),
        ];

        $response = $this->putJson($this->path($this->postCommentReport->id), $params);

        $response->assertUnauthorized();
    }
}
