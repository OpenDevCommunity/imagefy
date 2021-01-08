@component('mail::message')
# Dear {{ $email }}

We have a great news for you! Your invite request to join MD Share has been approved.

You can now register by clicking button bellow.

We hope that you will enjoy using MD Share.

@component('mail::button', ['url' => $link])
Register
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
