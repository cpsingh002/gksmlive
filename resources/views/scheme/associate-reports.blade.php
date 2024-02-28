@extends("dashboard.master")

@section("content")

<style>
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
                <h4 class="mb-sm-0 font-size-18">Complete Booking Reports</h4>

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

    @if($propty_report_details)
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        
                        
                        <div class="row">
                            <div class="col-12 col-md-8">
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
                            </div>
                        
                        
                        <div class="col-12 col-md-4 text-end">
                        <div class="btn-group submitter-group float-right">
                            <div class="input-group-prepend">
                                <div class="input-group-text1">Status:</div>
                            </div>
                            <select class="form-control status-dropdown">
                                <option value="">All</option>
                                <option value="booked">Booked</option>
                                <option value="hold">Hold</option>
                                <option value="completed">Completed</option>
                                
                                <option value="Managment Hold">Managment Hold</option>
                                
                            </select>
                        </div>
                        </div>
                        
                        </div>
                    
                    
                    
                    
                        <table class="table table-bordered dt-responsive associateReportTbl w-100 " id="associateReportTbl">
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
                                <th>View Details</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @foreach ($propty_report_details as $report_property)
                                
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$report_property->owner_name}}</td>
                                <td>{{$report_property->plot_type}}</td>
                                <td>{{$report_property->plot_name}}</td>
                                <td>{{$report_property->scheme_name}}</td>
                                <td>{{$report_property->adhar_card_number}}</td>
                                <td>{{$report_property->associate_name}}</td>
                                <td>{{$report_property->associate_rera_number}}</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($report_property->booking_time))}}</td>
                                @if($report_property->management_hold>0)
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
                                <td> <a href="#" class="card-link text-primary fw-bold">Managment Hold</a></td>
                                    @else
                                    @if($report_property->booking_status == 5)
                                        <td><a href="#" class="card-link fw-bold" style="color:darkgreen">Completed</a></td>
                                    @elseif($report_property->booking_status == 1)
                                    <td><a href="#" class="card-link text-primary fw-bold">Available</a></td>
                                    @elseif($report_property->booking_status == 2)
                                    <td><a href="#" class="card-link text-success fw-bold">Booked</a></td>
                                    @elseif($report_property->booking_status == 3)
                                    <td><a href="#" class="card-link text-danger fw-bold">Hold</a></td>
                                    @else
                                    <td><a href="#" class="card-link text-danger">Canceled</a></td>
                                    @endif
                                    @endif
                                <!--<td class="{{$report_property->booking_status == 2 ? 'text-success' : 'text-danger'}}">{{$report_property->booking_status == 2 ? 'Booked' : 'Hold'}}</td>-->
                                <td class=""><a href="{{ route('show.report-detail', ['id' => $report_property->property_public_id]) }}" ata-toggle="tooltip" data-placement="top" title="view Detail"><i class="fas fa-info-circle text-info"></i></a></td>


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
@endsection