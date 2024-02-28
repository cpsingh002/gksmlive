@extends("dashboard.master")

@section("content")
<style>
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
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Booking Reports</h4>

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
    <form method="post" action="{{ route('scheme.get-reports') }}">
        <div class="row mt-3 mb-3">

            @csrf
            <div class="col-6 col-md-3">
                <select class="form-control schedfdf" name="scheme_id">
                    <option>Select Scheme</option>
                    @foreach($schemes as $scheme)
                    <option value="{{ $scheme->id}}">
                        {{ $scheme->scheme_name}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <input type="submit" class="btn btn-success" value="Get Report" />
            </div>

        </div>
    </form>

    @if(isset($book_properties))
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        
                        
                        
                        
                        <div class="row">
                            <div class="col-12 col-md-8">
                            <!--<table border="0" cellspacing="5" cellpadding="5">-->
                            <!--<tbody>-->
                            <!--    <tr>-->
                            <!--    <td>Start Date:</td>-->
                            <!--    <td><input type="text"  id="min" name="min"></td>-->
                            <!--</tr>-->
                            <!--<tr>-->
                            <!--    <td>End Date:</td>-->
                            <!--    <td><input type="text"  id="max" name="max"></td>-->
                            <!--</tr>-->
                            <!--</tbody>-->
                            <!--</table>   -->
                            <div class="row">
                                    <div class="col-md-4 my-2">
                                        <span>Start Date:</span>
                                        <span><input type="text"  id="min" name="min"></span>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <span>End Date:</span>
                                        <span class="ms-2"><input type="text"  id="max" name="max"></span>
                                    </div>
                                </div>
                            </div>
                        
                        
                        <div class="col-12 col-md-4 text-end">
                        <div class="btn-group submitter-group float-right">
                            <div class="input-group-prepend">
                                <div class="input-group-text1">Status:</div>
                            </div>
                            <select class="form-control status-dropdown">
                                <option value="">All</option>
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                                <option value="hold">Hold</option>
                                <option value="completed">Completed</option>
                                
                                <option value="Managment Hold">Managment Hold</option>
                                <option value="Deleted">Deleted</option>
                                
                            </select>
                        </div>
                        </div>
                        
                        </div>
                        
                        
                        
                        
                        
                        <table id="associateReportTbl" class="table table-bordered dt-responsive  w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Customer Name</th>
                                <th>Type</th>
                                 <th>Plot/Shop No</th>
                                <th>Scheme Name</th>
                                <th>Customer Adhar Number</th>
                                <th>Name</th>
                                <th>Associate Rera Number</th>
                                <th>Booking Time</th>
                                <th>Status</th>
                                <th>View Detail</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($book_properties as $book_property)
                          
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$book_property->owner_name}}</td>
                                <td>{{$book_property->plot_type}}</td>
                                  <td>{{$book_property->plot_name}}</td>
                                <td>{{$book_property->scheme_name}}</td>
                                <td>{{$book_property->adhar_card_number}}</td>
                                <td>{{$book_property->associate_name}}</td>
                                <td>{{$book_property->associate_rera_number}}</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($book_property->booking_time))}}</td>
                                 @if($book_property->property_status==3)
                                <td class="text-dark fw-bold">Deleted</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @else
                                @if($book_property->booking_status == 2)
                                <td class="text-success fw-bold">Booked</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @elseif($book_property->booking_status == 3)
                                <td class="text-danger fw-bold">Hold</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @elseif($book_property->booking_status == 4)
                                <td class="text-danger">Canceled</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @elseif($book_property->booking_status == 5)
                                <td class="fw-bold" style="color:darkgreen;">Completed</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                               @elseif(($book_property->booking_status == 1) || ($book_property->booking_status == 0))
                                <td class="text-primary fw-bold">Available</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @else
                                <td class="text-primary">Management Hold</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>
                                @endif
                                @endif


                                <!-- <td class="{{$book_property->booking_status == 2 ? 'text-success' : 'text-danger'}}">{{$book_property->booking_status == 2 ? 'Booked' : 'Hold'}}</td>
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $book_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td> -->

                            </tr>
                            @php($count++)
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endif




</div> <!-- container-fluid -->

<!-- End Page-content -->

@push('scripts')
<script>
    $('.schedfdf').chosen();
</script>
@endpush
@push('scripts')
<!-- <script>
    jQuery('.schedfdf').chosen();
</script> -->
@endpush
@endsection