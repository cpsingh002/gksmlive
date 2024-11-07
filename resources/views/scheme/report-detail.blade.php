@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Complete Booking Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Report Details</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
        <div class="col-md-4 col-12">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> {{ session('status') }}</strong>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                   
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Scheme Name</th>
                                <td>{{$propty_report_detail->scheme_name}}</td>
                            </tr>

                            <tr>
                                <th>Plot/Shop Number</th>
                                <td>{{$propty_report_detail->plot_name}}</td>
                            </tr>


                            <tr>
                                <th>Name</th>
                                <td>{{$propty_report_detail->associate_name}}</td>
                            </tr>

                            <tr>
                                <th>Associate Contact Number</th>
                                <td>{{$propty_report_detail->associate_number}}</td>
                            </tr>

                            <tr>
                                <th>Associate Rera Number</th>
                                <td>{{$propty_report_detail->associate_rera_number}}</td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td>{{$propty_report_detail->owner_name}}</td>
                            </tr>
                            <tr>
                                <th>Customer Contact Number</th>
                                <td>{{$propty_report_detail->contact_no}}</td>
                            </tr>
                            <tr>
                                <th>Customer Address</th>
                                <td>{{$propty_report_detail->address}}</td>
                            </tr>
                             <tr>
                                <th>Payment Method</th>
                                <td>@if($propty_report_detail->payment_mode == 1) RTGS/IMPS @elseif($propty_report_detail->payment_mode == 2)Bank Transfer @elseif($propty_report_detail->payment_mode == 3) Cheque  @else<p>Not Selected</p> @endif</td>
                            </tr>
                            <tr>
                                <th>Customer Pan Card Details</th>
                                <td>{{$propty_report_detail->pan_card}} @if($propty_report_detail->pan_card_image !='')<a href="{{URL::to('/customer/pancard',$propty_report_detail->pan_card_image)}}" download target="_blank"><img src="{{URL::to('/customer/pancard',$propty_report_detail->pan_card_image)}}" class="ms-2" style="height:25px;width:45px;"></a>@endif </td>
                            </tr>
                            <tr>
                                <th>Customer Aadhaar Card Details</th>
                                <td>{{$propty_report_detail->adhar_card_number}}@if($propty_report_detail->adhar_card !='')<a href="{{URL::to('/customer/aadhar',$propty_report_detail->adhar_card)}}" download target="_blank"><img src="{{URL::to('/customer/aadhar',$propty_report_detail->adhar_card)}}" style="height:25px;width:45px;" class="ms-2"></a>@endif</td>
                            </tr>
                            <tr>
                                <th>Cheque Photo</th>
                                <td>@if($propty_report_detail->cheque_photo !='')<a href="{{URL::to('/customer/cheque',$propty_report_detail->cheque_photo)}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$propty_report_detail->cheque_photo)}}" style="height:25px;width:45px;" class="ms-2"></a>@endif</td>
                            </tr>
                            <tr>
                                <th>Attachment</th>
                                <td>@if($propty_report_detail->attachment !='')<a href="{{URL::to('/customer/attach',$propty_report_detail->attachment)}}" download target="_blank"><i class='far fa-file-alt'></i></a>@endif</td>
                            </tr>
                            

                        </tbody>
                    </table>
                    </div>
                </div>
                
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @if (Auth::user()->user_type != 4)
    
    @if($propty_report_detail->cancel_reason !='')
     <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18"> Cancel Report Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Report Details</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                   
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Reason</th>
                                <td>{{$propty_report_detail->cancel_reason}}</td>
                            </tr>
                            
                             <tr>
                                <th>Person</th>
                                <td>{{$propty_report_detail->cancel_by}}</td>
                            </tr>
                             <tr>
                                <th>Cancel Time</th>
                                <td>{{date('d-M-y H:i:s', strtotime($propty_report_detail->cancel_time))}}</td>
                            </tr>

                        </tbody>
                    </table>
                    </div>
                </div>
                
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endif
    @endif
    
        @if(isset($other_owner[0]))
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Other Owners Report Details</h4>

                

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            
                            <tr>
                                <th>Sr No.</th>
                                <th>Customer Name</th>
                                <th>Customer Contact Number</th>
                                <th>Customer Address</th>
                                <th>Customer Pan Card Details</th>
                                <th>Customer Addhar Card Details</th>
                                <th>Cheque Photo</th>
                                <th>Attachment</th>
                                
                            </tr>
                            @php $sn=1; @endphp
                              @foreach($other_owner as $list)
                                <tr>
                                  <th>{{$sn}}</th>
                                  <td>{{$list->owner_name}}</td>
                                  <td>{{$list->contact_no}}</td>
                                  <td>{{$list->address}}</td>
                                  <td>{{$list->pan_card}} @if($list->pan_card_image !='')<a href="{{URL::to('/customer/pancard',$list->pan_card_image)}}" download target="_blank"><img src="{{URL::to('/customer/pancard',$list->pan_card_image)}}"  class="ms-2" style="height:25px;width:45px;"></a>@endif</td>
                                  <td>{{$list->adhar_card_number}}
                                    @if($list->adhar_card !='')<a href="{{URL::to('/customer/aadhar',$list->adhar_card)}}" download target="_blank"><img src="{{URL::to('/customer/aadhar',$list->adhar_card)}}"  style="height:25px;width:45px;"></a>@endif</td>
                                  <td>@if($list->cheque_photo !='')<a href="{{URL::to('/customer/cheque',$list->cheque_photo)}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$list->cheque_photo)}}" style="height:25px;width:45px;"></a>@endif</td>
                                  <td>@if($list->attachment !='')<a href="{{URL::to('/customer/attach',$list->attachment)}}" download target="_blank"><i class='far fa-file-alt'></i></a>@endif</td>
                                  
                                </tr>
                                @php $sn++; @endphp
                              @endforeach
                            
                            

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endif

    @if(isset($paymentproof))
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Payment Proof Details</h4>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="example1 table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    
                                    <td>Payment Detail</td>
                                    <td>Payment Image</td>
                                    
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>    
                                <tr ed="{{$paymentproof->id}}">
                                    
                                    <td>{{$paymentproof->payment_details}}</td>
                                    <td><a href="{{URL::to('/customer/payment',$paymentproof->proof_image)}}" download target="_blank"><img src="{{URL::to('/customer/payment',$paymentproof->proof_image)}}" style="height:25px;width:45px;"></a></td>
                                
                                    <td>
                                    @if(in_array(Auth::user()->user_type,[1,2,3]))
                                        @if($paymentproof->status != 1)
                                        <a href="#"  class=" savepayment mt-1"  data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>
                                        @endif
                                        <a href="#"  onclick="change_password('{{$paymentproof->id}}','ver')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>
                                        <a href="#"  onclick="rebooking_date('{{$paymentproof->id}}')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-primary">Rebooking Date</button></a>  
                                    @endif
                                    </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @endif



    @if(isset($plothistories[0]))
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Property History From Last 7 days Details</h4>

                

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            
                            <tr>
                                <th>Sr No.</th>
                                <th>Plot No</th>
                                <th>Action by</th>
                                <th>Name</th>
                                <th>contact number</th>
                                <th>Action</th>
                                <th>Time</th>
                            </tr>
                            @php $sn=1; @endphp
                            @php
                                $user_type = [
                                        1 => 'Super Admin',
                                        2 => 'Production House',
                                        3 => 'Opertor',
                                        4=>  'Assocaite',
                                        5 => 'Visitor',
                                        ];
                                        @endphp
                            
                              @foreach($plothistories as $data)
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{$data->plotdata->plot_type}}-{{$data->plotdata->plot_name}}</td>
                                    <td>@if($data->action_by == '') Cronjob @else {{$user_type[$data->userdata->user_type]}} @endif</td>
                                    <td>@if($data->action_by == '') -- @else {{$data->userdata->name}} @endif</td>
                                    <td>@if($data->action_by == '') -- @else {{$data->userdata->mobile_number}} @endif</td>
                                    <td>{{$data->action}}</td>
                                    <td>{{date('d-M-Y H:i:s', strtotime($data->created_at))}}</td>
                                
                                </tr>
                                @php $sn++; @endphp
                              @endforeach
                            
                            

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endif


</div> <!-- container-fluid -->

<div id="myModal123" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Payment Cancel Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" method="post" action="#" id="frmPaymnetCancel">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id"  id="extendid"/>
                    <p>Are you sure you want to delete this</p>
                    <div class="form-group" >
                        <label>Reason</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="text" name="reason" class="form-control @error('reason') is-invalid @enderror"  placeholder="Enter Reason" required>
                            
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group"  style="display:none" id="lunchdatebox">
                        <label> Set Re-Booking Time</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="datetime-local" id="dateto" name="dateto" value="" class="form-control @error('dateto') is-invalid @enderror">
                                @error('dateto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                              
                    </div>         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div id="myModal1234" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Rebooking Date Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" action="#" id="frmRebook">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id"  id="extendidr"/>
                    <p>Are you sure you want to change booking time for this booking ?</p>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" >
                                <label>Booking time</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="text" name="datefrom" class="form-control" value="{{date('d-M-Y H:i:s', strtotime($propty_report_detail->booking_time))}}" required readonly>
                                    @error('reason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>  
                        </div>
                        <div class="col-6">
                        <div class="form-group" >
                                <label> Set Re-Booking Time</label>
                                <div class="input-group auth-pass-inputgroup">
                                <input type="datetime-local" name="dateto" value="{{$propty_report_detail->booking_time}}" class="form-control @error('dateto') is-invalid @enderror" required>
                                    @error('dateto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group" >
                        <label>Reason</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="text" name="reason" class="form-control @error('reason') is-invalid @enderror"  placeholder="Enter Reason" required>
                            
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- End Page-content -->

 
@endsection
@push('scripts')
<script>

$(".savepayment").click(function(){
         var id =$(this).parents("tr").attr("ed");
    //alert(id);
 
         if(confirm('Are you sure you want to save this ?'))
         {
             $.ajax({
               url: '{{url('/save-payment')}}',
               type: 'GET',
               data: {id: id},
               error: function() {
                   alert('Something is wrong');
               },
               success: function(data) {
                     //$("#"+id).remove();
                     // alert("Your Booking Canceled request submitted successfully. You will get refund within 24 hours");
                     //alert("Booking confirmation mail resent successfully.")
                     window.location.reload();
                       
               }
             });
         }
     });
    function change_password(id){
        var ghh = id;
        var gt = type;

        if(gt == 'ver'){
        jQuery('#lunchdatebox').show();
        $('#dateto').attr('required',true);
        }
        jQuery("#extendid").val(ghh);
        //  alert(ghh);
        jQuery('#myModal123').modal('show');
    }
    function rebooking_date(id){
        var ghh = id;
        jQuery("#extendidr").val(ghh);
        //   alert(ghh);
        jQuery('#myModal1234').modal('show');
    }

    jQuery('#frmPaymnetCancel').submit(function(e){
        jQuery('#login_msg').html("");
        e.preventDefault();
        jQuery.ajax({
            url:'{{ route('payment.destroy') }}',
            data:jQuery('#frmPaymnetCancel').serialize(),
            type:'post',
            success:function(result){
                if(result.status=="error"){
                    jQuery('#login_msg').html(result.msg);
                }
                if(result.status=="success"){
                    window.location.reload();
                }
            }
        });
    });

    jQuery('#frmRebook').submit(function(e){
        e.preventDefault();
        jQuery.ajax({
            url:'{{route('plot.rebook')}}',
            data:jQuery('#frmRebook').serialize(),
            type:'post',
            success:function(result){
                if(result.status=="error"){
                    alert(result.msg);
                }
                if(result.status =="success"){
                    window.location.reload();
                }
            }
            
        });
    });
</script>
@endpush