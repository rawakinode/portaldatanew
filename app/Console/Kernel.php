<?php

namespace App\Console;

use App\Jobs\RunRekapUniversitas;
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
        // $schedule->command('inspire')->hourly();
        // $schedule->command('rekap-data-universitas')->everyMinute();
        $schedule->command('rekap-data-universitas')->cron('0 0,6,12,18 * * *');
        $schedule->command('hitung:mahasiswa-aktif')->cron('0 0,6,12,18 * * *');
        //$schedule->command('prodi-rekap-mahasiswa-aktif')->hourly();
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
