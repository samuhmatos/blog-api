<?php

namespace App\Listeners;

use App\Events\WeeklyNewsLetter;
use App\Jobs\NotifyNewsLetter;
use App\Mail\PostPublished;
use App\Models\Newsletter;
use App\Services\PostServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWeeklyEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected PostServices $postServices
    )
    {}

    /**
     * Handle the event.
     */
    public function handle(WeeklyNewsLetter $event): void
    {
        $newsletterList = Newsletter::all();
        $posts = $this->postServices->getLatestBest(6, true);

        foreach($newsletterList as $newsletter){
            NotifyNewsLetter::dispatch($newsletter, $posts);
         }
    }
}
//todo: email from do email site
