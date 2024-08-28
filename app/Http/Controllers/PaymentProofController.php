<?php

namespace App\Http\Controllers;

use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\NotificationController;
use Mail;
use App\Mail\EmailDemo;
use App\Models\SchemeModel;
use App\Models\ProductionModel;
use App\Models\User;
use App\Models\PropertyModel;
use App\Models\UserActionHistory;
use App\Models\ProteryHistory;

class PaymentProofController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProofUplodStore(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
                            'payment_detail' => 'required',
                            'payment_proof' => 'required',
                        ],['payment_detail.required'=>'Pyment Proof method details are required',
                            'payment_proof.required'=>'Payment Proof Image required']);
        $property = PropertyModel::where('id',$request->id)->first();
        if($property->booking_status == 2){
            if($request->has('payment_proof')) {
                $paymentp = $request->file('payment_proof');
                $fileName = time() . rand(1, 99) . '.' . $paymentp->extension();
                $paymentp->move(public_path('customer/payment'), $fileName);
            }else{
                $fileName='';
            }
            $res = PaymentProof::where('property_id',$request->id)->first();
            if($res){
                if($res->status == '1'){
                    unlink('customer/payment'.'/'.$res->proof_image);
                    $res->payment_details = $request->payment_detail;
                    $res->proof_image = $fileName;
                    $res->status = 0;
                    $res->upload_by = Auth::user()->id;
                    $res->save();
                    $msg = "Payment  details update successfully";
                }else{
                    unlink('customer/payment'.'/'.$fileName);
                    $msg = "Last Payment details not verifiyed yet!";
                    return redirect()->back()->with('status', $msg);
                }
            }else{
                $model=new PaymentProof();
                $model->property_id = $request->id;
                $model->payment_details = $request->payment_detail;
                $model->proof_image = $fileName;
                $model->upload_by = Auth::user()->id;
                $model->save();
                $msg = "Payment  details upload successfully";
            }
        
            $property = PropertyModel::where('id',$request->id)->first();
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
                'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' Payment proof uploaded',
            ]);
            $notifi = new NotificationController;
            $notifi->PayMentPushNotification($mailData, $property->scheme_id, $property->production_id); 
            if(Auth::user()->user_type == 1){
                return redirect('/admin/schemes')->with('status', $msg);
            }elseif (Auth::user()->user_type == 2){ 
                return redirect('/production/schemes')->with('status', $msg);
            }elseif (Auth::user()->user_type == 3){ 
                return redirect('/opertor/schemes')->with('status', $msg);
            }elseif (Auth::user()->user_type == 4) {
                return redirect('/associate/schemes')->with('status', $msg);
            }
        }else{
            $msg = "Payment details not uploaded!";
            return redirect()->back()->with('status', $msg);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePayment(Request $request)
    {
        //dd($request->id);
        $res = PaymentProof::find($request->id);
        $res->status = 1;
        $res->save();
        
        $plot_details = DB::table('tbl_property')->where('id', $res->property_id)->first();
        $scheme_details = DB::table('tbl_scheme')->where('id', $plot_details->scheme_id)->first();
        $usered =DB::table('users')->where('public_id',$plot_details->user_id)->first();
        $mailData = [
            'title' => 'Payment Proof Varified by GKSM.',
            'name'=>$usered->name,
            'plot_no'=>$plot_details->plot_no,
            'plot_name'=>$plot_details->plot_name,
            'plot_type' =>$plot_details->plot_type,
            'scheme_name'=>$scheme_details->scheme_name,
            'by'=>Auth::user()->name,
            'mobile'=>$usered->mobile_number
        ];

        ProteryHistory ::create([
            'scheme_id' => $plot_details->scheme_id,
            'property_id'=>$plot_details->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' Payment has been approved',
        ]);
        $hji= 'acceptpayment';   $subject = $plot_details->plot_type.' Payment Proof Varified by GKSM';
        Mail::to($usered->email)->send(new EmailDemo($mailData,$hji,$subject));
        $notifi = new NotificationController;
        $notifi->PaymentNotification($mailData, $usered->device_token);
        $request->session()->flash('status','Payment details saved successfully');
        return response()->json(['status'=>"success"]);
        // if (Auth::user()->user_type == 1){
        //         return redirect('/admin/schemes')->with('status', 'Payment  details saved successfully');
        //     }elseif (Auth::user()->user_type == 2){ 
        //         return redirect('/production/schemes')->with('status', 'Payment details saved successfully');
        //     }elseif (Auth::user()->user_type == 3){ 
        //         return redirect('/opertor/schemes')->with('status', 'Payment details saved successfully');
        //     }elseif (Auth::user()->user_type == 4) {
        //         return redirect('/associate/schemes')->with('status', 'Payment details saved successfully');
        //     }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyPayment(Request $request)
    {
       // dd($request);
        $res = PaymentProof::find($request->id);
        $plot_details = DB::table('tbl_property')->where('id', $res->property_id)->first();
        $scheme_details = DB::table('tbl_scheme')->where('id', $plot_details->scheme_id)->first();
        $usered =DB::table('users')->where('public_id',$plot_details->user_id)->first();
        $mailData = [
            'title' => 'Payment Proof Canceled by GKSM.',
            'name'=>$usered->name,
            'plot_no'=>$plot_details->plot_no,
            'plot_name'=>$plot_details->plot_name,
            'plot_type' =>$plot_details->plot_type,
            'scheme_name'=>$scheme_details->scheme_name,
            'reason' => $request->reason,
             'by'=>Auth::user()->name,
             'mobile'=>$usered->mobile_number
        ];
        ProteryHistory ::create([
            'scheme_id' => $plot_details->scheme_id,
            'property_id'=>$plot_details->id,
            'action_by'=>Auth::user()->id,
            'action' => 'Scheme - '.$mailData['scheme_name'].', plot no- '.$mailData['plot_name'].' Payment cancelled /rejected',
        ]);
        $hji= 'cancelpaymnet';   $subject = $plot_details->plot_type.' Payment Proof Canceled by GKSM';
        Mail::to($usered->email)->send(new EmailDemo($mailData,$hji,$subject));
        $notifi = new NotificationController;
        $notifi->PaymentCancelNotification($mailData, $usered->device_token);
        $res->delete();
        $request->session()->flash('status','Payment  details deleted successfully');
        return response()->json(['status'=>"success"]);
        //   if (Auth::user()->user_type == 1){
        //         return redirect('/admin/schemes')->with('status', 'Payment  details deleted successfully');
        //     }elseif (Auth::user()->user_type == 2){ 
        //         return redirect('/production/schemes')->with('status', 'Payment details deleted successfully');
        //     }elseif (Auth::user()->user_type == 3){ 
        //         return redirect('/opertor/schemes')->with('status', 'Payment details deleted successfully');
        //     }elseif (Auth::user()->user_type == 4) {
        //         return redirect('/associate/schemes')->with('status', 'Payment details deleted successfully');
        //     }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentProof  $paymentProof
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentProof $paymentProof)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentProof  $paymentProof
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentProof $paymentProof)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentProof  $paymentProof
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentProof $paymentProof)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentProof  $paymentProof
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentProof $paymentProof)
    {
        //
    }
}
