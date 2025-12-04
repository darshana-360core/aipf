<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('business:sync')->everyFiveMinutes()->withoutOverlapping(10)->onOneServer();

        $schedule->command('check:level')->everyTwoHours()->withoutOverlapping(180)->onOneServer();
        // $schedule->command('check:rank')->everyTwoHours()->withoutOverlapping(180)->onOneServer();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
