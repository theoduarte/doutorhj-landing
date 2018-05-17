<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Agendamento;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    /**
     * Consulta Cep através de sistema externo
     *
     * @param string $nrCep
     */
    public function consultaCep($nrCep){
        $output = null;
        
        if ( !empty($nrCep) ) {
            $nrCep = UtilController::retiraMascara($nrCep);
            $nrCep = ltrim($nrCep, '0');
            $nrCep = sprintf("%08d", $nrCep);
            
            $token = 'fa31850c7f0a4f2541c14a050d1255c9';
            $url = 'http://www.cepaberto.com/api/v2/ceps.json?cep='.$nrCep;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . $token . '"'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            
            return response()->json(['status' => true, 'mensagem' => '', 'endereco' => $output]);
        }
        
        return response()->json(['status' => false, 'mensagem' => 'A busca falhou. Por favor, tente novamente.']);
    }
    
    /**
     * carrega dados na landing page
     *
     */
    public function home()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $agendamentos_home = [];
        
        if (Auth::check()) {
            
            $paciente = Auth::user()->paciente->id;
            
            $agendamentos_home = Agendamento::with('paciente')->with('clinica')->with('atendimento')->with('profissional')
            		->join('pacientes', function($join1) use ($paciente) { $join1->on('pacientes.responsavel_id', '=', DB::raw($paciente))->on('pacientes.id', '=', 'agendamentos.paciente_id')->orOn('pacientes.id', '=', DB::raw($paciente));})
            		->select('agendamentos.*')
            		->distinct()
            		->orderBy('dt_atendimento', 'desc')->get();
            
            for ($i = 0; $i < sizeof($agendamentos_home); $i++) {
                $agendamentos_home[$i]->clinica->load('enderecos');
                $agendamentos_home[$i]->clinica->enderecos->first()->load('cidade');
                $agendamentos_home[$i]->endereco_completo = $agendamentos_home[$i]->clinica->enderecos->first()->te_endereco.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->te_bairro.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->nm_cidade.'/'.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->estado->sg_estado;
            }
            
        }
        
        return view('welcome', compact('agendamentos_home', 'cvx_num_itens_carrinho'));
    }
}
