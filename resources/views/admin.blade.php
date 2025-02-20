<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Rendez-vous</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="container">
        <h1 class="logo">Espace Admin</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('schedules') }}">Voir les créneaux</a></li>
                <li><a href="{{ route('appointments.showAvailableAppointments') }}">Voir les rendez-vous</a></li>
                <li><a href="{{ route('logout') }}">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- ADMIN DASHBOARD -->
<section class="admin-dashboard">
    <div class="container">
        <h1>Bienvenue Admin</h1>

        <form action="{{ route('admin.schedules.store') }}" method="POST" class="admin-form">
            @csrf
            <label for="start_date_time">Date et heure de début :</label>
            <input type="datetime-local" name="start_date_time" required>

            <label for="end_date_time">Date et heure de fin :</label>
            <input type="datetime-local" name="end_date_time" required>

            <button type="submit">Créer un rendez-vous</button>
        </form>

        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <h2>Rendez-vous existants</h2>

        @if(isset($schedules) && $schedules->count() > 0)
            <div class="appointment-list">
                <ul>
                    @foreach ($schedules as $schedule)
                        <li>{{ $schedule->start_date_time }} - {{ $schedule->end_date_time }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <p>Aucun rendez-vous enregistré.</p>
        @endif
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Cabinet Kiné - Tous droits réservés</p>
</footer>

</body>
</html>
