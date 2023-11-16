<?php

namespace App\Http\Controllers;

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

    public function store(CreatePostCommentRequest $request)
    {
        try {
            $createdComment = $this->service->store(
                new CreatePostCommentDTO(
                    user_id: auth()->id(),
                    post_id: $request->validated('post_id'),
                    comment: $request->validated('comment'),
                    parent_id: $request->validated('parent_id'),
                )
            );

            return response()
                ->json($createdComment, 201);

        }catch(\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdatePostCommentRequest $request, PostComment $postComment)
    {
        try{
            $comment = $this->service->update(
                new UpdatePostCommentDTO($postComment->id, $request->comment)
            );

            return response()->json($comment);
        }catch(\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, PostComment $postComment)
    {
        $this->authorize('owner', [$postComment]);

        try{
            $this->service->destroy(new DestroyPostCommentDTO($postComment->id));

            return response()->noContent();

        }catch(\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], 500);
        }
    }


}
