<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

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
        $schedule->call(function () { //h - 3
            if (Carbon::now()->isSunday()) return;

            Log::info('call jam 02:00');
            app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg_h3();
            // app()->make(\App\Http\Controllers\MasterController::class)->data_simpus_master_provider1();
            // app()->make(\App\Http\Controllers\PasienBPJSController::class)->data_simpus();
            // })->dailyAt('02:00')->timezone('Asia/Jakarta');
        })->dailyAt('02:00')->timezone('Asia/Jakarta');

        $schedule->call(function () {
            if (Carbon::now()->isSunday()) return;

            Log::info('call jam 22:00');
            // app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg();
            app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg_h3();
        })->dailyAt('22:00')->timezone('Asia/Jakarta');

        $schedule->call(function () {
            if (Carbon::now()->isSunday()) {
                Log::info('call semua minggu');
                app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg();
            }
        })->dailyAt('02:00')->timezone('Asia/Jakarta');

        // $schedule->call(function () {
        //     // if (Carbon::now()->isSunday()) {
        //         Log::info('call pasien bpjs');
        //         app()->make(\App\Http\Controllers\PasienBPJSController::class)->convert_data_simpus();
        //     // }
        // })->dailyAt('18:47')->timezone('Asia/Jakarta');


        // $schedule->call(function () {
        //     Log::info('call');
        //     app()->make(\App\Http\Controllers\RiwayatController::class)->data_simpus_ckg_h3();
        //     app()->make(\App\Http\Controllers\MasterController::class)->data_simpus_master_provider1();
        //     app()->make(\App\Http\Controllers\PasienBPJSController::class)->data_simpus();
        // })->dailyAt('20:00')->timezone('Asia/Jakarta');
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
