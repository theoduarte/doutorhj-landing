<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Tipoatendimento;
use App\Consulta;
use App\Especialidade;
use App\Endereco;
use App\Atendimento;

class EspecialidadeController extends Controller
{
    
    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaEspecialidades()
    {
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $result = [];
        
        if ($tipo_atendimento == 'saude') {
            
            //DB::enableQueryLog();
            $atendimentos = DB::table('atendimentos')
                ->join('consultas', function($join1) { $join1->on('consultas.id', '=', 'atendimentos.consulta_id')->where('consultas.tipoatendimento_id', '=', 1);})
                ->select('atendimentos.*')
                ->distinct()
                ->get(['consultas.cd_consulta']);
                
            //$query = DB::getQueryLog();
            //dd($atendimentos);
        
            foreach ($atendimentos as $atend) {
                
                if (!EspecialidadeController::checkIfAtendimentoExists($result, $atend->consulta_id)) {
                    
                    $item = [
                        'id' => $atend->id,
                        'tipo' => 'consulta',
                        'descricao' => $atend->ds_preco,
                        'codigo' => $atend->consulta_id
                    ];
                    
                    array_push($result, $item);
                }
            }
            
        } elseif ($tipo_atendimento == 'odonto') {
            
            $tp_atendimento = DB::table('consultas')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'consultas.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "200");})
                ->select('consultas.*', 'consultas.id', 'consultas.cd_consulta', 'consultas.ds_consulta')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'consulta',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'exame') {
            
            $tp_atendimento = DB::table('procedimentos')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'procedimentos.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "300");})
                ->select('procedimentos.*', 'procedimentos.id', 'procedimentos.cd_procedimento', 'procedimentos.ds_procedimento')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_procedimento
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'procedimento') {
            
            $tp_atendimento = DB::table('procedimentos')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'procedimentos.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "400");})
                ->select('procedimentos.*', 'procedimentos.id', 'procedimentos.cd_procedimento', 'procedimentos.ds_procedimento')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_procedimento
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
        //dd("busca: $search_term tipo: $tipo_atendimento id: $procedimento_id especialidade: $tipo_especialidade");
        
        $result = [];
        
        /* $menus_app = Menu::with('itemmenus')
        	    ->join('menu_perfiluser', function($join1) { $join1->on('menus.id', '=', 'menu_perfiluser.menu_id');})
        	    ->join('perfilusers', function($join2) { $join2->on('menu_perfiluser.perfiluser_id', '=', 'perfilusers.id');})
        	    ->join('users', function($join3) use($user_id) { $join3->on('perfilusers.id', '=', 'users.perfiluser_id')->on('users.id', '=', DB::raw($user_id));})
        	    ->select('menus.*', 'menus.id', 'menus.titulo')
        	    ->get(); */
        
        if ($tipo_atendimento == 'saude') {
        	
            $consulta_id = $ct_atendimento->consulta_id;
        	//DB::enableQueryLog();
            $enderecos = Endereco::with('cidade')
	        	->join('cidades', function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));})
	        	->join('clinica_endereco', function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
	        	->join('clinicas', function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
	        	->join('profissionals', function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
	        	->join('atendimentos', function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
	        	//->join('consultas', function($join6) use ($atendimento_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('consultas.id', '=', DB::raw($procedimento_id));})
	        	->join('consultas', function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
	        	->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
	        	->distinct()
	        	->get();
	        
	        //$especialidades = Especialidade::orderBy('ds_especialidade', 'asc')->pluck('ds_especialidade', 'id');
//  	        $query = DB::getQueryLog();
//  	        dd($query);
	        
	        //dd($enderecos);
// 	        posts_data.append({ "value": post.title, "id" : post.id , "type": "post"})
// 	        response = {"query": "Unit", "suggestions": result}
	        	
	        foreach ($enderecos as $query)
	        {
	            //$query->load('cidade');
	            $arResultado = [ 'id' =>  $query->id, 'cidade_id' => $query->cidade_id, 'value' => $query->te_bairro.': '.$query->cidade->nm_cidade ];
	        	array_push($result, $arResultado);
	       	}
            
        }
        
        $response = ["suggestions" => $result];
        
        return Response()->json($response);
    }
    
    public function consultaEnderecoLocalAtendimento()
    {
        
        $search_term = UtilController::toStr(CVXRequest::post('search_term'));
        $tipo_atendimento = CVXRequest::post('tipo_atendimento');
        $atendimento_id = CVXRequest::post('atendimento_id');
        $ct_atendimento = Atendimento::findorfail($atendimento_id);
        
        //dd("busca: $search_term tipo: $tipo_atendimento id: $procedimento_id especialidade: $tipo_especialidade");
        
        $result = [];
        
        /* $menus_app = Menu::with('itemmenus')
         ->join('menu_perfiluser', function($join1) { $join1->on('menus.id', '=', 'menu_perfiluser.menu_id');})
         ->join('perfilusers', function($join2) { $join2->on('menu_perfiluser.perfiluser_id', '=', 'perfilusers.id');})
         ->join('users', function($join3) use($user_id) { $join3->on('perfilusers.id', '=', 'users.perfiluser_id')->on('users.id', '=', DB::raw($user_id));})
         ->select('menus.*', 'menus.id', 'menus.titulo')
         ->get(); */
        
        if ($tipo_atendimento == 'saude') {
            
            //DB::enableQueryLog();
            $consulta_id = $ct_atendimento->consulta_id;
            $enderecos = Endereco::with('cidade')
            ->join('cidades', function($join1) use ($search_term) { $join1->on('cidades.id', '=', 'enderecos.cidade_id')->on(DB::raw('to_str(cidades.nm_cidade)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_endereco)'), 'LIKE', DB::raw("'%".$search_term."%'"))->orOn(DB::raw('to_str(enderecos.te_bairro)'), 'LIKE', DB::raw("'%".$search_term."%'"));})
            ->join('clinica_endereco', function($join2) { $join2->on('enderecos.id', '=', 'clinica_endereco.endereco_id');})
            ->join('clinicas', function($join3) { $join3->on('clinica_endereco.clinica_id', '=', 'clinicas.id');})
            ->join('profissionals', function($join4) { $join4->on('profissionals.clinica_id', '=', 'clinicas.id');})
            ->join('atendimentos', function($join5) { $join5->on('atendimentos.profissional_id', '=', 'profissionals.id');})
            //->join('consultas', function($join6) use ($atendimento_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('consultas.id', '=', DB::raw($procedimento_id));})
            ->join('consultas', function($join6) use ($consulta_id) { $join6->on('consultas.id', '=', 'atendimentos.consulta_id')->on('atendimentos.consulta_id', '=', DB::raw($consulta_id));})
            ->select('enderecos.*', 'enderecos.id', 'enderecos.te_endereco', 'enderecos.te_bairro', 'enderecos.cidade_id')
            ->distinct()
            ->get();
            
            $result = $enderecos->first();
            
            if (isset($result)) {
                $result->nm_cidade = $result->te_bairro.': '.$result->cidade->nm_cidade;
            }
            
            return response()->json(['status' => true, 'endereco' => $result]);
        }
        
        return response()->json(['status' => false]);
    }
    
    public static function checkIfAtendimentoExists($list_atendimentos, $item) {
        
        foreach ($list_atendimentos as $atendimento) {
            
            if($atendimento['codigo'] == $item) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
}
