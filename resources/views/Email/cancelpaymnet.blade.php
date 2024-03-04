@component('mail::message')
# Hello
{{$mailData['plot_type']}} number {{$mailData['plot_name']}} at {{$mailData['scheme_name']}}, Payment Proof canceled by {{$mailData['by']}} and Reason is {{$mailData['reason']}} On GKSM Plot Booking Platform !!

<br>

Thanks,<br><br>
{{ config('app.name') }}
@endcomponent