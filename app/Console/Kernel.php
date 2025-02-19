<?php

namespace App\Console;

class Kernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rappel:rdv')->dailyAt('08:00');
    }

}
