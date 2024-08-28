<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\AdminModel;
use App\Models\User;
use App\Models\UserModel;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\EmailDemo;
use App\Http\Controllers\Api\NotificationController;
use Carbon\Carbon;
use App\Models\SelfCancelReason;
use App\Models\WaitingListMember;
use App\Models\WaitingListCustomer;
use App\Models\Customer;
use App\Models\PaymentProof;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
// use Symfony\Component\HttpFoundation\Response;

// require base_path("vendor/autoload.php");

// use Maatwebsite\Excel\Facades\Excel;

class AssociateController extends Controller
{
    public function index()
    {
        $associates = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->whereIn('users.status', [1, 5])->where('users.user_type', 4)->get();
        // dd($associates);
        return view('associate.associates', ['associates' => $associates]);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }

    public function addAssociate()
    {
        $teamdta=DB::table('teams')->where('status',1)->get();
        return view('associate.add-associate',['teams'=>$teamdta]);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }

    // Store Contact Form data
    public function storeAssociate(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|max:255|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'associate_rera_number' => 'required|unique:users',
            'applier_name' => 'required',
            'applier_rera_number' => 'required',
            'team'=>'required'
        ]);

        $saved = new UserModel;
        $user_type = 4;
        $saved->parent_id = $request->parent_id;
        $saved->parent_user_type = $request->parent_user_type;
        $saved->email = $request->email;
        $saved->name = $request->user_name;
        $saved->mobile_number = $request->mobile_number;
        $saved->password = Hash::make($request->password);
        $saved->associate_rera_number = $request->associate_rera_number ? $request->associate_rera_number : '';
        $saved->applier_name = $request->applier_name ? $request->applier_name : '';
        $saved->applier_rera_number = $request->applier_rera_number ? $request->applier_rera_number : '';
        $saved->status = 2;
        $saved->team = $request->team;
        $saved->user_type = $user_type;
        $saved->public_id = Str::random(6);
        $saved->save();

        $email = $request->email;
        $token = Str::random(64);
        $otp = rand(111111,999999);

        UserVerify::create([
            'user_id' => $saved->id, 
            'token' => $token,
            'mobile_opt'=>$otp
        ]);
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=> $request->user_name,
            'token' => $token
        ];
        $hji= 'demoEmail';
        $subject='Register Request';
        UserActionHistory::create([
            'user_id' => $saved->id,
            'action' => "Register Request Submit",
        ]);
  
        $dfg =   Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        return redirect('/associates')->with('status', 'Associate Added Successfully');
        // return redirect('/add-associate')->with('status', 'Associate Added Successfully');
    }

    public function AssociatePendingRequest()
    {
         $associates = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->where('users.status', 2)->where('users.user_type', 4)->orderBy('users.id','ASC')->get();
        // dd($associates);
        return view('users.pending-request', ['associates' => $associates]);
    }

    public function approvedStatus(Request $request)
    {
        //dd($request);
        //dd($request->userid);
        $status = DB::table('users')->where('public_id', $request->userid)->update(['status' => 1]);
        $model=DB::table('users')->where('public_id', $request->userid)->first();
        $email = $model->email;
   
        $mailData = [
            'title' => 'Associate Request Approved',
            'name' => $model->name,
        ];
        $hji= 'associate_approved';
        $subject='Associate Request Approved';
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Associate Request Approved for'. $model->name.' with rera number '.$model->associate_rera_number.'.',
        ]);
  
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        $notifi = new NotificationController;
        $notifi->mobilesmsRegisterapproved($mailData,$model->mobile_number);
        return redirect('/associates');
    }

    public function cancelledStatus(Request $request)
    {
        $model = DB::table('users')->where('public_id', $request->cancel_id)->first();
        $status = DB::table('users')->where('public_id', $request->cancel_id)->delete();
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Associate Request Approved for'. $model->name.' with rera number '.$model->associate_rera_number.'.',
        ]);
        return redirect('/associates');
    }

    public function AssociateLogin(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])){
            return redirect('/');
        }
        return redirect('associate-login')->with('success', 'Login details are not valid');
    }

    public  function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    public function exportAssociate()
    {
        $associates = DB::table('users')->whereIn('status', [1, 5])->where('user_type', 4)->get();
        dd($associates);
        return redirect('associate')->with('success', 'Login details are not valid');
    }
    
     public function indexopertor()
    {
        $associates = DB::table('users')->select('users.*','tbl_production.production_name')
        ->leftJoin('tbl_production','users.parent_id','tbl_production.production_id')->whereIn('users.status', [1, 5])->where('users.user_type', 3)->get();
        return view('associate.opertors', ['associates' => $associates]);
    }
    
    public function deleteAccount(Request $request)
    {
        // dd(Auth::user());
        $request->validate([
            'other_info' => 'required'
        ]);
        $user = User::find(Auth::user()->id)->update(['status'=>4,'delete_reason'=>$request->other_info]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Your Account is deleted By You',
        ]);
        // Auth::logoutOtherDevices(Auth::user()->password);
        return redirect('login')->with('danger', 'Your Account is deleted By You.');
    }
    public function deleAccount(Request $request)
    {
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->id)->first();
        // dd($property_details);
        return view('property.bookingdelete', ['property_details' => $property_details]);
    }

    public function deleteBooking(Request $request)
    {
        return   redirect()->route('view.scheme', ['id' => $request->scheme_id])->with('status', 'This action is disable by the admin, you can not perfrom this action.');
        $request->validate([
            'other_info' => 'required'
        ]);

        $proerty = DB::table('tbl_property')->where('public_id', $request->property_public_id)->first();
        if($proerty->waiting_list > 0){
            $datas= WaitingListMember::where(['scheme_id'=>$proerty->scheme_id,'plot_no'=>$proerty->plot_no])->first();
            $status = DB::table('tbl_property')->where('public_id', $proerty->public_id)
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
                'waiting_list'=>$proerty->waiting_list-1
            ]); 
            
            $assoicate_namew = $datas->associate_rera_number;
            $model=new Customer();
            $model->public_id = Str::random(6);
            $model->plot_public_id = $proerty->public_id;
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
                    $model->plot_public_id = $proerty->public_id;
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
            WaitingListMember::where('id',$datas->id)->delete();
            $selfcancel = new SelfCancelReason();
            $selfcancel->property_id = $proerty->id;
            $selfcancel->user_id = Auth::user()->id;
            $selfcancel->reason = $request->other_info;
            $selfcancel->save();
            $scheme_details = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
            ProteryHistory ::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$scheme_details->scheme_name.', plot no- '.$proerty->plot_name.' plot cancelled.',
            ]);
            ProteryHistory ::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>null,
                'action' => 'Scheme - '.$scheme_details->scheme_name.', plot no- '.$proerty->plot_name.' assing from waiting list.',
            ]);
              
        }else{
            $status = DB::table('tbl_property')->where('public_id', $request->property_public_id)
                ->update([
                    'booking_status' => 4,
                    'cancel_reason'=>$request->other_info,
                    'cancel_time'=>Carbon::now(),
                    // 'booking_time'=>Carbon::now(),
                    'cancel_by'=> Auth::user()->name,
                    'waiting_list'=>0  
            ]);
            $selfcancel = new SelfCancelReason();
            $selfcancel->property_id = $proerty->id;
            $selfcancel->user_id = Auth::user()->id;
            $selfcancel->reason = $request->other_info;
            $selfcancel->save();
            
            $scheme_details = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
            $mailData=['title' => $proerty->plot_type.' Booking Canceled','plot_no'=>$proerty->plot_no,'plot_name'=>$proerty->plot_name,'plot_type' =>$proerty->plot_type,'scheme_name'=>$scheme_details->scheme_name];
            ProteryHistory ::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' plot cancelled.',
            ]);
            $notifi = new NotificationController;
            $notifi->sendNotification($mailData);
        }
        return   redirect()->route('view.scheme', ['id' => $request->scheme_id])->with('status', 'Property booking Cancel update successfully.');
    }
}
