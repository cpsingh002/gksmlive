@extends("dashboard.master")

@section("content")

<style>
    @media(min-width:350px) and (max-width:767px){
        .card-link+.card-link {
     margin-left: 0px !important; 
}
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


                                <div class="table-responsive">
                                    <table class="table w-100" id="myTablelist">
                                        <thead>
                                            <tr>
                                                <td>Sr.No</td>
                                                <td>Scheme Name</td>
                                                 
                                                 <td> Type</td>
                                                 
                                                 
                                                 <td> Plot/Shop No</td>
                                                 
                                                <!-- <td style="width:510px;">Attributes</td> -->

                                                 @if($properties[0]->attributes_data)
                                                 <?php $i = 0; ?>
                                                    @foreach(json_decode($properties[0]->attributes_data) as $key=>$attr)
                                                    @if($i > 1)
                                                        <td> {{$key}}</td>
                                                        
                                                    @endif
                                                    <?php $i++ ;?>
                                                    @endforeach
                                                    
                                                @endif
                                               
                                                <td>Actions</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                             @php($count=1)
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
                                            <tr>
                                                <td>{{$property->plot_no}}</td>
                                                <td>{{$property->scheme_name }}</td>
                                                
                                                <td> {{$property->plot_type}}</td>
                                                
                                                
                                                 <td> {{$property->plot_name}}</td>
                                                  
                                                
                                                    @if(json_decode($property->attributes_data))

                                                    <!--@foreach(json_decode($property->attributes_data) as $key=>$attr)-->
                                                    <!--<span>{{$key}} -> {{$attr}} &nbsp</span>-->
                                                    <!--@endforeach-->
                                                    <?php  $i=1; ?>
                                                @foreach(json_decode($property->attributes_data) as $key=>$attr)
                                                @if($i > 2)
                                                <td>
                                               

                                                
                                                 <spna> {{$attr}}</span>
                                                 
                                                 </td>
                                                 @endif
                                                 <?php $i++; ?>
                                                @endforeach
                                                @endif

                                                
                                                @if($property->freez != 1)
                                                
                                                @if($property->management_hold>0)
                                                @php (

                                                    $managment_hold = [

                                                    1 => 'Rahan',
                                                    2 => 'Possession issue',
                                                    3 => 'Staff plot',
                                                    4=> 'Executive plot',
                                                    5 => 'Associate plot',
                                                    6 => 'Other',
                                                    

                                                    ]
                                                    )
                                                <td> <span class="fw-bold" style="color:blue">{{$managment_hold[$property->management_hold]}}</span>
                                                    @if(!in_array(Auth::user()->user_type, [4,5,6]))
                                                
                                                        <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link fw-bold mx-2">Cancle</a>
                                               
                                                        <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link fw-bold text-success">Complete</a>
                                               
                                                    @endif
                                                </td>
                                                @else
                                                    @if($property->status == 5)
                                                    <td>
                                                        <a href="#" class="card-link text-primary fw-bold" style="color:darkgreen !important;">Completed</a>
                                                    </td>
                                                    @else
                                                    <td>
                                                        @if($property->status == 0  || $property->status == 1 )
                                                            <a href="#" class="card-link text-primary fw-bold">Available</a>
                                                            @if(!in_array(Auth::user()->user_type,[5,6]))
                                                                <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                                @if(Auth::user()->user_type != 4)
                                                                    <a href="{{route('for-managment.property-status',['id' => $property->property_public_id])}}" class="card-link text-secondary">Management hold</a>
                                                                @endif
                                                            @endif
                                                        @elseif($property->status == 2)
                                                            <a href="#" class="card-link text-success fw-bold">Booked</a>
                                                            @if(!in_array(Auth::user()->user_type, [4,5,6]))
                                               
                                                                <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link  fw-bold">Cancle</a>
                                               
                                                                <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link text-success  fw-bold">Complete</a>
                                                            @elseif($property->status == 3 &&  Auth::user()->public_id  == $property->user_id )
                                               
                                                                <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                
                                                
                                                            @endif
                                                        @elseif($property->status == 3)
                                                            <a href="#" class="card-link text-danger fw-bold">Hold</a>
                                                            @if(!in_array(Auth::user()->user_type, [4,5,6]))
                                                                <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link fw-bold ">Cancle</a>
                                                                <a onclick="return confirm('Are you sure you want to complete this booking ?')" href="{{route('complete.property-complete',['id' => $property->property_public_id])}}" class="card-link text-success fw-bold">Complete</a>
                                                
                                                            @elseif($property->status == 3 &&  Auth::user()->public_id  == $property->user_id )
                                               
                                                                <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                            @endif
                                                        @else
                                                            <a href="#" class="card-link text-warning fw-bold">To Be Released</a>
                                                        @endif
                                                   
                                                    </td>
                                                    @endif
                                                @endif
                                                @else
                                                <td> <span class="fw-bold" style="color:blue">Freezed</span>
                                                @endif
                                            </tr>
                                             @php($count++)
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>


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