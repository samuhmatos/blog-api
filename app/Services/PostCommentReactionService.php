<?php

namespace App\Services;

use App\DTOs\PostCommentReaction\CreatePostCommentReactionDTO;
use App\Enums\ReactionType;
use App\Models\PostCommentReaction;
use App\Repositories\PostCommentReactionRepository;

class PostCommentReactionService
{
    public function __construct(
        protected PostCommentReactionRepository $repository
    ){}

    public function store(CreatePostCommentReactionDTO $commentReactionDTO):array
    {
        $commentId = $commentReactionDTO->commentId;

        $reaction = $this->repository->updateOrCreate(
            [
                'comment_id'=> $commentId,
                'user_id'=> auth()->id()
            ],
            ['type'=> $commentReactionDTO->reactionType]
        );

        return [
            'reaction' => $reaction,
            'count' => [
                'like' => $this->repository->count($commentReactionDTO->commentId, ReactionType::LIKE),
                'unlike' => $this->repository->count($commentReactionDTO->commentId, ReactionType::UNLIKE),
            ]
        ];
    }

    public function show(int $commentId)
    {
        return $this->repository->show($commentId, auth()->id());
    }

    public function delete(int $commentId)
    {
        $reaction = $this->repository->show($commentId, auth()->id());
        $reaction->delete();
    }
}
