<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Tipoatendimento;
use App\Consulta;
use App\Atendimento;

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
        $url = 'http://192.168.1.241';
        return redirect()->to($url)->with('success', 'O Item foi adicionado com sucesso');
        
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	/* $user_id = 17;
    	//$cartCollection = \Cart::session($user_id)->getContent();
    	$cartCollection = \Cart::getContent();
    	dd($cartCollection); */
    	
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $tipo_especialidade = CVXRequest::get('tipo_especialidade');
        $local_atendimento = UtilController::toStr(CVXRequest::get('local_atendimento'));
        $endereco_id = CVXRequest::get('endereco_id');
        
        $atendimentos = [];
        
        if ($tipo_atendimento == 'saude') {
        	 
        	//DB::enableQueryLog();
        	$atendimentos = Atendimento::with('clinica')
        		->join('clinicas', function($join1) { $join1->on('clinicas.id', '=', 'atendimentos.clinica_id');})
        		->join('clinica_endereco', function($join2) { $join2->on('clinicas.id', '=', 'clinica_endereco.clinica_id');})
        		->join('enderecos', function($join3) use ($endereco_id) { $join3->on('clinica_endereco.endereco_id', '=', 'enderecos.id')->on('enderecos.id', '=', DB::raw($endereco_id));})
        		->select('atendimentos.*', 'atendimentos.id', 'atendimentos.vl_com_atendimento', 'atendimentos.vl_net_atendimento', 'atendimentos.ds_preco', 'atendimentos.consulta_id')
        		->distinct()
        		->get();
        	 
        	//$especialidades = Especialidade::orderBy('ds_especialidade', 'asc')->pluck('ds_especialidade', 'id');
        	//$query = DB::getQueryLog();
        	//print_r($query);
        	 
        	//dd($atendimentos);
        
        }
        
        return view('resultado', compact('atendimentos', 'tipo_atendimento'));
    }
}
