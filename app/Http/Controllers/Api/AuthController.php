<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'associate_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'associate_number' => 'required',
                'password' => 'required',
                'associate_rera_number' => 'required',
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

            $user = User::create([
                'associate_name' => $request->associate_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'associate_number' => $request->associate_number,
                'associate_rera_number' => $request->associate_rera_number,
                'applier_rera_number' => $request->applier_rera_number,
                'applier_name' => $request->applier_name,
                'team' => $request->team,
                'status' => 2,
                'user_type' => 4,
                'public_id' => Str::random(6)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
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
                'user_type'=>'required'
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
            if($user->status != 1){

                return response()->json([
                    'status' => false,
                    'message' => 'Validation not Completed yet.',
                ], 401);

            }else{

            

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
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
        
        //          $correct_hash = Hash::make($request->old_password);
        //   dd($correct_hash, Hash::check('stpl@123..', $correct_hash));
        
        
        
        $userd=DB::table('users')->where('public_id', Auth::user()->public_id)->first();
       
       $fg=(Hash::check($request->old_password, $userd->password));
        if($fg){
           
             $status = DB::table('users')->where('public_id', $userd->public_id)->update([
                'password' => Hash::make($request->new_password),
            ]);return response()->json([
                'status' => true,
                'message' => 'Password Updated !!'
            ], 200);
            // return redirect('/logout')->with('status', 'Password Updated !!');
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Password not matched !!'
            ], 200);
            //  return redirect('/')->with('status', 'Password not matched !!');
        }
       
    }


    public  function checkEmail(Request $request)
    {
        // dd($request);

        try {
            //Validated
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

            $user = DB::table('users')->where('status', 1)->where('user_type', $user_type)->where('email', $request->email)->first();

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
                
                
                return response()->json([
                    'status' => true,
                    'message' => 'Email verified email sent successfully!!',
                    
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email',
                    
                ], 200); 
            }
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'logged out !!'
        ], 200);
    }

    public function profile(Request $request)
    {
        $user_detail = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->where('users.status', 1)->where('users.public_id', Auth::user()->public_id)->first();
        return response()->json([
            'status' => true,
            'result' => $user_detail,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
}
