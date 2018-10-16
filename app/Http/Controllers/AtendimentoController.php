<?php

namespace App\Http\Controllers;
use App\Paciente;
use App\Plano;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $sortItem = !empty($request->get('sort')) ? $request->get('sort') : 'asc';

		$paciente_id = null;

		if (Auth::check()) {
			$paciente = Auth::user()->paciente;
			$paciente_id = $paciente->id;
		}

		$plano_id = Paciente::getPlanoAtivo($paciente_id);

        if ($tipo_atendimento == 'saude') {
            $consulta = new Consulta();
            $atendimentos = $consulta->getActiveAtendimentos( $especialidade, $enderecoIds, $sortItem, $plano_id );
            $list_enderecos = $consulta->getActiveAddress( $especialidade );
            $list_atendimentos = $consulta->getActive($plano_id);
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') {
            $procedimento = new Procedimento();
            $atendimentos = $procedimento->getActiveAtendimentos( $especialidade, $enderecoIds, $sortItem, $plano_id );
            $list_enderecos = $procedimento->getActiveAddress( $especialidade );
            $list_atendimentos = ( $tipo_atendimento == 'exame' ) ? $procedimento->getActiveExameProcedimento($plano_id) : $procedimento->getActiveOdonto($plano_id);
        }

        return view('resultado', compact('atendimentos', 'paciente', 'list_atendimentos', 'list_enderecos', 'tipo_atendimento', 'locais_google_maps'));
    }
}