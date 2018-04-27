<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Agendamento;
use App\Clinica;
use App\Profissional;
use App\Estado;
use App\Atendimento;
use App\Http\Requests\AgendamentoRequest;
use App\Itempedido;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agenda = Agendamento::where(function($query){}
        
                                       )->orderBy('dt_atendimento')
                                        ->sortable()->paginate(20);
        
        $agenda->load(['Clinica'=>function($query){
//             $idClinica = (int)Request::input('clinica_id');
//             if(!empty($idClinica)) { $query->findorfail( 10 ); }
        }]);
            
        $agenda->load(['Paciente'=>function($query){
//             $paciente = Request::input('nm_paciente');
            
//             if(!empty($paciente)){
//                 $query->where(DB::raw('to_str(CONCAT(nm_primario, nm_secundario)) as nome'),
//                     'like', '%'.UtilController::toStr($paciente).'%');
//             }
        }]);
        
        $agenda->load('Profissional');
        
        Request::flash();
        
        return view('agenda.index', compact('agenda'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idAgenda)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idAgenda)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idAgenda)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAgenda)
    {
        
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
    	
    	$cartCollection = \Cart::getContent();
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
    	
    	\Cart::add(array(
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
    	
    	return redirect()->route('carrinho')->with('cart', 'O Item foi adicionado com sucesso');
    	
    	//return view('carrinho', compact('url', 'carrinho', 'valor_total'))->with('cart', 'O Item foi adicionado com sucesso');
    }
    
    public function carrinhoDeCompras(){
    	
    	//\Cart::clear();
    	
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$cartCollection = \Cart::getContent();
    	$itens = $cartCollection->toArray();
    	 
    	$carrinho = [];
    	$user_session = Auth::user();
    	$url = Request::root();
    	 
    	foreach ($itens as $item) {
    		$atendimento_tmp_id = $item['attributes']['atendimento_id'];
    		$profissional_tmp_id = $item['attributes']['profissional_id'];
    		$clinica_tmp_id = $item['attributes']['clinica_id'];
    	
    		$atendimento = Atendimento::findOrFail($atendimento_tmp_id);
    		$profissional = Profissional::findOrFail($profissional_tmp_id);
    		$clinica = Clinica::findOrFail($clinica_tmp_id);
    		$url = $item['attributes']['current_url'];
    	
    		if ($atendimento->procedimento_id != null) {
    			$atendimento->load('procedimento');
    			$atendimento->procedimento->load('especialidade');
    			$atendimento->nome_especialidade = $atendimento->procedimento->especialidade->ds_especialidade;
    			// {{ isset($item['atendimento']->procedimento_id) ? $item['atendimento']->procedimento->especialidade->ds_especialidade : isset($item['atendimento']->consulta_id) && isset($item['atendimento']->consulta->especialidade) ? $item['atendimento']->consulta->especialidade->ds_especialidade : '--------' }}
    		}
    	
    		if ($atendimento->consulta_id != null) {
    			$atendimento->load('consulta');
    			$atendimento->consulta->load('especialidade');
    			$atendimento->nome_especialidade = $atendimento->consulta->especialidade->ds_especialidade;
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
    				'paciente'				=> $user_session,
    				'data_agendamento' 		=> $item['attributes']['data_atendimento'],
    				'hora_agendamento' 		=> $item['attributes']['hora_atendimento'],
    				'current_url' 			=> $url
    		);
    	
    		array_push($carrinho, $item_carrinho);
    	}
    	 
    	$valor_total = \Cart::getTotal();
    	
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
}