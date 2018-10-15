<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Agendamento;
use App\Paciente;
use App\VigenciaPaciente;
use App\Plano;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // public function __construct() {

    //     $termosCondicoes = new TermosCondicoes();
    //     View::share( 'termosCondicoesAtual', $termosCondicoes->getActual() );
    // }

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
        $plano = Plano::OPEN;

        if (Auth::check()) {
			$paciente = Auth::user()->paciente;
			$paciente_id = $paciente->id;

			//dd($paciente->vl_consumido, $paciente->vl_max_consumo);

			//DB::enableQueryLog();
			$agendamentos_home = Agendamento::with([
				'paciente', 'clinica.enderecos.cidade', 'atendimento', 'profissional', 'itempedidos.pedido.pagamentos',
				'datahoracheckups.itemcheckup.atendimento.profissional', 'checkup'
			])
				->join('pacientes', function($join1) use ($paciente_id) {
					$join1->on('pacientes.id', '=', 'agendamentos.paciente_id')->where(function($query) use ($paciente_id) {
						$query->on('pacientes.responsavel_id', '=', DB::raw($paciente_id))->orOn('pacientes.id', '=', DB::raw($paciente_id));
					});
				})
				->select('agendamentos.*')
				->distinct()
				->orderBy('dt_atendimento', 'asc')->get();

			//$query_temp = DB::getQueryLog();

			$plano = Paciente::getPlanoAtivo($paciente_id);
            
            if($plano != Plano::OPEN) {
                $vigencia_valor = Paciente::getValorLimite($paciente_id) ;
                                
            }
                                
			foreach($agendamentos_home as $agendamento) {
				if(!empty($agendamento->clinica)) {
					$agendamento->endereco_completo = $agendamento->clinica->enderecos->first()->te_endereco . ' - ' . $agendamento->clinica->enderecos->first()->te_bairro . ' - ' . $agendamento->clinica->enderecos->first()->cidade->nm_cidade . '/' . $agendamento->clinica->enderecos->first()->cidade->estado->sg_estado;
				}

                if ( !empty($agendamento->itempedidos->first()) ) {
                    $agendamento->valor_total = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? number_format( ($agendamento->itempedidos->first()->pedido->pagamentos->first()->amount)/100,  2, ',', '.') : number_format( 0,  2, ',', '.');
                    $agendamento->data_pagamento = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? date('d/m/Y', strtotime($agendamento->itempedidos->first()->pedido->pagamentos->first()->created_at)) : '----------';
                }
			}
        }
        
        return view('welcome', compact('plano','vigencia_valor','agendamentos_home', 'cvx_num_itens_carrinho'));
    }
    
    /**
     * carrega dados na landing page provisoria
     *
     */
    public function provisorio()
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    
    	$agendamentos_home = [];
    
    	return view('provisorio', compact('agendamentos_home'));
    }
}
