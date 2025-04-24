@extends("dashboard.master")
<style>
    #cke_2_contents{
        height:70px !important;
    }
    .main-content{
        overflow:visible;
    }
    .chosen-container-single .chosen-single{
        height:38px;
        padding-top:7px;
        background:white;
    }
    .chosen-container-single .chosen-single div b {
    display: block;
    width: 100%;
    height: 100%;
    background: url(chosen-sprite.png) no-repeat 0 9px;
}



 .status-dropdown{border: 1px solid #aaa;
    border-radius: 3px;
    width: 168px;
    line-height: 16px;
    height: 33px;}
    .input-group-text1{
        padding: 0.47rem 0.35rem;
    }
    #associateReportTbl_filter{
        position:relative;
        top:10px;
    }
    .dt-buttons{
        position: relative;
    top: 20px;
    }
     .text-end {
    text-align: initial!important;
}
    @media (min-width:768px){
        #associateReportTbl_filter {
    position: relative;
     top: -20px; 
}
.text-end {
    text-align: right!important;
}
    }
</style>
@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Customer Form</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
        <div class="row">
            <form class="needs-validation" method="post" action="{{URL::to('/customerliststore')}}" enctype="multipart/form-data">                   
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
                                        <label class="form-label" for="productionName">Select Scheme <span class="text-danger">*</span></label>
                                        <select class="form-control @error('scheme_id') is-invalid @enderror schedfdf" name="scheme_id">
                                            <option value="">Choose scheme</option>
                                            @foreach ($schemes as $scheme)
                                                <option value="{{$scheme->id}}">{{$scheme->scheme_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('scheme_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="schemeName" required>
                                        @error('owner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="schemeImg">Aadhaar Card Number <span class="text-danger">*</span></label>
                                        <input type="number" name="adhar_card_number" onKeyPress="if( this.value.length == 12 ) return false; " required class="form-control @error('adhar_card_number') is-invalid @enderror" id="schemeImg">
                                        @error('adhar_card_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="schemeImg">Customer Contact Number <span class="text-danger">*</span></label>
                                        <input type="number" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror">
                                        @error('contact_no')
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
                    <!-- end card -->
                </div> <!-- end col -->
            </form>
        </div>
    <!-- end row -->
</div> <!-- container-fluid -->
@push('scripts')
<script>
    $('.schedfdf').chosen();
</script>
@endpush
@endsection