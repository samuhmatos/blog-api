<?php

namespace App\Http\Controllers;

use App\DTOs\PostCommentReports\CreatePostCommentReportDTO;
use App\DTOs\PostCommentReports\UpdatePostCommentReportDTO;
use App\Http\Requests\PostCommentReportRequest;
use App\Models\PostCommentReport;
use App\Services\PostCommentReportService;
use Illuminate\Http\Request;

class PostCommentReportController extends Controller
{
    public function __construct(
        public PostCommentReportService $service
    ){}
    public function store(PostCommentReportRequest $request)
    {
        $dto = new CreatePostCommentReportDTO($request->comment_id, $request->message);

        $this->service->create($dto);

        return response()->noContent();
    }

    public function update(PostCommentReportRequest $request, int $id)
    {
        $dto = new UpdatePostCommentReportDTO(
            $request->status,
            $id
        );

        $this->service->update($dto);

        return response()->noContent();
    }

    public function show(Request $request, int $id)
    {
        return $this->service->show($id);
    }
}
