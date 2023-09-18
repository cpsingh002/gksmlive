@component('mail::message')
# Hello
Your @if($mailData['status']==2) Booked @else Hold @endif {{$mailData['plot_type']}} number {{$mailData['plot_name']}} at {{$mailData['scheme_name']}} has been cancelled by {{$mailData['name']}} On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
