@component('mail::message')
# Dear {{ $email }}

Thank You for showing interest in joining {{ config('app.name') }}. As this is a private project and not
available to general public we do allow for users to request an invite. Please note that
not all requests are approved and there are many factors that can interfere with your request
such as we have reached users limit that we have set.

All requests are being reviewed from Monday - Friday @ 8:00 am - 10:00 pm (GMT) and Saturday - Sunday @ 11:00 am - 00:00 am (GMT).

We will do our best to get back to you within the next 48 hours. Please note that this is an estimated timeframe and might
not be met.

If you have any questions then feel free to send us an email to marek@marekdev.me

Thanks,<br>
{{ config('app.name') }}
@endcomponent
