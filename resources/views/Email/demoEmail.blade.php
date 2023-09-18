
@component('mail::message')
# Hello {{$mailData['name']}}

Thank you, you are Register Successfully as a associate On GKSM Plot Booking Platform !!

Please verify your email with bellow link: 
<a href="{{ route('user.verify', $mailData['token']) }}">Verify Email</a>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
