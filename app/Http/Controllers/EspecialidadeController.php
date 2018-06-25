<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Endereco;
use App\Atendimento;
use App\Cidade;

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
        $result = [];
        
        if ($tipo_atendimento == 'saude' | $tipo_atendimento == 'odonto') {
            
            $tipo_atendimento_id = $tipo_atendimento == 'saude' ? 1 : 2;
            
            //DB::enableQueryLog();
            $atendimentos = DB::table('atendimentos')
            	->join('consultas', 		function ($join1) use ($tipo_atendimento_id) {$join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
            	->join('clinicas', 			function ($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
            	->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
                ->orderBy('atendimentos.ds_preco', 'asc')
                ->select('atendimentos.*')
                ->distinct()
                ->get(['consultas.cd_consulta']);
            
            //$query = DB::getQueryLog();
            //dd($query);
            
            foreach ($atendimentos as $atend) {
                
                if (! EspecialidadeController::checkIfAtendimentoExists($result, $atend->consulta_id)) {
                    
                    $item = [
                        'id' => $atend->id,
                        'tipo' => 'consulta',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->consulta_id
                    ];
                    
                    array_push($result, $item);
                }
            }
            
        } elseif ($tipo_atendimento == 'exame') {
            
            $tipo_atendimento_id = 3;
            
            DB::enableQueryLog();
            $atendimentos = DB::table('atendimentos')
            	->join('procedimentos', 	function ($join1) use ($tipo_atendimento_id) {$join1->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->where('procedimentos.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
            	->join('clinicas', 			function ($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
            	->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
                ->orderBy('atendimentos.ds_preco', 'asc')
                ->select('atendimentos.*')
                ->distinct()
                ->get(['procedimentos.cd_procedimento']);
            
            foreach ($atendimentos as $atend) {
                
                if (! EspecialidadeController::checkIfAtendimentoExists($result, $atend->procedimento_id)) {
                    
                    $item = [
                        'id' => $atend->id,
                        'tipo' => 'exame',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->procedimento_id
                    ];
                    
                    array_push($result, $item);
                }
            }
        } elseif ($tipo_atendimento == 'checkup') {
            $tipo_atendimento_id = 4;
            
            $item = [
                'id' => $atend->id,
                'tipo' => 'exame',
                'descricao' => $atend->ds_preco,
                'codigo' => $atend->procedimento_id
            ];
            
            array_push($result, $item);
        }
        
        
        /*
           * elseif ($tipo_atendimento == 'procedimento') {
           *
           * $tp_atendimento = DB::table('procedimentos')
           * ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'procedimentos.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "400");})
           * ->select('procedimentos.*', 'procedimentos.id', 'procedimentos.cd_procedimento', 'procedimentos.ds_procedimento')
           * ->get();
           *
           * foreach ($tp_atendimento as $atend) {
           * $item = [
           * 'id' => $atend->id,
           * 'tipo' => 'procedimento',
           * 'descricao' => $atend->ds_procedimento
           * ];
           *
           * array_push($result, $item);
           * }
           *
           * }
           */
        
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
        
        if ($tipo_atendimento == 'saude' | $tipo_atendimento == 'odonto') {

        	
            //dd($tipo_especialidade);
            $consulta_id = $ct_atendimento->consulta_id;
//         	DB::enableQueryLog();
        	$enderecos = DB::table('enderecos')
        		->join('cidades', function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
        	    function($query) use ($search_term) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));});})
	        	->join('clinica_endereco', function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	        	->join('clinicas', function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	        	->join('profissionals', function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	        	->join('atendimentos', function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	        	//->join('consultas', function($join6) use ($atendimento_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('consultas.id', '=', DB::raw($procedimento_id));})
	        	->join('consultas', function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	        	->where('clinicas.cs_status', '=', 'A')
	        	->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	        	->distinct()
	        	->get();
	        
	        //$especialidades = Especialidade::orderBy('ds_especialidade', 'asc')->pluck('ds_especialidade', 'id');
//   	        $query = DB::getQueryLog();
//   	        dd($query);
	        
	        //dd($enderecos);
// 	        posts_data.append({ "value": post.title, "id" : post.id , "type": "post"})
// 	        response = {"query": "Unit", "suggestions": result}
	        	
	        foreach ($enderecos as $query)
	        {
	            $cidade = Cidade::findorfail($query->cidade_id);
	            $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => $query->te_bairro.': '.$cidade->nm_cidade ];
	        	array_push($result, $arResultado);
	       	}
	       	
        } elseif ($tipo_atendimento == 'exame') {
            
            $procedimento_id = $ct_atendimento->procedimento_id;
            
            $enderecos = Endereco::with('cidade')
            	//->join('cidades', function ($join1) use ($search_term) {$join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%" . $search_term . "%'"));})
	            ->join('cidades', function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
	            function($query) use ($search_term) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));});})
                ->join('clinica_endereco', function ($join2) {$join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
                ->join('clinicas', function ($join3) {$join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
                ->join('profissionals', function ($join4) {$join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
                ->join('atendimentos', function ($join5) {$join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
                ->join('procedimentos', function ($join6) use ($procedimento_id) { $join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
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
    	
    	$cidade_id = $ct_atendimento->clinica->enderecos->first()->cidade->id;
    	
    	$tipo_atendimento = CVXRequest::post('tipo_atendimento');
    	
    	$endereco = $ct_atendimento->clinica->enderecos->first();
    	$local_atendimento = UtilController::toStr($endereco->te_bairro);
    	
    	$list_endereco_ids = [];
    	$result = [];
    
    	if ($tipo_atendimento == 'saude' | $tipo_atendimento == 'odonto') {
    		
    		$ct_atendimento->load('consulta');
    		$consulta_id = $ct_atendimento->consulta->id;
    		
    		$enderecos = Endereco::with('cidade')
	    		->join('cidades', 			function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
	    		function($query) use ($local_atendimento) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));});})
	    		->join('clinica_endereco', 	function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	    		->join('clinicas', 			function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	    		->join('profissionals', 	function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	    		->join('atendimentos', 		function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	    		->join('consultas', 		function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	    		->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	    		->where('clinicas.cs_status', '=', 'A')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
    		
    		//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
	    	$arResultado = [ 'id' =>  $endereco->id, 'cidade_id' => $endereco->cidade_id, 'value' => ucwords(strtolower($endereco->te_bairro)).': '.$endereco->cidade->nm_cidade, 'te_bairro' =>  $endereco->te_bairro ];
	    	array_push($result, $arResultado);
	    		
    		foreach ($enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->te_bairro)).': '.$query->cidade->nm_cidade ];
    			if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $result)) {
    				array_push($result, $arResultado);
    			}
    			array_push($list_endereco_ids, $query->id);
    		}
    		
    		//-- busca os demais enderecos disponíveis de atendimento --------------------
    		$outros_enderecos = Endereco::with('cidade')
	    		->join('cidades', 			function($join1) use ($cidade_id) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.id', '=', DB::raw($cidade_id));})
	    		->join('clinica_endereco', 	function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	    		->join('clinicas', 			function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	    		->join('profissionals', 	function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	    		->join('atendimentos', 		function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	    		->join('consultas', 		function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	    		->whereNotIn('enderecos.id', $list_endereco_ids)->where('clinicas.cs_status', '=', 'A')
	    		->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
    		
    		//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
    		foreach ($outros_enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->te_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
    		
    			if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $result)) {
    				array_push($result, $arResultado);
    			}
    		}
    		
    	} elseif ($tipo_atendimento == 'exame') {
    
    		$procedimento_id = $ct_atendimento->procedimento_id;
    
    		$enderecos = Endereco::with('cidade')->with('cidade')
	    		->join('cidades', 			function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(
	    		function($query) use ($local_atendimento) { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));});})
	    		->join('clinica_endereco', 	function ($join2) {$join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	    		->join('clinicas', 			function ($join3) {$join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	    		->join('profissionals', 	function ($join4) {$join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	    		->join('atendimentos', 		function ($join5) {$join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	    		->join('procedimentos', 	function ($join6) use ($procedimento_id) {$join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
	    		->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	    		->where('clinicas.cs_status', '=', 'A')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
	    		
	    	//-- lista enderecos id usada para aplicar clausula NOI IN na lista dos demais enderecos ---
	    	$list_endereco_ids = [];
	    	
	    	//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
	    	$arResultado = [ 'id' =>  $endereco->id, 'cidade_id' => $endereco->cidade_id, 'value' => ucwords(strtolower($endereco->te_bairro)).': '.$endereco->cidade->nm_cidade, 'te_bairro' => $endereco->te_bairro ];
	    	array_push($result, $arResultado);
    
    		foreach ($enderecos as $query) {
    			
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->te_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
    			
    			if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $result)) {
    				array_push($result, $arResultado);
    			}
    			array_push($list_endereco_ids, $query->id);
    		}
    		
    		//-- busca os demais enderecos disponíveis de atendimento --------------------
    		$outros_enderecos = Endereco::with('cidade')
	    		->join('cidades', 			function($join1) use ($cidade_id) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.id', '=', DB::raw($cidade_id));})
	    		->join('clinica_endereco', 	function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	    		->join('clinicas', 			function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	    		->join('profissionals', 	function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	    		->join('atendimentos', 		function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	    		->join('procedimentos', 	function($join6) use ($procedimento_id) { $join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
	    		->whereNotIn('enderecos.id', $list_endereco_ids)->where('clinicas.cs_status', '=', 'A')
	    		->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	    		->distinct()
	    		->orderby('enderecos.te_bairro', 'asc')
	    		->get();
    		
    		//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
    		foreach ($outros_enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->te_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
    			 
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
            	->join('cidades',               function ($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%" . $search_term . "%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%" . $search_term . "%'"));})
                ->join('clinica_endereco',      function ($join2) {$join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
                ->join('clinicas',              function ($join3) {$join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
                ->join('profissionals',         function ($join4) {$join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
                ->join('atendimentos',          function ($join5) {$join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
                ->join('consultas',             function ($join6) use ($consulta_id) {$join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
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
