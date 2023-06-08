@extends("dashboard.master")

@section("content")
<style>
    .card{
        box-shadow: 0px 7px 10px 0px;
}
    
    .shadow-green{
        box-shadow: 0px 7px 10px 0px rgb(97 229 177);
    }
    .shadow-red{
        box-shadow: 0px 7px 10px 0px rgb(213 36 36);
    }
    .shadow-blue{
           box-shadow: 0px 7px 10px 0px rgb(36 107 213);
           color:darkblue;

    }
    .shadow-violet{
        box-shadow: 0px 7px 10px 0px rgb(100 51 217);
        color:darkviolet;
        border-color:darkviolet;
    }
    .shadow-teal{
         box-shadow: 0px 7px 10px 0px darkgreen;
       border-color:darkgreen;
    }
</style>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $scheme_detail->scheme_name}}</h4>

                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>-->
                <!--        <li class="breadcrumb-item active">DataTables</li>-->
                <!--    </ol>-->
                <!--</div>-->
  
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

$booking_status = [
2 => 'Booked',
3 => 'Hold'
]
)


@php (

      $managment_color = [
        0 =>'aaa',
        1 => 'Rahan',
        2 => 'border-success shadow-green',
        3 => 'border-danger shadow-red',
        4=>  'shadow-violet',
        5 => 'shadow-teal',
        6 => 'border-info shadow-blue',
        ]
       )

                              <div class="col-md-4">
                                        <!--<div class="card {{isset($color[$property->status]) ? $color[$property->status] : 'out of borders';}}" style="width: 18rem;">-->
                                            
                                         <!--<div class="card @if($property->status == 2) border-success @elseif($property->status == 3) border-danger @endif" style="width: 18rem;">-->
                                            <div class="card {{$managment_color[$property->status]}}">
                                            <div class="card-body">
                                                 <h5 class="card-title">Plot No {{$property->plot_no }}</h5>
                                                <!-- <a href="{{ route('view.property', ['id' => $property->property_public_id]) }}">
                                                    <h5 class="card-title">Plot No {{$property->plot_no }}</h5>
                                                </a> -->
                                                 @if($property->status != 1)

                                                <p class="card-text">{{$property->description }}</p>
                                                @endif
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
                                            @if($property->management_hold > 0)
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

                                            @php (

                                            $booking_status = [
                                            2 => 'Booked',
                                            3 => 'Hold'
                                            ]
                                            )
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a href="#" class="card-link  fw-bold" style="color:blue;">{{$managment_hold[$property->management_hold]}}</a>
                                                    <p>
                                                        {{$property->other_info}}
                                                    </p>
                                                </li>
                                                @if(Auth::user()->user_type != 4)
                                                <li>
                                                    <a href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a>
                                                    <!-- <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a> -->
                                                </li>
                                                <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link text-secondary">Complete</a>
                                                @endif

                                            </ul>
                                            @elseif($property->status == 2 || $property->status == 3)


                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <!--<a href="#" class="card-link text-success">{{@$booking_status[$property->status]}}</a>-->
                                                    
                                                    <a href="#" class="card-link fw-bold @if ($property->status == 2)text-success @else ($property->status == 3)text-danger @endif">{{@$booking_status[$property->status]}}</a>
                                                </li>
                                                @if(Auth::user()->user_type != 4)
                                                <li>
                                                     <a href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a>
                                                    <!-- <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a> -->
                                                </li>
                                                <li>
                                                    <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link ">Complete</a>
                                                </li>
                                                @elseif($property->status == 3 &&  Auth::user()->public_id  == $property->user_id )
                                                <li>
                                                    <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                </li>
                                                
                                                @endif

                                            </ul>
                                            

                                            @elseif($property->status == 5)
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link fw-bold" style="color:darkgreen">Completed</a>
                                                </li>
                                            </ul>
                                            @elseif($property->status == 4)
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link  fw-bold">To Be Released</a>
                                                </li>
                                            </ul>
                                            @else
                                            <ul class="list-group-flush" style="list-style:none;">
                                                <li>
                                                    <a class="card-link text-primary fw-bold">Available</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                </li>
                                                @if(Auth::user()->user_type != 4)
                                                <li>
                                                    <a href="{{route('for-managment.property-status',['id' => $property->property_public_id])}}" class="card-link text-secondary">Management hold</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('for-managment.property-delete',['id' => $property->property_public_id])}}" class="card-link text-danger">Delete</a>
                                                    <!-- <a onclick="return confirm('Are you sure you want to delete this plot ?')" href="{{route('for-managment.property-delete',['id' => $property->property_public_id])}}" class="card-link text-danger">Delete</a> -->
                                                </li>
                                                @endif
                                            </ul>

                                            @endif
                                        </div>
                                    </div>
                                    @endforeach



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