
@component('mail::message')
# Hello
{{$mailData['plot_type']}} number {{$mailData['plot_name']}} at {{$mailData['scheme_name']}} has been cancelled and it going to available in 30 min On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
{{ config('app.name') }}
@endcomponent