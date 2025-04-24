@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Schemes</h4>
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
                    @if(Auth::user()->user_type == 1 || Auth::user()->user_type ==2)
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
    
                                <div class="page-title-right">
                                     @if (Auth::user()->user_type == 1) 
                                        
                                        <a href="{{URL::to('admin/add-scheme')}}" type="button" class="btn btn-success waves-effect waves-light">Add Scheme</a>
                                    @elseif (Auth::user()->user_type == 2) 
                                        
                                        <a href="{{URL::to('production/add-scheme')}}" type="button" class="btn btn-success waves-effect waves-light">Add Scheme</a>
                                   
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Production Name</th>
                                    <th>Scheme Name</th>
                                    <th>Unit Available</th>
                                    @if(in_array(Auth::user()->user_type,[1,6]))
                                    <th>gaj</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if((Auth::user()->user_type == 4) && (Auth::user()->all_seen == 0)&&(!in_array(Auth::user()->team, $teams)))
                                    @php($count=1)
                                    @foreach ($schemes->where('status',1) as $scheme)
                                        @if($scheme->scheme_team == Auth::user()->team)
                                            <tr>
                                                <td> {{$count}} </td>
                                                <td>{{$scheme->production_name}}</td>
                                                <td>{{$scheme->scheme_name}}</td>
                                                <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                                <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                    <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                    <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                </td>
                                            </tr>
                                            @php($count++)
                                        @endif                         
                                    @endforeach                 
                                @elseif((Auth::user()->user_type == 2) )
                                    @php($count=1)
                                    @foreach ($schemes as $scheme)
                                        @if($scheme->upublic_id == Auth::user()->parent_id)
                                            <tr>
                                                <td> {{$count}} </td>
                                                <!-- <td>{{$scheme->scheme_public_id}}</td> -->
                                                <td>{{$scheme->production_name}}</td>
                                                <td>{{$scheme->scheme_name}}</td>
                                                <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                                <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    @if(Auth::user()->user_type == 2)
                                                        <a href="{{ route('scheme.edit', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('scheme.destroy', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        @if($scheme->hold_status == 1)
                                                        <a onclick="return confirm('Are you sure you want to Active Hold Status option ?')" href="{{ route('scheme.activehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Active Hold Status"><i class="fa fa-times-circle text-danger"></i></a>
                                                        @else
                                                        <!--<a onclick="return confirm('Are you sure you want to Deactive Hold Status option ?')" href="{{ route('scheme.deactivehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>-->
                                                        <a hre="#" onclick="change_password('{{$scheme->scheme_id}}')" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>
                                                        @endif
                                                        @if($scheme->status == 1)
                                                        <a onclick="return confirm('Are you sure you want to deactive scheme ?')" href="{{ route('scheme.deactive', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                                        @else
                                                        <a onclick="return confirm('Are you sure you want to active scheme again ?')" href="{{ route('scheme.active', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Activate"></i></a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php($count++)
                                        @endif
                                    @endforeach
                                    
                                @elseif(in_array(Auth::user()->user_type,[1,6]) )
                                    @php($count=1)
                                    @foreach ($schemes as $scheme)
                                        
                                            <tr>
                                                <td> {{$count}} </td>
                                                <!-- <td>{{$scheme->scheme_public_id}}</td> -->
                                                <td>{{$scheme->production_name}}</td>
                                                <td>{{$scheme->scheme_name}}</td>
                                                <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                                <td>{{$g_slot[$scheme->scheme_id]}}</td>
                                                <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    @if(Auth::user()->user_type == 1)
                                                        <a href="{{ route('scheme.edit', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('scheme.destroy', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        @if($scheme->hold_status == 1)
                                                        <a onclick="return confirm('Are you sure you want to Active Hold Status option ?')" href="{{ route('scheme.activehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Active Hold Status"><i class="fa fa-times-circle text-danger"></i></a>
                                                        @else
                                                        <!--<a onclick="return confirm('Are you sure you want to Deactive Hold Status option ?')" href="{{ route('scheme.deactivehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>-->
                                                        <a hre="#" onclick="change_password('{{$scheme->scheme_id}}')" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>
                                                        @endif
                                                        @if($scheme->status == 1)
                                                        <a onclick="return confirm('Are you sure you want to deactive scheme ?')" href="{{ route('scheme.deactive', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                                        @else
                                                        <a onclick="return confirm('Are you sure you want to active scheme again ?')" href="{{ route('scheme.active', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Activate"></i></a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php($count++)
                                    
                                    @endforeach
                                
                                @elseif((Auth::user()->user_type == 3))
                                    @php($count=1)
                                   
                                    @foreach ($schemes->where('status',1) as $scheme)
                                        @if($scheme->upublic_id == Auth::user()->parent_id)
                                        @if (in_array($scheme->scheme_id, $schdata))
                                            <tr>
                                                <td> {{$count}} </td>
                                                <!-- <td>{{$scheme->scheme_public_id}}</td> -->
                                                <td>{{$scheme->production_name}}</td>
                                                <td>{{$scheme->scheme_name}}</td>
                                                <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                                <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                   
                                                
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                        @if($scheme->hold_status == 1)
                                                        <a onclick="return confirm('Are you sure you want to Active Hold Status option ?')" href="{{ route('scheme.activehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Active Hold Status"><i class="fa fa-times-circle text-danger"></i></a>
                                                        @else
                                                        <!--<a onclick="return confirm('Are you sure you want to Deactive Hold Status option ?')" href="{{ route('scheme.deactivehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>-->
                                                        <a hre="#" onclick="change_password('{{$scheme->scheme_id}}')" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>
                                                        @endif
                                                </td>
                                            </tr>
                                            @php($count++)
                                            @endif
                                        @endif
                                    @endforeach
                                @elseif((Auth::user()->user_type == 5))
                                    @php($count=1)
                                    @foreach ($schemes->where('status',1) as $scheme)
                                        @if($scheme->upublic_id == Auth::user()->parent_id)
                                        
                                            <tr>
                                                <td> {{$count}} </td>
                                                <!-- <td>{{$scheme->scheme_public_id}}</td> -->
                                                <td>{{$scheme->production_name}}</td>
                                                <td>{{$scheme->scheme_name}}</td>
                                                <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                                <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                   
                                                
                                                        <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                        <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                        <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                
                                                </td>
                                            </tr>
                                            @php($count++)
                                          
                                        @endif
                                    @endforeach
                                @else
                                    @php($count=1)
                                    @foreach ($schemes->where('status',1) as $scheme)
                                    
                                        <tr>
                                            <td> {{$count}} </td>
                                            <!-- <td>{{$scheme->scheme_public_id}}</td> -->
                                            <td>{{$scheme->production_name}}</td>
                                            <td>{{$scheme->scheme_name}}</td>
                                            <td>{{$a_slot[$scheme->scheme_id]}}</td>
                                            <td class="{{$scheme->scheme_status == 1 ? 'text-success' : 'text-danger'}}">{{$scheme->scheme_status == 1 ? 'Active' : 'Deactive'}}</td>
                                            <td>
                                                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2 || Auth::user()->user_type == 3)
                                                    <a href="{{ route('scheme.edit', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        </i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('scheme.destroy', ['id' => $scheme->scheme_public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
        
                                                    <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
        
                                                    <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                    <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                    
                                                     @if($scheme->hold_status == 1)
                                                        <a onclick="return confirm('Are you sure you want to Active Hold Status option ?')" href="{{ route('scheme.activehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title="Active Hold Status"><i class="fa fa-times-circle text-danger"></i></a>
                                                        @else
                                                        <!--<a onclick="return confirm('Are you sure you want to Deactive Hold Status option ?')" href="{{ route('scheme.deactivehold', ['id' => $scheme->scheme_id]) }}" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>-->
                                                        <a hre="#" onclick="change_password('{{$scheme->scheme_id}}')" data-toggle="tooltip" data-placement="top" title=" Deactive Hold Status"><i class="fa fa-check-circle text-success"></i></a>
                                                        @endif
                
                                                @else
                                                    <a href="{{ route('view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="View Scheme"><i class="fas fa-house-user text-success"></i></a>
                                                    <a href="{{ route('list_view.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="List View"><i class="fas fa-bars text-info"></i></a>
                                                    <a href="{{ route('show.scheme', ['id' => $scheme->scheme_id]) }}" ata-toggle="tooltip" data-placement="top" title="Scheme Details"><i class="fas fa-home text-info"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php($count++)
                                  
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- container-fluid -->

<!-- End Page-content -->


<div id="myModal123" class="modal fade show mt-5 pt-5" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deactive Hold Status Reset Time</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" method="post" action="#" id="frmPaymnetCancel">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id"  id="extendid"/>
                    <p>Are you sure you want to Deactive Hold Status option ?</p>
                    <div class="form-group"  id="lunchdatebox">
                        <label> Re-Set Time</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="datetime-local" name="dateto" value="" id="dateto" class="form-control @error('dateto') is-invalid @enderror"  required>
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


@push('scripts')
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
    url:'{{ route('scheme.deactivehold') }}',
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
@endsection
