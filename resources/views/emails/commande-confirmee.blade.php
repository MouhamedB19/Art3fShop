@component('mail::message')
# Merci pour votre commande, {{ $commande->client->prenom }} !

Votre commande **#{{ $commande->id }}** du {{ $commande->date_commande->format('d/m/Y') }} a bien été validée.

@component('mail::table')
| Œuvre | Artiste | Prix |
| :---- | :------ | ---: |
@foreach($commande->tirages as $tirage)
    | {{ $tirage->oeuvre->titre }} |
    {{ $tirage->oeuvre->artiste?->nom_d_artiste ?: $tirage->oeuvre->artiste?->user->nom . ' ' . $tirage->oeuvre->artiste?->user->prenom }}
    | {{ number_format($tirage->prix, 2) }} € |
@endforeach
@endcomponent

Sous-total : **{{ number_format($totalBrut, 2) }} €**

@if($reduction > 0)
    Réduction appliquée : **-{{ number_format($reduction, 2) }} €**
@endif

## Total : {{ number_format($totalNet, 2) }} €

@if($commande->est_cadeau)
    🎁 Cette commande est marquée comme cadeau.

    @if($commande->message_cadeau)
        > {{ $commande->message_cadeau }}
    @endif
@endif

@component('mail::button', ['url' => route('compte.commandes.show', $commande)])
Voir ma commande
@endcomponent

Merci de votre confiance,<br>
L'équipe art3f
@endcomponent