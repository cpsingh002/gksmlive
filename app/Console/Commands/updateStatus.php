<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class updateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statusAllseen:days';

    /**
     * The console command description. 
     *
     * @var string
     */
    protected $description = 'update All seen status every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = DB::table('users')->where('user_type', 4)->where('status', 1)->get();
        foreach ($users as $asd)
       {
            //$booking_status = DB::table('tbl_property')->where('booking_status', 5)->where('associate_rera_number',$asd->associate_rera_number)->sum('gaj');
            if(($asd->gaj >= 1000) || ($asd->created_at == now()->subMonth(6)->format('Y-m-d H:i:s'))||( $asd->created_at < now()->subMonth(6)->format('Y-m-d H:i:s') )){
            $status= DB::table('users')->where('public_id',$asd->public_id)->update(['all_seen'=>1]);
            }
           
       }
        return;
    }
}
