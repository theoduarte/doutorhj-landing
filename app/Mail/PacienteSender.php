<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Paciente;
use Illuminate\Support\Facades\Crypt;

class PacienteSender extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $paciente;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Paciente $paciente)
    {
        $this->user = $paciente->user;
        $this->paciente = $paciente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administrador@comvex.com.br', 'DoctorHoje')->view('emails.paciente_verificacao_conta')->with(['verify_hash' => Crypt::encryptString($this->paciente->id)]);
    }
}
