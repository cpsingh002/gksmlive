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
                <h4 class="mb-sm-0 font-size-18">Edit Scheme Details</h4>

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
        <form class="needs-validation" method="post" action="{{ route('scheme.update') }}" enctype="multipart/form-data">
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
                            <input type="hidden" name="scheme_id" value="{{$scheme_detail[0]->public_id}}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Select Production <span class="text-danger">*</span></label>
                                    <select class="form-control" name="production_id">
                                        <option>Choose Production</option>
                                        @foreach ($productions as $production)
                                        <option {{$scheme_detail[0]->production_id == $production->public_id ? 'selected' : ''}} value="{{$production->public_id}}">{{$production->production_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Scheme Name <span class="text-danger">*</span></label>
                                    <input type="text" name="scheme_name" value="{{$scheme_detail[0]->scheme_name}}" class="form-control @error('scheme_name') is-invalid @enderror" id="schemeName">
                                    @error('scheme_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Map Location (Enter Google Map URL) <span class="text-danger">*</span></label>
                                    <input type="text" name="location" value="{{$scheme_detail[0]->location}}" class="form-control @error('location') is-invalid @enderror" id="schemeImg">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Team Name <span class="text-danger">*</span></label>
                                    <select name="team"  class="form-control">
                                                    <option> Select Team</option>
                                                    @foreach($teams as $list)  
                                                    @if($scheme_detail[0]->team==$list->public_id)
                                                    <option selected value="{{$list->public_id}}">
                                                    @else
                                                    <option value="{{ $list->public_id }}">
                                                    @endif
                                                     {{ $list->team_name }}</option>
                                                    <!--<option value={{$scheme_detail[0]->team == $list->public_id ? 'selected' : ''}} value="{{$list->public_id}}">{{$list->team_name}}</option>     -->
                                                    @endforeach
                                                </select> 
                                    @error('team')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Launch Date <span class="text-danger">*</span></label>
                                    <input type="date"  name="lunchdate" value="@if($scheme_detail[0]->lunch_date){{$scheme_detail[0]->lunch_date}}@endif" class="form-control @error('lunchdate') is-invalid @enderror" id="schemeImg">
                                    @error('lunchdate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Scheme description</h4>
                                        <p class="card-title-desc"></p>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="editor1" name="description">{{$scheme_detail[0]->scheme_description}}</textarea>
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

                        <div class="card">

                            <div class="card-body">

                                <div class="row">


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme Cover Image <span class="text-danger"></span></label>
                                            <input type="file" name="scheme_img" value="{{$scheme_detail[0]->scheme_img}}" class="form-control @error('scheme_img') is-invalid @enderror" id="schemeImg">
                                            @if($scheme_detail[0]->scheme_img !='')
                                                <a href="{{URL::to('/files',$scheme_detail[0]->scheme_img)}}" download target="_blank"><img src="{{URL::to('/files',$scheme_detail[0]->scheme_img)}}" class="ms-2" style="height:25px;width:45px;"></a>
                                            @endif
                                            @error('scheme_img') <span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme Brochure <span class="text-danger"></span></label>
                                            <input type="file" name="brochure" value="{{$scheme_detail[0]->brochure}}" class="form-control @error('brochure') is-invalid @enderror" id="schemeImg"  placeholder ="{{$scheme_detail[0]->brochure}}">
                                            @if($scheme_detail[0]->brochure !='')<a href="{{URL::to('/brochure',$scheme_detail[0]->brochure)}}" download target="_blank"><i class='far fa-file-pdf'></i></a>@endif
                                            @error('brochure')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme PPt</label>
                                            <input type="file" name="ppt" class="form-control" value="{{$scheme_detail[0]->ppt}}" id="schemeImg">
                                            @if($scheme_detail[0]->ppt !='')<a href="{{URL::to('/ppt',$scheme_detail[0]->ppt)}}" download target="_blank"><i class='far fa-file-powerpoint'></i></a>@endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme JDA Map</label>
                                            <input type="file" name="jda_map" class="form-control" value="{{$scheme_detail[0]->jda_map}}" id="schemeImg">
                                            @if($scheme_detail[0]->jda_map !='')<a href="{{URL::to('/jda_map',$scheme_detail[0]->jda_map)}}" download target="_blank"><i class="far fa-map"></i></a>@endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme Other Document</label>
                                            <input type="file" name="other_docs" value="{{$scheme_detail[0]->other_docs}}" class="form-control" id="schemeImg">
                                            @if($scheme_detail[0]->other_docs !='')<a href="{{URL::to('/other_docs',$scheme_detail[0]->other_docs)}}" download target="_blank"><i class="far fa-file-pdf"></i></a>@endif
                                        </div>
                                    </div>

                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="mb-3">-->
                                    <!--        <label class="form-label" for="schemeImg">Video</label>-->
                                    <!--        <input type="file" name="video" class="form-control" value="{{$scheme_detail[0]->video}}" id="schemeImg">-->

                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Scheme Rera Registration</label>
                                            <input type="file" name="pra" class="form-control" value="{{$scheme_detail[0]->pra}}" id="schemeImg">
                                            @if($scheme_detail[0]->pra !='')<a href="{{URL::to('/pra',$scheme_detail[0]->pra)}}" download target="_blank"><i class="far fa-file-alt"></i></a>@endif
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="schemeImg">Schemes Images (Choose Multiple Images)</label>
                                            <input type="file" name="scheme_images[]" multiple class="form-control" id="schemeImg">
                                            @foreach(explode(',', $scheme_detail[0]->scheme_images) as $image)
                                                @if($image != '')<a href="{{URL::to('/scheme_images',$image)}}" download target="_blank"><img  src="{{URL::to('/scheme_images',$image)}}" width="50" /></a>@endif
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="videoLinks">Scheme Video Links</label>
                                            <textarea class="form-control @error('video') is-invalid @enderror"  id="editor12" name="video">{{$scheme_detail[0]->video}}</textarea>
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
                                            <input type="text" name="bank_name" value="{{$scheme_detail[0]->bank_name}}" class="form-control @error('bank_name') is-invalid @enderror" id="schemeImg">
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
                                            <input type="number" name="account_number" value="{{$scheme_detail[0]->account_number}}" class="form-control @error('account_number') is-invalid @enderror" id="schemeImg">
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
                                            <input type="text" name="ifsc_code" value="{{$scheme_detail[0]->ifsc_code}}" class="form-control @error('ifsc_code') is-invalid @enderror" id="schemeImg">
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
                                            <input type="text" name="branch_name" value="{{$scheme_detail[0]->branch_name}}" class="form-control @error('branch_name') is-invalid @enderror" id="schemeImg">
                                            @error('branch_name')
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
                        <div class="text-center"><button class="btn btn-primary" type="submit">Submit</button></div>
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