@component('mail::message')
# Hello,

Your booked plot number {{$mailData['plot_no']}} at {{$mailData['scheme_name']}} has been completed by {{$mailData['name']}} On GKSM Plot Booking Platform !!
<br>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
