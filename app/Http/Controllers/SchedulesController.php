<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SchedulesController extends Controller
{
    public function schedules()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Génération des créneaux horaires
        $availableSlots = $this->generateSchedule($currentMonth, $currentYear);

        return view('schedules', compact('currentMonth', 'currentYear', 'availableSlots'));
    }

    private function generateSchedule($month, $year)
    {
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $availableSlots = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $slots = [];

            // Créneaux matin (9h-12h)
            for ($hour = 9; $hour < 12; $hour++) {
                $slots[] = $this->createSlot($date, $hour);
            }

            // Créneaux après-midi (13h-18h)
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
}
