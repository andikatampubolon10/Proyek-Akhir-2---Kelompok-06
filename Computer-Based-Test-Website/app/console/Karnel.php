<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Menjadwalkan perintah untuk dijalankan setiap hari
        $schedule->command('operator:update-status')
                 ->daily(); // Menjalankan perintah setiap hari
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Memuat semua perintah artisan yang ada di folder 'Commands'
        $this->load(__DIR__.'/Commands');

        // Menambahkan routes/console.php untuk mendaftarkan perintah-perintah khusus
        require base_path('routes/console.php');
    }
}
