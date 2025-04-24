@extends("dashboard.master")

@section("content")

<div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Waiting list Details</h4>
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
                        <table id="myTable" class="table table-bordered dt-responsive associateReportTbl w-100 ">
    
                            
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Customer Name</th>
                                    @if (Auth::user()->user_type != 4 )
                                    <th>Customer Addhar Number</th>@endif
                                    <th>Associate Name</th>
                                    <th>Associate Contact Number</th>
                                    <th>Associate Rera Number</th>
                                   
                                    <th>Booking Time</th>
                                     @if (in_array(Auth::user()->user_type,[1,2,3]))
                                    <th>Action</th>@endif
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @php 
                                $booking_status = [
                                2 => 'Booked',
                                3 => 'Hold'
                                ]
                            @endphp
                                @php $sn=2; @endphp
                                    <tr>
                                        <td>1</td>
                                        <td>{{$asd->owner_name}}</td>
                                       @if (Auth::user()->user_type != 4 )<td>{{$asd->adhar_card_number}}</td>@endif
                                        <td>{{$asd->associate_name}}</td>
                                      <td>{{$asd->associate_number}}</td>
                                      <td>{{$asd->associate_rera_number}}</td>
                                      <td>{{\Carbon\Carbon::parse($asd->booking_time)->format('d-M-y H:i:s.v')}}</td>
                                      
                                   
                                      <td>
                                      <a href="#" class="card-link fw-bold @if ($asd->booking_status == 2)text-success @else ($asd->booking_status == 3)text-danger @endif">{{@$booking_status[$asd->booking_status]}}</a>
                                            <!-- <button class="btn btn-sm btn-success">Main</button>         -->
                                      </td>
                                     
                                    </tr>
                                  @foreach($data as $list)
                                    <tr ed="{{$list->id}}">
                                      <td>{{$sn}}</td>
                                      <td>{{$list->owner_name}}</td>
                                       @if (Auth::user()->user_type != 4 )<td>{{$list->adhar_card_number}}</td>@endif
                                      <td>{{$list->associate_name}}</td>
                                      <td>{{$list->associate_number}}</td>
                                      <td>{{$list->associate_rera_number}}</td>
                                      <td>{{\Carbon\Carbon::parse($list->booking_time)->format('d-M-y H:i:s.v')}}</td>
                                      
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

<script>
jQuery.noConflict();
    $(document).ready(function() {
        // $('#myWatingTable').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copyHtml5',
        //         'excelHtml5',
        //         'csvHtml5',
        //         'pdfHtml5',
        //         'pageLength',
        //         {
        //         extend: 'pdfHtml5',
        //         orientation: 'landscape',
        //         pageSize: 'LEGAL'
        //     },
        //     ]
        // });
        
        // $('#myWatingTable').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copyHtml5',
        //         'excelHtml5',
        //         'csvHtml5',
        //         'pdfHtml5',
        //         'pageLength'
        //     ],
        //     "order": [[ 5, 'asc' ]]
        // });
        
        
        //  $('#datatable1').DataTable({
        //     dom: 'Bfrtip',
            
        //     "order": [[ 5, 'asc' ]]
        // });

        
    });
   
</script>
   @endpush