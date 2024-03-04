@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
        <div class="col-4">
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
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body bg-gradient1 rounded-2 text-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="text-white mb-3 lh-1 d-block text-truncate">Total Schemes</h3>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$schemesCount}}">{{$schemesCount}}</span>
                            </h4>
                        </div>
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+$20.9k</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body bg-gradient2 rounded-2 text-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="text-white mb-3 lh-1 d-block text-truncate">Total Users</h3>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$usersCount}}">{{$usersCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-danger text-danger">-29 Trades</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body bg-gradient3 rounded-2 text-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="text-white mb-3 lh-1 d-block text-truncate">Total Hold Units</h3>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$holdPropertyCount}}">{{$holdPropertyCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+ $2.8k</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body bg-gradient4 rounded-2 text-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="text-white mb-3 lh-1 d-block text-truncate">Total Book Units</h3>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$bookPropertyCount}}">{{$bookPropertyCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+2.95%</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row-->
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Teams Data</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table  class="example table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Team Name</td>
                                <td>Associates</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody> 
                            @php($count=1)
                            @foreach($teamdata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->team_name}}</td>
                                    <td><label class="bg-team px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td> <a href="{{ route('team.view', ['id' => $data->public_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray ">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Production House  Data</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Production House</td>
                                <td>Schemes</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @foreach($productiondata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->production_name}}</td>
                                    <td><label class="bg-production px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td> <a href="{{ url('/admin/schemes') }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray ">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Operator Data</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Production House</td>
                                <td>Operators</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody>
                             @php($count=1)
                            @foreach($opertordata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->production_name}}</td>
                                    <td><label class="bg-operator px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td> <a href="{{ url('/admin/opertor') }}" ata-toggle="tooltip" data-placement="top" title="View Operators"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Booked Units</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table  class="example table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Units</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody> 
                            @php($count=1)
                            @foreach($bookdata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->scheme_name}}</td>
                                    <td><label class="bg-info px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td> <a href="{{ route('view.scheme', ['id' => $data->id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray ">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Hold Units</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Units</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @foreach($holddata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->scheme_name}}</td>
                                    <td><label class="bg-pink px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td> <a href="{{ route('view.scheme', ['id' => $data->id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-4">
            <div class="card">
                <div class="card-header py-2 bg-lightgray ">
                    <div class="col-12">
                        <div class="text-center">
                            <h5 class="mb-0">Completed Units</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Units</td>
                                <td>Total Units</td>
                                <td>View</td>
                            </tr>
                        </thead>
                        <tbody>
                             @php($count=1)
                            @foreach($completedata as $data)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$data->scheme_name}}</td>
                                    <td><label class="bg-primary px-3 py-1 rounded-1 text-white">{{$data->user_count}}</label></td>
                                    <td><label class="bg-secondary px-3 py-1 rounded-1 text-white">{{$data->no_of_plot}}</label></td>
                                    <td> <a href="{{ route('view.scheme', ['id' => $data->id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a></td>
                                </tr>
                                @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-2  bg-danger">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0 text-white">Unverified Payment Proof</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example1 table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Unit Number</td>
                                <!--<td>Plot Number</td>-->
                                <td>Associate Name</td>
                                <td>Associate Number</td>
                                <td>Booking Time</td>
                                <td>Payment Detail</td>
                                <td>Payment Image</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @foreach($proofdata as $data)
                            <tr ed="{{$data->payment_id}}">
                                <td>{{$count}}</td>
                                <td>{{$data->scheme_name}}</td>
                                <td>{{$data->plot_name}}</td>
                                <!--<td><label class="bg-danger px-3 py-1 rounded-1 text-white">{{$data->plot_no}}</label></td>-->
                                <td>{{$data->associate_name}}</td>
                                <td>{{$data->associate_number}}</td>
                                <td>{{date('d-M-y H:i:s', strtotime($data->booking_time))}}</td>
                                <td>{{$data->payment_details}}</td>
                                <td><a href="{{URL::to('/customer/payment',$data->proof_image)}}" download target="_blank"><img src="{{URL::to('/customer/payment',$data->proof_image)}}" style="height:25px;width:45px;"></a></td>
                                <td>
                                    <a href="#"  class=" savepayment mt-1"  data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>
                                      <a href="#"  onclick="change_password('{{$data->payment_id}}')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>  
                                </td>
                            </tr>
                            @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-2  bg-success">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0 text-white">Verified Payment Proof</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example1 table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Unit Number</td>
                                <!--<td>Plot Number</td>-->
                                <td>Associate Name</td>
                                <td>Associate Number</td>
                                <td>Booking Time</td>
                                <td>Payment Detail</td>
                                <td>Payment Image</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @foreach($proofvdata as $data)
                            <tr ed="{{$data->payment_id}}">
                                <td>{{$count}}</td>
                                <td>{{$data->scheme_name}}</td>
                                <td>{{$data->plot_name}}</td>
                                <!--<td><label class="bg-success px-3 py-1 rounded-1 text-white">{{$data->plot_no}}</label></td>-->
                                <td>{{$data->associate_name}}</td>
                                <td>{{$data->associate_number}}</td>
                                <td>{{date('d-M-y H:i:s', strtotime($data->booking_time))}}</td>
                                <td>{{$data->payment_details}}</td>
                                <td><a href="{{URL::to('/customer/payment',$data->proof_image)}}" download target="_blank"><img src="{{URL::to('/customer/payment',$data->proof_image)}}" style="height:25px;width:45px;"></a></td>
                                <td>
                                     <a href="#"  onclick="change_password('{{$data->payment_id}}')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a> 
                                </td>
                            </tr>
                            @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-2  bg-primary">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0 text-white">Waiting Lists at Unit</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example1 table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Scheme Name</td>
                                <td>Unit Number</td>
                                <!--<td>Plot Number</td>-->
                                <td>Associate Name</td>
                                <td>Associate Number</td>
                                <td>Booking Time</td>
                               <td>Waiting</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @foreach($waitingdata as $data)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$data->scheme_name}}</td>
                                <td>{{$data->plot_name}}</td>
                                <!--<td><label class="bg-success px-3 py-1 rounded-1 text-white">{{$data->plot_no}}</label></td>-->
                                <td>{{$data->associate_name}}</td>
                                <td>{{$data->associate_number}}</td>
                                <td>{{date('d-M-y H:i:s', strtotime($data->booking_time))}}</td>
                               <td>{{$data->waiting_list}}</td>
                                <td>
                                     <a href="{{route('waiting_list',['id'=>$data->id,'plot'=>$data->plot_no ])}}"  class="mt-1 " data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm text-white bg-primary">View</button></a> 
                                </td>
                            </tr>
                            @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>


</div>

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@push('scripts')
<script>


 $('.example').DataTable(
		{
			"paging": true,
			"lengthChange":false,
			"searching": false
		}
	);
	
	$('.example1').DataTable(
		{
			"paging": true,
			"lengthChange":false,
			
		}
	);
	
	
  
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
 
  
  
  $(".deletepayment").click(function(){
         var id = jQuery("#extendid").val();
 alert(id);
 
         if(confirm('Are you sure you want to delete this ?'))
         {
             $.ajax({
               url: '{{url('/destroy-payment')}}',
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
 
   </script>
   
   <script>
   function change_password(id){
    var ghh = id;
   
        jQuery("#extendid").val(ghh);
    //  alert(ghh);
   jQuery('#myModal123').modal('show');
}
</script>
<script>
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
    </script>
   @endpush
