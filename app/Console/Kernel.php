<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     protected $commands = [
        Commands\StatusChange::class,
        Commands\updateStatus::class,
    ];
   
    protected function schedule(Schedule $schedule)
    {

    
        // $schedule->command('inspire')->hourly();

        // $schedule->command('status:update_status_every_30_minutes')
        //     ->everyMinute();

        $schedule->command('statusChange:minutes')
        ->everyMinute();
          $schedule->command('statusAllseen:days')->daily();


        // $schedule->call(function () {
        //     DB::table('tbl_property')
        //         ->update(['booking_status' => 1]);
        // })->everyMinute();
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
