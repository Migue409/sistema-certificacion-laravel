<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EnviarAvisos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:avisos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Funcion que se ejecuta automaticamente a las 12:00 am para el recordatorio de las actividades a los alumnos que esten inscritos en esta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $actividades = DB::table('actividades')
            ->select(
                'actividades.*',
                'usuarios.*',
                DB::raw('(SELECT u.nombre FROM usuarios u WHERE u.id_usuario = actividades.id_usuario) AS nombre_profesor_actividad')
            )
            ->join('citas', 'actividades.id_actividad', '=', 'citas.id_actividad')
            ->join('reservas', 'citas.id', '=', 'reservas.id_cita')
            ->join('usuarios', 'usuarios.id_usuario', '=', 'reservas.id_usuario')
            ->whereDate('actividades.fecha', '=', DB::raw('DATE_ADD(CURDATE(), INTERVAL 3 DAY)'))
            ->get();

        foreach ($actividades as $msn) {
            try {
                $nombre = $msn->nombre;
                $actividad = $msn->actividad;
                $destinatario = $msn->correo;
                $aula = $msn->salon;
                $nomDoc = $msn->nombre_profesor_actividad;
                $fecha = $msn->fecha;
                $tipoMsn = 3;
                $logoUrl = asset('images/logoCoordinacion.png');

                $mailController = new MailController();
                $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividad, $nombre, $logoUrl);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        $this->info('Avisos enviados correctamente.');
    }
}
