<?php

namespace App\Http\Controllers;

use App\Cidade;
use App\Endereco;
use App\Atendimento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;

class EspecialidadeController extends Controller
{
    public function __construct(CheckupController $checkup){
        $this->checkupController = $checkup;
    }
    
    // ############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaEspecialidades()
    {
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $result = [];
        
        if ($tipo_atendimento == 'saude') { //--realiza a busca pelos itens do tipo CONSULTA-------- 
            
            $tipo_atendimento_id = 1;

            $atendimentos = DB::table('atendimentos')
            	->join('consultas', 		     function($join1) use ($tipo_atendimento_id) {$join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
            	->join('clinicas', 			     function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
            	->join('filials',                function($join3) { $join3->on('clinicas.id', '=', 'filials.clinica_id');})
            	->join('profissionals', 		 function($join4) { $join4->on('profissionals.id', '=', 'atendimentos.profissional_id')->on('profissionals.clinica_id', '=', 'clinicas.id');})
            	->join('filial_profissional',    function($join5) { $join5->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
            	->join('enderecos',              function($join6) { $join6->on('filials.endereco_id', '=', 'enderecos.id');})
            	->join('tag_populars', 		     function($join7) { $join7->on('tag_populars.consulta_id', '=', 'consultas.id');})
            	->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
            	->orderBy('tag_populars.id', 'asc')
            	->select(DB::raw('on (tag_populars.id) tag_populars.id'), 'atendimentos.id as idatendimento', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'tag_populars.cs_tag as ds_preco', 'atendimentos.cs_status', 'atendimentos.created_at', 'atendimentos.updated_at', 'atendimentos.clinica_id', 'atendimentos.consulta_id', 'atendimentos.procedimento_id', 'atendimentos.profissional_id')
                ->distinct()
                ->get(['consultas.cd_consulta']);
            
            foreach ($atendimentos as $atend) {
                
                if (! EspecialidadeController::checkIfAtendimentoExists($result, $atend->consulta_id)) {
                    
                    $item = [
                        'id' => $atend->idatendimento,
                        'tipo' => 'consulta',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->consulta_id
                    ];
                    
                    array_push($result, $item);
                }
            }
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') { //--realiza a busca pelos itens do tipo CONSULTA--------
            $tipo_atendimento_id = $tipo_atendimento == 'exame' ? 3 : 2;

            $atendimentos = DB::table('atendimentos')
            	->join('procedimentos',        function($join1) use ($tipo_atendimento_id) {$join1->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->where('procedimentos.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
            	->join('clinicas',             function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
            	->join('filials',              function($join4) { $join4->on('clinicas.id', '=', 'filials.clinica_id');})
            	->join('tag_populars',         function($join3) { $join3->on('tag_populars.procedimento_id', '=', 'procedimentos.id');})
            	->join('atendimento_filial',   function($join5) { $join5->on('atendimento_filial.filial_id', '=', 'filials.id')->on('atendimento_filial.atendimento_id', '=', 'atendimentos.id');})
            	->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
                ->orderBy('tag_populars.id', 'asc')
                ->select(DB::raw('on (tag_populars.id) tag_populars.id'), 'atendimentos.id as idatendimento', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'tag_populars.cs_tag as ds_preco', 'atendimentos.cs_status', 'atendimentos.created_at', 'atendimentos.updated_at', 'atendimentos.clinica_id', 'atendimentos.consulta_id', 'atendimentos.procedimento_id', 'atendimentos.profissional_id')
                ->distinct()
                ->get(['procedimentos.cd_procedimento']);
 
            foreach ($atendimentos as $atend) {
                if (! EspecialidadeController::checkIfAtendimentoExists($result, $atend->procedimento_id)) {
                    $item = [
                        'id' => $atend->idatendimento,
                        'tipo' => 'exame',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->procedimento_id
                    ];
                    
                    array_push($result, $item);
                }
            }
        } elseif ($tipo_atendimento == 'checkup') {
            foreach($this->checkupController->getTituloCheckupAtivo() as $dado){
                $item = [
                    'tipo'      => 'checkup',
                    'descricao' => strtoupper($dado->titulo)
                ];         
                array_push($result, $item);
            }
        }

        return response()->json(['status' => true, 'atendimento' => json_encode($result)]);
    }

    public function consultaLocalAtendimento()
    {
        $search_term = UtilController::toStr(CVXRequest::post('search_term'));
        $tipo_atendimento = CVXRequest::post('tipo_atendimento');
        $atendimento_id = CVXRequest::post('atendimento_id');
        $tipo_especialidade = CVXRequest::post('tipo_especialidade');
        $ct_atendimento = Atendimento::findorfail($atendimento_id);
        
        $result = [];
        
        if ($tipo_atendimento == 'saude') {
            $consulta_id = $ct_atendimento->consulta_id;
        	$enderecos = DB::table('enderecos')
        		->join('cidades', 				function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
        	    function($query) use ($search_term) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));});})
        		->join('filials',             	function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
	        	->join('clinicas', 				function($join3) { $join3->on('filials.clinica_id', '=', 'clinicas.id');})
	        	->join('profissionals', 		function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	        	->join('filial_profissional',   function($join7) { $join7->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
	        	->join('atendimentos', 			function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	        	->join('consultas', 			function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	        	->where('clinicas.cs_status', '=', 'A')
	        	->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	        	->distinct()
	        	->get();
	        
	        foreach ($enderecos as $query)
	        {
	            $cidade = Cidade::findorfail($query->cidade_id);
	            $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => $query->te_bairro.': '.$cidade->nm_cidade ];
	        	array_push($result, $arResultado);
	       	}
	       	
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') {
            
            $procedimento_id = $ct_atendimento->procedimento_id;
            
            $enderecos = Endereco::with('cidade')
	            ->join('cidades', 				function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
	            function($query) use ($search_term) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));});})
	            ->join('filials',        		function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
                ->join('clinicas', 				function ($join3) {$join3->on('filials.clinica_id', '=', 'clinicas.id');})
                ->leftJoin('atendimentos', 		function($join5) { $join5->on('atendimentos.clinica_id', '=', 'clinicas.id');})
                ->join('procedimentos', 		function ($join6) use ($procedimento_id) { $join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
                ->where('clinicas.cs_status', '=', 'A')
                ->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
                ->distinct()
                ->get();
            
            foreach ($enderecos as $query) {
                $arResultado = [
                    'id' => $query->id,
                    'cidade_id' => $query->cidade_id,
                    'value' => $query->te_bairro . ': ' . $query->cidade->nm_cidade
                ];
                array_push($result, $arResultado);
            }
        }
        
        $response = [
            "suggestions" => $result
        ];
        
        return Response()->json($response);
    }
    
    public function consultaTodosLocaisAtendimento()
    {
    	$atendimento_id = CVXRequest::post('atendimento_id');
    	$ct_atendimento = Atendimento::findorfail($atendimento_id);
    	$ct_atendimento->load('clinica');
    	$ct_atendimento->clinica->load('enderecos');
    	$ct_atendimento->clinica->enderecos->first()->load('cidade');
    	$ct_atendimento->clinica->load('filials');
    	$filials = $ct_atendimento->clinica->filials;
    	
    	$cidade_id = $filials->first()->endereco->cidade->id;
    	
    	$tipo_atendimento = CVXRequest::post('tipo_atendimento');
    	
    	$endereco = $filials->first()->endereco;
    	$local_atendimento = UtilController::toStr($endereco->te_bairro);
    	
    	$list_endereco_ids = [];
    	$result = [];
    
    	if ($tipo_atendimento == 'saude') {
    		
    		$ct_atendimento->load('consulta');
    		$consulta_id = $ct_atendimento->consulta->id;
    		
    		//DB::enableQueryLog();
    		$outros_enderecos = Endereco::with('cidade')
	    		->join('cidades', 				function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id');})
	    		->join('filials',           	function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
	    		->join('clinicas', 				function($join3) { $join3->on('filials.clinica_id', '=', 'clinicas.id');})
	    		->join('profissionals', 		function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	    		->join('filial_profissional',   function($join7) { $join7->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
	    		->join('atendimentos', 			function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	    		->join('consultas', 			function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	    		->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'filials.nm_nome_fantasia as ds_bairro', 'enderecos.cidade_id')
	    		->where('clinicas.cs_status', '=', 'A')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
	    	
    		//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
    		foreach ($outros_enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->ds_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
    		
    			if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $result)) {
    				array_push($result, $arResultado);
    			}
    		}
    		
    	} elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') {
    
    		$procedimento_id = $ct_atendimento->procedimento_id;
    		$outros_enderecos = Endereco::with('cidade')->with('cidade')
	    		->join('cidades', 				function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id');})
	    		->join('filials',             	function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
	    		->join('clinicas', 				function($join3) {$join3->on('filials.clinica_id', '=', 'clinicas.id');})
	    		->join('atendimentos', 			function($join5) {$join5->on('atendimentos.clinica_id', '=', 'clinicas.id');})
	    		->join('procedimentos', 		function($join6) use ($procedimento_id) {$join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
	    		->join('atendimento_filial',    function($join8) { $join8->on('atendimento_filial.filial_id', '=', 'filials.id')->on('atendimento_filial.atendimento_id', '=', 'atendimentos.id');})
	    		->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'filials.nm_nome_fantasia as ds_bairro', 'enderecos.cidade_id')
	    		->where('clinicas.cs_status', '=', 'A')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
	    	
    		//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
    		foreach ($outros_enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->ds_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
    			 
    			if (!$this->checkIfExistsInArray($query->te_bairro, $result)) {
    				array_push($result, $arResultado);
    			}
    		}
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
            // ->join('consultas', function($join6) use ($atendimento_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('consultas.id', '=', DB::raw($procedimento_id));})
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

    public static function checkIfAtendimentoExists($list_atendimentos, $item)
    {
        foreach ($list_atendimentos as $atendimento) {
            
            if ($atendimento['codigo'] == $item) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    public static function checkIfExistsInArray($entry, $list_enderecos) {
    	 
    	 
    	foreach ($list_enderecos as $endereco) {
    	    if (trim(strtolower($endereco['te_bairro'])) == trim(strtolower($entry))) {
    			return true;
    		}
    	}
    	 
    	return false;
    }
}
