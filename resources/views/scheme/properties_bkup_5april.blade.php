@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $scheme_detail->scheme_name}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card-body">
                                <div class="row g-4">

                                    @foreach ($properties as $property)

                                    @php (
                                    $color =
                                    [
                                    1 => 'border-primary',
                                    2 => 'border-success',
                                    3 => 'border-danger',
                                    4 => 'border-warning'
                                    ]
                                    )

                                    <div class="col-md-4">
                                        <div class="card {{isset($color[$property->status]) ? $color[$property->status] : 'out of borders';}}" style="width: 18rem;">

                                            <div class="card-body">
                                                <a href="{{ route('view.property', ['id' => $property->property_public_id]) }}">
                                                    <h5 class="card-title">Plot No {{$property->plot_no }}</h5>
                                                </a>
                                                <p class="card-text">{{$property->description }}</p>
                                            </div>
                                            @if(json_decode($property->attributes_data))
                                            <ul class="list-group list-group-flush">
                                                @foreach(json_decode($property->attributes_data) as $key=>$attr)
                                                <li class="list-group-item">{{$key}} -> {{$attr}}</li>
                                                @endforeach
                                                <!-- <li class="list-group-item">A second item</li>
                                                <li class="list-group-item">A third item</li> -->
                                            </ul>
                                            @endif
                                            @if($property->status == 5)
                                            <div class="card-body">
                                                <a href="#" class="card-link text-primary">Completed</a>
                                            </div>
                                            @else
                                            <div class="card-body">
                                                @if($property->status == 1)
                                                <a href="#" class="card-link text-primary">Available</a>
                                                <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                @if(Auth::user()->user_type != 4)
                                                @if($property->management_hold)
                                                @php (

                                                $managment_hold = [

                                                1 => 'Rahan',
                                                2 => 'Possession issue',
                                                3 => 'Staff plot',
                                                4=> 'Executive plot',
                                                5 => 'Associate plot',
                                                6 => 'Other'

                                                ]
                                                )
                                                <a href="{{route('for-managment.property-status',['id' => $property->property_public_id])}}" class="card-link text-secondary">{{$managment_hold[$property->management_hold]}}</a>
                                                @else
                                                <a href="{{route('for-managment.property-status',['id' => $property->property_public_id])}}" class="card-link text-secondary">Management hold</a>
                                                @endif
                                                @endif
                                                @elseif($property->status == 2)

                                                <a href="#" class="card-link text-success">Booked</a>
                                                @elseif($property->status == 3)
                                                <a href="#" class="card-link text-danger">Hold</a>
                                                @if($property->user_id == Auth::user()->public_id)
                                                <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                @endif
                                                @else

                                                @if(Auth::user()->user_type != 4)
                                                @if($current_time != $time)
                                                <a href="#" class="card-link text-warning">Cancel</a>
                                                @endif
                                                @endif
                                                @endif

                                            </div>
                                            @if(Auth::user()->user_type != 4)
                                            @if($property->status == 2 || $property->status == 3)
                                            <div class="card-body">

                                                <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a>
                                                <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link text-secondary">Complete</a>
                                                <a href="{{route('for-managment.property-status',['id' => $property->property_public_id])}}" class="card-link text-secondary">Management hold</a>

                                            </div>
                                            @endif
                                            @endif

                                            @endif


                                        </div>
                                    </div>
                                    @endforeach

                                    <!-- 
                                    @foreach ($properties as $property)
                                    <div class="col-xl-2">

                                        <a href="{{ route('view.property', ['id' => $property->property_public_id]) }}">
                                            <h5 class="font-size-15 mb-3">Plot No {{$property->plot_no }}</h5>
                                        </a>

                                        <div>
                                            @if($property->status == 1)
                                            <button type="button" class="btn btn-outline-success">Plot No {{$property->plot_no }}</button>
                                            @elseif($property->status == 2)
                                            <button type="button" class="btn btn-outline-danger">Plot No {{$property->plot_no }}</button>
                                            @elseif($property->status == 3)
                                            <button type="button" class="btn btn-outline-warning">Plot No {{$property->plot_no }}</button>
                                            @else
                                            <button type="button" class="btn btn-outline-secondary">Plot No {{$property->plot_no }}</button>
                                            @endif
                                            <input type="hidden" value="1" name="property_status" />
                                            <div class="mt-2" role="group" aria-label="Basic example">
                                                @if($property->status == 1)
                                                <button type="button" class="text-success border-0 ">Booked</button>
                                                @else
                                                <a href="{{ route('property.book', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}">
                                                    <button type="button" class="text-success border-0">Book</button>
                                                </a>
                                                @endif
                                                @if($property->status == 1)
                                                <button type="button" class="text-danger border-0 disabled">Hold</button>
                                                @else
                                                <a href="{{ route('property.hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}">
                                                    <button type="button" class="text-danger border-0">Hold</button>
                                                </a>
                                                @endif

                                            </div>

                                        </div>
                                    </div> -->
                                    <!-- end col -->
                                    <!-- @endforeach -->

                                </div><!-- end row -->
                            </div><!-- end card-body -->
                        </div><!-- end col -->
                    </div><!-- end row -->


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection