@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Associates</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Associate Name</th>
                                <th>Associate Email</th>
                                <th>Associate Rera Number</th>
                                <th>Associate Uplinner Name</th>
                                <th>Request Status</th>

                                <th>Approved</th>
                                <th>Cancelled</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($associates as $associate)

                            <tr>
                                <td>{{$associate->public_id}}</td>
                                <td>{{$associate->name}}</td>
                                <td>{{$associate->email}}</td>
                                <td>{{$associate->associate_rera_number}}</td>
                                <td>{{$associate->applier_name}}</td>

                                <td class="{{$associate->status == 1 ? 'text-success' : 'text-danger'}}">{{$associate->status == 1 ? 'Approved' : 'Pending'}}</td>
                                <td>
                                    <form method="post" action="{{ route('associate.approved', ['userid' => $associate->public_id]) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approved</button>
                                    </form>

                                </td>
                                <td>
                                    <form method="post" action="{{ route('associate.cancelled') }}">
                                        @csrf
                                        <input type="hidden" name="cancel_id" value="{{$associate->public_id}}" />
                                        <button class="btn btn-sm btn-danger">Cancelled</button>
                                    </form>
                                </td>

                                <!-- <td>
                                    <a href=""><i class="fas fa-pencil-alt text-primary" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <i class="fas fa-recycle text-danger" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                    <a href="{{ route('view.user', ['id' => $associate->public_id]) }}" data-toggle="tooltip" data-placement="top" title="View Info"><i class="fas fa-user-alt text-success"></i></a>
                                </td> -->

                            </tr>
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