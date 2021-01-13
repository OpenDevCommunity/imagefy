@component('mail::message')
# Dear {{ $email  }}

Thank You for your interest in joining {{ config('app.name') }}. Unfortuantelly we were unable to accept your request.

There are many reasons why we are unable to approve your request such as we have reached amount of users
we can accept at this time.

Not to worry! You can always request invite again at later date and we might be able to accept your request.

If you have any questions then feel free to contact us at marek@marekdev.me.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
