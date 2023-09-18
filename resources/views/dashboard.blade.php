@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
        <div class="col-4">
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
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">No Of Scheme</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$schemesCount}}">{{$schemesCount}}</span>
                            </h4>
                        </div>
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+$20.9k</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Users</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$usersCount}}">{{$usersCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-danger text-danger">-29 Trades</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">No Of Hold Unit</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$holdPropertyCount}}">{{$holdPropertyCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+ $2.8k</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">No Of Book Unit</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{$bookPropertyCount}}">{{$bookPropertyCount}}</span>
                            </h4>
                        </div>
                        <!-- <div class="col-6">
                            <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                        </div> -->
                    </div>
                    <!-- <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">+2.95%</span>
                        <span class="ms-1 text-muted font-size-13">Since last week</span>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row-->


</div>
@endsection