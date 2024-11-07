@extends("dashboard.master")

@section("content")

<style>
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
        height: 33px;
    }
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
                                            <option value="Managment Hold">Management Hold</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <form method="post" action="{{ route('repots.option.details') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-10 my-2">
                                        <div class="row">
                                            <div class="col-3">
                                                <select class="form-control schedfdf" name="scheme_id">
                                                    <option value ="">Select Scheme</option>
                                                    @foreach($schemes as $scheme)
                                                        @if($scheme->id==$scheme_id)
                                                            <option selected value="{{$scheme->id}}">
                                                        @else
                                                            <option value="{{ $scheme->id}}">
                                                        @endif
                                                            {{ $scheme->scheme_name}}
                                                            </option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control schedfdf" name="team_id">
                                                    <option value="">Select Team</option>
                                                    @foreach($teams as $team)
                                                        @if($team->public_id == $team_id)
                                                            <option selected value="{{ $team->public_id}}">
                                                        @else
                                                            <option value="{{ $team->public_id}}">
                                                        @endif
                                                                {{ $team->team_name}}
                                                            </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3">
                                            
                                                <select class="form-control schedfdf" name="production_id">
                                                    <option value="">Select Production</option>
                                                    @foreach($productions as $production)
                                                        @if($production->public_id == $production_id)
                                                            <option selected value="{{ $production->public_id}}">
                                                        @else
                                                            <option value="{{ $production->public_id}}">
                                                        @endif
                                                                {{ $production->production_name}}
                                                            </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <input type="submit" class="btn btn-success form-control" value="Get Report" />
                                            </div>                                    
                                        </div>
                                    </div>          
                                </div>
                            </form>
                    
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
                                        <th>Gaj</th>
                                        @if($propty_report_details[0]->attributes_data)
                                            <?php $i = 0; ?>
                                            @foreach(json_decode($propty_report_details[0]->attributes_data) as $key=>$attr)
                                            @if($i > 1)
                                                <td> {{$key}}</td>    
                                            @endif
                                            <?php $i++ ; $j = $i;?>
                                            @endforeach    
                                        @endif
                                        <th>Associate Upliner name</th>
                                        <th>Upliner rera number</th>
                                        <th>Team name</th>
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
                                                    6 => 'Other',
                                                    ]
                                                )
                                                <td> <a href="#" class="card-link">Management Hold</a></td>
                                            @else
                                                @if($report_property->booking_status == 5)
                                                    <td><a href="#" class="card-link fw-bold" style="color:darkgreen">Completed</a></td>
                                                @elseif(($report_property->booking_status == 1) || ($report_property->booking_status == 0))
                                                        @if($report_property->status == 1)
                                                            <td><a href="#" class="card-link text-primary fw-bold">Available</a>
                                                        @else
                                                        <td><a href="#" class="card-link  text-dark fw-bold">Deleted</a>
                                                        @endif
                                                @elseif($report_property->booking_status == 2)
                                                    <td><a href="#" class="card-link text-success fw-bold">Booked</a>
                                                @elseif($report_property->booking_status == 3)
                                                    <td><a href="#" class="card-link text-danger fw-bold">Hold</a>
                                                @else
                                                    <td><a href="#" class="card-link text-danger">Canceled</a>
                                                @endif
                                                @if($report_property->freez == 1)
                                                    <span>[Freezed]</span>
                                                @endif
                                                </td>
                                            @endif
                                                <td>{{$report_property->gaj}}</td>
                                                @if(isset($report_property->attributes_data))                              
                                                    <?php  $i=0; ?>
                                                    @foreach(json_decode($report_property->attributes_data) as $key=>$attr)
                                                        @if(($i > 1)&&($i < $j))
                                                            <td><spna> {{$attr}}</span></td>
                                                        @endif
                                                        <?php $i++; ?>
                                                    @endforeach
                                                @else
                                                <?php $i =2;?>
                                                @endif
                                                                         
                                                @for($y= $i; $y < $j; $y++)
                                                    <td><spna>{{$y}}</span></td>
                                                
                                                @endfor
                                            <td>{{$report_property->applier_name}}</td>
                                            <td>{{$report_property->applier_rera_number}}</td>
                                            <td>{{$report_property->team_name}}</td>
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

@push('scripts')
<script>
    $('.schedfdf').chosen();
</script>
@endpush
@endsection