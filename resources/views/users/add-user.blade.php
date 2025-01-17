@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Operator Form</h4>

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
                    <form class="needs-validation" method="post" action="{{ route('user.store') }}" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="parent_id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="parent_user_type" value="{{Auth::user()->user_type}}">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Operator</label>
                                    <input type="text" class="form-control @error('user_type') is-invalid @enderror" id="productionName" name="user_type" placeholder="Enter User Name" value="Operator" required readonly>
                                    @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Operator Name</label>
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
                                    <label class="form-label" for="productionImg">Operator Email</label>
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
                                    <!--<div class="d-flex">-->
                                    <!--<input type="password" name="password" class="form-control password-field @error('password') is-invalid @enderror" id="productionImg">-->
                                    <!--<span><i  toggle=".password-field" class="fa fa-fw fa-eye toggle-password password-field"></i></span>-->
                                    <!--</div>-->
                                    <!--@error('password')-->
                                    <!--<span class="invalid-feedback" role="alert">-->
                                    <!--    <strong>{{ $message }}</strong>-->
                                    <!--</span>-->
                                    <!--@enderror-->
                                    
                                    
                                    
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password"  minlength= "6" placeholder="Enter Password" value="" aria-label="Password" minlenght="6" aria-describedby="password-addon" class="form-control @error('password') is-invalid @enderror">
                                        <button class="btn btn-light shadow-none ms-0 password-addon" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Operator Contact Number</label>
                                    <input type="number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" id="productionImg" min="0" max="12">
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Schemes</label>

                                    <select id="servicearea" class="form-control @error('schemes') is-invalid @enderror" name="schemes[]" required="required" size="3" multiple>
                                         @foreach($schemes as $list)  
                                           
                                            <option value="{{ $list->id }}">
                                           
                                             {{ $list->scheme_name }}</option>
                                           
                                        @endforeach
                
                                    </select> 
                                    @error('schemes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- end col -->
                        </div>

                        <div class="text-center"><button class="btn btn-primary" type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->


@endsection