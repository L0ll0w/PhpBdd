<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier de réservation</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="container">
        <h1 class="logo">Espace Client</h1>
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
        <h1>Calendrier de réservation</h1>

        <div class="calendar-container">
            <div class="calendar-days">
                @foreach($availableSlots as $date => $slots)
                    <div class="day">{{ $date }}
                        @foreach($slots as $slot)
                            <form method="POST" action="{{ route('appointments.book') }}">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">
                                <input type="hidden" name="time" value="{{ $slot['start'] }}">
                                <button type="submit" class="{{ $slot['booked'] ? 'booked' : 'available' }}" {{ $slot['booked'] ? 'disabled' : '' }}>
                                    {{ $slot['start'] }} - {{ $slot['end'] }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <h2>Liste des créneaux disponibles</h2>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->id }}</td>
                    <td>{{ $schedule->start_date_time }}</td>
                    <td>{{ $schedule->end_date_time }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Cabinet Kiné - Tous droits réservés</p>
</footer>

</body>
</html>
