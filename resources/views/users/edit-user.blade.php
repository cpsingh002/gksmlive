@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Associate Details</h4>

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
                    <form class="needs-validation" method="post" action="{{ url('/update-user') }}" novalidate>
                        @csrf
                        <div class="row">
                        <input type="hidden"   name="user_id" value="{{$user_detail->public_id}}">
                        <input type="hidden"   name="id" value="{{$user_detail->id}}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Associate Name</label>
                                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="productionName" name="user_name" placeholder="Enter User Name" value="{{$user_detail->name}}" required>
                                    @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Email</label>
                                    <input type="email" value="{{$user_detail->email}}" name="email" class="form-control @error('email') is-invalid @enderror" id="productionImg">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!--<div class="col-md-6">-->
                            <!--    <div class="mb-3">-->
                            <!--        <label class="form-label" for="productionImg">Password</label>-->
                            <!--        <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" id="productionImg">-->
                            <!--        @error('password')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Contact Number</label>
                                    <input type="number" value="{{$user_detail->mobile_number}}" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" id="productionImg" min="0" max="12">
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
                                    <input type="text" value="{{$user_detail->associate_rera_number}}" name="associate_rera_number" class="form-control @error('associate_rera_number') is-invalid @enderror" id="productionImg">
                                    @error('associate_rera_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Immediate Uplinner Name</label>
                                    <input type="text" value="{{$user_detail->applier_name}}" name="applier_name" class="form-control @error('applier_name') is-invalid @enderror" id="productionImg">
                                    @error('applier_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Immediate Uplinner Rera Number</label>
                                    <input type="text" value="{{$user_detail->applier_rera_number}}" name="applier_rera_number" class="form-control @error('applier_rera_number') is-invalid @enderror" id="productionImg">
                                    @error('applier_rera_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Joining Date</label>
                                    <input type="datetime-local" value="{{$user_detail->created_at}}" name="joing_date" class="form-control @error('joing_date') is-invalid @enderror" id="productionImg">
                                    @error('joing_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Sold Guz </label>
                                    <input type="text" value="{{$user_detail->gaj}}" name="gaj" class="form-control @error('gaj') is-invalid @enderror" id="productionImg">
                                    @error('gaj')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                                
                                <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Associate Team</label>

                                    <select id="servicearea" class="form-control" name="team" required="required">
                                         @foreach($teams as $list)  
                                            @if($user_detail->team==$list->public_id)
                                            <option selected value="{{$list->public_id}}">
                                            @else
                                            <option value="{{ $list->public_id }}">
                                            @endif
                                             {{ $list->team_name }}</option>
                                           
                                        @endforeach
                
                                    </select> 
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