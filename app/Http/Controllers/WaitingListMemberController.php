<?php

namespace App\Http\Controllers;

use App\Models\WaitingListMember;
use App\Models\Customer;
use App\Models\WaitingListCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Api\NotificationController;

class WaitingListMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->id);
        $scheme_id = $request->id;
        $plot_no = $request->plot;
        $data= WaitingListMember::where(['scheme_id'=>$scheme_id,'plot_no'=>$plot_no])->get();
        //dd($data);
        return view('waiting.waitinglists', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyWaiting(Request $request)
    {
       // dd($request->id);
         $data= WaitingListMember::find($request->id);
        //WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first()
        $asd = DB::table('tbl_property')->where(['scheme_id'=> $data->scheme_id,'plot_no'=>$data->plot_no])->first();
        $status = DB::table('tbl_property')->where(['scheme_id'=> $data->scheme_id,'plot_no'=>$data->plot_no])
                             ->update([
                                'waiting_list'=>$asd->waiting_list-1
                            ]);   
        $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$data->id)->get();
        if(isset($mulitu_customers[0])){
            foreach($mulitu_customers as $multi){
                $model1=WaitingListCustomer::find($multi->id);
                $model1->delete();
            }
        }
       
        $data->delete();
        return redirect('/admin/schemes')->with('status', 'Waiting booking  deleted successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveWaiting(Request $request)
    {
       // dd($request->id);
        $data= WaitingListMember::find($request->id);
        //WaitingListMember::where(['scheme_id'=>$asd->scheme_id,'plot_no'=>$asd->plot_no])->first()
        $asd = DB::table('tbl_property')->where(['scheme_id'=> $data->scheme_id,'plot_no'=>$data->plot_no])->first();
        
        $status = DB::table('tbl_property')->where(['scheme_id'=> $data->scheme_id,'plot_no'=>$data->plot_no])
                             ->update([
                                'associate_name' => $data->associate_name,
                                'associate_number' => $data->associate_number,
                                'associate_rera_number' => $data->associate_rera_number,
                                'booking_status' => $data->booking_status,
                                'payment_mode' => $data->payment_mode,
                                'booking_time' =>   Carbon::now(),
                                'description' => $data->description,
                                'owner_name' =>  $data->owner_name,
                                'contact_no' => $data->contact_no,
                                'adhar_card_number' =>$data->adhar_card_number,
                                'address' => $data->address,
                                'user_id' => $data->user_id,
                                'pan_card'=>$data->pan_card,
                                'pan_card_image'=>$data->pan_card_image,
                                'adhar_card'=>$data->adhar_card,
                                'cheque_photo'=>$data->cheque_photo,
                                'attachment'=> $data->attachment,
                                'other_owner'=>$data->other_owner,
                                'waiting_list'=>$asd->waiting_list-1
                            ]);   
        $mulitu_customers = WaitingListCustomer::where('waiting_member_id',$data->id)->get();
        if(isset($mulitu_customers[0])){
            foreach($mulitu_customers as $multi){
             $model=new Customer();
             $model->public_id = Str::random(6);
             $model->plot_public_id = $asd->public_id;
             $model->booking_status = $multi->booking_status;
             $model->associate = $data->associate_rera_number;
             $model->payment_mode =  $multi->payment_mode;
             $model->description = $multi->description;
             $model->owner_name =  $multi->owner_name;
             $model->contact_no = $multi->contact_no;
             $model->address = $multi->address;
             $model->pan_card= $multi->pan_card;
             $model->adhar_card_number= $multi->adhar_card_number;
             $model->pan_card_image = $multi->pan_card_image;
             $model->adhar_card= $multi->adhar_card;
             $model->cheque_photo= $multi->cheque_photo;
             $model->attachment= $multi->attachment;
             $model->save();
                $model1=WaitingListCustomer::find($multi->id);
                $model1->delete();
            }
        }
       
      $data->delete();
        $plot_details = DB::table('tbl_property')->where('public_id', $asd->public_id)->first();
        $scheme_details = DB::table('tbl_scheme')->where('id', $asd->scheme_id)->first();
        $usered =DB::table('users')->where('public_id',$plot_details->user_id)->first();
                $mailData = [
                    'title' => $plot_details->plot_type.' Book Details',
                    'name' => $usered->name,
                    'plot_no'=>$plot_details->plot_no,
                    'plot_name'=>$plot_details->plot_name,
                    'plot_type' =>$plot_details->plot_type,
                    'scheme_name'=>$scheme_details->scheme_name,
                ];
        $notifi = new NotificationController;
        $notifi->MoveNotification($mailData, $usered->device_token);
     // return redirect('/admin/schemes')->with('status', 'Plot assign to waiting assoicated successfully');
      return   redirect()->route('view.scheme', ['id' => $scheme_details->id])->with('status', 'Plot assign to waiting assoicated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WaitingListMember  $waitingListMember
     * @return \Illuminate\Http\Response
     */
    public function show(WaitingListMember $waitingListMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WaitingListMember  $waitingListMember
     * @return \Illuminate\Http\Response
     */
    public function edit(WaitingListMember $waitingListMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WaitingListMember  $waitingListMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaitingListMember $waitingListMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WaitingListMember  $waitingListMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaitingListMember $waitingListMember)
    {
        //
    }
}
