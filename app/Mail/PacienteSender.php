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
    public $verify_hash;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Paciente $paciente)
    {
        $this->user = $paciente->user;
        $this->verify_hash = Crypt::encryptString($paciente->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('administrador@comvex.com.br')->view('view.emails.paciente_verificacao_conta');
    }
}
