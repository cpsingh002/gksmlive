<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        
        if (Auth::check()) {
            $usersCount = DB::table('users')->count();
            $productionsCount = DB::table('tbl_production')->where('status', 1)->count();
            $schemesCount = DB::table('tbl_scheme')->where('status', 1)->count();
            $bookPropertyCount = DB::table('tbl_property')->where('booking_status', 2)->count();
            $holdPropertyCount = DB::table('tbl_property')->where('booking_status', 3)->count();
            // dd($schemesCount);
            $bookdata = DB::table("tbl_scheme")->select("tbl_scheme.id","tbl_scheme.scheme_name", DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id","tbl_scheme.scheme_name")->where('tbl_property.booking_status',2)->get();
                // dd($bookdata);
            $holddata = DB::table("tbl_scheme")->select("tbl_scheme.id","tbl_scheme.scheme_name", DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id","tbl_scheme.scheme_name")->where('tbl_property.booking_status',3)->get();
            $completedata = DB::table("tbl_scheme")->select("tbl_scheme.id","tbl_scheme.scheme_name","tbl_scheme.no_of_plot" ,DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id","tbl_scheme.scheme_name","tbl_scheme.no_of_plot")->where('tbl_property.booking_status',5)->get();
             $proofvdata = DB::table("tbl_scheme")->select("tbl_scheme.id","tbl_scheme.scheme_name",'tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->where('tbl_property.booking_status',2)->where('payment_proofs.status',1)->leftJoin('users','users.id','payment_proofs.upload_by') ->get();
            
            $proofdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")
                ->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')->leftJoin('users','users.id','payment_proofs.upload_by')
                ->where('tbl_property.booking_status',2)->where('payment_proofs.status',0)->get();
            $waitingdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','tbl_property.waiting_list')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->where('tbl_property.waiting_list','>',0)->get();
                
            //dd($waitingdata);
            // ->join("tbl_property","tbl_scheme.id","=","tbl_property.scheme_id")
            
            $teamdata = DB::table("teams")->select("teams.id",'teams.team_name','teams.public_id', DB::raw("count(*) as user_count"))
                ->join("users","users.team","=","teams.public_id")->groupBy("teams.id",'teams.team_name','teams.public_id')->where('users.status',1)->get();
               
            $productiondata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("tbl_scheme","tbl_scheme.production_id","=","tbl_production.public_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('tbl_scheme.status',1)->get();
                
            $opertordata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("users","users.parent_id","=","tbl_production.production_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('users.status',1)->where('users.user_type',3)->get();
                 //dd($opertordata);
            return view('dashboard',['usersCount' => $usersCount, 'bookPropertyCount'=>$bookPropertyCount, 
            'holdPropertyCount'=> $holdPropertyCount, 'schemesCount' => $schemesCount,'bookdata'=>$bookdata,'holddata'=>$holddata,'completedata'=>$completedata,
            'proofvdata'=>$proofvdata,'proofdata'=>$proofdata,'opertordata'=>$opertordata,'productiondata'=>$productiondata,'teamdata'=>$teamdata,'waitingdata'=>$waitingdata]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
        // return view('dashboard');
    }
    
    
    
    public function indexpro()
    {
        
        if (Auth::check()) {
            $usersCount = DB::table('users')->count();
            $productionsCount = DB::table('tbl_production')->where('status', 1)->count();
            $schemesCount = DB::table('tbl_scheme')->where('status', 1)->count();
            $bookPropertyCount = DB::table('tbl_property')->where('booking_status', 2)->count();
            $holdPropertyCount = DB::table('tbl_property')->where('booking_status', 3)->count();
            // dd($schemesCount);
            $bookdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',2)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->get();
                
            $holddata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',3)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->get();
                
            $completedata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot' ,DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot')->where('tbl_property.booking_status',5)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->get();
                
             $proofvdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->leftJoin('users','users.id','payment_proofs.upload_by')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_property.booking_status',2)->where('payment_proofs.status',1)->get();
                
            $proofdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->leftJoin('users','users.id','payment_proofs.upload_by')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_property.booking_status',2)->where('payment_proofs.status',0)->get();
                
            $waitingdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','tbl_property.waiting_list')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)
                ->where('tbl_property.waiting_list','>',0)->get();
                
           // dd($waitingdata);
            // ->join("tbl_property","tbl_scheme.id","=","tbl_property.scheme_id")
            
            $teamdata = DB::table("teams")->select("teams.id",'teams.team_name','teams.public_id', DB::raw("count(*) as user_count"))
                ->join("users","users.team","=","teams.public_id")->groupBy("teams.id",'teams.team_name','teams.public_id')->where('users.status',1)->get();
               
            $productiondata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("tbl_scheme","tbl_scheme.production_id","=","tbl_production.public_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('tbl_scheme.status',1)->get();
                
            $opertordata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("users","users.parent_id","=","tbl_production.production_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('users.status',1)->where('users.user_type',3)->get();
                 //dd($opertordata);
            return view('dashboard_p',['usersCount' => $usersCount, 'bookPropertyCount'=>$bookPropertyCount, 
            'holdPropertyCount'=> $holdPropertyCount, 'schemesCount' => $schemesCount,'bookdata'=>$bookdata,'holddata'=>$holddata,'completedata'=>$completedata,
            'proofvdata'=>$proofvdata,'proofdata'=>$proofdata,'opertordata'=>$opertordata,'productiondata'=>$productiondata,'teamdata'=>$teamdata,'waitingdata'=>$waitingdata]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
        // return view('dashboard');
    }
    
    
    
    public function indexass()
    {
        
        if (Auth::check()) {
            $usersCount = DB::table('users')->count();
            $productionsCount = DB::table('tbl_production')->where('status', 1)->count();
            $schemesCount = DB::table('tbl_scheme')->where('status', 1)->count();
            $bookPropertyCount = DB::table('tbl_property')->where('booking_status', 2)->count();
            $holdPropertyCount = DB::table('tbl_property')->where('booking_status', 3)->count();
            // dd($schemesCount);
            $bookdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',2)->where('tbl_property.user_id',Auth::user()->public_id)->get();
            $holddata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',3)->where('tbl_property.user_id',Auth::user()->public_id)->get();
            $completedata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot' ,DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot')->where('tbl_property.booking_status',5)->where('tbl_property.user_id',Auth::user()->public_id)->get();
                
             $proofvdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->leftJoin('users','users.id','payment_proofs.upload_by')->where('tbl_property.booking_status',2)->where('payment_proofs.status',1)->where('tbl_property.user_id',Auth::user()->public_id)->get();
            $proofdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->leftJoin('users','users.id','payment_proofs.upload_by')->where('tbl_property.booking_status',2)->where('payment_proofs.status',0)->where('tbl_property.user_id',Auth::user()->public_id)->get();
           // dd($proofvdata);
            // ->join("tbl_property","tbl_scheme.id","=","tbl_property.scheme_id")
            
             $waitingdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','tbl_property.waiting_list')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")
                ->join('waiting_list_members',function ($join) {
                $join->on('waiting_list_members.scheme_id', '=', 'tbl_property.scheme_id')->On('waiting_list_members.plot_no', '=', 'tbl_property.plot_no');})->where('waiting_list_members.user_id',Auth::user()->public_id)->where('tbl_property.waiting_list','>',0)->get();
            
            // $waitingdata =DB::table('tbl_property')->leftjoin('waiting_list_members','waiting_list_members.scheme_id','=','tbl_property.scheme_id')
            // ->where('waiting_list_members.user_id',Auth::user()->parent_id)->where('tbl_property.waiting_list','>',0)->get();
            
            //dd($waitingdata);
            $teamdata = DB::table("teams")->select("teams.id",'teams.team_name','teams.public_id', DB::raw("count(*) as user_count"))
                ->join("users","users.team","=","teams.public_id")->groupBy("teams.id",'teams.team_name','teams.public_id')->where('users.status',1)->get();
               
            $productiondata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("tbl_scheme","tbl_scheme.production_id","=","tbl_production.public_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('tbl_scheme.status',1)->get();
                
            $opertordata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("users","users.parent_id","=","tbl_production.production_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('users.status',1)->where('users.user_type',3)->get();
                 //dd($opertordata);
            return view('dashboard_a',['usersCount' => $usersCount, 'bookPropertyCount'=>$bookPropertyCount, 
            'holdPropertyCount'=> $holdPropertyCount, 'schemesCount' => $schemesCount,'bookdata'=>$bookdata,'holddata'=>$holddata,'completedata'=>$completedata,
            'proofvdata'=>$proofvdata,'proofdata'=>$proofdata,'opertordata'=>$opertordata,'productiondata'=>$productiondata,'teamdata'=>$teamdata,'waitingdata'=>$waitingdata]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
        // return view('dashboard');
    }
    
    public function indexop()
    {
        
        if (Auth::check()) {
            $usersCount = DB::table('users')->count();
            $productionsCount = DB::table('tbl_production')->where('status', 1)->count();
            $schemesCount = DB::table('tbl_scheme')->where('status', 1)->count();
            $bookPropertyCount = DB::table('tbl_property')->where('booking_status', 2)->count();
            $holdPropertyCount = DB::table('tbl_property')->where('booking_status', 3)->count();
            // dd($schemesCount);
            $bookdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',2)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
            $holddata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name', DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name')->where('tbl_property.booking_status',3)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
            $completedata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot' ,DB::raw("count(*) as user_count"))
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->groupBy("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_scheme.no_of_plot')->where('tbl_property.booking_status',5)
                ->where('tbl_production.production_id',Auth::user()->parent_id)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
             $proofvdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->leftJoin('users','users.id','payment_proofs.upload_by')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_property.booking_status',2)
                ->where('payment_proofs.status',1)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
            $proofdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','payment_proofs.payment_details','payment_proofs.proof_image','payment_proofs.id as payment_id','users.name','users.user_type')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('payment_proofs','payment_proofs.property_id','=','tbl_property.id')
                ->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->leftJoin('users','users.id','payment_proofs.upload_by')
                ->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_property.booking_status',2)
                ->where('payment_proofs.status',0)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
                $waitingdata = DB::table("tbl_scheme")->select("tbl_scheme.id",'tbl_scheme.scheme_name','tbl_property.plot_no','tbl_property.plot_name','tbl_property.booking_time','tbl_property.associate_name','tbl_property.associate_number','tbl_property.waiting_list')
                ->join("tbl_property","tbl_property.scheme_id","=","tbl_scheme.id")->join('tbl_production','tbl_production.public_id','=','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)
                ->where('tbl_property.waiting_list','>',0)->whereIn('tbl_scheme.id',json_decode(Auth::user()->scheme_opertaor))->get();
                
           // dd($waitingdata);
            // ->join("tbl_property","tbl_scheme.id","=","tbl_property.scheme_id")
            
            $teamdata = DB::table("teams")->select("teams.id",'teams.team_name','teams.public_id', DB::raw("count(*) as user_count"))
                ->join("users","users.team","=","teams.public_id")->groupBy("teams.id",'teams.team_name','teams.public_id')->where('users.status',1)->get();
               
            $productiondata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("tbl_scheme","tbl_scheme.production_id","=","tbl_production.public_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('tbl_scheme.status',1)->get();
                
            $opertordata= DB::table("tbl_production")->select("tbl_production.id",'tbl_production.production_name', DB::raw("count(*) as user_count"))
                ->join("users","users.parent_id","=","tbl_production.production_id")->groupBy("tbl_production.id",'tbl_production.production_name')->where('users.status',1)->where('users.user_type',3)->get();
                 //dd($opertordata);
            return view('dashboard_p',['usersCount' => $usersCount, 'bookPropertyCount'=>$bookPropertyCount, 
            'holdPropertyCount'=> $holdPropertyCount, 'schemesCount' => $schemesCount,'bookdata'=>$bookdata,'holddata'=>$holddata,'completedata'=>$completedata,
            'proofvdata'=>$proofvdata,'proofdata'=>$proofdata,'opertordata'=>$opertordata,'productiondata'=>$productiondata,'teamdata'=>$teamdata,'waitingdata'=>$waitingdata]);
        }
        return redirect('login')->with('success', 'you are not allowed to access');
        // return view('dashboard');
    }
    
    public function asdfgh(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        $number=User::whereNotNull('mobile_number')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('mobile_number')->all();
        dd($number,$firebaseToken);
        
    }
    
}
