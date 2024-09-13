@component('mail::message')
# Hello, {{ $user->name }}

We understand that it happens. Don't worry, you can reset your password by clicking the button below.

@component('mail::button', ['url' => url('reset/' . $user->remember_token)])
Reset Your Password
@endcomponent

If you encounter any issues while recovering your password, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
