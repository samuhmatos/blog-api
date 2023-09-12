<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PostReactionController extends Controller
{
    public function show(Request $request, Post $post)
    {
        $reaction = PostReaction::query()->where('post_id', $post->id)->where('user_id', $request->user()->id)->first();

        return response($reaction);
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'type' => ['required', 'string', new Enum(ReactionType::class)]
        ]);

        $payload = $request->only(['type']);

        $reaction = PostReaction::query()->updateOrCreate(
            ['post_id'=> $post->id, 'user_id'=> auth()->user()->id],
            ['type'=>$payload['type']]
        );

        return response($reaction, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user_id = auth()->user()->id;
        $postReaction = PostReaction::query()->where('user_id', $user_id)->where('post_id', $post->id)->firstOrFail();
        $postReaction->delete();

        return response()->noContent();
    }
}
