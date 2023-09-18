@extends("dashboard.master")

@section("content")
<style>
    .far{
        font-size:26px;
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Details</h4>

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
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">

                        <tbody>
                            <tr>
                                <th>Scheme Name</th>
                                <td>{{$scheme_details[0]->scheme_name}}</td>
                            </tr>
                            <tr>
                                <th>Total Plot</th>
                                <td>{{$scheme_details[0]->no_of_plot}}</td>
                            </tr>
                            <tr>
                                <th>Team Name</th>
                                <td>{{$scheme_details[0]->team_name}}</td>
                            </tr>

                            <tr>
                                <th>Scheme Location</th>
                                <td><a href="{{$scheme_details[0]->location}}" download target="_blank">{{$scheme_details[0]->location}}</a></td>
                            </tr>

                            <tr>
                                <th>Scheme Image</th>
                                <td>@if($scheme_details[0]->scheme_img !='')<a href="{{URL::to('/files',$scheme_details[0]->scheme_img)}}" download target="_blank"><img src="{{URL::to('/files',$scheme_details[0]->scheme_img)}}" width="50" /></a>@endif</td>

                            </tr>

                            <tr>
                                <th>Scheme Images</th>
                                <td >
                                @foreach($images as $image)
                                    @if($image != '')<a href="{{URL::to('/scheme_images',$image)}}" download target="_blank"><img  src="{{URL::to('/scheme_images',$image)}}" width="50" /></a>@endif
                                @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th>Scheme Brochure</th>
                                <td>@if($scheme_details[0]->brochure !='')<a href="{{URL::to('/brochure',$scheme_details[0]->brochure)}}" download target="_blank"><i class='far fa-file-pdf'></i></a>@endif</td>
                            </tr>

                            <tr>
                                <th>Scheme ppt</th>
                                <td>@if($scheme_details[0]->ppt !='')<a href="{{URL::to('/ppt',$scheme_details[0]->ppt)}}" download target="_blank"><i class='far fa-file-powerpoint'></i></a>@endif</td>
                            </tr>

                            <tr>
                                <th>Scheme Jda Map</th>
                                <td>@if($scheme_details[0]->jda_map !='')<a href="{{URL::to('/jda_map',$scheme_details[0]->jda_map)}}" download target="_blank"><i class="far fa-map"></i></a>@endif</td>
                            </tr>
                            <tr>
                                <th>Scheme Video</th>
                                <!--<td>@if($scheme_details[0]->video !='')<a href="{{URL::to('/video',$scheme_details[0]->video)}}" download target="_blank"><i class="far fa-file-video"></i></a>@endif</td>-->
                                <td>{!!$scheme_details[0]->video!!}</td>
                            </tr>

                            <tr>
                                <th>Scheme Rera</th>
                                <td>@if($scheme_details[0]->pra !='')<a href="{{URL::to('/pra',$scheme_details[0]->pra)}}" download target="_blank"><i class="far fa-file-alt"></i></a>@endif</td>
                            </tr>

                            <tr>
                                <th>Scheme Description</th>
                                <td colspan='{{count($images)}}'>{!!$scheme_details[0]->scheme_description!!}</td>
                            </tr>

                            <tr>
                                <th>Bank Name</th>
                                <td>{{$scheme_details[0]->bank_name}}</td>
                            </tr>

                            <tr>
                                <th>Account Number</th>
                                <td>{{$scheme_details[0]->account_number}}</td>
                            </tr>

                            <tr>
                                <th>IFSC Code</th>
                                <td>{{$scheme_details[0]->ifsc_code}}</td>
                            </tr>

                            <tr>
                                <th>Branch Name</th>
                                <td>{{$scheme_details[0]->branch_name}}</td>
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