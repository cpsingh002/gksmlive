@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Booking Cancel Form</h4>

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
                    <form class="needs-validation" method="post" action="{{ route('booking.delete') }}" novalidate>
                        @csrf
                        <input type="hidden" value="6" name="booking_status" />
                        <input type="hidden" value="{{$property_details->property_public_id}}" name="property_public_id" />
                        <input type="hidden" value="{{$property_details->plot_no}}" name="plot_no" />
                        <input type="hidden" value="{{$property_details->scheme_id}}" name="scheme_id" />
                       
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Other Info</label>
                                    <input type="text" name="other_info" class="form-control" id="otherInfo">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>


                            <!-- end col -->
                      

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