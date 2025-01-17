<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Mail;
use Session;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\NotificationController;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\Notification;
use App\Http\Controllers\Services\PushNotification;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
   // public function authenticated(Request $request, $user) {
   
    //  Auth::logoutOtherDevices($request->get('password'));
       
    // } 

    public function adminLogin(Request $request)
    {
        // dd($request->role);
        //  dd($request);
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);
        if($request->role == '0'){
            $user_type = 1;
        }else if ($request->role == '1'){
            $user_type = 2;
        }elseif ($request->role == '2'){
            $user_type = 3;
        }elseif ($request->role == '3'){
            $user_type = 4;
        }elseif($request->role == '4'){
            $user_type = 5;
        }elseif($request->role == '5'){
            $user_type = 6;
        }else{
            return redirect('login')->with('success', 'Login details are not valid');
        }

        $credentials = $request->only('email', 'password');
        //  dd($user_type);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,  'user_type' =>  $user_type])) {
            // if (Auth::attempt($credentials)) {
            if(Auth::user()->status == 1){
                // dd(Auth::user());
                $user = User::where('id', Auth::user()->id)->first();
                $user->device_token = $request->device_token;
                $user->save();
                // Auth::user()->device_token =  $request->device_token;
                if(Auth::user()->user_type != 1){
                    Auth::logoutOtherDevices($request->get('password'));
                    if (count(DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->get()) > 0)
                    {
                        DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->delete();
                    }
                }
                if ($request->role == '0') {
                    return redirect('/admin');
                } else if ($request->role == '1') {
                    return redirect('/production');
                } elseif ($request->role == '2') {
                    return redirect('/opertor');
                } elseif ($request->role == '3') {
                    return redirect('/associate');
                }elseif($request->role == '4'){
                    return redirect('/production/schemes');
                }elseif($request->role == '5')
                {
                    // dd('hj');
                    return redirect('/admin');
                }
            }else{
                return redirect('login')->with('danger', 'Your Account is deactivated By Super Admin.');
            }
        }
        return redirect('login')->with('danger', 'Login details are not valid');
    }

    public function associateRegister()
    {
       $teamdta = DB::table('teams')->where('status',1)->get();
    //    dd($teamdta);
        return view('register',['teams'=>$teamdta]);
    }

    // Store Contact Form data
    public function storeAssociate(Request $request)
    {      
        // dd($request);
        $validatedData = $request->validate([
            'associate_name' => 'required',
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'associate_rera_number' => 'required|unique:users',
            'applier_rera_number' => 'required',
           'applier_name' => 'required',
            'team'=>'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $save = new UserModel;
        $save->name = $request->associate_name;
        $save->email = $request->email;
        $save->mobile_number = $request->mobile_number;
        $save->associate_rera_number = $request->associate_rera_number;
        $save->applier_rera_number = $request->applier_rera_number;
        $save->applier_name = $request->applier_name;
        $save->password = Hash::make($request->password);
        $save->status = 2;
        $save->user_type = 4;  
        $save->team= $request->team;
        $save->public_id = Str::random(6);
        $save->save();
        
        $token = Str::random(64);
        $otp = rand(111111,999999);

        UserVerify::create([
          'user_id' => $save->id, 
          'token' => $token,
          'mobile_opt'=>$otp
        ]);
        
        $email = $request->email;
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=> $request->associate_name,
            'token' => $token
        ];
        $hji= 'demoEmail';
        $subject = 'Register Request';
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        
        $notifi = new NotificationController;
        $notifi->mobilesmsRegister($mailData,$request->associate_number);
        UserActionHistory::create([
            'user_id' => $save->id,
            'action' => "Register Request Submit",
            'past_data' =>null,
            'new_data' => json_encode($save),
            'user_to' => $save->id
        ]);
        
        return redirect('/login');
    }
    
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;          
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        return redirect()->route('login')->with('message', $message);
    }
    
    public function verifyAccountotp(Request $request)
    {
        $verifyUser = UserVerify::where('mobile_opt', $request->token)->where('user_id',Auth::user()->id)->first();
        $message = 'Sorry Your OTP does not matched.';
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_mobile_verified){
                $verifyUser->user->is_mobile_verified = 1;
                $verifyUser->user->save();
                $message = "Your Mobile is verified. You can now login.";
            }else{
                $message = "Your Mobile is already verified. You can now login.";
            }       
            return response()->json(['status'=>'success','message' => $message]); 
        }    
        return response()->json(['status'=>'error','message' => $message,]); 
    
    }
    
    public function ReverifyAccountotp(Request $request)
    {
        $verifyUser = UserVerify::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->first();
        if(\Carbon\Carbon::parse($verifyUser->created_at)->addMinutes(3) > now()->format('Y-m-d H:i:s'))
        {
            return redirect()->back()->with('msg', 'Verification OTP sent successfully to your mobile number. For New OTP, Please wait for 3 minutes!!');
        }
        $otp = rand(111111,999999);
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => Auth::user()->id, 
            'token' => $token,
            'mobile_opt'=>$otp
        ]);
        $email = Auth::user()->email;  
        $mailData = [
            'name'=> Auth::user()->name,
            'token' => $otp
        ];
        $notifi = new NotificationController;
        $notifi->mobilesmsotpvefiy($mailData,Auth::user()->mobile_number);
        return redirect()->back()->with('msg', 'Verification OTP sent successfully to your mobile number!!');
    }
    public function ReverifyAccount(Request $request)
    {
        $token = Str::random(64);
        $otp = rand(111111,999999);
  
        UserVerify::create([
            'user_id' => Auth::user()->id, 
            'token' => $token,
            'mobile_opt'=>$otp
        ]);
        
        $email = Auth::user()->email;
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=> Auth::user()->name,
            'token' => $token
        ];
        $hji= 'demoEmail';
        $subject = 'Register Request';
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
        return redirect('/logout');
    }
    public function Reverif(Request $request)
    {
        return view('users.verfiy');
    }

    public function Reverifotp(Request $request)
    {
        return view('users.otpverfiy');
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
        $validatedData = $request->validate(['new_password' => 'required|min:6']);
        $userd=DB::table('users')->where('public_id', Auth::user()->public_id)->first();
        $fg=(Hash::check($request->old_password, $userd->password));
        if($fg){
            $status = DB::table('users')->where('public_id', $userd->public_id)->update(['password' => Hash::make($request->new_password)]);
            UserActionHistory::create([
                'user_id' => $userd->id,
                'action' => "Password Updated by User",
                'past_data' =>null,
                'new_data' => null,
                'user_to' => $userd->id
                
            ]);
            return redirect('/logout')->with('status', 'Password Updated !!');
        }else{
            return redirect('/')->with('status', 'Password not matched !!');
        }
    }
    
     public function adminchnagePassword (Request $request)
    {
        //dd($request);
        $validatedData = $request->validate(['password' => 'required|min:6']);
        $status = DB::table('users')->where('public_id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect('/associates')->with('status', 'Password Updated !!');
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
            $possw= Hash::make($onetimepassword);
            $status = DB::table('users')->where('public_id', $user->public_id)->update([
                'password' => $possw,
            ]);
            $email = $request->email;
            $mailData = [
                'title' => 'Forgot Password',
                'name'=> $user->name,
                'rand_id'=>$onetimepassword,
            ];
            $hji= 'forgot_password';   $subject = 'Forgot Password';
            Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
            $notifi = new NotificationController;
            $notifi->mobilesmsotlp($mailData,$user->mobile_number);
            return redirect('/forgot-password')->with('success', 'Email verified email sent successfully!!');
        } else {
            return redirect('/forgot-password')->with('danger', 'Invalid email');
        }
    }
}
