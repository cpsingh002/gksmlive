@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Associates</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Associates</li>-->
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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <a href="{{URL::to('/add-associate')}}" type="button" class="btn btn-success waves-effect waves-light">Add Associate</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="myTable" class="table table-bordered dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Associate Name</th>
                                <th>Associate Email</th>
                                <th>Associate Contact Number</th>
                                <th>Associate Rera Number</th>
                                <th>Team</th>
                                <th>Immediate Uplinner Name</th>
                                <th>Immediate Uplinner Rera Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($associates as $associate)

                            <tr>
                                <td> {{$count}} </td>
                                <td>{{$associate->name}}</td>
                                <!-- <td>{{$associate->public_id}}</td> -->
                                <td>{{$associate->email}}</td>
                                <td>{{$associate->mobile_number}}</td>
                                <td>{{$associate->associate_rera_number ? $associate->associate_rera_number : '-'}}</td>
                                <td>{{$associate->team_name}}</td>
                                 <td>{{$associate->applier_name}}</td>
                                <td>{{$associate->applier_rera_number}}</td>
                                <td class="{{$associate->status == 1 ? 'text-success' : 'text-danger'}}">{{$associate->status == 1 ? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a href="{{ url('edit-user', ['id' => $associate->public_id]) }}"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete associate ?')" href="{{ route('user.destroy', ['id' => $associate->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fas fa-recycle text-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    @if($associate->status == 1)
                                    <a href="{{ route('view.user', ['id' => $associate->public_id]) }}" data-toggle="tooltip" data-placement="top" title="View Info"><i class="fas fa-user-alt text-success"></i></a>
                                    @endif
                                    @if($associate->status !=5)
                                    <a onclick="return confirm('Are you sure you want to deactive associate ?')" href="{{ route('user.deactivate', ['id' => $associate->public_id, 'status' => 1]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    @else
                                    <a onclick="return confirm('Are you sure you want to active associate again ?')" href="{{ route('user.activate', ['id' => $associate->public_id, 'status' => 5]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate User"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Activate"></i></a>
                                    @endif
                                    
                                     <a class="change_password_btn" onclick="change_password('{{$associate->public_id}}')" data-toggle="tooltip" data-placement="top" title="Change User"><i class="fa fa-unlock-alt text-info" data-toggle="tooltip" data-placement="top" title="Change Password"></i></a>
                                      <!--<input type="button" id="ImageHosting" value="To Image Hosting" onclick="ImageHosting_Click()"/>-->

                                </td>

                            </tr>
                            @php($count++)
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    
    
  <div id="myModal123" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form role="form" method="post" action="{{url('associates/change-password')}}">
                         @csrf
                <div class="modal-body">
                <input type="hidden" name="id"  id="extendid"/>
                        <div class="form-group" >
                            <label>Password</label>
                            <!--<div class="d-flex">-->
                            <!--<input type="password" class="form-control mb-2 password-field"  name="password" placeholder="password"/>-->
                            <!--<span  id="password-addon"><i  toggle=".password-field" class="fa fa-fw fa-eye toggle-password"></i></span>-->
                            <!--</div>-->
                            
                            
                            <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Enter Password" value="" minlength="6" aria-label="Password" aria-describedby="password-addon">
                                        <button class="btn btn-light shadow-none ms-0 password-addon" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        @error('password')
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
<!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>-->
<!--  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
<!--<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>-->
<script>
//   function change_password(id){
//     var ghh = id;
   
//         $("#extendid").val(ghh);
//      //alert(ghh);
//     $('#myModal123').modal('show');
// }




//     $('.change_password_btn').on('click', function() {          
//           var ghh =$(this).parents("tr").attr("id");
//          $("#extendid").val(ghh);
//      alert("ssssssssssss");
//     $('#myModal123').modal('show');
// });



 

</script>







</div> <!-- container-fluid -->

<!--@push('scripts')-->
<!--<script>-->
<!--$('.change_password_btn').on('click', function() {          -->
<!--        $('#myModal123').modal('show');-->
<!--});-->
<!--</script>-->
<!--@endpush-->

















<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   function change_password(id){
    var ghh = id;
   
        jQuery("#extendid").val(ghh);
    //  alert(ghh);
   jQuery('#myModal123').modal('show');
}
</script>
<!-- End Page-content -->
@endsection