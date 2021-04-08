<?php

namespace App\Console;

use App\Console\Commands\LinkedinApiLogin;
use App\Console\Commands\LinkedinJson;
use App\Console\Commands\LinkedinPuppeteerLogin;
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

        LinkedinApiLogin::class,
        LinkedinPuppeteerLogin::class,
        LinkedinJson::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:LinkedinApiLogin')->timezone('Asia/Yerevan')->at('16:35')->everySixHours();
        $schedule->command('command:LinkedinPuppeteerLogin')->timezone('Asia/Yerevan')->at('16:35')->everySixHours();
        $schedule->command('command:LinkedinJson')->timezone('Asia/Yerevan')->at('16:35')->everySixHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
