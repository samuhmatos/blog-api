<?php

namespace App\Observers;

use App\Jobs\NotifyNewsLetter;
use App\Mail\PostPublished;
use App\Models\Newsletter;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        // notfy the newsletter with the the post link

        // if(!$post->is_draft){
        //     $newsLetterUsers = Newsletter::all();

        //    foreach (["teste@gmail", "samuh@gmail.com"] as $value) {
        //        // Mail::send(new PostPublished($value));
        //         NotifyNewsLetter::dispatch($value);
        //    }

        // }
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
