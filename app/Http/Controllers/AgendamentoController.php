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
            $paciente_tmp_id = $item['attributes']['paciente_id'];
            
            $atendimento = Atendimento::findOrFail($atendimento_tmp_id);
            $profissional = Profissional::findOrFail($profissional_tmp_id);
            $clinica = Clinica::findOrFail($clinica_tmp_id);
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
                $atendimento->load('profissional');
                $atendimento->profissional->load('especialidades');
                
                $nome_especialidade = "";
                
                foreach ($atendimento->profissional->especialidades as $especialidade) {
                    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
                }
                
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
            
            $item_carrinho = array(
                'item_id' 				=> $item['id'],
                'valor' 				=> $item['price'],
                'atendimento' 			=> $atendimento,
                'profissional' 			=> $profissional,
                'clinica' 				=> $clinica,
                'titular'               => $titular,
                'paciente'				=> $paciente,
                'data_agendamento' 		=> $item['attributes']['data_atendimento'],
                'hora_agendamento' 		=> $item['attributes']['hora_atendimento'],
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
     * Realiza o agendamento de um usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agendarAtendimento(AgendamentoRequest $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
        $atendimento_id		= $request->input('atendimento_id');
    	$profissional_id	= $request->input('profissional_id');
    	$paciente_id		= $request->input('paciente_id');
    	$clinica_id			= $request->input('clinica_id');
    	$data_atendimento	= $request->input('data_atendimento');
    	$hora_atendimento	= $request->input('hora_atendimento');
    	$vl_com_atendimento = $request->input('vl_com_atendimento');
    	$url = $request->input('current_url');
    	
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
        	        'data_atendimento' => $data_atendimento,
        	        'hora_atendimento' => $hora_atendimento,
    				'current_url' => $url
    		)
    	));
    	
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
        $data_atendimento	= $request->input('data_atendimento');
        $hora_atendimento	= $request->input('hora_atendimento');
        $vl_com_atendimento = $request->input('vl_com_atendimento');
        $url                = $request->input('current_url');
        
        CVXCart::update($item_id, array(
            'attributes' => array(
                'atendimento_id' => $atendimento_id,
                'profissional_id' => $profissional_id,
                'paciente_id' => $paciente_id,
                'clinica_id' => $clinica_id,
                'data_atendimento' => $data_atendimento,
                'hora_atendimento' => $hora_atendimento,
                'current_url' => $url
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
    		$paciente_tmp_id = $item['attributes']['paciente_id'];
    	
    		$atendimento = Atendimento::findOrFail($atendimento_tmp_id);
    		$profissional = Profissional::findOrFail($profissional_tmp_id);
    		$clinica = Clinica::findOrFail($clinica_tmp_id);
    		
    		$paciente = $paciente_tmp_id != '' ? Paciente::findOrFail($paciente_tmp_id) : [];
    		
    		$url = $item['attributes']['current_url'];
    	
    		if ($atendimento->procedimento_id != null) {
    			$atendimento->load('procedimento');
    			$atendimento->load('profissional');
    			$atendimento->profissional->load('especialidades');
    			
    			$nome_especialidade = "";
    			
    			foreach ($atendimento->profissional->especialidades as $especialidade) {
    			    $nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    			}
    			
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
    	
    		$item_carrinho = array(
    				'item_id' 				=> $item['id'],
    				'valor' 				=> $item['price'],
    				'atendimento' 			=> $atendimento,
    				'profissional' 			=> $profissional,
    				'clinica' 				=> $clinica,
    		        'paciente'				=> $paciente,
    				'data_agendamento' 		=> $item['attributes']['data_atendimento'],
    				'hora_agendamento' 		=> $item['attributes']['hora_atendimento'],
    				'current_url' 			=> $url
    		);
    	
    		array_push($carrinho, $item_carrinho);
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
            
            $agendamentos_home = Agendamento::with('paciente')->with('clinica')->with('atendimento')->with('profissional')->with('itempedidos')
	            ->join('pacientes', function($join1) use ($paciente_id) { $join1->on('pacientes.responsavel_id', '=', DB::raw($paciente_id))->on('pacientes.id', '=', 'agendamentos.paciente_id')->orOn('pacientes.id', '=', DB::raw($paciente_id));})
	            ->select('agendamentos.*')
	            ->whereNotNull('agendamentos.atendimento_id')
	            ->distinct()
	            ->orderBy('dt_atendimento', 'desc')->get();
            
            for ($i = 0; $i < sizeof($agendamentos_home); $i++) {
                $agendamentos_home[$i]->clinica->load('enderecos');
                $agendamentos_home[$i]->clinica->enderecos->first()->load('cidade');
                $agendamentos_home[$i]->endereco_completo = $agendamentos_home[$i]->clinica->enderecos->first()->te_endereco.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->te_bairro.' - '.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->nm_cidade.'/'.$agendamentos_home[$i]->clinica->enderecos->first()->cidade->estado->sg_estado;
                $agendamentos_home[$i]->itempedidos->first()->load('pedido');
                $agendamentos_home[$i]->itempedidos->first()->pedido->load('pagamentos');
                $agendamentos_home[$i]->valor_total = sizeof($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos) > 0 ? number_format( ($agendamentos_home[$i]->itempedidos->first()->pedido->pagamentos->first()->amount)/100,  2, ',', '.') : number_format( 0,  2, ',', '.');
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
    	
    	
    	$agendamentos = Agendamento::where('clinica_id', '=', $clinica_id)->where('profissional_id', $profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($data.' '.$hora)))->get();
    	
    	$agendamento_disponivel = sizeof($agendamentos) <= 0 ? true : false;
    	
    	if (!$agendamento_disponivel) {
    		return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.']);
    	}
    	
    	$agendamento = Agendamento::findorfail($agendamento_id);
    	
    	if (!isset($agendamento)) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento não foi encontrado. Por favor, tente novamente.']);
    	}
    	
    	$agendamento->cs_status = 10;
    	$agendamento->dt_atendimento    = $data.' '.$hora;
    
    	if (!$agendamento->save()) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento não foi remarcado. Por favor, tente novamente.']);
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
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento não foi encontrado. Por favor, tente novamente.']);
    	}
    	 
    	$agendamento->cs_status = 60;
    	$agendamento->dt_atendimento    = date('Y-m-d H:i:s');
    
    	if (!$agendamento->save()) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento não foi Cancelado. Por favor, tente novamente.']);
    	}
    	 
    	$agendamento->dia_agendamento 	= '--';
    	$agendamento->mes_agendamento 	= '---';
    	$agendamento->hora_agendamento 	= '----';
    
    	return response()->json(['status' => true, 'mensagem' => 'O Agendamento foi Cancelado com sucesso!', 'agendamento' => $agendamento->toJson()]);
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
        }
        
        return view('agendamentos.minha-conta', compact('user_paciente', 'dt_nascimento', 'dependentes', 'cartoes_paciente', 'agendamentos'));
    }
}