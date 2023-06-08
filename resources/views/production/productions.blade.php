@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Productions</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">DataTables</li>-->
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
                                <a href="{{URL::to('/add-production')}}" type="button" class="btn btn-success waves-effect waves-light">Add Production</a>
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
                                 <th>Production Name</th>
                                <th>Production Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($productions as $production)

                            <tr>
                                <!-- <td>{{$production->public_id}}</td> -->
                                <td> {{$count}} </td>
                                <td> {{$production->name}} </td>
                                <td>{{$production->email}}</td>
                                <td class="{{$production->status == 1 ? 'text-success' : 'text-danger'}}">{{$production->status == 1 ? 'Active' : 'Deactive'}}</td>
                                <td>
                                    <a href="{{ route('production.edit', ['id' => $production->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt text-primary"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('production.destroy', ['id' => $production->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
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