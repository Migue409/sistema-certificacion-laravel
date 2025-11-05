<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $fecha;
    public $aula;
    public $docente;
    public $actividad;
    public $nombre;
    public $tipoMsn;
    public $logoUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($aula, $docente, $fecha, $tipoMsn,$actividad,$nombre,$logoUrl)
    {
        $this->fecha = $fecha;
        $this->aula = $aula;
        $this->docente = $docente;
        $this->tipoMsn = $tipoMsn;
        $this->actividad = $actividad;
        $this->nombre = $nombre;
        $this->logoUrl = $logoUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tienes una nueva notificación de la coordinación de inglés.',
        );
    }

    public function build()
    {
        
        if ($this->tipoMsn == 1) {
            $vista = 'ActExt.mails.ConfirmacionCitaAlumno';
        } elseif ($this->tipoMsn == '2') {
            $vista = 'ActExt.mails.CancelacionCitaAlumno';
        } elseif ($this->tipoMsn == '3') {
            $vista = 'ActExt.mails.RecordatorioCitaAlumno';
        } elseif ($this->tipoMsn == '4') {
            $vista = 'ActExt.mails.EdicionCitaAlumno';
        } elseif ($this->tipoMsn == '5') {
            $vista = 'ActExt.mails.AsignacionActividadProfesor';
        } elseif ($this->tipoMsn == '6') {
            $vista = 'ActExt.mails.CancelacionActividadProfesor';
        } elseif ($this->tipoMsn == '7') {
            $vista = 'ActExt.mails.EdicionActividadProfesor';
        }

        $logo = $this->logoUrl;
    
        return $this->subject('Aviso de actividad Extracurricular de Inglés')
            ->view($vista);
    }

    /**
     * Get the message content definition.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
