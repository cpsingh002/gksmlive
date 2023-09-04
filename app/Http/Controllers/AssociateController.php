<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\AdminModel;
use App\Models\UserModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;

require base_path("vendor/autoload.php");

use Maatwebsite\Excel\Facades\Excel;

class AssociateController extends Controller
{
    public function index()
    {


        $associates = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->whereIn('users.status', [1, 5])->where('users.user_type', 4)->get();
        // dd($associates);

        return view('associate.associates', ['associates' => $associates]);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }

    public function addAssociate()
    {

       $teamdta=DB::table('teams')->where('status',1)->get();
        return view('associate.add-associate',['teams'=>$teamdta]);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }

    // Store Contact Form data
    public function storeAssociate(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required',
            'password' => 'required',
            'associate_rera_number' => 'required',
            'applier_name' => 'required',
            'applier_rera_number' => 'required',
            'team'=>'required'
        ]);

        $save = new UserModel;

        // dd($save);
        $user_type = 4;
        $save->parent_id = $request->parent_id;
        $save->parent_user_type = $request->parent_user_type;
        $save->email = $request->email;
        $save->name = $request->user_name;
        $save->mobile_number = $request->mobile_number;
        $save->password = Hash::make($request->password);
        $save->associate_rera_number = $request->associate_rera_number ? $request->associate_rera_number : '';
        $save->applier_name = $request->applier_name ? $request->applier_name : '';
        $save->applier_rera_number = $request->applier_rera_number ? $request->applier_rera_number : '';
        $save->status = 2;
        $save->team = $request->team;
        $save->user_type = $user_type;
        $save->public_id = Str::random(6);
        $save->save();

        $email = $request->email;
   
        $mailData = [
            'title' => 'Register Request Submit',
            'name'=> $request->user_name,
        ];
         $hji= 'demoEmail';
         $subject='Register Request';
  
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
   
        // return response()->json([
        //     'message' => 'Email has been sent.'
        // ], Response::HTTP_OK);

         return redirect('/associates')->with('status', 'Associate Added Successfully');
        // return redirect('/add-associate')->with('status', 'Associate Added Successfully');
    }

    public function AssociatePendingRequest()
    {
         $associates = DB::table('users')->select('users.*','teams.team_name')->leftJoin('teams','users.team','teams.public_id')->where('users.status', 2)->where('users.user_type', 4)->orderBy('users.id','ASC')->get();
        // dd($associates);
        return view('users.pending-request', ['associates' => $associates]);
    }

    public function approvedStatus(Request $request)
    {
        //dd($request);
        //dd($request->userid);
        $status = DB::table('users')
            ->where('public_id', $request->userid)
            ->update(['status' => 1]);
            
            $model=DB::table('users')
            ->where('public_id', $request->userid)->get();
            
            
             $email = $model['0']->email;
   
        $mailData = [
            'title' => 'Associate Request Approved',
            'name' => $model['0']->name,
        ];
         $hji= 'associate_approved';
         $subject='Associate Request Approved';
  
        Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
//dd($model);
            // $data=['name'=>$model['0']->name];
            // $user['to']=$model['0']->email;
            // Mail::send('Email/associate_approved',$data,function($messages) use ($user){
            //     $messages->to($user['to']);
            //     $messages->subject("Associate Request Approved");
            // });
        return redirect('/associates');
    }

    public function cancelledStatus(Request $request)
    {
        // dd($request);
    
    // $model= Airport::where(['public_id'=> $request->cancel_id]);
    // $model->delete();
    
    

        $status = DB::table('users')
            ->where('public_id', $request->cancel_id)
            ->delete();
        return redirect('/associates');
    }

    public function AssociateLogin(Request $request)
    {

        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect('/');
        }

        // if (Auth::attempt($credentials)) {
        //     return redirect('/');
        // }
        return redirect('associate-login')->with('success', 'Login details are not valid');
    }

    public  function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('login');
    }

    public function exportAssociate()
    {
        $associates = DB::table('users')->whereIn('status', [1, 5])->where('user_type', 4)->get();
        dd($associates);
        // $fileName = "export_associate-" . date('Ymd') . ".xlsx";
       
        // // header("Content-Disposition: attachment; filename=\"$fileName\"");
        // // header("Content-Type: application/vnd.ms-excel");
        // function filterData(&$str){
        //     $str = preg_replace("/\t/", "\\t", $str);
        //     $str = preg_replace("/\r?\n/", "\\n", $str);
        //     if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        // }
        
        
        // $flag = false;
        // foreach ($associates as $row) {
        //     $arr_keys = [
        //         'id' => $row->id,
        //         'public_id' => $row->public_id,
        //         'email' => $row->email,
        //     ];
        //     if (!$flag) {
        //         // dd($row);   
        //         // Set column names as first row
        //         echo implode("\t", array_keys($arr_keys)) . "\n";
        //         $flag = true;
        //     }
           
        //     // Filter data
        //     array_walk($row, 'filterData');
        //     echo implode("\t", array_values($row)) . "\n";
        // }
        // dd($row);
        // exit;
        return redirect('associate')->with('success', 'Login details are not valid');
        // return view('/associate);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }

    public function indexopertor()
    {


        $associates = DB::table('users')->select('users.*','tbl_production.production_name')
        ->leftJoin('tbl_production','users.parent_id','tbl_production.production_id')->whereIn('users.status', [1, 5])->where('users.user_type', 3)->get();
         //dd($associates);

        return view('associate.opertors', ['associates' => $associates]);
        // return redirect('associate_login')->with('success', 'you are not allowed to access');
    }
}
