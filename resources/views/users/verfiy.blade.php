@extends('dashboard.blank')

@section('content')
    <div class="cls-content-sm panel">
        <div class="panel-body p-3">
            <h1 class="h3 mb-3">{{ __('Verify Your Email Address') }}</h1>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="btn-link text-bold text-main"><strong>{{ __('Click here to request another') }}</strong></a>.
        </div>
    </div>
    
    
     
@endsection