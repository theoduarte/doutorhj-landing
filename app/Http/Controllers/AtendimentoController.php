<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\Plano;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Procedimento;
use App\Consulta;
use App\Endereco;
use App\Cidade;
use App\Agendamento;
use App\Filial;
use App\VigenciaPaciente;
use Illuminate\Support\Facades\Session;

class AtendimentoController extends Controller
{
    
    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaAtendimentos(Request $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$tipo_atendimento = $request->get('tipo_atendimento');
        $enderecoIds = $request->get('local_atendimento');
        $especialidade = $request->get('tipo_especialidade');
        $sg_estado_localizacao = $request->get('sg_estado_localizacao');
        $sortItem = !empty($request->get('sort')) ? $request->get('sort') : 'asc';

		if(is_null($sg_estado_localizacao) || is_null($especialidade)) {
			Log::error('Erro no resultado dos atenidmento. '. json_encode($request->all()));
			return redirect('/')->with('erro-clear-storage', 'Ocorreu um erro inesperado, tente novamente.');
		}

		$paciente_id = null;

		if (Auth::check()) {
			$paciente = Auth::user()->paciente;
			$paciente_id = $paciente->id;
		}

		$plano_id = Paciente::getPlanoAtivo($paciente_id);
		
        if ($tipo_atendimento == 'saude') {
            $consulta = new Consulta();
            $atendimentos = $consulta->getActiveAtendimentos( $especialidade, $enderecoIds, $sortItem, $plano_id, $sg_estado_localizacao );
            $list_enderecos = $consulta->getActiveAddress( $especialidade, $sg_estado_localizacao );
            $list_atendimentos = $consulta->getActive($plano_id, $sg_estado_localizacao);
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') {
            $procedimento = new Procedimento();
            $atendimentos = $procedimento->getActiveAtendimentos( $especialidade, $enderecoIds, $sortItem, $plano_id, $sg_estado_localizacao );
            $list_enderecos = $procedimento->getActiveAddress( $especialidade, $sg_estado_localizacao );
            $list_atendimentos = ( $tipo_atendimento == 'exame' ) ? $procedimento->getActiveExameProcedimento($plano_id, $sg_estado_localizacao) : $procedimento->getActiveOdonto($plano_id, $sg_estado_localizacao);
        }

        return view('resultado', compact('atendimentos', 'paciente', 'list_atendimentos', 'list_enderecos', 'tipo_atendimento', 'locais_google_maps', 'sg_estado_localizacao'));
    }
}