@component('mail::message')
# Hello,

Your booked {{$mailData['plot_type']}} number {{$mailData['plot_name']}} at {{$mailData['scheme_name']}} has been completed by {{$mailData['name']}} On GKSM Plot Booking Platform !!
<br>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
