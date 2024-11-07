<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PropertyModel;
use Illuminate\Http\Request;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;
use App\Models\Notification;

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
}
