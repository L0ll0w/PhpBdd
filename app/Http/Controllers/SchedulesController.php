<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedules;
use App\Models\Appointments;
use Carbon\Carbon;



class SchedulesController extends Controller
{
    /**
     * Afficher la liste des créneaux disponibles.
     */
    public function index()
    {
        // Récupère tous les créneaux non réservés
        $schedules = Schedules::where('booked', false)->orderBy('start_date_time')->get();

        // Générer un tableau pour stocker les créneaux par date
        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $date = Carbon::parse($schedule->start_date_time)->format('Y-m-d');
            $startTime = Carbon::parse($schedule->start_date_time)->format('H:i');
            $endTime = Carbon::parse($schedule->end_date_time)->format('H:i');

            if (!isset($availableSlots[$date])) {
                $availableSlots[$date] = [];
            }

            $availableSlots[$date][] = [
                'id' => $schedule->id,
                'start' => $startTime,
                'end' => $endTime,
                'booked' => $schedule->booked, // Vérifie si le créneau est réservé
            ];
        }

        return view('schedules', compact('schedules', 'availableSlots'));
    }

    /**
     * Enregistrer un nouveau créneau disponible.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date_time' => 'required|date|after:now',
            'end_date_time' => 'required|date|after:start_date_time',
        ]);

        $start = $request->start_date_time;
        $end = $request->end_date_time;

        // Vérifier s'il y a un conflit avec un créneau existant
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

        // Enregistrer le créneau
        Schedules::create([
            'start_date_time' => $start,
            'end_date_time' => $end,
            'booked' => false,
        ]);

        return redirect()->back()->with('success', 'Créneau ajouté avec succès.');
    }

    /**
     * Supprimer un créneau
     */
    public function destroy($id)
    {
        $schedule = Schedules::findOrFail($id);

        // Vérifie si le créneau est réservé avant de le supprimer
        if ($schedule->booked) {
            return redirect()->back()->with('error', 'Impossible de supprimer un créneau réservé.');
        }

        $schedule->delete();
        return redirect()->back()->with('success', 'Créneau supprimé avec succès.');
    }

    /**
     * Marquer un créneau comme réservé après une prise de rendez-vous
     */
    public function markAsBooked($id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->update(['booked' => true]);

        return response()->json(['success' => 'Créneau marqué comme réservé.']);
    }

    /**
     * Afficher les créneaux et les rendez-vous
     */
    public function schedules()
    {
        // Récupère tous les créneaux
        $schedules = Schedules::orderBy('start_date_time')->get();

        // Récupère tous les rendez-vous pour afficher les réservations existantes
        $appointments = Appointments::orderBy('date')->get();

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
                'id' => $schedule->id,
                'start' => $startTime,
                'end' => $endTime,
                'booked' => $schedule->booked, // Marque les créneaux réservés
            ];
        }

        return view('schedules', compact('schedules', 'availableSlots', 'appointments'));
    }
}
