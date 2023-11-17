<?php

namespace App\Services;

use App\DTOs\PostComments\CreatePostCommentDTO;
use App\DTOs\PostComments\DestroyPostCommentDTO;
use App\DTOs\PostComments\UpdatePostCommentDTO;
use App\Models\PostComment;
use App\Repositories\PostCommentRepository;

class PostCommentService {
    public function __construct(
        protected PostCommentRepository $repository
    )
    {}

    public function store(CreatePostCommentDTO $params): PostComment
    {
        $createdComment = $this->repository->create([
            "post_id" => $params->post_id,
            "user_id" => $params->user_id,
            "comment" => $params->comment,
            "parent_id" => $params->parent_id,
        ]);

        if(!$createdComment) {
            throw new \ErrorException("Unexpected error ocurred");
        }

        return $createdComment->load('user');
    }

    public function update(UpdatePostCommentDTO $params):PostComment
    {
        $update = $this->repository->update($params->id, [
            'comment' => $params->comment,
        ]);


        if(!$update) {
            throw new \ErrorException("Unexpected error ocurred");
        }

        $comment = $this->repository->find($params->id);

        return $comment->load("user");
    }

    public function destroy(DestroyPostCommentDTO $param): bool
    {
        $removedComment =  $this->repository->delete($param->id);

        if(!$removedComment) {
            throw new \ErrorException("Unexpected error ocurred");
        }

        return true;
    }
}
