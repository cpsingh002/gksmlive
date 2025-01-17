@extends("dashboard.master")

@section("content")
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
    
    
   <form class="needs-validation" method="post" action="{{ route('property.multi_book_property') }}" enctype="multipart/form-data" id="submitform23">
    @csrf
    
    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="plot-select-box">
                       <ol class="cabin fuselage">
                           <li class="row">
                              <ol class="seats" >
                                @foreach($properties as $property)
                                    <li class="seat">
                                        <input type="hidden" name="plot_type[]" value="{{substr($property->plot_type, 0, 1)}}" id="tpye{{$property->plot_no}}">
                                        <input type="checkbox" class="single-checkbox" name="plot_name[]" value ="{{$property->plot_no}}" id="{{$property->plot_no}}" />
                                        <label for="{{$property->plot_no}}" onclick="myFunction('{{$property->plot_no}}')">{{substr($property->plot_type, 0, 1)}} - {{$property->plot_name}}</label>
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Name</label>
                                    <input type="text" name="associate_name" value="{{Auth::user()->name}}" readonly class="form-control" id="schemeName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Contact Number</label>
                                    <input type="text" name="associate_number" value="{{Auth::user()->mobile_number}}" readonly class="form-control" id="schemeName">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Rera Number</label>
                                    <input type="text" name="associate_rera_number" value="{{Auth::user()->associate_rera_number}}" readonly class="form-control" id="schemeName">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                     <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="txtMessaged" id="owner_name" >
                                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="owner_named" >
                                    <div id="newinput"></div>
                                    @error('owner_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('ploat_status') is-invalid @enderror" name="ploat_status" required>
                                        <option value="">Select Property Status</option>
                                        <option value="2">Book</option>
                                         @if($scheme_detail->hold_status == 0)
                                        <option value="3">Hold</option>
                                        @endif
                                        <!--<option value="4">Cancel</option>-->
                                    </select>
                                    @error('ploat_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Contact Number </label>
                                    <input type="number" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror">
                                    @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Address </label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="schemeImg">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Payment Mode</label>
                                    <select class="form-control" name="payment_mode">
                                        <option value="0">Select Payment Mode</option>
                                        <option value="1">RTGS/IMPS</option>
                                        <option value="2">Bank Transfer</option>
                                        <option value="3">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Cheque Photo</label>
                                    <input type="file" name="cheque_photo" class="form-control" id="schemeImg">
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Aadhaar Card Number<span class="text-danger">*</span></label>
                                    <input type="number" name="adhar_card_number" onKeyPress="if( this.value.length == 12 ) return false; " required class="form-control" id="schemeImg">
                                    @error('adhar_card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Aadhaar Card Photo</label>
                                    <input type="file" name="adhar_card" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer PAN Card Number</label>
                                    <input type="text" name="pan_card_no" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer PAN Card Photo</label>
                                    <input type="file" name="pan_card_image" class="form-control" id="schemeImg">
                                    <!-- <textarea name="txtMessage" id="txtMessaged"></textarea> -->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Attachment</label>
                                    <input type="file" name="attachement" class="form-control" id="schemeImg">
                                </div>
                            </div>
                            
                            
                            @php $loop_taxed_count=1; @endphp
                             <div id="append-data-form"></div>
                                <div class="col-md-2">
                                    <div class="form-group change">
                                       <!--<label for="">&nbsp;</label><br/>-->
                                       @if($loop_taxed_count < '2')
                                       <a class="btn btn-success add-more mb-2" id="add-more" onclick="add_tax_more()" >+ Add More</a>
                                       @endif
                                    </div>
                                </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Description</label>
                                   <input type="text" name="description" class="form-control @error('description') is-invalid @enderror descriptiond"  id="txtMessage" id="description">                                    
                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror description" id="descriptiond">
                                    
                                    <div id="newinput1"></div>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


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
    $(function () {
        $('input[id="txtMessage"]').hide();
        $('input[id="txtMessaged"]').hide();

        //show it when the checkbox is clicked
        $('#flexSwitchCheckDefault').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[id="txtMessage"]').fadeIn();
                $('input[id="txtMessaged"]').fadeIn();
                $('input[id="owner_named"]').remove();
                $('input[id="descriptiond"]').remove();
                
            } else {
                $('input[id="txtMessage"]').hide();
                $('input[id="txtMessaged"]').hide();
                newRowAdd1 ='<input type="text" name="description" class="form-control @error('description') is-invalid @enderror descriptiond"  id="txtMessage" id="description">'; 
                newRowAdd ='<input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="owner_named">'; 
            $('#newinput').append(newRowAdd);
            $('#newinput1').append(newRowAdd1);
            }
        });
    });
</script>
<script type="text/javascript">
        google.load("elements", "1", { packages: "transliteration" });
        var control;
        function onLoad() {         
            var options = {
                //Source Language
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                // Destination language to Transliterate
                destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };                     
            control = new google.elements.transliteration.TransliterationControl(options);  
            control.makeTransliteratable(['txtMessage','txtMessaged']);   
        }
        google.setOnLoadCallback(onLoad);         
</script>
<script>
   	// $("#add-more").on("click", function() {  
	// 		$("#append-data-form").append('<div class="append-data"><div class="row"><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label><input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="schemeName">@error('owner_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Status</label><select class="form-control" name="ploat_status"><option>Select Property Status</option><option value="2">Book</option><option value="3">Hold</option><!--<option value="4">Cancel</option>--></select></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Contact No <span class="text-danger">*</span></label><input type="number" min="1" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" id="schemeImg">@error('contact_no')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Address </label><input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="schemeImg">@error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Payment Mode</label><select class="form-control" name="payment_mode"><option value="0">Select Payment Mode</option><option value="1">RTGS/IMPS</option><option value="2">Bank Transfer</option><option value="3">Cheque</option></select></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Adhar Card</label><input type="file" name="adhar_card" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">cheque Photo</label><input type="file" name="cheque_photo" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Attachment</label><input type="file" name="attachement" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Number</label><input type="number" name="pan_card_no" class="form-control" id="schemeImg"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">PAN Card Photo</label><input type="file" name="pan_card_image" class="form-control" id="schemeImg"></div></div><br/></div></div>');
   	// });   	
   	$("#removeEmail").on("click", function() {  
		$("#more-email").children().last().remove();  
	});  
       
    var loop_tax_count=1; 
    var loop_count=0; 
    var number=0;
    function add_tax_more(){
        // alert(loop_count);
        loop_tax_count++;
        // alert(loop_tax_count);
        if(loop_tax_count-loop_count<4){
            var html='<div class="add_box_'+loop_tax_count+'"><input id="piid" type="hidden" name="piid[]" value=""><div class="append-data mt-2"><h3 class="mb-2">Add Co-Applicant</h3><div class="row"><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label><input type="text" name="owner_namelist[]" class="form-control @error('owner_name') is-invalid @enderror" id="schemeName" required>@error('owner_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Contact Number </label><input type="number" name="contact_nolist[]" class="form-control @error('contact_no') is-invalid @enderror" id="schemeImg">@error('contact_no')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Address </label><input type="text" name="addresslist[]" class="form-control @error('address') is-invalid @enderror" id="schemeImg">@error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Aadhaar Card Number<span class="text-danger">*</span></label><input type="number" name="adhar_card_number_list[]" class="form-control" id="schemeImg" onKeyPress="if( this.value.length == 12 ) return false; " required>@error('adhar_card_number_list')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Aadhaar Card Photo</label><input type="file" name="adhar_cardlist[]" class="form-control"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer PAN Card Number</label><input type="text" name="pan_card_nolist[]" class="form-control"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer PAN Card Photo</label><input type="file" name="pan_card_imagelist[]" class="form-control"></div></div><div class="col-md-12"><div class="mb-3"><label class="form-label" for="schemeImg">Attachment</label><input type="file" name="attachementlist[]" class="form-control"></div></div><br/></div></div>';
                html+='<div class="col-md-2"><div class="row mb-3 ms-1 property_tax_'+loop_tax_count+'""><button type="button" class="btn btn-danger mt-2" style="width:auto;" onclick=remove_tax_more("'+loop_tax_count+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></div></div></div>'; 
        }else{
            var html='';
            loop_tax_count--;
        }  
        jQuery('#append-data-form').append(html)
    }
    function remove_tax_more(loop_tax_count){
        jQuery('.add_box_'+loop_tax_count).remove();
        loop_count++;
    }
</script>


<script>
    // $(".single-checkbox").on("click", function() {
    //     alert("rrrr")
    // }
    // );
    //         $('input[type=checkbox]').change(function(e){
    //   if ($('input[type=checkbox]:checked').length > 2) {
    //         $(this).prop('checked', false)
    //         alert("You can select maximum 2 properties");
    //   }
    // })
</script>
<script>
    var pcount = 0;
    var ccount = 0;
    var lucn  = '{{$scheme_detail->lunch_date}}';
    const now = '{{now()->subMonths(1)->format('Y-m-d H:i:s')}}';
    if(new Date(now) <= new Date(lucn))
    {
        alert('Associates can select multiple shops without any limit on shops and other units like Plot, Villa, Farmhouse can select only two units-Only');
        function myFunction($id){
        var type =  $('#tpye'+$id).val();
        // alert(pcount);
        if(type !== "S")
        {
            if(type !== "S")
            {
                pcount++;
                if(pcount  >= 3)
                {
                    ccount++;
                    // alert(pcount);
                    // $('input[type=checkbox]').change(function(e){
                    // //$('#'+$id).prop('checked', false);
                    // $('#'+$id).prop('checked', false).removeAttr('checked');
                    // alert("You can select maximum 2 properties");
                    // });
                    $('#'+$id).click(function() {
                        if(this.checked){
                            pcount = 0;
                            ccount = 0
                            // alert(pcount);
                            $("input[type=checkbox]").prop('checked', false);
                            //   alert("You can select maximum 2 properties");
                            //    $('#'+$id).prop('checked', false).removeAttr('checked');
                            window.location.reload();
                        }
                    });         
                }else{
                    $('#'+$id).click(function() {
                        if(!this.checked){
                            pcount--;
                            //   $('#'+$id).prop('checked', false).removeAttr('checked');
                            //   alert('ljkh');
                        }
                    });
                }          
            }  
        }
    };
    }else{
        alert('Associates can select multiple Shops, Plot, Villa and Farmhouse without any limit.');
        function myFunction($id){
        }
    }
</script>
    
    
@endpush
@endsection