<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Endereco;
use App\Cidade;
use App\Agendamento;
use App\Filial;

class AtendimentoController extends Controller
{
    
    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaAtendimentos()
    {   
        //$url = 'http://192.168.145.136';
        
        
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	/* $user_id = 17;
    	//$cartCollection = \Cart::session($user_id)->getContent();
    	$cartCollection = \Cart::getContent();
    	dd($cartCollection); */
    	
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $atendimento_id = CVXRequest::get('tipo_especialidade');
        $local_atendimento = UtilController::toStr(CVXRequest::get('local_atendimento'));
        $endereco_id = CVXRequest::get('endereco_id');
        $sort_item = CVXRequest::get('sort') != '' ? CVXRequest::get('sort') : 'asc';
        
        $atendimentos = [];
        $list_atendimentos = [];
        $list_enderecos = [];
        $locais_google_maps = [];
        
        $endereco = '';
        $cidade_id = '';
        
        if($endereco_id != 'TODOS') {
            $endereco = Endereco::findorfail($endereco_id);
            $endereco->load('cidade');
            $cidade_id = $endereco->cidade->id;
            
            //-- seleciona o bairro e converte para o formato de search_term -------
            $local_atendimento = UtilController::toStr($endereco->te_bairro);
        }
        $ct_atendimento = Atendimento::findorfail($atendimento_id);
        
        
        if ($tipo_atendimento == 'saude') {
            
            $tipo_atendimento_id = 1;
            //$tipo_atendimento_id = $tipo_atendimento == 'saude' ? 1 : 2;
        	 
            //-- realiza a lista dos atendimentos do tipo CONSULTA MEDICA OU ODONTOLOGICA---------------
            $consulta_id = $ct_atendimento->consulta_id;
            
        	//DB::enableQueryLog();
        	$atendimentos = Atendimento::with('clinica')
        	   ->join('consultas',             function($join1) use ($tipo_atendimento_id) { $join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
        	   ->join('clinicas',              function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
        	   ->join('filials',               function($join3) { $join3->on('clinicas.id', '=', 'filials.clinica_id');})
        	   ->join('profissionals',         function($join5) { $join5->on('profissionals.id', '=', 'atendimentos.profissional_id')->on('profissionals.clinica_id', '=', 'clinicas.id');})
        	   ->join('filial_profissional',   function($join6) { $join6->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
        	   ->join('enderecos',             function($join4) use ($local_atendimento) { $join4->on('filials.endereco_id', '=', 'enderecos.id')->where(function($query) use ($local_atendimento) { if ($local_atendimento == 'todos') { $query->where(DB::raw("1"), '=', DB::raw("1")); } else { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));}});})
        	   ->join('tag_populars', 		   function($join7) { $join7->on('tag_populars.consulta_id', '=', 'consultas.id');})
        	   ->where('atendimentos.consulta_id', '=', $consulta_id)->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
        	   ->orderBy('atendimentos.vl_com_atendimento', $sort_item)
        	   ->select('atendimentos.*', 'atendimentos.id', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'atendimentos.ds_preco', 'atendimentos.procedimento_id', 'filials.id as filial_id')
        	   ->distinct()
        	   ->get();
        	
//         	$query = DB::getQueryLog();
//         	print_r($query);
        	
        	//-- seleciona os itens de atendimento removendo as repeticoes-----------
        	$atendimentos_temp = DB::table('atendimentos')
        	   ->join('consultas', 		      function($join1) use ($tipo_atendimento_id) { $join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
        	   ->join('clinicas',    	      function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
        	   ->join('filials',              function($join3) { $join3->on('clinicas.id', '=', 'filials.clinica_id');})
        	   ->join('profissionals', 		  function($join4) { $join4->on('profissionals.id', '=', 'atendimentos.profissional_id')->on('profissionals.clinica_id', '=', 'clinicas.id');})
        	   ->join('filial_profissional',  function($join5) { $join5->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
        	   ->join('enderecos',            function($join6) { $join6->on('filials.endereco_id', '=', 'enderecos.id');})
        	   ->join('tag_populars', 	      function($join7) { $join7->on('tag_populars.consulta_id', '=', 'consultas.id');})
        	   ->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
        	   ->orderBy('tag_populars.id', 'asc')
        	   ->select(DB::raw('on (tag_populars.id) tag_populars.id'), 'atendimentos.id as idatendimento', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'tag_populars.cs_tag as ds_preco', 'atendimentos.cs_status', 'atendimentos.created_at', 'atendimentos.updated_at', 'atendimentos.clinica_id', 'atendimentos.consulta_id', 'atendimentos.procedimento_id', 'atendimentos.profissional_id')
        	   ->distinct()
        	   ->get(['consultas.cd_consulta']);
            
            foreach ($atendimentos_temp as $atend) {
        		    
                if (!EspecialidadeController::checkIfAtendimentoExists($list_atendimentos, $atend->consulta_id)) {
        		        
    		        $item = [
    		            'id' => $atend->idatendimento,
    		            'tipo' => 'consulta',
    		            'descricao' => $atend->ds_preco,
    		            'codigo' => $atend->consulta_id
    		        ];
    		        
    		        array_push($list_atendimentos, $item);
    		    }
    		}
    		    		
    		//-- busca dos enderecos disponíveis de atendimento --------------------
    		//DB::enableQueryLog();
    		$enderecos = Endereco::with('cidade')
	    		->join('cidades',             function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->where(function($query) use ($local_atendimento) { if ($local_atendimento == 'todos') { $query->where(DB::raw("1"), '=', DB::raw("1")); } else { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));}});})
        		->join('filials',             function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
        		->join('clinicas',            function($join3) { $join3->on('filials.clinica_id', '=', 'clinicas.id');})
        		->join('profissionals',       function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
        		->join('filial_profissional', function($join5) { $join5->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
        		->join('atendimentos',        function($join6) { $join6->on('atendimentos.profissional_id', '=', 'profissionals.id');})
        		->join('consultas',           function($join7) use ($consulta_id) { $join7->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
        		->where('clinicas.cs_status', '=', 'A')
        		->select('enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'filials.nm_nome_fantasia as ds_bairro', 'enderecos.cidade_id')
        		->distinct()
        		->orderby('enderecos.te_bairro', 'asc')
        		->get();
        	//$query = DB::getQueryLog();
        	//print_r($query);
            
        	//-- lista enderecos id usada para aplicar clausula NOI IN na lista dos demais enderecos ---
        	$list_endereco_ids = [];
        	
        	/* if($endereco_id != 'TODOS') {
            	//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
        	    $arResultado = [ 'id' =>  $endereco->id, 'cidade_id' => $endereco->cidade_id, 'value' => ucwords(strtolower($endereco->ds_bairro)).': '.$endereco->cidade->nm_cidade, 'te_bairro' =>  $endereco->te_bairro ];
            	array_push($list_enderecos, $arResultado);
        	} */
        	
        	foreach ($enderecos as $query)
        	{
        		$cidade = Cidade::findorfail($query->cidade_id);
        	    
        		$arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->ds_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
        	    if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $list_enderecos)) {
        	        array_push($list_enderecos, $arResultado);
        	    }
        	    
        	    array_push($list_endereco_ids, $query->id);
            }
        	
            if($endereco_id != 'TODOS') {
                //-- busca os demais enderecos disponíveis de atendimento --------------------
        		$outros_enderecos = Endereco::with('cidade')
        		    ->join('cidades',             function($join1) use ($cidade_id) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.id', '=', DB::raw($cidade_id));})
        		    ->join('filials',             function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
            		->join('clinicas',            function($join3) { $join3->on('filials.clinica_id', '=', 'clinicas.id');})
            		->join('profissionals',       function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
            		->join('filial_profissional', function($join5) { $join5->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
            		->join('atendimentos',        function($join6) { $join6->on('atendimentos.profissional_id', '=', 'profissionals.id');})
            		->join('consultas',           function($join7) use ($consulta_id) { $join7->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
            		->where('clinicas.cs_status', '=', 'A')->whereNotIn('enderecos.id', $list_endereco_ids)
            		->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro',  'filials.nm_nome_fantasia as ds_bairro', 'enderecos.cidade_id')
            		->distinct()
            		->orderby('enderecos.te_bairro', 'asc')
            		->get();
        		
            	//-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
            	foreach ($outros_enderecos as $query)
        		{
        		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->ds_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
        		    
        		    if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $list_enderecos)) {
        		        array_push($list_enderecos, $arResultado);
        		    }
        		}
            }
        
        } elseif ($tipo_atendimento == 'exame' | $tipo_atendimento == 'odonto') {
            
            //$tipo_atendimento_id = 3;
            $tipo_atendimento_id = $tipo_atendimento == 'exame' ? 3 : 2;
            $procedimento_id = $ct_atendimento->procedimento_id;
            
            //-- realiza a lista dos atendimentos do tipo EXAME---------------
            //DB::enableQueryLog();
            $atendimentos = Atendimento::with('clinica')
                ->join('procedimentos',         function($join1) use ($tipo_atendimento_id) { $join1->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->where('procedimentos.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
                ->join('clinicas',              function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
                ->join('filials',               function($join3) { $join3->on('clinicas.id', '=', 'filials.clinica_id');})
                ->join('enderecos',             function($join4) use ($local_atendimento) { $join4->on('filials.endereco_id', '=', 'enderecos.id')->where(function($query) use ($local_atendimento) { if ($local_atendimento == 'todos') { $query->where(DB::raw("1"), '=', DB::raw("1")); } else { $query->where(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));}});})
                ->join('atendimento_filial',    function($join8) { $join8->on('atendimento_filial.filial_id', '=', 'filials.id')->on('atendimento_filial.atendimento_id', '=', 'atendimentos.id');})
                ->where('atendimentos.procedimento_id', '=', $procedimento_id)->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
                ->orderBy('atendimentos.vl_com_atendimento', $sort_item)
                ->select('atendimentos.*', 'atendimentos.id', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'atendimentos.ds_preco', 'atendimentos.procedimento_id', 'filials.id as filial_id')
                ->distinct()
                ->get();
            //$query = DB::getQueryLog();
            //print_r($query);
                
            //-- seleciona os itens de atendimento removendo as repeticoes-----------
            $atendimentos_temp = DB::table('atendimentos')
                ->join('procedimentos', 	    function($join1) use ($tipo_atendimento_id) { $join1->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->where('procedimentos.tipoatendimento_id', '=', DB::raw($tipo_atendimento_id));})
                ->join('clinicas',              function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
                ->join('filials',               function($join4) { $join4->on('clinicas.id', '=', 'filials.clinica_id');})
                ->join('tag_populars', 		    function ($join3) { $join3->on('tag_populars.procedimento_id', '=', 'procedimentos.id');})
                ->join('atendimento_filial',    function($join5) { $join5->on('atendimento_filial.filial_id', '=', 'filials.id')->on('atendimento_filial.atendimento_id', '=', 'atendimentos.id');})
                ->where('atendimentos.cs_status', '=', 'A')->where('clinicas.cs_status', '=', 'A')
                ->orderBy('tag_populars.id', 'asc')
                ->select(DB::raw('on (tag_populars.id) tag_populars.id'), 'atendimentos.id as idatendimento', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'tag_populars.cs_tag as ds_preco', 'atendimentos.cs_status', 'atendimentos.created_at', 'atendimentos.updated_at', 'atendimentos.clinica_id', 'atendimentos.consulta_id', 'atendimentos.procedimento_id', 'atendimentos.profissional_id')
                ->distinct()
                ->get(['procedimentos.cd_procedimento']);
                
            foreach ($atendimentos_temp as $atend) {
                
                if (!EspecialidadeController::checkIfAtendimentoExists($list_atendimentos, $atend->procedimento_id)) {
                    
                    $item = [
                        'id' => $atend->idatendimento,
                        'tipo' => 'exame',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->procedimento_id
                    ];
                    
                    array_push($list_atendimentos, $item);
                }
            }

            
            //-- busca dos enderecos disponíveis de atendimento --------------------
            
            $enderecos = Endereco::with('cidade')->with('cidade')
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
            
            //-- lista enderecos id usada para aplicar clausula NOI IN na lista dos demais enderecos ---
            $list_endereco_ids = [];
            
            /* if($endereco_id != 'TODOS') {
                //-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
                $arResultado = [ 'id' =>  $endereco->id, 'cidade_id' => $endereco->cidade_id, 'value' => ucwords(strtolower($endereco->ds_bairro)).': '.$endereco->cidade->nm_cidade, 'te_bairro' =>  $endereco->te_bairro ];
                array_push($list_enderecos, $arResultado);
            } */
            
            foreach ($enderecos as $query)
            {
            	$cidade = Cidade::findorfail($query->cidade_id);
                
            	$arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->ds_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
                if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $list_enderecos)) {
                    array_push($list_enderecos, $arResultado);
                }
                array_push($list_endereco_ids, $query->id);
            }
            
            /* if($endereco_id != 'TODOS') {
                //-- busca os demais enderecos disponíveis de atendimento --------------------
                $outros_enderecos = Endereco::with('cidade')
                    ->join('cidades',           function($join1) use ($cidade_id) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.id', '=', DB::raw($cidade_id));})
                    //->join('clinica_endereco',  function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
                    ->join('filials',           function($join2) { $join2->on('enderecos.id', '=', 'filials.endereco_id');})
                    ->join('clinicas',          function($join3) { $join3->on('filials.clinica_id', '=', 'clinicas.id');})
                    //->join('profissionals',     function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
                    //->join('filial_profissional',   function($join7) { $join7->on('profissionals.id', '=', 'filial_profissional.profissional_id')->on('filial_profissional.filial_id', '=', 'filials.id');})
                    ->join('atendimentos',      function($join5) { $join5->on('atendimentos.clinica_id', '=', 'clinicas.id');})
                    ->join('procedimentos',     function($join6) use ($procedimento_id) { $join6->on('procedimentos.id', '=', 'atendimentos.procedimento_id')->on('atendimentos.procedimento_id', '=', DB::raw($procedimento_id));})
                    ->where('clinicas.cs_status', '=', 'A')->whereNotIn('enderecos.id', $list_endereco_ids)
                    ->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
                    ->distinct()
                    ->orderby('enderecos.te_bairro', 'asc')
                    ->get();
                
                //-- realiza a conversao dos itens para exibicao no droplist da landing page ---------------
                foreach ($outros_enderecos as $query)
                {
                    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => ucwords(strtolower($query->te_bairro)).': '.$query->cidade->nm_cidade, 'te_bairro' => $query->te_bairro ];
                    
                    if (!EspecialidadeController::checkIfExistsInArray($query->te_bairro, $list_enderecos)) {
                        array_push($list_enderecos, $arResultado);
                    }
                }
            } */
            
        }
        
        //-- realiza a lista dos locais para uso do GOOGLE MAPS---------------
        foreach ($atendimentos as $atend) {
            
            $filial_temp = Filial::findorfail($atend->filial_id);
            $filial_temp->load('endereco');
            $filial_temp->endereco->load('cidade');
            $info = "<strong>".$atend->clinica->nm_fantasia." - Unidade: (".$filial_temp->nm_nome_fantasia.")"."</strong><br> ".$filial_temp->endereco->te_endereco."<br> ".$filial_temp->endereco->te_bairro." - ".$filial_temp->endereco->cidade->nm_cidade.", ".$filial_temp->endereco->cidade->sg_estado.", ".$filial_temp->endereco->getCepFormatado()."<br>";
            $lat = $filial_temp->endereco->nr_latitude_gps;
            $long = $filial_temp->endereco->nr_longitute_gps;
            
            $atend->filial_result = $filial_temp;
            
            $item_google_maps = ['info' => $info, 'lat' => $lat, 'long' => $long];
            
            array_push($locais_google_maps, $item_google_maps);
        }
        
        return view('resultado', compact('atendimentos', 'list_atendimentos', 'list_enderecos', 'tipo_atendimento', 'locais_google_maps'));
    }
}
