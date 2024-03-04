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
        
        
        // $df =  now()->subHour(2)->subMinute(15)->format('Y-m-d H:i:s');
        // dd($df);
        
        $booking_statushold = DB::table('tbl_property')->where('booking_status', 3)->orwhere('booking_status',4)->orwhere('booking_status',2)->get();
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
                        'booking_time' =>  Carbon::now(),
                    ]);
                }
            }elseif($asd->booking_status == 3){
                
                if(($asd->booking_time == now()->subDay(1)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subDay(1)->format('Y-m-d H:i:s') )){
                //  dd($asd);
                    if($asd->waiting_list > 0){
                        //$paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        //if(!isset($paymentproof)){
                            $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first();
                        
                           // unlink('customer/aadhar'.'/'.$asd->adhar_card);
                            // unlink('customer/aadhar'.'/'.$asd->adhar_card);
                            // unlink('customer/pancard'.'/'.$asd->pan_card_image);
                            // unlink('customer/cheque'.'/'.$asd->cheque_photo);
                            // unlink('customer/attach'.'/'.$asd->attachment);
                            $status = DB::table('tbl_property')->where('public_id', $asd->public_id)
                             ->update([
                                'associate_name' => $datas->associate_name,
                                'associate_number' => $datas->associate_number,
                                'associate_rera_number' => $datas->associate_rera_number,
                                'booking_status' => $datas->booking_status,
                                'payment_mode' => $datas->payment_mode,
                                'booking_time' =>   Carbon::now(),
                                'description' => $datas->description,
                                'owner_name' =>  $datas->owner_name,
                                'contact_no' => $datas->contact_no,
                                'adhar_card_number' =>$datas->adhar_card_number,
                                'address' => $datas->address,
                                'user_id' => $datas->user_id,
                                'pan_card'=>$datas->pan_card,
                                'pan_card_image'=>$datas->pan_card_image,
                                'adhar_card'=>$datas->adhar_card,
                                'cheque_photo'=>$datas->cheque_photo,
                                'attachment'=> $datas->attachment,
                                'other_owner'=>$datas->other_owner,
                                'waiting_list'=>$asd->waiting_list-1
                            ]);   
                            $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$datas->id)->get();
                            if(isset($mulitu_customers[0])){
                                foreach($mulitu_customers as $multi){
                                 $model=new Customer();
                                 $model->public_id = Str::random(6);
                                 $model->plot_public_id = $asd->public_id;
                                 $model->booking_status = $multi->booking_status;
                                 $model->associate = $datas->associate_rera_number;
                                 $model->payment_mode =  $multi->payment_mode;
                                 $model->description = $multi->description;
                                 $model->owner_name =  $multi->owner_name;
                                 $model->contact_no = $multi->contact_no;
                                 $model->address = $multi->address;
                                 $model->pan_card= $multi->pan_card;
                                 $model->adhar_card_number= $multi->adhar_card_number;
                                 $model->pan_card_image = $multi->pan_card_image;
                                 $model->adhar_card= $multi->adhar_card;
                                 $model->cheque_photo= $multi->cheque_photo;
                                 $model->attachment= $multi->attachment;
                                 $model->save();
                                    $model1=WaitingListCustomer::find($multi->id);
                                    $model1->delete();
                                }
                            }
                           // $multi_customer = DB::table('customers')->where('plot_public_id',$request->property_id)->ORDERBY('id', 'DESC')->limit($min)->get();
                           // $datad = WaitingListMember::where($datas->id)->delete();
                            $model=WaitingListMember::find($datas->id);
                            $model->delete();
                            $plot_details = DB::table('tbl_property')->where('public_id', $asd->public_id)->first();
                            $scheme_details = DB::table('tbl_scheme')->where('id', $asd->scheme_id)->first();
                             $usered =DB::table('users')->where('public_id',$plot_details->user_id)->first();
                            $mailData = [
                                'title' => $plot_details->plot_type.' Book Details',
                                'name'=>$usered->name,
                                'plot_no'=>$plot_details->plot_no,
                                'plot_name'=>$plot_details->plot_name,
                                'plot_type' =>$plot_details->plot_type,
                                'scheme_name'=>$scheme_details->scheme_name,
                            ];
                    $notifi = new NotificationController;
                    $notifi->MoveNotification($mailData, $usered->device_token);
                       // }
                    }else{
                
                        $status = DB::table('tbl_property')->where('public_id', $asd->public_id)
                        ->update([
                            'booking_status' => 1,
                            'management_hold' => 0,
                            'booking_time' =>  Carbon::now(),
                             'cancel_time'=>Carbon::now(),
                        ]);  
                    }
    
                }
            }elseif($asd->booking_status == 2){
                if(($asd->booking_time == now()->subMinute(30)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subMinute(30)->format('Y-m-d H:i:s') )){
                //  dd($asd);
                    if($asd->waiting_list > 0){
                        $paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        if(!isset($paymentproof)){
                            $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first();
                        
                           // unlink('customer/aadhar'.'/'.$asd->adhar_card);
                            // unlink('customer/aadhar'.'/'.$asd->adhar_card);
                            // unlink('customer/pancard'.'/'.$asd->pan_card_image);
                            // unlink('customer/cheque'.'/'.$asd->cheque_photo);
                            // unlink('customer/attach'.'/'.$asd->attachment);
                            $status = DB::table('tbl_property')->where('public_id', $asd->public_id)
                             ->update([
                                'associate_name' => $datas->associate_name,
                                'associate_number' => $datas->associate_number,
                                'associate_rera_number' => $datas->associate_rera_number,
                                'booking_status' => $datas->booking_status,
                                'payment_mode' => $datas->payment_mode,
                                'booking_time' => Carbon::now(),
                                'description' => $datas->description,
                                'owner_name' =>  $datas->owner_name,
                                'contact_no' => $datas->contact_no,
                                'adhar_card_number' =>$datas->adhar_card_number,
                                'address' => $datas->address,
                                'user_id' => $datas->user_id,
                                'pan_card'=>$datas->pan_card,
                                'pan_card_image'=>$datas->pan_card_image,
                                'adhar_card'=>$datas->adhar_card,
                                'cheque_photo'=>$datas->cheque_photo,
                                'attachment'=> $datas->attachment,
                                'other_owner'=>$datas->other_owner,
                                'waiting_list'=>$asd->waiting_list-1
                            ]);   
                            $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$datas->id)->get();
                            if(isset($mulitu_customers[0])){
                                foreach($mulitu_customers as $multi){
                                 $model=new Customer();
                                 $model->public_id = Str::random(6);
                                 $model->plot_public_id = $asd->public_id;
                                 $model->booking_status = $multi->booking_status;
                                 $model->associate = $datas->associate_rera_number;
                                 $model->payment_mode =  $multi->payment_mode;
                                 $model->description = $multi->description;
                                 $model->owner_name =  $multi->owner_name;
                                 $model->contact_no = $multi->contact_no;
                                 $model->address = $multi->address;
                                 $model->pan_card= $multi->pan_card;
                                 $model->adhar_card_number= $multi->adhar_card_number;
                                 $model->pan_card_image = $multi->pan_card_image;
                                 $model->adhar_card= $multi->adhar_card;
                                 $model->cheque_photo= $multi->cheque_photo;
                                 $model->attachment= $multi->attachment;
                                 $model->save();
                                    $model1=WaitingListCustomer::find($multi->id);
                                    $model1->delete();
                                }
                            }
                        
                           // $datad = WaitingListMember::where(['id'=> $datas->id])->delete();
                            $model=WaitingListMember::find($datas->id);
                            $model->delete();
                            $plot_details = DB::table('tbl_property')->where('public_id', $asd->public_id)->first();
                            $scheme_details = DB::table('tbl_scheme')->where('id', $asd->scheme_id)->first();
                             $usered =DB::table('users')->where('public_id',$plot_details->user_id)->first();
                            $mailData = [
                                'title' => $plot_details->plot_type.' Book Details',
                                'name'=>$usered->name,
                                'plot_no'=>$plot_details->plot_no,
                                'plot_name'=>$plot_details->plot_name,
                                'plot_type' =>$plot_details->plot_type,
                                'scheme_name'=>$scheme_details->scheme_name,
                            ];
                    $notifi = new NotificationController;
                    $notifi->MoveNotification($mailData, $usered->device_token);
                        }
                    }else{
                        $paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        //dd($paymentproof)
                        if(!isset($paymentproof)){
                         $status = DB::table('tbl_property')->where('public_id', $asd->public_id)
                            ->update([
                            'booking_status' => 4,
                            'management_hold' => 0,
                            'booking_time' =>  Carbon::now(),
                            'cancel_time'=>Carbon::now()
                            ]); 
                            
                            
                                    
                    $users= DB::table('users')->where('status',1)->where('is_email_verified',1)->get();
                     $scheme_details = DB::table('tbl_scheme')->where('id', $asd->scheme_id)->first();
                    foreach($users as $list){
                        $mailData=['title' => $asd->plot_type.' Booking Canceled','plot_no'=>$asd->plot_no,'plot_name'=>$asd->plot_name,'plot_type' =>$asd->plot_type,'scheme_name'=>$scheme_details->scheme_name];
                        $email = $list->email;
                        $hji= 'cancelemail';   $subject = $asd->plot_type.' Available';
                            Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                    }
                    $notifi = new NotificationController;
                    $notifi->sendNotification($mailData);
                        
                                    
                                    
                                    
                        }
                    }
    
                }  
            }
      
        }
    }

}
