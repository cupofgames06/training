<x-mail::message>
# Bonjour {!! $data['user']->profile->full_name !!},

{!! $data['of']->entity->name !!} vous a créé un compte Manager sur la Plateforme F Immobilier.
Pour finaliser l’ouverture de votre compte, merci de cliquer sur le lien ci-dessous pour choisir votre mot de passe.

<x-mail::button :url="$data['url']">
Activer mon compte
</x-mail::button>

<x-mail::subcopy>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ac ipsum ut justo facilisis lobortis at ac leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
</x-mail::subcopy>
</x-mail::message>
