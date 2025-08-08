@component('mail::message')
# Introduction

<h3>{{$detels['name']}}</h3>
<h3>{{$detels['email']}}</h3>
<h3>{{$detels['phone']}}</h3>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
