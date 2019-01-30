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
use Illuminate\Support\Facades\Session;

class AtendimentoController extends Controller
{
	public function consultaAtendimentosCaixa(Request $request, $tipoAtendimento, $tipoEspecialidade, $sgEstado, $localAtendimento = null)
	{
		$_GET['tipo_atendimento'] 		= $tipoAtendimento;
		$_GET['tipo_especialidade'] 	= $tipoEspecialidade;
		$_GET['sg_estado_localizacao'] = $sgEstado;
		$_GET['local_atendimento'] 		= $localAtendimento;
		$_GET['sort'] 					= $request->sort;

		$dados = $this->getConsultaAtendimentos($tipoAtendimento, $tipoEspecialidade, $sgEstado, $localAtendimento, $request->sort);

		return view('resultado', $dados);
	}

    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaAtendimentos(Request $request)
    {
		$tipoAtendimento = $request->get('tipo_atendimento');
		$tipoEspecialidade = $request->get('tipo_especialidade');
		$localAtendimento = $request->get('local_atendimento');
		$sgEstado = $request->get('sg_estado_localizacao');
		$sort = $request->get('sort');

		$atendimentos = $this->getConsultaAtendimentos($tipoAtendimento, $tipoEspecialidade, $sgEstado, $localAtendimento, $sort);

    	return view('resultado', $atendimentos);
    }

	public function getConsultaAtendimentos($tipoAtendimento, $tipoEspecialidade, $sgEstado, $localAtendimento = null, $sort = null)
	{
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');

		if(is_null($sgEstado) || is_null($tipoEspecialidade)) {
			return redirect('/')->with('erro-clear-storage', 'Ocorreu um erro inesperado, tente novamente.');
		}

		$paciente_id = null;

		if (Auth::check()) {
			$paciente = Auth::user()->paciente;
			$paciente_id = $paciente->id;
		}

		$plano_id = Paciente::getPlanoAtivo($paciente_id);

		if ($tipoAtendimento == 'saude') {
			$consulta = new Consulta();
			$atendimentos = $consulta->getActiveAtendimentos( $tipoEspecialidade, $localAtendimento, $sort, $plano_id, $sgEstado );
			$list_enderecos = $consulta->getActiveAddress( $tipoEspecialidade, $sgEstado );
			$list_atendimentos = $consulta->getActive($plano_id, $sgEstado);
		} elseif ($tipoAtendimento == 'exame' | $tipoAtendimento == 'odonto') {
			$procedimento = new Procedimento();
			$atendimentos = $procedimento->getActiveAtendimentos( $tipoEspecialidade, $localAtendimento, $sort, $plano_id, $sgEstado );
			$list_enderecos = $procedimento->getActiveAddress( $tipoEspecialidade, $sgEstado );
			$list_atendimentos = ( $tipoAtendimento == 'exame' ) ? $procedimento->getActiveExameProcedimento($plano_id, $sgEstado) : $procedimento->getActiveOdonto($plano_id, $sgEstado);
		}

		return compact('atendimentos', 'paciente', 'list_atendimentos', 'list_enderecos', 'tipo_atendimento', 'locais_google_maps', 'sg_estado_localizacao');
	}
}