@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Payment Proof Form</h4>

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
                    <form class="needs-validation" method="post" action="{{ route('property.book-hold-proof-store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="6" name="booking_status" />
                        <input type="hidden" value="{{$property_details->id}}" name="id"  />
                        <input type="hidden" value="{{$property_details->plot_no}}" name="plot_no" />
                        <input type="hidden" value="{{$property_details->scheme_id}}" name="scheme_id" />
                        <div class="row">
                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productionName">Payment Details </label>
                                    <input type="text" name="payment_detail" class="form-control"  class="form-control @error('payment_detail') is-invalid @enderror" required>
                                        
                                </div>
                            </div> 

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Payment Proof Image</label>
                                    <input type="file" name="payment_proof" class="form-control"  class="form-control @error('payment_prrof') is-invalid @enderror" required>
                                
                                    @error('payment_proof')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <!-- <div class="valid-feedback">
                                        Looks good!
                                    </div> -->
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