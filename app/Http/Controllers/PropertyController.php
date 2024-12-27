<?php

namespace App\Http\Controllers;

use App\Models\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ProteryHistory;
use App\Models\PaymentProof;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Api\NotificationController;
use App\Models\Notification;
use App\Models\UserActionHistory;
use App\Models\SchemeModel;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = DB::table('tbl_property')->get();
        return view('property.properties', ['properties' => $properties]);
    }

    public function addProperty()
    {
        $productions = DB::table('tbl_production')->get();
        $schemes = DB::table('tbl_scheme')->get();
        return view('property/add-property', ['productions' => $productions, 'schemes' => $schemes]);
    }


    // Store Contact Form data
    public function storeProperty(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'property_name' => 'required'
        ]);
        $save = new PropertyModel;
        $save->property_name = $request->property_name;
        $save->production_id = $request->production_id;
        $save->scheme_id = $request->scheme_id;
        $save->public_id = Str::random(6);

        // dd($save);
        $save->save();
        return redirect('/properties')->with('status', 'Ajax Form Data Has Been validated and store into database');
    }

    public function destroyProperty($id)
    {

        $update = DB::table('tbl_property')->where('public_id', $id)->limit(1)->update(['status' => 3]);
        if ($update) {
            return redirect('/properties')->with('status', 'Ajax Form Data Has Been validated and store into database');
        }
    }


    public function PlotHistory(Request $request)
    {
        // dd($request);
        $scheme_id='';
        $plot_id = '';
        $plothistories = [];
        $plots = [];
        if (isset($request->scheme_id)) {
            $scheme_id = $request->scheme_id;
            $plothistories = ProteryHistory::where('scheme_id',$request->scheme_id)->orderby('id','DESC')->get();
            $plots = PropertyModel::where('scheme_id',$request->scheme_id)->select('tbl_property.id','tbl_property.plot_name','tbl_property.plot_type')->get();
        }
        if(isset($request->plot_id))
        {
            $plot_id = $request->plot_id;
            $plothistories = ProteryHistory::where('scheme_id',$request->scheme_id)->where('property_id',$request->plot_id)->orderby('id','DESC')->get();
        }

            if(in_array(Auth::user()->user_type, [2,5]))
            {
                $schemes= SchemeModel::leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('tbl_scheme.status','!=', 3)->get();
                // dd($schemes);
                // $notices = Notification::WhereIn('scheme_id',$schemes)->where('created_at', Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [3])){
                $schemes = SchemeModel::WhereIn('id',json_decode(Auth::user()->scheme_opertaor))->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('status','!=', 3)->get();
                // $notices = Notification::WhereIn('scheme_id',json_decode(Auth::user()->scheme_opertaor))->where('created_at', Carbon::today())->orderby('id','DESC')->get();
            }elseif(in_array(Auth::user()->user_type, [1,6]))
            {
                $schemes = DB::table('tbl_scheme')->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('status','!=', 3)->get();
            }
        // $schemes = DB::table('tbl_scheme')->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('status', 1)->get();
        
        
        return view('property.property-history',['schemes'=>$schemes,'plothistories'=>$plothistories,'scheme_id'=>$scheme_id,'plot_id'=>$plot_id,'plots'=>$plots]);
    }

    public function Rebooking(Request $request)
    {
        $res = PaymentProof::find($request->id);
        $plot_details = PropertyModel::where('id', $res->property_id)->first();
        $scheme_details = DB::table('tbl_scheme')->where('id', $plot_details->scheme_id)->first();
        PropertyModel::where('id', $res->property_id)->update(['booking_time'=>$request->dateto]);
        ProteryHistory ::create([
            'scheme_id' => $plot_details->scheme_id,
            'property_id'=>$plot_details->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme_details->scheme_name.' , plot no- '.$plot_details->plot_name.' Booking date changed and re boooking date updated ',
            'past_data' =>json_encode($plot_details),
            'new_data' =>json_encode(PropertyModel::find($plot_details->id)),
            'name' =>$plot_details->owner_name,
            'addhar_card' =>$plot_details->adhar_card_number
        ]);
        $request->session()->flash('status','Rebooking date updated successfully');
        return response()->json(['status'=>"success"]);
    }


    public function FreezPlot(Request $request)
    {
        // dd($request);


        $property_details = DB::table('tbl_property')->where('public_id', $request->id)->first();
        return view('property.property_freez',['property_details'=>$property_details]);
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }else{
            $name=Auth::user()->name;
        }
          // dd($name);
          $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 1]);
        
        $scheme = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
        $usered = User::where('public_id',$proerty->user_id)->first();
        $notifi = new NotificationController;
        $notifi->Mangementhold($usered->name,$usered->mobile_number);
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by Freez due to management decided .',
            'past_data' =>json_encode($proerty),
            'new_data' =>json_encode(PropertyModel::find($proerty->id)),
            'name' =>$proerty->owner_name,
            'addhar_card' =>$proerty->adhar_card_number
        ]);

        Notification::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'msg_to'=>$usered->id,
            'action'=>'freez',
            'msg' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by Freez due to management decided .',
        ]);
        $request->session()->flash('status','Plot goes to Freez mode');
        return redirect()->back();
    }

    public function UnFreezPlot(Request $request)
    {
        // dd($request);
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }else{
            $name=Auth::user()->name;
        }
          // dd($name);

        $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $usered = User::where('public_id', $proerty->user_id)->first();
        $scheme = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 0,'booking_time'=>Carbon::now()]);
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by unFreez due to management decided .',
            'past_data' =>json_encode($proerty),
            'new_data' =>json_encode(PropertyModel::find($proerty->id)),
            'name' =>$proerty->owner_name,
            'addhar_card' =>$proerty->adhar_card_number
        ]);

        Notification::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'msg_to'=>$usered->id,
            'action'=>'Unfreez',
            'msg' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by unFreez due to management decided .',
        ]);
        $request->session()->flash('status','Plot goes to Freez mode');
        return redirect()->back();
    }


    public function FreezPlotReason(Request $request)
    {

        $validatedData = $request->validate([
            'other_info' => 'required',
        ],['other_info'=>'Reason required']);

        // dd($request);

        $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $usered = User::where('public_id', $proerty->user_id)->first();
        $scheme = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
        if($request->freeztype == "freez")
        {
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 1]);
            $msg = "Plot goes to Freez mode";
            $notifi = new NotificationController;
            $notifi->Mangementhold($usered->name,$usered->mobile_number);
            ProteryHistory ::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot  Freez with reason '.$request->other_info .' to management decided .',
                'past_data' =>json_encode($proerty),
                'new_data' =>json_encode(PropertyModel::find($proerty->id)),
                'name' =>$proerty->owner_name,
                'addhar_card' =>$proerty->adhar_card_number
            ]);

            Notification::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'msg_to'=>$usered->id,
                'action'=>'freez',
                'msg' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot  Freez with reason '.$request->other_info .'  to management decided .',
            ]);
        }
        if($request->freeztype == "unfreez")
        {
            $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 0,'booking_time'=>Carbon::now()]);
            $msg = "Plot goes to unFreez mode";
            ProteryHistory ::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot  unFreez with reason '.$request->other_info .'  to management decided .',
                'past_data' =>json_encode($proerty),
                'new_data' =>json_encode(PropertyModel::find($proerty->id)),
                'name' =>$proerty->owner_name,
                'addhar_card' =>$proerty->adhar_card_number
            ]);
    
            Notification::create([
                'scheme_id' => $proerty->scheme_id,
                'property_id'=>$proerty->id,
                'action_by'=>Auth::user()->id,
                'msg_to'=>$usered->id,
                'action'=>'Unfreez',
                'msg' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot  unFreez with reason '.$request->other_info .'  to management decided .',
            ]);
        }

        // $request->session()->flash('status','Plot goes to Freez mode');

        if(Auth::user()->user_type == 1){
            return redirect('/admin/schemes')->with('status', $msg);
        }elseif (Auth::user()->user_type == 2){ 
            return redirect('/production/schemes')->with('status', $msg);
        }elseif (Auth::user()->user_type == 3){ 
            return redirect('/opertor/schemes')->with('status', $msg);
        }
    }


    public function AdharProofUplod(Request $request)
    {
        $propertyId = $request->property_id;
        $property_details = DB::table('tbl_scheme')
        ->select('tbl_property.public_id as property_public_id', 'tbl_property.id as id', 'tbl_property.scheme_id as scheme_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_property.plot_no', 'tbl_scheme.id as scheme_id','tbl_property.adhar_card_number')
        ->leftJoin('tbl_property', 'tbl_scheme.id', '=', 'tbl_property.scheme_id')->where('tbl_scheme.status', 1)->where('tbl_property.public_id', $propertyId)->first();
        
        return view('property.aadhar_upload', ['property_details' => $property_details]);
    }

    public function AdharProofUplodStore(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
                            'payment_detail' => 'required',
                            'adhar_card' => 'required',
                        ],['payment_detail.required'=>'Pyment Proof method details are required',
                            'adhar_card.required'=>'Payment Proof Image required']);
        $property = PropertyModel::where('id',$request->id)->first();
        if($property->booking_status == 2){

            // $status = Customer::where('id', $request->id)->update(['adhar_card' => null]);
            // unlink('customer/aadhar'.'/'.$image);
            if ($request->has('adhar_card')) {
                $adhar_card = $request->file('adhar_card');
                $fileName_adhar = time() . rand(1, 99) . '.' . $adhar_card->extension();
                $adhar_card->move(public_path('customer/aadhar'), $fileName_adhar);
                PropertyModel::where('id',$request->id)->update(['adhar_card'=>$fileName_adhar]);
            }
            
        
            $scheme_details = DB::table('tbl_scheme')->where('id', $property->scheme_id)->first();
            $mailData = [
                'title' => $property->plot_type.' Book Details',
                'name'=>Auth::user()->name,
                'plot_no'=>$property->plot_no,
                'plot_name'=>$property->plot_name,
                'plot_type' =>$property->plot_type,
                'scheme_name'=>$scheme_details->scheme_name,
            ];
            ProteryHistory ::create([
                'scheme_id' => $property->scheme_id,
                'property_id'=>$property->id,
                'action_by'=>Auth::user()->id,
                'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' Adhaar card proof uploaded',
                'past_data' =>json_encode($property),
                'new_data' =>json_encode(PropertyModel::find($property->id)),
                'name' =>$property->owner_name,
                'addhar_card' =>$property->adhar_card_number
            ]);

            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'In Scheme -'.$mailData['scheme_name'].', Plot No-'.$mailData['plot_name'].'property id- '.$mailData['plot_no'].' by user '. Auth::user()->name .' Aadhar card Updated.',
                'past_data' =>json_encode($property),
                'new_data' =>json_encode(PropertyModel::find($property->id)),
                'user_to' => null
            ]);
            // $notifi = new NotificationController;
            // $notifi->PayMentPushNotification($mailData, $property->scheme_id, $property->production_id); 
            if(Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', 'Aadhar card details uploaded!');
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', 'Aadhar card details uploaded!');
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', 'Aadhar card details uploaded!');
            }elseif (Auth::user()->user_type == 4) {
                return redirect('/associate/schemes')->with('status', 'Aadhar card details uploaded!');
            }
        }else{
            $msg = "Aadhar card details not uploaded!";
            return redirect()->back()->with('status', $msg);
        }
    }


    public function PlotHistoryView(Request $request)
    {
        $data = ProteryHistory::where('id',$request->id)->first();
        // dd(json_decode($data->past_data, true));
        //   dd(($data->past_data)->toArray);
        return view('property.property-history-view',['data'=>$data]);
    }

    public function PlotHistoryViewNotification(Request $request)
    {
        $noti = Notification::where('id',$request->id)->first();
        // dd($noti);
        $data = ProteryHistory::where('created_at','>=',$noti->created_at)->where('scheme_id',$noti->scheme_id)->where('property_id',$noti->property_id)->first();
        // dd($data);
        // dd(json_decode($data->past_data, true));
        //   dd(($data->past_data)->toArray);
        return view('property.property-history-view',['data'=>$data]);
    }

}

