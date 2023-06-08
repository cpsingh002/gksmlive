<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Hash;

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

    public function addUser()
    {
        return view('users/add-user');
    }


    // Store Contact Form data
    public function storeUser(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required',
            'password' => 'required',
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
        $save->public_id = Str::random(6);
        $save->save();
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
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
                    return redirect('/operators')->with('status', 'Associate Deleted Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {
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
                    return redirect('/associates')->with('status', 'Associate Deleted Successfully');
                } else {
                    return redirect('/operators')->with('status', 'Associate Deleted Successfully');
                }
            }
        } else {
            $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 1]);
            if ($update) {
                if ($user_detail->user_type == 4) {
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
        $user_detail = DB::table('users')->where('status', 1)->where('public_id', $id)->first();
//dd($user_detail);
        $teamdta=DB::table('teams')->where('status',1)->get();
        if ($user_detail->user_type == 4) {
            return view('users.edit-user', ['user_detail' => $user_detail,'teams'=>$teamdta]);
        } else {
            // dd("yes");\
            //  dd($user_detail);
            return view('users.edit-operator', ['user_detail' => $user_detail,'teams'=>$teamdta]);
        }

        //dd($user_detail);
    }

    // Store Contact Form data
    public function updateUser(Request $request)
    {


        // $save = new UserModel;

        $status = "";
        if ($request->operator_type == 3) {
            // dd($request);
            $validatedData = $request->validate([
                'user_name' => 'required',
                'mobile_number' => 'required',
            ]);

            $status = DB::table('users')
                ->where('public_id', $request->user_id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number

                ]);
        } else {

            $validatedData = $request->validate([
                'user_name' => 'required',
                'mobile_number' => 'required',
                'associate_rera_number' => 'required',
                'applier_name' => 'required',
                'applier_rera_number' => 'required',
                'team'=>'required'
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
