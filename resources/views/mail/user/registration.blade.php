<x-mail::message>

<x-mail::panel>
Hi {{ $user->name }},

Thank you for registering with us! Please click the button below to verify your email address and complete your registration.

<x-mail::button :url="$verificationUrl">
    Verify Email Address
</x-mail::button>

If you did not create an account, no further action is required.
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}

</x-mail::message>
