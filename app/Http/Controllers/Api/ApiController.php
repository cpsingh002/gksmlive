<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Mail;
use App\Mail\EmailDemo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\SchemeModel;
use App\Models\PropertyModel;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        
       
            $result['usersCount'] = DB::table('users')->count();
            //$result['productionsCount'] = DB::table('tbl_production')->where('status', 1)->count();
            $result['schemesCount'] = DB::table('tbl_scheme')->where('status', 1)->count();
            $result['bookPropertyCount'] = DB::table('tbl_property')->where('booking_status', 2)->count();
            $result['holdPropertyCount'] = DB::table('tbl_property')->where('booking_status', 3)->count();
            
            // dd($schemesCount);
            return response()->json([
                'status' => true,
                'result' => $result
            ], 200);
           
            
    }

    public function show_scheme (Request $request)
    {
        $per_page=7;
        $search ='';
        if($request->has('search')) $search = $request->search;
        if($request->has('per_page'))  $per_page=$request->per_page;
        
        $teamdta=DB::table('teams')->where('super_team',1)->get();
        $super_team=[];
        $i=1;
            foreach($teamdta as $list)
            {
                $original_array =  $list->public_id;
                $super_team[]=$original_array;
                $i++;
            }
        
         if((Auth::user()->all_seen != 1)&&(!in_array(Auth::user()->team, $super_team)))
            {
            $schemes = DB::table('tbl_scheme')
            ->select('tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->where('tbl_scheme.status', 1)->where('tbl_scheme.team', Auth::user()->team)->where(function($query) use ($search){
                    $query->where('tbl_scheme.scheme_name', 'LIKE', '%'. $search. '%')
                    ->orwhere('tbl_production.production_name','LIKE','%'. $search. '%')
                    ; })->paginate($per_page);
                
            }else{
                $schemes = DB::table('tbl_scheme')
            ->select('tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')->where('tbl_scheme.status', 1)->where(function($query) use ($search){
                    $query->where('tbl_scheme.scheme_name', 'LIKE', '%'. $search. '%')
                    ->orwhere('tbl_production.production_name','LIKE','%'. $search. '%')
                    ; })->paginate($per_page);
            }
        
        // dd($schemes);
         //$avalib_slot=[];
        if(isset($schemes[0])){
            foreach($schemes as $list){
                $dfgf = DB::table('tbl_property')->where('scheme_id',$list->scheme_id)->whereIn('booking_status',[1,0])->where('status','!=',3)->count();
                $list->ad_slot = strval($dfgf);
            //$avalib_slot[$list->scheme_id]= DB::table('tbl_property')->where('scheme_id',$list->scheme_id)->whereIn('booking_status',[1,2])->where('status','!=',3)->count();
            }
        }

         
         //$result['schemes']= $schemes;
         //$result['super_team']=$super_team;
         //$result['a_slot']=$avalib_slot;

         return response()->json([
            'status' => true,
            'result' => $schemes
        ], 200);
    }

    public function viewScheme(Request $request,$id)
    {
        $per_page=5;
        if($request->has('per_page'))  $per_page=$request->per_page;
        
        if($request->has('search')){
            $search = $request->search;
             $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id','tbl_property.plot_type','tbl_property.plot_name','tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])    ->where(function($query) use ($search){
                    $query->where('tbl_property.booking_status',  $search)
                    ->orwhere('tbl_property.plot_name', $search)
                    ->orwhere('tbl_property.plot_type', $search); })->orderBy('tbl_property.booking_status','ASC')
            ->paginate($per_page);
            
        }else{
        
        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id','tbl_property.plot_type','tbl_property.plot_name','tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.attributes_data', 'tbl_property.user_id','tbl_property.cancel_time', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')
            ->paginate($per_page);
        }

        $scheme_detail = DB::table('tbl_scheme')
            ->where('tbl_scheme.id', $id)
            ->first();
          
       // $current_time = now();
       $result['properties']=$properties;
       $result['scheme_detail']=$scheme_detail;
       return response()->json([
            'status' => true,
            'result' => $result
        ], 200);
        
    }
    
    public function search(Request $request,$id,$name)
    {
         $per_page=5;
         
         $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id','tbl_property.plot_type','tbl_property.plot_name','tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->where('tbl_property.plot_name','LIKE', '%'.$name.'%')->orderBy('tbl_property.booking_status','ASC')->where(function($query) use ($dfg, $res1){
                    $query->where('startbook','<=',$dfg->addHours($res1)->format('Y-m-d H:i:s'))
                    ->orwhere('startbook','<=',$dfg->addHours(0)->format('Y-m-d H:i:s'));   })    
            ->paginate($per_page);
            //dd($properties);
        //$result = Product::where('name', 'LIKE', '%'. $name. '%')->get();
        if(count($properties)){
         return Response()->json($properties);
        }
        else
        {
        return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    public function listViewScheme(Request $request,$id)
    {
        $per_page=10;
        if($request->has('per_page'))  $per_page=$request->per_page;
        if($request->has('search')){
            $search = $request->search;
             $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id','tbl_property.plot_type','tbl_property.plot_name','tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.cancel_time','tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])    ->where(function($query) use ($search){
                    $query->where('tbl_property.booking_status',  $search)
                    ->orwhere('tbl_property.plot_name',  $search)
                    ->orwhere('tbl_property.plot_type', $search); })->orderBy('tbl_property.booking_status','ASC')
            ->paginate($per_page);
        }else{
        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.plot_name','tbl_property.plot_type','tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.attributes_data', 'tbl_property.other_info','tbl_property.cancel_time', 'tbl_property.other_info', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])->orderBy('tbl_property.booking_status','ASC')
            ->paginate($per_page);;

         //dd($properties);    
        }
        $scheme_detail = DB::table('tbl_scheme')
            ->where('tbl_scheme.id', $id)
            ->first();

            $result['properties']=$properties;
            $result['scheme_detail']=$scheme_detail;

        return response()->json([
            'status'=>true,
            'result'=>$result
        ],200);

    }

    public function showScheme(Request $request,$id)
    {

       $scheme_details = DB::table('tbl_scheme')
        ->select('tbl_scheme.*','teams.team_name')->leftJoin('teams','tbl_scheme.team','teams.public_id')->where('tbl_scheme.id', $id)->get();

        //dd($scheme_details[0]->scheme_images);
        $images = $scheme_details[0]->scheme_images;
        $imgArray = explode(',', $images);
        // print_r($imgArray);
        //exit;

        $result['scheme_details']=$scheme_details;
        $result['images']=$imgArray;

        return response()->json([
            'status'=>true,
            'result'=>$result
        ],200);

    }
    public function bookProperty(Request $request)
    {
        //   return response()->json([
        //     'status'=>true,
        //     'result'=>$request->piid
        // ],200);
        //dd($request);
        $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
        
        if ($booking_status->booking_status != 2 && $booking_status->booking_status != 3)
        {
            $validatedData = $request->validate([
                'owner_name' => 'required',
                'contact_no' => 'required',
                'ploat_status'=>'required',
            ]);
                    
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

            $status = DB::table('tbl_property')->where('public_id', $request->property_id)
                ->update([
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
                        'user_id' => Auth::user()->public_id,
                        'pan_card'=>$request->pan_card_no,
                        'pan_card_image'=>$fileName_pan,
                        'adhar_card'=>$fileName_adhar,
                        'cheque_photo'=>$fileName_cheque,
                        'attachment'=> $fileName_att,
                        'other_owner'=>$other_owner
                    ]);
            
            $model=new Customer();
            $model->public_id = Str::random(6);
            $model->plot_public_id = $request->property_id;
            $model->booking_status = $request->ploat_status;

            $model->payment_mode =  0;
            $model->description = $request->description;
            $model->owner_name =  $request->owner_name;
            $model->contact_no = $request->contact_no;
            $model->address = $request->address;
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
                    // $payment_modelist=$request->payment_modelist;
                    $pan_cardlist=$request->pan_card_nolist;
                    $taxidArr=$request->post('piid'); 
                    foreach($taxidArr as $key=>$val){                                       
                        if ($request->hasFile("adhar_cardlist.$key")) {
                            $adhar_card = $request->file("adhar_cardlist.$key");
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
                         $model->save();
             
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
                    $hji= 'bookedplotdetails';   $subject = $booking_status->plot_type.' Book Details';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                }
               
                return response()->json([
                    'status'=>true,
                    'msg'=>'Property details update successfully'
                ],200);
               
             
        }elseif(($booking_status->booking_status == 3) && ($booking_status->associate_rera_number == $request->associate_rera_number) && ($request->ploat_status == 2)) {
        
            $validatedData = $request->validate([
                'owner_name' => 'required',
                'contact_no' => 'required',
                'ploat_status'=>'required',
            ]);
            
            if ($request->has('adhar_card')) {
                $adhar_card = $request->file('adhar_card');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
            }else{
                $fileName_adhar=$booking_status->adhar_card;
            }
    
            if ($request->has('cheque_photo')) {
                $cheque_photo = $request->file('cheque_photo');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_cheque = time() . rand(1, 99) . '.' . $cheque_photo->extension();
                $cheque_photo->move(public_path('customer/cheque'), $fileName_cheque);
            }else{
                $fileName_cheque=$booking_status->cheque_photo;
            }
    
            if ($request->has('attachement')) {
                $attachement = $request->file('attachement');
                //$filename = $adhar_card->getClientOriginalName();
                $fileName_att = time() . rand(1, 99) . '.' . $attachement->extension();
                $attachement->move(public_path('customer/attach'), $fileName_att);
            }else{
                $fileName_att=$booking_status->attachment;
            }
    
            if ($request->has('pan_card_image')) {
                $pan_card_image = $request->file('pan_card_image');
                //$filename = $adhar_card->getClientOriginalName();
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
                        'user_id' => Auth::user()->public_id,
                        'pan_card'=>$request->pan_card_no,
                        'pan_card_image'=>$fileName_pan,
                        'adhar_card'=>$fileName_adhar,
                        'cheque_photo'=>$fileName_cheque,
                        'attachment'=> $fileName_att,
                        'other_owner'=>$other_owner
                    ]
                );
                $model = Customer::where('plot_public_id',$request->property_id)->where('contact_no',$request->contact_no)->update(
                    [
                        'plot_public_id' => $request->property_id,
                        'booking_status' => $request->ploat_status,
                        'description' => $request->description,
                        'owner_name' =>  $request->owner_name,
                        'contact_no' => $request->contact_no,
                        'address' => $request->address,
                        'pan_card' => $request->pan_card_no,
                        'pan_card_image' => $fileName_pan,
                        'adhar_card' => $fileName_adhar,
                        'cheque_photo' => $fileName_cheque,
                        'attachment' => $fileName_att
                    ]
                    );
            
            
            
            if(isset($request->piid)){

                if(!empty($request->owner_namelist[0])){
                  
                    $owner_namelist=$request->owner_namelist;
                    $contact_nolist=$request->contact_nolist;
                    $addresslist=$request->addresslist;
                    // $payment_modelist=$request->payment_modelist;
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
                    'title' =>  $booking_status->plot_type.' Book Details',
                    'name'=>Auth::user()->name,
                    'plot_no'=>$booking_status->plot_no,
                    'plot_name'=>$booking_status->plot_name,
                    'plot_type' =>$booking_status->plot_type,
                    'scheme_name'=>$scheme_details->scheme_name,
                ];
                $hji= 'bookedplotdetails';   $subject =  $booking_status->plot_type.' Book Details';
                Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                
            }
       
            return response()->json([
                    'status'=>true,
                    'msg'=>'Property details update successfully'
                ],200);

        }else{
            return response()->json([
                'status'=>false,
                'msg'=>'Plot already booked/Hold'
            ],200);
            
        }
    }


    public function propertyReports(Request $request)
    {

        //dd($request->scheme_id);

        if (isset($request->scheme_id)) {
             $per_page=7;
        if($request->has('per_page'))  $per_page=$request->per_page;
            $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            $book_properties = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.status as property_status','tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.id as property_id', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.booking_status', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
               
                //->orWhere('booking_status', 3)
                //->orWhere('booking_status', 4)
                ->where('tbl_property.scheme_id', $request->scheme_id)->paginate($per_page);
            //dd($book_properties);
            $result['schemes']= $schemes;
            $result['book_properties']= $book_properties;

            return response()->json([
                'status'=>true,
                'result'=>$result
            ],200);
            //return view('scheme.reports', ['book_properties' => $book_properties, 'schemes' => $schemes]);
        } else {
            $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            $result['schemes']= $schemes;

            return response()->json([
                'status'=>true,
                'result'=>$result
            ],200);
            //return view('scheme.reports', ['schemes' => $schemes]);
        }
    }

    public function associatePropertyReports(Request $request)
    {    
         $per_page=10;
          $search ='';
        if($request->has('search')) $search = $request->search;
        if($request->has('per_page'))  $per_page=$request->per_page;
            $propty_report_details = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no','tbl_property.plot_type','tbl_property.plot_name', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->where('tbl_property.user_id', Auth::user()->public_id)->where(function($query) use ($search){
                    $query->where('tbl_property.plot_name', 'LIKE', '%'. $search. '%')
                    ->orwhere('tbl_scheme.scheme_name', 'LIKE', '%'. $search. '%')
                    ->orwhere('tbl_property.booking_status',  $search)
                    ->orwhere('tbl_property.plot_type', $search); })->paginate($per_page);
        

                $result['propty_report_details']= $propty_report_details;

                return response()->json([
                    'status'=>true,
                    'result'=>$result
                ],200);
        
        
       
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
        
        $multi_customer = DB::table('customers')->where('plot_public_id',$id)->ORDERBY('id', 'DESC')->limit($min)->get();
            //dd($multi_customer);


         //dd($propty_report_detail);
         $result['propty_report_detail']= $propty_report_detail;
         $result['other_owner']= $multi_customer;

         return response()->json([
             'status'=>true,
             'result'=>$result
         ],200);
 
        //return view('scheme.report-detail', ['propty_report_detail' => $propty_report_detail,'other_owner'=>$multi_customer]);

    }
    
    public function teamlist(Request $request){

        $teamdta=DB::table('teams')->where('status',1)->get();
            $result['teamdta']= $teamdta;
        return response()->json([
            'status'=>true,
            'result'=>$result
        ],200);
        
        
    }
    
     public function propertyBook(Request $request)

    {

        $propty_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.*')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
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
           
            $result['multi_customer']= $multi_customer;
             $result['propty_detail']= $propty_detail;

             return response()->json([
                 'status'=>true,
                 'result'=>$result
             ],200);
            //return view('scheme.edit-book-hold-property', ['property_data' => $request,'multi_customer'=>$multi_customer,'propty_detail'=>propty_detail]);
        }
       
        return response()->json([
                 'status'=>false,
                 'msg'=>'Not recode found'
             ],200);
         //return view('scheme.book-hold-property', ['property_data' => $request]);
    }


}
