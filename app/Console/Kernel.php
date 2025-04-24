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
        // Commands\PushTokenUpdate::class,
         Commands\CanceltoAvalible::class,
           Commands\HoldStatusScheme::class,
    ];
   
    protected function schedule(Schedule $schedule)
    {


        // $schedule->command('statusChange:minutes')
        // ->everyThreeMinutes();
        //  $schedule->command('pushtoken:update')
        // ->everyThreeMinutes();
        // $schedule->command('statusAllseen:days')->daily();

        $schedule->command('statusChange:minutes')->everyMinute()->between('09:30', '18:31');
        // $schedule->command('pushtoken:update')
        // ->everyThreeMinutes();
        $schedule->command('statusAllseen:days')->daily();
        $schedule->commandss('canceled:toavalibale')->everyMinute();
        $schedule->commandss('holdstatusactive:tbl_scheme')->everyMinute();
       
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
