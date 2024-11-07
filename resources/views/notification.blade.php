@extends("dashboard.master")

@section("content")
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Notifications</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Notifications</a></li>
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>

            </div>
        </div>
        <div class="col-4">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> {{ session('status') }}</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-2  bg-danger">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-0 text-white">Notification from last 7 days</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                       <table class="example1 table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <td>S.No.</td>
                                <td>Action</td>
                                <td>Msg</td>
                                <!--<td>Plot Number</td>-->
                                <td>Time</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count=1)
                            @forelse($notices as $note)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$note->action}}</td>
                                <td>{{$note->msg}}</td>                                
                                <td>{{date('d-M-Y H:i:s', strtotime($note->created_at))}}</td>
                                
                            </tr>
                            @php($count++)
                            @endforeach
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('scripts')

@endpush
