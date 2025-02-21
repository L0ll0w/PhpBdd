<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client - Espace de réservation</title>
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
</head>

<body>
<div class="container">
    <h1>Bienvenue dans votre espace client</h1>
    <p>Consultez et réservez vos horaires en toute simplicité.</p>

    <a href="{{ route('schedules') }}" class="btn">Voir les horaires</a>
</div>
</body>

</html>
