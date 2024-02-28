@component('mail::message')
# Hello
{{$mailData['plot_type']}} number {{$mailData['plot_name']}} at {{$mailData['scheme_name']}}, Payment Proof verified by {{$mailData['by']}} On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
{{ config('app.name') }}
@endcomponent