<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SchemeModel;
use App\Models\WaitingListMember;
use App\Models\WaitingListCustomer;
use App\Models\PaymentProof;
use App\Models\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use App\Mail\EmailDemo;
use App\Models\User;
use App\Http\Controllers\Api\NotificationController;
use App\Jobs\SendEmails;
use App\Models\Team;
use App\Models\ProductionModel;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;

class SchemeController extends Controller
{
    public function opertorviewshceme($id){
        
        if((Auth::user()->user_type == 3) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 5)){
            $properties = DB::table('tbl_property')
            ->select('tbl_property.freez','tbl_property.booking_time','users.parent_id as gvg','tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.cancel_time','tbl_property.management_hold','users.name','tbl_property.waiting_list')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->leftJoin('users','users.public_id','=','tbl_property.user_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')->get();

            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
            
            $current_time = now();
        }elseif(Auth::user()->user_type == 1){

        
            $properties = DB::table('tbl_property')
            ->select('tbl_property.freez','tbl_property.booking_time','tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold','users.name','tbl_property.waiting_list')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftJoin('users','tbl_property.user_id','=','users.public_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
            ->get();

            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
         
            $current_time = now();
       
        }elseif(Auth::user()->user_type == 4){
            //dd($id);
            $teamdta=DB::table('teams')->where('super_team',1)->get();
                $super_team=[];
                    $i=1;
                    foreach($teamdta as $list)
                    {
                        $original_array =  $list->public_id;
                        $super_team[]=$original_array;
                        $i++;
                    }
            if((Auth::user()->all_seen == 0)&&(!in_array(Auth::user()->team, $super_team))){
                $properties = DB::table('tbl_property')
                ->select('tbl_property.freez','tbl_property.booking_time','tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold','users.name','tbl_property.waiting_list')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftJoin('users','tbl_property.user_id','=','users.public_id')
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])
                ->where('tbl_scheme.team', Auth::user()->team)->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
                ->get();
            }else{

                $properties = DB::table('tbl_property')
                ->select('tbl_property.freez','tbl_property.booking_time','tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time','tbl_property.management_hold','users.name','tbl_property.waiting_list')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftJoin('users','tbl_property.user_id','=','users.public_id')
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
                ->get();
            }
            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
         
            $current_time = now();
        
            
        }
            // dd($properties);
        if(isset($properties[0])){
            
            return view('scheme.properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
        }else{
            session()->flush();
            return redirect()->route('login');
        }
        
    }
    public function index()
    {
       
        $schemes = DB::table('tbl_scheme')
            ->select('users.parent_id as upublic_id','tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status','tbl_scheme.hold_status','tbl_scheme.status')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')->leftJoin('users','users.id','=','tbl_production.production_id')
            ->where('tbl_scheme.status','!=',3)->get();
           
        $avalib_slot=[];
        foreach($schemes as $list){
            $avalib_slot[$list->scheme_id]= DB::table('tbl_property')->where('scheme_id',$list->scheme_id)->whereIn('booking_status',[1,0])->where('status','!=',3)->count();
        }

        // super team field
         $teamdta=DB::table('teams')->where('super_team',1)->get();
         $super_team=[];
            $i=1;
            foreach($teamdta as $list)
            {
                $original_array =  $list->public_id;
                $super_team[]=$original_array;
                $i++;
            }
            $schdata = json_decode(Auth::user()->scheme_opertaor);
      
        return view('scheme.schemes', ['schemes' => $schemes,'teams'=>$super_team,'a_slot'=> $avalib_slot,'schdata'=>$schdata]);
      
    }

    public function addScheme()
    {
        $productions = DB::table('tbl_production')->where('status', 1)->get();
        $teamdta=DB::table('teams')->where('status',1)->get();
        return view('scheme.add-scheme', ['productions' => $productions,'teams'=>$teamdta]);
        // return view('scheme/add-scheme');
    }


    // Store Contact Form data
    public function storeScheme(Request $request)
    {

        $validatedData = $request->validate([
            'scheme_name' => 'required|unique:tbl_scheme',
            'scheme_img'=>'required',
            'brochure'=>'required',
            'location' => 'required',
            'plot_count' => 'required',
            'description' => 'required',
            'description' => 'required',
            'team'=>'required',
            'production_id'=>'required',
            'lunchdate'=>'required'
        ],['production_id.required' => 'Production field is required',
            'plot_count.required'=>' The total no. of units field is required.'
            ]);

        $store_scheme = new SchemeModel;
        $store_property = new PropertyModel;


        if ($request->has('scheme_img')) {
            $image = $request->file('scheme_img');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('files'), $filename);
        }

        if ($request->has('brochure')) {
            $brochure = $request->file('brochure');
            $filename = $brochure->getClientOriginalName();
            $brochure->move(public_path('brochure'), $filename);
        }

        if ($request->has('ppt')) {
            $ppt = $request->file('ppt');
            $fileName_ppt = time() . rand(1, 99) . '.' . $ppt->extension();
            // $filename = $ppt->getClientOriginalName();
            $ppt->move(public_path('ppt'), $fileName_ppt);
        } else {
            $fileName_ppt = NULL;
        }


        // if ($request->has('video')) {
        //     $video = $request->file('video');
        //     $fileName_video = time() . rand(1, 99) . '.' . $video->extension();
        //     // $filename = $video->getClientOriginalName();
        //     $video->move(public_path('video'), $fileName_video);
        // } else {
        //     $fileName_video = NULL;
        // }

        if ($request->has('jda_map')) {
            $jda_map = $request->file('jda_map');
            $fileName_jda_map = time() . rand(1, 99) . '.' . $jda_map->extension();
            // $filename = $jda_map->getClientOriginalName();
            $jda_map->move(public_path('jda_map'), $fileName_jda_map);
        } else {
            $fileName_jda_map = NULL;
        }

        if ($request->has('other_docs')) {
            $other_docs = $request->file('other_docs');
            $fileName_other_docs = time() . rand(1, 99) . '.' . $other_docs->extension();
            // $filename = $other_docs->getClientOriginalName();
            $other_docs->move(public_path('other_docs'), $fileName_other_docs);
        } else {
            $fileName_other_docs = NULL;
        }

        if ($request->has('pra')) {
            $pra = $request->file('pra');
            $fileName_pra = time() . rand(1, 99) . '.' . $pra->extension();
            // $filename = $pra->getClientOriginalName();
            $pra->move(public_path('pra'), $fileName_pra);
        } else {
            $fileName_pra = NULL;
        }

        $files = [];
        if ($request->file('scheme_images')) {
            foreach ($request->file('scheme_images') as $key => $file) {
                $fileName = time() . rand(1, 99) . '.' . $file->extension();
                $file->move(public_path('scheme_images'), $fileName);
                $files[] = $fileName;
            }
        }

        $img_arr_string = implode(',', $files);
         //dd($img_arr_string);


        $store_scheme->public_id = Str::random(6);
        $store_scheme->production_id = $request->production_id;
        $store_scheme->scheme_name = $request->scheme_name;
        $store_scheme->location = $request->location;
        $store_scheme->no_of_plot = $request->plot_count;
        $store_scheme->scheme_img = $request->file('scheme_img')->getClientOriginalName();
        $store_scheme->brochure = $request->file('brochure')->getClientOriginalName();
        $store_scheme->ppt = $fileName_ppt;
        // $store_scheme->video =  $fileName_video;
        $store_scheme->video =  $request->video;
        $store_scheme->jda_map =  $fileName_jda_map;
        $store_scheme->other_docs =  $fileName_other_docs;
        $store_scheme->pra =  $fileName_pra;
        $store_scheme->scheme_images = $img_arr_string;
        $store_scheme->scheme_description = $request->description;
        $store_scheme->bank_name =  $request->bank_name;
        $store_scheme->account_number =  $request->account_number;
        $store_scheme->ifsc_code = $request->ifsc_code;
        $store_scheme->branch_name = $request->branch_name;
         $store_scheme->team = $request->team;
         $store_scheme->lunch_date = $request->lunchdate;
         $store_scheme->status = 2;

        $store_scheme->save();

        for ($i = 1; $i <= intval($request->plot_count); $i++) {

            $records = [
                "public_id" => Str::random(6),
                "plot_no" => $i,
                "production_id" =>  $request->production_id,
                "scheme_id" =>  $store_scheme->id,
                "booking_time"=>Carbon::now(),
                "booking_status"=>1
            ];

            PropertyModel::insert($records); // Eloquent approach
        }

        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Scheme created by '. Auth::user()->name .' with name '. $request->scheme_name .'.',
        ]);
        
            if (Auth::user()->user_type == 1){
                
                return redirect('/admin/schemes')->with('status', 'Scheme Added Successfully !!');
            }elseif (Auth::user()->user_type == 2){ 
               
                return redirect('/production/schemes')->with('status', 'Scheme Added Successfully !!');
            }elseif (Auth::user()->user_type == 3){ 
                
                return redirect('/opertor/schemes')->with('status', 'Scheme Added Successfully !!');
            }
        //return redirect('/schemes')->with('status', 'Scheme Added Successfully !!');
    }

    public function destroyScheme($id)
    {

        $update = DB::table('tbl_scheme')->where('public_id', $id)->limit(1)->update(['status' => 3]);
        if ($update) {
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Scheme created by '. Auth::user()->name .' with id '. $id .'.',
            ]);
            
            if (Auth::user()->user_type == 1){
                
                return redirect('/admin/schemes')->with('status', 'Scheme Deleted Successfully !!');
            }elseif (Auth::user()->user_type == 2){ 
               
                return redirect('/production/schemes')->with('status', 'Scheme Deleted Successfully !!');
            }elseif (Auth::user()->user_type == 3){ 
                
                return redirect('/opertor/schemes')->with('status', 'Scheme Deleted Successfully !!');
            }
           // return redirect('/schemes')->with('status', 'Scheme Deleted Successfully !!');
        }
    }

    public function viewScheme($id)
    {

        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type','tbl_property.plot_name', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->get();
        // dd($properties);    
        $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
        // dd(json_decode($property->attributes_data));
        //dd($scheme_detail);
        $current_time = now();
        return view('scheme.properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
    }

    public function listViewScheme($id)
    {

        if((Auth::user()->user_type == 3) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 5)){
            $properties = DB::table('tbl_property')
            ->select('tbl_property.freez','tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.plot_name','tbl_property.plot_type','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.other_info','tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->leftJoin('users','users.id','=','tbl_production.production_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')->where('users.parent_id',Auth::user()->parent_id)->get();

            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
            $current_time = now();
     
        }elseif(Auth::user()->user_type == 1){

        
            $properties = DB::table('tbl_property')
            ->select('tbl_property.freez','tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.plot_name','tbl_property.plot_type','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.other_info', 'tbl_property.other_info', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
            ->get();
            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();      
            $current_time = now();
        
        }elseif(Auth::user()->user_type == 4){
            
            $teamdta=DB::table('teams')->where('super_team',1)->get();
                $super_team=[];
                    $i=1;
                    foreach($teamdta as $list)
                    {
                        $original_array =  $list->public_id;
                        $super_team[]=$original_array;
                        $i++;
                    }
            if((Auth::user()->all_seen == 0)&&(!in_array(Auth::user()->team, $super_team))){
                $properties = DB::table('tbl_property')
                ->select('tbl_property.freez','tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.plot_name','tbl_property.plot_type','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.other_info', 'tbl_property.other_info', 'tbl_property.management_hold')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])
                ->where('tbl_scheme.team', Auth::user()->team)->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
                ->get();
            }else{

                $properties = DB::table('tbl_property')
                ->select('tbl_property.freez','tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.plot_name','tbl_property.plot_type','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.other_info', 'tbl_property.other_info', 'tbl_property.management_hold')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')->orderBy('tbl_property.id','ASC')
                ->get();
            }
            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
         
            $current_time = now();        
        }
        if(isset($properties[0])){
            return view('scheme.list_properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
        }else{
            session()->flush();
            return redirect()->route('login');
        }
        
    }


    public function showScheme($id)
    {

       $scheme_details = DB::table('tbl_scheme')
        ->select('tbl_scheme.*','teams.team_name')->leftJoin('teams','tbl_scheme.team','teams.public_id')->where('tbl_scheme.id', $id)->get();
        $images = $scheme_details[0]->scheme_images;
        $imgArray = explode(',', $images);

        return view('scheme.scheme', ['scheme_details' => $scheme_details, "images" => $imgArray]);
    }

    public function viewProperty($id)
    {

        $property = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_desc as description', 'tbl_property.attributes_data')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $id)->first();
        return view('scheme.update-property', ['property' => $property]);
    }

    public function propertyStatus(Request $request)
    {
        
        return view('scheme.status-property', ['property_data' => $request]);
    }

    public function updateProperty(Request $request)
    {

        $status = DB::table('tbl_property')
            ->where('public_id', $request->property_id)
            ->update(['plot_desc' => $request->description, 'user_id' => Auth::user()->public_id]);
        return redirect('/property/view-property/' . $request->property_id)->with('status', 'Property details update successfully');
    }

    public function statusOfPropery(Request $request)
    {
        //dd($request);
        $status = DB::table('tbl_property')
            ->where('public_id', $request->property_id)
            ->update(['description' => $request->description, 'owner_name' =>  $request->owner_name, 'contact_no' => $request->contact_no, 'address' => $request->address, 'user_id' => Auth::user()->public_id]);
        return redirect('/schemes')->with('status', 'Property details update successfully');
    }

    public function propertyBook(Request $request)

    {

        $propty_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.*')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status', 1)
            ->where('tbl_property.public_id', $request->property_id)->whereIn('tbl_property.booking_status',[2,3])->first();
            //dd($propty_detail);
        if(isset($propty_detail)){

            if($propty_detail->other_owner==''){
                $min=0;
            }else{
                $min=$propty_detail->other_owner;
            }
            $multi_customer = DB::table('customers')->where('plot_public_id',$request->property_id)->ORDERBY('id', 'DESC')->limit($min)->get();
            //dd($propty_report_detail);
            //dd($multi_customer);
            return view('scheme.edit-book-hold-property', ['property_data' => $request,'multi_customer'=>$multi_customer,'propty_detail'=>$propty_detail]);
        }
         $propty_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.hold_status')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status',1)
            ->where('tbl_property.public_id', $request->property_id)->first();
            session()->put('booking_page', true);
        if(!isset($propty_detail)){
        
            session()->flush();
            return redirect()->route('login');
        }
         return view('scheme.book-hold-property', ['property_data' => $request,'pdata'=>$propty_detail]);
    }


    // function for multiple book plots

    public function multiplepropertyBook(Request $request)

    {
       $property_id = "NgBbpw";
        $id= $request->id;

        if((Auth::user()->user_type == 3) || (Auth::user()->user_type == 2)){
            $properties = DB::table('tbl_property')
            ->select('users.parent_id as gvg','tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no','tbl_property.plot_name','tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.cancel_time','tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->leftJoin('users','users.id','=','tbl_production.production_id')->where('tbl_scheme.status',1)
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,0])->whereIn('tbl_property.booking_status',[1,0])->orderBy('tbl_property.booking_status','ASC')->where('users.parent_id',Auth::user()->parent_id)->get();

            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
            
            $current_time = now();
        }elseif(Auth::user()->user_type == 1){

        
            $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_property.plot_name','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status',1)
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,0])->whereIn('tbl_property.booking_status',[1,0])->orderBy('tbl_property.booking_status','ASC')
            ->get();

            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
         
            $current_time = now();
            //return view('scheme.properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
            // dd($properties);
       
        }elseif(Auth::user()->user_type == 4){
            //dd($id);
            $teamdta=DB::table('teams')->where('super_team',1)->get();
                $super_team=[];
                    $i=1;
                    foreach($teamdta as $list)
                    {
                        $original_array =  $list->public_id;
                        $super_team[]=$original_array;
                        $i++;
                    }
            if((Auth::user()->all_seen == 0)&&(!in_array(Auth::user()->team, $super_team))){
                $properties = DB::table('tbl_property')
                ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no','tbl_property.plot_name', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status',1)
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,0])->whereIn('tbl_property.booking_status',[1,0])
                ->where('tbl_scheme.team', Auth::user()->team)->orderBy('tbl_property.booking_status','ASC')
                ->get();
            }else{

                $properties = DB::table('tbl_property')
                ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_property.plot_type', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_property.plot_name','tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time','tbl_property.management_hold')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status',1)
                ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,0])->whereIn('tbl_property.booking_status',[1,0])->orderBy('tbl_property.booking_status','ASC')
                ->get();
            }
            $scheme_detail = DB::table('tbl_scheme')->where('tbl_scheme.id', $id)->first();
         
            $current_time = now();
        
            //return view('scheme.properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
        
            //dd($properties);
        }
        //dd($properties);
        if(!isset($properties[0])){
           
            session()->flush();
            return redirect()->route('login');
        }

        //dd($propty_detail);
        session()->put('booking_page', true);
         return view('scheme.multiple-book-hold-property', ['property_data' => $request,'properties' => $properties, 'scheme_detail' => $scheme_detail,]);
    }


    public function propertyBookHold(Request $request)
    {

        return view('scheme.book-hold-property', ['property_data' => $request]);
    }

    public function propertyHold(Request $request)
    {

        return view('scheme.hold-property', ['property_data' => $request]);
    }
     
    public function AddharValidation($property_id,$adhar_card_number)
    {
        $pmodel = PropertyModel::where('public_id', $property_id)->first();
        $plot_type = $pmodel->plot_type;
        $smodel = SchemeModel::where('id',$pmodel->scheme_id)->first();
        $start=Carbon::parse($smodel->lunch_date)->format('Y-m-d H:i:s');
        $end=Carbon::parse($smodel->lunch_date)->addMonth()->format('Y-m-d H:i:s');
        $pbpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',2)->count();
        $phpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',3)->count();
        $pcpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',5)->count();

        $sbpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',2)->count();
        $shpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',3)->count();
        $scpmodel = PropertyModel::where('scheme_id',$pmodel->scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',5)->count();
        
        if((($pbpmodel + $pcpmodel) >= 2) && ($sbpmodel + $scpmodel) >= 4){
            $move = 'yes';
            return $move;
        }elseif((($pbpmodel + $pcpmodel) >= 2) && ($plot_type[0] != 'S')){
            $move = 'yes';
            return $move;
        }elseif((($sbpmodel + $scpmodel) >= 4) && ($plot_type[0] == 'S')){
            $move = 'yes';
            return $move;
        }else{
            $move = 'no';
            return $move;
        }


        // if((($pbpmodel + $pcpmodel) >= 2) || ($sbpmodel + $scpmodel) >= 4){

        //     if((($pbpmodel + $pcpmodel) >= 2) && ($plot_type[0] != 'S')){
        //         $move = 'yes';
        //     }else{
        //         $move = 'no';
        //     }
        //     if((($sbpmodel + $scpmodel) >= 4) && ($plot_type[0] == 'S')){
        //         $move = 'yes';
        //     }else{
        //         $move = 'no';
        //     }

        //     // $move = 'yes';
        //     return $move;
                           
        // }
        $move = 'no';
        //   dd($pbpmodel,$phpmodel,$pcpmodel,$pbpmodel,$phpmodel,$pcpmodel);
        return $move;
    }

    public function bookProperty(Request $request)
    {
           //dd($request);
         //dd($request->post());
        $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
        $smodel = SchemeModel::where('id',$booking_status->scheme_id)->first();
        if(!session()->get('booking_page')){
            
            return redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Try to Attempt rebooking.');
        }
        if(($smodel->lunch_date > now()->subMonth()->format('Y-m-d H:i:s')) && ($request->ploat_status == 2))
        {
          $move =   $this->AddharValidation($request->property_id, $request->adhar_card_number);
          if($move == 'yes')
          {
            session()->forget('booking_page');
            return redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Customer already booked/Complete 2 plot or 4 shop under last 1 month.'); 
          }
        }
        

        if(($booking_status->booking_status == 1)){
            $pcustomer = Customer::where('plot_public_id',$booking_status->public_id)->where('adhar_card_number',$request->adhar_card_number)
                    ->where('associate',$request->associate_rera_number)->whereDate('created_at', '>', Carbon::today()->subDays(1)->toDateString())->first();
            if($pcustomer)
            {
                session()->forget('booking_page');
                return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Customer already booked/Hold this plot under last 24 hours.');
            }
            
            if(($booking_status->adhar_card_number == $request->adhar_card_number) && ($booking_status->cancel_time > now()->subDays(1)->format('Y-m-d H:i:s'))){
    
                session()->forget('booking_page');
                return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Customer already booked/Hold this plot under last 24 hours.');
               }
        }

        if($booking_status->booking_status != 2 && $booking_status->booking_status != 3) 
            {
            
                $validatedData = $request->validate([
                    'owner_name' => 'required',
                    'ploat_status'=>'required',
                    'adhar_card_number' =>'required|min:12'
                    
                    
                ],['ploat_status.required'=>'Plot status field is required',
                'adhar_card_number.required' =>'Please enter Adhar Card Number']);
                    
                if ($request->has('adhar_card')) {
                    $adhar_card = $request->file('adhar_card');
                    //$filename = $adhar_card->getClientOriginalName();
                    $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                    $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                }else{
                    $fileName_adhar='';
                }

                if ($request->has('cheque_photo')) 
                {
                    $cheque_photo = $request->file('cheque_photo');
                    //$filename = $adhar_card->getClientOriginalName();
                    $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                    $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                }else{
                    $fileName_cheque='';
                }

                if ($request->has('attachement')) {
                    $attachement = $request->file('attachement');
                    //$filename = $adhar_card->getClientOriginalName();
                    $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                    $attachement->move(public_path('customer/attach'), $fileName_att);
                }else{
                    $fileName_att='';
                }

                if ($request->has('pan_card_image')) {
                    $pan_card_image = $request->file('pan_card_image');
                    //$filename = $adhar_card->getClientOriginalName();
                    $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                    $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                }else{
                    $fileName_pan='';
                }
            
                if(isset($request->piid)){
                    $other_owner =   count($request->piid);
                }else{
                    $other_owner=NULL;
                }

                $status = DB::table('tbl_property')->where('public_id', $request->property_id)
                    ->update(
                        [
                            'associate_name' => $request->associate_name,
                            'associate_number' => $request->associate_number,
                            'associate_rera_number' => $request->associate_rera_number,
                            'booking_status' => $request->ploat_status,
                            'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
                            'booking_time' =>  Carbon::now(),
                            'description' => $request->description,
                            'owner_name' =>  $request->owner_name,
                            'contact_no' => $request->contact_no,
                            'address' => $request->address,
                            'adhar_card_number' => $request->adhar_card_number,
                            'user_id' => Auth::user()->public_id,
                            'pan_card'=>$request->pan_card_no,
                            'pan_card_image'=>$fileName_pan,
                            'adhar_card'=>$fileName_adhar,
                            'cheque_photo'=>$fileName_cheque,
                            'attachment'=> $fileName_att,
                            'other_owner'=>$other_owner
                        ]
                    );
                
                $model=new Customer();
                $model->public_id = Str::random(6);
                $model->plot_public_id = $request->property_id;
                $model->booking_status = $request->ploat_status;
                $model->associate = $request->associate_rera_number;
                $model->payment_mode =  0;
                $model->description = $request->description;
                $model->owner_name =  $request->owner_name;
                $model->contact_no = $request->contact_no;
                $model->address = $request->address;
                $model->pan_card= $request->pan_card_no;
                $model->adhar_card_number = $request->adhar_card_number;
                $model->pan_card_image = $fileName_pan;
                $model->adhar_card= $fileName_adhar;
                $model->cheque_photo= $fileName_cheque;
                $model->attachment= $fileName_att;
                $model->save();
                
                if(isset($request->piid)){

                    if(!empty($request->owner_namelist[0])){
                      
                        $owner_namelist=$request->owner_namelist;
                        $contact_nolist=$request->contact_nolist;
                        $addresslist=$request->addresslist;
                        // $payment_modelist=$request->payment_modelist;
                        $pan_cardlist=$request->pan_card_nolist;
                         $addhar_numberlist = $request->adhar_card_number_list;
                        $taxidArr=$request->post('piid'); 
                        foreach($taxidArr as $key=>$val){                                       
                          
                           

                            if ($request->hasFile("adhar_cardlist.$key")) {
                                $adhar_card = $request->file("adhar_cardlist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                            }else{
                                $fileName_adhar='';
                            }

                            if ($request->hasFile("cheque_photolist.$key")) {
                                $cheque_photo = $request->file("cheque_photolist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                            }else{
                                $fileName_cheque='';
                            }
    
                            if ($request->hasFile("attachementlist.$key")) {
                                $attachement = $request->file("attachementlist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                                $attachement->move(public_path('customer/attach'), $fileName_att);
                            }else{
                                $fileName_att='';
                            }
        
                            if ($request->hasFile("pan_card_imagelist.$key")) {
                                $pan_card_image = $request->file("pan_card_imagelist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                            }else{
                                $fileName_pan='';
                            }
    
                            
                            $model=new Customer();
                            $model->public_id = Str::random(6);
                            $model->plot_public_id = $request->property_id;
                            $model->booking_status = $request->ploat_status;
                            $model->associate = $request->associate_rera_number;
                            $model->payment_mode =  0;
                            $model->description = $request->description;
                            $model->owner_name =  $owner_namelist[$key];
                            $model->contact_no = $contact_nolist[$key];
                            $model->address = $addresslist[$key];
                            $model->pan_card= $pan_cardlist[$key];
                            $model->pan_card_image = $fileName_pan;
                            $model->adhar_card= $fileName_adhar;
                            $model->adhar_card_number= $addhar_numberlist[$key];
                            $model->cheque_photo= $fileName_cheque;
                            $model->attachment= $fileName_att;
                            $model->save();
                        }
                    }
                }
                $scheme_details = DB::table('tbl_scheme')->where('id', $booking_status->scheme_id)->first();
                $email = Auth::user()->email;
                $mailData = [
                        'title' => $booking_status->plot_type.' Book Details',
                        'name'=>Auth::user()->name,
                        'plot_no'=>$booking_status->plot_no,
                        'plot_name'=>$booking_status->plot_name,
                        'plot_type' =>$booking_status->plot_type,
                        'scheme_name'=>$scheme_details->scheme_name,
                    ];
                $hji= 'bookedplotdetails';   $subject = $booking_status->plot_type.' Book Details';
                
                $notifi = new NotificationController;
                  
                if($request->ploat_status==2)
                {
                    ProteryHistory ::create([
                        'scheme_id' => $scheme_details->id,
                        'property_id'=>$booking_status->id,
                        'action_by'=>Auth::user()->id,
                        'action' =>  'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].'  has been booked.',
                    ]);
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                    $notifi->BookingsendNotification($mailData, Auth::user()->device_token, Auth::user()->mobile_number);
                    $notifi->mobileBooksms($mailData,Auth::user()->mobile_number);
                    
                }else{
                    ProteryHistory ::create([
                        'scheme_id' => $scheme_details->id,
                        'property_id'=>$booking_status->id,
                        'action_by'=>Auth::user()->id,
                        'action' =>  'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].'  has been hold.',
                    ]);
                    $notifi->mobilesmshold($mailData, Auth::user()->mobile_number);
                }
                
                $notifi->BookingPushNotification($mailData, $booking_status->scheme_id, $booking_status->production_id);
                session()->forget('booking_page');
               
               if (Auth::user()->user_type == 1){
                    return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
                   
                }elseif (Auth::user()->user_type == 2){ 
                    return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
                   
                }elseif (Auth::user()->user_type == 3){ 
                    return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
                   
                }elseif (Auth::user()->user_type == 4) {
                    return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
                   
                }
                //  return redirect('/schemes')->with('status', 'Property details update successfully');
             
        }elseif(($booking_status->booking_status == 3) && ($booking_status->associate_rera_number == $request->associate_rera_number) && ($request->ploat_status == 2)) {
        
            $validatedData = $request->validate([
                'owner_name' => 'required',
                'adhar_card_number' => 'required|min:12',
                'ploat_status'=>'required',
            ]);
            
            if ($request->has('adhar_card')) {
                $adhar_card = $request->file('adhar_card');
                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
            }else{
                $fileName_adhar=$booking_status->adhar_card;
            }
    
            if ($request->has('cheque_photo')) {
                $cheque_photo = $request->file('cheque_photo');
                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
            }else{
                $fileName_cheque=$booking_status->cheque_photo;
            }
    
            if ($request->has('attachement')) {
                $attachement = $request->file('attachement');
                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                $attachement->move(public_path('customer/attach'), $fileName_att);
            }else{
                $fileName_att=$booking_status->attachment;
            }
    
            if ($request->has('pan_card_image')) {
                $pan_card_image = $request->file('pan_card_image');
                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
            }else{
                $fileName_pan=$booking_status->pan_card_image;
            }
            
            if(isset($request->piid)){
            $other_owner =   count($request->piid);
            }else{
                $other_owner=NULL;
            }

            $status = DB::table('tbl_property')->where('public_id', $request->property_id)
                ->update(
                    [
                        'associate_name' => $request->associate_name,
                        'associate_number' => $request->associate_number,
                        'associate_rera_number' => $request->associate_rera_number,
                        'booking_status' => $request->ploat_status,
                        'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
                        'booking_time' =>  Carbon::now(),
                        'description' => $request->description,
                        'owner_name' =>  $request->owner_name,
                        'contact_no' => $request->contact_no,
                        'address' => $request->address,
                        'adhar_card_number' => $request->adhar_card_number,
                        'user_id' => Auth::user()->public_id,
                        'pan_card'=>$request->pan_card_no,
                        'pan_card_image'=>$fileName_pan,
                        'adhar_card'=>$fileName_adhar,
                        'cheque_photo'=>$fileName_cheque,
                        'attachment'=> $fileName_att,
                        'other_owner'=>$other_owner
                    ]
                );
               
            
            
            
            if(isset($request->piid)){

                if(!empty($request->owner_namelist[0])){
                  
                    $owner_namelist=$request->owner_namelist;
                    $contact_nolist=$request->contact_nolist;
                    $addresslist=$request->addresslist;
                    // $payment_modelist=$request->payment_modelist;
                     $addhar_numberlist = $request->adhar_card_number_list;
                    $pan_cardlist=$request->pan_card_nolist;
                    $taxidArr=$request->post('piid'); 
                    
                    foreach($taxidArr as $key=>$val){                                       
                        
                        if($taxidArr[$key]!=''){
                            
                            $custarr = Customer::where(['id'=>$taxidArr[$key]])->first();

                                if ($request->hasFile("adhar_cardlist.$key")) {
                                    $adhar_card = $request->file("adhar_cardlist.$key");
                                    //$filename = $adhar_card->getClientOriginalName();
                                    $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                                    $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                                }else{
                                    $fileName_adhar=$custarr->adhar_card;
                                }
        
                                if ($request->hasFile("cheque_photolist.$key")) {
                                    $cheque_photo = $request->file("cheque_photolist.$key");
                                    //$filename = $adhar_card->getClientOriginalName();
                                    $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                                    $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                                }else{
                                    $fileName_cheque=$custarr->cheque_photo;
                                }
        
                                if ($request->hasFile("attachementlist.$key")) {
                                    $attachement = $request->file("attachementlist.$key");
                                    //$filename = $adhar_card->getClientOriginalName();
                                    $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                                    $attachement->move(public_path('customer/attach'), $fileName_att);
                                }else{
                                    $fileName_att=$custarr->attachment;
                                }
            
                                if ($request->hasFile("pan_card_imagelist.$key")) {
                                    $pan_card_image = $request->file("pan_card_imagelist.$key");
                                    //$filename = $adhar_card->getClientOriginalName();
                                    $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                                    $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                                }else{
                                    $fileName_pan=$custarr->pan_card_image;
                                }

                                Customer::where(['id'=>$taxidArr[$key]])->update([
                                    'plot_public_id' => $request->property_id,
                                    'booking_status' => $request->ploat_status,
                                    'description' => $request->description,
                                    'owner_name' => $owner_namelist[$key],
                                    'contact_no' => $contact_nolist[$key],
                                    'address' => $addresslist[$key],
                                    'pan_card' => $pan_cardlist[$key],
                                    'pan_card_image' => $fileName_pan,
                                    'adhar_card' => $fileName_adhar,
                                    'cheque_photo' => $fileName_cheque,
                                    'adhar_card_number' => $addhar_numberlist[$key],
                                    'attachment' => $fileName_att
                                    ]);
                        }else{
                                
                            if ($request->hasFile("adhar_cardlist.$key")) {
                                $adhar_card = $request->file("adhar_cardlist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                            }else{
                                $fileName_adhar='';
                            }
        
                            if ($request->hasFile("cheque_photolist.$key")) {
                                $cheque_photo = $request->file("cheque_photolist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                            }else{
                                $fileName_cheque='';
                            }
        
                            if ($request->hasFile("attachementlist.$key")) {
                                $attachement = $request->file("attachementlist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                                $attachement->move(public_path('customer/attach'), $fileName_att);
                            }else{
                                $fileName_att='';
                            }
        
                            if ($request->hasFile("pan_card_imagelist.$key")) {
                                $pan_card_image = $request->file("pan_card_imagelist.$key");
                                //$filename = $adhar_card->getClientOriginalName();
                                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                            }else{
                                $fileName_pan='';
                            }

                             $model=new Customer();
                             $model->public_id = Str::random(6);
                             $model->plot_public_id = $request->property_id;
                             $model->booking_status = $request->ploat_status;
                            $model->associate = $request->associate_rera_number;
                             $model->payment_mode =  0;
                             $model->description = $request->description;
                             $model->owner_name =  $owner_namelist[$key];
                             $model->contact_no = $contact_nolist[$key];
                             $model->address = $addresslist[$key];
                             $model->pan_card= $pan_cardlist[$key];
                             $model->pan_card_image = $fileName_pan;
                             $model->adhar_card= $fileName_adhar;
                             $model->adhar_card_number= $addhar_numberlist[$key];
                             $model->cheque_photo= $fileName_cheque;
                             $model->attachment= $fileName_att;
                             $model->save();
                        }
         
                    }
                }
            }
            $scheme_details = DB::table('tbl_scheme')->where('id', $booking_status->scheme_id)->first();
            //dd($scheme_details);
            if($request->ploat_status==2)
            {
               $email = Auth::user()->email;
               $mailData = [
                    'title' => $booking_status->plot_type.' Book Details',
                    'name'=>Auth::user()->name,
                    'plot_no'=>$booking_status->plot_no,
                    'plot_name'=>$booking_status->plot_name,
                    'plot_type' =>$booking_status->plot_type,
                    'scheme_name'=>$scheme_details->scheme_name,
                ];
                $hji= 'bookedplotdetails';   $subject =  $booking_status->plot_type.' Book Details';
                Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
            }
            ProteryHistory ::create([
                'scheme_id' => $scheme_details->id,
                'property_id'=>$booking_status->id,
                'action_by'=>Auth::user()->id,
                'action' =>  'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' plot hold to book.',
            ]);
            
            $notifi = new NotificationController;
            $notifi->BookingsendNotification($mailData, Auth::user()->device_token, Auth::user()->mobile_number);
            $notifi->BookingPushNotification($mailData,$booking_status->scheme_id,$booking_status->production_id);
            $notifi->mobileBooksms($mailData,Auth::user()->mobile_number);
            session()->forget('booking_page');
            if (Auth::user()->user_type == 1){
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
               
            }elseif (Auth::user()->user_type == 2){ 
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
               
            }elseif (Auth::user()->user_type == 3){ 
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
                
            }elseif (Auth::user()->user_type == 4) {
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully');
             
            }
       
        }elseif(($booking_status->booking_status == 2 || $booking_status->booking_status == 3) && $request->ploat_status == 2 && $booking_status->waiting_list < 3){
            
             $validatedData = $request->validate([
                        'owner_name' => 'required',
                        'ploat_status'=>'required',
                        'adhar_card_number' =>'required|min:12'
                        
                        
                    ],['ploat_status.required'=>'Plot status field is required',
                    'adhar_card_number.required' =>'Please enter Adhar Card Number']);
            if ($request->has('adhar_card')) {
                $adhar_card = $request->file('adhar_card');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
            }else{
                $fileName_adhar='';
            }

            if ($request->has('cheque_photo')) {
                $cheque_photo = $request->file('cheque_photo');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
            }else{
                $fileName_cheque='';
            }

            if ($request->has('attachement')) {
                $attachement = $request->file('attachement');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                $attachement->move(public_path('customer/attach'), $fileName_att);
            }else{
                $fileName_att='';
            }
        
            if ($request->has('pan_card_image')) {
                $pan_card_image = $request->file('pan_card_image');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
            }else{
                $fileName_pan='';
            }
    
            if(isset($request->piid)){
            $other_owner =   count($request->piid);
            }else{
                $other_owner=NULL;
            }
            
            $model1=new WaitingListMember();
            $model1->scheme_id = $booking_status->scheme_id;
            $model1->plot_no =$booking_status->plot_no;
            $model1->user_id = Auth::user()->public_id;
            $model1->associate_name = $request->associate_name;
            $model1->associate_number= $request->associate_number;
            $model1->associate_rera_number= $request->associate_rera_number;
            $model1->payment_mode = $request->payment_mode ? $request->payment_mode : 0;
            $model1->adhar_card = $fileName_adhar;
            $model1->adhar_card_number =$request->adhar_card_number;
            $model1->pan_card = $request->pan_card_no;
            $model1->pan_card_image = $fileName_pan;
            $model1->cheque_photo = $fileName_cheque;
            $model1->attachment = $fileName_att;
            $model1->owner_name =  $request->owner_name;
            $model1->booking_status= $request->ploat_status;
            $model1->contact_no = $request->contact_no; 
            $model1->address = $request->address;
            $model1->booking_time =  Carbon::now();
            $model1->description = $request->description;
            $model1->other_owner = $other_owner;
            $model1->save();

            if(isset($request->piid)){

                if(!empty($request->owner_namelist[0])){
                  
                    $owner_namelist=$request->owner_namelist;
                    $contact_nolist=$request->contact_nolist;
                    $addresslist=$request->addresslist;
                    // $payment_modelist=$request->payment_modelist;
                    $pan_cardlist=$request->pan_card_nolist;
                     $addhar_numberlist = $request->adhar_card_number_list;
                    $taxidArr=$request->post('piid'); 
                    foreach($taxidArr as $key=>$val){                                       
                        if ($request->hasFile("adhar_cardlist.$key")) {
                            $adhar_card = $request->file("adhar_cardlist.$key");
                            //$filename = $adhar_card->getClientOriginalName();
                            $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                            $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                        }else{
                            $fileName_adhar='';
                        }
    
                        if ($request->hasFile("cheque_photolist.$key")) {
                            $cheque_photo = $request->file("cheque_photolist.$key");
                            //$filename = $adhar_card->getClientOriginalName();
                            $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                            $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                        }else{
                            $fileName_cheque='';
                        }
    
                        if ($request->hasFile("attachementlist.$key")) {
                            $attachement = $request->file("attachementlist.$key");
                            //$filename = $adhar_card->getClientOriginalName();
                            $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                            $attachement->move(public_path('customer/attach'), $fileName_att);
                        }else{
                            $fileName_att='';
                        }
    
                        if ($request->hasFile("pan_card_imagelist.$key")) {
                            $pan_card_image = $request->file("pan_card_imagelist.$key");
                            //$filename = $adhar_card->getClientOriginalName();
                            $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                            $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                        }else{
                            $fileName_pan='';
                        }
    
                                $model=new WaitingListCustomer();
                                $model->scheme_id = $booking_status->scheme_id;
                                $model->plot_no = $booking_status->plot_no;
                                $model->user_id = Auth::user()->public_id;
                                $model->waiting_member_id = $model1->id;
                                $model->payment_mode =  0;
                                $model->adhar_card= $fileName_adhar;
                                $model->adhar_card_number= $addhar_numberlist[$key];
                                $model->pan_card= $pan_cardlist[$key];
                                $model->pan_card_image = $fileName_pan;
                                $model->cheque_photo= $fileName_cheque;
                                $model->attachment= $fileName_att;
                                $model->owner_name =  $owner_namelist[$key];
                                $model->booking_status = $request->ploat_status;
                                $model->contact_no = $contact_nolist[$key];
                                $model->address = $addresslist[$key];
                                $model->save();
         
                    }
                }
            }
            $status = DB::table('tbl_property')->where('public_id', $request->property_id)->increment('waiting_list');
            $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
             $scheme_details = DB::table('tbl_scheme')->where('id', $booking_status->scheme_id)->first();
              $mailData = [
                        'title' => $booking_status->plot_type.' Book Details',
                        'name'=>Auth::user()->name,
                        'plot_no'=>$booking_status->plot_no,
                        'plot_name'=>$booking_status->plot_name,
                        'plot_type' =>$booking_status->plot_type,
                        'scheme_name'=>$scheme_details->scheme_name,
                    ];
            $notifi = new NotificationController;
            $notifi->WaitingsendNotification($mailData, Auth::user()->device_token);
            ProteryHistory ::create([
                'scheme_id' => $scheme_details->id,
                'property_id'=>$booking_status->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' is in waiting list',
            ]);
            session()->forget('booking_page');
            if (Auth::user()->user_type == 1){
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Plot already booked/Hold. You are on waiting list.');
              //  return redirect('/admin/schemes')->with('status', 'Plot already booked/Hold. You are on waiting list.');
            }elseif (Auth::user()->user_type == 2){ 
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Plot already booked/Hold. You are on waiting list.');
               // return redirect('/production/schemes')->with('status', 'Plot already booked/Hold. You are on waiting list.');
            }elseif (Auth::user()->user_type == 3){ 
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Plot already booked/Hold. You are on waiting list.');
               // return redirect('/opertor/schemes')->with('status', 'Plot already booked/Hold. You are on waiting list.');
            }elseif (Auth::user()->user_type == 4) {
                 return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Plot already booked/Hold. You are on waiting list.');
               // return redirect('/associate/schemes')->with('status', 'Plot already booked/Hold. You are on waiting list.');
            }
        }else{
            session()->forget('booking_page');
            if (Auth::user()->user_type == 1){
                 return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Plot already booked/Hold.');
               // return redirect('/admin/schemes')->with('status', 'Plot already booked/Hold');
            }elseif (Auth::user()->user_type == 2){ 
                return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Plot already booked/Hold.');
               // return redirect('/production/schemes')->with('status', 'Plot already booked/Hold');
            }elseif (Auth::user()->user_type == 3){ 
                 return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Plot already booked/Hold.');
              //  return redirect('/opertor/schemes')->with('status', 'Plot already booked/Hold');
            }elseif (Auth::user()->user_type == 4) {
                 return   redirect()->route('view.scheme', ['id' => $booking_status->scheme_id])->with('status', 'Plot already booked/Hold.');
              //  return redirect('/associate/schemes')->with('status', 'Plot already booked/Hold');
            }
            
        }
    }

    public function holdProperty(Request $request)
    {

        // dd($request);
        $validatedData = $request->validate([
            'owner_name' => 'required',
            'contact_no' => 'required'
        ]);

        $status = DB::table('tbl_property')
            ->where('public_id', $request->property_id)
            ->update(
                [
                    'associate_name' => $request->associate_name,
                    'associate_number' => $request->associate_number,
                    'booking_status' => 2,
                    'description' => $request->description,
                    'owner_name' =>  $request->owner_name,
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                    'user_id' => Auth::user()->public_id,
                    'booking_time' =>  Carbon::now(),
                ]
            );
        return redirect('/schemes')->with('status', 'Property details update successfully');
    }

    public function propertyReports(Request $request)
    {

        //dd($request->scheme_id);

        if (isset($request->scheme_id)) {
            
            $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            $book_properties = DB::table('tbl_property')
                ->select('users.applier_name','users.applier_rera_number','teams.team_name','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.status as property_status','tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.id as property_id', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.booking_status', 'tbl_property.booking_time','tbl_property.freez')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
                ->leftjoin('teams','teams.public_id','=','users.team')
                ->where('tbl_property.scheme_id', $request->scheme_id)->get();
            //dd($book_properties);
            return view('scheme.reports', ['book_properties' => $book_properties, 'schemes' => $schemes]);
        } else {
            $schemes = DB::table('tbl_scheme')->select('tbl_scheme.*')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->leftJoin('users','users.id','=','tbl_production.production_id')->where('tbl_scheme.status', 1)->where('users.parent_id', Auth::user()->parent_id)->get();
            // dd($schemes);
            return view('scheme.reports', ['schemes' => $schemes]);
        }
    }


    public function propertyDetailReports($id)
    {

        //dd($id);
       $propty_report_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.*')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $id)->first();
        if($propty_report_detail->other_owner==''){
            $min=0;
        }else{
            $min=$propty_report_detail->other_owner;
        }
        $paymentproof = PaymentProof::where('property_id', $propty_report_detail->id)->first();
        $user = User::where('associate_rera_number',$propty_report_detail->associate_rera_number)->first();

        $multi_customer = DB::table('customers')->where('plot_public_id',$id)->ORDERBY('id', 'DESC')->limit($min)->get();
            //dd($multi_customer);
        // $plothistories = ProteryHistory::where('property_id' , $propty_report_detail->id)->where('action_by',$user->id)->whereDate('created_at', '>', now()->subDays(7))->get();
        $plothistories = ProteryHistory::where('property_id' , $propty_report_detail->id)->whereDate('created_at', '>', now()->subDays(7))->get();

         //dd($propty_report_detail);
        return view('scheme.report-detail', ['propty_report_detail' => $propty_report_detail,'other_owner'=>$multi_customer,'plothistories'=>$plothistories,'paymentproof'=>$paymentproof]);

    }


    public function associatePropertyReports(Request $request)
    {

        if (Auth::user()->user_type == 1) {
            $propty_report_details = PropertyModel::select('users.applier_name','users.applier_rera_number','teams.team_name','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time','tbl_property.freez')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
                ->leftjoin('teams','teams.public_id','=','users.team')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->get();
        } else {
            $propty_report_details = PropertyModel::select('users.applier_name','users.applier_rera_number','teams.team_name','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time','tbl_property.freez')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
                ->leftjoin('teams','teams.public_id','=','users.team')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->where('tbl_property.user_id', Auth::user()->public_id)->get();
        }


        //  dd( $propty_report_details);
        // $scheme_detail = DB::table('tbl_property')
        // ->where('status', 1)->where('user_id', Auth::user()->public_id)
        // ->get();
        return view('scheme.associate-reports', ['propty_report_details' => $propty_report_details]);
        // return view('scheme.associate-reports', ['propty_report_details' => $propty_report_details, 'users' => $users]);
    }

    public function editScheme($id)
    {

        $productions = DB::table('tbl_production')->where('status',1)->get();

        $scheme_detail = DB::table('tbl_scheme')->where('public_id', $id)
            ->get();
         //dd($scheme_detail);
        //  echo"<pre>";
        //  print_r($scheme_detail);
        //  die();
       $teamdta=DB::table('teams')->where('status',1)->get();
        return view('scheme.edit-scheme', ['scheme_detail' => $scheme_detail, 'productions' => $productions,'teams'=>$teamdta]);
    }

    // Store Contact Form data
    public function updateScheme(Request $request)
    {   
       //  dd($request);
        $validatedData = $request->validate([
            'scheme_name' => 'required',
            'location' => 'required',
            'description' => 'required',
             'lunchdate'=>'required'
        ]);    

        $scheme_details = DB::table('tbl_scheme')->where('public_id', $request->scheme_id)->get();
        $imagesmulti = $scheme_details[0]->scheme_images;
       // $imgArray = explode(',', $images);
            if ($request->hasfile('scheme_img')) {
                $image = $request->file('scheme_img');
                $filename_img = $image->getClientOriginalName();
                $image->move(public_path('files'), $filename_img);
            }else{
                $filename_img=$scheme_details[0]->scheme_img;
            }
    
            if ($request->hasfile('brochure')) {
                $brochure = $request->file('brochure');
                $filename_bro = $brochure->getClientOriginalName();
                $brochure->move(public_path('brochure'), $filename_bro);
            }else{
                $filename_bro=$scheme_details[0]->brochure;
            }
    
            if ($request->has('ppt')) {
                $ppt = $request->file('ppt');
                $fileName_ppt = time() . rand(1, 99) . '.' . $ppt->extension();
                $ppt->move(public_path('ppt'), $fileName_ppt);
            } else {
                $fileName_ppt = $scheme_details[0]->ppt;
            }    
            if ($request->has('jda_map')) {
                $jda_map = $request->file('jda_map');
                $fileName_jda_map = time() . rand(1, 99) . '.' . $jda_map->extension();
                $jda_map->move(public_path('jda_map'), $fileName_jda_map);
            } else {
                $fileName_jda_map = $scheme_details[0]->jda_map;
            }
    
            if ($request->has('other_docs')) {
                $other_docs = $request->file('other_docs');
                $fileName_other_docs = time() . rand(1, 99) . '.' . $other_docs->extension();
                $other_docs->move(public_path('other_docs'), $fileName_other_docs);
            } else {
                $fileName_other_docs = $scheme_details[0]->other_docs;
            }
    
            if ($request->has('pra')) {
                $pra = $request->file('pra');
                $fileName_pra = time() . rand(1, 99) . '.' . $pra->extension();
                $pra->move(public_path('pra'), $fileName_pra);
            } else {
                $fileName_pra = $scheme_details[0]->pra;
            }
    
            $files = [];
            if ($request->file('scheme_images')) {
                foreach ($request->file('scheme_images') as $key => $file) {
                    $fileName = time() . rand(1, 99) . '.' . $file->extension();
                    $file->move(public_path('scheme_images'), $fileName);
                    $files[] = $fileName;
                }
                $img_arr_string = implode(',', $files);
            }else{
                $img_arr_string = $imagesmulti;
            }           
    
            $status = DB::table('tbl_scheme')->where('public_id', $request->scheme_id)
            ->update([
                'production_id' => $request->production_id,
                'scheme_name' => $request->scheme_name,
                'scheme_description' => $request->description,
                'location' => $request->location,
                'bank_name' =>  $request->bank_name,
                'account_number' =>  $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'branch_name' => $request->branch_name,
                'scheme_img'=>$filename_img,
                'brochure' => $filename_bro,
                'ppt' => $fileName_ppt,
                // 'video' =>  $fileName_video,
                'video' =>  $request->video,
                'jda_map' =>  $fileName_jda_map,
                'other_docs' =>  $fileName_other_docs,
                'pra' =>  $fileName_pra,
                'scheme_images' => $img_arr_string,
                'team'=>$request->team,
                'lunch_date'=>$request->lunchdate
            ]);

            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Scheme updated by '. Auth::user()->name .' with name '. $scheme_details->scheme_name .'with id '.$request->scheme_id.'. ',
            ]);
            
            if (Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Scheme Updated Successfully !!');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Scheme Updated Successfully !!');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Scheme Updated Successfully !!');
            }
        //return redirect('/schemes')->with('status', 'Scheme Updated Successfully !!');
    }
    
     public function propertyStatuscancel($propertyId)
    {
        // dd($propertyId);
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status', 1)
            ->where('tbl_property.public_id', $propertyId)->first();
        //dd($property_details);
        session()->put('booking_cancel', true);
        return view('property.property-cancel-reson', ['property_details' => $property_details]);
        // dd($propertyId);
    }

    public function propertyCancel(Request $request)
    {
        $validatedData = $request->validate([
            'other_info' => 'required'
        ]);
        if(!session()->get('booking_cancel')){
            
            if (Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Try to Attempt recancel booking.');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Try to Attempt recancel booking.');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Try to Attempt recancel booking.');
            }elseif (Auth::user()->user_type == 4) {
                return redirect('/associate/schemes')->with('status', 'Try to Attempt recancel booking.');
            }
        }
        $timeto= Carbon::createFromFormat('H:i:s', '09:30:00')->format('H:i:s');;
        $timefrom= Carbon::createFromFormat('H:i:s', '18:15:00')->format('H:i:s');
        $time= now()->format('H:i:s');
        if(($timeto <= now()->format('H:i:s'))&&( $timefrom >= now()->format('H:i:s') )){
            if(Auth::user()->user_type == 1){
                $name="Super Admin";
            }elseif(Auth::user()->user_type == 2){
                $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
                $name=$production->production_name;
            }else{
                $name=Auth::user()->name;
            }
            session()->forget('booking_cancel');
            $proail = PropertyModel::where('public_id', $request->property_public_id)->where('booking_status','!=',4)->first();
            // dd($proail);
            if(!isset($proail->status))
            {
                if (Auth::user()->user_type == 1){
                    return redirect('/admin/schemes')->with('status', 'Try to Attempt recancel booking.');
                }elseif (Auth::user()->user_type == 2){ 
                    return redirect('/production/schemes')->with('status', 'Try to Attempt recancel booking.');
                }elseif (Auth::user()->user_type == 3){ 
                    return redirect('/opertor/schemes')->with('status', 'Try to Attempt recancel booking.');
                }elseif (Auth::user()->user_type == 4) {
                    return redirect('/associate/schemes')->with('status', 'Try to Attempt recancel booking.');
                }
                // return redirect()->route('schemes')->with('status', 'Try to Attempt recancel booking.');
            }
            $statushji = $proail->booking_status;
            if($proail->waiting_list > 0){
               // dd($statushji);
                $datas= WaitingListMember::where(['scheme_id'=>$proail->scheme_id,'plot_no'=>$proail->plot_no])->get();
                //dd($datas);
                foreach($datas as $data){
                    // unlink('customer/aadhar'.'/'.$data->adhar_card);
                    // unlink('customer/pancard'.'/'.$data->pan_card_image);
                    // unlink('customer/cheque'.'/'.$data->cheque_photo);
                    // unlink('customer/attach'.'/'.$data->attachment);
                    $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                    //dd($waitingdatas);
                    if(isset($waitingdatas[0]))
                    {
                        //dd('yes');
                        foreach($waitingdatas as $waitingdata){
                            // unlink('customer/aadhar'.'/'.$waitingdata->adhar_card);
                            // unlink('customer/pancard'.'/'.$waitingdata->pan_card_image);
                            // unlink('customer/cheque'.'/'.$waitingdata->cheque_photo);
                            // unlink('customer/attach'.'/'.$waitingdata->attachment);
                            $model= WaitingListCustomer::find($$waitingdata->id);
                            $model->delete();
                        }
                    }
                    // dd('no');
                }
            }
            $paymentproof = PaymentProof::where('property_id', $proail->id)->first();
            if(isset($paymentproof)){
                unlink('customer/payment'.'/'.$paymentproof->proof_image);
            }
            $paymentproof = PaymentProof::where('property_id', $proail->id)->delete();
        
            $status = DB::table('tbl_property')->where('public_id', $request->property_public_id)
                ->update([
                    'booking_status' => 4,
                    'management_hold' => NULL,
                    // 'booking_time' =>  Carbon::now(),
                    'associate_name'=> $name,
                    'cancel_reason'=>$request->other_info,
                    'other_info'=>NULL,
                    'cancel_by'=>$name,
                    'cancel_time'=>Carbon::now(),
                    'waiting_list' => 0
                ]);
            $propty_report_detail = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.user_id','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_name','tbl_property.plot_type','tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_status')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
                ->where('tbl_property.public_id', $request->property_public_id)->first();
            $usered =DB::table('users')->where('public_id',$propty_report_detail->user_id)->first();
            $mailData = [
                'title' => $propty_report_detail->plot_type.' Booking Canceled',
                'name'=>$name,
                'plot_no'=>$propty_report_detail->plot_no,
                'plot_name'=>$propty_report_detail->plot_name,
                'plot_type' =>$propty_report_detail->plot_type,
                'scheme_name'=>$propty_report_detail->scheme_name,
                'status'=>$statushji
            ];
            if(isset($usered)){
                $email = $usered->email;
                
                $hji= 'bookedplotcancel';   $subject = $propty_report_detail->plot_type.' Booking Canceled';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                    
                $notifi = new NotificationController;
                $notifi->CancelsendNotification($mailData, $usered->device_token,$usered->mobile_number);
            }
       
            // $resu['mailData'] = $mailData=['title' => $propty_report_detail->plot_type.' Booking Canceled','plot_no'=>$propty_report_detail->plot_no,'plot_name'=>$propty_report_detail->plot_name,'plot_type' =>$propty_report_detail->plot_type,'scheme_name'=>$propty_report_detail->scheme_name];
            // $resu['hji'] = $hji= 'cancelemail';  
            // $resu['subject'] = $subject = $propty_report_detail->plot_type.' and'. $propty_report_detail->plot_name .' Available';  
            
            ProteryHistory ::create([
                'scheme_id' => $proail->scheme_id,
                'property_id'=>$proail->id,
                'action_by'=>Auth::user()->id,
                 'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' booking has been cancelled.',
            ]);
            $notifi = new NotificationController;
            $notifi->sendNotification($mailData);
            // SendEmails::dispatch($resu);
       
            // $users= User::where('status',1)->where('is_email_verified','1')->get();
            
            // $chunkedUsers = $users->chunk(50); // Split users into chunks of 100
              
                
                
                    // $notifi = new NotificationController;
                    // $notifi->sendNotification($mailData);
                    
            if (Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 4) {
                return redirect('/associate/schemes')->with('status', 'Property details update successfully');
            }
        }else{
            session()->forget('booking_cancel');
            if (Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Plot Booking cancelation time between 09:30 AM to 06:15 PM');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Plot Booking cancelation time between 09:30 AM to 06:15 PM');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Plot Booking cancelation time between 09:30 AM to 06:15 PM');
            }elseif (Auth::user()->user_type == 4) {
                return redirect('/associate/schemes')->with('status', 'Plot Booking cancelation time between 09:30 AM to 06:15 PM');
            }
        }
    }

    public function propertyComplete(Request $request)
    {
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }elseif(Auth::user()->user_type == 2){
            $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
            $name=$production->production_name;
        }else{
           $name=Auth::user()->name;
        }
        
        $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        
         if($proerty->waiting_list > 0){
            $datas= WaitingListMember::where(['scheme_id'=>$proerty->scheme_id,'plot_no'=>$proerty->plot_no])->get();
             foreach($datas as $data){
                if($data->adhar_card != ''){
                    unlink('customer/aadhar'.'/'.$data->adhar_card);
                }
                if($data->pan_card_image != ''){
                    unlink('customer/pancard'.'/'.$data->pan_card_image);
                }
                if($data->cheque_photo != ''){
                    unlink('customer/cheque'.'/'.$data->cheque_photo);
                }
                if($data->attachment != ''){
                    unlink('customer/attach'.'/'.$data->attachment);
                }
                $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                if($waitingdatas[0])
                {
                    foreach($waitingdatas as $waitingdata){
                        if($waitingdata->adhar_card != ''){
                            unlink('customer/aadhar'.'/'.$waitingdata->adhar_card);
                        }
                        if($waitingdata->pan_card_image != ''){
                            unlink('customer/pancard'.'/'.$waitingdata->pan_card_image);
                        }
                        if($waitingdata->cheque_photo != ''){
                            unlink('customer/cheque'.'/'.$waitingdata->cheque_photo);
                        }
                        if($waitingdata->attachment != ''){
                            unlink('customer/attach'.'/'.$waitingdata->attachment);
                        }
                        $model= WaitingListCustomer::find($$waitingdata->id);
                        $model->delete();
                    }
                }
             }
              
        }
        
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update([
                'booking_status' => 5,
                'associate_name'=> $name,
                'booking_time' =>  Carbon::now(),
                'management_hold'=>null,
                'waiting_list'=> 0
            ]);

        $propty_report_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.gaj', 'tbl_property.user_id','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_name','tbl_property.plot_type', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_status')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->id)->first();
        $usered =DB::table('users')->where('public_id',$propty_report_detail->user_id)->first();
         
        if(isset($usered)){
            $usermodel=DB::table('users')->where('public_id',$propty_report_detail->user_id)->update(['gaj'=>$usered->gaj + $propty_report_detail->gaj]);
            $email = $usered->email;
            $mailData = [
                        'title' => $propty_report_detail->plot_type.' Booking Complete',
                        'name'=>$name,
                        'plot_no'=>$propty_report_detail->plot_no,
                        'plot_name'=>$propty_report_detail->plot_name,
                        'plot_type' =>$propty_report_detail->plot_type,
                        'scheme_name'=>$propty_report_detail->scheme_name,
                    ];
            $hji= 'bookedplotcomplete';   $subject = $propty_report_detail->plot_type.' Booking Complete';
                Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                ProteryHistory ::create([
                    'scheme_id' => $proerty->scheme_id,
                    'property_id'=>$proerty->id,
                    'action_by'=>Auth::user()->id,
                    'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' booking has been completed.',
                ]);
            $notifi = new NotificationController;
            $notifi->CompletesendNotification($mailData,$usered->device_token,$usered->mobile_number);
       
        }
        if (Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', 'Property details update successfully');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', 'Property details update successfully');
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', 'Property details update successfully');
        }
    }

    public function propertyStatusForManagment($propertyId)
    {
        // dd($propertyId);
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.status', 1)->where('tbl_property.public_id', $propertyId)->first();
        //dd($property_details);
        return view('property.property-managment-page', ['property_details' => $property_details]);
        // dd($propertyId);
    }
    
    public function propertyStatusdelete($propertyId)
    {
        // dd($propertyId);
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.status', 1)->where('tbl_property.public_id', $propertyId)->first();
        //dd($property_details);
        return view('property.property-delete-reson', ['property_details' => $property_details]);
        // dd($propertyId);
    }

    public function propertyplotdelete( Request $request)
    {
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }elseif(Auth::user()->user_type == 2){
            $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
            $name=$production->production_name;
        }else{
           $name=Auth::user()->name;
        }
        $proerty = DB::table('tbl_property')->where('public_id', $request->property_public_id)->first();
        if($proerty->waiting_list > 0){
            $datas= WaitingListMember::where(['scheme_id'=>$proerty->scheme_id,'plot_no'=>$proerty->plot_no])->get();
            foreach($datas as $data){
                if($data->adhar_card != ''){
                    unlink('customer/aadhar'.'/'.$data->adhar_card);
                }
                if($data->pan_card_image != ''){
                    unlink('customer/pancard'.'/'.$data->pan_card_image);
                }
                if($data->cheque_photo != ''){
                    unlink('customer/cheque'.'/'.$data->cheque_photo);
                }
                if($data->attachment != ''){
                    unlink('customer/attach'.'/'.$data->attachment);
                }
                $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                if($waitingdatas[0])
                {
                    foreach($waitingdatas as $waitingdata){
                        if($waitingdata->adhar_card != ''){
                            unlink('customer/aadhar'.'/'.$waitingdata->adhar_card);
                        }
                        if($waitingdata->pan_card_image != ''){
                            unlink('customer/pancard'.'/'.$waitingdata->pan_card_image);
                        }
                        if($waitingdata->cheque_photo != ''){
                            unlink('customer/cheque'.'/'.$waitingdata->cheque_photo);
                        }
                        if($waitingdata->attachment != ''){
                            unlink('customer/attach'.'/'.$waitingdata->attachment);
                        }
                        $model= WaitingListCustomer::find($$waitingdata->id);
                        $model->delete();
                    }
                }
            }  
        }
        $status = DB::table('tbl_property')->where('public_id', $request->property_public_id)
            ->update([
                'status' => 3,
                'cancel_reason'=>$request->other_info,
                'cancel_time'=>Carbon::now(),
                'associate_name'=> $name,
                'waiting_list'=>0
                
            ]);
        $scheme = DB::table('tbl_scheme')->where('id',$proerty->scheme_id)->first();
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
             'action' => 'Scheme - '.$scheme->scheme_name.', plot no- '.$proerty->plot_name.' plot deleted',
        ]);
        if (Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', 'Property details update successfully');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', 'Property details update successfully');
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', 'Property details update successfully');
        }
    }


    public function propertyManagmentHold(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'managment_hold_id' => 'required'
        ]);
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }else{
            $name=Auth::user()->name;
        }
          // dd($name);
          $proerty = DB::table('tbl_property')->where('public_id', $request->property_public_id)->first();
        $status = DB::table('tbl_property')->where('public_id', $request->property_public_id)->where('scheme_id', $request->scheme_id)->where('plot_no', $request->plot_no)
            ->update(
                [
                    'booking_status' => $request->booking_status,
                    'management_hold' => $request->managment_hold_id,
                    'other_info' => $request->other_info,
                    'associate_name'=> $name,
                    'booking_time' =>  Carbon::now(),
                    'user_id'=>NULL,
                ]);
        
        $scheme = DB::table('tbl_scheme')->where('id', $request->scheme_id)->first();
        $usered = User::where('public_id',$proerty->user_id)->first();
        if(isset($usered[0])){
            $notifi = new NotificationController;
            $notifi->Mangementhold($usered->name,$usered->$usered->mobile_number);
        }
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.', plot no- '.$proerty->plot_name.' plot by Management hold due to management decided.',
        ]);
        if (Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', 'Managment hold done');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', 'Managment hold done');
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', 'Managment hold done');
        }
        
    }

    public function updateplot(Request $request)
    {
       // dd(($request->post()));
        $dfdsgfd=json_encode($request->post());
        $id =$request->scheme_id;
        $property = DB::table('tbl_property')->select('tbl_property.attributes_names')->where('tbl_property.public_id', $id)->first();
        $positionedd=[];
        $i=1;
        foreach (json_decode($property->attributes_names) as $key=>$attr) 
        {
            $f= "atrriu_".$i;
            $rfh= array($key => $request->$f );
            $positionedd=array_merge($positionedd,$rfh);
            $i++;
        }
        $dfdsgfd=json_encode($positionedd);
        $update = DB::table('tbl_property')->where('public_id', $id)->update(["attributes_data" => $dfdsgfd]);
        $scheme = DB::table('tbl_scheme')->where('id',$property->scheme_id)->first();
        ProteryHistory ::create([
            'scheme_id' => $property->scheme_id,
            'property_id'=>$property->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.', plot no- '.$property->plot_name.' plot Attribute changed.',
        ]);
        if (Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', 'Property details update successfully!!');
        }elseif (Auth::user()->user_type == 2){ 
                    return redirect('/production/schemes')->with('status', 'Property details update successfully!!');
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', 'Property details update successfully!!');
        }
        
    }
    
    public function propertyrelease(Request $request)
    {
        $booking_status = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $paymentproof = PaymentProof::where('property_id', $booking_status->id)->first();
        if($paymentproof){
            unlink('customer/payment'.'/'.$paymentproof->proof_image);
        }
        $paymentproof = PaymentProof::where('property_id', $booking_status->id)->delete();
        if($booking_status->waiting_list > 0){
            $datas= WaitingListMember::where(['scheme_id'=>$booking_status->scheme_id,'plot_no'=>$booking_status->plot_no])->get();
            foreach($datas as $data){
                if($data->adhar_card != ''){
                    unlink('customer/aadhar'.'/'.$data->adhar_card);
                }
                if($data->pan_card_image != ''){
                    unlink('customer/pancard'.'/'.$data->pan_card_image);
                }
                if($data->cheque_photo != ''){
                    unlink('customer/cheque'.'/'.$data->cheque_photo);
                }
                if($data->attachment != ''){
                    unlink('customer/attach'.'/'.$data->attachment);
                }
                $waitingdatas= WaitingListCustomer::where(['waiting_member_id'=>$data->id])->get();
                if($waitingdatas[0])
                {
                    foreach($waitingdatas as $waitingdata){
                        if($waitingdata->adhar_card != ''){
                            unlink('customer/aadhar'.'/'.$waitingdata->adhar_card);
                        }
                        if($waitingdata->pan_card_image != ''){
                            unlink('customer/pancard'.'/'.$waitingdata->pan_card_image);
                        }
                        if($waitingdata->cheque_photo != ''){
                            unlink('customer/cheque'.'/'.$waitingdata->cheque_photo);
                        }
                        if($waitingdata->attachment != ''){
                            unlink('customer/attach'.'/'.$waitingdata->attachment);
                        }
                        $model= WaitingListCustomer::find($$waitingdata->id);
                        $model->delete();
                    }
                }
            }      
        }
        $associate= DB::table('users')->where('public_id',$booking_status->user_id)->first();
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update([
            'status'=>1,
            'user_id'=>null,
            'associate_name'=>null,
            'associate_number'=>null,
            'associate_rera_number'=>null,
            'payment_mode'=>null,
            'adhar_card'=>null,
            'pan_card'=>null,
            'pan_card_image'=>null,
            'cheque_photo'=>null,
            'attachment'=>null,
            'owner_name'=>null,
            'contact_no'=>null,
            'address'=>null,
            'description'=>null,
            'booking_status' =>1,
            'management_hold' => 0,
            'booking_time' => Carbon::now(),
            'cancel_reason'=>null,
            'cancel_by'=>null,
            'cancel_time'=>null,
            'other_owner'=>null,
            'other_info'=>null
        ]);
        
        if($booking_status->user_id != NULL){
            $gaj= DB::table('users')->where('public_id',$booking_status->user_id)->update(['gaj'=>$associate->gaj - $booking_status->gaj ]);
        }
        $scheme = DB::table('tbl_scheme')->where('id',$booking_status->scheme_id)->first();
        ProteryHistory ::create([
            'scheme_id' => $booking_status->scheme_id,
            'property_id'=>$booking_status->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.', plot no-'.$booking_status->plot_name.' to be relaesed due to client not interested . And after 30 mins it will be available in availability.',
        ]);
        return redirect('/admin/schemes')->with('status', 'Property details update successfully');
    }
    
    public function editCustomer(Request $request)
    {
        $propty_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.*')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->property_id)->whereIn('tbl_property.booking_status',[2,3])->first();
            //dd($propty_detail);     
        if($propty_detail->other_owner==''){
            $min=0;
        }else{
            $min=$propty_detail->other_owner;
        }
        $multi_customer = DB::table('customers')->where('plot_public_id',$request->property_id)->ORDERBY('id', 'DESC')->limit($min)->get();
            //dd($propty_report_detail);
            //dd($multi_customer);
        return view('scheme.edit-cutomer', ['property_data' => $request,'multi_customer'=>$multi_customer,'propty_detail'=>$propty_detail]);
    }
    
    public function updateCustomer(Request $request)
    {
        $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
            $validatedData = $request->validate([
                'owner_name' => 'required',
                'adhar_card_number' => 'required|min:12',            
            ]);
            
            if ($request->has('adhar_card')) {
                $adhar_card = $request->file('adhar_card');
                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
            }else{
                $fileName_adhar=$booking_status->adhar_card;
            }
    
            if ($request->has('cheque_photo')) {
                $cheque_photo = $request->file('cheque_photo');
                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
            }else{
                $fileName_cheque=$booking_status->cheque_photo;
            }
    
            if ($request->has('attachement')) {
                $attachement = $request->file('attachement');
                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                $attachement->move(public_path('customer/attach'), $fileName_att);
            }else{
                $fileName_att=$booking_status->attachment;
            }
    
            if ($request->has('pan_card_image')) {
                $pan_card_image = $request->file('pan_card_image');
                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
            }else{
                $fileName_pan=$booking_status->pan_card_image;
            }
            
            if(isset($request->piid)){
                $other_owner =   count($request->piid);
            }else{
                $other_owner=NULL;
            }

            $status = DB::table('tbl_property')->where('public_id', $request->property_id)
                ->update([
                        'associate_name' => $request->associate_name,
                        'associate_number' => $request->associate_number,
                        'associate_rera_number' => $request->associate_rera_number,
                        
                        'booking_time' =>  Carbon::now(),
                        'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
                        'description' => $request->description,
                        'owner_name' =>  $request->owner_name,
                        'contact_no' => $request->contact_no,
                        'address' => $request->address,
                       
                        'pan_card'=>$request->pan_card_no,
                        'pan_card_image'=>$fileName_pan,
                        'adhar_card'=>$fileName_adhar,
                        'adhar_card_number' =>$request->adhar_card_number,
                        'cheque_photo'=>$fileName_cheque,
                        'attachment'=> $fileName_att,
                        'other_owner'=>$other_owner
                ]);
            if(isset($request->piid)){
                if(!empty($request->owner_namelist[0])){
                    $owner_namelist=$request->owner_namelist;
                    $contact_nolist=$request->contact_nolist;
                    $addresslist=$request->addresslist;
                    $payment_modelist=$request->payment_modelist;
                    $pan_cardlist=$request->pan_card_nolist;
                    $addhar_numberlist = $request->adhar_card_number_list;
                    $taxidArr=$request->post('piid'); 
                    foreach($taxidArr as $key=>$val){                                           
                        if($taxidArr[$key]!=''){
                            $custarr = Customer::where(['id'=>$taxidArr[$key]])->first();
                            if ($request->hasFile("adhar_cardlist.$key")) {
                                $adhar_card = $request->file("adhar_cardlist.$key");
                                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                            }else{
                                $fileName_adhar=$custarr->adhar_card;
                            }
    
                            if ($request->hasFile("cheque_photolist.$key")) {
                                $cheque_photo = $request->file("cheque_photolist.$key");
                                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                            }else{
                                $fileName_cheque=$custarr->cheque_photo;
                            }
    
                            if ($request->hasFile("attachementlist.$key")) {
                                $attachement = $request->file("attachementlist.$key");
                                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                                $attachement->move(public_path('customer/attach'), $fileName_att);
                            }else{
                                $fileName_att=$custarr->attachment;
                            }
        
                            if ($request->hasFile("pan_card_imagelist.$key")) {
                                $pan_card_image = $request->file("pan_card_imagelist.$key");
                                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                            }else{
                                $fileName_pan=$custarr->pan_card_image;
                            }

                            Customer::where(['id'=>$taxidArr[$key]])->update([
                                'plot_public_id' => $request->property_id,
                                
                                'description' => $request->description,
                                'owner_name' =>  $owner_namelist[$key],
                                'contact_no' => $contact_nolist[$key],
                                'address' => $addresslist[$key],
                                'pan_card' => $pan_cardlist[$key],
                                'pan_card_image' => $fileName_pan,
                                'adhar_card' => $fileName_adhar,
                                'cheque_photo' => $fileName_cheque,
                                'attachment' => $fileName_att,
                                'adhar_card_number' =>$addhar_numberlist[$key],
                            ]);
                        }else{   
                            if ($request->hasFile("adhar_cardlist.$key")) {
                                $adhar_card = $request->file("adhar_cardlist.$key");
                                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                            }else{
                                $fileName_adhar='';
                            }
                            if ($request->hasFile("cheque_photolist.$key")) {
                                $cheque_photo = $request->file("cheque_photolist.$key");
                                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
                            }else{
                                $fileName_cheque='';
                            }
                            if ($request->hasFile("attachementlist.$key")) {
                                $attachement = $request->file("attachementlist.$key");
                                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                                $attachement->move(public_path('customer/attach'), $fileName_att);
                            }else{
                                $fileName_att='';
                            }
                            if ($request->hasFile("pan_card_imagelist.$key")) {
                                $pan_card_image = $request->file("pan_card_imagelist.$key");
                                $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
                                $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
                            }else{
                                $fileName_pan='';
                            }

                            $model=new Customer();
                            $model->public_id = Str::random(6);
                            $model->plot_public_id = $request->property_id;
                            $model->booking_status = $booking_status->booking_status;
                            $model->associate = $request->associate_rera_number;
                            $model->payment_mode =  0;
                            $model->description = $request->description;
                            $model->owner_name =  $owner_namelist[$key];
                            $model->contact_no = $contact_nolist[$key];
                            $model->address = $addresslist[$key];
                            $model->pan_card= $pan_cardlist[$key];
                            $model->pan_card_image = $fileName_pan;
                            $model->adhar_card= $fileName_adhar;
                            $model->cheque_photo= $fileName_cheque;
                            $model->attachment= $fileName_att;
                            $model->adhar_card_number = $addhar_numberlist[$key];
                            $model->save();
                        }
                    }
                }
            }
            $scheme = SchemeModel::where('id',$booking_status->scheme_id)->first();
            ProteryHistory ::create([
                'scheme_id' => $booking_status->scheme_id,
                'property_id'=>$booking_status->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$scheme->scheme_name.' , plot no-'.$booking_status->plot_name.'-customer details changed ',
            ]);
            if (Auth::user()->user_type == 1){
                
                return redirect('/admin/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 2){ 
               
                return redirect('/production/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 3){ 
                
                return redirect('/opertor/schemes')->with('status', 'Property details update successfully');
            }elseif (Auth::user()->user_type == 4) {
                
                return redirect('/associate/schemes')->with('status', 'Property details update successfully');
            }
        

    }
    
    public function removeimage(Request $request)
    {
        //dd($request->id);
        $par = $request->par;
        $image = $request->image;
        if($par === 'adh'){
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['adhar_card' => null]);
            unlink('customer/aadhar'.'/'.$image);    
        }elseif($par === 'pan'){
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['pan_card_image' => null]);
            unlink('customer/pancard'.'/'.$image);
        }elseif($par === 'che'){
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['cheque_photo' => null]);
            unlink('customer/cheque'.'/'.$image);
        }elseif($par === 'att'){
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['attachment' => null]);
            unlink('customer/attach'.'/'.$image);
        }
        return redirect()->back();
    }
    

    public function updateplotatyd(Request $request)
    {
       // dd(($request->post()));   
       $propertyalls = DB::table('tbl_property')->where('scheme_id','19')->get();
       //dd($propertyalls);
       foreach($propertyalls as $propertyall)
       {
            $i=1; 
            foreach(json_decode($propertyall->attributes_data) as $key=>$attr){
                $atrriu[$i] = $attr;
                $i++; 
            }
            $positionedd=[];
            $i=1;   
            foreach (json_decode($propertyall->attributes_names) as $key=>$attr) 
            {
                $f= $atrriu[$i];
                $rfh= array($key =>$f );
                $positionedd=array_merge($positionedd,$rfh);
                $i++;
            }
            $dfdsgfd=json_encode($positionedd);
            $update = DB::table('tbl_property')->where('public_id', $propertyall->public_id)->update(["attributes_data" => $dfdsgfd]);
        }

        ProteryHistory ::create([
            'scheme_id' => $booking_status->scheme_id,
            'property_id'=>$booking_status->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Attribute data Updated',
        ]);
        if (Auth::user()->user_type == 1){          
            return redirect('/admin/schemes')->with('status', 'Property details update successfully!!');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', 'Property details update successfully!!');
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', 'Property details update successfully!!');
        }    
    }
    
    
    public function multipalbookhold(Request $request)
    {
        // dd($request->plot_name);
        // $pmodel = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->first();
         $smodel = SchemeModel::where('id',$request->scheme_id)->first();
         if(!session()->get('booking_page')){
            
            return redirect()->route('view.scheme', ['id' => $smodel->id])->with('status', 'Try to Attempt rebooking.');
        }
        if(($smodel->lunch_date > now()->subMonth()->format('Y-m-d H:i:s')) && ($request->ploat_status == 2))
        {
           $move = $this->CheckMUltipliBookingStatus($request->plot_name, $request->adhar_card_number,$request->scheme_id);
            if($move == 'yes')
            {
                return redirect()->route('view.scheme', ['id' => $smodel->id])->with('status', 'Customer  can not  booked/Complete  more than 2 plot or 4 shop under last 1 month.'); 
            }
        }
        $plot_names = $request->plot_name; 
        foreach($plot_names as $plot_name){

            $plot_details = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->where('plot_no',$plot_name)->first();
            // $smodel = SchemeModel::where('id',$pmodel->scheme_id)->first();
            if(($smodel->lunch_date > now()->subMonth()->format('Y-m-d H:i:s')) && ($request->ploat_status == 2))
            {
                $move = $this->AddharValidation($plot_details->public_id, $request->adhar_card_number);
                if($move == 'yes')
                {
                    return redirect()->route('view.scheme', ['id' => $plot_details->scheme_id])->with('status', 'Customer already booked/Complete 2 plot or 4 shop under last 1 month.'); 
                }
            }

            // $plot_details = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->where('plot_no',$plot_name)->first();
            $pcustomer = Customer::where('plot_public_id',$plot_details->public_id)->where('adhar_card_number',$request->adhar_card_number)
                ->where('associate',$request->associate_rera_number)->whereDate('created_at', '>', Carbon::today()->subDays(1)->toDateString())->first();
            if($pcustomer)
            {
                return   redirect()->route('view.scheme', ['id' => $request->scheme_id])->with('status', 'Customer already booked/Hold this plot under last 24 hours.');
            }
            if(($plot_details->adhar_card_number == $request->adhar_card_number) && ($plot_details->cancel_time > now()->subDays(1)->format('Y-m-d H:i:s'))){
                return   redirect()->route('view.scheme', ['id' => $request->scheme_id])->with('status', 'Customer already booked/Hold this '.$plot_details->plot_type.' number '.$plot_details->plot_name.' under last 24 hours.');
            }
        }
        $validatedData = $request->validate([
                        'owner_name' => 'required',
                        'adhar_card_number' => 'required|min:12',
                        'ploat_status'=>'required',
            ],['ploat_status.required'=>'Plot status field is required']);
                    
        if ($request->has('adhar_card')) {
            $adhar_card = $request->file('adhar_card');
            $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
            $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
        }else{
            $fileName_adhar='';
        }

        if ($request->has('cheque_photo')) {
            $cheque_photo = $request->file('cheque_photo');
            $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
            $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
        }else{
            $fileName_cheque='';
        }

        if ($request->has('attachement')) {
            $attachement = $request->file('attachement');
            $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
            $attachement->move(public_path('customer/attach'), $fileName_att);
        }else{
            $fileName_att='';
        }

        if ($request->has('pan_card_image')) {
            $pan_card_image = $request->file('pan_card_image');
            $fileName_pan = time() . rand(1, 99) . '.' . $pan_card_image->extension();
            $pan_card_image->move(public_path('customer/pancard'), $fileName_pan);
        }else{
            $fileName_pan='';
        }
            
        if(isset($request->piid)){
            $other_owner =   count($request->piid);
        }else{
            $other_owner=NULL;
        }
        
        if(isset($request->piid)){
            if(!empty($request->owner_namelist[0])){  
                $owner_namelist=$request->owner_namelist;
                $contact_nolist=$request->contact_nolist;
                $addresslist=$request->addresslist;
                $payment_modelist=$request->payment_modelist;
                $pan_cardlist=$request->pan_card_nolist;
                $addhar_numberlist = $request->adhar_card_number_list;
                $taxidArr=$request->post('piid'); 
                $i=1;
                foreach($taxidArr as $key=>$val){                                       
                    if ($request->hasFile("adhar_cardlist.$key")) {
                        $adhar_cardc = $request->file("adhar_cardlist.$key");
                        $fileName_adharc[$i] = time() . rand(1, 99) . '.' . $adhar_cardc->extension();
                        $adhar_cardc->move(public_path('customer/aadhar'), $fileName_adharc[$i]);
                    }else{
                        $fileName_adharc[$i]='';
                    }

                    if ($request->hasFile("cheque_photolist.$key")) {
                        $cheque_photoc = $request->file("cheque_photolist.$key");
                        $fileName_chequec[$i] = time() . rand(1, 99) . '.' . $cheque_photoc->extension();
                        $cheque_photoc->move(public_path('customer/cheque'), $fileName_chequec[$i]);
                    }else{
                        $fileName_chequec[$i]='';
                    }

                    if ($request->hasFile("attachementlist.$key")) {
                        $attachementc = $request->file("attachementlist.$key");
                        $fileName_attc[$i] = time() . rand(1, 99) . '.' . $attachementc->extension();
                        $attachementc->move(public_path('customer/attach'), $fileName_attc[$i]);
                    }else{
                        $fileName_attc[$i]='';
                    }

                    if ($request->hasFile("pan_card_imagelist.$key")) {
                        $pan_card_imagec = $request->file("pan_card_imagelist.$key");
                        $fileName_panc[$i] = time() . rand(1, 99) . '.' . $pan_card_imagec->extension();
                        $pan_card_imagec->move(public_path('customer/pancard'), $fileName_panc[$i]);
                    }else{
                        $fileName_panc[$i]='';
                    }
                    $i++;
                }
            }    
        }
                 
        $plot_names = $request->plot_name; 
        foreach($plot_names as $plot_name){
            $plot_details = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->where('plot_no',$plot_name)->first();
            if(($smodel->lunch_date > now()->subMonth()->format('Y-m-d H:i:s')) && ($request->ploat_status == 2))
            {
                $move = $this->AddharValidation($plot_details->public_id, $request->adhar_card_number);
                if($move == 'yes')
                {  
                    return redirect()->route('view.scheme', ['id' => $plot_details->scheme_id])->with('status', 'Customer already booked/Complete 2 plot or 4 shop under last 1 month.'); 
                }
            }
        
            if($plot_details->booking_status != 2 && $plot_details->booking_status != 3) 
            {
                $status = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->where('plot_no',$plot_name)
                        ->update(
                            [
                                'associate_name' => $request->associate_name,
                                'associate_number' => $request->associate_number,
                                'associate_rera_number' => $request->associate_rera_number,
                                'booking_status' => $request->ploat_status,
                                'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
                                'booking_time' =>  Carbon::now(),
                                'description' => $request->description,
                                'owner_name' =>  $request->owner_name,
                                'contact_no' => $request->contact_no,
                                'adhar_card_number' =>$request->adhar_card_number,
                                'address' => $request->address,
                                'user_id' => Auth::user()->public_id,
                                'pan_card'=>$request->pan_card_no,
                                'pan_card_image'=>$fileName_pan,
                                'adhar_card'=>$fileName_adhar,
                                'cheque_photo'=>$fileName_cheque,
                                'attachment'=> $fileName_att,
                                'other_owner'=>$other_owner
                            ]
                        );
                
                $model=new Customer();
                $model->public_id = Str::random(6);
                $model->plot_public_id = $plot_details->public_id;
                $model->booking_status = $request->ploat_status;
                $model->associate = $request->associate_rera_number;
                $model->payment_mode =  0;
                $model->description = $request->description;
                $model->owner_name =  $request->owner_name;
                $model->contact_no = $request->contact_no;
                $model->address = $request->address;
                $model->adhar_card_number= $request->adhar_card_number;
                $model->pan_card= $request->pan_card_no;
                $model->pan_card_image = $fileName_pan;
                $model->adhar_card= $fileName_adhar;
                $model->cheque_photo= $fileName_cheque;
                $model->attachment= $fileName_att;
                $model->save();
                
                if(isset($request->piid)){

                    if(!empty($request->owner_namelist[0])){
                      
                        $owner_namelist=$request->owner_namelist;
                        $contact_nolist=$request->contact_nolist;
                        $addresslist=$request->addresslist;
                        $payment_modelist=$request->payment_modelist;
                        $pan_cardlist=$request->pan_card_nolist;
                        $addhar_numberlist = $request->adhar_card_number_list;
                        $taxidArr=$request->post('piid'); 
                        $i=1;
                        foreach($taxidArr as $key=>$val){                                       
                            $model=new Customer();
                            $model->public_id = Str::random(6);
                            $model->plot_public_id = $plot_details->public_id;
                            $model->booking_status = $request->ploat_status;
                            $model->associate = $request->associate_rera_number;
                            $model->payment_mode =  0;
                            $model->description = $request->description;
                            $model->owner_name =  $owner_namelist[$key];
                            $model->contact_no = $contact_nolist[$key];
                            $model->address = $addresslist[$key];
                            $model->pan_card= $pan_cardlist[$key];
                            $model->adhar_card_number= $addhar_numberlist[$key];
                            $model->pan_card_image = $fileName_panc[$i];
                            $model->adhar_card= $fileName_adharc[$i];
                            $model->cheque_photo= $fileName_chequec[$i];
                            $model->attachment= $fileName_attc[$i];
                            $model->save(); 
                            $i++;
                        }
                    }
                    
                }
                $scheme_details = DB::table('tbl_scheme')->where('id', $plot_details->scheme_id)->first();
                $email=  AUth::user()->email;
                $mailData = [
                    'title' => $plot_details->plot_type.' Book Details',
                    'name'=>Auth::user()->name,
                    'plot_no'=>$plot_details->plot_no,
                    'plot_name'=>$plot_details->plot_name,
                    'plot_type' =>$plot_details->plot_type,
                    'scheme_name'=>$scheme_details->scheme_name,
                ];
                $hji= 'bookedplotdetails';   $subject = $plot_details->plot_type.' Book Details';
                ProteryHistory ::create([
                    'scheme_id' => $scheme_details->id,
                    'property_id'=>$plot_details->id,
                    'action_by'=>Auth::user()->id,
                    'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].'  has been booked',
                ]);
                $notifi = new NotificationController;
                
                if($request->ploat_status==2)
                {
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                    $notifi->BookingsendNotification($mailData, Auth::user()->device_token, Auth::user()->mobile_number); 
                    $notifi->mobileBooksms($mailData,Auth::user()->mobile_number);
                }else{
                    $notifi->mobilesmshold($mailData, Auth::user()->mobile_number);
                }
                $notifi->BookingPushNotification($mailData,$plot_details->scheme_id,$plot_details->production_id);
                 
            }elseif(($plot_details->booking_status == 2 || $plot_details->booking_status == 3) && $request->ploat_status == 2 && $plot_details->waiting_list < 3){
                //for waiting list code
                $model1=new WaitingListMember();
                $model1->scheme_id = $request->scheme_id;
                $model1->plot_no =$plot_name;
                $model1->user_id = Auth::user()->public_id;
                $model1->associate_name = $request->associate_name;
                $model1->associate_number= $request->associate_number;
                $model1->associate_rera_number= $request->associate_rera_number;
                $model1->payment_mode = $request->payment_mode ? $request->payment_mode : 0;
                $model1->adhar_card = $fileName_adhar;
                $model1->adhar_card_number =$request->adhar_card_number;
                $model1->pan_card = $request->pan_card_no;
                $model1->pan_card_image = $fileName_pan;
                $model1->cheque_photo = $fileName_cheque;
                $model1->attachment = $fileName_att;
                $model1->owner_name =  $request->owner_name;
                $model1->booking_status= $request->ploat_status;
                $model1->contact_no = $request->contact_no; 
                $model1->address = $request->address;
                $model1->booking_time =  Carbon::now();
                $model1->description = $request->description;
                $model1->other_owner = $other_owner;
                $model1->save();
                                  
                if(isset($request->piid)){
                    if(!empty($request->owner_namelist[0])){    
                        $owner_namelist=$request->owner_namelist;
                        $contact_nolist=$request->contact_nolist;
                        $addresslist=$request->addresslist;
                        $payment_modelist=$request->payment_modelist;
                        $pan_cardlist=$request->pan_card_nolist;
                        $addhar_numberlist = $request->adhar_card_number_list;
                        $taxidArr=$request->post('piid'); 
                        $i=1;
                        foreach($taxidArr as $key=>$val){                                             
                            $model=new WaitingListCustomer();
                            $model->scheme_id = $request->scheme_id;
                            $model->plot_no = $plot_name;
                            $model->user_id = Auth::user()->public_id;
                            $model->waiting_member_id = $model1->id;
                            $model->payment_mode =  0;
                            $model->adhar_card= $fileName_adharc[$i];
                            $model->adhar_card_number= $addhar_numberlist[$key];
                            $model->pan_card= $pan_cardlist[$key];
                            $model->pan_card_image = $fileName_panc[$i];
                            $model->cheque_photo= $fileName_chequec[$i];
                            $model->attachment= $fileName_attc[$i];
                            $model->owner_name =  $owner_namelist[$key];
                            $model->booking_status = $request->ploat_status;
                            $model->contact_no = $contact_nolist[$key];
                            $model->address = $addresslist[$key];
                            $model->save();
                            $i++;
                        }
                    }    
                }
                $status = DB::table('tbl_property')->where('scheme_id', $request->scheme_id)->where('plot_no',$plot_name)->increment('waiting_list');
                $scheme_details = DB::table('tbl_scheme')->where('id', $plot_details->scheme_id)->first();
                $mailData = [
                    'title' => $plot_details->plot_type.' Book Details',
                    'name'=>Auth::user()->name,
                    'plot_no'=>$plot_details->plot_no,
                    'plot_name'=>$plot_details->plot_name,
                    'plot_type' =>$plot_details->plot_type,
                    'scheme_name'=>$scheme_details->scheme_name,
                ];
                $notifi = new NotificationController;
                ProteryHistory ::create([
                    'scheme_id' => $scheme_details->id,
                    'property_id'=>$plot_details->id,
                    'action_by'=>Auth::user()->id,
                    'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].'plot has been in waiting list',
                ]);
                $notifi->WaitingsendNotification($mailData, Auth::user()->device_token);
            }
                
        }
        session()->forget('booking_page');
        if (Auth::user()->user_type == 1){
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully.');
        }elseif (Auth::user()->user_type == 2){ 
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully.');
        }elseif (Auth::user()->user_type == 3){ 
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully.');
        }elseif (Auth::user()->user_type == 4) {
                return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Property details update successfully.');
        }
        
    }
        
        
        
    public function ProofUplod(Request $request)
    {
        $propertyId = $request->property_id;
        $property_details = DB::table('tbl_scheme')
        ->select('tbl_property.public_id as property_public_id', 'tbl_property.id as id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id')
        ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status', 1)->where('tbl_property.public_id', $propertyId)->first();
        
        return view('waiting.upload_proof', ['property_details' => $property_details]);
    }
        
    public function ProofUplodDetails(Request $request)
    {
        $propertyId = $request->property_id;
        $property_details = DB::table('tbl_property')->select('tbl_property.associate_name','tbl_property.booking_time','tbl_property.associate_number','tbl_property.associate_rera_number','payment_proofs.*','users.name','users.user_type')
            ->leftJoin('payment_proofs','payment_proofs.property_id','tbl_property.id')
            ->leftJoin('users','users.id','payment_proofs.upload_by')->where('tbl_property.public_id', $propertyId)->first();
        $data = $property_details;
        return view('waiting/payment_details', ['data' => $data]);
    }
      
      
    public function ActiveHoldScheme($id)
    {
        $update = DB::table('tbl_scheme')->where('id', $id)->limit(1)->update(['hold_status' => 0]);
        if ($update) {
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Scheme updated active hold by '. Auth::user()->name .' with id '.$id.'. ',
            ]);
            if (Auth::user()->user_type == 1){ 
                return redirect('/admin/schemes')->with('status', 'Hold Status Option Activated Successfully !!');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Hold Status Option Activated Successfully !!');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Hold Status Option Activated Successfully !!');
            }
        }
    }
    public function DeactiveHoldScheme($id)
    {
        $update = DB::table('tbl_scheme')->where('id', $id)->limit(1)->update(['hold_status' => 1]);
        if ($update) {    
            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Scheme updated deactive hold by '. Auth::user()->name .' with id '.$id.'. ',
            ]);   
            if (Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Hold Status Option Deactivated Successfully !!!');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Hold Status Option deactivated Successfully !!');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Hold Status Option deactivated Successfully !!');
            }
        }
    }
        
    public function ActiveScheme(Request $request)
    {
        $update = DB::table('tbl_scheme')->where('id', $request->id)->limit(1)->update(['status' => 1]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Scheme updated active hold by '. Auth::user()->name .' with id '.$request->id.'. ',
        ]);
        if (Auth::user()->user_type == 1){      

            return redirect('/admin/schemes')->with('status', 'Scheme Activated Successfully !!');
        }elseif (Auth::user()->user_type == 2){      
            return redirect('/production/schemes')->with('status', 'Scheme Activated Successfully !!');
        }
    }
    
    public function DeactiveScheme(Request $request)
    {
        $update = DB::table('tbl_scheme')->where('id', $request->id)->limit(1)->update(['status' => 2]);
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Scheme updated deactive hold by '. Auth::user()->name .'with id '.$request->id.'. ',
        ]);
        if (Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', 'Scheme Deactivated Successfully !!');
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', 'Schemen Deactivated Successfully !!');
        }
    }


    public function waitingpropertyBook(Request $request)
    {
        $propty_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.hold_status')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->property_id)->first();
        session()->put('booking_page', true);
        return view('scheme.book-hold-property', ['property_data' => $request,'pdata'=>$propty_detail]);
    }

    public function PropertyReportsOption(Request $request)
    {
        $scheme_id='';
        $team_id='';
        $production_id='';
        // dd($request);
        $query = PropertyModel::select('users.applier_name','tbl_property.gaj','users.applier_rera_number','teams.team_name','teams.public_id as tpublic_id','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time','tbl_property.attributes_data','tbl_property.freez')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
                ->leftjoin('teams','teams.public_id','=','users.team')->leftjoin('tbl_production','tbl_production.public_id','=','tbl_property.production_id')->whereIn('booking_status', [0,1,2, 3, 4, 5,6]);
        if (isset($request->scheme_id)) {
            $scheme_id=$request->scheme_id;
            $query = $query->where('scheme_id',$scheme_id);
        }
        if (isset($request->team_id)) {
            $team_id=$request->team_id;
            $query = $query->where('teams.public_id',$team_id);
        }
        if(isset($request->production_id)){
            $production_id = $request->production_id;
            $query = $query->where('tbl_property.production_id',$production_id);
        }
        $propty_report_details= $query->get();

        // dd($propty_report_details);
        // if (Auth::user()->user_type == 1) {
        //     $propty_report_details = PropertyModel::select('users.applier_name','users.applier_rera_number','teams.team_name','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
        //         ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
        //         ->leftjoin('teams','teams.public_id','=','users.team')->whereIn('booking_status', [1,2, 3, 4, 5, 6])
        //         ->get();
        // } else {
        //     $propty_report_details = PropertyModel::select('users.applier_name','users.applier_rera_number','teams.team_name','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.adhar_card_number', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
        //         ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->leftjoin('users','users.public_id','=','tbl_property.user_id')
        //         ->leftjoin('teams','teams.public_id','=','users.team')->whereIn('booking_status', [2, 3, 4, 5, 6])
        //         ->where('tbl_property.user_id', Auth::user()->public_id)->get();
        // }
        $schemes = DB::table('tbl_scheme')->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('status', 1)->get();
        $teams = Team::where('status',1)->select('teams.public_id','teams.team_name')->get();
        $productions = ProductionModel::Select('tbl_production.public_id','tbl_production.production_name')->where('status',1)->get();
        
        return view('scheme.reports-option', ['propty_report_details' => $propty_report_details,'schemes'=>$schemes,'teams'=>$teams,'scheme_id'=>$scheme_id,'team_id'=>$team_id,'production_id'=>$production_id,'productions'=>$productions]);
    }

    public function CheckMUltipliBookingStatus($pa, $cus,$id)
    {
        // dd($request);
        $plot_number = $pa;
        $adhar_card_number = $cus;
        $scheme_id  = $id;
        $potype = [];
        
        foreach($plot_number as $key=> $pnumber){
            $pm = PropertyModel::where('scheme_id',$scheme_id)->where('plot_no',$pnumber)->first();
            if($pm->plot_type[0] == "S"){
                $potype[$key] = $pm->plot_type[0];
            }else{
                $potype[$key] = "P";
            }

        }
        // dd(array_search('P',array_flip(array_count_values($potype))));
        $pcount = array_search('P',array_flip(array_count_values($potype)));
        $scount = array_search('S',array_flip(array_count_values($potype)));

        // $pmodel = PropertyModel::where('public_id', $property_id)->first();
        // $plot_type = $pmodel->plot_type;
        $smodel = SchemeModel::where('id',$scheme_id)->first();
        $start=Carbon::parse($smodel->lunch_date)->format('Y-m-d H:i:s');
        $end=Carbon::parse($smodel->lunch_date)->addMonth()->format('Y-m-d H:i:s');
        $pbpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',2)->count();
        $phpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',3)->count();
        $pcpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','not LIKE',"S%")->where('booking_status',5)->count();

        $sbpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',2)->count();
        $shpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',3)->count();
        $scpmodel = PropertyModel::where('scheme_id',$scheme_id)->where('adhar_card_number',$adhar_card_number)->whereBetween('booking_time', [$start, $end])->where('plot_type','LIKE',"S%")->where('booking_status',5)->count();
        if((($pbpmodel + $pcpmodel) >= 2) && ($sbpmodel + $scpmodel) >= 4){
            $move = 'yes';
            return $move;
        }elseif(($pbpmodel + $pcpmodel + $pcount) > 2){
            $move = 'yes';
            return $move;
        }elseif((($sbpmodel + $scpmodel + $scount) >= 5)){
            $move = 'yes';
            return $move;
        }else{
            $move = 'no';
            return $move;
        }
    }
    
}
    

