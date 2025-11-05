<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NotificacionMailable;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function enviarCorreo($destinatario,$aula, $docente, $fecha,$tipoMsn,$actividad,$nombre,$logoUrl)
    {
        try {
            Mail::to($destinatario)->send(new NotificacionMailable($aula,$docente,$fecha,$tipoMsn,$actividad,$nombre,$logoUrl)); 
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('ActExt.mails.AsignacionActividadProfesor', compact('logoUrl'));
    }
}
