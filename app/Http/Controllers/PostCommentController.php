<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function index(Post $post)
    {
        $postComments = PostComment::with(['user', 'answers.user'])->where('post_id', $post->id)->where('parent_id', null)->get();

        return response($postComments);
    }
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'parent_id' => ['integer', "exists:post_comments,id"],
            'comment' => ['required', 'string', 'max:500']
        ]);

        $payload = $request->only(['parent_id', 'comment']);
        $payload['user_id'] = auth()->user()->id;
        $payload['post_id'] = $post->id;

        $postComment = PostComment::query()->create($payload);
        $postComment = $postComment->refresh()->load(['user', 'parent']);
        return response($postComment, 201);
    }

    public function update(Request $request, Post $post, PostComment $postComment)
    {
        $request->validate([
            'comment'=> ['required', 'string', 'max:500']
        ]);

        $this->authorize('matchUser', $postComment);
        $this->authorize('matchPost', [$postComment, $post]);

        $postComment->comment = $request->input('comment');
        $postComment->save();
        $postComment->load('user');

        return response($postComment, 201);
    }

    public function destroy(Request $request, Post $post, PostComment $postComment)
    {
        $this->authorize('matchUser', $postComment);
        $this->authorize('matchPost', [$postComment, $post]);

        $postComment->delete();

        return response()->noContent();
    }


}
