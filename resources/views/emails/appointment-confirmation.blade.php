@component('mail::message')
# ✅ Confirmation de rendez-vous

Bonjour **{{ $appointment->patient->name }}**,

Votre rendez-vous a été **confirmé** avec succès. Voici les détails :

@component('mail::table')
| | |
|:--|:--|
| 🩺 **Service** | {{ $appointment->service->name }} |
| 👨‍⚕️ **Médecin** | {{ $appointment->doctor->name }} |
| 📅 **Date** | {{ $appointment->appointment_date->format('d/m/Y à H:i') }} |
| ⏱ **Durée** | {{ $appointment->service->duration_minutes }} minutes |
| 💶 **Tarif** | {{ number_format($appointment->service->price, 2) }} € |
@endcomponent

@if($appointment->notes)
> **Note :** {{ $appointment->notes }}
@endif

Merci de vous présenter 10 minutes avant l'heure de votre rendez-vous.

@component('mail::button', ['url' => config('app.url'), 'color' => 'blue'])
Accéder à votre espace
@endcomponent

Cordialement,
**L'équipe du Cabinet Médical**

@component('mail::subcopy')
Si vous n'avez pas pris ce rendez-vous, veuillez contacter notre cabinet immédiatement.
@endcomponent
@endcomponent
