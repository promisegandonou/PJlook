<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation au projet</title>
</head>
<body>
    <h2>Invitation à rejoindre le projet : {{ $titre }}</h2>
    <p>Bonjour,</p>
    <p>Vous avez été invité à rejoindre le projet <strong>{{ $titre }}</strong>.</p>
    <p>Pour accepter l'invitation, cliquez sur le lien ci-dessous :</p>
    <p>
        <a href="{{ $lienInvitation }}" style="padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
            Accepter l'invitation
        </a>
    </p>
    <p>Si vous n'êtes pas concerné(e), ignorez cet email.</p>
</body>
</html>
