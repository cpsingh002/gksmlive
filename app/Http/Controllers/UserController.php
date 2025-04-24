<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Mail\EmailDemo;
use Mail;
use App\Http\Controllers\Api\NotificationController;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\Notification;
use App\Models\SchemeModel;
use App\Models\User;
use App\Models\ProductionModel;

class UserController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            // if (Auth::user()->user_type == 1) {
            //     $user_type = 1;
            // } else if (Auth::user()->user_type == 2) {
            //     $user_type = 2;
            // } else if (Auth::user()->user_type == 3) {
            //     $user_type = 3;
            // } else if (Auth::user()->user_type == 4) {
            //     $user_type = 4;
            // } else {
            //     return redirect('login')->with('success', 'you are not allowed to access');
            // }

            //dd(Auth::user());
            $user_type = 3;
            $users = DB::table('users')->where('status', 1)->where('user_type', $user_type)->where('parent_user_type', Auth::user()->user_type)->where('parent_id', Auth::user()->id)->get();
            // dd( $users);
            return view('users.users', ['users' => $users]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
    }
    public function indexop()
    {

        if (Auth::check()) {
            // if (Auth::user()->user_type == 1) {
            //     $user_type = 1;
            // } else if (Auth::user()->user_type == 2) {
            //     $user_type = 2;
            // } else if (Auth::user()->user_type == 3) {
            //     $user_type = 3;
            // } else if (Auth::user()->user_type == 4) {
            //     $user_type = 4;
            // } else {
            //     return redirect('login')->with('success', 'you are not allowed to access');
            // }

            //dd(Auth::user());
            $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")->where('tbl_scheme.status','!=', 3)->get();
            $user_type = 3;
            $users = DB::table('users')->whereIn('status', [1,5])->where('user_type', $user_type)->where('parent_user_type', Auth::user()->user_type)->where('parent_id', Auth::user()->id)->get();
            // dd( $users);
            return view('users.operator', ['users' => $users,'schemedata'=>$schemedata]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
    }

    public function addUser()
    {
          $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status','!=', 3)->get();
            //return view('users.edit-operator', ['user_detail' => $user_detail,'teams'=>$teamdta,'schemes'=>$schemedata]);
        return view('users/add-user',['schemes'=>$schemedata]);
    }


    // Store Contact Form data
    public function storeUser(Request $request)
    {
       //  dd($request);
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'schemes'=>'required',
        ]);

        $save = new UserModel;
        $user_type = 3;

        $save->parent_id = $request->parent_id;
        $save->parent_user_type = $request->parent_user_type;
        $save->name = $request->user_name;
        $save->email = $request->email;
        $save->mobile_number = $request->mobile_number;
        $save->password = Hash::make($request->password);
        $save->status = 1;
        $save->user_type = $user_type;
        $save->scheme_opertaor = json_encode($request->schemes);
        $save->public_id = Str::random(6);
        $save->save();
        UserActionHistory::create([
            'user_id' => $save->id,
            'action' => "Operator saved",
            'past_data' =>null,
            'new_data' => json_encode($save),
            'user_to' => $save->id
        ]);
        
        $token = Str::random(64);
        $email = $request->email;
        $otp = rand(111111,999999);

        UserVerify::create([
          'user_id' => $save->id, 
          'token' => $token,
          'mobile_opt'=>$otp
        ]);
   
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=>  $request->user_name,
            'token' => $token
        ];
        $hji= 'demoEmail';
        $subject = 'Register Request';
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        $notifi = new NotificationController;
        $notifi->mobilesmsRegister($mailData,$request->mobile_number);
                
        return redirect('/operators')->with('status', 'User Added Successfully');
    }

    public function destroyUser($id)
    {
        // dd($id);    
        $user_detail = DB::table('users')->where('status', 1)->where('public_id', $id)->first();
        if (empty($user_detail)) {
            // dd("yes");
            $user_detailsd = DB::table('users')->where('public_id', $id)->first();
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 3]);
            if ($update) {
                UserActionHistory::create([
                    'user_id' => Auth::user()->id,
                    'action' => "Opertor deleted",
                    'past_data' =>json_encode($user_detailsd),
                    'new_data' => null,
                    'user_to' => $user_detailsd->id
                ]);
                return redirect('/associates')->with('status', 'Associate Deleted Successfully');
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 3]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                     if (count(DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->get()) > 0) {
                    DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->delete();
                    }
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Associate deleted",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => null,
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Opertor deleted",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => null,
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/operators')->with('status', 'Associate Deleted Successfully');
                }
            }
        }
    }

    public function deactivateUser($id, $status)
    {

        if ($status == 1) {
            $user_detail = DB::table('users')->where('status', $status)->where('public_id', $id)->first();
        } else {
            $user_detail = DB::table('users')->where('status', $status)->where('public_id', $id)->first();
        }

        // dd($user_detail->status);
        if ($user_detail->status == 1) {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 5]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                   
                    if (count(DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->get()) > 0) {
                    DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->delete();
                    }
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Associate Deactive",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,5);
                    return redirect('/associates')->with('status', 'Associate Deactive Successfully');
                } else {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Opertor Deactive",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/operators')->with('status', 'Opertor Deactive Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Associate Activated",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,1);
                    return redirect('/associates')->with('status', 'Associate Activated Successfully');
                } else {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Operator Activated",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/operators')->with('status', 'Operator Activated Successfully');
                }
            }
        }
    }

    public function activateUser($id, $status)
    {
        // dd($status);
        if ($status == 1) {
            $user_detail = DB::table('users')->where('status', $status)->where('public_id', $id)->first();
        } else {
            $user_detail = DB::table('users')->where('status', $status)->where('public_id', $id)->first();
        }

        // dd($user_detail->status);
        if ($user_detail->status == 1) {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 5]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Associate Deleted",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,5);
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Operator Deleted",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/operators')->with('status', 'Associate Deleted Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {

                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Associate Activated",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,1);
                    return redirect('/associates')->with('status', 'Associate Activated Successfully');
                } else {

                    UserActionHistory::create([
                        'user_id' => Auth::user()->id,
                        'action' => "Operator Deleted",
                        'past_data' =>json_encode($user_detail),
                        'new_data' => json_encode(UserModel::find($user_detail->id)),
                        'user_to' => $user_detail->id
                    ]);
                    return redirect('/operators')->with('status', 'Operator Activated Successfully');
                }
            }
        }
    }

    public function viewUser($id)
    {
        //dd($id);
        $user_detail = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->where('users.status', 1)->where('users.public_id', $id)->first();
        // dd($user_detail);
        return view('users.user_detail', ['user_detail' => $user_detail]);
    }

    public function editUser($id)
    {
        // dd($id);
        $user_detail = DB::table('users')->where('public_id', $id)->first();
        //dd($user_detail);
        $teamdta=DB::table('teams')->where('status',1)->get();
        
        if ($user_detail->user_type == 4) {
            return view('users.edit-user', ['user_detail' => $user_detail,'teams'=>$teamdta]);
        } else {
            // dd("yes");\
            //  dd($user_detail);
            if(Auth::user()->user_type == 2){
                $productions = ProductionModel::where('production_id',Auth::user()->parent_id)->get();
                $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status','!=',3)->get();
            }elseif(Auth::user()->user_type == 1)
            {   

                $productions = ProductionModel::where('status','!=',3)->get();
                // $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")
                // ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')
                // ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status','!=',3)->get();
                $schemedata = [];
            }
            $schdata = json_decode($user_detail->scheme_opertaor);
            //dd($schdata);
            return view('users.edit-operator', ['user_detail' => $user_detail,'teams'=>$teamdta,'schemes'=>$schemedata,'schdata'=>$schdata,'productions'=>$productions]);
        }

        //dd($user_detail);
    }

    // Store Contact Form data
   public function updateUser(Request $request)
    {
        //dd($request);

        // $save = new UserModel;
        $data = UserModel::where('public_id', $request->user_id)->first();

        $status = "";
        if ($request->operator_type == 3) {
            // dd($request);
            if(Auth::user()->user_type == 1)
            {
                $validatedData = $request->validate([
                    'user_name' => 'required',
                    'mobile_number' => 'required|unique:users,mobile_number,'.$request->post('id'),
                    'production'=>'required',
                    'email'=>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix|unique:users,email,'.$request->post('id')
                    
                ]);
                $status = DB::table('users')->where('public_id', $request->user_id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'parent_id'=>$request->production,
                    'mobile_number' => $request->mobile_number,
                    'scheme_opertaor' =>[]

                ]);
                $action = "Operator production House changed";

            }else{

                $validatedData = $request->validate([
                    'user_name' => 'required',
                    'mobile_number' => 'required|unique:users,mobile_number,'.$request->post('id'),
                    'schemes'=>'required',
                    'email'=>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix|unique:users,email,'.$request->post('id')
                    
                ]);
                // dd($request);

                $status = DB::table('users')
                ->where('public_id', $request->user_id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'scheme_opertaor' =>$request->schemes
                ]);
                $action = "Operator Details changed";
            }
        // dd('sdgfhd');
        
            
        } else {

            $validatedData = $request->validate([
                'user_name' => 'required',
                'applier_name' => 'required',
                'applier_rera_number' => 'required',
                'team'=>'required',
                 'mobile_number' => 'required|unique:users,mobile_number,'.$request->post('id'),
                'associate_rera_number' => 'required|unique:users,associate_rera_number,'.$request->post('id'),
                'email'=>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix|unique:users,email,'.$request->post('id')
            ]);
            $status = DB::table('users')
                ->where('public_id', $request->user_id)

                ->update([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'associate_rera_number' => $request->associate_rera_number,
                    'applier_name' => $request->applier_name,
                    'applier_rera_number' => $request->applier_rera_number,
                    'team'=>$request->team,
                    'created_at'=>$request->joing_date,
                    'gaj'=>$request->gaj

                ]);
                $action = "User Information Updated";
        }


        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => $action,
            'past_data' =>json_encode($data),
            'new_data' => json_encode(UserModel::find($data->id)),
            'user_to' => $data->id
        ]);
        if ($request->operator_type == 3) {
            //dd("yes");
            // return redirect('/associates')->with('status', 'Associate Updated Successfully');
            if(Auth::user()->user_type == 1)
            {
                return redirect('admin/opertor')->with('status', 'Operator Updated Successfully');
            }else{
                return redirect('/operators')->with('status', 'Operator Updated Successfully');
            }
            
        } else {
            return redirect('/associates')->with('status', 'Associate Updated Successfully');
        }
    }

   public function GetNotification(Request $request)
    {
        $start = now()->format('Y-m-d H:i:s');
        // dd($start);
        $end = now()->subDays(7)->format('Y-m-d H:i:s');
        if(Auth::user()->user_type == 4){
            $id = Auth::user()->id;
            $notices = Notification::where(static function ($query) use ($id) {
                $query->where('msg_to',$id)
                    ->orwhereNull('msg_to');
            })->whereBetween('created_at',[$end,$start])->orderby('id','DESC')->get();
        }elseif(in_array(Auth::user()->user_type, [2,5]))
        {
            $schemes= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->pluck('tbl_scheme.id')->toArray();
            // dd($schemes);
            $notices = Notification::where(static function ($query) use ($schemes) {
                $query->WhereIn('scheme_id',$schemes)
                    ->orwhereNull('scheme_id');
            })->whereBetween('created_at',[$end,$start])->orderby('id','DESC')->get();
        }elseif(in_array(Auth::user()->user_type, [3])){
            $schemes = json_decode(Auth::user()->scheme_opertaor);
            $notices = Notification::where(static function ($query) use ($schemes) {
                $query->WhereIn('scheme_id',$schemes)
                    ->orwhereNull('scheme_id');
            })->whereBetween('created_at',[$end,$start])->orderby('id','DESC')->get();
        }elseif(in_array(Auth::user()->user_type, [1,6]))
        {
            $notices = Notification::whereBetween('created_at',[$end,$start])->orderby('id','DESC')->get();
        }
        // $notices = Notification::Where('msg_to',Auth::user()->id)->orwhereNull('msg_to')->whereBetween(DB::raw('DATE(created_at)'),[$end,$start])->orderby('id','DESC')->get();
        // $notices = Notification::Where('msg_to',Auth::user()->id)->orwhereNull('msg_to')->whereBetween('created_at',[$end,$start])->orderby('id','DESC')->get();
        return view('notification', ['notices' => $notices]);
    }



    public function UserHistory(Request $request)
    {
        $email='';
        $type = '';
        $datas = [];
       
        if (isset($request->email)) {
            // dd($request);
            $email =$request->email;
            $type = $request->type;
            $user = UserModel::where('email',$request->email)->first();
            if($type == 'by')
            {
                $datas = UserActionHistory::where('user_id',$user->id)->orderBy('id','DESC')->get();
            }elseif($type == 'over'){
                $datas = UserActionHistory::where('user_to',$user->id)->orderBy('id','DESC')->get();
            }
        }     
        
        return view('property.user-history',['email'=>$email,'type'=>$type,'datas'=>$datas]);
    }

    public function UserHistoryView(Request $request)
    {
        $data = UserActionHistory::where('id',$request->id)->first();
        // dd(json_decode($data->past_data, true));
        //   dd(($data->past_data)->toArray);
        return view('property.property-history-view',['data'=>$data]);
    }


   public function ActiveOpertor(Request $request)
    {
        $asd =User::where('id', $request->id)->first();
        $update = User::where('id', $request->id)->update(['status' => 1]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Operator status updated active by '. Auth::user()->name .' with id '.$request->id.'. ',
            'past_data' =>json_encode($asd),
            'new_data' => json_encode(User::find($asd->id)),
            'user_to' => $request->id,
        ]);
        if (Auth::user()->user_type == 1){      

            return redirect('admin/opertor')->with('status', 'Operator Activated Successfully !!');
        }elseif (Auth::user()->user_type == 2){      
            return redirect('/operators')->with('status', 'operator Activated Successfully !!');
        }
    }


    public function DeactiveOpertor(Request $request)
    {
        $asd =User::where('id', $request->id)->first();
        $update = User::where('id', $request->id)->update(['status' => 5]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Operator status Upadted deactive by '. Auth::user()->name .'with id '.$request->id.'. ',
             'past_data' =>json_encode($asd),
            'new_data' => json_encode(User::find($asd->id)),
            'user_to' => $request->id,
        ]);
        if (Auth::user()->user_type == 1){
            return redirect('admin/opertor')->with('status', 'Operator Deactivated Successfully !!');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/operators')->with('status', 'Operator Deactivated Successfully !!');
        }
    }
}
