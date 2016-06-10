<?php

namespace App\Console;

use App\Tweet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tweets = Tweet::where('scheduled','<=',date('Y-m-d H:i:s'))
                ->where('status','=','scheduled')->get();
            foreach($tweets as $tweet) {
                $tweet->sendViaApi();
            }
        })->everyMinute();
    }
}
