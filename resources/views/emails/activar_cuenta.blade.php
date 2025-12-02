@component('mail::message')
# Activación de Cuenta

Hola {{ $user->nombre }},

Gracias por registrarte en Aventones.  
Para activar tu cuenta, haz clic en el siguiente botón:

@component('mail::button', ['url' => $url])
Activar Cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
