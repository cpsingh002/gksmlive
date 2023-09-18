@extends("dashboard.master")
<style>
    #cke_2_contents{
        height:70px !important;
    }
</style>
@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Scheme</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
        <div class="row">
             @if (Auth::user()->user_type == 1) 
                <form class="needs-validation" method="post" action="{{URL::to('admin/add-scheme')}}" enctype="multipart/form-data">                   
            @elseif (Auth::user()->user_type == 2) 
                <form class="needs-validation" method="post" action="{{URL::to('production/add-scheme')}}" enctype="multipart/form-data">
            @elseif (Auth::user()->user_type == 3) 
                <form class="needs-validation" method="post" action="{{URL::to('opertor/add-scheme')}}" enctype="multipart/form-data">
            @endif
            @csrf
            <div class="offset-xl-2 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Select Production <span class="text-danger">*</span></label>
                                    <select class="form-control" name="production_id">
                                        <option>Choose Production</option>
                                        @foreach ($productions as $production)
                                            <option value="{{$production->public_id}}">{{$production->production_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Scheme Name <span class="text-danger">*</span></label>
                                    <input type="text" name="scheme_name" class="form-control @error('scheme_name') is-invalid @enderror" id="schemeName">
                                    @error('scheme_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">No Of Plot <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="plot_count" class="form-control @error('plot_count') is-invalid @enderror" id="schemeImg">
                                    @error('plot_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Team <span class="text-danger">*</span></label>
                                    <select id="servicearea" name="team"  class="form-control @error('team') is-invalid @enderror">
                                        <option value=""> Select Team</option>
                                        @foreach($teams as $list)            
                                            <option value="{{ $list->public_id }}"> {{ $list->team_name }}</option>
                                        @endforeach
                                    </select> 
                                    @error('team')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Map Location <span class="text-danger">*</span></label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="schemeImg">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Enter a description</h4>
                                        <p class="card-title-desc"></p>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="editor1" name="description"></textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Image <span class="text-danger">*</span></label>
                                    <input type="file" name="scheme_img" class="form-control @error('scheme_img') is-invalid @enderror" id="schemeImg">
                                    @error('scheme_img')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Brochure <span class="text-danger">*</span></label>
                                    <input type="file" name="brochure" class="form-control @error('brochure') is-invalid @enderror" id="schemeImg">
                                    @error('brochure')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Ppt</label>
                                    <input type="file" name="ppt" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">JDA Map</label>
                                    <input type="file" name="jda_map" class="form-control " id="schemeImg">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Other Document</label>
                                    <input type="file" name="other_docs" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Project Rera Registration</label>
                                    <input type="file" name="pra" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Schemes Images</label>
                                    <input type="file" name="scheme_images[]" multiple class="form-control" id="schemeImg">
                                </div>
                            </div>
                            <!--<div class="col-md-6">-->
                            <!--    <div class="mb-3">-->
                            <!--        <label class="form-label" for="schemeImg">Video</label>-->
                            <!--        <input type="file" name="video" class="form-control" id="schemeImg">-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="video links">Video Links</label>
                                    <textarea class="form-control @error('video') is-invalid @enderror" id="editor12" name="video"></textarea>
                                        @error('video')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            <!-- end col -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" required>
                                    @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Account Number <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="account_number" class="form-control @error('account_number') is-invalid @enderror" required>
                                    @error('account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">IFSC Code <span class="text-danger">*</span></label>
                                    <input type="text" name="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" required>
                                    @error('ifsc_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Branch Name <span class="text-danger">*</span></label>
                                    <input type="text" name="branch_name" class="form-control @error('branch_name') is-invalid @enderror" required>
                                    @error('branch_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </form>
    </div>
    <!-- end row -->
</div> <!-- container-fluid -->
@push('scripts')
<script>
    CKEDITOR.replace('editor1');
    
    
     CKEDITOR.replace('editor12', {
  toolbar: [
    ['Link'] // Add more toolbar options here if needed.
  ]
});
</script>
@endpush
@endsection