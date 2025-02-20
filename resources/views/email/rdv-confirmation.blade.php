<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirmation de rendez-vous</title>
    </head>
    <body>
        <h1>Bonjour</h1>
        <p>Votre rendez-vous a bien été pris en compte.</p>
        <p><strong>Date :</strong> {{ $rdv->date_time->format('d/m/Y H:i') }}</p>
        <p>Merci de votre confiance.</p>
        <p>Cabinet de Kinésithérapeute</p>
    </body>
</html>
