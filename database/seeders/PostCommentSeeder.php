<?php

namespace Database\Seeders;

use App\Models\PostComment;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostComment::factory()->count(40)->create();

        for ($i=0; $i < 60; $i++) {

            $allComments = PostComment::all();
            $randomPost = $allComments->random()->post_id;

            $availableComments = PostComment::query()
                ->where('post_id', $randomPost)
                ->where('parent_id', null)
                ->get();

            $randomComment = $availableComments->random();

            PostComment::factory()
                ->set('post_id',$randomPost)
                ->set('parent_id', $randomComment->id)
                ->create();

        }
    }

    protected function randomParentComment(int $postId, int $i)
    {
        $comment = PostComment::query()->where('post_id', $postId)->get();

        return $comment->random()->id;

        do {
            $result = rand(0,2) === 1
                ? rand(1,40 + $i)
                : null;
        } while ($result != $postId);

        return $result;
    }

}
