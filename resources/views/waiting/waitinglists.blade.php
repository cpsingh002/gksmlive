@extends("dashboard.master")

@section("content")

<div class="container-fluid">
    @if(isset($data[0]))
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Waiting list Details</h4>
    
                    
    
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-12">
    
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
    
                            <tbody>
                                
                                <tr>
                                    <th>SN</th>
                                    <th>Customer Name</th>
                                    @if (Auth::user()->user_type != 4 )
                                    <th>Customer Addhar Number</th>@endif
                                    <th>Associate Name</th>
                                    <th>Associate Contact Number</th>
                                    <th>Associate Rera Number</th>
                                    <!--<th>Cheque_photo</th>-->
                                    <!--<th>Attachment</th>-->
                                    <th>Booking Time</th>
                                     @if (Auth::user()->user_type == 1 || Auth::user()->user_type == 2 )
                                    <th>Action</th>@endif
                                    
                                </tr>
                                @php $sn=1; @endphp
                                  @foreach($data as $list)
                                    <tr>
                                      <th>{{$sn}}</th>
                                      <td>{{$list->owner_name}}</td>
                                       @if (Auth::user()->user_type != 4 )<td>{{$list->adhar_card_number}}</td>@endif
                                      <td>{{$list->associate_name}}</td>
                                      <td>{{$list->associate_number}}</td>
                                      <td>{{$list->associate_rera_number}}</td>
                                      <!--<td>@if($list->cheque_photo !='')<a href="{{URL::to('/customer/cheque',$list->cheque_photo)}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$list->cheque_photo)}}" style="height:25px;width:45px;"></a>@endif</td>-->
                                      <!--<td>@if($list->attachment !='')<a href="{{URL::to('/customer/attach',$list->attachment)}}" download target="_blank"><i class='far fa-file-alt'></i></a>@endif</td>-->
                                      <td>{{date('d-M-y H:i:s', strtotime($list->booking_time))}}</td>
                                        <!--<td>{{$list->subCategories}}</td>-->
                                        @if(Auth::user()->user_type == 1)
                                      <td>
                                            <a onclick="return confirm('Are you sure you want to assign plot to this associate ?')" href="{{ route('waiting.save', ['id' => $list->id]) }}" data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Assign</button></a>
                                            <a onclick="return confirm('Are you sure you want to delete this associate  waiting booking ?')" href="{{ route('waiting.destroy', ['id' => $list->id]) }}" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a>  
                                      </td>
                                      @elseif(Auth::user()->user_type ==2)
                                      <td>
                                            <a onclick="return confirm('Are you sure you want to assign plot to this associate ?')" href="{{ route('waiting.savep', ['id' => $list->id]) }}" data-toggle="tooltip" data-placement="top" title="Accept"><button class="btn btn-sm btn-success">Assign</button></a>
                                            <a onclick="return confirm('Are you sure you want to delete this associate  waiting booking ?')" href="{{ route('waiting.destroyp', ['id' => $list->id]) }}" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-sm btn-danger">Cancel</button></a>  
                                      </td>
                                      @endif
                                    </tr>
                                    @php $sn++; @endphp
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
