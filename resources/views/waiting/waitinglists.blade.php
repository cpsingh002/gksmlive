@extends("dashboard.master")

@section("content")

<div class="container-fluid">
    @if(isset($data[0]))
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Waiting list Details</h4>
    
                    
    
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
                                    <th>SN</th>
                                    <th>Customer Name</th>
                                    @if (Auth::user()->user_type != 4 )
                                    <th>Customer Addhar Number</th>@endif
                                    <th>Associate Name</th>
                                    <th>Associate Contact Number</th>
                                    <th>Associate Rera Number</th>
                                    <!--<th>Cheque_photo</th>-->
                                    <!--<th>Attachment</th>-->
                                    <th>Booking Time</th>
                                     @if (in_array(Auth::user()->user_type,[1,2,3]))
                                    <th>Action</th>@endif
                                    
                                </tr>
                                @php $sn=1; @endphp
                                  @foreach($data as $list)
                                    <tr ed="{{$list->id}}">
                                      <th>{{$sn}}</th>
                                      <td>{{$list->owner_name}}</td>
                                       @if (Auth::user()->user_type != 4 )<td>{{$list->adhar_card_number}}</td>@endif
                                      <td>{{$list->associate_name}}</td>
                                      <td>{{$list->associate_number}}</td>
                                      <td>{{$list->associate_rera_number}}</td>
                                      <!--<td>@if($list->cheque_photo !='')<a href="{{URL::to('/customer/cheque',$list->cheque_photo)}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$list->cheque_photo)}}" style="height:25px;width:45px;"></a>@endif</td>-->
                                      <!--<td>@if($list->attachment !='')<a href="{{URL::to('/customer/attach',$list->attachment)}}" download target="_blank"><i class='far fa-file-alt'></i></a>@endif</td>-->
                                      <td>{{date('d-M-y H:i:s', strtotime($list->booking_time))}}</td>
                                        <!--<td>{{$list->subCategories}}</td>-->
                                    @if(in_array(Auth::user()->user_type,[1,2,3]))
                                      <td>
                                            <a  onclick="change_save('{{$list->id}}')" href="#" data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Assign</button></a>
                                            <a onclick="change_distory('{{$list->id}}')" href="#" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a>  
                                      </td>
                                      @endif
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
    
    
</div> 

<!-- End Page-content -->
<div id="myModal123" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Waiting list Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" method="post" action="" id="frmPaymnetCancel">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id"  id="extendid"/>
                    <p>Are you sure you want to perform this action ?</p>
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
        function change_save(id,type){
            var ghh = id;
            jQuery("#extendid").val(ghh);
            //  alert(ghh);
            jQuery('#myModal123').modal('show');
            $("#frmPaymnetCancel").attr('action', '{{route('waiting.save')}}');
            
        }

        function change_distory(id,type){
            var ghh = id;
            jQuery("#extendid").val(ghh);
            jQuery('#myModal123').modal('show');
            $("#frmPaymnetCancel").attr('action', '{{route('waiting.destroy')}}');
        }
    </script>
<script>
// jQuery('#frmPaymnetCancel').submit(function(e){
//   jQuery('#login_msg').html("");
//   e.preventDefault();
//   jQuery.ajax({
//     url:'{{ route('payment.destroy') }}',
//     data:jQuery('#frmPaymnetCancel').serialize(),
//     type:'post',
//     success:function(result){
//       if(result.status=="error"){
//         jQuery('#login_msg').html(result.msg);
//       }
//       if(result.status=="success"){
//        window.location.reload();
//       }
//     }
//   });
// });
    </script>
   @endpush