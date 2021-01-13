@component('mail::message')
# New Invite Request

A new invite request has been submitted by {{ $email }}.

To accept or reject please login to administartion dashboard by
clicking on button bellow.

@component('mail::button', ['url' => $url])
View Pending Invite Requests
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
