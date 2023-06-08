<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statusChange:minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this is a testing';

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
        
        
        
        
        $booking_statushold = DB::table('tbl_property')->where('booking_status', 3)->orwhere('booking_status',4)->get();
        //$booking_statuscanceld = DB::table('tbl_property')->where('booking_status', 2)->where('scheme_id',21)->get();
        
        //dd($booking_statuscanceld); 

       foreach ($booking_statushold as $asd)
       {
      
        if($asd->booking_status == 4){
           if(($asd->booking_time == now()->subMinute(30)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subMinute(30)->format('Y-m-d H:i:s') )){
          //  dd($asd);
                $status = DB::table('tbl_property')
                ->where('public_id', $asd->public_id)
                ->update([
                    'booking_status' => 1,
                    'management_hold' => 0,
                    'booking_time' =>  NULL,
                ]);
            }
        }elseif($asd->booking_status == 3){
          if(($asd->booking_time == now()->subDay(1)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subDay(1)->format('Y-m-d H:i:s') )){
            //  dd($asd);
            $status = DB::table('tbl_property')
            ->where('public_id', $asd->public_id)
            ->update([
                'booking_status' => 1,
                'management_hold' => 0,
                'booking_time' =>  NULL,
            ]);  
           }

        }
    }
      
    }

}
