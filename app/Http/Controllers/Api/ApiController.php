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
    public function index()
    {
        
       
            $result['usersCount'] = DB::table('users')->count();
            $result['productionsCount'] = DB::table('tbl_production')->where('status', 1)->count();
            $result['schemesCount'] = DB::table('tbl_scheme')->where('status', 1)->count();
            $result['bookPropertyCount'] = DB::table('tbl_property')->where('booking_status', 2)->count();
            $result['holdPropertyCount'] = DB::table('tbl_property')->where('booking_status', 3)->count();
            
            // dd($schemesCount);
            return response()->json([
                'status' => true,
                'result' => $result
            ], 200);
           
            
    }

    public function show_scheme ()
    {
        $schemes = DB::table('tbl_scheme')
            ->select('tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
            // ->select('*')
            ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
            ->where('tbl_scheme.status', 1)
            //->where('tbl_scheme.team',Auth::user()->team)
            ->get();
        // dd($schemes);
         $teamdta=DB::table('teams')->where('super_team',1)->get();
         $super_team=[];
        $i=1;
       foreach($teamdta as $list)
       {
        
        $original_array =  $list->public_id;
            $super_team[]=$original_array;
            $i++;
         }
         $result['schemes']= $schemes;
         $result['super_team']=$super_team;

         return response()->json([
            'status' => true,
            'result' => $result
        ], 200);
    }

    public function viewScheme($id)
    {

        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])
            ->get();


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

    public function listViewScheme($id)
    {

        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description', 'tbl_property.user_id','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.other_info', 'tbl_property.other_info', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])
            ->get();

         //dd($properties);    

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

    public function showScheme($id)
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
                      
        $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
       
        if ($booking_status->booking_status != 2 && $booking_status->booking_status != 3) {
            $validateUser = Validator::make($request->all(), [
                'owner_name' => 'required',
                'contact_no' => 'required',
                'ploat_status'=>'required',
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
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
                $other_owner =  count($request->piid);
            }else{
                $other_owner=NULL;
            }

            $status = DB::table('tbl_property')
                ->where('public_id', $request->property_id)
                ->update(
                    [
                        'associate_name' => $request->associate_name,
                        'associate_number' => $request->associate_number,
                        'associate_rera_number' => $request->associate_rera_number,
                        'booking_status' => $request->ploat_status,
                        'booking_time' =>  Carbon::now(),
                        'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
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
                
                $model=new Customer();
                $model->public_id = Str::random(6);
                $model->plot_public_id = $request->property_id;
                $model->booking_status = $request->ploat_status;
                $model->payment_mode = $request->payment_mode ? $request->payment_mode : 0;
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
                        $payment_modelist=$request->payment_modelist;
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
                             $model->booking_status = $request->ploat_status;
             
                             $model->payment_mode = $payment_modelist[$key] ? $payment_modelist[$key] : 0;
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
                
                if($request->ploat_status==2)
                {
                   $email = Auth::user()->email;
                   $mailData = [
                        'title' => 'Plot Book Details',
                        'name'=>Auth::user()->name,
                        'plot_no'=>$booking_status->plot_no,
                        'scheme_name'=>$scheme_details->scheme_name,
                    ];
                    $hji= 'bookedplotdetails';   $subject = 'Plot Book Details';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
                }

                return response()->json([
                    'status'=>true,
                    'msg'=>'Property details update successfully'
                ],200);
            //  return redirect('/schemes')->with('status', 'Property details update successfully');
             
        }elseif(($booking_status->booking_status == 3) || ($booking_status->associate_rera_number == $request->associate_rera_number)) {
           
            $validateUser = Validator::make($request->all(), [
                'owner_name' => 'required',
                'contact_no' => 'required',
                'ploat_status'=>'required',
                
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
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

            $status = DB::table('tbl_property')
                ->where('public_id', $request->property_id)
                ->update(
                    [
                        'associate_name' => $request->associate_name,
                        'associate_number' => $request->associate_number,
                        'associate_rera_number' => $request->associate_rera_number,
                        'booking_status' => $request->ploat_status,
                        'booking_time' =>  Carbon::now(),
                        'payment_mode' => $request->payment_mode ? $request->payment_mode : 0,
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
                
                 $model=new Customer();
                $model->public_id = Str::random(6);
                $model->plot_public_id = $request->property_id;
                $model->booking_status = $request->ploat_status;

                $model->payment_mode = $request->payment_mode ? $request->payment_mode : 0;
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
                        $payment_modelist=$request->payment_modelist;
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
                             $model->booking_status = $request->ploat_status;      
                             $model->payment_mode = $payment_modelist[$key] ? $payment_modelist[$key] : 0;
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
               
                if($request->ploat_status==2)
                {
                   $email = Auth::user()->email;
                   $mailData = [
                        'title' => 'Plot Book Details',
                        'name'=>Auth::user()->name,
                        'plot_no'=>$booking_status->plot_no,
                        'scheme_name'=>$scheme_details->scheme_name,
                    ];
                    $hji= 'bookedplotdetails';   $subject = 'Plot Book Details';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));               
                }
                return response()->json([
                    'status'=>true,
                    'msg'=>'Property details update successfully'
                ],200);
           
             //return redirect('/schemes')->with('status', 'Property details update successfully');
        }else{
            return response()->json([
                'status'=>true,
                'msg'=>'Plot already booked/Hold'
            ],200);
            //return redirect('/schemes')->with('status', 'Plot already booked/Hold');
        }
    }


    public function propertyReports(Request $request)
    {

        //dd($request->scheme_id);

        if (isset($request->scheme_id)) {
            $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
            $book_properties = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.status as property_status','tbl_property.plot_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.id as property_id', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.booking_status', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
               
                //->orWhere('booking_status', 3)
                //->orWhere('booking_status', 4)
                ->where('tbl_property.scheme_id', $request->scheme_id)->get();
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
            $propty_report_details = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->where('tbl_property.user_id', Auth::user()->public_id)->get();
        

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

}
