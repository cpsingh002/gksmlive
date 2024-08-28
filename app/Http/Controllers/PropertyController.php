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
        $schemes = DB::table('tbl_scheme')->select('tbl_scheme.id','tbl_scheme.scheme_name')->where('status', 1)->get();
        
        
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
        ]);
        $request->session()->flash('status','Rebooking date updated successfully');
        return response()->json(['status'=>"success"]);
    }


    public function FreezPlot(Request $request)
    {
        // dd($request);
        if(Auth::user()->user_type == 1){
            $name="Super Admin";
        }else{
            $name=Auth::user()->name;
        }
          // dd($name);
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 1]);
        $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $scheme = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
        $usered = User::where('public_id',$proerty->user_id)->first();
        $notifi = new NotificationController;
        $notifi->Mangementhold($usered->name,$usered->mobile_number);
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by Freez due to management decided .'
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
        $status = DB::table('tbl_property')->where('public_id', $request->id)->update(['freez' => 0,'booking_time'=>Carbon::now()]);
        $proerty = DB::table('tbl_property')->where('public_id', $request->id)->first();
        $scheme = DB::table('tbl_scheme')->where('id', $proerty->scheme_id)->first();
        ProteryHistory ::create([
            'scheme_id' => $proerty->scheme_id,
            'property_id'=>$proerty->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$scheme->scheme_name.' , plot no- '.$proerty->plot_name.' Plot by unFreez due to management decided .'
        ]);
        $request->session()->flash('status','Plot goes to Freez mode');
        return redirect()->back();
    }
}
