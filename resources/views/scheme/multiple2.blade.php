@extends("dashboard.master")

@section("content")
<style>
    .c1{
        background-color: #ffeb3b !important;
    }
    .c2{
        background-color: #03a9f4 !important;
    }
    .c3{
        background-color: #ff9800 !important;
    }
    .c4
    {
        background-color: #3f51b5 !important;
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Multiple Property Book/Hold Form</h4>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                    <label class="form-check-label" for="flexSwitchCheckDefault">For Hindi</label>
                </div>
                <!--<div class="page-title-right">-->
                <!--    <ol class="breadcrumb m-0">-->
                <!--        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>-->
                <!--        <li class="breadcrumb-item active">Form Validation</li>-->
                <!--    </ol>-->
                <!--</div>-->

            </div>
        </div>
    </div>
    <!-- end page title -->
    
   <form class="needs-validation" method="post" action="{{ route('property.multi_plotbook_property') }}" enctype="multipart/form-data" id="submitform23">
    @csrf
    
    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    @if(isset($customerlists[0]))
                    <div style="display:flex">
                        <div>
                            <p>Please select your age:</p>
                        </div>
                            <div>
                                @for($i = 1; $i <= $customerlists->count(); $i++ )

                                <input type="radio" id="c{{$i}}" name="customer" value="{{$i}}"  @if($i == 1) checked @endif>
                                <label for="c{{$i}}">For Customer{{$i}}</label>
                                @endfor
                            </div>
                            
                    </div>
                    @endif
                    <div class="plot-select-box">
                       <ol class="cabin fuselage">
                           <li class="row">
                              <ol class="seats" >
                                @foreach($properties as $property)
                                    <li class="seat">
                                        <input type="hidden" name="plot_type[]" value="{{substr($property->plot_type, 0, 1)}}" id="tpye{{$property->plot_no}}">
                                        <!-- <input type="checkbox" class="single-checkbox" name="plot_name[]" value ="{{$property->plot_no}}" id="{{$property->plot_no}}" /> -->
                                        <label for="{{$property->plot_no}}" id="tpyel{{$property->plot_no}}"  onclick="myFunction('{{$property->plot_no}}')">{{substr($property->plot_type, 0, 1)}} - {{$property->plot_name}}</label>
                                    </li>
                                @endforeach
                              </ol>
                            </li>
                        </ol>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                  
                        <div class="row">
                            <input type="hidden" value="{{ $scheme_detail->id}}" name="scheme_id" />
                            @php($sn =1)
                            @foreach($customerlists as $customerlist)
                            <div class="col-md-{{12/$customerlists->count()}}">
                                <h4>Customer {{$sn}}</h4>
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="owner_name[{{$customerlist->id}}]"  value ="{{$customerlist->owner_name}}" class="form-control @error('owner_name') is-invalid @enderror" id="owner_named"  readonly>
                                     @error('owner_name') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label" for="schemeName">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="ploat_status[{{$customerlist->id}}]"  required>
                                            <option value="">Select Property Status</option>
                                            <option value="2">Book</option>
                                            @if($scheme_detail->hold_status == 0)
                                            <option value="3">Hold</option>
                                            @endif
                                            <!--<option value="4">Cancel</option>-->
                                        </select>
                                    </div>
                             
                            
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Aadhaar Card Number<span class="text-danger">*</span></label>
                                    <input type="number" name="adhar_card_number[{{$customerlist->id}}]" value ="{{$customerlist->adhar_card_number}}" onKeyPress="if( this.value.length == 12 ) return false; " required class="form-control" id="schemeImg" readonly>
                                    @error('adhar_card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Contact Number </label>
                                    <input type="number" name="contact_no[{{$customerlist->id}}]" value="{{$customerlist->contact_no}}" class="form-control @error('contact_no') is-invalid @enderror" readonly>
                                    @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="carray[{{$customerlist->id}}]" value="" id="c{{$sn}}array">
                            </div>
                            @php($sn++)
                            @endforeach
                            <!-- end col -->

                            
                        </div>

                        <div class="text-center"><button class="btn btn-primary" type='submit'>Submit</button></div>
                    <!--</form>-->
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->
    
    </form>

</div> <!-- container-fluid -->
@push('scripts')



<script>
    var pcount = 0;
    var ccount = 0;
    var c4array = [];
    var c3array =[];
    var c2array = [];
     var c1array = [];

    var lucn  = '{{$scheme_detail->lunch_date}}';
    const now = '{{now()->subMonths(1)->format('Y-m-d H:i:s')}}';
    if(new Date(now) <= new Date(lucn))
    {
        // alert('Associates can select multiple shops without any limit on shops and other units like Plot, Villa, Farmhouse can select only two units-Only');
        function myFunction($id){
            var type =  $('#tpye'+$id).val();
            // alert(pcount);
            // alert( $('input[name="customer"]:checked').val())
            var ctype = $('input[name="customer"]:checked').val();
            if(ctype == '1')
            {
                var arr = c1array;
                
            } else if(ctype=='2')
            {
                var arr = c2array;
            } else if (ctype =='3')
            {
                var arr = c3array;
            } else if(ctype == '4')
            {
                var arr = c4array;
            }
            if($('#tpyel'+$id).hasClass('c'+ctype))
            {
                // alert($('#tpyel'+$id).attr('class'));
                if($(this).hasClass(''))
                {
                    alert('allrjkeady');
                }else{
                $('#tpyel'+$id).removeClass('c'+ctype);
                arr = arr.filter(function(item) {
                        return item !== $id
                    });
                if(ctype == '1')
                {
                    c1array =  arr;
                } else if(ctype=='2')
                {
                    c2array = arr;
                } else if (ctype =='3')
                {
                    c3array = arr;
                } else if(ctype == '4')
                {
                    c4array = arr;
                }
                // alert(arr);
                $('#c'+ctype+'array').val(arr)
                // alert('remobed');
            }
            }else{
                // alert($('#tpyel'+$id).attr('class'));
                if($('#tpyel'+$id).hasClass('') === false)
                {
                    alert('Already Selected for other customer');
                }else{
                    if(arr.length >= 2)
                    {
                        alert('Maximum 2 Unit Selected for one customer');
                    }else{
                        $('#tpyel'+$id).addClass('c'+ctype);
                        // alert(arr.length);
                        arr.push($id);
                        $('#c'+ctype+'array').val(arr)
                        // alert('added');
                    }
                }
            }
        }
    }else{
        // alert('Associates can select multiple Shops, Plot, Villa and Farmhouse without any limit.');
        function myFunction($id){
            var type =  $('#tpye'+$id).val();
            // alert(pcount);
            // alert( $('input[name="customer"]:checked').val())
            var ctype = $('input[name="customer"]:checked').val();
            if(ctype == '1')
            {
                var arr = c1array;
                
            } else if(ctype=='2')
            {
                var arr = c2array;
            } else if (ctype =='3')
            {
                var arr = c3array;
            } else if(ctype == '4')
            {
                var arr = c4array;
            }
            if($('#tpyel'+$id).hasClass('c'+ctype))
            {
                // alert($('#tpyel'+$id).attr('class'));
                if($(this).hasClass(''))
                {
                    alert('allrjkeady');
                }else{
                $('#tpyel'+$id).removeClass('c'+ctype);
                arr = arr.filter(function(item) {
                        return item !== $id
                    });
                if(ctype == '1')
                {
                    c1array =  arr;
                } else if(ctype=='2')
                {
                    c2array = arr;
                } else if (ctype =='3')
                {
                    c3array = arr;
                } else if(ctype == '4')
                {
                    c4array = arr;
                }
                // alert(arr);
                $('#c'+ctype+'array').val(arr)
                // alert('remobed');
            }
            }else{
                // alert($('#tpyel'+$id).attr('class'));
                if($('#tpyel'+$id).hasClass('') === false)
                {
                    alert('Already Selected for other customer');
                }else{
                    if(arr.length >= 2)
                    {
                        alert('Maximum 2 Unit Selected for one customer');
                    }else{
                        $('#tpyel'+$id).addClass('c'+ctype);
                        // alert(arr.length);
                        arr.push($id);
                        $('#c'+ctype+'array').val(arr)
                        // alert('added');
                    }
                }
            }
        }
    }


  
</script>

<script>
    // function myFunctionc($id){
    //     // alert($id);
    //     var sdsf = $('#c'+$id+'array').val();
    //     // alert(sdsf);
    //     sdsf.filter(function(item) {
    //         return  $("#"+item).attr("disabled", true);    
    //     });
    // }
</script>
    
    
@endpush
@endsection