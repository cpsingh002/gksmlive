@extends("dashboard.master")

@section("content")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(()=>{
            $("#ploat_status").val('{{$propty_detail->booking_status}}');
            // $("#payment_mode").val('{{$propty_detail->payment_mode}}');
            
        });   
</script>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Property Book/Hold Details</h4>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                    <label class="form-check-label" for="flexSwitchCheckDefault">For Hindi</label>
                </div>
                
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="offset-xl-2 col-xl-8">
            <div class="card">

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class="needs-validation" method="post" action="{{ route('property.update_customer') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" value="{{ $property_data->property_id}}" name="property_id" />

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Name</label>
                                    <input type="text" name="associate_name" value="{{Auth::user()->name}}" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Number</label>
                                    <input type="text" name="associate_number" value="{{Auth::user()->mobile_number}}" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Associate Rera Number</label>
                                    <input type="text" name="associate_rera_number" value="{{Auth::user()->associate_rera_number}}" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                     <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="txtMessaged" id="owner_name" value="{{$propty_detail->owner_name}}" readonly>
                                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" id="owner_named" value="{{$propty_detail->owner_name}}" readonly>
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
                                    <label class="form-label" for="schemeName">Status</label>
                                    <select class="form-control" name="ploat_status" id="ploat_status">
                                        <option>Select Property Status</option>
                                        <option value="2">Book</option>
                                        <!--<option value="4">Cancel</option>-->

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Contact Number <span class="text-danger">*</span></label>
                                    <input type="number"  name="contact_no" value="{{$propty_detail->contact_no}}" class="form-control @error('contact_no') is-invalid @enderror" @if($propty_detail->contact_no) readonly  @endif>
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
                                    <input type="text" name="address" value="{{$propty_detail->address}}" class="form-control @error('address') is-invalid @enderror" @if($propty_detail->address) readonly  @endif>
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
                                    <select class="form-control" name="payment_mode" id="payment_mode">
                                        <option value="0">Select Payment Mode</option>
                                        <option value="1">RTGS/IMPS</option>
                                        <option value="2">Bank Transfer</option>
                                        <option value="3">Cheque</option>
                                    </select>
                                </div>
                            </div>
                             -->
                            <!-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Cheque Photo</label>
                                    
                                    @if($propty_detail->cheque_photo !='')
                                        <input type="file" name="cheque_photo" class="form-control" value="{{$propty_detail->cheque_photo}}" disabled>
                                        <a href="{{URL::to('/customer/cheque',$propty_detail->cheque_photo)}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$propty_detail->cheque_photo)}}" class="ms-2" style="height:25px;width:45px;"></a>
                                    @else
                                    <input type="file" name="cheque_photo" class="form-control">
                                    @endif
                                </div>
                            </div> -->

                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Aadhaar Card Number<span class="text-danger">*</span></label>
                                    <input type="text" name="adhar_card_number"  value="{{$propty_detail->adhar_card_number}}" class="form-control" id="schemeImg"  readonly >
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer Aadhaar Card Photo</label>
                                    
                                    @if($propty_detail->adhar_card !='')
                                        <input type="file" name="adhar_card"  class="form-control" value="{{$propty_detail->adhar_card}}" disabled>
                                        <a href="{{URL::to('/customer/aadhar',$propty_detail->adhar_card)}}" download target="_blank"><img src="{{URL::to('/customer/aadhar',$propty_detail->adhar_card)}}" class="ms-2" style="height:25px;width:45px;"></a>
                                    @else
                                    <input type="file" name="adhar_card"  class="form-control">
                                    @endif
                                </div>
                            </div>

                            

                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer PAN Card Number</label>
                                    <input type="text" name="pan_card_no" value="{{$propty_detail->pan_card}}" class="form-control" @if($propty_detail->pan_card) readonly  @endif>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Customer PAN Card Photo</label>
                                   
                                    @if($propty_detail->pan_card_image !='')
                                    <input type="file" name="pan_card_image" class="form-control" value="{{$propty_detail->pan_card_image}}" disabled>
                                        <a href="{{URL::to('/customer/pancard',$propty_detail->pan_card_image)}}" download target="_blank"><img src="{{URL::to('/customer/pancard',$propty_detail->pan_card_image)}}" class="ms-2" style="height:25px;width:45px;"></a>
                                     @else
                                      <input type="file" name="pan_card_image" class="form-control">
                                        <!-- <textarea name="txtMessage" id="txtMessaged"></textarea> -->
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Attachment</label>
                                    
                                    @if($propty_detail->attachment !='')
                                    <input type="file" name="attachement" class="form-control" value="{{$propty_detail->attachment}}" disabled>
                                        <a href="{{URL::to('/customer/attach',$propty_detail->attachment)}}" download target="_blank"><img src="{{URL::to('/customer/attach',$propty_detail->attachment)}}" class="ms-2" style="height:25px;width:45px;"></a>
                                    @else
                                    <input type="file" name="attachement" class="form-control">
                                    @endif                                
                                </div>
                            </div>
                            @php $loop_taxed_count=1; @endphp
                            @foreach($multi_customer as $key=>$val)
                                @php 
                                $loop_count_prev=$loop_taxed_count;
                                $TarArr=(array)$val;
                                @endphp

                                <script type="text/javascript">
                                    $(document).ready(()=>{
                                            $("#paymenmt_mode_{{$key}}").val('{{$TarArr['payment_mode']}}');
                                            
                                        });   
                                </script>
                                <div class="add_box_{{$loop_taxed_count++}}">
                                    <input id="piid" type="hidden" name="piid[]" value="{{$TarArr['id']}}">
                                    <div class="append-data mt-2"><h3 class="mb-2">Add Co-Applicant</h3>
                                        <div class="row"><div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label>
                                                <input type="text" name="owner_namelist[]" value ="{{$TarArr['owner_name']}}" class="form-control @error('owner_name') is-invalid @enderror" readonly>
                                                    @error('owner_name')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer Contact Number</label>
                                                <input type="number" name="contact_nolist[]" value ="{{$TarArr['contact_no']}}" class="form-control @error('contact_no') is-invalid @enderror" >
                                                    @error('contact_no')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer Address </label>
                                                <input type="text" name="addresslist[]" value ="{{$TarArr['address']}}" class="form-control @error('address') is-invalid @enderror" >
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Cheque Photo</label>
                                                
                                                @if($TarArr['cheque_photo'] !='')
                                                    <input type="file" name="cheque_photolist[]" class="form-control" value="{{$TarArr['cheque_photo']}}" disabled>
                                                    <a href="{{URL::to('/customer/cheque',$TarArr['cheque_photo'])}}" download target="_blank"><img src="{{URL::to('/customer/cheque',$TarArr['cheque_photo'])}}" class="ms-2" style="height:25px;width:45px;"></a>
                                                @else
                                                <input type="file" name="cheque_photolist[]" class="form-control">
                                                @endif
                                            </div>
                                        </div> -->
                                        
                                        
                                        
                                         <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer Aadhaar Card Number<span class="text-danger">*</span></label>
                                                <input type="text" name="adhar_card_number_list[]" value ="{{$TarArr['adhar_card_number']}}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer Aadhaar Card Photo</label>
                                                
                                                @if($TarArr['adhar_card'] !='')
                                                <input type="file" name="adhar_cardlist[]" class="form-control" value="{{$TarArr['adhar_card']}}" disabled>
                                                    <a href="{{URL::to('/customer/aadhar',$TarArr['adhar_card'])}}" download target="_blank"><img src="{{URL::to('/customer/aadhar',$TarArr['adhar_card'])}}" class="ms-2" style="height:25px;width:45px;"></a>
                                                @else
                                                <input type="file" name="adhar_cardlist[]" class="form-control">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer PAN Card Number</label>
                                                <input type="text" name="pan_card_nolist[]" value ="{{$TarArr['pan_card']}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Customer PAN Card Photo</label>
                                                
                                                @if($TarArr['pan_card_image'] !='')
                                                    <input type="file" name="pan_card_imagelist[]" class="form-control" value="{{$TarArr['pan_card_image']}}" disabled>
                                                    <a href="{{URL::to('/customer/pancard',$TarArr['pan_card_image'])}}" download target="_blank"><img src="{{URL::to('/customer/pancard',$TarArr['pan_card_image'])}}" class="ms-2" style="height:25px;width:45px;"></a>
                                                @else
                                                <input type="file" name="pan_card_imagelist[]" class="form-control">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="schemeImg">Attachment</label>
                                                
                                                @if($TarArr['attachment'] !='')
                                                     <input type="file" name="attachementlist[]" class="form-control" value="{{$TarArr['attachment']}}" disabled>
                                                    <a href="{{URL::to('/customer/attach',$TarArr['attachment'])}}" download target="_blank"><img src="{{URL::to('/customer/attach',$TarArr['attachment'])}}" class="ms-2" style="height:25px;width:45px;"></a>
                                                @else
                                                <input type="file" name="attachementlist[]" class="form-control">
                                                @endif
                                            </div>
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            @endforeach
                            
                              <div id="append-data-form"></div> 
                              <div class="col-md-2">
                               <div class="form-group change">
                                   <label for="">&nbsp;</label><br/>
                                    
                                   <a class="btn btn-success add-more mb-2" id="add-more" onclick="add_tax_more({{$loop_taxed_count - 1}})" >+ Add More</a>
                                  
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="schemeImg">Description</label>
                                   <input type="text" name="description" value="{{$propty_detail->description}}" class="form-control @error('description') is-invalid @enderror descriptiond"  id="txtMessage" id="description" readonly>                                    
                                    <input type="text" name="description"  value="{{$propty_detail->description}}" class="form-control @error('description') is-invalid @enderror description" id="descriptiond" readonly>
                                    
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

                        <div class="text-center"><button class="btn btn-primary" type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->


    </div>
    <!-- end row -->

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
   	
   	
		$("#removeEmail").on("click", function() {  
			$("#more-email").children().last().remove();  
		});  


        var loop_tax_count=1; 
        var loop_count=0; 
        var number=0;
   function add_tax_more(precount){
      // alert(loop_count);
    
      loop_tax_count++;
     
      // alert(loop_tax_count);
   
      if(loop_tax_count-loop_count<(4-precount)){
      var html='<div class="add_box_'+loop_tax_count+'"><input id="piid" type="hidden" name="piid[]" value=""><div class="append-data mt-2"><h3 class="mb-2">Add Co-Applicant</h3><div class="row"><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeName">Customer Name <span class="text-danger">*</span></label><input type="text" name="owner_namelist[]" class="form-control @error('owner_name') is-invalid @enderror" id="schemeName" required>@error('owner_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Contact Number</label><input type="number" name="contact_nolist[]" class="form-control @error('contact_no') is-invalid @enderror">@error('contact_no')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Address </label><input type="text" name="addresslist[]" class="form-control @error('address') is-invalid @enderror">@error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Aadhar Card Number<span class="text-danger">*</span></label><input type="text" name="adhar_card_number_list[]" onKeyPress="if( this.value.length == 12 ) return false; " class="form-control" id="schemeImg" required></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer Aadhaar Card Photo</label><input type="file" name="adhar_cardlist[]" class="form-control"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer PAN Card Number</label><input type="text" name="pan_card_nolist[]" class="form-control"></div></div><div class="col-md-6"><div class="mb-3"><label class="form-label" for="schemeImg">Customer PAN Card Photo</label><input type="file" name="pan_card_imagelist[]" class="form-control"></div></div><div class="col-md-12"><div class="mb-3"><label class="form-label" for="schemeImg">Attachment</label><input type="file" name="attachementlist[]" class="form-control"></div></div><br/></div></div>';
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
@endpush
@endsection