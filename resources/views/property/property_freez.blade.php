@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Property Freez/Unfreez Reason Form</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    <form class="needs-validation" method="post" action="{{ route('plot.freezreason') }}">
                        @csrf
                        <input type="hidden" value="6" name="booking_status" />
                        <input type="hidden" value="{{$property_details->public_id}}" name="id" />
                        <input type="hidden" value="{{$property_details->plot_no}}" name="plot_no" />
                        <input type="hidden" value="{{$property_details->scheme_id}}" name="scheme_id" />
                        @if($property_details->freez)
                            <input type="hidden" value="unfreez" name="freeztype" />
                        @else
                            <input type="hidden" value="freez" name="freeztype" />
                        @endif
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Reason</label>
                                    <input type="text" name="other_info" class="form-control"  class="form-control @error('other_info') is-invalid @enderror" required>
                                    @error('other_info')  <span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong>  </span>  @enderror
                                    
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