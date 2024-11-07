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
                <h4 class="mb-sm-0 font-size-18">User Action history Reports</h4>

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
    <form method="post" action="{{ route('user.history') }}">
        <div class="row mt-3 mb-3">

            @csrf
            <div class="col-6 col-md-3">
                <label class="form-label" for="productionName">User Email id<span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="productionName" name="email" placeholder="Enter user email id" value="{{$email}}" required>
            </div>
           
            <div class="col-4">
                <!-- <label class="form-label" for="teamName">Team Wise</label> -->
                 <p> Select for User action type</p>
                <input type="radio" id="actionby" name="type" value="by">
                <label class="form-label" for="actionby">Done BY</label><br>
                <input type="radio" id="actionover" name="type" value="over">
                <label class="form-label" for="actionover">Over By</label><br>
            </div>
            
            <div class="col-3">
                <input type="submit" class="btn btn-success" value="Get Report" />
            </div>

        </div>
    </form>

    @if(isset($datas[0]))
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
                        </div>
                        
                        
                        
                        
                        
                        <table id="Historyplot" class="table table-bordered dt-responsive  w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>User By </th>
                                <th>Action</th>
                                <th>User To</th>
                                <th>Time</th>
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
                            @foreach ($datas as $data)
                          
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$data->userby->name}}</td>
                                <td>{{$data->action}}</td>
                                <td>@if($data->user_to == '') -- @else @if(isset($data->userto)) {{$data->userto->name}} @else deleted @endif @endif</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($data->created_at))}}</td>
                                @if(Auth::user()->id == 2) 
                                <td><a href="{{ route('userhistory.view', ['id' => $data->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><button class="btn btn-sm btn-success">View</button></a></td>  
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
                "targets": [4],
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
    let date = new Date(data[4]);
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