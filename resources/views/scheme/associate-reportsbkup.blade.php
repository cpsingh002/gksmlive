@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Booking Reports</h4>

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

    @if(isset($users))
    <form method="post" action="{{ route('scheme.get-associate-reports') }}">
        <div class="row mt-3 mb-3">

            @csrf
            <div class="col-3">
                <select class="form-control" name="user_id">
                    <option>Select User</option>
                    @foreach($users as $user)
                    <option value="{{$user->public_id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-3">
                <button class="btn btn-success">Get Reports</button>
            </div>


        </div>
    </form>


    @if($book_properties != null)
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Scheme Name</th>
                                <th>Plot No</th>
                                <th>Associate Name</th>
                                <th>Associate Number</th>
                                <th>Status</th>
                                <th>View Report</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($propty_report_details as $report_property)

                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$report_property->scheme_name}}</td>
                                <td>{{$report_property->plot_no}}</td>
                                <td>{{$report_property->associate_name}}</td>
                                <td>{{$report_property->associate_number}}</td>

                                <td class="{{$report_property->booking_status == 1 ? 'text-success' : 'text-danger'}}">{{$report_property->booking_status == 1 ? 'Booked' : 'Hold'}}</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $report_property->public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>


                            </tr>
                            @php($count++)
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endif

    @endif




</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection