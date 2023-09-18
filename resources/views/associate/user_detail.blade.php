@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">User Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">DataTables</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">


                        <tbody>

                            <!-- <tr>
                                <th>Id</th>
                                <td>{{$user_detail->public_id}}</td>
                            </tr> -->
                            <tr>
                                <th>user Name</th>
                                <td>{{$user_detail->name}}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{$user_detail->email}}</td>

                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="{{$user_detail->status == 1 ? 'text-success' : 'text-danger'}}">{{$user_detail->status == 1 ? 'Active' : 'Deactive'}}</td>
                            </tr>




                            </tr>

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