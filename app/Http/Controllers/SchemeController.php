<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SchemeModel;
use App\Models\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use App\Mail\EmailDemo;
class SchemeController extends Controller
{
    public function index()
    {
        //$schemes = DB::table('tbl_scheme')->get();

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
       
       //dd($super_team);
        return view('scheme.schemes', ['schemes' => $schemes,'teams'=>$super_team]);
        //return view('dashboard/master');
        // return view('production/productions');
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
            'team'=>'required'
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


        if ($request->has('video')) {
            $video = $request->file('video');
            $fileName_video = time() . rand(1, 99) . '.' . $video->extension();
            // $filename = $video->getClientOriginalName();
            $video->move(public_path('video'), $fileName_video);
        } else {
            $fileName_video = NULL;
        }

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
        $store_scheme->video =  $fileName_video;
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

        $store_scheme->save();

        for ($i = 1; $i <= intval($request->plot_count); $i++) {

            $records = [
                "public_id" => Str::random(6),
                "plot_no" => $i,
                "production_id" =>  $request->production_id,
                "scheme_id" =>  $store_scheme->id,
                "booking_time"=>Carbon::now()
            ];

            PropertyModel::insert($records); // Eloquent approach
        }

        return redirect('/schemes')->with('status', 'Scheme Added Successfully !!');
    }

    public function destroyScheme($id)
    {

        $update = DB::table('tbl_scheme')->where('public_id', $id)->limit(1)->update(['status' => 3]);
        if ($update) {
            return redirect('/schemes')->with('status', 'Scheme Deleted Successfully !!');
        }
    }

    public function viewScheme($id)
    {

        $properties = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_property.description','tbl_property.other_info', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_property.booking_status as property_status', 'tbl_property.booking_status as status', 'tbl_property.attributes_data', 'tbl_property.user_id', 'tbl_property.management_hold')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.id', $id)->whereIn('tbl_property.status',[1,2,0])
            ->get();

        // dd($properties);    

        $scheme_detail = DB::table('tbl_scheme')
            ->where('tbl_scheme.id', $id)
            ->first();
          //  dd(Auth::user()->public_id);
        // dd(json_decode($property->attributes_data));
         //dd($scheme_detail);
        $current_time = now();
        // echo $current_time->format('h');
        // exit;
        return view('scheme.properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail, 'current_time' => $current_time->format('h'), 'time' => '9']);
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

        // dd(json_decode($property->attributes_data));
        // dd($properties);

        return view('scheme.list_properties', ['properties' => $properties, 'scheme_detail' => $scheme_detail]);
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

        return view('scheme.scheme', ['scheme_details' => $scheme_details, "images" => $imgArray]);
    }

    public function viewProperty($id)
    {

        $property = DB::table('tbl_property')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_property.plot_desc as description', 'tbl_property.attributes_data')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $id)
            ->first();

        // dd(json_decode($property->attributes_data));

        return view('scheme.update-property', ['property' => $property]);
    }

    public function propertyStatus(Request $request)
    {
        // dd($request);
        //DB::enableQueryLog();
        // $status = DB::table('tbl_property')
        //     ->where('public_id', $request->property_id)
        //     ->update(['status' => $request->property_status, 'user_id' => Auth::user()->public_id]);
        // return redirect('/scheme/view-scheme/' . $request->scheme_id)->with('status', 'Plot booked successfully');
        //$query = DB::getQueryLog();
        //dd(end($query));
        // dd($request);
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
        return view('scheme.book-hold-property', ['property_data' => $request]);
    }

    public function propertyBookHold(Request $request)
    {

        return view('scheme.book-hold-property', ['property_data' => $request]);
    }

    public function propertyHold(Request $request)
    {

        return view('scheme.hold-property', ['property_data' => $request]);
    }

    public function bookProperty(Request $request)
    {
           
            //dd($request->owner_namelist);
            
            //  if(empty($request->owner_namelist[0])){
            // echo('heelo');
            // }else{
            //     echo('yes');
            // }
            // die();
         //dd($request);
        //$request->property_id
        $booking_status = DB::table('tbl_property')->where('public_id', $request->property_id)->first();
        // dd($booking_status->booking_status);
        // if($booking_status->booking_status ==3 || $booking_status->associate_rera_number == $request->associate_rera_number)
        // {
            
        // }

        if ($booking_status->booking_status != 2 && $booking_status->booking_status != 3) {
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
                            // $taxdataArr['public_id']=Str::random(6);
                            // $taxdataArr['plot_public_id']=$request->property_id;
                            // $taxdataArr['booking_status']=$request->ploat_status;;
                            // $taxdataArr['payment_mode']= $payment_modelist[$key] ? $payment_modelist[$key] : 0;
                            // $taxdataArr['description']=$request->description;
                            // $taxdataArr['owner_name']=$owner_namelist[$key];
                            // $taxdataArr['contact_no']=$contact_nolist[$key];
                            // $taxdataArr['address']=$addresslist[$key];
                            // $taxdataArr['pan_card']=$pan_cardlist[$key];

                           

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
    
                            // $taxdataArr['pan_card_image']=$fileName_pan;
                            // $taxdataArr['adhar_card']=$fileName_adhar;
                            // $taxdataArr['cheque_photo']=$fileName_cheque;
                            // $taxdataArr['attachment']=$fileName_att;
     
    
                            //DB::table('customers')->insert($taxdataArr);

    
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
                //dd($scheme_details);
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
                    
                    
                //     $data=['name'=>Auth::user()->name,'plot_no'=>$booking_status->plot_no,'scheme_name'=>$scheme_details->scheme_name];
                // $user['to']=Auth::user()->email;
                // Mail::send('Email/bookedplotdetails',$data,function($messages) use ($user){
                //     $messages->to($user['to']);
                //     $messages->subject("Plot Book Details");
                // });
                }
           // return redirect()->action([SchemeController::class, 'index']);
             return redirect('/schemes')->with('status', 'Property details update successfully');
             
        }elseif(($booking_status->booking_status == 3) || ($booking_status->associate_rera_number == $request->associate_rera_number)) {
        
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
                            // $taxdataArr['public_id']=Str::random(6);
                            // $taxdataArr['plot_public_id']=$request->property_id;
                            // $taxdataArr['booking_status']=$request->ploat_status;;
                            // $taxdataArr['payment_mode']= $payment_modelist[$key] ? $payment_modelist[$key] : 0;
                            // $taxdataArr['description']=$request->description;
                            // $taxdataArr['owner_name']=$owner_namelist[$key];
                            // $taxdataArr['contact_no']=$contact_nolist[$key];
                            // $taxdataArr['address']=$addresslist[$key];
                            // $taxdataArr['pan_card']=$pan_cardlist[$key];

                           

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
    
                            // $taxdataArr['pan_card_image']=$fileName_pan;
                            // $taxdataArr['adhar_card']=$fileName_adhar;
                            // $taxdataArr['cheque_photo']=$fileName_cheque;
                            // $taxdataArr['attachment']=$fileName_att;
     
    
                            //DB::table('customers')->insert($taxdataArr);

    
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
                //dd($scheme_details);
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
                    
                    
                //     $data=['name'=>Auth::user()->name,'plot_no'=>$booking_status->plot_no,'scheme_name'=>$scheme_details->scheme_name];
                // $user['to']=Auth::user()->email;
                // Mail::send('Email/bookedplotdetails',$data,function($messages) use ($user){
                //     $messages->to($user['to']);
                //     $messages->subject("Plot Book Details");
                // });
                }
           // return redirect()->action([SchemeController::class, 'index']);
             return redirect('/schemes')->with('status', 'Property details update successfully');
        }else{
            return redirect('/schemes')->with('status', 'Plot already booked/Hold');
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
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.status as property_status','tbl_property.plot_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.id as property_id', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.booking_status', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
               
                //->orWhere('booking_status', 3)
                //->orWhere('booking_status', 4)
                ->where('tbl_property.scheme_id', $request->scheme_id)->get();
            //dd($book_properties);
            return view('scheme.reports', ['book_properties' => $book_properties, 'schemes' => $schemes]);
        } else {
            $schemes = DB::table('tbl_scheme')->where('status', 1)->get();
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
 
 $multi_customer = DB::table('customers')->where('plot_public_id',$id)->ORDERBY('id', 'DESC')->limit($min)->get();
            //dd($multi_customer);


         //dd($propty_report_detail);
        return view('scheme.report-detail', ['propty_report_detail' => $propty_report_detail,'other_owner'=>$multi_customer]);

    }


    public function associatePropertyReports(Request $request)
    {

        // dd($request);

        // dd(Auth::user()->public_id);
        // if (Auth::user()->user_type == 1) {

        //     $users = DB::table('users')->where('user_type', 2)->get();

        //     $book_properties = DB::table('tbl_property')->where('user_id', Auth::user()->public_id)->get();
        //     return view('scheme.associate-reports', ['book_properties' => $book_properties, 'users' => $users]);
        // } else {
        //     $book_properties = DB::table('tbl_property')->where('user_id', Auth::user()->public_id)->get();
        //     return view('scheme.associate-reports', ['book_properties' => $book_properties]);
        // }

        //$users = DB::table('users')->where('user_type', 2)->get();
        // $book_properties = null;
        // $users = DB::table('users')->where('user_type', 2)->get();
        // if ($request->user_id) {
        //     if (Auth::user()->user_type == 1) {
        //         $book_properties = DB::table('tbl_property')->where('user_id', $request->user_id)->get();
        //         // dd($book_properties);

        //     }
        // }

        // dd(Auth::user()->public_id);


        if (Auth::user()->user_type == 1) {
            $propty_report_details = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->get();
        } else {
            $propty_report_details = DB::table('tbl_property')
                ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.management_hold', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no', 'tbl_property.owner_name', 'tbl_property.contact_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.booking_status', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_time')
                ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->whereIn('booking_status', [2, 3, 4, 5, 6])
                ->where('tbl_property.user_id', Auth::user()->public_id)->get();
        }


         //dd( $propty_report_details);
        // $scheme_detail = DB::table('tbl_property')
        // ->where('status', 1)->where('user_id', Auth::user()->public_id)
        // ->get();
        return view('scheme.associate-reports', ['propty_report_details' => $propty_report_details]);
        // return view('scheme.associate-reports', ['propty_report_details' => $propty_report_details, 'users' => $users]);
    }

    public function editScheme($id)
    {

        $productions = DB::table('tbl_production')->get();

        $scheme_detail = DB::table('tbl_scheme')
            ->where('status', 1)->where('public_id', $id)
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
        //  echo"<pre>";
        //  print_r($request);
        //  die();
       //  dd($request);
        $validatedData = $request->validate([
            'scheme_name' => 'required',
            'location' => 'required',
            'description' => 'required',
           
        ]);

       // $store_scheme = new SchemeModel;

        // $status = DB::table('tbl_scheme')
        //     ->where('public_id', $request->scheme_id)
        //     ->update([
        //         'production_id' => $request->production_id,
        //         'scheme_name' => $request->scheme_name,
        //         'scheme_description' => $request->description,
        //         'location' => $request->location,
        //         'bank_name' =>  $request->bank_name,
        //         'account_number' =>  $request->account_number,
        //         'ifsc_code' => $request->ifsc_code,
        //         'branch_name' => $request->branch_name,


        //     ]);

        $scheme_details = DB::table('tbl_scheme')->where('public_id', $request->scheme_id)->get();

        //dd($scheme_details[0]->scheme_images);
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
                // $filename = $ppt->getClientOriginalName();
                $ppt->move(public_path('ppt'), $fileName_ppt);
            } else {
                $fileName_ppt = $scheme_details[0]->ppt;
            }
    
    
            if ($request->has('video')) {
                $video = $request->file('video');
                $fileName_video = time() . rand(1, 99) . '.' . $video->extension();
                // $filename = $video->getClientOriginalName();
                $video->move(public_path('video'), $fileName_video);
            } else {
                $fileName_video = $scheme_details[0]->video;
            }
    
            if ($request->has('jda_map')) {
                $jda_map = $request->file('jda_map');
                $fileName_jda_map = time() . rand(1, 99) . '.' . $jda_map->extension();
                // $filename = $jda_map->getClientOriginalName();
                $jda_map->move(public_path('jda_map'), $fileName_jda_map);
            } else {
                $fileName_jda_map = $scheme_details[0]->jda_map;
            }
    
            if ($request->has('other_docs')) {
                $other_docs = $request->file('other_docs');
                $fileName_other_docs = time() . rand(1, 99) . '.' . $other_docs->extension();
                // $filename = $other_docs->getClientOriginalName();
                $other_docs->move(public_path('other_docs'), $fileName_other_docs);
            } else {
                $fileName_other_docs = $scheme_details[0]->other_docs;
            }
    
            if ($request->has('pra')) {
                $pra = $request->file('pra');
                $fileName_pra = time() . rand(1, 99) . '.' . $pra->extension();
                // $filename = $pra->getClientOriginalName();
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
            // echo"<pre>";
            // print_r($filename);
            // die();
           
            // dd($img_arr_string);
           
    
            $status = DB::table('tbl_scheme')
            ->where('public_id', $request->scheme_id)
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
                'video' =>  $fileName_video,
                'jda_map' =>  $fileName_jda_map,
                'other_docs' =>  $fileName_other_docs,
                'pra' =>  $fileName_pra,
                'scheme_images' => $img_arr_string,
                'team'=>$request->team,

            ]);
        return redirect('/schemes')->with('status', 'Scheme Updated Successfully !!');
    }
    
     public function propertyStatuscancel($propertyId)
    {
        // dd($propertyId);
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')

            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.status', 1)
            ->where('tbl_property.public_id', $propertyId)
            ->first();
        //dd($property_details);
        return view('property.property-cancel-reson', ['property_details' => $property_details]);
        // dd($propertyId);
    }

    public function propertyCancel(Request $request)
    {
        $validatedData = $request->validate([
            'other_info' => 'required'
        ]);
        $timeto= Carbon::createFromFormat('H:i:s', '09:30:00')->format('H:i:s');;
        $timefrom= Carbon::createFromFormat('H:i:s', '18:15:00')->format('H:i:s');
        $time= now()->format('H:i:s');
        // echo "<pre>";
        // print_r($timeto);
        // print_r($timefrom);
        // print_r($time);
        // die();
        if(($timeto <= now()->format('H:i:s'))&&( $timefrom >= now()->format('H:i:s') )){
        // dd($request->id);
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
           }elseif(Auth::user()->user_type == 2){
               
        
            $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
            $name=$production->production_name;
           }else{
               $name=Auth::user()->name;
           }
           
           $proail = DB::table('tbl_property')->where('tbl_property.public_id', $request->property_public_id)->first();
           $statushji = $proail->booking_status;
        
           $status = DB::table('tbl_property')
            ->where('public_id', $request->property_public_id)
            ->update([
                'booking_status' => 4,
                'management_hold' => 0,
                'booking_time' =>  Carbon::now(),
                'associate_name'=> $name,
                'cancel_reason'=>$request->other_info,
                'cancel_by'=>$name,
                'cancel_time'=>Carbon::now()
            ]);
        // dd($status);
        $propty_report_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.user_id','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_status')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->property_public_id)->first();
           // dd($propty_report_detail);
       $usered =DB::table('users')->where('public_id',$propty_report_detail->user_id)->first();

       if(isset($usered)){
       
                    $email = $usered->email;
                     $mailData = [
                        'title' => 'Plot Booking Canceled',
                        'name'=>$name,
                        'plot_no'=>$propty_report_detail->plot_no,
                        'scheme_name'=>$propty_report_detail->scheme_name,
                        'status'=>$statushji
                    ];
                    $hji= 'bookedplotcancel';   $subject = 'Plot Booking Canceled';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
       }
       //dd($name);
        //     $data=['name'=>$name,'plot_no'=>$propty_report_detail->plot_no,'scheme_name'=>$propty_report_detail->scheme_name];
        // $user['to']=$usered->email;
        // Mail::send('Email/bookedplotcancel',$data,function($messages) use ($user){
        //     $messages->to($user['to']);
        //     $messages->subject("Plot Booking Canceled");
        // });
       
        $users= DB::table('users')->where('status',1)->get();
            foreach($users as $list){
                $mailData=['title' => 'Plot Booking Canceled','plot_no'=>$propty_report_detail->plot_no,'scheme_name'=>$propty_report_detail->scheme_name];
                $email = $list->email;
                $hji= 'cancelemail';   $subject = 'Plot Available';
                Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
            }


        
           // return redirect()->action([SchemeController::class, 'index']);
             return redirect('/schemes')->with('status', 'Property details update successfully');
    }else{
        return redirect('/schemes')->with('status', 'Plot Booking cancelation time between 09:30 AM to 06:15 PM');
    }
       // return view('scheme.report-detail', ['propty_report_detail' => $propty_report_detail])->with('status', 'Plot Cancel Successfully !!');
    }

    public function propertyComplete(Request $request)
    {

        // dd($request->id);
       if(Auth::user()->user_type == 1){
            $name="Super Admin";
           }elseif(Auth::user()->user_type == 2){
               
        
            $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
            $name=$production->production_name;
           }else{
               $name=Auth::user()->name;
           }
        $status = DB::table('tbl_property')
            ->where('public_id', $request->id)
            ->update([
                'booking_status' => 5,
                'associate_name'=> $name,
                'booking_time' =>  Carbon::now(),
                'management_hold'=>null,
            ]);

            $propty_report_detail = DB::table('tbl_property')
            ->select('tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name','tbl_property.gaj', 'tbl_property.user_id','tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status', 'tbl_property.plot_no', 'tbl_property.associate_name', 'tbl_property.associate_number', 'tbl_property.associate_rera_number', 'tbl_property.public_id as property_public_id', 'tbl_property.booking_status')
            ->leftJoin('tbl_scheme', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_property.public_id', $request->id)->first();
            //dd($propty_report_detail->gaj);
            
            
            $usered =DB::table('users')->where('public_id',$propty_report_detail->user_id)->first();
            
            
        if(isset($usered)){
            
               $usermodel=DB::table('users')->where('public_id',$propty_report_detail->user_id)
               ->update(['gaj'=>$usered->gaj + $propty_report_detail->gaj]);
          
                    $email = $usered->email;
                     $mailData = [
                        'title' => 'Plot Booking Complete',
                        'name'=>$name,
                        'plot_no'=>$propty_report_detail->plot_no,
                        'scheme_name'=>$propty_report_detail->scheme_name,
                    ];
                    $hji= 'bookedplotcomplete';   $subject = 'Plot Booking Complete';
                    Mail::to($email)->send(new EmailDemo($mailData,$hji,$subject));
       
            }
            
            // dd($statusd->gaj);
            // $data=['name'=>$name,'plot_no'=>$propty_report_detail->plot_no,'scheme_name'=>$propty_report_detail->scheme_name];
            // $user['to']=$usered->email;
            // Mail::send('Email/bookedplotcomplete',$data,function($messages) use ($user){
            //     $messages->to($user['to']);
            //     $messages->subject("Plot Booking Complete");
            // });
            return redirect('/schemes')->with('status', 'Property details update successfully');
        //return view('scheme.report-detail', ['propty_report_detail' => $propty_report_detail])->with('status', 'Plot Completed Successfully !!');
    }

    public function propertyStatusForManagment($propertyId)
    {
        // dd($propertyId);
        $property_details = DB::table('tbl_scheme')
            ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')

            ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
            ->where('tbl_scheme.status', 1)
            ->where('tbl_property.public_id', $propertyId)
            ->first();
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
            ->where('tbl_scheme.status', 1)
            ->where('tbl_property.public_id', $propertyId)
            ->first();
        //dd($property_details);
        return view('property.property-delete-reson', ['property_details' => $property_details]);
        // dd($propertyId);
    }

    public function propertyplotdelete( Request $request)
    {
        // dd($propertyId);
        // $property_details = DB::table('tbl_scheme')
        //     ->select('tbl_property.public_id as property_public_id', 'tbl_scheme.public_id as scheme_public_id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')

        //     ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')
        //     ->where('tbl_scheme.status', 1)
        //     ->where('tbl_property.public_id', $propertyId)
        //     ->first();
        //dd($property_details);
         if(Auth::user()->user_type == 1){
            $name="Super Admin";
           }elseif(Auth::user()->user_type == 2){
               
        
            $production = DB::table('tbl_production')->where('production_id', Auth::user()->id)->first();
            $name=$production->production_name;
           }else{
               $name=Auth::user()->name;
           }

        $status = DB::table('tbl_property')
            ->where('public_id', $request->property_public_id)
            ->update([
                'status' => 3,
                'cancel_reason'=>$request->other_info,
                 'cancel_time'=>Carbon::now(),
                  'associate_name'=> $name,
                
            ]);
            return redirect('/schemes')->with('status', 'Property details update successfully');
        // dd($propertyId);
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
        $status = DB::table('tbl_property')

            ->where('public_id', $request->property_public_id)
            ->where('scheme_id', $request->scheme_id)
            ->where('plot_no', $request->plot_no)
            ->update(
                [
                    'booking_status' => $request->booking_status,
                    'management_hold' => $request->managment_hold_id,
                    'other_info' => $request->other_info,
                    'associate_name'=> $name,
                    'booking_time' =>  Carbon::now(),
                    'user_id'=>NULL,
                ]
            );
        return redirect('/schemes')->with('status', 'Managment hold done');
        // dd($request);
    }
}
