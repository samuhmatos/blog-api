<?php

namespace App\Console\Commands;

use App\Events\WeeklyNewsLetter;
use Illuminate\Console\Command;

class NewsLetterWeeklyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the NewsLetter list about the weekly most popular and better posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        event(new WeeklyNewsLetter());
    }
}
