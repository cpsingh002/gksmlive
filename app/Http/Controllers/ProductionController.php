<?php

namespace App\Http\Controllers;

use App\Models\ProductionModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Mail\EmailDemo;
use Mail;
use App\Models\UserVerify;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;

class ProductionController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            $productions = DB::table('users')->where('user_type', 2)->where('status', 1)->get();
            return view('production.productions', ['productions' => $productions]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
    }

    public function addProduction()
    {
        return view('production/add-production');
    }


    // Store Contact Form data
    public function storeProduction(Request $request)
    {

        // dd($request);
        $validatedData = $request->validate([
            //'company_email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            // 'production_name' => 'required|unique:tbl_production',
            // 'production_description' => 'required',
            'password' => 'required|min:6',
        ]);

        $save = new UserModel;
        $productionSave = new ProductionModel;

        $production_arldy_exists = DB::table('users')->where('user_type', 2)->where('email', $request->email)->count();

        if($production_arldy_exists == 1){
            return redirect('/productions')->with('status', 'Production already added please change email address !!');
        }else{
            $save->email = $request->email;
            // $save->production_name = $request->production_name;
            // $save->production_description = $request->production_description;
            $save->password = Hash::make($request->password);
            $save->user_type = 2;
            $save->status = 1;
            $save->public_id = Str::random(6);
            $save->is_mobile_verified= 1;
           // $save->parent_id = $save->public_id;
            $save->save();
            if($save->id){
                $productionSave->public_id = Str::random(6);
                $productionSave->production_id = $save->id;
                $productionSave->save();
            }
            UserActionHistory ::create([
                'user_id' => $save->id,
                'action' => 'Production Created by'.Auth::user()->name .' by email '. $request->eamil .'.',
            ]);
            $update = UserModel::where('id',$save->id)->update(['parent_id'=>$save->id]);
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
                'name'=> 'Production Name',
                'token' => $token
            ];
            $hji= 'demoEmail';
            $subject = 'Register Request';
            Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
            return redirect('/productions')->with('status', 'Production added successfully !!');
        }
    }

    public function destroyProduction($id)
    {
        $productions = DB::table('users')->where('user_type', 2)->where('public_id', $id)->first();
        // dd($productions->id);
        $update = DB::table('users')->where('public_id', $id)->limit(1)->update(['status' => 3]);
        // dd($update);
        if ($update) {
            $update = DB::table('tbl_production')->where('production_id', $productions->id)->limit(1)->update(['status' => 3]);
            UserActionHistory ::create([
                'user_id' => Auth::user()->id,
                'action' => 'Production deleted by'.Auth::user()->name .' by email '. $productions->eamil .'.',
            ]);
            return redirect('/productions')->with('status', 'Production Deleted successfully');
        }
    }

    public function getProduction($id)
    {
        $user = DB::table('users')->where('public_id', $id)->first();
        // dd($user->id);
        $production = DB::table('tbl_production')->where('production_id', $user->id)->first();
        // dd($production->production_name);
        return view('production.update-production', ['production' => $production]);
    }

    public function updateProduction(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'production_name' => 'required|unique:tbl_production,production_name,'.$request->id,
            'production_description' => 'required'
        ]);
        
        $dfgj=DB::table('tbl_production')->where('public_id', $request->production_id)->get();
        if($request->hasfile('production_img')){
            $image = $request->file('production_img');
            $filename_img = $image->getClientOriginalName();
            $image->move(public_path('files'), $filename_img);
        }else{
            $filename_img = $dfgj[0]->production_img;
        }

        // $save = new UserModel;

        $status = DB::table('tbl_production')->where('public_id', $request->production_id)
                ->update([
                    'production_name' => $request->production_name,
                    'production_description' => $request->production_description,
                    'production_img'=>$filename_img,
                ]);
            
        $production=DB::table('tbl_production')->where('public_id', $request->production_id)->first();
        $namejk=DB::table('users')->where('id', $production->production_id)
                ->update([
                    'name' => $request->production_name,
                    'image'=>$filename_img,
                ]);
        UserActionHistory ::create([
            'user_id' => $production->production_id,
            'action' => 'Production information updated by '. Auth::user()->name .'.',
        ]);
        return redirect('/productions')->with('status', 'Production Updated Successfully');
    }



    public function LoginPage(Request $request)
    {
        return view('production/production_login');
    }

    public function ProductionLogin(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect('/');
        }
        return redirect('associate-login')->with('success', 'Login details are not valid');
    }

    public function productionProfilePage(Request $request)
    {
        $production_detail = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
        // dd($production_detail->production_name);
        return view('production/production-profile', ['production_detail' => $production_detail]);
        // return view('production/production-profile');
    }

    public function profileUpdate(Request $request)
    {
        $validatedData = $request->validate([
           'production_name' => 'required|unique:tbl_production,production_name,'.$request->id,
           'production_description' => 'required',
        ]);
        
        $dfgj=DB::table('tbl_production')->where('production_id', $request->production_id)->first();
        if($request->hasfile('production_img')){
            $image = $request->file('production_img');
            $filename_img = $image->getClientOriginalName();
            $image->move(public_path('files'), $filename_img);
        }else{
            $filename_img = $dfgj->production_img;
        }
    
        $status = DB::table('tbl_production')->where('production_id', $request->production_id)
            ->update([
                'production_name' => $request->production_name,
                'production_description' => $request->production_description,
                'production_img'=>$filename_img,
            ]);
            
        $mg= DB::table('users')->where('id',$request->production_id)
             ->update([                
                 'image'=>$filename_img,
                 'name'=>$request->production_name,
            ]);

        UserActionHistory ::create([
            'user_id' => $dfgj->production_id,
            'action' => 'Production information updated by '. Auth::user()->name .'.',
        ]);
        if(Auth::user()->id){
            return redirect('/production')->with('status', 'Production Updated Successfully');
        }else{
            return redirect('/productions')->with('status', 'Production Updated Successfully');
        }    
        
    }
}
