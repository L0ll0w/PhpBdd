<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier de réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
        .calendar-container {
            text-align: center;
        }
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            justify-items: center;
            margin-top: 20px;
        }
        .day {
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
        }
        .available {
            background-color: #4CAF50;
            color: white;
        }
        .booked {
            background-color: #E74C3C;
            color: white;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

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

</body>
</html>
