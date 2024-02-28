@extends("dashboard.master")

@section("content")
<style>
.text-shadow{
    padding: 3px 13px;
    box-shadow: 2px 2px 2px 2px #807f7f;
}
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
     .input-group-text1{
        padding: 0.47rem 0.35rem;
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
                    <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="btn-group submitter-group float-right w-100">
                            <div class="input-group-prepend">
                                <div class="input-group-text1">Status:</div>
                            </div>
                            <select class="form-control" id="status-dropdown">
                                <option value="">All</option>
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                                <option value="hold">Hold</option>
                                <option value="completed">Completed</option>
                                
                                <!--<option value="Managment Hold">Managment Hold</option>-->
                                <option value="to be released">Cancelled</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="page-title-box float-end mt-3 mt-md-0 mt-xl-0  d-flex">
                            <label class="me-2 mt-1 search-input">Search:</label>
                            <input type="text" id="myInput" name="name" onkeyup="myFunction()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{url('/property/multiple-book-hold')}}/{{$scheme_detail->id}}" class="btn btn-primary ms-3">Select Multiple Plots</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-body" >
                            <div class="row g-4" id="myUL">
                                <?php $i=1; ?> 
                                    @foreach ($properties as $property)
                                    @php (
                                        $booking_status = [
                                        2 => 'Booked',
                                        3 => 'Hold'
                                        ]) 
                                    @php (
                                        $managment_color = [
                                                0 =>'aaa',
                                                1 => 'Rahan',
                                                2 => 'border-success shadow-green',
                                                3 => 'border-danger shadow-red',
                                                4=>  'shadow-violet',
                                                5 => 'shadow-teal',
                                                6 => 'border-info shadow-blue',
                                                ])
                                    @php($usrename = username($property->user_id))
                                        
                                <div class="col-md-4 search-box">
                                    <!--<div class="card {{isset($color[$property->status]) ? $color[$property->status] : 'out of borders';}}" style="width: 18rem;">-->
                                    <!--<div class="card @if($property->status == 2) border-success @elseif($property->status == 3) border-danger @endif" style="width: 18rem;">-->
                                    <div class="card {{$managment_color[$property->status]}}">
                                        <div class="card-body">
                                            <div class="row">
                                                @if(Auth::user()->user_type != 4)
                                                    <div class="col-md-6"><a href="{{ route('view.property', ['id' => $property->property_public_id]) }}">
                                                        <!-- <h5 class="card-title">S. No {{$property->plot_no }}</h5> -->
                                                        <h5 class="card-title">Sr. No. {{$property->plot_no}}</h5>
                                                    </a></div>
                                                @else
                                                     <div class="col-md-6"><h5 class="card-title">Sr. No. {{$property->plot_no}}</h5> </div>
                                                @endif
                                                <div class="col-md-6"><h5 class="card-title float-end text-shadow">{{$property->plot_type}}</h5></div>
                                                                                            </div>
                                                 @if(($property->status != 1) && ($property->status != 0))

                                                <p class="card-text">{{$property->description }}</p>
                                                @endif
                                            </div>
                                            
                                            @if(json_decode($property->attributes_data))
                                            <ul class="list-group list-group-flush">
                                                 <?php  $i=1; ?>
                                                @foreach(json_decode($property->attributes_data) as $key=>$attr)
                                                  @if($i == 1)
                                                <li class="list-group-item">{{$property->plot_type}}-{{$key}} -> {{$attr}}</li>
                                                @else
                                                 <li class="list-group-item">{{$key}} -> {{$attr}}</li>
                                                  @endif
                                                <?php $i++; ?>
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
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <ul class="list-group-flush" style="list-style:none;">
                                                            <li>
                                                                <a href="#" class="card-link  fw-bold" style="color:blue;">{{$managment_hold[$property->management_hold]}}</a>
                                                                <p class="mb-0">
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
                                                    </div>
                                                    <div class="col-md-5">
                                                        <p><strong>By :{{ $usrename}} </strong></p>
                                                        <p>List</p>
                                                    </div>
                                                </div>
                                                
                                            @elseif($property->status == 2 || $property->status == 3)

                                            <div class="row">
                                                <div class="col-md-7">
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
                                                        @if(Auth::user()->user_type != 4 &&  $property->status == 3 &&  Auth::user()->public_id  == $property->user_id)
                                                        <li>
                                                            <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click Here to Book/Hold</a>
                                                        </li>
                                                        @endif
                                                         @if(Auth::user()->user_type != 4 && ($property->status == 2 || $property->status == 3))
                                                        <li>
                                                            <a href="{{ route('property.edit_customer', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Edit Customer Details</a>
                                                        </li>
                                                        @endif
        
                                                    </ul>
                                                </div>
                                                
                                                
                                                <div class="col-md-5">
                                                    <p><strong>By :{{$usrename}}</strong></p>
                                                    <span><strong>List</strong> <span>10</span>
                                                </div>
                                            </div>
                                            
                                            

                                            @elseif($property->status == 5)
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <ul class="list-group-flush" style="list-style:none;">
                                                        <li>
                                                            <a class="card-link fw-bold" style="color:darkgreen">Completed</a>
                                                        </li>
                                                        @if(Auth::user()->user_type == 1)
                                                        <li>
                                                             <!-- <a href="{{route('cancel.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a> -->
                                                             <a onclick="return confirm('Are you sure you want to cancel this booking ?')" href="{{route('complete.property-cancel',['id' => $property->property_public_id])}}" class="card-link text-danger">Cancle</a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="col-md-5">
                                                    <p><strong>By : {{$usrename}}</strong></p>
                                                     <span><strong>List</strong> <span>10</span>
                                                </div>
                                            </div>
                                            
                                            @elseif($property->status == 4)
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <ul class="list-group-flush" style="list-style:none;">
                                                        <li>
                                                            <a class="card-link  fw-bold">To Be Released</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- <div class="col-md-5">
                                                    <p><strong>By : {{$usrename}}</strong></p>
                                                     <span><strong>List</strong> <span>10</span>
                                                </div> -->
                                            </div>
                                            
                                            @else
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <ul class="list-group-flush" style="list-style:none;">
                                                        <li>
                                                            <a class="card-link text-primary fw-bold">Available</a>
                                                        </li>
                                                        @if(Auth::user()->user_type == 4 && Auth::user()->public_id  == $property->user_id && $property->cancel_time > now()->subDay(1)->format('Y-m-d H:i:s') )
                                                        <li>
                                                            <!--<a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click herde Book/Hold</a>-->
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a href="{{ route('property.book-hold', ['scheme_id' => $property->scheme_id, 'property_id' => $property->property_public_id]) }}" class="card-link">Click here Book/Hold</a>
                                                        </li>
                                                        @endif
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
                                                </div>
                                                <!-- <div class="col-md-5">
                                                    <p><strong>By : {{$usrename}}</strong></p>
                                                     <span><strong>List</strong> <span>10</span>
                                                </div> -->
                                            </div>
                                            

                                            @endif
                                        </div>
                                    </div>
                                    <?php $i++; ?>
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


<script>

// function myFunction() {
//   alert("You pressed a key inside the input field");
// }

function myFunction(){
   
    var value = $("#myInput").val();
     var str = value || '';
    //  var result = str.toLowerCase();

  
        
  $('#myUL .search-box').each(function(){
    // var lcval = $(this).text();
    var lcval = $(this).text().toLowerCase();
    
    
    var searchValue = value.toLowerCase(); // Convert the search value to lowercase
    if(lcval.indexOf(searchValue) > -1){
        // if(lcval.indexOf(value)>-1){
      $(this).show();
    } else {
      $(this).hide();
    }
  });
};
     

      
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    //  $('.status-dropdown').change( function(){
    //   var value = $(this).val();
      
      
      $('#status-dropdown').change(function() {

  var value = $(this).val();
      
       $('#myUL .search-box').each(function(){
    var lcval = $(this).text().toLowerCase();
    // alert(lcval);
    if(lcval.indexOf(value)>-1){
      $(this).show();
    } else {
      $(this).hide();
    }
  });
     })
</script>
@endsection