<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PropertyModel;
use Illuminate\Http\Request;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\Notification;

use App\Models\Customerlist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SchemeModel;

class CustomerController extends Controller
{
    
    public function destroy(Request $request)
    {
        //dd($request);
        $id = $request->id;
        $pid = $request->pid;
        //dd($id);
        $model= Customer::find($id);
        $model->delete();
        $modelproperty = PropertyModel::find($pid)->decrement('other_owner');
        
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Customer deleted  by user '. Auth::user()->name .'for property'.$pid .'.',
            'past_data' =>json_encode($model),
            'new_data' => null,
            'user_to' => null
            
        ]);
        return response()->json(['status'=>'success']);
        
    }
    
        public function removeimage(Request $request)
    {
        //dd($request->id);
        $par = $request->par;
        $image = $request->image;
        $model = Customer::where('id', $request->id)->first();
        if($par === 'adh')
        {
            $status = Customer::where('id', $request->id)->update(['adhar_card' => null]);
            unlink('customer/aadhar'.'/'.$image);
                
        }elseif($par === 'pan')
        {
            $status = Customer::where('id', $request->id)->update(['pan_card_image' => null]);
            unlink('customer/pancard'.'/'.$image);
        }elseif($par === 'che')
        {
            $status =Customer::where('id', $request->id)->update(['cheque_photo' => null]);
            unlink('customer/cheque'.'/'.$image);
        }elseif($par === 'att')
        {
            $status = Customer::where('id', $request->id)->update(['attachment' => null]);
            unlink('customer/attach'.'/'.$image);
        }
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'Customer images deleted by user '. Auth::user()->name .'for cutomer id'.$request->id .'.',
            'past_data' =>json_encode($model),
            'new_data' => json_encode(Customer::find($request->id)),
            'user_to' => null
            
        ]);
        return redirect()->back();
    }
    
    
    public function CustomerList(Request $request)
    {
        // if(Auth::user()->user_type == 4){
            $id = Auth::user()->id;
            $teamdta=DB::table('teams')->where('super_team',1)->pluck('teams.public_id')->toArray();
            // dd($teamdta);
            
            if((Auth::user()->all_seen != 1)&&(!in_array(Auth::user()->team, $teamdta)))
            {
                $schemes = SchemeModel::select('tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
                ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')
                ->where('tbl_scheme.status', 1)->where('tbl_scheme.team', Auth::user()->team)->get();
                    
            }else{
                    $schemes = DB::table('tbl_scheme')
                ->select('tbl_production.public_id as production_public_id', 'tbl_scheme.team as scheme_team','tbl_scheme.public_id as scheme_public_id', 'tbl_scheme.scheme_name as scheme_name', 'tbl_production.production_name', 'tbl_scheme.id as scheme_id', 'tbl_scheme.status as scheme_status')
                ->leftJoin('tbl_production', 'tbl_scheme.production_id', '=', 'tbl_production.public_id')->where('tbl_scheme.status', 1)->get();
            }
            $customerlists = Customerlist::where('user_id',Auth::id())->get();
            // dd($schemes);
        // }

        return view('customerlist.index', ['customerlists' => $customerlists]);
    }
     public function CustomerListCreate(Request $request)
     {
        if(Auth::user()->user_type == 4){
            $id = Auth::user()->id;
            $teamdta=DB::table('teams')->where('super_team',1)->pluck('teams.public_id')->toArray();            
            if((Auth::user()->all_seen != 1)&&(!in_array(Auth::user()->team, $teamdta)))
            {
                $schemes = SchemeModel::where('tbl_scheme.status', 1)->where('tbl_scheme.team', Auth::user()->team)->get();
                    
            }else{
                    $schemes = SchemeModel::where('tbl_scheme.status', 1)->get();
            }
            // $customerlists = Customerlist::where('user_id',Auth::id())->get();
            // // dd($schemes);
        }elseif(in_array(Auth::user()->user_type, [2,5]))
        {
            $schemes= SchemeModel::select('tbl_scheme.*')->leftjoin('tbl_production','tbl_production.public_id','tbl_scheme.production_id')->where('tbl_production.production_id',Auth::user()->parent_id)->where('tbl_scheme.status', 1)->get();
            
        }elseif(in_array(Auth::user()->user_type, [3])){
            $schemes = SchemeModel::WhereIn('id',json_decode(Auth::user()->scheme_opertaor))->where('tbl_scheme.status', 1)->orderby('id','DESC')->get();
        }elseif(in_array(Auth::user()->user_type, [1,6]))
        {
            $schemes = SchemeModel::where('tbl_scheme.status', 1)->orderby('id','DESC')->get();
        }

        return view('customerlist.create', ['schemes' => $schemes]);
     }

     public function CustomerListStore(Request $request)
     {
        $request->validate([
            'adhar_card_number' => ['required','numeric','digits:12'],
            'contact_no' => ['required','numeric','digits:10'],
            'owner_name'=>'required',
            'scheme_id'=>['required','numeric','exists:tbl_scheme,id'],
        ]);
        $customerlists = Customerlist::where('user_id',Auth::id())->get();
        if($customerlists->count() >= 8)
        {
            return redirect('customerlist')->with('status', 'Maximum Customer count is 8, you cannot add more customer Please Delete previously added customer!!');
        }
        if($customerlists->where('scheme_id',$request->scheme_id)->count() >= 4)
        {
            return redirect('customerlist')->with('status', 'Maximum Customer count is 4 for one scheme, you cannot add more customer Please Delete previously added customer!!');
        }
        if($customerlists->where('scheme_id',$request->scheme_id)->where('adhar_card_number',$request->adhar_card_number)->count() >= 1)
        {
            return redirect('customerlist')->with('status', 'No Duplicate Aadhaar card allowed in same scheme!!');
        }
        $model = new Customerlist();
        $model->scheme_id = $request->scheme_id;
        $model->user_id = Auth::id();
        $model->adhar_card_number = $request->adhar_card_number;
        $model->contact_no = $request->contact_no;
        $model->owner_name = $request->owner_name;
        $model->booking_status = 2;
        $model->status = 1;
        $model->save();
        UserActionHistory::create([
            'user_id' => Auth::user()->id,
            'action' => 'New Customer added by user for scheme id '.$request->scheme_id.'.',
            'past_data' =>null,
            'new_data' => json_encode($model),
            'user_to' => null
        ]);
        return redirect('customerlist')->with('status', 'Customer saved Successfully!!');
        // dd($request);
     }

    public function CustomerlistDistroy(Request $request)
    {
        $customer = Customerlist::where('id',$request->id)->first();
        Customerlist::where('id',$request->id)->delete();

            UserActionHistory::create([
                'user_id' => Auth::user()->id,
                'action' => 'Customer from list deleted by user id',
                'past_data' =>json_encode($customer),
                'new_data' => null,
                'user_to' => null
            ]);
        return redirect()->back()->with('status', 'Customer Deleted Successfully!!');
    }
}
