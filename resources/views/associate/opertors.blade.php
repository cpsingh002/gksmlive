@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Operators</h4>

                <div class="page-title-right">
                   <ol class="breadcrumb m-0">
                       <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                       <li class="breadcrumb-item active">Operators</li>
                   </ol>
                </div>

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
                                <!-- <a href="{{URL::to('/add-associate')}}" type="button" class="btn btn-success waves-effect waves-light">Add Associate</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Operator Name</th>
                                <th>Operator Email</th>
                                <th>Operator Contact Number</th>
                                <th>Production House</th>
                                <th>Scheme</th>
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
                                <td>{{$associate->production_name}}</td>
                                <td> @if(empty(json_decode($associate->scheme_opertaor)))                                          
                                        <p>No scheme</p>
                                    @else
                                        @foreach($schemedata as $list)  
                                            @if (in_array($list->id, json_decode($associate->scheme_opertaor)))
                                            <li> {{ $list->scheme_name }}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="{{$associate->status == 1 ? 'text-success' : 'text-danger'}}">{{$associate->status == 1 ? 'Active' : 'Deactive'}}</td>
                                <td>
                                <a href="{{ route('admin-edit-user.user', ['id' => $associate->public_id]) }}"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    @if($associate->status == 1)
                                        <a onclick="return confirm('Are you sure you want to deactive Operator ?')" href="{{ route('opertor.deactive', ['id' => $associate->id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    @else
                                        <a onclick="return confirm('Are you sure you want to active Operator again ?')" href="{{ route('opertor.active', ['id' => $associate->id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Activate"></i></a>
                                    @endif
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


</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection