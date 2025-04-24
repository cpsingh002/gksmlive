<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Mail\EmailDemo;
use App\Models\WaitingListMember;
use App\Models\WaitingListCustomer;
use App\Models\Customer;
use App\Models\PaymentProof;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\NotificationController;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\PropertyModel;
use App\Models\SchemeModel;
use App\Models\User;
use App\Models\Notification;

class CanceltoAvalible extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canceled:toavalibale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $booking_statushold = PropertyModel::whereIn('booking_status',[4])->where('freez','!=',1)->get();
        foreach ($booking_statushold as $asdd)
        {
            $asd= PropertyModel::where('id',$asdd->id)->first();    
            if((\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $asd->cancel_time)->format('Y-m-d H:i') == now()->subMinute(30)->format('Y-m-d H:i'))||( date('Y-m-d H:i', strtotime($asd->cancel_time)) < now()->subMinute(30)->format('Y-m-d H:i') ))
            {
                    //  dd($asd);
                    $status = DB::table('tbl_property')->where('public_id', $asd->public_id)
                    ->update([
                        'booking_status' => 1,
                        'management_hold' => 0,
                        'run_auto' => 0
                        // 'booking_time' =>  Carbon::now(),
                    ]);
                    // $property_details = PropertyModel::where('public_id', $asd->public_id)->first();
                    ProteryHistory ::create([
                        'scheme_id' => $asd->scheme_id,
                        'property_id'=>$asd->id,
                        'action_by'=>null,
                        'action' => "Unit status change cancel to available",
                        'past_data' =>json_encode($asd),
                        'new_data' =>json_encode(PropertyModel::find($asd->id)),
                        'name' =>null,
                        'addhar_card' =>null
                    ]);
            }
        }
    }
}
