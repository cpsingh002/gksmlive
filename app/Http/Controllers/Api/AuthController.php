<?php

namespace App\Http\Controllers\Api;
use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\EmailDemo;
use Session;
use App\Http\Controllers\Api\NotificationController;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'associate_name' => 'required',
                'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,8}$/ix',
                'mobile_number' => 'required|unique:users',
                'password' => 'required',
                'associate_rera_number' => 'required|unique:users',
                'applier_rera_number' => 'required',
               'applier_name' => 'required',
                'team'=>'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
                $public_ids = Str::random(6);
                
                
            $user = UserModel::create([
                'public_id' => $public_ids,
                'name' => $request->associate_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mobile_number' => $request->mobile_number,
                'associate_rera_number' => $request->associate_rera_number,
                'applier_rera_number' => $request->applier_rera_number,
                'applier_name' => $request->applier_name,
                'team' => $request->team,
                'status' => 2,
                'user_type' =>4
            ]);
            $token = Str::random(64);
            $otp = rand(111111,999999);

            UserVerify::create([
            'user_id' => $user->id, 
            'token' => $token,
            'mobile_opt'=>$otp
            ]);
            
            $email = $request->email;
            $mailData = ['title' => 'Register Request Submit','name'=> $request->associate_name,'token' => $token];
            $hji= 'demoEmail';
            $subject='Register Request';
            Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
   
            $notifi = new NotificationController;
            $notifi->mobilesmsRegister($mailData,$request->mobile_number);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required',
                'user_type'=>'required',
                'device_token'=>'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            if(!Auth::attempt($request->only(['email', 'password','user_type']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            if($user->status == 5){
                return response()->json([
                    'status' => false,
                    'message' => 'Your Account is deactivated By Super Admin.',
                ], 401);
            }elseif($user->status != 1){    
                return response()->json([
                    'status' => false,
                    'message' => 'Validation not Completed yet.',
                ], 401);    
            }else{
                //Auth::logoutOtherDevices($request->get('password'));
                 Auth::logoutOtherDevices($request->get('password'));
                if(count(DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->get()) > 0){
                        DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->delete();
                }
                Auth::user()->update(['device_token'=>$request->device_token]);
                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'is_mobile_verified'=>Auth::user()->is_mobile_verified,
                    'is_email_verified'=>Auth::user()->is_email_verified,
                    'device_token'=>$request->device_token,
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function chnagePassword (Request $request)
    {
        
        $userd=DB::table('users')->where('public_id', Auth::user()->public_id)->first();
        $fg=(Hash::check($request->old_password, $userd->password));
        if($fg){
            $status = DB::table('users')->where('public_id', $userd->public_id)->update(['password' => Hash::make($request->password)]);
            return response()->json([
                'status' => true,
                'message' => 'Password Updated !!'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Password not matched !!'
            ], 200);
        }   
    }


    public  function checkEmail(Request $request)
    {
        try{
            $validateUser = Validator::make($request->all(), 
            [
                'user_type' => 'required',
                'email'=>'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user = DB::table('users')->where('status', 1)->where('user_type', $request->user_type)->where('email', $request->email)->first();
            if($user){
                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                $onetimepassword= substr(str_shuffle($data), 0, 8);
                $possw= Hash::make($onetimepassword);
                $status = DB::table('users')->where('public_id', $user->public_id)->update(['password' => $possw]);
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
                
                return response()->json([
                    'status' => true,
                    'message' => 'Email verified email sent successfully!!',    
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email',    
                ], 401); 
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->update(['device_token'=>'']);
        // $result = Auth::user()->id;
        $userd = UserModel::find(Auth::user()->id);
        $userd->device_token = NULL;
        $userd->save();
        //$status = DB::table('users')->where('public_id', Auth::user()->public_id)->update(['device_token'=>NULL]);
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'logged out !!',          
        ], 200);
    }
    
    public function profile(Request $request)
    {
        $user_detail = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->where('users.status', 1)->where('users.public_id', Auth::user()->public_id)->first();
        return response()->json([
            'status' => true,
            'result' => $user_detail
        ], 200);
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
        return response()->json([
                    'status' => true,
                    'message' => 'Verification email sent successfully!!',
                ], 200);
    }
     public function ReverifyAccountOTP(Request $request)
    {
        try{
            
            $otp = rand(111111,999999);
            $token = Str::random(64);
            UserVerify::create([
                'user_id' => Auth::user()->id, 
                'token' => $token,
                'mobile_opt'=>$otp
            ]);
        
            $email = Auth::user()->email;
            $mailData = [
                'title' => 'Register Request Submit',
                'name'=> Auth::user()->name,
                'token' => $otp
            ];
            $notifi = new NotificationController;
            $notifi->mobilesmsotpvefiy($mailData,Auth::user()->mobile_number);
            return response()->json([
                    'status' => true,
                    'message' => 'Verification OTP sent successfully!!',
                ], 200);
        }catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function verifyAccountotp(Request $request)
    {
        
        $verifyUser = UserVerify::where('mobile_opt', $request->token)->where('user_id',Auth::user()->id)->first();
        //   dd($verifyUser);
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
            return response()->json([
                    'status' => true,
                    'message' => $message,
                    'token'=>$request->token
                ], 200);
        }
  
       return response()->json([
                    'status' => false,
                    'message' => $message,
                    'token'=>$request->token
                ], 200);
    }
    public function Accountdelete(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [ 'other_info' => 'required']);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }         
            $user = User::find(Auth::user()->id)->update(['status'=>4,'delete_reason'=>$request->other_info]);
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully !'
            ], 200);            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
