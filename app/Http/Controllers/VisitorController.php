<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionModel;
use Hash;
use App\Models\UserActionHistory;

class VisitorController extends Controller
{
    //
    public function index(Request $request)
    {
        $users =User::where('user_type',5)->get();
        return view('visitor.list', ['users' => $users]);

    }
    public function addVisitor(Request $request)
    {
        $products = ProductionModel::where('status',1)->get();
        return view('visitor.add_visitor',['products'=>$products]);
    }

    public function storeVisitor(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6',
            
            'parent_id'=>'required'
        ]);

        $save = new UserModel;
        $user_type = 5;
        $save->parent_id = $request->parent_id;
        $save->parent_user_type = $request->parent_user_type;
        $save->name = $request->user_name;
        $save->email = $request->email;
        $save->mobile_number = $request->mobile_number;
        $save->password = Hash::make($request->password);
        $save->status = 1;
        $save->user_type = $user_type;
        $save->public_id = Str::random(6);
        $save->is_mobile_verified = 1;
        $save->is_email_verified = 1;
        $save->save();   
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'visitor add by '. Auth::user()->name .' with name '.$request->email .'.',
            'past_data' =>null,
            'new_data' => json_encode($save),
            'user_to' => $save->id
        ]);     
        return redirect()->back()->with('status', 'Visitor Added Successfully');
    }

    public function editVisitor(Request $request)
    {
        $visitor = User::where('public_id',$request->id)->first();
        $products = ProductionModel::where('status',1)->get();
        return view('visitor.edit_visitor',['products'=>$products,'visitor'=>$visitor]);

    }

    public function destroyVisitor(Request $request)
    {
        $user_detail = User::where('status', 1)->where('user_type',5)->where('public_id', $request->id)->first();
        $user_detail->delete();
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'visitor deleted by '. Auth::user()->name .' with name '.$user_detail->email .'.',
            'past_data' =>json_encode($user_detail),
            'new_data' => null,
            'user_to' => $user_detail->id
        ]);
        return redirect()->back()->with('status', 'Visitor  Deleted Successfully');
               
    }

    public function updateVisitor(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required',
            'mobile_number' => 'required|unique:users,mobile_number,'.$request->post('id'),
            'parent_id'=>'required',
            'email'=>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix|unique:users,email,'.$request->post('id')
        ]);
        $user_detail = User::where('user_type',5)->where('public_id', $request->user_id)->first();
        $status = DB::table('users')->where('user_type',5)->where('public_id', $request->user_id)
            ->update([
                'name' => $request->user_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'scheme_opertaor' =>$request->schemes

            ]);
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'visitor updated by '. Auth::user()->name .' with name '. $request->email .'.',
                'past_data' =>json_encode($user_detail),
                'new_data' => json_encode(User::find($user_detail->id)),
                'user_to' => $user_detail->id
            ]);

        if($request->password != '')
        {
            $validatedData = $request->validate(['password' => 'required|min:6']);
            $status = User::where('user_type',5)->where('public_id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->back()->with('status', 'Visitor  Updated Successfully');
    }
}
