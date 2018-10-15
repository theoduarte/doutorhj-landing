<?php

namespace App\Http\Controllers;

use App\ItemCheckup;
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
use Illuminate\Support\Facades\Auth;
use App\Paciente;
use App\CartaoPaciente;
use App\Pedido;
use App\Mensagem;
use App\MensagemDestinatario;
use App\Filial;
use App\Checkup;
use App\TagPopular;
use App\VigenciaPaciente;
use App\Plano;
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
    public function informaBeneficiario()
    {
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
//         $atendimento_id      = $request->input('atendimento_id');
//         $profissional_id = $request->input('profissional_id');
//         $paciente_id     = $request->input('paciente_id');
//         $clinica_id          = $request->input('clinica_id');
//         $data_atendimento    = $request->input('data_atendimento');
//         $hora_atendimento    = $request->input('hora_atendimento');
//         $vl_com_atendimento = $request->input('vl_com_atendimento');
//         $url                = $request->input('current_url');
        $cartCollection = CVXCart::getContent();
        $itens = $cartCollection->toArray();
        // dd($itens);die;
        $carrinho = [];
        $user_session = Auth::user();
        $url = '';
        $tem_titular = false;
        $tem_pacientes = false;
        $item_titular = [];
        $proximo_item = [];

        foreach ($itens as $item) {
            $titular = false;
            if($item['attributes']['tipo_atendimento'] == 'simples') {
                $paciente_tmp_id = $item['attributes']['paciente_id'];

                $paciente = !empty($paciente_tmp_id) ? Paciente::find($paciente_tmp_id) : [];
                $url = $item['attributes']['current_url'];                

                if( !empty($paciente) && $user_session->paciente->id == $paciente->id ) {
                    $titular = true;
                    $tem_titular = true;
                }
                
                $tem_pacientes = true;

                $item_carrinho = array(
                    'item_id'               => $item['id'],
                    'titular'               => $titular,
                    'paciente'              => $paciente,
                    'current_url'           => $url
                );
                
                if ($titular) {
                    $item_titular = $item_carrinho;
                }

//                if( empty($paciente) ) {
                    $proximo_item = $item_carrinho;
//                }
            } elseif($item['attributes']['tipo_atendimento'] == 'checkup') {
                $paciente_tmp_id = '';
                $paciente = [];
                $url = $item['attributes']['current_url'];
                $titular = false;
                if(sizeof($paciente) > 0) {
                    if($user_session->paciente->id == $paciente->id) {
                        $titular = true;
                        $tem_titular = true;
                    }
                    
                    $tem_pacientes = true;
                }
                
                $item_carrinho = array(
                    'item_id'               => $item['id'],
                    'titular'               => $titular,
                    'paciente'              => $paciente,
                    'items_checkup'         => $item['attributes']['items_checkup'],
                    'current_url'           => $url
                );
                
                if ($titular) {
                    $item_titular = $item_carrinho;
                }

//                if( empty($paciente) ) {
                    $proximo_item = $item_carrinho;
//                }
            }
            
            array_push($carrinho, $item_carrinho);
        }

        //dd($proximo_item['clinica']);
        
        $valor_total = CVXCart::getTotal();
        $valor_total = number_format($valor_total, 2, ',', '.');
            
        // dd($user_session);

        $responsavel_id = $user_session->paciente->id;

      
            //$query_temp = DB::getQueryLog();
		$plano = Paciente::getPlanoAtivo($user_session->paciente->id);
        
        if($plano != Plano::OPEN) {

            $vigencia_valor = Paciente::getVlMaxConsumo($user_session->paciente->id);                
        }
                          
        $dependentes = Paciente::where('responsavel_id', $responsavel_id)->where('cs_status', '=', 'A')->get();
        
        $paciente_titular = $user_session->paciente;
        
        return view('agendamentos.informa-beneficiario', compact('url','plano','vigencia_valor', 'item_titular', 'tem_titular', 'tem_pacientes', 'carrinho', 'dependentes', 'paciente_titular', 'proximo_item', 'valor_total'));
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
    	
    	$tipo_atendimento	= $request->input('tipo_atendimento');

   	    // \Cart::clear();

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
    		$clinica_id			= $request->input('clinica_id');
    		$filial_id			= $request->input('filial_id');
    		$data_atendimento	= $request->input('data_atendimento');
    		$hora_atendimento	= $request->input('hora_atendimento');
    		$vl_com_atendimento = $request->input('vl_com_atendimento');
    		$url 				= $request->input('current_url');

			$paciente_id = $request->input('paciente_id') ?? Auth::user()->paciente->id ?? null;
			if(!is_null($paciente_id)) {
				$paciente = Paciente::findOrFail($paciente_id);
			} else {
				$paciente = new Paciente();
			}

			$plano_id = $paciente->getPlanoAtivo($paciente->id);

			$atendimento = Atendimento::where(['atendimentos.id' => $atendimento_id])
				->with('precoAtivo')->whereHas('precoAtivo', function($query) use ($plano_id) {
					$query->where('precos.plano_id', '=', $plano_id);
				})->first();
                
			$vl_com_atendimento = $atendimento->precoAtivo->vl_comercial;

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
					'tipo_atendimento' => 'simples',
					'current_url' => $url
				)
    		));
    	} elseif($tipo_atendimento == 'checkup') {
			$checkup_id			= $request->input('checkup_id');
			$vl_total_checkup 	= ItemCheckup::query()->where('checkup_id', $checkup_id)->sum('vl_com_checkup');
			$vl_total_checkup 	= number_format($vl_total_checkup, 2, '.', '');
			$url 				= $request->input('current_url');

			$checkup = Checkup::findorfail($checkup_id);
			$checkup->load('itemcheckups');
			$items_checkup = $checkup->itemcheckups;

			foreach ($items_checkup as $item) {
				$selecionaData = $request->input('selecionaData_'.$item->atendimento_id);
				$selecionaHora = $request->input('selecionaHora_'.$item->atendimento_id);

				$item_checkup[] = [
					'id' => $item->id,
					'data_agendamento' => isset($selecionaData) && $selecionaData != '' ? $selecionaData : '',
					'hora_agendamento' => isset($selecionaHora) && $selecionaHora != '' ? $selecionaHora : ''
				];

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
					'tipo_atendimento' => 'checkup',
					'checkup_id' => $checkup_id,
					'current_url' => $url,
					'items_checkup' => $item_checkup
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
        $paciente_id		= $request->input('paciente_id');
        $url                = $request->input('current_url');
        
		$cartCollection = CVXCart::getContent();
        $card = $cartCollection->toArray()[$item_id];
		$card['quantity'] = 0;
       
      //  CVXCart::clear();
		if($card['attributes']['paciente_id'] != $paciente_id) {
			$paciente = Paciente::findOrFail($paciente_id);
			$plano_id = $paciente->getPlanoAtivo($paciente->id);

			$atendimento = Atendimento::where(['atendimentos.id' => $card['attributes']['atendimento_id']])
				->with('precoAtivo')->whereHas('precoAtivo', function($query) use ($plano_id) {
					$query->where('precos.plano_id', '=', $plano_id);
				})->first();
			$vl_comercial = $atendimento->precoAtivo->vl_comercial;

			$source = array('.', ',');
			$replace = array('', '.');
			$vl_comercial = str_replace($source, $replace, $vl_comercial);

			$card['attributes']['paciente_id'] = $paciente_id;
			$card['price'] = $vl_comercial;
		}
      
		$card['attributes']['current_url'] = $url;
        
        CVXCart::update($item_id, $card);

		//self::atualizaValorTotalCarrinho();

        return redirect()->route('carrinho')->with('cart', 'O Item foi adicionado com sucesso');
    }

	protected function atualizaValorTotalCarrinho()
	{
		$cartCollection = CVXCart::getContent()->toArray();

		foreach($cartCollection as $item) {

		}

		dd($cartCollection,CVXCart::getTotal());

	}
    
    public function carrinhoDeCompras()
	{
		$user_session = Auth::user();
		$url = Request::root();
    	
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
    	$cartCollection = CVXCart::getContent();
    	$itens = $cartCollection->toArray();
        
    	$carrinho = [];

    	foreach ($itens as $item) {
			$paciente_tmp_id = $item['attributes']['paciente_id'];
			$paciente = $paciente_tmp_id != null && $paciente_tmp_id != '' ? Paciente::findOrFail($paciente_tmp_id) : [];

			if($item['attributes']['tipo_atendimento'] == 'simples') {
				$atendimento_tmp_id = $item['attributes']['atendimento_id'];
				$profissional_tmp_id = $item['attributes']['profissional_id'];
				$clinica_tmp_id = $item['attributes']['clinica_id'];
				$filial_tmp_id = $item['attributes']['filial_id'];

				$paciente = new Paciente();
				$plano_id = $paciente->getPlanoAtivo($paciente->id);
				$atendimento = Atendimento::where(['atendimentos.id' => $atendimento_tmp_id])
					->with('precoAtivo')->whereHas('precoAtivo', function($query) use ($plano_id) {
						$query->where('precos.plano_id', '=', $plano_id);
					})->first();

				$profissional = !empty($profissional_tmp_id) ? Profissional::findOrFail($profissional_tmp_id) : null;
				$clinica = Clinica::findOrFail($clinica_tmp_id);
				$filial = Filial::findOrFail($filial_tmp_id);

				$url = $item['attributes']['current_url'];

				if ($atendimento->procedimento_id != null) {
					$atendimento->load('procedimento');

					$nome_especialidade = $atendimento->procedimento->ds_procedimento;
					$ds_atendimento = $atendimento->procedimento->tag_populars->first()->cs_tag;

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
                
                    $resultado =  TagPopular::where('consulta_id',$atendimento->consulta_id )->first() ;
                    
                    !empty($resultado) ? $ds_atendimento= $resultado->cs_tag : $ds_atendimento= '';
                    					
					$atendimento->nome_especialidade = $nome_especialidade;
                    
                    $atendimento->ds_atendimento = $ds_atendimento;
				}

				if (isset($clinica)) {
					$clinica->load('enderecos');
				}

				if (isset($filial)) {
					$filial->load('endereco');
				}

				$data_atendimento = $item['attributes']['data_atendimento'];
				$hora_atendimento = $item['attributes']['hora_atendimento'];

				$item_carrinho = [
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
				];
			} elseif($item['attributes']['tipo_atendimento'] == 'checkup') {
				$checkup_tmp_id = $item['attributes']['checkup_id'];

				$carrinhoItensCheckup = $item['attributes']['items_checkup'];

				$checkup = Checkup::findOrFail($checkup_tmp_id);

				$item_checkups = ItemCheckup::query()->where('checkup_id', $checkup_tmp_id)
					->with(['atendimento.consulta', 'atendimento.procedimento', 'atendimento.clinica.enderecos'])
					->select('item_checkups.*')
					->join('atendimentos', 'atendimentos.id', '=', 'item_checkups.atendimento_id')
					->orderByRaw('coalesce(atendimentos.consulta_id, atendimentos.procedimento_id)')
					->get();

				foreach($item_checkups as $itemCheckup) {
					$key = array_search($itemCheckup->id, array_column($carrinhoItensCheckup, 'id'));
					if(!empty($carrinhoItensCheckup[$key]['data_agendamento']) && !empty($carrinhoItensCheckup[$key]['hora_agendamento'])) {
						$dataHoraAgendamento = $carrinhoItensCheckup[$key]['data_agendamento'] . ' ' . $carrinhoItensCheckup[$key]['hora_agendamento'];
						$itemCheckup->dataHoraAgendamento = \DateTime::createFromFormat('d.m.Y H:i', $dataHoraAgendamento)->format('d/m/Y H:i');
					}
				}
				
				$item_carrinho = [
					'item_id' 				=> $item['id'],
					'valor' 				=> $item['price'],
					'atendimento' 			=> null,
					'profissional' 			=> null,
					'clinica' 				=> null,
					'filial' 				=> null,
					'paciente'				=> $paciente,
					'data_agendamento' 		=> null,
					'hora_agendamento' 		=> null,
					'current_url' 			=> $url,
					'checkup'				=> $checkup,
					'itens_checkup'			=> $item_checkups,
				];
			}

             
            
    		if (!empty($paciente)) {
    			array_push($carrinho, $item_carrinho);
    		} else {
    			CVXCart::remove($item_carrinho['item_id']);
    		}
    	}
        
        
			$plano = Paciente::getPlanoAtivo($user_session->paciente->id);

            if($plano != Plano::OPEN) {
                $vigencia_valor =  Paciente::getVlMaxConsumo($user_session->paciente->id);               
            }

      
    	$valor_total = CVXCart::getTotal();
		$valor_total = number_format($valor_total, 2, ',', '.');

    	return view('agendamentos.carrinho', compact('url', 'carrinho', 'valor_total', 'plano', 'vigencia_valor'));
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
         $plano =Plano::OPEN;
        $agendamentos_home = [];
        
        if (Auth::check()) {
            $paciente_id = Auth::user()->paciente->id;
            
            
            $list_dependentes = Paciente::where('responsavel_id', $paciente_id)->orderBy('id', 'asc')->pluck('id');
            
            //DB::enableQueryLog();
            $agendamentos_home = Agendamento::with('itempedidos')->with('filial')->whereIn('paciente_id', $list_dependentes )->orWhere('paciente_id', $paciente_id)->orderBy( 'agendamentos.dt_atendimento', 'desc')->get();
            /* $agendamentos_home = Agendamento::with('paciente')->with('filial')
            	->join('pacientes', function($join) use ($paciente_id) {$join->on('pacientes.responsavel_id', '=', DB::raw($paciente_id))->orOn('agendamentos.paciente_id', '=', DB::raw($paciente_id));})
            	->select('agendamentos.id', 'agendamentos.te_ticket', 'agendamentos.dt_atendimento', 'agendamentos.cs_status', 'agendamentos.bo_remarcacao', 'agendamentos.created_at', 'agendamentos.clinica_id', 'agendamentos.paciente_id', 'agendamentos.atendimento_id', 'agendamentos.profissional_id', 'agendamentos.filial_id', 'agendamentos.bo_retorno', 'agendamentos.cupom_id', 'agendamentos.checkup_id')
            	->distinct()
            	->orderBy( 'agendamentos.dt_atendimento', 'desc')
            	->get(); */
            //dd($agendamentos_home);
            //$query_log = DB::getQueryLog();
            //print_r($query_log);

            
         //$query_temp = DB::getQueryLog();
			$plano = Paciente::getPlanoAtivo( $paciente_id);

            if($plano != 1) {

                $vigencia_valor =   Paciente::getVlMaxConsumo($paciente_id);                

            }

            
        }
        
        return view('agendamentos.meus-agendamentos', compact('agendamentos_home','plano','vigencia_valor'));
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
    		return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estÃ£o disponíveis. Por favor, tente novamente.']);
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
    	 
    	//$agendamento->cs_status = 60;
    	//$agendamento->dt_atendimento    = date('Y-m-d H:i:s');
    
    	if (!$agendamento->save()) {
    		return response()->json(['status' => false, 'mensagem' => 'O Agendamento não foi Cancelado. Por favor, tente novamente.']);
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
    
    	return response()->json(['status' => true, 'mensagem' => 'A Solicitação de Cancelamento foi realizada com sucesso!', 'agendamento' => $agendamento->toJson()]);
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
        
        
        
            //$query_temp = DB::getQueryLog();
			$plano = Paciente::getPlanoAtivo($user_paciente->paciente->id);

            if($plano !=Plano::OPEN) {
               $vigencia_valor = Paciente::getVlMaxConsumo($user_paciente->paciente->id);
                
            }

            
        

        foreach ($agendamentos as $agendamento) {
        	$agendamento->itempedidos->first()->pedido->load('cartao_paciente');
        	$agendamento->valor_total = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? number_format( ($agendamento->itempedidos->first()->pedido->pagamentos->first()->amount)/100,  2, ',', '.') : number_format( 0,  2, ',', '.');
        	$agendamento->data_pagamento = sizeof($agendamento->itempedidos->first()->pedido->pagamentos) > 0 ? date('d/m/Y', strtotime($agendamento->itempedidos->first()->pedido->pagamentos->first()->created_at)) : '----------';
        }
        
        return view('agendamentos.minha-conta', compact('user_paciente', 'dt_nascimento', 'dependentes', 'cartoes_paciente', 'agendamentos', 'plano', 'vigencia_valor'));
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
 
        $agendamentos = Agendamento::where('clinica_id', '=', $clinica_id)->where('profissional_id', $profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($data.' '.$hora)))->get();

        
        $agendamento_disponivel = sizeof($agendamentos) <= 0 ? true : false;
        
        if (!$agendamento_disponivel) {
            return response()->json(['status' => false, 'mensagem' => 'O horário escolhido não estão disponível, pois já existe um atendimento marcado. Por favor, tente outro horário.']);
        }
        
        return response()->json(['status' => true, 'mensagem' => 'Agendamento disponível!']);
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
        
        $mensagem_cliente->rma_nome     	= 'Contato DoutorHoje';
        $mensagem_cliente->rma_email       	= 'contato@doutorhoje.com.br';
        $mensagem_cliente->assunto     		= 'PrÃ©-Agendamento Solicitado';
        $mensagem_cliente->conteudo     	= "<h4>Sua solicitação de <strong>cancelamento</strong> estÃ¡ em anÃ¡lise:</h4><br><ul><li>Nº do Pedido: $nr_pedido</li><li>Especialidade/exame: $nome_especialidade</li><li>Dr(a): $nome_profissional</li><li>Data: $data_agendamento</li><li>HorÃ¡rio: $hora_agendamento (por ordem de chegada)</li><li>EndereÃ§o: $endereco_agendamento</li></ul>";
        $mensagem_cliente->save();
        
        $destinatario                      = new MensagemDestinatario();
        $destinatario->tipo_destinatario   = 'PC';
        $destinatario->mensagem_id         = $mensagem_cliente->id;
        $destinatario->destinatario_id     = $paciente->user->id;
        $destinatario->save();
        
        $from = 'contato@doutorhoje.com.br';
        $to = $email;
        $subject = 'Cancelamento Solicitado';
        
        $html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoutorHoje</title>
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
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoutorHoje - Cancelamento de agendamento</span></td>
                <td width='120' style='text-align:right'><a href='#' target='_blank' style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Abrir no navegador</a></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td><img src='https://doutorhoje.com.br/libs/home-template/img/email/h1.png' width='600' height='113' alt='DoutorHoje'/></td>
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
                    Sua solicitação de <strong>cancelamento</strong> estÃ¡ em anÃ¡lise. Aguarde
                    contato telefÃ´nico do Doutor Hoje para confirmação do
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/numero-pedido.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/especialidade.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/especialidade.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/data.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/hora.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/local.png' width='34' height='30' alt=''/></td>
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
                <td width='34'><img src='https://doutorhoje.com.br/libs/home-template/img/email/status.png' width='34' height='30' alt=''/></td>
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
                    Atenção as regras de cancelamento descritas abaixo. Conforme
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
                    Sabemos que imprevisto acontecem, mas não deixe de cuidar da
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
                    Equipe Doutor Hoje
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
                <td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/facebook.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/youtube.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/instagram.png' width='27' height='24' alt=''/></a></td>
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
                    <a href='mailto:cliente@doutorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>cliente@doutorhoje.com.br</a>
                    <br><br>
                    Ou ligue para (61) 3221-5350, o atendimento Ã© de<br>
                    segunda Ã  sexta-feira
                    das 8h00 Ã s 18h00. <br><br>
                    <strong>Doutor Hoje</strong> 2018 
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
        
        return $send_message;
    }
}