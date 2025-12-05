<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;

class RecordatorioReservaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $chofer;
    public $ride;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
        $this->chofer  = $reserva->ride->user;
        $this->ride    = $reserva->ride;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio de Reserva Pendiente',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recordatorio_reserva',
            with: [
                'reserva' => $this->reserva,
                'chofer'  => $this->chofer,
                'ride'    => $this->ride,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

