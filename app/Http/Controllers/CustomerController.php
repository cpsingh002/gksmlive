<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PropertyModel;
use Illuminate\Http\Request;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
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
            'action' => 'Customer deleted  by user '. Auth::user()->name .'for plot'.$pid .'.',
        ]);
        return response()->json(['status'=>'success']);
        
    }
    
        public function removeimage(Request $request)
    {
        //dd($request->id);
        $par = $request->par;
        $image = $request->image;
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
        
        return redirect()->back();
    }
}
