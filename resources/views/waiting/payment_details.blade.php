@extends("dashboard.master")

@section("content")

<div class="container-fluid">
    @if(isset($data))
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-12">
    
                        </div>
                    </div>
                    @if(isset($data->id))
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
                                    <!--<th>Attachment</th>-->
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
                                      
                                      <td>{{date('d-M-y H:i:s', strtotime($data->booking_time))}}</td>
                                      <td>
                                      <!--<a onclick="return confirm('Are you sure you want to save this ?')" href="{{ route('payment.save', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>-->
                                      <!--<a onclick="return confirm('Are you sure you want to delete this ?')" href="{{ route('payment.destroy', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>  -->
                                         @if($data->status != 1)
                                         <a href="#"  class="savepayment mt-1"  data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Approve</button></a>
                                         <a href="#"  class="deletepayment mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Reject</button></a>  
                                         @endif
                                         @if($data->status == 1)
                                      <a href="#"  class="deletepayment mt-1" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a>  
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
   @endpush
