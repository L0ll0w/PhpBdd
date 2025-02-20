<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier de réservation</title>
    <link rel="stylesheet" href="{{ asset('css/schedule.css') }}">
    <style>
        .booked {
            display: none; /* Masquer les créneaux réservés */
        }
        .available {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .available:hover {
            background-color: #388E3C;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="container">
        <h1 class="logo">Espace Client</h1>
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
    <div class="container">
        <h1>Calendrier de réservation</h1>

        <div class="calendar-container">
            <div class="calendar-days">
                @foreach($availableSlots as $date => $slots)
                    <div class="day">{{ $date }}
                        @foreach($slots as $slot)
                            @if(!$slot['booked'])
                                <button class="available" onclick="openPopup('{{ $date }}', '{{ $slot['start'] }}')">
                                    {{ $slot['start'] }} - {{ $slot['end'] }}
                                </button>
                            @endif
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
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            @foreach($schedules as $schedule)
                @if(!$schedule->booked)
                    <tr>
                        <td>{{ $schedule->id }}</td>
                        <td>{{ $schedule->start_date_time }}</td>
                        <td>{{ $schedule->end_date_time }}</td>
                        <td>Disponible</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- POPUP FORM -->
<div class="popup-overlay" id="popup-overlay"></div>
<div class="popup" id="popup">
    <h2>Confirmer votre réservation</h2>
    <form method="POST" action="{{ route('appointments.book') }}">
        @csrf
        <input type="hidden" id="popup-date" name="date">
        <input type="hidden" id="popup-time" name="time">
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>
        <br><br>
        <button type="submit" class="btn btn-primary">Confirmer</button>
        <button type="button" class="btn" onclick="closePopup()">Annuler</button>
    </form>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Cabinet Kiné - Tous droits réservés</p>
</footer>

<script>
    function openPopup(date, time) {
        document.getElementById('popup-date').value = date;
        document.getElementById('popup-time').value = time;
        document.getElementById('popup-overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
    }
    function closePopup() {
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
    }
</script>

</body>
</html>
