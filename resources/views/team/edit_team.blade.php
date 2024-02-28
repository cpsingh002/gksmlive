@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Team Details</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>-->
                <!--        <li class="breadcrumb-item active">Form Validation</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="needs-validation" method="post" action="{{ route('team.update')}}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="hidden" name="attribute_id" value="{{$attribute->public_id}}">
                                    <label class="form-label" for="productionName">Team Name</label>
                                    <input type="text" class="form-control @error('team_name') is-invalid @enderror" id="productionName" name="team_name" placeholder="Enter Team Name" value="{{$attribute->team_name}}" required>

                                    @error('team_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="">
                                    <label class="form-label" for="productionName">Team Description</label>
                                    <textarea name="team_description" class="form-control @error('team_description') is-invalid @enderror">{{$attribute->team_description}}</textarea>
                                    @error('team_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-md-12">-->
                            <!--    <div class="card">-->
                            <!--        <select class="form-control" name="super_team">-->
                            <!--            <option value=""> Select y/N</option>-->
                            <!--            <option value="0">NO</option>-->
                            <!--            <option value="1">YES</option>-->
                            <!--        </select>-->
                                    <!--<textarea name="super_team" class="form-control @error('super_team') is-invalid @enderror">{{$attribute->super_team}}</textarea>-->
                            <!--        @error('super_team')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!-- end col -->
                        </div>

                        <div class="text-center mt-2"><button class="btn btn-primary" type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
@endsection