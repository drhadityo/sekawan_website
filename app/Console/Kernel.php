<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('down')->daily();
        $schedule->command('db:clean')->daily();
        $schedule->command('model:prune')->daily();
        $schedule->command('activitylog:clean')->daily();
        $schedule->command('cache:clear')->monthly();
        $schedule->command('queue:clear')->monthly();
        $schedule->command('view:clear')->monthly();
        $schedule->command('config:cache')->monthly();
        $schedule->command('event:cache')->monthly();
        $schedule->command('route:cache')->monthly();
        $schedule->command('view:cache')->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
