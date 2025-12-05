<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use Carbon\Carbon;
use App\Mail\RecordatorioReservaMail;
use Illuminate\Support\Facades\Mail;

class RecordatorioReservasPendientes extends Command
{
    /**
     * Nombre del comando (para usar en terminal)
     */
    protected $signature = 'reservas:recordatorio {minutos=1}';

    /**
     * Descripción del comando
     */
    protected $description = 'Envía recordatorios a choferes sobre reservas pendientes sin responder.';

    /**
     * Lógica del comando
     */
    public function handle()
    {
        $minutos = (int) $this->argument('minutos');

        $this->info("Buscando reservas con más de $minutos minutos sin respuesta...");

        // Buscar reservas Pendientes con más de X minutos sin responder
        $reservas = Reserva::where('estado', 'Pendiente')
            ->where('created_at', '<=', Carbon::now()->subMinutes($minutos))
            ->with(['ride', 'ride.user'])   // el chofer es el user del ride
            ->get();

        if ($reservas->isEmpty()) {
            $this->info("No hay reservas pendientes antiguas.");
            return;
        }

        foreach ($reservas as $reserva) {
            $chofer = $reserva->ride->user;  // aquí obtenemos al chofer

            if ($chofer && $chofer->email) {
                Mail::to($chofer->email)
                    ->send(new RecordatorioReservaMail($reserva));

                $this->info("Correo enviado al chofer: {$chofer->email} (Reserva ID: {$reserva->id})");
            } else {
                $this->warn("La reserva {$reserva->id} no tiene chofer asociado con email.");
            }
        }

        $this->info("Proceso de recordatorios finalizado.");
    }
}


