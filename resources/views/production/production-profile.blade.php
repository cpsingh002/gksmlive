@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Production Profile</h4>

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

                    <form class="needs-validation" method="post" action="{{ route('production.profileUpdate') }}"  enctype="multipart/form-data" novalidate>
                        @csrf


                        <div class="row">
                            <input type="hidden" value="{{Auth::user()->id}}" name="production_id" />
                            <input type="hidden" value="{{$production_detail->id}}" name="id" />
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Production Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="productionName"   value="{{Auth::user()->email}}" readonly> 

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Production name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('production_name') is-invalid @enderror" id="productionName" name="production_name" placeholder="Enter Production Name" value="{{@$production_detail->production_name}}" required>

                                    @error('production_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionImg">Image <span class="text-danger">*</span></label>
                                    <input type="file" name="production_img" class="form-control" id="productionImg" value="{{$production_detail->production_img}}">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="card">
                                        <label class="form-label" for="productionImg">Description <span class="text-danger">*</span></label>
                                        <textarea name="production_description" id="editor1" class="form-control @error('production_description') is-invalid @enderror">{{@$production_detail->production_description}}</textarea>
                                        @error('production_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                        <input type="hidden" name="id" value="{{$production_detail->id}}"/>
                        <div class="text-center"><button class="btn btn-primary" type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

</div> <!-- container-fluid -->
@push('scripts')
<script>
    CKEDITOR.replace('editor1');
</script>
@endpush
@endsection