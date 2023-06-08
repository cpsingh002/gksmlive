@component('mail::message')
# Hello {{$mailData['name']}} , 
your one time  login password is  <b>{{$mailData['rand_id']}} </b>
<br>
<br> Please Login On GKSM Plot Booking Platform and and change your password !!
<br>
<br>


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent