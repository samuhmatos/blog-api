<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\DTOs\PostCommentReports\PaginatePostCommentReportsDTO;
use App\DTOs\PostComments\CreatePostCommentDTO;
use App\DTOs\PostComments\DestroyPostCommentDTO;
use App\DTOs\PostComments\UpdatePostCommentDTO;
use App\Http\Requests\PostComment\CreatePostCommentRequest;
use App\Http\Requests\PostComment\UpdatePostCommentRequest;
use App\Models\PostComment;
use App\Services\PostCommentService;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct(
        protected PostCommentService $service
    ){}

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $reportsType = $request->get('reports_type');

        $paginateDTO = new PaginatePostCommentReportsDTO($page, $perPage, $reportsType);

        return response(
            PaginationAdapter::toJson(
                $this->service->paginateWithReports($paginateDTO)
            )
        );
    }

    public function store(CreatePostCommentRequest $request)
    {
        $createdComment = $this->service->store(
            new CreatePostCommentDTO(
                user_id: auth()->id(),
                post_id: $request->validated('post_id'),
                comment: $request->validated('comment'),
                parent_id: $request->validated('parent_id'),
            )
        );

        return response($createdComment, 201);
    }

    public function update(UpdatePostCommentRequest $request, PostComment $postComment)
    {
        $comment = $this->service->update(
            new UpdatePostCommentDTO($postComment->id, $request->comment)
        );

        return response($comment);
    }

    public function destroy(PostComment $postComment)
    {
        $this->authorize('owner', [$postComment]);

        $this->service->destroy(new DestroyPostCommentDTO($postComment->id));
        return response()->noContent();
    }


}
