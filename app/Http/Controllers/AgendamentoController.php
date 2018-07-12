<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request as CVXRequest;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Agendamento;
use App\Clinica;
use App\Profissional;
use App\Estado;
use App\Atendimento;
use App\Http\Requests\AgendamentoRequest;
use App\Itempedido;
//use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Paciente;
use App\CartaoPaciente;
use App\Pedido;
use App\Mensagem;
use App\MensagemDestinatario;
use App\Filial;
use App\Checkup;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $get_term = CVXRequest::get('dt_atendimento');
        $search_term = UtilController::toStr($get_term);
        
        $agenda = Agendamento::where(DB::raw('to_str(dt_atendimento)'), 'LIKE', '%'.$search_term.'%')->sortable()->paginate(10);
                                        
        $agenda->load('clinica');    
        $agenda->load('paciente');
        $agenda->load('Profissional');
        
        return view('agenda.index', compact('agenda'));
    }
    
    
    /**
     * informaBeneficiario a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function informaBeneficiario(){
        /*$user_id = 17;
        
        \Cart::session($user_id)->add(455, 'Sample Item', 100.99, 2, array());
        \Cart::clear();
        \Cart::add(array(
        'id' => 456,
        'name' => 'Sample Item 1',
        'price' => 67.99,
        'quantity' => 4,
        'attributes' => array()
        ));
        
        \Cart::add(array(
        'id' => 568,
        'name' => 'Sample Item 2',
        'price' => 69.25,
        'quantity' => 4,
        'attributes' => array(
        'size' => 'L',
        'color' => 'blue'
        )
        ));*/
        
//         $atendimento_id		= $request->input('atendimento_id');
//         $profissional_id	= $request->input('profissional_id');
//         $paciente_id		= $request->input('paciente_id');
//         $clinica_id			= $request->input('clinica_id');
//         $data_atendimento	= $request->input('data_atendimento');
//         $hora_atendimento	= $request->input('hora_atendimento');
//         $vl_com_atendimento = $request->input('vl_com_atendimento');
//         $url                = $request->input('current_url');
        
        $cartCollection = CVXCart::getContent();
        $itens = $cartCollection->toArray();
        
        $carrinho = [];
        $user_session = Auth::user();
        $url = '';
        $tem_titular = false;
        $tem_pacientes = false;
        $item_titular = [];
        $proximo_item = [];
        
        foreach ($itens as $item) {
            $atendimento_tmp_id = $item['attributes']['atendimento_id'];
            $profissional_tmp_id = $item['attributes']['profissional_id'];
            $clinica_tmp_id = $item['attributes']['clinica_id'];
            $filial_tmp_id = $item['attributes']['filial_id'];
            $paciente_tmp_id = $item['attributes']['paciente_id'];
            
            $atendimento = Atendimento::findOrFail($atendimento_tmp_id);
            $profissional = isset($profissional_tmp_id) ? Profissional::findOrFail($profissional_tmp_id) : null;
            $clinica = Clinica::findOrFail($clinica_tmp_id);
            $filial = Filial::findOrFail($filial_tmp_id);
            $paciente = $paciente_tmp_id != '' ? Paciente::findOrFail($paciente_tmp_id) : [];
            $url = $item['attributes']['current_url'];
            
            $titular = false;
            if(sizeof($paciente) > 0) {
                if($user_session->paciente->id == $paciente->id) {
                    $titular = true;
                    $tem_titular = true;
                }
                
                $tem_pacientes = true;
            }
            
            if ($atendimento->procedimento_id != null) {
                $atendimento->load('procedimento');
                //$atendimento->load('profissional');
                //$atendimento->profissional->load('especialidades');
                
                //$nome_especialidade = "";
                $nome_especialidade = $atendimento->procedimento->ds_procedimento;
                $ds_atendimento = $atendimento->procedimento->tag_populars->first()->cs_tag;
                
                /* foreach ($atendimento->profissional->especialidades as $especialidade) {
                    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
                } */
                
                $nome_especialidade = $atendimento->procedimento->ds_procedimento;
                $atendimento->nome_especialidade = $nome_especialidade;
            }
            
            if ($atendimento->consulta_id != null) {
                $atendimento->load('consulta');
                $atendimento->load('profissional');
                $atendimento->profissional->load('especialidades');
                
                $nome_especialidade = "";
                
                foreach ($atendimento->profissional->especialidades as $especialidade) {
                    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
                }
                
                $atendimento->nome_especialidade = $nome_especialidade;
            }
            
            //dd($atendimento);
            
            if (isset($clinica)) {
                $clinica->load('enderecos');
            }
            
            if (isset($filial)) {
                $filial->load('endereco');
            }
            
            $item_carrinho = array(
                'item_id' 				=> $item['id'],
                'valor' 				=> $item['price'],
                'atendimento' 			=> $atendimento,
                'profissional' 			=> $profissional,
                'clinica' 				=> $clinica,
                'filial' 				=> $filial,
                'titular'               => $titular,
                'paciente'				=> $paciente,
                'data_agendamento' 		=> isset($item['attributes']['data_atendimento']) ? $item['attributes']['data_atendimento'] : null,
                'hora_agendamento' 		=> isset($item['attributes']['hora_atendimento']) ? $item['attributes']['hora_atendimento'] : null,
                'current_url' 			=> $url
            );
            
            if ($titular) {
                $item_titular = $item_carrinho;
            }
            
            if(sizeof($paciente) <= 0) {
                $proximo_item = $item_carrinho;
            }
            
            array_push($carrinho, $item_carrinho);
        }
        
        //dd($proximo_item['clinica']);
        
        $valor_total = CVXCart::getTotal();
        
        $responsavel_id = $user_session->paciente->id;
        
        $dependentes = Paciente::where('responsavel_id', $responsavel_id)->where('cs_status', '=', 'A')->get();
        
        $paciente_titular = $user_session->paciente;
        
        return view('agendamentos.informa-beneficiario', compact('url', 'item_titular', 'tem_titular', 'tem_pacientes', 'carrinho', 'dependentes', 'paciente_titular', 'proximo_item', 'valor_total'));
    }
    
    /**
     * Realiza o agendamento de um usuÃ¡rio autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agendarAtendimento(AgendamentoRequest $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$tipo_atendimento	= $request->input('tipo_atendimento');
    	
    	//\Cart::clear();
    	$item_pedido = Itempedido::all()->last();
    	$cart_id = 0;
    	 
    	$cartCollection = CVXCart::getContent();
    	$num_itens = $cartCollection->count();
    	 
    	if (!isset($item_pedido) & $num_itens == 0) {
    		$cart_id = 1;
    	} elseif (isset($item_pedido) & $num_itens == 0) {
    		$cart_id = $item_pedido->id;
    	} elseif (isset($item_pedido) & $num_itens > 0) {
    		$cart_id = $item_pedido->id;
    		$cart_id = $cart_id + $num_itens + 1;
    	} else {
    		$cart_id = $num_itens + 1;
    	}
    	
    	if ($tipo_atendimento == 'simples') {
    		$atendimento_id		= $request->input('atendimento_id');
    		$profissional_id	= $request->input('profissional_id');
    		$paciente_id		= $request->input('paciente_id');
    		$clinica_id			= $request->input('clinica_id');
    		$filial_id			= $request->input('filial_id');
    		$data_atendimento	= $request->input('data_atendimento');
    		$hora_atendimento	= $request->input('hora_atendimento');
    		$vl_com_atendimento = $request->input('vl_com_atendimento');
    		$url 				= $request->input('current_url');
    		
    		CVXCart::add(array(
    				'id' => $cart_id,
    				'name' => 'Agendamento Item '.strval($num_itens + 1),
    				'price' => $vl_com_atendimento,
    				'quantity' => 1,
    				'attributes' => array(
    						'atendimento_id' => $atendimento_id,
    						'profissional_id' => $profissional_id,
    						'paciente_id' => $paciente_id,
    						'clinica_id' => $clinica_id,
    						'filial_id' => $filial_id,
    						'data_atendimento' => $data_atendimento,
    						'hora_atendimento' => $hora_atendimento,
    						'current_url' => $url
    				)
    		));
    	} else {
    		
    		$checkup_id			= $request->input('checkup_id');
    		$vl_total_checkup	= $request->input('vl_total_checkup');
    		$url = "";
    		
    		$datas_atend_checkup = [];
    		$horas_atend_checkup = [];
    		
    		$checkup = Checkup::findorfail($checkup_id);
    		$checkup->load('itemcheckups');
    		
    		$items_checkup = $checkup->itemcheckups;
    		
    		foreach ($items_checkup as $item) {
    			
    			if ($request->input('selecionaData_'.$item->atendimento_id)) {
    				$item['data_agendamento'] = $request->input('selecionaData_'.$item->atendimento_id); 
    				$item['hora_agendamento'] = $request->input('selecionaHora_'.$item->atendimento_id);
    			}
    		}
    		
    		CVXCart::add(array(
    				'id' => $cart_id,
    				'name' => 'Agendamento Item '.strval($num_itens + 1),
    				'price' => $vl_total_checkup,
    				'quantity' => 1,
    				'attributes' => array(
    						'atendimento_id' => null,
    						'profissional_id' => null,
    						'paciente_id' => null,
    						'clinica_id' => null,
    						'filial_id' => null,
    						'data_atendimento' => null,
    						'hora_atendimento' => null,
    						'datas_atend_checkup' => $datas_atend_checkup,
    						'horas_atend_checkup' => $horas_atend_checkup,
    						'checkup_id' => $checkup_id,
    						'current_url' => $url
    				)
    		));
    	}
    	
//     	$atendimento = Atendimento::findOrFail($atendimento_id);
//     	dd($atendimento);
    	 
    	//return view('agendamentos.pagamento', compact('cargos'));
    	//return Redirect::to($url);
    	//return redirect()->to($url)->with('success', 'O Item foi adicionado com sucesso');
    	//return redirect()->to($url)->with('cart', 'O Item foi adicionado com sucesso');
    	
    	
    	
    	//dd($carrinho);
    	
    	//return redirect()->route('carrinho')->with('cart', 'O Item foi adicionado com sucesso');
    	return redirect()->route('informa-beneficiario')->with('cart', 'O Item foi adicionado com sucesso');
    	
    	//return view('carrinho', compact('url', 'carrinho', 'valor_total'))->with('cart', 'O Item foi adicionado com sucesso');
    }
    
    /**
     * Realiza a atualizacao dos itens do carrinho
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function atualizaCarrinho(AgendamentoRequest $request)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $item_id		    = $request->input('item_id');
        $atendimento_id		= $request->input('atendimento_id');
        $profissional_id	= $request->input('profissional_id');
        $paciente_id		= $request->input('paciente_id');
        $clinica_id			= $request->input('clinica_id');
        $filial_id			= $request->input('filial_id');
        $data_atendimento	= $request->input('data_atendimento');
        $hora_atendimento	= $request->input('hora_atendimento');
        $vl_com_atendimento = $request->input('vl_com_atendimento');
        $url                = $request->input('current_url');
        
        CVXCart::update($item_id, array(
            'attributes' => array(
                'atendimento_id'    => $atendimento_id,
                'profissional_id'   => $profissional_id,
                'paciente_id'       => $paciente_id,
                'clinica_id'        => $clinica_id,
                'filial_id'         => $filial_id,
                'data_atendimento'  => $data_atendimento,
                'hora_atendimento'  => $hora_atendimento,
                'current_url'       => $url
            )
        ));
        
        return redirect()->route('carrinho')->with('cart', 'O Item foi adicionado com sucesso');
    }
    
    public function carrinhoDeCompras(){
    	
        //CVXCart::clear();
    	
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$cartCollection = CVXCart::getContent();
    	$itens = $cartCollection->toArray();
    	 
    	$carrinho = [];
    	$user_session = Auth::user();
    	$url = Request::root();
    	 
    	foreach ($itens as $item) {
    		$atendimento_tmp_id = $item['attributes']['atendimento_id'];
    		$profissional_tmp_id = $item['attributes']['profissional_id'];
    		$clinica_tmp_id = $item['attributes']['clinica_id'];
    		$filial_tmp_id = $item['attributes']['filial_id'];
    		$paciente_tmp_id = $item['attributes']['paciente_id'];
    	
    		$atendimento = Atendimento::findOrFail($atendimento_tmp_id);
    		$profissional = isset($profissional_tmp_id) && $profissional_tmp_id != 'null' ? Profissional::findOrFail($profissional_tmp_id) : null;
    		$clinica = Clinica::findOrFail($clinica_tmp_id);
    		$filial = Filial::findOrFail($filial_tmp_id);
    		
    		$paciente = $paciente_tmp_id != null && $paciente_tmp_id != '' ? Paciente::findOrFail($paciente_tmp_id) : [];
    		
    		$url = $item['attributes']['current_url'];
    	
    		if ($atendimento->procedimento_id != null) {
    			$atendimento->load('procedimento');
    			//$atendimento->load('profissional');
    			//$atendimento->profissional->load('especialidades');
    			
    			$nome_especialidade = $atendimento->procedimento->ds_procedimento;
    			$ds_atendimento = $atendimento->procedimento->tag_populars->first()->cs_tag;
    			
    			/*foreach ($atendimento->profissional->especialidades as $especialidade) {
    			    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    			}*/
    			
    			$atendimento->nome_especialidade = $nome_especialidade;
    			$atendimento->ds_atendimento = $ds_atendimento;
    		}
    	
    		if ($atendimento->consulta_id != null) {
    			$atendimento->load('consulta');
    			$atendimento->load('profissional');
    			$atendimento->profissional->load('especialidades');
    			
    			$nome_especialidade = "";
    			
    			foreach ($atendimento->profissional->especialidades as $especialidade) {
    			    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    			}
    			    			
    			$ds_atendimento = $atendimento->consulta->tag_populars->first()->cs_tag;
    			
    			$atendimento->nome_especialidade = $nome_especialidade;
    			$atendimento->ds_atendimento = $ds_atendimento;
    		}
    	
    		//dd($atendimento);
    	
    		if (isset($clinica)) {
    			$clinica->load('enderecos');
    		}
    		
    		if (isset($filial)) {
    		    $filial->load('endereco');
    		}
    		
    		$data_atendimento = $item['attributes']['data_atendimento'];
    		$hora_atendimento = $item['attributes']['hora_atendimento'];
    	
    		$item_carrinho = array(
    				'item_id' 				=> $item['id'],
    				'valor' 				=> $item['price'],
    				'atendimento' 			=> $atendimento,
    				'profissional' 			=> $profissional,
    				'clinica' 				=> $clinica,
    		        'filial' 				=> $filial,
    		        'paciente'				=> $paciente,
    		        'data_agendamento' 		=> isset($data_atendimento) ? $data_atendimento : null,
    		        'hora_agendamento' 		=> isset($hora_atendimento) ? $hora_atendimento : null,
    				'current_url' 			=> $url
    		);
    		//dd($paciente);
    		if (!empty($paciente)) {
    			array_push($carrinho, $item_carrinho);
    		} else {
    			CVXCart::remove($item_carrinho['item_id']);
    		}
    	}
    	
    	$valor_total = CVXCart::getTotal();
    	
    	return view('agendamentos.carrinho', compact('url', 'carrinho', 'valor_total'));
    }
    
    /**
     * Consulta para alimentar autocomplete
     * 
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocalAtendimento($consulta){
        $arJson = array();
        $consultas = Clinica::where(DB::raw('to_str(nm_razao_social)'), 'like', '%'.UtilController::toStr($consulta).'%')->get();
        $consultas->load('documentos');
        
        foreach ($consultas as $query)
        {
            $nrDocumento = null;
            foreach($query->documentos as $objDocumento){
                if( $objDocumento->tp_documento == 'CNPJ' ){
                    $nrDocumento = $objDocumento->te_documento;
                }
            }
            
            $teDocumento = (!empty($nrDocumento)) ? ' - CNPJ: ' . UtilController::formataCnpj($nrDocumento) : null;
            $arJson[] = [ 'id' => $query->id, 'value' => $query->nm_razao_social . $teDocumento];
        }
        
        return Response()->json($arJson);
    }
    
    /**
     * Consulta para alimentar autocomplete
     * 
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfissional($profissional){
        $arJson = array();
        $profissional = Profissional::where(function($query){
//                         dd(Request::all());
                # $query->where(DB::raw('to_str(CONCAT(nm_primario, nm_secundario))'),'like', '%'.UtilController::toStr($profissional).'%');
            
            
                                                })->get();
        $profissional->load('documentos');
        
        foreach ($profissional as $query)
        {
            foreach($query->documentos as $objDocumento){
                if( $objDocumento->tp_documento == 'CRM' or 
                        $objDocumento->tp_documento == 'CRO' ){
                    
                    $estado = Estado::findorfail((int)$objDocumento->estado_id);
                    $teDocumento = $objDocumento->te_documento.' '.$objDocumento->tp_documento.'/'.$estado->sg_estado;
                }
            }
            
            $arJson[] = [ 'id' => $query->id, 'value' => $query->nm_primario.' '.$query->nm_secundario. ' '. $teDocumento];
        }
        
        return Response()->json($arJson);
    }
    
    /**
     * lista os agendamentos na area logada do cliente
     *
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function meusAgendamentos(){
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $agendamentos_home = [];
        
        if (Auth::check()) {
            
            $paciente_id = Auth::user()->paciente->id;
            
            //DB::enableQueryLog();
            $agendamentos_home = Agendamento::with('paciente')->with('clinica')->with('atendimento')->with('profissional')->with('itempedidos')
	            ->join('pacientes', function($join1) use ($paciente_id) { $join1->on('pacientes.id', '=', 'agendamentos.paciente_id')->where(
	            function($query) use ($paciente_id) { $query->on('pacientes.responsavel_id', '=', DB::raw($paciente_id))->orOn('pacientes.id', '=', DB::raw($paciente_id));});})
	            ->select('agendamentos.*')
	            ->whereNotNull('agendamentos.atendimento_id')
	            ->distinct()
	            ->orderBy('dt_atendimento', 'desc')->get();
	        
	       //$query_temp = DB::getQueryLog();
	       //dd($query_temp);
            
            for ($i = 0; $i < sizeof($agendamentos_home); $i++) {
                $agendamentos_home[$i]->clinica->load('enderecos');
                $agendamentos_home[$i]->clinica->enderecos->first()->load('cidade');
                $agendamentos_home[$i]->endereco_completo = $agendamentos_home[$i]->clinica->enderecos->first()->te_endereco.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->te_bairro.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->nm_cidade.'/'.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->estado->sg_estado;
                $agendamentos_home[$i]->itempedidos->first()->load('pedido');
                $agendamentos_home[$i]->itempedidos->first()->pedido->load('pagamentos');
                $agendamentos_home[$i]->valor_total = sizeof($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos) > 0 ? number_format( ($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos->first()->amount)/100,  2, ',', '.') : number_format( 0,  2, ',', '.');
                $agendamentos_home[$i]->data_pagamento = sizeof($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos) > 0 ? date('d/m/Y', strtotime($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos->first()->created_at)) : '----------';
            }
            
        }
        
        //dd($agendamentos_home);
        
        return view('agendamentos.meus-agendamentos', compact('agendamentos_home'));
    }
    
    /**
     * remarcarAgendamento a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remarcarAgendamento(Request $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$clinica_id 		= CVXRequest::post('clinica_id');
    	$profissional_id 	= CVXRequest::post('profissional_id');
    	$agendamento_id 	= CVXRequest::post('agendamento_id');
    	
    	$data_agendamento 	= CVXRequest::post('data_agendamento');
    	$hora_agendamento 	= CVXRequest::post('hora_agendamento');
    	
    	$data_temp = explode('/', $data_agendamento);
    	$data = $data_temp[2].'-'.$data_temp[1].'-'.$data_temp[0];
    	$hora = $hora_agendamento.":00";
    	
    	
    	$agendamentos = [];
    	
    	if($profissional_id != '0') {
    		$agendamentos = Agendamento::where('clinica_id', '=', $clinica_id)->where('profissional_id', $profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($data.' '.$hora)))->get();
    	} else {
    		$agendamentos = Agendamento::where('clinica_id', '=', $clinica_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($data.' '.$hora)))->get();
    	}
    	
    	$agendamento_disponivel = sizeof($agendamentos) <= 0 ? true : false;
    	
    	if (!$agendamento_disponivel) {
    		return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento nÃ£o foi realizado, pois um dos horÃ¡rios escolhidos nÃ£o estÃ£o disponÃ­veis. Por favor, tente novamente.']);
    	}
    	
    	$agendamento = Agendamento::findorfail($agendamento_id);
    	
    	if (!isset($agendamento)) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento nÃ£o foi encontrado. Por favor, tente novamente.']);
    	}
    	
    	$agendamento->cs_status = 10;
    	$agendamento->dt_atendimento    = $data.' '.$hora;
    
    	if (!$agendamento->save()) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento nÃ£o foi remarcado. Por favor, tente novamente.']);
    	}
    	
    	$agendamento->dia_agendamento 	= $data_temp[0];
    	$agendamento->mes_agendamento 	= substr(strftime('%B', strtotime($agendamento->getRawDtAtendimentoAttribute())), 0, 3);
    	$agendamento->hora_agendamento 	= date('H:i', strtotime($agendamento->getRawDtAtendimentoAttribute()));
    
    	return response()->json(['status' => true, 'mensagem' => 'O Agendamento foi remarcado com sucesso!', 'agendamento' => $agendamento->toJson()]);
    }
    
    /**
     * cancelarAgendamento a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelarAgendamento(Request $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	    	
    	$agendamento_id 	= CVXRequest::post('agendamento_id');
    	 
    	$agendamento = Agendamento::findorfail($agendamento_id);
    	 
    	if (!isset($agendamento)) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento nÃ£o foi encontrado. Por favor, tente novamente.']);
    	}
    	 
    	//$agendamento->cs_status = 60;
    	//$agendamento->dt_atendimento    = date('Y-m-d H:i:s');
    
    	if (!$agendamento->save()) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento nÃ£o foi Cancelado. Por favor, tente novamente.']);
    	}
    	 
    	$agendamento->dia_agendamento 	= '--';
    	$agendamento->mes_agendamento 	= '---';
    	$agendamento->hora_agendamento 	= '----';
    	
    	//--carrega os dados do paciente para configurar a mensagem-----
    	$paciente_id = $agendamento->paciente_id;
    	$paciente = Paciente::findorfail($paciente_id);
    	$paciente->load('user');
    	$paciente->load('documentos');
    	$paciente->load('contatos');
    	
    	//--carrega os dados do agendamento para configurar a mensagem-----
    	
    	$agendamento->load('itempedidos');
    	$agendamento->load('atendimento');
    	$agendamento->load('clinica');
    	$agendamento->load('profissional');
    	
    	$agendamento->profissional->load('especialidades');
    	$nome_especialidade = "";
    	
    	foreach ($agendamento->profissional->especialidades as $especialidade) {
    	    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    	}
    	
    	$agendamento->nome_especialidade = $nome_especialidade;
    	
    	//--carrega os dados do pedido para configurar a mensagem-----
    	$pedido_id = $agendamento->itempedidos->first()->pedido_id;
    	
    	$pedido = Pedido::findorfail($pedido_id);
    	
    	//--enviar mensagem informando do cancelamento do agendamento----------------
    	try {
    	    $this->enviarEmailCancelarAgendamento($paciente, $pedido, $agendamento);
    	} catch (Exception $e) {}
    
    	return response()->json(['status' => true, 'mensagem' => 'A SolicitaÃ§Ã£o de Cancelamento foi realizada com sucesso!', 'agendamento' => $agendamento->toJson()]);
    }
    
    /**
     * carrega os dados da conta do cliente
     *
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function minhaConta(){
    	
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
        
        $user_paciente = Auth::user();
        $user_paciente->paciente->load('contatos');
        //$user_paciente->paciente->load('dependentes');
        $responsavel_id = $user_paciente->paciente->id;
        
        $dependentes = Paciente::where('responsavel_id', $responsavel_id)->where('cs_status', '=', 'A')->get();
        
        $dt_nascimento = explode('/', $user_paciente->paciente->dt_nascimento);
        
        //--busca os cartoes de credito do paciente----------
        $cartoes_paciente = CartaoPaciente::where('paciente_id', $responsavel_id)->get();
        
        //--busca os agendamentos do paciente----------
        $agendamentos = Agendamento::with('paciente')->with('clinica')->with('atendimento')->with('profissional')->with('itempedidos')->where('paciente_id', '=', $responsavel_id)->whereNotNull('agendamentos.atendimento_id')->orderBy('dt_atendimento', 'desc')->get();
        
        foreach ($agendamentos as $agendamento) {
        	$agendamento->itempedidos->first()->pedido->load('cartao_paciente');
        	$agendamento->valor_total = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? number_format( ($agendamento->itempedidos->first()->pedido->pagamentos->first()->amount)/100,  2, ',', '.') : number_format( 0,  2, ',', '.');
        	$agendamento->data_pagamento = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? date('d/m/Y', strtotime($agendamento->itempedidos->first()->pedido->pagamentos->first()->created_at)) : '----------';
        }
        
        return view('agendamentos.minha-conta', compact('user_paciente', 'dt_nascimento', 'dependentes', 'cartoes_paciente', 'agendamentos'));
    }
    
    /**
     * consultaAgendamentoDisponivel a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consultaAgendamentoDisponivel(Request $request)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $clinica_id 		= CVXRequest::post('clinica_id');
        $profissional_id 	= CVXRequest::post('profissional_id');
        
        $data_agendamento 	= CVXRequest::post('data_agendamento');
        $hora_agendamento 	= CVXRequest::post('hora_agendamento');
        
        $data = $data_agendamento;
        $hora = $hora_agendamento.":00";
        
        
        //DB::enableQueryLog();
        $agendamentos = Agendamento::where('clinica_id', '=', $clinica_id)->where('profissional_id', $profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($data.' '.$hora)))->get();
        //$query = DB::getQueryLog();
        //dd($query);
        
        $agendamento_disponivel = sizeof($agendamentos) <= 0 ? true : false;
        
        if (!$agendamento_disponivel) {
            return response()->json(['status' => false, 'mensagem' => 'O horÃ¡rio escolhido nÃ£o estÃ¡ disponÃ­vel, pois jÃ¡ existe um atendimento marcado. Por favor, tente outro horÃ¡rio.']);
        }
        
        return response()->json(['status' => true, 'mensagem' => 'Agendamento disponÃ­vel!']);
    }
    
    /**
     * enviarEmailCancelarAgendamento a newly external user created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enviarEmailCancelarAgendamento($paciente, $pedido, $agendamento)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        # dados da mensagem
        $mensagem_drhj            		= new Mensagem();
        
        $mensagem_drhj->rma_nome     	= $paciente->nm_primario.' '.$paciente->nm_secundario;
        $mensagem_drhj->rma_email       = $paciente->user->email;
        $mensagem_drhj->assunto     	= 'Cancelamento Solicitado';
        
        $nome 		= $paciente->nm_primario.' '.$paciente->nm_secundario;
        $email 		= $paciente->user->email;
        $telefone 	= $paciente->contatos->first()->ds_contato;
        
        $nm_primario 			= $paciente->nm_primario;
        $nr_pedido 				= sprintf("%010d", $pedido->id);
        $nome_especialidade 	= $agendamento->nome_especialidade;
        $nome_profissional		= $agendamento->profissional->nm_primario.' '.$agendamento->profissional->nm_secundario;
        $data_agendamento		= date('d', strtotime($agendamento->getRawDtAtendimentoAttribute())).' de '.strftime('%B', strtotime($agendamento->getRawDtAtendimentoAttribute())).' / '.strftime('%A', strtotime($agendamento->getRawDtAtendimentoAttribute())) ;
        $hora_agendamento		= date('H:i', strtotime($agendamento->getRawDtAtendimentoAttribute())).' (por ordem de chegada)';
        $endereco_agendamento = '--------------------';
        
        $agendamento->clinica->load('enderecos');
        $enderecos_clinica = $agendamento->clinica->enderecos->first();
        
        if ($agendamento->clinica->enderecos != null) {
            $enderecos_clinica->load('cidade');
            $cidade_clinica = $enderecos_clinica->cidade;
            
            if ($cidade_clinica != null) {
                $endereco_agendamento = $enderecos_clinica->te_endereco.', '.$enderecos_clinica->nr_logradouro.', '.$enderecos_clinica->te_bairro.', '.$cidade_clinica->nm_cidade.'/ '.$cidade_clinica->sg_estado;
            }
        }
        
        $agendamento_status = 'Em Cancelamento';
        
        $mensagem_drhj->conteudo     	= "<h4>Cancelamento Solicitado pelo Cliente:</h4><br><ul><li>Nome: $nome</li><li>E-mail: $email</li><li>Telefone: $telefone</li></ul>";
        
        $mensagem_drhj->save();
        
        /* if(!$mensagem->save()) {
         return redirect()->route('landing-page')->with('error', 'A Sua mensagem nÃ£o foi enviada. Por favor, tente novamente');
         } */
        
        $destinatario                      = new MensagemDestinatario();
        $destinatario->tipo_destinatario   = 'DH';
        $destinatario->mensagem_id         = $mensagem_drhj->id;
        $destinatario->destinatario_id     = 1;
        $destinatario->save();
        
        $destinatario                      = new MensagemDestinatario();
        $destinatario->tipo_destinatario   = 'DH';
        $destinatario->mensagem_id         = $mensagem_drhj->id;
        $destinatario->destinatario_id     = 3;
        $destinatario->save();
        
        #dados da mensagem para o cliente
        $mensagem_cliente            		= new Mensagem();
        
        $mensagem_cliente->rma_nome     	= 'Contato DoctorHoje';
        $mensagem_cliente->rma_email       	= 'contato@doctorhoje.com.br';
        $mensagem_cliente->assunto     		= 'PrÃ©-Agendamento Solicitado';
        $mensagem_cliente->conteudo     	= "<h4>Sua solicitaÃ§Ã£o de <strong>cancelamento</strong> estÃ¡ em anÃ¡lise:</h4><br><ul><li>NÂº do Pedido: $nr_pedido</li><li>Especialidade/exame: $nome_especialidade</li><li>Dr(a): $nome_profissional</li><li>Data: $data_agendamento</li><li>HorÃ¡rio: $hora_agendamento (por ordem de chegada)</li><li>EndereÃ§o: $endereco_agendamento</li></ul>";
        $mensagem_cliente->save();
        
        $destinatario                      = new MensagemDestinatario();
        $destinatario->tipo_destinatario   = 'PC';
        $destinatario->mensagem_id         = $mensagem_cliente->id;
        $destinatario->destinatario_id     = $paciente->user->id;
        $destinatario->save();
        
        $from = 'contato@doctorhoje.com.br';
        $to = $email;
        $subject = 'Cancelamento Solicitado';
        
        $html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoctorHoje</title>
    </head>
    <body style='margin: 0;'>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'>&nbsp;</td>
                <td width='120' style='text-align:right'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoctorHoje - Cancelamento de agendamento</span></td>
                <td width='120' style='text-align:right'><a href='#' target='_blank' style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Abrir no navegador</a></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td><img src='https://doctorhoje.com.br/libs/home-template/img/email/h1.png' width='600' height='113' alt='DoctorHoje'/></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px;'><strong>Cancelamento de agendamento</strong></td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 28px; line-height: 50px; color: #434342; background-color: #fff; text-align: center;'>
                    OlÃ¡, <strong style='color: #1d70b7;'>$nm_primario</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
                    Sua solicitaÃ§Ã£o de <strong>cancelamento</strong> estÃ¡ em anÃ¡lise. Aguarde
                    contato telefÃ´nico do Doctor Hoje para confirmaÃ§Ã£o do
                    cancelamento. 
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/numero-pedido.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>NÂº do pedido: <span>$nr_pedido</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/especialidade.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>Especialidade/exame: <span>$nome_especialidade</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/especialidade.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>Dr(a): <span>$nome_profissional</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/data.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'><span>$data_agendamento</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/hora.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'><span>$hora_agendamento</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/local.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'><span>$endereco_agendamento</span>
                </td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/status.png' width='34' height='30' alt=''/></td>
                <td width='10'>&nbsp;</td>
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>Status: <span>$agendamento_status</span></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
                    AtenÃ§Ã£o as regras de cancelamento descritas abaixo. Conforme
                    Termo de Uso, <strong>Art.nÂº XX</strong>. 
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 50px; color: #434342; text-align: center;'>
                    <strong style='color: #ffffff;'>REGRAS DE CANCELAMENTO</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30'></td>
                <td width='180' style='background-color: #307ec1; font-family:Arial, Helvetica, sans-serif; font-size: 12px; line-height: 50px; color: #ffffff; text-align: center;'><strong style='color: #ffffff;'>SOLICITAÃ‡ÃƒO/PERÃ�ODO</strong></td>
                <td width='180' style='background-color: #307ec1; font-family:Arial, Helvetica, sans-serif; font-size: 12px; line-height: 50px; color: #ffffff; text-align: center;'><strong style='color: #ffffff;'>ATÃ‰ 24 HORAS</strong></td>
                <td width='180' style='background-color: #307ec1; font-family:Arial, Helvetica, sans-serif; font-size: 12px; line-height: 50px; color: #ffffff; text-align: center;'><strong style='color: #ffffff;'>INFERIOR A 24 HORAS</strong></td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30'></td>
                <td width='180' style='background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30'></td>
                <td width='180' style='background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>Cancelamento</td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>Reembolso de 50%<br>
                    do valor pago em atÃ©<br>
                    5 dias Ãºteis.
                </td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>Sem direito a<br>
                    reembolso.
                </td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30'></td>
                <td width='180' style='background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='179' style='border-left:1px solid #ddd; background-color: #f9f9f9; font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; text-align: center;'>&nbsp;</td>
                <td width='30'></td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
                    Sabemos que imprevisto acontecem, mas nÃ£o deixe de cuidar da
                    sua saÃºde! 
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: center;'>
                    AbraÃ§os,<br>
                    Equipe Doctor Hoje
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='209'></td>
                <td width='27'><a href='#'><img src='https://doctorhoje.com.br/libs/home-template/img/email/facebook.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='https://doctorhoje.com.br/libs/home-template/img/email/youtube.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='https://doctorhoje.com.br/libs/home-template/img/email/instagram.png' width='27' height='24' alt=''/></a></td>
                <td width='210'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='540' style='line-height:16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#434342; text-align: center;'>
                    Em caso de qualquer dÃºvida, fique Ã  vontade <br>
                    para responder esse e-mail ou
                    nos contatar no <br><br>
                    <a href='mailto:meajuda@doctorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>meajuda@doctorhoje.com.br</a>
                    <br><br>
                    Ou ligue para (61) 3221-5350, o atendimento Ã© de<br>
                    segunda Ã  sexta-feira
                    das 8h00 Ã s 18h00. <br><br>
                    <strong>Doctor Hoje</strong> 2018 
                </td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
    </body>
</html>
HEREDOC;
        
        $html_message = str_replace(array("\r", "\n"), '', $html_message);
        
        $send_message = UtilController::sendMail($to, $from, $subject, $html_message);
        
        //     	echo "<script>console.log( 'Debug Objects: " . $send_message . "' );</script>";
        //     	return redirect()->route('provisorio')->with('success', 'A Sua mensagem foi enviada com sucesso!');
        
        return $send_message;
    }
}