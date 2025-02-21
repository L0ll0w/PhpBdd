<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier de réservation</title>
    <link rel="stylesheet" href="{{ asset('css/schedule.css') }}">
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
                                <button class="available"
                                        data-date="{{ $date }}"
                                        data-time="{{ $slot['start'] }}"
                                        onclick="openPopup('{{ $date }}', '{{ $slot['start'] }}', this)">
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
                    <tr data-date="{{ $schedule->start_date_time }}" data-time="{{ $schedule->start_date_time }}">
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
    <form id="reservation-form" method="POST" action="{{ route('appointments.book') }}">
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

<!-- SUCCESS POPUP -->
<div class="success-popup" id="success-popup">
    <p>✅ Votre rendez-vous a été enregistré avec succès !</p>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Cabinet Kiné - Tous droits réservés</p>
</footer>

<script>
    let selectedSlot = null;

    function openPopup(date, time, button) {
        document.getElementById('popup-date').value = date;
        document.getElementById('popup-time').value = time;
        document.getElementById('popup-overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';

        selectedSlot = button;
    }

    function closePopup() {
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
    }

    document.getElementById('reservation-form').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer le bouton du créneau réservé
                    if (selectedSlot) {
                        selectedSlot.remove();
                    }
                    closePopup();

                    // Afficher la popup de succès
                    let successPopup = document.getElementById('success-popup');
                    successPopup.style.display = 'block';

                    // Cacher la popup après 3 secondes
                    setTimeout(() => {
                        successPopup.style.display = 'none';
                    }, 3000);
                } else {
                    alert("Erreur : " + data.error);
                }
            })
            .catch(error => console.error("Erreur :", error));
    });
</script>

<style>
    .success-popup {
        display: none;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: green;
        color: white;
        padding: 15px;
        border-radius: 5px;
        font-size: 16px;
        z-index: 1000;
    }
</style>

</body>
</html>
