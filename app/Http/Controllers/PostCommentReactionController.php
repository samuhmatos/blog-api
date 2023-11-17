<?php

namespace App\Http\Controllers;

use App\DTOs\PostCommentReaction\CreatePostCommentReactionDTO;
use App\Enums\ReactionType;
use App\Models\PostComment;
use App\Services\PostCommentReactionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class PostCommentReactionController extends Controller
{
    public function __construct(
        protected PostCommentReactionService $service
    ){}
    public function store(Request $request, PostComment $postComment): Response
    {
        $request->validate([
            'type' => ['required', 'string', new Enum(ReactionType::class)]
        ]);

        $type = $request->type == ReactionType::LIKE
            ? ReactionType::LIKE
            : ReactionType::UNLIKE;

        $commentCreated = $this->service->store(
            new CreatePostCommentReactionDTO($postComment->id, $type)
        );

        return response($commentCreated, 201);
    }

    public function show(PostComment $postComment): Response
    {
        $reaction = $this->service->show($postComment->id);

        return response($reaction);
    }

    public function destroy(PostComment $postComment): Response
    {
        $this->service->delete($postComment->id);

        return response()->noContent();
    }
}
