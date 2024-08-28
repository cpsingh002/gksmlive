@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Attributes</h4>

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

                            <div class="page-title-right">
                                <a href="{{URL::to('/add-attribute')}}" type="button" class="btn btn-success waves-effect waves-light">Add Attribute</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Attribute Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                        @php($count=1)
                        

                            @foreach ($attributes as $attribute)
                            @if($attribute->id == 22)
                             <tr>
                                <td>{{$count}}</td>
                                <td>{{$attribute->attribute_name}}</td>
                                 <td >
                              
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-success">Active</a>
                                <td>
                                    <span>Fixed attribute can't change</span>
                                </td>

                            </tr>
                            
                            @else

                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$attribute->attribute_name}}</td>
                                 <td >
                                @if($attribute->status==1)
                                    <a href="{{route('attribute.status',['id'=>$attribute->public_id,'status'=>0])}}" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-success">Active</a>
                                 @elseif($attribute->status==0)
                                    <a href="{{route('attribute.status',['id'=>$attribute->public_id,'status'=>1])}}" data-toggle="tooltip" data-placement="top" title="Change Status" class="text-warning">Deactive</a>
                                @endif
                                <!-- <a href="{{ route('attribute.edit', ['id' => $attribute->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Change Status">{{$attribute->status == 1 ? 'Active' : 'Deactive'}}</a> --> </td> 
                                
                                <td>
                                    <a href="{{ route('attribute.edit', ['id' => $attribute->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt text-primary"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('attribute.destroy', ['id' => $attribute->public_id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a>
                                </td>

                            </tr>
                            @endif
                            @php($count++)
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- container-fluid -->

<!-- End Page-content -->
@endsection