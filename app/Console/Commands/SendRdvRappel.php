<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RdvConfirmationMail;

class SendRdvRappel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappel:rdv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un email de rappel la veille du rendez-vous';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set on the next day's date
        $tomorrow = Carbon::tomorrow()->startOfDay();
        $rdvs = Appointments::whereDate('date', $tomorrow)->get();

        // Each appointment is retrieved to send an e-mail
        foreach ($rdvs as $rdv) {
            Mail::to($rdv->email)->send(new RdvConfirmationMail($rdv));
        }

        // Success message
        $this->info('Emails de rappel envoyés avec succès.');
    }
}
