@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Operators</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">Operators</li>-->
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
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <a href="{{URL::to('/add-operator')}}" type="button" class="btn btn-success waves-effect waves-light">Add Operator</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Operator Name</th>
                                <th>Operator Email</th>
                                <th>Operator Contact Number</th>
                                <th>Schemes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($users as $user)

                            <tr>
                                <td> {{$count}} </td>
                                <!-- <td>{{$user->public_id}}</td> -->
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->mobile_number ? $user->mobile_number : '-'}}</td>
                                <td>                                           
                                    @foreach($schemedata as $list)  
                                        @if (in_array($list->id, json_decode($user->scheme_opertaor)))
                                        <li> {{ $list->scheme_name }}</li>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="{{$user->status == 1 ? 'text-success' : 'text-danger'}}">{{$user->status == 1 ? 'Active' : 'Deactive'}}</td>
                                
                                <td>
                                    <a href="{{ route('edit-user.user', ['id' => $user->public_id]) }}"><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete operator ?')" href="{{ route('user.destroy', ['id' => $user->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fas fa-recycle text-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <a href="{{ route('view.user', ['id' => $user->public_id]) }}" data-toggle="tooltip" data-placement="top" title="View Info"><i class="fas fa-user-alt text-success"></i></a>
                                    @if($user->status == 1)
                                        <a onclick="return confirm('Are you sure you want to deactive Opertor ?')" href="{{ route('opertor.deactive', ['id' => $user->id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye text-success" data-toggle="tooltip" data-placement="top" title="Deactivate"></i></a>
                                    @else
                                        <a onclick="return confirm('Are you sure you want to active Opertor again ?')" href="{{ route('opertor.active', ['id' => $user->id]) }}" data-toggle="tooltip" data-placement="top" title="Deactivate scheme"><i class="fas fa-eye-slash text-danger" data-toggle="tooltip" data-placement="top" title="Activate"></i></a>
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