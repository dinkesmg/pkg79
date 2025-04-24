<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        // $schedule->command('riwayat:simpus')->everyMinute();
        $schedule->call(function () {
            Log::info('call');
            app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg();
            app()->make(\App\Http\Controllers\MasterController::class)->data_simpus_master_provider1();
            app()->make(\App\Http\Controllers\PasienBPJSController::class)->data_simpus();
        })->dailyAt('04:00')->timezone('Asia/Jakarta');
        $schedule->call(function () {
            Log::info('call');
            app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg();
            app()->make(\App\Http\Controllers\MasterController::class)->data_simpus_master_provider1();
            app()->make(\App\Http\Controllers\PasienBPJSController::class)->data_simpus();
            // })->everyThreeHours();
        })->everyEightHours();
        // })->dailyAt('04:00')->timezone('Asia/Jakarta');
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