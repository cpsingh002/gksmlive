@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Associate</h4>

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
                    <form class="needs-validation" method="post" action="{{ route('associate.store') }}" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="parent_id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="parent_user_type" value="{{Auth::user()->user_type}}">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Associate</label>
                                    <input type="text" class="form-control @error('user_type') is-invalid @enderror" id="productionName" name="user_type" placeholder="Enter User Name" value="Associate" required readonly>
                                    @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Associate Name</label>
                                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="productionName" name="user_name" placeholder="Enter User Name" value="" required>
                                    @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="productionImg">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="productionImg">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Contact Number</label>
                                    <input type="number" min="1" name="mobile_number" min="1" class="form-control @error('mobile_number') is-invalid @enderror" id="productionImg">
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Rera Number</label>
                                    <input type="text" name="associate_rera_number" class="form-control @error('associate_rera_number') is-invalid @enderror" id="productionImg">
                                    @error('associate_rera_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Uplinner Name</label>
                                    <input type="text" name="applier_name" class="form-control @error('applier_name') is-invalid @enderror" id="productionImg">
                                    @error('applier_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Uplinner Rera Number</label>
                                    <input type="text" name="applier_rera_number" class="form-control @error('applier_rera_number') is-invalid @enderror" id="productionImg">
                                    @error('applier_rera_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Team</label>
                                    <select id="servicearea" name="team" required="required" class="form-control">
                                        <option value=""> Select Team</option>
                                        @foreach($teams as $list)            
                                        <option value="{{ $list->public_id }}"> {{ $list->team_name }}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div>


                            <!-- end col -->
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
@endsection