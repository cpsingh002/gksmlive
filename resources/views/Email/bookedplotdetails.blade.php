@component('mail::message')
# Hello {{$mailData['name']}},
You have succesfuly  booked {{$mailData['plot_type']}} number {{$mailData['plot_name']}}, at {{$mailData['scheme_name']}} On GKSM Plot Booking Platform !!

<br>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
