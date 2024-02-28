@extends('dashboard.blank')

@section('content')
<div class="cls-content-sm panel">
      @if(session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                    @endif
        <div class="panel-body p-3 text-center">
            <h1 class="h3 mb-3 ">{{ __('Verify Your Mobile Number') }}</h1>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A OTP  has been sent to your mobile number.') }}
                    </div>
                @endif

            {{ __('Before proceeding, please verify your mobile number.') }}
                    <form id="frmRegistar" class="needs-validation" method="post">
                       
                        <div class="row">
                            
                            <div class="col-md-6 m-auto">
                                <div class="mb-3 d-flex mt-3">
                                    <label class="form-label me-3 pt-2" for="productionImg"><strong>OTP</strong></label>
                                    <div class="input-group ">
                                        <input type="test" id="otp" name="otp" value="" class="form-control" placeholder="Enter OTP here">
                                    </div>
                                </div>
                            </div>
                        </div>
<div id="thank_you_msg"></div>
                        <div class="text-center"><button class="btn btn-primary mb-3" type="button" id="checkcoupon">Submit</button></div>
                    </form>
            {{ __('If you did not receive the OTP') }}, <a href="{{ route('verification.resendotp') }}" class="btn-link text-bold text-main"><strong>{{ __('Click here to request another OTP') }}</strong></a>.
        </div>
    </div>
    
    @endsection
    
    @push('scripts')
<script>
  
    $("#checkcoupon").click(function(e){
        var id=  $("#otp").val();
        //alert(id);
        $.ajax({
            url: '{{url('account/verifyotp')}}',
            type: 'GET',
            data: {token: id},
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                if(data.status=="error"){
                    jQuery('#thank_you_msg').html(data.message);
                }
                if(data.status=="success"){
                   
                    if({{Auth::user()->user_type}} == 1){
                      window.location.href = '{{url('/admin/')}}';
                    }else if({{Auth::user()->user_type}} == 2) {
                      window.location.href = '{{url('/production/')}}';
                    }else if ({{Auth::user()->user_type}} == 3){
                        window.location.href = '{{url('/opertor/')}}';
                    }else{
                         window.location.href = '{{url('/associate/')}}';
                    }
                   

                }
            }
        });
         
    });
</script>
   @endpush