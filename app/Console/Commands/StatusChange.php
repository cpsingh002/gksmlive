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
        // dd($df);$booking_statushold = PropertyModel::whereIn('booking_status',[2,3,4])->where('freez','!=',1)->get();
        
        $booking_statushold = PropertyModel::whereIn('booking_status',[2,3,4])->where('freez','!=',1)->get();
        foreach ($booking_statushold as $asdd)
        {
            $asd= PropertyModel::where('id',$asdd->id)->first();
            if($asd->booking_status == 4)
            {
               if((\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $asd->cancel_time)->format('Y-m-d H:i') == now()->subMinute(30)->format('Y-m-d H:i'))||( date('Y-m-d H:i', strtotime($asd->cancel_time)) < now()->subMinute(30)->format('Y-m-d H:i') ))
                {
                    //  dd($asd);
                    $status = DB::table('tbl_property')
                    ->where('public_id', $asd->public_id)
                    ->update([
                        'booking_status' => 1,
                        'management_hold' => 0,
                        // 'booking_time' =>  Carbon::now(),
                    ]);
                    // $property_details = PropertyModel::where('public_id', $asd->public_id)->first();
                    ProteryHistory ::create([
                        'scheme_id' => $asd->scheme_id,
                        'property_id'=>$asd->id,
                        'action_by'=>null,
                        'action' => "Plot status change cancel to available",
                        'past_data' =>json_encode($asd),
                        'new_data' =>json_encode(PropertyModel::find($asd->id)),
                        'name' =>null,
                        'addhar_card' =>null
                    ]);
                }
            }elseif($asd->booking_status == 3)
            {
                
                if(($asd->booking_time == now()->subDay(1)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subDay(1)->format('Y-m-d H:i:s') ))
                {
                    //  dd($asd);
                    if($asd->waiting_list > 0)
                    {
                        //$paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        //if(!isset($paymentproof)){
                        $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first();
                        
                            if($asd->adhar_card != ''){
                                // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$asd->adhar_card);
                            }
                            if($asd->pan_card_image != ''){
                                // unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$asd->pan_card_image);
                            }
                            if($asd->cheque_photo != ''){
                                // unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$asd->cheque_photo);
                            }
                            if($asd->attachment != ''){
                                // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$asd->attachment);
                            }
                            $status = PropertyModel::where('public_id', $asd->public_id)
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
                                    $associaterera = $datas->associate_rera_number;
                                    $model=new Customer();
                                    $model->public_id = Str::random(6);
                                    $model->plot_public_id = $asd->public_id;
                                    $model->booking_status = $datas->booking_status;
                                    $model->associate = $datas->associate_rera_number;
                                    $model->payment_mode =  $datas->payment_mode;
                                    $model->description = $datas->description;
                                    $model->owner_name =  $datas->owner_name;
                                    $model->contact_no = $datas->contact_no;
                                    $model->address = $datas->address;
                                    $model->pan_card= $datas->pan_card;
                                    $model->adhar_card_number= $datas->adhar_card_number;
                                    $model->pan_card_image = $datas->pan_card_image;
                                    $model->adhar_card= $datas->adhar_card;
                                    $model->cheque_photo= $datas->cheque_photo;
                                    $model->attachment= $datas->attachment;
                                    $model->save();
                                $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$datas->id)->get();
                            if(isset($mulitu_customers[0])){
                                foreach($mulitu_customers as $multi){
                                    $model=new Customer();
                                    $model->public_id = Str::random(6);
                                    $model->plot_public_id = $asd->public_id;
                                    $model->associate = $datas->associate_rera_number;
                                    $model->booking_status = $multi->booking_status;
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
                            $plot_details = PropertyModel::where('public_id', $asd->public_id)->first();
                            $scheme_details = SchemeModel::where('id', $asd->scheme_id)->first();
                            $usered =User::where('public_id',$plot_details->user_id)->first();
                            $mailData = [
                                'title' => $plot_details->plot_type.' Book Details',
                                'name'=>$usered->name,
                                'plot_no'=>$plot_details->plot_no,
                                'plot_name'=>$plot_details->plot_name,
                                'plot_type' =>$plot_details->plot_type,
                                'scheme_name'=>$scheme_details->scheme_name,
                                'mobile' => $usered->mobile_number,
                            ];
                            ProteryHistory ::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'action' => 'Scheme -'.$mailData['scheme_name'].', plot no-'.$mailData['plot_name'].'Plot assing from waiting list for customer name '.$datas->owner_name.' with addhar card number ' .$datas->adhar_card_number .'!!',
                                'past_data' =>json_encode($asd),
                                'new_data' =>json_encode($plot_details),
                                'name' =>$datas->owner_name,
                                'addhar_card' =>$datas->adhar_card_number
                            ]);
                            Notification::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'msg_to'=>$usered->id,
                                'action'=>'waiting assign',
                                'msg' => 'Hello, '.$mailData['plot_type'].' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been assign to you On GKSM Plot Booking Platform !!',
                            ]);
                            $notifi = new NotificationController;
                            $notifi->MoveNotification($mailData, $usered->device_token);

                            
                       // }
                    }else{
                
                        $status = PropertyModel::where('public_id', $asd->public_id)
                        ->update([
                            'booking_status' => 4,
                            'management_hold' => 0,
                            // 'booking_time' =>  Carbon::now(),
                            'cancel_time'=>Carbon::now(),
                            'wbooking_time' =>null,
                        ]);
                        $plot_details = PropertyModel::where('public_id', $asd->public_id)->first();
                        
                        ProteryHistory::create([
                            'scheme_id' => $asd->scheme_id,
                            'property_id'=>$asd->id,
                            'action_by'=>null,
                            'action' => 'Plot status change hold to cancel',
                            'past_data' =>json_encode($asd),
                            'new_data' =>json_encode($plot_details),
                            'name' =>null,
                            'addhar_card' =>null
                        ]);
                    }
    
                }
            }elseif($asd->booking_status == 2){
                if(($asd->booking_time == now()->subHour(2)->subMinute(15)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subHour(2)->subMinute(15)->format('Y-m-d H:i:s') )){
                    //  dd($asd);
                    if($asd->waiting_list > 0){
                        $paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        if(!isset($paymentproof)){
                            $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first();
                        
                                if($asd->adhar_card != ''){
                                    // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$asd->adhar_card);
                                
                                }
                                if($asd->pan_card_image != ''){
                                    // unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$asd->pan_card_image);
                                }
                                if($asd->cheque_photo != ''){
                                    // unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$asd->cheque_photo);
                                }
                                if($asd->attachment != ''){
                                    // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$asd->attachment);
                                }
                            $status = PropertyModel::where('public_id', $asd->public_id)
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
                                    $associaterera = $datas->associate_rera_number;
                                    $model=new Customer();
                                    $model->public_id = Str::random(6);
                                    $model->plot_public_id = $asd->public_id;
                                    $model->booking_status = $datas->booking_status;
                                    $model->associate = $datas->associate_rera_number;
                                    $model->payment_mode =  $datas->payment_mode;
                                    $model->description = $datas->description;
                                    $model->owner_name =  $datas->owner_name;
                                    $model->contact_no = $datas->contact_no;
                                    $model->address = $datas->address;
                                    $model->pan_card= $datas->pan_card;
                                    $model->adhar_card_number= $datas->adhar_card_number;
                                    $model->pan_card_image = $datas->pan_card_image;
                                    $model->adhar_card= $datas->adhar_card;
                                    $model->cheque_photo= $datas->cheque_photo;
                                    $model->attachment= $datas->attachment;
                                    $model->save();
                            
                            $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$datas->id)->get();
                            if(isset($mulitu_customers[0])){
                                foreach($mulitu_customers as $multi){
                                 $model=new Customer();
                                 $model->public_id = Str::random(6);
                                 $model->plot_public_id = $asd->public_id;
                                 $model->associate = $datas->associate_rera_number;
                                 $model->booking_status = $multi->booking_status;
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
                            $plot_details = PropertyModel::where('public_id', $asd->public_id)->first();
                            $scheme_details = SchemeModel::where('id', $asd->scheme_id)->first();
                            $usered =User::where('public_id',$plot_details->user_id)->first();
                            $mailData = [
                                'title' => $plot_details->plot_type.' Book Details',
                                'name'=>$usered->name,
                                'plot_no'=>$plot_details->plot_no,
                                'plot_name'=>$plot_details->plot_name,
                                'plot_type' =>$plot_details->plot_type,
                                'scheme_name'=>$scheme_details->scheme_name,
                                'mobile' => $usered->mobile_number,
                            ];
                            ProteryHistory ::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'action' => 'Scheme -'.$mailData['scheme_name'].', plot no-'.$mailData['plot_name'].'Plot assing from waiting list for customer name '.$datas->owner_name.' with addhar card number ' .$datas->adhar_card_number .'!!',
                                'past_data' =>json_encode($asd),
                                'new_data' =>json_encode($plot_details),
                                'name' =>$datas->owner_name,
                                'addhar_card' =>$datas->adhar_card_number
                            
                            ]);
                            Notification::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'msg_to'=>$usered->id,
                                'action'=>'waiting assign',
                                'msg' => 'Hello, '.$mailData['plot_type'].' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been assign to you On GKSM Plot Booking Platform !!',
                            ]);
                            $notifi = new NotificationController;
                            $notifi->MoveNotification($mailData, $usered->device_token);
                           
                        }
                    }else{
                        $paymentproof = PaymentProof::where('property_id', $asd->id)->first();
                        //dd($paymentproof)
                        if(!isset($paymentproof)){
                            $status = PropertyModel::where('public_id', $asd->public_id)
                                ->update([
                                'booking_status' => 4,
                                'management_hold' => 0,
                                // 'booking_time' =>  Carbon::now(),
                                'cancel_time'=>Carbon::now(),
                                 'wbooking_time' =>null,
                            ]); 

                            $plot_details = PropertyModel::where('public_id', $asd->public_id)->first();
                            $users= User::where('public_id',$asd->user_id)->first();
                            $scheme_details = SchemeModel::where('id', $asd->scheme_id)->first();
                            $mailData=['title' => $asd->plot_type.' Booking Canceled','plot_no'=>$asd->plot_no,'plot_name'=>$asd->plot_name,'plot_type' =>$asd->plot_type,'scheme_name'=>$scheme_details->scheme_name];
                            
                            ProteryHistory ::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'action' => 'Plot status change booked to cancel',
                                'past_data' =>json_encode($asd),
                                'new_data' =>json_encode($plot_details),
                                'name' =>null,
                                'addhar_card' =>null
                               
                            ]);
                            
                            // foreach($users as $list){
                            //     // $mailData=['title' => $asd->plot_type.' Booking Canceled','plot_no'=>$asd->plot_no,'plot_name'=>$asd->plot_name,'plot_type' =>$asd->plot_type,'scheme_name'=>$scheme_details->scheme_name];
                            //     $email = $list->email;
                            //     $hji= 'cancelemail';   $subject = $asd->plot_type.' Available';
                            //         Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                            // }
                            Notification::create([                              
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'msg_to'=>$users->id,
                                'action'=>'Cancel',
                                'msg' => 'Hello, '.$mailData['plot_type'].' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been cancelled and it going to available in 30 min On GKSM Plot Booking Platform !!',                            
                            ]);
                            $notifi = new NotificationController;
                            $notifi->sendNotification($mailData);
                        }
                    }
    
                } 

                if($asd->waiting_list > 0){
                    $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->orderBy('id','DESC')->get();
                    if(($datas[0]->created_at == now()->subDay(1)->format('Y-m-d H:i:s'))||( $datas[0]->created_at < now()->subDay(1)->format('Y-m-d H:i:s') ))
                    {
                        foreach($datas as $data){
                            if($data->adhar_card != ''){
                                // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$data->adhar_card);
                            }
                            if($data->pan_card_image != ''){
                                // unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$data->pan_card_image);
                            }
                            if($data->cheque_photo != ''){
                                // unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$data->cheque_photo);
                            }
                            if($data->attachment != ''){
                                // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$data->attachment);
                            }
                            $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                            if(isset($waitingdatas[0]))
                            {
                                foreach($waitingdatas as $waitingdata){
                                    if($waitingdata->adhar_card != ''){
                                        // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$waitingdata->adhar_card);
                                    }
                                    // if($waitingdata->pan_card_image != ''){
                                    //     unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$waitingdata->pan_card_image);
                                    // }
                                    // if($waitingdata->cheque_photo != ''){
                                    //     unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$waitingdata->cheque_photo);
                                    // }
                                    if($waitingdata->attachment != ''){
                                        // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$waitingdata->attachment);
                                    }
                                    $model= WaitingListCustomer::find($waitingdata->id);
                                    $model->delete();
                                }
                            }
                            
                            WaitingListMember::find($data->id)->delete();
                            $status = PropertyModel::where('id', $asd->id)->decrement('waiting_list', 1); 
                            ProteryHistory ::create([
                                'scheme_id' => $asd->scheme_id,
                                'property_id'=>$asd->id,
                                'action_by'=>null,
                                'action' => 'waiting list remove after 24 hours',
                            ]);
                        }
                    }
                }
                
                // if(($asd->booking_time == now()->subDay(1)->format('Y-m-d H:i:s'))||( $asd->booking_time < now()->subDay(1)->format('Y-m-d H:i:s') )){
                //     if($asd->waiting_list > 0){
                //         $datas= WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->orderBy('id','DESC')->get();
                //         if($datas[0]->created_at  < now()->format('Y-m-d H:i:s') ){

                        
                //             foreach($datas as $data){
                //                 if($data->adhar_card != ''){
                //                     // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$data->adhar_card);
                //                 }
                //                 if($data->pan_card_image != ''){
                //                     // unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$data->pan_card_image);
                //                 }
                //                 if($data->cheque_photo != ''){
                //                     // unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$data->cheque_photo);
                //                 }
                //                 if($data->attachment != ''){
                //                     // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$data->attachment);
                //                 }
                //                 $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                //                 if(isset($waitingdatas[0]))
                //                 {
                //                     foreach($waitingdatas as $waitingdata){
                //                         if($waitingdata->adhar_card != ''){
                //                             // unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$waitingdata->adhar_card);
                //                         }
                //                         // if($waitingdata->pan_card_image != ''){
                //                         //     unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$waitingdata->pan_card_image);
                //                         // }
                //                         // if($waitingdata->cheque_photo != ''){
                //                         //     unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$waitingdata->cheque_photo);
                //                         // }
                //                         if($waitingdata->attachment != ''){
                //                             // unlink('test.bookinggksm.com/public/customer/attach'.'/'.$waitingdata->attachment);
                //                         }
                //                         $model= WaitingListCustomer::find($waitingdata->id);
                //                         $model->delete();
                //                     }
                //                 }
                                
                //                 WaitingListMember::find($data->id)->delete();
                //                 $status = PropertyModel::where('id', $asd->id)->decrement('waiting_list', 1); 
                //                 ProteryHistory ::create([
                //                     'scheme_id' => $asd->scheme_id,
                //                     'property_id'=>$asd->id,
                //                     'action_by'=>null,
                //                     'action' => 'waiting list remove after 24 hours',
                //                 ]);
                //             }
                //         }
                //     }
                //     // $status = PropertyModel::where('id', $asd->id)->update(['waiting_list'=> 0]);
                //     //     ProteryHistory ::create([
                //     //         'scheme_id' => $asd->scheme_id,
                //     //         'property_id'=>$asd->id,
                //     //         'action_by'=>null,
                //     //         'action' => 'waiting list remove after 24 hours',
                //     //     ]);
                    
              
                // }    
                
            }
      
        }


        // $ghf  = PropertyModel::where('id', 2365)->first();
        // if($ghf->adhar_card != ''){
        //     unlink('test.bookinggksm.com/public/customer/aadhar'.'/'.$ghf->adhar_card);
            
        // }
        // if($ghf->pan_card_image != ''){
        //     unlink('test.bookinggksm.com/public/customer/pancard'.'/'.$ghf->pan_card_image);
        // }
        // if($ghf->cheque_photo != ''){
        //     unlink('test.bookinggksm.com/public/customer/cheque'.'/'.$ghf->cheque_photo);
        // }
        // if($ghf->attachment != ''){
        //     unlink('test.bookinggksm.com/public/customer/attach'.'/'.$ghf->attachment);
        // }

    }

}
