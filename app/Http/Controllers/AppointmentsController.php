<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AppointmentsController extends Controller
{
    public function showAvailableAppointments($month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $availableSlots = $this->generateSchedule($month, $year);

        return view('appointments.index', compact('month', 'year', 'availableSlots'));
    }

    private function generateSchedule($month, $year)
    {
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $availableSlots = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $slots = [];

            for ($hour = 9; $hour < 12; $hour++) {
                $slots[] = $this->createSlot($date, $hour);
            }

            for ($hour = 13; $hour < 18; $hour++) {
                $slots[] = $this->createSlot($date, $hour);
            }

            $availableSlots[$date->format('Y-m-d')] = $slots;
        }

        return $availableSlots;
    }

    private function createSlot($date, $hour)
    {
        $startDateTime = $date->copy()->hour($hour)->minute(0);
        $endDateTime = $startDateTime->copy()->addHour();

        $isBooked = Appointments::where('date', $startDateTime->toDateString())
            ->where('time', $startDateTime->toTimeString())
            ->exists();

        return [
            'start' => $startDateTime->format('H:i'),
            'end' => $endDateTime->format('H:i'),
            'booked' => $isBooked
        ];
    }

    public function bookAppointment(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required|string|max:255',
        ]);

        // Vérifier si le créneau est déjà réservé
        $existingAppointment = Appointments::where('date', $request->date)
            ->where('time', $request->time)
            ->first();

        if ($existingAppointment) {
            return back()->with('error', 'Ce créneau est déjà réservé.');
        }

        // Enregistrement du rendez-vous avec description
        Appointments::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'time' => $request->time,
            'details' => $request->description,
        ]);

        return back()->with('success', 'Votre rendez-vous a bien été réservé.');
    }
}
