<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Las aplicaciones de consola registradas.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\EnviarAvisos::class,
    ];

    /**
     * Defina las tareas programadas para la aplicación.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('avisos:enviar')->dailyAt('10:30');
    }

    /**
     * Registra cualquier comando de la consola en la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
