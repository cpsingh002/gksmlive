@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Message</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Message</li>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-2  bg-danger">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0 text-white">Write New Message</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="post" action="{{ route('message.store') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="productionName" name="title" placeholder="Enter Title Here" value="" required>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Message</label>
                                    <textarea id="w3review" class="form-control @error('message') is-invalid @enderror"  name="message" placeholder="Enter Message here"  required rows="4" cols="50"></textarea>
                                    
                                    @error('message')
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
        </div>
    </div>
    
</div>
@endsection
@push('scripts')

@endpush
