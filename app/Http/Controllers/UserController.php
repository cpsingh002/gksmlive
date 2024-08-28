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
            $user_type = 3;
            $users = DB::table('users')->where('status', 1)->where('user_type', $user_type)->where('parent_user_type', Auth::user()->user_type)->where('parent_id', Auth::user()->id)->get();
            // dd( $users);
            return view('users.operator', ['users' => $users]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
    }

    public function addUser()
    {
          $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status', 1)->get();
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
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 3]);
            if ($update) {
                return redirect('/associates')->with('status', 'Associate Deleted Successfully');
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 3]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                     if (count(DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->get()) > 0) {
                    DB::table('personal_access_tokens')->where('tokenable_id', $user_detail->id)->delete();
                    }
                    
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
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
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,5);
                    return redirect('/associates')->with('status', 'Associate Deactive Successfully');
                } else {
                    return redirect('/operators')->with('status', 'Opertor Deactive Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,1);
                    return redirect('/associates')->with('status', 'Associate Activated Successfully');
                } else {
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
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,5);
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
                    return redirect('/operators')->with('status', 'Associate Deleted Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {
                    $notifi = new NotificationController;
                    $notifi->mobilesmsuseraccount($user_detail->name,$user_detail->mobile_number,1);
                    return redirect('/associates')->with('status', 'Associate Activated Successfully');
                } else {
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
            $schemedata=DB::table("tbl_scheme")->select("tbl_scheme.*")
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status', 1)->get();
            $schdata = json_decode($user_detail->scheme_opertaor);
            //dd($schdata);
            return view('users.edit-operator', ['user_detail' => $user_detail,'teams'=>$teamdta,'schemes'=>$schemedata,'schdata'=>$schdata]);
        }

        //dd($user_detail);
    }

    // Store Contact Form data
    public function updateUser(Request $request)
    {
        //dd($request);

        // $save = new UserModel;

        $status = "";
        if ($request->operator_type == 3) {
            // dd($request);
            $validatedData = $request->validate([
                'user_name' => 'required',
                'mobile_number' => 'required|unique:users,mobile_number,'.$request->post('id'),
                'schemes'=>'required',
                'email'=>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix|unique:users,email,'.$request->post('id')
                
            ]);

            $status = DB::table('users')
                ->where('public_id', $request->user_id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                     'scheme_opertaor' =>$request->schemes

                ]);
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
        }

        if ($request->operator_type == 3) {
            //dd("yes");
            // return redirect('/associates')->with('status', 'Associate Updated Successfully');
            return redirect('/operators')->with('status', 'Operator Updated Successfully');
        } else {
            return redirect('/associates')->with('status', 'Associate Updated Successfully');
        }
    }
}
