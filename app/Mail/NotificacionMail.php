<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $comentario;

    public function __construct($mensaje, $comentario = null)
    {
        $this->mensaje = $mensaje;
        $this->comentario = $comentario;
    }

    public function build()
    {
        return $this->subject('Nueva notificación - Intranet Garden')
                    ->view('emails.notificacion');
    }
}
