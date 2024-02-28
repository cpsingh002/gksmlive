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


</div> <!-- container-fluid -->

<!-- End Page-content -->

 
@endsection