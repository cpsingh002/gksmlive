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
                <h4 class="mb-sm-0 font-size-18">Scheme Plot history Reports</h4>

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
    <form method="post" action="{{ route('plot.history') }}">
        <div class="row mt-3 mb-3">

            @csrf
            <div class="col-6 col-md-3">
                <select class="form-control schedfdf" name="scheme_id">
                    <option>Select Scheme</option>
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
            @if(isset($plots[0]))
            <div class="col-3">
                <!-- <label class="form-label" for="teamName">Team Wise</label> -->
                <select class="form-control schedfdf" name="plot_id">
                    <option value="">Select Plot No</option>
                    @foreach($plots as $plot)
                        @if($plot->id == $plot_id)
                            <option selected value="{{ $plot->id}}">
                        @else
                            <option value="{{ $plot->id}}">
                        @endif
                                {{ $plot->plot_type}}-{{$plot->plot_name}}
                            </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-3">
                <input type="submit" class="btn btn-success" value="Get Report" />
            </div>

        </div>
    </form>

    @if(isset($plothistories[0]))
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
                                        <span><input type="text" class="date-range-filter"  id="min1" name="min1"></span>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <span>End Date:</span>
                                        <span class="ms-2"><input type="text"  class="date-range-filter" id="max1" name="max1"></span>
                                    </div>
                                </div>
                            </div>
                        
                        
                        <!-- <div class="col-12 col-md-4 text-end">
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
                        </div> -->
                        
                        </div>
                        
                        
                        
                        
                        
                        <table id="Historyplot" class="table table-bordered dt-responsive  w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Plot No</th>
                                <th>Action by</th>
                                <th>Name</th>
                                <th>contact number</th>
                                 <th>Action</th>
                                 <th>Time</th>
                                 <th>Platform</th>
                                 @if(Auth::user()->id == 2)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>


                        <tbody>
                            @php($count=1)
                            @php(
                                $user_type = [
                                        1 => 'Super Admin',
                                        2 => 'Production House',
                                        3 => 'Opertor',
                                        4=>  'Assocaite',
                                        5 => 'Visitor',
                                        ]
                            )
                            @foreach ($plothistories as $data)
                          
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$data->plotdata->plot_type}}-{{$data->plotdata->plot_name}}</td>
                                <td>@if($data->action_by == '') Cronjob @else {{$user_type[$data->userdata->user_type]}} @endif</td>
                                <td>@if($data->action_by == '') -- @else {{$data->userdata->name}} @endif</td>
                                <td>@if($data->action_by == '') -- @else {{$data->userdata->mobile_number}} @endif</td>
                                <td>{{$data->action}}</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($data->created_at))}}</td>
                                <td>@if($data->done_by == 1) Web @else App @endif</td> 
                                @if(Auth::user()->id == 2) 
                                <td><a href="{{ route('plothistory.view', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><button class="btn btn-sm btn-success">View</button></a></td>  
                                @endif
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

<script>
    
jQuery.noConflict();
  $(document).ready(function() {
      

  var table12 = $('#Historyplot').DataTable( {
        dom: 'Bfrtip',
        columnDefs: [
            {
                "targets": [6],
                "visible": true
            }
        ],
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'pageLength',
                {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ]
    });
   
    
    let minDate1, maxDate1;
 
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate1.val();
    let max = maxDate1.val();
    // alert(min);
    let date = new Date(data[6]);
//  alert(date);
    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min < date && max === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDate1 = new DateTime('#min1', {
    format: 'MMMM Do YYYY'
});
maxDate1 = new DateTime('#max1', {
    format: 'MMMM Do YYYY'
});
    document.querySelectorAll('#min1, #max1').forEach((el) => {
    el.addEventListener('change', () => table12.draw());
});

// $('.date-range-filter').change(function() {
//   table12.draw();
// });
    
    });
        
</script>
@endpush
@endsection