<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Mail;
use Session;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function index()
    {

        return view('login');
    }

    public function adminLogin(Request $request)
    {
        // dd($request->role);
        // dd($request);
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);
        if ($request->role == '0') {
            $user_type = 1;
        } else if ($request->role == '1') {
            $user_type = 2;
        } elseif ($request->role == '2') {
            $user_type = 3;
        } elseif ($request->role == '3') {
            $user_type = 4;
        } else {
            return redirect('login')->with('success', 'Login details are not valid');
        }

        $credentials = $request->only('email', 'password');
        // dd($user_type);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1, 'user_type' =>  $user_type])) {
            // if (Auth::attempt($credentials)) {

            // dd(Auth::user());
            return redirect('/');
        }
        return redirect('login')->with('danger', 'Login details are not valid');
    }

    public function associateRegister()
    {
       $teamdta=DB::table('teams')->where('status',1)->get();
        return view('register',['teams'=>$teamdta]);
    }

    // Store Contact Form data
    public function storeAssociate(Request $request)
    {

        
        // dd($request);
        $validatedData = $request->validate([
            'associate_name' => 'required',
            'email' => 'required|email|unique:users',
            'associate_number' => 'required',
            'password' => 'required',
            'associate_rera_number' => 'required',
            'applier_rera_number' => 'required',
           'applier_name' => 'required',
            'team'=>'required'
        ]);

        $save = new UserModel;

        $save->name = $request->associate_name;
        $save->email = $request->email;
        $save->mobile_number = $request->associate_number;
        $save->associate_rera_number = $request->associate_rera_number;
        $save->applier_rera_number = $request->applier_rera_number;
        $save->applier_name = $request->applier_name;
        $save->password = Hash::make($request->password);
        $save->status = 2;
        $save->user_type = 4;
      
        $save->team= $request->team;
        $save->public_id = Str::random(6);
        $save->save();
        
        $email = $request->email;
   
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=> $request->associate_name,
        ];
   $hji= 'demoEmail';
   $subject = 'Register Request';
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        return redirect('/login');
    }


    public  function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('/login');
    }

    public  function forgotPassword()
    {
        return view('forgot_password');
    }
    public function chnagePassword (Request $request)
    {
        
//          $correct_hash = Hash::make($request->old_password);
//   dd($correct_hash, Hash::check('stpl@123..', $correct_hash));
        
        
        // print_r(Hash::make($request->old_password));
        $userd=DB::table('users')->where('public_id', Auth::user()->public_id)->first();
       //echo "<br>";
      //  print_r($userd->password);
       // dd($userd);
       $fg=(Hash::check($request->old_password, $userd->password));
        if($fg){
            //dd($userd->password);
             $status = DB::table('users')->where('public_id', $userd->public_id)->update([
                'password' => Hash::make($request->new_password),
            ]);
             return redirect('/logout')->with('status', 'Password Updated !!');
        }else{
             
              return redirect('/')->with('status', 'Password not matched !!');
        }
       
    }

    public  function checkEmail(Request $request)
    {
        // dd($request);


        if ($request->role == '1') {
            $user_type = 2;
        } elseif ($request->role == '2') {
            $user_type = 3;
        } elseif ($request->role == '3') {
            $user_type = 4;
        }
        $user = DB::table('users')->where('status', 1)->where('user_type', $user_type)->where('email', $request->email)->first();
         //dd($user);
        if ($user) {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            $onetimepassword= substr(str_shuffle($data), 0, 8);
            //print_r($onetimepassword);
            $possw= Hash::make($onetimepassword);
            //dd($onetimepassword);
            $status = DB::table('users')->where('public_id', $user->public_id)->update([
                'password' => $possw,
            ]);
            //dd($status);
            $email = $request->email;
           $mailData = [
                'title' => 'Forgot Password',
                'name'=> $user->name,
                'rand_id'=>$onetimepassword,
            ];
            $hji= 'forgot_password';   $subject = 'Forgot Password';
            Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
            
            
            
            // $data=['name'=>$user->name,'rand_id'=>$onetimepassword];
            // $userd['to']=$request->email;
            // Mail::send('Email/forgot_password',$data,function($messages) use ($userd){
            //     $messages->to($userd['to']);
            //     $messages->subject("Forgot Password");
            // });
            return redirect('/forgot-password')->with('success', 'Email verified email sent successfully!!');
        } else {
            return redirect('/forgot-password')->with('danger', 'Invalid email');
        }
    }
}
