<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class PostCommentReactionController extends Controller
{
    public function store(Request $request, PostComment $postComment): Response
    {
        $request->validate([
            'type' => ['required', 'string', new Enum(ReactionType::class)]
        ]);

        $payload = $request->only(['type']);

        $reaction = PostCommentReaction::query()->updateOrCreate(
            ['comment_id'=> $postComment->id, 'user_id'=> auth()->user()->id],
            ['type'=>$payload['type']]
        );


        $like = PostCommentReaction::withReactionCount($postComment->id, ReactionType::LIKE);
        $unlike = PostCommentReaction::withReactionCount($postComment->id, ReactionType::UNLIKE);

        return response([
            'reaction' => $reaction,
            'count' => [
                'like' => $like,
                'unlike' => $unlike
            ]
        ], 201);
    }

    public function show(Request $request, PostComment $postComment)
    {
        $reaction = PostCommentReaction::query()
            ->where('comment_id', $postComment->id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response($reaction);
    }

    public function destroy(PostComment $postComment): Response
    {
        $user_id = auth()->user()->id;
        $postReaction = PostCommentReaction::query()
            ->where('user_id', $user_id)
            ->where('comment_id', $postComment->id)
            ->firstOrFail();

        $postReaction->delete();

        return response()->noContent();
    }
}
