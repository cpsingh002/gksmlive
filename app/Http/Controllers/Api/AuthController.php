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
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\Notification;
use App\Models\PushToken;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use App\Services\PushNotification;

class AuthController extends Controller
{

    private PushNotification $pushNotificationService;

    public function __construct(PushNotification $pushNotificationService)
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function subscribe(Request $request)
    {
        try {
            $token = $request->token;
            $topic = 'web-users';
            $response = $this->pushNotificationService->sendFirebaseTopicSubscription($token, $topic);
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

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
            UserActionHistory::create([
                'user_id' => $user->id,
                'action' => "Register Request Submit",
                'past_data' =>null,
                'new_data' => json_encode($user),
                'user_to' => $user->id
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
        
        // return response()->json([
        //     'status' => true,
        //     'message' => 'validation error',
        //     'result' => $request->post()
        // ], 200);
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
                Auth::user()->update(['device_token'=>$request->device_token,'is_mobile_verified'=>1,'is_email_verified'=>1]);
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
            
            $verifyUser = UserVerify::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->first();
            if(\Carbon\Carbon::parse($verifyUser->created_at)->addMinutes(3) > now()->format('Y-m-d H:i:s'))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Verification OTP sent successfully to your mobile number. For New OTp Please wait for 3 minutes!!',
                ], 200);
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

    public function topicsubscribeto(Request $request)
    {

        $credentialsFilePath = Storage::path('json/gksm-3d7c2-68e8fca9a5ad.json');
            $client = new GoogleClient();
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();

            $access_token = $token['access_token'];
        // $tokendf = PushToken::orderBy('id', 'DESC')->first();
        // $access_token = $tokendf->token;
        $headers =
            [
            
            "Authorization: Bearer $access_token",
            'Content-Type: application/json',
            'access_token_auth : true'];

        $ch = curl_init();
        // browser token you can get it via ajax from client side
        $token = $request->token;
        curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/iid/v1/$token/rel/topics/GKSMTOKEN");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        return response()->json([
            'status' => true,
            'result' => $result
        ], 200);
        // echo "The Result : " . $result;
    }

    public function sendnotifications(Request $request)
    {

        // $headers = array
        // (
        // 'Authorization: Bearer ' . $access_token,
        // 'Content-Type: application/json',
        // 'access_token_auth : true');
        // POST https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send HTTP/1.1

// Content-Type: application/json
// Authorization: Bearer ya29.ElqKBGN2Ri_Uz...HnS_uNreA
// {
//   "message":{
//     "topic" : "foo-bar",
//     "notification" : {
//       "body" : "This is a Firebase Cloud Messaging Topic Message!",
//       "title" : "FCM Message"
//       }
//    }
// }


 
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "topic" => 'gksm',
                "notification" => [
                    "title" => 'FCM Message',
                    "body" =>  'This is a Firebase Cloud Messaging Topic Message!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        dd($response);
        curl_close($ch);
        
        return ;
    }
}
