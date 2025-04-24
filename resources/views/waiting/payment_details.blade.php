@extends("dashboard.master")

@section("content")

<div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Payment Proof</h4>
    
                    
    
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
        @if(isset($data))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-12">
    
                        </div>
                    </div>
                    @if(isset($data->id))
                    @php(
                            $user_type = [
                                    0 =>'aaa',
                                    1 => 'Super Admin',
                                    2 => 'Production House',
                                    3 => 'Operator',
                                    4=>  'Self',
                                    5 => 'Visitor',
                                    ]
                            )
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
    
                            <tbody>
                                
                                <tr>
                                    <th>SN</th>
                                    <th>Associate Name</th>
                                    <th>Associate Contact Number</th>
                                    <th>Associate Rera Number</th>
                                    <th>Payment Details</th>
                                    <th>Image</th>
                                    <th>Upload By</th>
                                    <th>Booking Time</th>
                                    <th>Action</th>
                                    
                                </tr>
                                
                                    <tr ed="{{$data->id}}">
                                      <th>1</th>
                                      <td>{{$data->associate_name}}</td>
                                      <td>{{$data->associate_number}}</td>
                                      <td>{{$data->associate_rera_number}}</td>
                                      <td>{{$data->payment_details}}</td>
                                      <td><a href="{{URL::to('/customer/payment',$data->proof_image)}}" download target="_blank"><img src="{{URL::to('/customer/payment',$data->proof_image)}}" style="height:25px;width:45px;"></a></td>
                                      <td>{{$data->name}}, [{{$user_type[$data->user_type]}}]</td>
                                      <td>{{date('d-M-y H:i:s', strtotime($data->booking_time))}}</td>
                                      <td>
                                      <!--<a onclick="return confirm('Are you sure you want to save this ?')" href="{{ route('payment.save', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>-->
                                      <!--<a onclick="return confirm('Are you sure you want to delete this ?')" href="{{ route('payment.destroy', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>  -->
                                      @if(!in_array(Auth::user()->user_type, [5,6]))  
                                      @if($data->status != 1)
                                         <a href="#"  class="savepayment mt-1"  data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>
                                         <a href="#"  onclick="change_password('{{$data->id}}','unver')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>  
                                         @endif
                                         @if($data->status == 1)
                                            <a href="#"   onclick="change_password('{{$data->id}}','ver')" class="mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a>  
                                        @endif
                                        @endif
                                        </td>
                                    </tr>
                                  
                                
                                
    
                            </tbody>
                        </table>
                        </div>
                    </div>
                    @else
                    <p class="text-center"> No Payment Proof Uploaded Yet!</p>
                    @endif
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endif
    
    
</div> <!-- container-fluid -->

<!-- End Page-content -->
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
                        <label> Set Available Time</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="datetime-local" name="dateto" value="" id="dateto" class="form-control @error('dateto') is-invalid @enderror" >
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
 
  
  
  $(".deletepayment").click(function(){
         var id =$(this).parents("tr").attr("ed");
 //alert(id);
 
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
        function change_password(id,type){
            var ghh = id;
            jQuery("#extendid").val(ghh);
            //  alert(ghh);
            jQuery('#myModal123').modal('show');
            if(type == 'ver') {
                jQuery('#lunchdatebox').show();
                $('#dateto').attr('required',true);
            }
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
