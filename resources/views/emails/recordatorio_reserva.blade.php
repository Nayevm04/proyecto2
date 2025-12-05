@component('mail::message')

# Recordatorio de Reserva Pendiente

Hola **{{ $chofer->nombre }}**,  
Tienes reservas pendientes por revisar.

---

Por favor ingresa a tu cuenta para gestionar esta solicitud.

Gracias,<br>
{{ config('app.name') }}

@endcomponent



