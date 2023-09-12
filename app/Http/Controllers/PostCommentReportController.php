<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostCommentReport;
use Illuminate\Http\Request;

class PostCommentReportController extends Controller
{
    public function store(Request $request, Post $post, PostComment $postComment)
    {
        $this->authorize('matchPost',[$postComment, $post]);

        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();

        $report = PostCommentReport::create([
            'comment_id' => $postComment->id,
            'user_id' => $user->id,
            'reason' => $request->reason
        ]);

        return response()->noContent();

    }
}
