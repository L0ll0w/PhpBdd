<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedules;
use Carbon\Carbon;

class SchedulesController extends Controller
{
    public function index()
    {
        // Récupère tous les rendez-vous triés par date de début
        $schedules = Schedules::orderBy('start_date_time')->get();

        // Générer un tableau pour stocker les créneaux par date
        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $date = Carbon::parse($schedule->start_date_time)->format('Y-m-d');
            $startTime = Carbon::parse($schedule->start_date_time)->format('H:i');
            $endTime = Carbon::parse($schedule->end_date_time)->format('H:i');

            // Initialisation de la date dans le tableau si elle n'existe pas encore
            if (!isset($availableSlots[$date])) {
                $availableSlots[$date] = [];
            }

            $availableSlots[$date][] = [
                'start' => $startTime,
                'end' => $endTime,
                'booked' => false, // Mettre à jour cette valeur si un système de réservation est ajouté
            ];
        }

        // Passe la variable $schedules et $availableSlots à la vue "admin"
        return view('admin', compact('schedules', 'availableSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date_time' => 'required|date|after:now',
            'end_date_time' => 'required|date|after:start_date_time',
        ]);

        $start = $request->start_date_time;
        $end = $request->end_date_time;

        // Vérifie si un rendez-vous existe déjà sur ce créneau
        $conflict = Schedules::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_date_time', [$start, $end])
                ->orWhereBetween('end_date_time', [$start, $end])
                ->orWhere(function ($query) use ($start, $end) {
                    $query->where('start_date_time', '<=', $start)
                        ->where('end_date_time', '>=', $end);
                });
        })->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'Ce créneau est déjà réservé.');
        }

        // Enregistrement du nouveau rendez-vous
        Schedules::create([
            'start_date_time' => $start,
            'end_date_time' => $end,
        ]);

        return redirect()->back();
    }

    public function schedules()
    {
        $schedules = Schedules::orderBy('start_date_time')->get();

        // Générer les créneaux disponibles par date
        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $date = Carbon::parse($schedule->start_date_time)->format('Y-m-d');
            $startTime = Carbon::parse($schedule->start_date_time)->format('H:i');
            $endTime = Carbon::parse($schedule->end_date_time)->format('H:i');

            if (!isset($availableSlots[$date])) {
                $availableSlots[$date] = [];
            }

            $availableSlots[$date][] = [
                'start' => $startTime,
                'end' => $endTime,
                'booked' => false,
            ];
        }

        return view('schedules', compact('schedules', 'availableSlots'));
    }
}

