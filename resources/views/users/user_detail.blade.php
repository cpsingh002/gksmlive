@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Associate Details</h4>

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
                                <th>Sr No</th>
                                <td>{{$user_detail->id}}</td>
                            </tr> -->
                            <tr>
                                <th>Name</th>
                                <td>{{$user_detail->name}}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{$user_detail->email}}</td>

                            </tr>

                            <tr>
                                <th>Contact Number</th>
                                <td>{{$user_detail->mobile_number}}</td>

                            </tr>
                            @if(Auth::user()->user_type != 2 )
                            <tr>
                                <th>Rera Number</th>
                                <td>{{$user_detail->associate_rera_number}}</td>

                            </tr>
                             <tr>
                                <th>Team</th>
                                <td>{{$user_detail->team_name}}</td>

                            </tr>


                            <tr>
                                <th>Uplinner Name</th>
                                <td>{{$user_detail->applier_name}}</td>

                            </tr>

                            <tr>
                                <th>Uplinner Rera Number</th>
                                <td>{{$user_detail->applier_rera_number}}</td>

                            </tr>
                            
                            <tr>
                                <th>Joining Date</th>
                                <td>{{date('d-M-Y H:i:s', strtotime($user_detail->created_at))}}</td>

                            </tr>
                            <tr>
                                <th>Sold Guz</th>
                                <td>{{$user_detail->gaj}}</td>

                            </tr>
                            @endif
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