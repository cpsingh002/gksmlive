@component('mail::message')
# Hello {{$mailData['name']}},
You have succesfuly  booked plot number {{$mailData['plot_no']}} at {{$mailData['scheme_name']}} On GKSM Plot Booking Platform !!

<br>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
