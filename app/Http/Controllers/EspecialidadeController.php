<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\Cidade;
use App\Endereco;
use App\Atendimento;
use App\Paciente;
use App\Procedimento;
use App\Consulta;
use App\Checkup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;

class EspecialidadeController extends Controller
{
    // ############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaEspecialidades()
    {
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $uf_localizacao = CVXRequest::get('uf_localizacao');
        $result = [];

		$paciente_id = null;

		if (Auth::check()) {
			$paciente = Auth::user()->paciente;
			$paciente_id = $paciente->id;
		}

		$plano_id = Paciente::getPlanoAtivo($paciente_id);

        if ($tipo_atendimento == 'saude') { //--realiza a busca pelos itens do tipo CONSULTA-------- 
            $consulta = new Consulta();
            $result = $consulta->getActive($plano_id, $uf_localizacao);
            $result = $result->toArray();
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') { //--realiza a busca pelos itens do tipo CONSULTA--------
            $procedimento = new Procedimento();
            $result = ( $tipo_atendimento == 'exame' ) ? $procedimento->getActiveExameProcedimento($plano_id, $uf_localizacao) : $procedimento->getActiveOdonto($plano_id);
            $result = $result->toArray();
        } elseif ($tipo_atendimento == 'checkup') {
            $checkup = new Checkup;
            $checkups = $checkup->getActive($plano_id);
            foreach($checkups as $checkup){
                $item = [
                    'id'        => $checkup->id,
                    'tipo'      => 'checkup',
                    'descricao' => strtoupper($checkup->titulo)
                ];         
                array_push($result, $item);
            }
        }
        
        return response()->json(['status' => true, 'atendimento' => json_encode($result)]);
    }
    
    public function consultaTodosLocaisAtendimento()
    {
    	$especialidade = CVXRequest::post('especialidade');
        $tipo_atendimento = CVXRequest::post('tipo_atendimento');
        $uf_localizacao = CVXRequest::get('uf_localizacao');

        if ($tipo_atendimento == 'saude') {
            $consulta = new Consulta();
            $result = $consulta->getActiveAddress( $especialidade, $uf_localizacao );
        } elseif ($tipo_atendimento == 'exame' || $tipo_atendimento == 'odonto') {
            $procedimento = new Procedimento();
            $result = $procedimento->getActiveAddress( $especialidade, $uf_localizacao );
        }
    
    	return response()->json(['status' => true, 'endereco' => $result ]);
    }

    public function consultaEnderecoLocalAtendimento()
    {
        $search_term = UtilController::toStr(CVXRequest::post('search_term'));
        $tipo_atendimento = CVXRequest::post('tipo_atendimento');
        $atendimento_id = CVXRequest::post('atendimento_id');
        $ct_atendimento = Atendimento::findorfail($atendimento_id);
        
        $result = [];
        
        if ($tipo_atendimento == 'saude') {
            
            // DB::enableQueryLog();
            $consulta_id = $ct_atendimento->consulta_id;
            $enderecos = Endereco::with('cidade')
            	->join('cidades',               function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%" . $search_term . "%'"));})
                //->join('clinica_endereco',      function ($join2) {$join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
                ->join('filials',             	function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
                ->join('clinicas',              function($join3) {$join3->on('filials.clinica_id', '=', 'clinicas.id');})
                ->join('profissionals',         function($join4) {$join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
                ->join('filial_profissional',   function($join7) { $join7->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
                ->join('atendimentos',          function($join5) {$join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
                ->join('consultas',             function($join6) use ($consulta_id) {$join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
                ->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
                ->where('clinicas.cs_status', '=', 'A')
                ->distinct()
                ->get();
            
            $result = $enderecos->first();
            
            if (isset($result)) {
                $result->nm_cidade = $result->te_bairro . ': ' . $result->cidade->nm_cidade;
            }
            
            return response()->json(['status' => true, 'endereco' => $result]);
        }
        
        return response()->json(['status' => false]);
    }
}
