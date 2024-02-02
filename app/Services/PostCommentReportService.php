<?php

namespace App\Services;

use App\DTOs\PostCommentReports\CreatePostCommentReportDTO;
use App\DTOs\PostCommentReports\UpdatePostCommentReportDTO;
use App\Repositories\PostCommentReportRepository;
use Illuminate\Support\Facades\Auth;

class PostCommentReportService {
    public function __construct(
        public PostCommentReportRepository $repository,
        public PostCommentService $postCommentService
    ) {}

    public function create(CreatePostCommentReportDTO $createPostCommentReportDTO)
    {
        $this->repository->create([
            'comment_id' => $createPostCommentReportDTO->commentId,
            'user_id' => Auth::id(),
            'message' => $createPostCommentReportDTO->message
        ]);
    }

    public function update(UpdatePostCommentReportDTO $updatePostCommentReportDTO)
    {
        $this->repository->findOrFail($updatePostCommentReportDTO->reportId);

        $this->repository->update(
            $updatePostCommentReportDTO->reportId,
            ['status' => $updatePostCommentReportDTO->reportsType]
        );
    }

    public function show(int $id)
    {
        return $this->repository
            ->findOrFail($id);
    }
}
