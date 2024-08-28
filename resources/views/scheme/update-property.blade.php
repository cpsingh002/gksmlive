@extends("dashboard.master")

@section("content")
<style>
    .far{
        font-size:26px;
    }
    .table-responsive{
        margin:30px 0px;
    }
    .table th {
        max-width:200px !important;
        width:200px;
    }
    .submit_btn{
        position:absolute;
        bottom:0;
        left:50%;
        margin-bottom:14px
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Scheme Details</h4>

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
        <div class="col-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        @if(isset($property->attributes_data)) 

                        <tbody>
                        <form class="needs-validation" method="post" action="{{ route('property_plot.update') }}">
                            @csrf
                            <input type="hidden" name="scheme_id" value="{{$property->property_public_id}}">
                          <?php  $i=1; ?>
                            @foreach(json_decode($property->attributes_data) as $key=>$attr)
                            <tr>
                                @if($i == 1)
                                    <th>{{$property->plot_type}}-{{$key}}</th>
                                    <td><input type="text" name="atrriu_{{$i}}" value="{{$attr}}" class="form-control" readonly></td>
                                @else
                                    <th>{{$key}}</th>
                                    <td><input type="text" name="atrriu_{{$i}}" value="{{$attr}}" class="form-control"></td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                            @endforeach
                            <input type="hidden" name="scheme_id" value="{{$property->property_public_id}}">
                            <tr><div class="submit_btn"><button class="btn btn-primary" type="submit">Submit</button></div></tr>
                        </form>
                               
                        </tbody>
                         @else
                        <p>No Attributes Uploaded Yet.</p>
                         @endif
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection