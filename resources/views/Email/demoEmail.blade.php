@component('mail::message')
# Introduction

{{$mailData['body']}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
