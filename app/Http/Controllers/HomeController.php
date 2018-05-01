<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Agendamento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function home()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $agendamentos_home = [];
        
        if (Auth::check()) {
            
            $paciente = Auth::user()->paciente->id;
            
            $agendamentos_home = Agendamento::with('paciente')->with('clinica')->with('atendimento')->with('profissional')->where('paciente_id', '=', $paciente)->get();
            
            for ($i = 0; $i < sizeof($agendamentos_home); $i++) {
                $agendamentos_home[$i]->clinica->load('enderecos');
                $agendamentos_home[$i]->clinica->enderecos->first()->load('cidade');
                $agendamentos_home[$i]->endereco_completo = $agendamentos_home[$i]->clinica->enderecos->first()->te_endereco.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->te_bairro.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->nm_cidade.'/'.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->estado->sg_estado;   
            }
            
        }
        
        return view('welcome', compact('agendamentos_home'));
    }
}
