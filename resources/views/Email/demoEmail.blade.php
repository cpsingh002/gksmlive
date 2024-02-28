
@component('mail::message')
# Hello {{$mailData['name']}}

Thank you, you are Register Successfully On GKSM Plot Booking Platform !!

Please verify your email with this link: 
<a href="{{ route('user.verify', $mailData['token']) }}"><strong>Verify Email</strong></a>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
