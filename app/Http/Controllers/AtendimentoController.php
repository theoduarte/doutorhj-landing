<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Tipoatendimento;
use App\Consulta;
use App\Atendimento;
use App\Endereco;

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
        
        $endereco = Endereco::findorfail($endereco_id);
        $endereco->load('cidade');
        $ct_atendimento = Atendimento::findorfail($atendimento_id);
        $cidade_id = $endereco->cidade->id;
        
        if ($tipo_atendimento == 'saude') {
        	 
        	//DB::enableQueryLog();
        	$atendimentos = Atendimento::with('clinica')
        	    ->join('consultas', function($join1) { $join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', 1);})
        		->join('clinicas', function($join2) { $join2->on('clinicas.id', '=', 'atendimentos.clinica_id');})
        		->join('clinica_endereco', function($join3) { $join3->on('clinicas.id', '=', 'clinica_endereco.clinica_id');})
        		->join('enderecos', function($join4) use ($endereco_id) { $join4->on('clinica_endereco.endereco_id', '=', 'enderecos.id')->on('enderecos.id', '=', DB::raw($endereco_id));})
        		->where('atendimentos.consulta_id', '=', $ct_atendimento->consulta_id)
        		->orderBy('atendimentos.vl_com_atendimento', $sort_item)
        		->select('atendimentos.*', 'atendimentos.id', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'atendimentos.ds_preco', 'atendimentos.consulta_id')
        		->distinct()
        		->get();
        	 
        	//$especialidades = Especialidade::orderBy('ds_especialidade', 'asc')->pluck('ds_especialidade', 'id');
        	//$query = DB::getQueryLog();
        	//print_r($query);
        	$locais_google_maps = [];
//         	var clinicaTres = {
//         	    info: '<strong>Clínica Devas</strong><br>\r\
//                                 SDN CNB Etapa III - S 4104, Setor de<br> Diversões Norte - Brasília, DF, 70077-000<br>\
//                                 <a href="https://goo.gl/2JdPbn">Obter direção</a>',
//                                 lat: -15.7920841,
//                                 long: -47.8859702
//         	};
        	
        	foreach ($atendimentos as $atend) {
        	    $atend->clinica->load('enderecos');
        	    $atend->clinica->enderecos->first()->load('cidade');
        	    $info = "<strong>".$atend->clinica->nm_fantasia."</strong><br> ".$atend->clinica->enderecos->first()->te_endereco."<br> ".$atend->clinica->enderecos->first()->te_bairro." - ".$atend->clinica->enderecos->first()->cidade->nm_cidade.", ".$atend->clinica->enderecos->first()->cidade->sg_estado.", ".$atend->clinica->enderecos->first()->getCepFormatado()."<br>";
        	    $lat = $atend->clinica->enderecos->first()->nr_latitude_gps;
        	    $long = $atend->clinica->enderecos->first()->nr_longitute_gps;
        	    
        	    $item_google_maps = ['info' => $info, 'lat' => $lat, 'long' => $long];
        	    
        	    array_push($locais_google_maps, $item_google_maps);
        	}
        	
        	$atendimentos_temp = DB::table('atendimentos')
        	   ->join('consultas', function($join1) { $join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', 1);})
        	   ->select('atendimentos.*')
        	   ->distinct()
        	   ->get(['consultas.cd_consulta']);
            
            foreach ($atendimentos_temp as $atend) {
        		    
                if (!EspecialidadeController::checkIfAtendimentoExists($list_atendimentos, $atend->consulta_id)) {
        		        
    		        $item = [
    		            'id' => $atend->id,
    		            'tipo' => 'consulta',
    		            'descricao' => $atend->ds_preco,
    		            'codigo' => $atend->consulta_id
    		        ];
    		        
    		        array_push($list_atendimentos, $item);
    		    }
    		}
    		
    		$local_atendimento = UtilController::toStr($endereco->te_bairro);
    		
    		$consulta_id = $ct_atendimento->consulta_id;
    		$enderecos = Endereco::with('cidade')
    		    ->join('cidades', function($join1) use ($local_atendimento) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$local_atendimento."%'"));})
        		->join('clinica_endereco', function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
        		->join('clinicas', function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
        		->join('profissionals', function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
        		->join('atendimentos', function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
        		//->join('consultas', function($join6) use ($atendimento_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('consultas.id', '=', DB::raw($procedimento_id));})
        		->join('consultas', function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
        		->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
        		->distinct()
        		->get();
        	
        	$list_endereco_ids = []; 
        	
        	foreach ($enderecos as $query)
        	{
        	    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => $query->te_bairro.': '.$query->cidade->nm_cidade ];
        	    array_push($list_enderecos, $arResultado);
        	    array_push($list_endereco_ids, $query->id);
            }
        	
    		$outros_enderecos = Endereco::with('cidade')
    		    ->join('cidades', function($join1) use ($cidade_id) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.id', '=', DB::raw($cidade_id));})
        		->join('clinica_endereco', function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
        		->join('clinicas', function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
        		->join('profissionals', function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
        		->join('atendimentos', function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
        		->join('consultas', function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
        		->whereNotIn('enderecos.id', $list_endereco_ids)
        		->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
        		->distinct()
        		->get();
        	
//         	dd($outros_enderecos);
    		
        	foreach ($outros_enderecos as $query)
    		{
    		    $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => $query->te_bairro.': '.$query->cidade->nm_cidade ];
    		    array_push($list_enderecos, $arResultado);
    		}
        
        }
        
        return view('resultado', compact('atendimentos', 'list_atendimentos', 'list_enderecos', 'tipo_atendimento', 'locais_google_maps'));
    }
}
