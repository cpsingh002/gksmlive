@extends("dashboard.master")

@section("content")

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Schemes</h4>
            </div>
        </div>
        <div class="col-md-4 col-12">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> {{ session('status') }}</strong>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                                <a href="{{URL::to('/customerlistcreate')}}" type="button" class="btn btn-success waves-effect waves-light">Add New Customer</a>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Scheme Name</th>
                                    <th>Customer Name</th>
                                    <th>Contact No</th>
                                    <th>Aadhaar Card Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @php($count=1)
                                @foreach($customerlists as $customerlist)
                                    <tr>
                                        <td> {{$count++}} </td>
                                        <td>{{$customerlist->scheme->scheme_name}}</td>
                                        <td>{{$customerlist->owner_name}}</td>
                                        <td>{{$customerlist->contact_no}}</td>
                                        <td>{{$customerlist->adhar_card_number}}</td>
                                        <td><a onclick="return confirm('Are you sure you want to delete ?')" href="{{ route('customerlist.destroy', ['id' => $customerlist->id]) }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-recycle text-danger"></i></a></td> 
                                    </tr>   
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