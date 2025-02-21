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
                <li><a href="{{ route('welcome') }}">Accueil</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn">Se déconnecter</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- ADMIN DASHBOARD -->
<section class="admin-dashboard">
    <script src="{{ asset('js/confirmation.js') }}"></script>
    <div class="container">
        <h1>Bienvenue Admin</h1>

        <!-- FORMULAIRE POUR CRÉER DES CRÉNEAUX -->
        <h2>Créer un créneau de rendez-vous</h2>
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="admin-form">
            @csrf
            <label for="start_date_time">Date et heure de début :</label>
            <input type="datetime-local" name="start_date_time" required>

            <label for="end_date_time">Date et heure de fin :</label>
            <input type="datetime-local" name="end_date_time" required>

            <button type="submit">Créer un créneau</button>
        </form>

        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <!-- LISTE DES CRÉNEAUX DISPONIBLES -->
        <h2>Créneaux disponibles</h2>
        @if(isset($schedules) && $schedules->count() > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_date_time)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_date_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_date_time)->format('H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun créneau disponible.</p>
        @endif

        <!-- LISTE DES RENDEZ-VOUS RÉSERVÉS -->
        <h2>Liste des Rendez-vous</h2>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Date du Rendez-vous</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->user->name ?? 'Inconnu' }}</td>
                    <td>{{ $appointment->time }}</td>
                    <td>{{ $appointment->details }}</td>
                    <td>
                        <form id="delete-form-{{ $appointment->id }}" action="{{ route('admin.rdv.delete', $appointment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger" data-id="{{ $appointment->id }}">Supprimer</button>
                        </form>
                    </td>
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
