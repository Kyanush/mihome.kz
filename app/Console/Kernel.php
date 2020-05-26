<?php

namespace App\Console;

use App\Console\Commands\mi_home_kz;
use App\Console\Commands\real_store_kz;
use App\Console\Commands\xiaomi_store_kz;
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
        mi_home_kz::class,
        xiaomi_store_kz::class,
        real_store_kz::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //https://tutsforweb.com/how-to-set-up-task-scheduling-cron-job-in-laravel/
        $schedule->command('command:mi_hone_kz')->everyFiveMinutes();
        $schedule->command('command:xiaomi_store_kz')->everyMinute();
        $schedule->command('command:real_store_kz')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
       // $this->load(__DIR__.'/Commands');

       // require base_path('routes/console.php');
    }
}
