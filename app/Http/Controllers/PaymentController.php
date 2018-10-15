<?php

namespace App\Http\Controllers;

use App\Checkup;
use App\Datahoracheckup;
use App\Especialidade;
use App\ItemCheckup;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use App\Pedido;
use App\Agendamento;
use App\Paciente;
use App\Itempedido;
use Illuminate\Support\Facades\DB;
use App\CreditCardResponse;
use App\DebitCardResponse;
use App\CartaoPaciente;
use App\CupomDesconto;
use App\Atendimento;
use App\Mensagem;
use App\MensagemDestinatario;
use App\Contato;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use MundiAPILib\MundiAPIClient;
use App\FuncoesPagamento;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//
		

		//$input = Input::only('paciente_id');  
		$input =CVXRequest::post('paciente_id');
		echo $input;
		//var_dump(request('valor_servicos'));
		die;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
    
    /**
     * notificacao a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notificacao(Request $request)
    {
    	$RecurrentPaymentId 	= CVXRequest::post('RecurrentPaymentId');
    	$PaymentId 				= CVXRequest::post('PaymentId');
    	$ChangeType 			= CVXRequest::post('ChangeType');
    	
    	$result = [
    			'message' => 'HTTP Status Code 200 OK',
    			'RecurrentPaymentId' => $RecurrentPaymentId,
    			'PaymentId' => $PaymentId,
    			'ChangeType' => $ChangeType
    	];
    	
    	return response()->json('HTTP Status Code 200 OK', 200);
    }
	
	

	
    public function fullTransactionTeste(Request $request)
    {
	
		
		
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	 
    	$result_agendamentos = Agendamento::with('atendimento')->with('clinica')->with('profissional')->with('itempedidos')->with('paciente')->where('agendamentos.id', '>', 5)->get();
    	
    	$contato1 = Contato::where(DB::raw("regexp_replace(ds_contato , '[^0-9]*', '', 'g')"), '=', '(61) 93545-8712')->get();
    	$contato = $contato1->first();
	
    	DB::beginTransaction();
    	
    	$paciente_teste = new Paciente();
    	$paciente_teste->nm_primario = 'teste2';
    	$paciente_teste->nm_secundario = 'sobrenome';
    	$paciente_teste->cs_sexo = 'A';
    	$paciente_teste->dt_nascimento = date('Y-m-d');
		$paciente_teste->access_token = 'token';
		
		
    	$result = $paciente_teste->save();
	
    	try {
    		$contato_id = $contato->id;
    		
    	} catch (\Exception $e) {
    		DB::rollback();
    		dd("------------------------------exception-------------------------".$e);
    	}
    	DB::commit();
    	dd($result);
    	
    	if ($result_agendamentos == null) {
    		return redirect()->route('landing-page');
    	}
    	//dd($result_agendamentos);
    	$pedido = [];
    
    	$valor_total_pedido = 0;
    
    	foreach ($result_agendamentos as $agendamento) {
    		if (isset($agendamento->itempedidos) && sizeof($agendamento->itempedidos) > 0) {
    
    			$agendamento->itempedidos->first()->load('pedido');
    			// dd($result_agendamentos);
    			$pedido = $agendamento->itempedidos->first()->pedido;
    			$valor_total_pedido = $valor_total_pedido+$agendamento->itempedidos->first()->valor;
    		}
    	}
    
    	$request->session()->forget('result_agendamentos');
    	$request->session()->forget('pedido');
    	$request->session()->forget('valor_total_pedido');
    
    	return view('payments.finalizar_pedido', compact('result_agendamentos', 'pedido', 'valor_total_pedido'));
    }
    
    public function fullTransactionFinish(Request $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
		

        $result_agendamentos =   $request->session()->get('result_agendamentos'); //json_decode(, true);
	

        if ($result_agendamentos == null) {
     //       return redirect()->route('landing-page');
        }

        $pedido = $request->session()->get('pedido');
        
		$valor_total_pedido = $request->session()->get('valor_total_pedido');
				
		$boleto_bancario = $request->session()->get('descricao_boleto');
		
		$transferencia_bancaria = $request->session()->get('trans_bancario');
        
      //  $request->session()->forget('result_agendamentos');
      //  $request->session()->forget('pedido');
      //  $request->session()->forget('valor_total_pedido');
        
        return view('payments.finalizar_pedido', compact('result_agendamentos', 'pedido', 'valor_total_pedido', 'boleto_bancario','transferencia_bancaria'));
    }
    
    /**
     * realiza o pagamento na Cielo por cartao de credito no padrao completo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


	 /**
	 * Pagamentos
	 * 1 para crédito empresarial
	 * 2 para credito empresarial mais cartao de crédito
	 * 3 para cartao de crédito
	 * 4 para boleto bancario
	 * 5 para transferencia bancaria
	 * 
	 */
	
	 public function fullTransaction(Request $request)
    {


		$basicAuthUserName = env('MUNDIPAGG_KEY');
		$basicAuthPassword = "";
		
		$client = new MundiAPIClient($basicAuthUserName, $basicAuthPassword);

		
		//echo json_encode(CVXRequest::All());

		// metodo de pagamento
		$metodoPagamento  = CVXRequest::post('metodo');
		$dados  = (object) CVXRequest::post('dados');
		$cod_cupom_desconto = CVXRequest::post('cod_cupom_desconto');
		$percentual_desconto = 0; // '0' indica que o cliente vai pagar 100% do valor total dos produtos-----		  
		if($cod_cupom_desconto != '') {
            $percentual_desconto = $this->validarCupomDesconto($cod_cupom_desconto);
        }

        
             
		$carrinho = CVXCart::getContent()->toArray();

		
		//print_r($carrinho); die;
		// echo '<pre>';
		// print_r($carrinho);
		// var_dump(CVXRequest::all());die;

        //--verifica se as condicoes de agendamento estao disponiveis------
        $agendamento_disponivel = true;
        $agendamentos = (array) CVXRequest::post('agendamentos');
		//$agendamentos = (($agenda[0]));
		$listCarrinho = $this->listCarrinhoItens();
		
		$paciente_id = CVXRequest::post('paciente_id');
		
		$titulo_pedido = CVXRequest::post('titulo_pedido');
		$num_parcela_selecionado = CVXRequest::post('num_parcela_selecionado');
		$paciente =(object) Paciente::select("*")->where('id', $paciente_id)->first();
		
	
		
        //--verifica se todos os agendamentos possuem um atendimento relacionado------
        $agendamento_atendimento = true;

		

        //--verifica se profissional existe, indicando que se trata de um exame/procedimento que não precisa de profissional e nem data/hora--
        //--ou verifica que se trata de uma consulta ou atendimento em uma clinica que sempre necessita de data/hora--
        for ($i = 0; $i < count($agendamentos); $i++) {
			$item_agendamento = json_decode($agendamentos[$i]);
			
			
			
			if(!empty($item_agendamento->atendimento_id)) {
				$atendimento_id_temp = $item_agendamento->atendimento_id;
				$item_atendimento = Atendimento::findorfail($atendimento_id_temp);
				$item_atendimento->load('clinica');
				$item_agendamento->dt_atendimento = \DateTime::createFromFormat('Y-m-d H:i', $item_agendamento->dt_atendimento);

				if ($item_agendamento->profissional_id && $item_agendamento->profissional_id != 'null') {
					$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', $item_agendamento->dt_atendimento->format('Y-m-d H:i:s'))->get();

					if (sizeof($agendamento) > 0) {
						$agendamento_disponivel = false;
					}

				} elseif ($item_atendimento->consulta_id != null | $item_atendimento->clinica->tp_prestador == 'CLI') {
					$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('dt_atendimento', '=', $item_agendamento->dt_atendimento->format('Y-m-d H:i:s'))->get();

					if (sizeof($agendamento) > 0) {
						$agendamento_disponivel = false;
					}
				}

				if ($item_atendimento == null) {
					$agendamento_atendimento = false;
				}

				$item_agendamento->dt_atendimento = !empty($item_agendamento->dt_atendimento) ? $item_agendamento->dt_atendimento->format('d/m/Y H:i') : null;
				$agendamentoItens[] = $item_agendamento;
			} elseif(!empty($item_agendamento->checkup_id)) {
				$idCarrinho = $listCarrinho['checkups'][$item_agendamento->checkup_id];
				$item_agendamento->itens = $carrinho[$idCarrinho]['attributes']['items_checkup'];

				if(!Checkup::where(['id' => $item_agendamento->checkup_id])->exists()) {
					return response()->json([
						'mensagem' => 'O seu Agendamento não foi realizado, pois um dos checkups informados não existe. Por favor, tente novamente.'
					], 403);
				}

				if(count($item_agendamento->itens) != ItemCheckup::where(['checkup_id' => $item_agendamento->checkup_id])->get()->count()) {
					return response()->json([
						'mensagem' => 'Quantidade de itens fornecidos no checkup invalida. Por favor, tente novamente.'
					], 400);
				}

				foreach ($item_agendamento->itens as $key=>$item) {
					if(!empty($item['data_agendamento']) || !empty($item['hora_agendamento'])) {
						$dataHoraAgendamento = $item['data_agendamento'] . ' ' . $item['hora_agendamento'];
						$item['dt_atendimento'] = \DateTime::createFromFormat('d.m.Y H:i', $dataHoraAgendamento)->format('d/m/Y H:i');

						$atendimento = Atendimento::join('item_checkups', 'item_checkups.atendimento_id', '=', 'atendimentos.id')
							->where(['item_checkups.id' => $item['id'], 'item_checkups.checkup_id' => $item_agendamento->checkup_id])
							->first();

						if(!Agendamento::validaHorarioDisponivel($atendimento->clinica_id, $atendimento->profissional_id, $item['dt_atendimento'])) {
							return response()->json([
								'checkup_id' => $item_agendamento->checkup_id,
								'profissional_id' => $item->profissional_id,
								'clinica_id' => $item->clinica_id,
								'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.'
							], 403);
						}

						$item_agendamento->itens[$key]['dt_atendimento'] = $item['dt_atendimento'];
					} else {
						$item_agendamento->itens[$key]['dt_atendimento'] = null;
					}
				}

				$checkups_id[] = $item_agendamento->checkup_id;
				$agendamentoItens[] = $item_agendamento;
			}
        }

        if (!$agendamento_disponivel) {
        	return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.']);
        }
         
        if (!$agendamento_atendimento) {
        	return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos itens não possui um Atendimento Relacionado. Por favor, tente novamente.']);
        }
		

		
	

        ########### STARTING TRANSACTION ############
     //   DB::beginTransaction();
        #############################################
        
        
		$valor_total = CVXCart::getTotal();
				
		
        $valor_desconto = $valor_total*$percentual_desconto;
        
        //-- determina o numero de parcelas -------
        $valor_parcelamento = $valor_total-$valor_desconto;
        
        
        $parcelamentos = array(
            1 => '1x R$ '.number_format( $valor_parcelamento,  2, ',', '.')
		);
		
		//valida a bandeira do cartao
			if(!empty($dados->numero)  && empty($pagamento[0]->cartao->cartao_id)){
				if(empty($dados->cvv)){
					return response()->json([
						'mensagem' => 'CVV obrigatorio quando enviado apenas o cartao_id.'
					], 422);
				}

				$bandeira = UtilController::validaCartao($dados->numero, $dados->cvv);
								
				if(!$bandeira[1]) {
					return response()->json([
						'message' => 'Número do cartão inválido!',
					], 400);
				} elseif(!$bandeira[2]) {
					return response()->json([
						'message' => 'Número do código de segurança inválido!',
					], 400);
				} else { 
					$bandeira = $bandeira[0];
				}			
			}

			$pedido = new Pedido();
        
			$descricao = '';
			$dt_pagamento = date('Y-m-d H:i:s');                        
			$pedido->titulo         = $titulo_pedido;
			$pedido->descricao      = $descricao;
			$pedido->dt_pagamento   = $dt_pagamento;
			$pedido->tp_pagamento   = $metodoPagamento ==1? 'empresarial' : $metodoPagamento==2 ? 'empre+credito' : $metodoPagamento==3 ? 'credito' : $metodoPagamento==4? 'boleto' : $metodoPagamento==5 ?'transferencia':'';
			$pedido->paciente_id    = $paciente_id;
			
			


			// credito empresarial
			if($metodoPagamento == 1){

			}else 
			// credito empresarial + cartao de credito
			if($metodoPagamento ==2){

				// validar se o cartao do funcionario existe limite
				// obtem o valor de limite restande do usuario
				$limiteCartaoFuncionario =200;
				if($limiteCartaoFuncionario ==0){
					return response()->json([
						'mensagem' => 'Não existe limite no cartao empresarial.'
					], 422);
				}else{
					$valorLimiteRestante = 2.00;
				}

				if(!empty($dados->cartaoid)) {
					$cartao = CartaoPaciente::where(['id'=>$dados->cartaoid , 'paciente_id' =>$paciente_id]);
					if(!$cartao->exists()) {
						DB::rollback();
						return response()->json([
							'mensagem' => 'ID do Cartão do Paciente não encontrado. Por favor, tente novamente.'
						], 404);
					}
					if(empty($dados->cvv)){
						return response()->json([
							'mensagem' => 'CVV obrigatorio quando enviado apenas o cartao_id.'
						], 422);
					}

					// card_id quando o cartao está salvo no sistema
					$cartao =$cartao->first()->card_token;
					$metodoCartao=1;

				} else {

					if( $dados->salvar == 0){
	
						try{									
							// cria token cartao						
							$cartaoToken = $client->getTokens()->createToken(env('MUNDIPAGG_KEY_PUBLIC'), FuncoesPagamento::criarTokenCartao($dados->numero, $dados->nome,$dados->mes, $dados->ano, $dados->cvv));
							// token gerado a partir da mundipagg sem salvar o cartao do usuario.
							$metodoCartao=2;
							$cartao = $cartaoToken->id;
						}catch(\Exception $e){
							DB::rollBack();
							return response()->json([
								'message' => 'Não foi possivel efetuar o pagamento com o cartao de crédito!',
								'errors' => $e->getMessage(),
							], 500);
						}

					}else{
						$cartaoPaciente = CartaoPaciente::where([
							'numero' => substr($dados->numero, -4),
							'dt_validade' => $dados->mes.'/'.$dados->ano,
							'bandeira' => $bandeira
						])->exists();
						
						if(!$cartaoPaciente) { 																				
							
							try {
								$saveCartao = $client->getCustomers()->createCard($paciente->mundipagg_token, FuncoesPagamento::criarCartao(
									$dados->numero, 
									$dados->nome, 				
									$dados->mes, 
									$dados->ano,
									$dados->cvv, 
									$bandeira
									)); 
									
								$cartao_paciente = new CartaoPaciente();
								$cartao_paciente->bandeira 		= $bandeira;
								$cartao_paciente->nome_impresso = $dados->nome;
								$cartao_paciente->numero 		= substr($dados->numero, -4);
								$cartao_paciente->dt_validade 	= $dados->mes . '/' . $dados->ano;
								$cartao_paciente->card_token 	= $saveCartao->id;
								$cartao_paciente->paciente_id 	= $paciente->id;

								if($cartao_paciente->save()) {
									
									// card_id cartao salvo
									$metodoCartao=1;
									$cartao = $saveCartao->id;
									
								}
							} catch(\Exception $e) {
								DB::rollBack();
								return response()->json([
									'message' => 'Erro ao salvar o cartao!',
									'errors' => $e->getMessage(),
								], 500);
							}
						}else{
							DB::rollback();
							return response()->json([
								'mensagem' => 'Não é possivel cadastrar um cartão que já está salvo.'
							], 404);	
						}	
					}
				}
				
				//$dados['cvv']
				//$dados['parcelas']
				//$dados['porcentagem']
				

			}else 
			// faz validação para efetuar compra com o  cartao de credito
			if($metodoPagamento ==3){
				if(!empty($dados->cartaoid)){
					$cartao = CartaoPaciente::where(['id'=>$dados->cartaoid , 'paciente_id' =>$paciente_id]);
						if(!$cartao->exists()) {
							DB::rollback();
							return response()->json([
								'mensagem' => 'ID do Cartão do Paciente não encontrado. Por favor, tente novamente.'
							], 404);
						}
						if(empty($dados->cvv)){
							return response()->json([
								'mensagem' => 'CVV obrigatorio quando enviado apenas o cartao_id.'
							], 422);
						}

						// card_id quando o cartao está salvo no sistema
						$cartao =$cartao->first()->card_token;
						$metodoCartao=1;
				}else{
					if($dados->salvar ==0){
						
						try{									
							// cria token cartao						
							$cartaoToken = $client->getTokens()->createToken(env('MUNDIPAGG_KEY_PUBLIC'), FuncoesPagamento::criarTokenCartao($dados->numero, $dados->nome,$dados->mes, $dados->ano, $dados->cvv));
							// token gerado a partir da mundipagg sem salvar o cartao do usuario.
							$metodoCartao=2;
							$cartao = $cartaoToken->id;
						}catch(\Exception $e){
							DB::rollBack();
							return response()->json([
								'message' => 'Não foi possivel efetuar o pagamento com o cartao de crédito!',
								'errors' => $e->getMessage(),
							], 500);
						}

					}else {
								$cartaoPaciente = CartaoPaciente::where([
										'numero' => substr($dados->numero, -4),
										'dt_validade' => $dados->mes.'/'.$dados->ano,
										'bandeira' => $bandeira
									])->exists();
									
									if(!$cartaoPaciente) { 																				
										
										try {
											$saveCartao = $client->getCustomers()->createCard($paciente->mundipagg_token, FuncoesPagamento::criarCartao(
												$dados->numero, 
												$dados->nome, 				
												$dados->mes, 
												$dados->ano,
												$dados->cvv, 
												$bandeira
												)); 
												
											$cartao_paciente = new CartaoPaciente();
											$cartao_paciente->bandeira 		= $bandeira;
											$cartao_paciente->nome_impresso = $dados->nome;
											$cartao_paciente->numero 		= substr($dados->numero, -4);
											$cartao_paciente->dt_validade 	= $dados->mes . '/' . $dados->ano;
											$cartao_paciente->card_token 	= $saveCartao->id;
											$cartao_paciente->paciente_id 	= $paciente->id;

											if($cartao_paciente->save()) {
												
												// card_id cartao salvo
												$metodoCartao=1;
												$cartao = $saveCartao->id;
												
											}
										} catch(\Exception $e) {
											DB::rollBack();
											return response()->json([
												'message' => 'Erro ao salvar o cartao!',
												'errors' => $e->getMessage(),
											], 500);
										}
									}else{
										DB::rollback();
										return response()->json([
											'mensagem' => 'Não é possivel cadastrar um cartão que já está salvo.'
										], 404);	
									}															

					}
				}					
			}else
			//boleto bancario
			if($metodoPagamento ==4){
				
			
				

			}else
			//transferencia bancario
			if($metodoPagamento ==5){
	
			}else{
				echo json_encode('metodo errado');
				die;
			}




			if($metodoPagamento==1){

			}else 
			if($metodoPagamento ==2 ){
				
				if($metodoPagamento ==2 && empty($dados->porcentagem)){
					return response()->json([
						'message' => 'Campo porcentagem nulo '.$dados->porcentagem
						
					], 500);
				}
				if($dados->porcentagem <0 || $dados->porcentagem >100){
					return response()->json([
						'message' => 'Valor de porcentagem informado incorretamente valor recebido '.$dados->porcentagem
						
					], 500);
				}

				//valor para fim de calculo
				$valorFinal = $valor_total-$valor_desconto;
				
				// efetua o desconto sobre o valor restante do credito empresarial definido pelo usuario
				$totalDescontoEmpresarial = ( ($valorLimiteRestante * $dados->porcentagem ) /100 );

				$totalPagarEmpresarial = ($valorFinal - $totalDescontoEmpresarial);
				$totalValorCredito = ($valorFinal - $totalPagarEmpresarial);
				//$valorCartaoCredito = ($valorLimiteRestante - $valorFinal );
				//$valorEmpresarial = 

				// valor para ser cobrado no cartao empresarial 
				$empresarial =  $dados->porcentagem  * $valorFinal / 100;

				// valor para ser cobrado no cartao de credito
				$cartaoCredito =  $valorFinal - $empresarial ;

			
				($dados->parcelas >3) ? $valorCartaoCredito = $this->convertRealEmCentavos(  number_format( $cartaoCredito * (1 + 0.05) ** $pag->qt_parcela, 2, ',', '.') ) : $valorCartaoCredito = $this->convertRealEmCentavos( number_format(  $cartaoCredito , 2, ',', '.') ) ;
				$valorCartaoEmpresarial = $this->convertRealEmCentavos( number_format(  $empresarial , 2, ',', '.') );
			
				//$dados['cvv']
				//$dados['parcelas']
				//$dados['porcentagem']
			
			}else{
				$valor =  $this->convertRealEmCentavos( number_format( $valor_total-$valor_desconto, 2, ',', '.') ) ;
			}
			
		

			die;
		

				// pagamento com cartão de credito e empresarial
			if ($metodoPagamento ==2) {					
				
			
				
			//	$valorFinal = $valor_total-$valor_desconto;
				//$dados->porcentagem  *	$valorFinal
			//	$valor =  $this->convertRealEmCentavos( number_format( $valor_total-$valor_desconto, 2, ',', '.') ) ;							
			}

			die;

				// pagamento com cartão de credito
			if ($metodoPagamento ==3) {											
					try{
						$criarPagamento = $client->getOrders()->createOrder(FuncoesPagamento::criarPagamentoCartaoUnico($paciente->mundipagg_token,$valor, $dados->parcelas, "Doutor hoje cart",$cartao, "Doutor hoje",$metodoCartao,!empty($dados->cvv)  ? $dados->cvv : '' ))    ;					
					}catch(\Exception $e){
						DB::rollBack();
						return response()->json([
							'message' => 'Não foi possivel efetuar o pagamento com o cartao de crédito, pagamento não efetuado!',
							'errors' => $e->getMessage(),
						], 500);
					}
															
			}
			
			if($metodoPagamento ==4){
				try{
					$criarPagamento = $client->getOrders()->createOrder(FuncoesPagamento::pagamentoBoleto($valor,$paciente->mundipagg_token, 123456, "Pagar até o vencimento boleto")) ;
					//echo json_encode($criarPagamento); die;
				}catch(\Exception $e){
					DB::rollBack();
					return response()->json([
						'message' => 'Não foi possivel gerar o boleto de pagamento!',
						'errors' => $e->getMessage(),
					], 500);
				}
			}

			if($metodoPagamento ==5){
				try{
					$criarPagamento = $client->getOrders()->createOrder(FuncoesPagamento::criarTranferencia($valor,"Doutor hoje",$paciente->mundipagg_token));    
				//var_dump($criarPagamento); die;
				}catch(\Exception $e){
					DB::rollBack();
					return response()->json([
						'message' => 'Não foi possivel realizar transferencia bancaria, pagamento não efetuado!',
						'errors' => $e->getMessage(),
					], 500);
				}
			}

			
		//	var_dump($criarPagamento); die;

        /*if ($tp_pagamento == 'credito') {
        	if ($valor_total > 200) {
        		$parcelamentos = [];
        	
        		for ($i = 1; $i < 5; $i++) {
        		    $item_valor =  $valor_parcelamento/$i;
        		    
        		    if ($i <= 3) {
        		        $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor,  2, ',', '.').' sem juros';
        		    } elseif ($i > 3) {
        		        $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor*1.05,  2, ',', '.').' com juros (5% a.m.)';
        		    }
        		}
        	}
        }
         */
        
        
        //-- pedido id do DoutorHoje----------------------------------
        //$MerchantOrderId = $pedido->id;
        
        //-- dados do comprador---------------------------------------
        $customer = Paciente::findorfail($paciente_id);
        $customer->load('user');
        $customer->load('documentos');
        $customer->load('contatos');
		
		$customer_name                  = $customer->nm_primario.' '.$customer->nm_secundario; //-- usado no pagamento por debito tambem
        $customer_identity              = $customer->documentos->first()->te_documento;
        $customer_Identity_type         = $customer->documentos->first()->tp_documento;
        $customer_email                 = $customer->user->email;
        $customer_birthdate             = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", $customer->dt_nascimento);
   
		if (!$pedido->save()) {
			########### FINISHIING TRANSACTION ##########
			DB::rollback();
			#############################################
			return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
		}

		
		if(!empty($criarPagamento)){
			$dadosPagamentos = json_decode(json_encode($criarPagamento), true);
			$result_agendamentos=[];
			foreach($agendamentoItens as $i=>$item_agendamento) {
				
									$MerchantOrderId = $pedido->id;
									$agendamento 						= new Agendamento();
									$agendamento->te_ticket				= UtilController::getAccessToken();
									$agendamento->cs_status         	= 10;
									$agendamento->bo_remarcacao     	= 'N';
									$agendamento->bo_retorno        	= 'N';
									$agendamento->paciente_id       	= $item_agendamento->paciente_id;
			
									if(!empty($item_agendamento->atendimento_id)) {
										$agendamento->dt_atendimento    = isset($item_agendamento->dt_atendimento) && !empty($item_agendamento->dt_atendimento) ? \DateTime::createFromFormat('d/m/Y H:i', $item_agendamento->dt_atendimento)->format('Y-m-d H:i:s') : null;
										$agendamento->clinica_id        = $item_agendamento->clinica_id;
										$agendamento->filial_id			= $item_agendamento->filial_id;
										$agendamento->atendimento_id    = $item_agendamento->atendimento_id;
										 $agendamento->profissional_id   = isset($item_agendamento->profissional_id) && !empty($item_agendamento->profissional_id) ? $item_agendamento->profissional_id : null;
									} elseif(!empty($item_agendamento->checkup_id)) {
										$agendamento->checkup_id = $item_agendamento->checkup_id;
									}
			
									//--busca o cupom de desconto------------
									$cupom_desconto = $this->buscaCupomDesconto($cod_cupom_desconto);
									 
									if (sizeof($cupom_desconto) > 0) {
										$agendamento->cupom_id = $cupom_desconto->first()->id;
									}
									 
									if ($agendamento->save()) {
			
										$agendamento->atendimentos()->attach( $item_agendamento->atendimento_id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ] );
										$agendamento_id = $agendamento->id;
										$agendamento->load('atendimento');
										$agendamento->load('clinica');
										$agendamento->load('filial');
										$agendamento->load('profissional');
										$agendamento->load('paciente');
										
										 
										$item_pedido = new Itempedido();
										$item_pedido->pedido_id = $MerchantOrderId;
										$item_pedido->agendamento_id = $agendamento_id;
			
										if(!empty($item_agendamento->atendimento_id)) {
											$item_pedido->valor = $agendamento->atendimentos()->first()->vl_com_atendimento * (1 - $percentual_desconto);
										} else {
											foreach ($item_agendamento->itens as $item) {
												$dataHoraCheckup = new Datahoracheckup();
												$dataHoraCheckup->agendamento_id = $agendamento->id;
												$dataHoraCheckup->itemcheckup_id = $item['id'];
												
												if ( !empty($item['dt_atendimento']) ) {                                        
													$dtAtendimento = Carbon::createFromFormat('d/m/Y H:i', $item['dt_atendimento'])->toDateTimeString();
													$dataHoraCheckup->dt_atendimento = $dtAtendimento;    
												}
			
												if (!$dataHoraCheckup->save()) {
													DB::rollback();
													return response()->json([
														'mensagem' => 'Erro ao salvar a dataHoraCheckup!'
													], 500);
												}
											}
											$item_pedido->valor	= ItemCheckup::query()->where('checkup_id', $checkups_id)->sum('vl_com_checkup');
										}
			
										if(!$item_pedido->save()) {
											echo "<script>console.log( 'Debug Objects: item do pedido ($MerchantOrderId) não foi salvo. Por favor, tente novamente.' );</script>";
										}
			
										//--busca pelas especialidades do atendimento--------------------------------------
										$nome_especialidade = "";
										$ds_atendimento = "";
			
										$especialidade_obj = new Especialidade();
										$especialidade = $especialidade_obj->getNomeEspecialidade($agendamento->id);
			
										$agendamento->ds_atendimento = $especialidade['ds_atendimento'];
										$agendamento->nome_especialidade = $especialidade['nome_especialidades'];
			
										//--busca os itens de pedido relacionados------------------------------------------
										$agendamento->load('itempedidos');
			
										if(!is_null($agendamento->checkup_id)) {
											$agendamento->load('checkup');
											$agendamento->load('datahoracheckups');
										}
										
										//echo $agendamento; die;
										//$dados =(array) $agendamento; //json_decode(json_encode($agendamento), true);
										array_push($result_agendamentos,  $agendamento);
										
									

										//--enviar mensagem informando o pre agendamento da solicitacao----------------
										try {
											if(!is_null($agendamento->atendimento_id))
												$this->enviarEmailPreAgendamento($customer, $pedido, $agendamento);
										} catch (Exception $e) {}

											
											$Payment                                 	= new Payment();				 			 				 
											$Payment->merchant_order_id             	= $dadosPagamentos['id'];
											$Payment->payment_id                     	= $dadosPagamentos['charges'][0]['id'];
											$Payment->tid 							= $metodoPagamento == 3 ? $dadosPagamentos['charges'][0]['last_transaction']['acquirer_tid'] : ''; 
											$Payment->payment_type 					= $dadosPagamentos['charges'][0]['payment_method']; 
											$Payment->amount                        	= $dadosPagamentos['charges'][0]['amount']; 
											$Payment->currency                     	= $dadosPagamentos['charges'][0]['currency']; 
											$Payment->country                     	= "BRA";
											$Payment->installments 				     = $metodoPagamento == 3 ? $dadosPagamentos['charges'][0]['last_transaction']['installments'] : 0;							
											$Payment->pedido_id  						= $pedido->id;
											$Payment->cielo_result                 	= json_encode($criarPagamento);
											
											if(!$Payment->save()) {
												DB::rollback();
												return response()->json([
													'mensagem' => 'Erro ao salvar o pagamento!'
												], 500);
											}
						
									}


									 
							}

							$dados = json_decode(json_encode($criarPagamento), true);		

							$boleto=null;
							if($metodoPagamento==4){

								$boleto = [
									"instrucoes" => $dados['charges'][0]['last_transaction']['instructions'],
									"url" => 	$dados['charges'][0]['last_transaction']['url'],
									"qr_code" => $dados['charges'][0]['last_transaction']['qr_code'],
									"pdf_url" => $dados['charges'][0]['last_transaction']['pdf']	
								];
								
							//	$this->enviarEmailPagamentoRealizado($paciente, $pedido, $dados['charges'][0]['last_transaction']['url']);																														
							}


							$transferencia=null;
							if($metodoPagamento==5){
								$transferencia = [
									"metodo" => $dados['charges'][0]['payment_method'],
									"url" => 	$dados['charges'][0]['last_transaction']['url']									
								];
									
																																	
							}

						

							//print_r($result_agendamentos); die;

							 ########### FINISHIING TRANSACTION ##########
						//	 DB::commit();
							 #############################################
						//	 CVXCart::clear();
						
							 $valor_total_pedido = $valor_total-$valor_desconto;
							 
 

							 $request->session()->put('result_agendamentos', $result_agendamentos);
							 $request->session()->put('pedido', $pedido);
							 $request->session()->put('valor_total_pedido', $valor_total_pedido);
							 $request->session()->put('descricao_boleto', $boleto);
							 $request->session()->put('trans_bancario', $transferencia)	;
							 //return view('payments.finalizar_pedido', compact('result_agendamentos', 'pedido', 'valor_total_pedido'));
							 
							//return redirect()->route('payments.pedido_finalizado')->with('success', 'O Pedido foi realizado com sucesso!');
							 return response()->json(['status' => true, 'mensagem' => 'O Pedido foi realizado com sucesso!', 'pagamento' => $criarPagamento]);


			
						}else{
							DB::rollback();
								return response()->json([
									'message' =>'informe um tipo de pagamento correto, tipo de pagamento enviado: ',                    
								], 422);
						}

    }
	
	

	/**
	 * Converte os valores recebidos em reais para centavos	 	
	 */
	private function convertRealEmCentavos($valor){
		// regra de 3
		/**
		 * 1 real------- 100ctv
		 * 5 reais------ x
		 * 1*x=100*5
		 * z=500 centavos
		 */
		
		$dado = str_replace(".", "", $valor);

		$dado = str_replace(",", ".", $dado);
		
		$resultado = $dado*100;		
		//echo $resultado; die;
		return (int) $resultado;
	}





    /**
     * realiza o pagamento na Cielo por cartao de credito cadastrado no padrao completo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fullTransactionSaveCard(Request $request)
    {
    	$merchantKey    = env('CIELO_MERCHANT_KEY');
    	$merchantId     = env('CIELO_MERCHANT_ID');
    	$url            = env('CIELO_URL').'/1/sales';
    	
    	//--verifica se as condicoes de agendamento estao disponiveis------
    	$agendamento_disponivel = true;
    	$agendamentos = CVXRequest::post('agendamentos');
    	
    	//--verifica se todos os agendamentos possuem um atendimento relacionado------
    	$agendamento_atendimento = true;

		$carrinho = CVXCart::getContent()->toArray();

    	//--verifica se profissional existe, indicando que se trata de um exame/procedimento que não precisa de profissional e nem data/hora--
    	//--ou verifica que se trata de uma consulta ou atendimento em uma clinica que sempre necessita de data/hora--
    	for ($i = 0; $i < sizeof($agendamentos); $i++) {
    	    $item_agendamento = json_decode($agendamentos[$i]);
			$listCarrinho = $this->listCarrinhoItens();

			if(!empty($item_agendamento->atendimento_id)) {
				$atendimento_id_temp = $item_agendamento->atendimento_id;
				$item_atendimento = Atendimento::findorfail($atendimento_id_temp);
				$item_atendimento->load('clinica');

				$item_agendamento->dt_atendimento = \DateTime::createFromFormat('Y-m-d H:i', $item_agendamento->dt_atendimento);

				if ($item_agendamento->profissional_id && $item_agendamento->profissional_id != 'null') {
					$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', $item_agendamento->dt_atendimento->format('Y-m-d H:i:s'))->get();

					if (sizeof($agendamento) > 0) {
						$agendamento_disponivel = false;
					}

				} elseif ($item_atendimento->consulta_id != null | $item_atendimento->clinica->tp_prestador == 'CLI') {

					$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('dt_atendimento', '=', $item_agendamento->dt_atendimento->format('Y-m-d H:i:s'))->get();

					if (sizeof($agendamento) > 0) {
						$agendamento_disponivel = false;
					}
				}

				if ($item_atendimento == null) {
					$agendamento_atendimento = false;
				}

				$item_agendamento->dt_atendimento = !empty($item_agendamento->dt_atendimento) ? $item_agendamento->dt_atendimento->format('d/m/Y H:i') : null;
				$agendamentoItens[] = $item_agendamento;
			} elseif(!empty($item_agendamento->checkup_id)) {
				$idCarrinho = $listCarrinho['checkups'][$item_agendamento->checkup_id];
				$item_agendamento->itens = $carrinho[$idCarrinho]['attributes']['items_checkup'];

				if (!Checkup::where(['id' => $item_agendamento->checkup_id])->exists()) {
					return response()->json([
						'mensagem' => 'O seu Agendamento não foi realizado, pois um dos checkups informados não existe. Por favor, tente novamente.'
					], 403);
				}

				if (count($item_agendamento->itens) != ItemCheckup::where(['checkup_id' => $item_agendamento->checkup_id])->get()->count()) {
					return response()->json([
						'mensagem' => 'Quantidade de itens fornecidos no checkup invalida. Por favor, tente novamente.'
					], 400);
				}

				foreach ($item_agendamento->itens as $key => $item) {
					if (!empty($item['data_agendamento']) || !empty($item['hora_agendamento'])) {
						$dataHoraAgendamento = $item['data_agendamento'] . ' ' . $item['hora_agendamento'];
						$item['dt_atendimento'] = \DateTime::createFromFormat('d.m.Y H:i', $dataHoraAgendamento)->format('d/m/Y H:i');

						$atendimento = Atendimento::join('item_checkups', 'item_checkups.atendimento_id', '=', 'atendimentos.id')
							->where(['item_checkups.id' => $item['id'], 'item_checkups.checkup_id' => $item_agendamento->checkup_id])
							->first();

						if (!Agendamento::validaHorarioDisponivel($atendimento->clinica_id, $atendimento->profissional_id, $item['dt_atendimento'])) {
							return response()->json([
								'checkup_id' => $item_agendamento->checkup_id,
								'profissional_id' => $item->profissional_id,
								'clinica_id' => $item->clinica_id,
								'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.'
							], 403);
						}

						$item_agendamento->itens[$key]['dt_atendimento'] = $item['dt_atendimento'];
					} else {
						$item_agendamento->itens[$key]['dt_atendimento'] = null;
					}
				}

				$checkups_id[] = $item_agendamento->checkup_id;
				$agendamentoItens[] = $item_agendamento;
			}
    	}
    	 
    	if (!$agendamento_disponivel) {
    		return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.']);
    	}
    	 
    	if (!$agendamento_atendimento) {
    		return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos itens não possui um Atendimento Relacionado. Por favor, tente novamente.']);
    	}
    	
    	########### STARTING TRANSACTION ############
    	DB::beginTransaction();
    	#############################################
    	
    	//--verifica se eh credito ou debito---------------
    	$tp_pagamento = CVXRequest::post('tipo_pagamento');
    	
    	$cod_cupom_desconto = CVXRequest::post('cod_cupom_desconto');
    	$percentual_desconto = 0; // '0' indica que o cliente vai pagar 100% do valor total dos produtos-----
    	
    	if($cod_cupom_desconto != '') {
    	    $percentual_desconto = $this->validarCupomDesconto($cod_cupom_desconto);
    	}
    	
    	$cartao_paciente = CVXRequest::post('cartao_paciente');
    
    	$valor_total = CVXCart::getTotal();
    	$valor_desconto = $valor_total*$percentual_desconto;
    
    	//-- determina o numero de parcelas -------
    	$valor_parcelamento = $valor_total-$valor_desconto;
    	
    	
    	$parcelamentos = array(
    	    1 => '1x R$ '.number_format( $valor_parcelamento,  2, ',', '.')
    	);
    	
    	if ($tp_pagamento == 'credito') {
    	    if ($valor_total > 200) {
    	        $parcelamentos = [];
    	        
    	        for ($i = 1; $i < 5; $i++) {
    	            $item_valor =  $valor_parcelamento/$i;
    	            
    	            if ($i <= 3) {
    	                $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor,  2, ',', '.').' sem juros';
    	            } elseif ($i > 3) {
    	                $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor*1.05,  2, ',', '.').' com juros (5% a.m.)';
    	            }
    	        }
    	    }
    	}

		//--cartao cadastrado do paciente-----------------------------
		$cartao_cadastrado = CartaoPaciente::findorfail($cartao_paciente);

    	$pedido = new Pedido();
    	$titulo_pedido = CVXRequest::post('titulo_pedido');
    	$descricao = '';
    	$dt_pagamento = date('Y-m-d H:i:s');
    	$paciente_id = CVXRequest::post('paciente_id');
    	$num_parcela_selecionado = CVXRequest::post('num_parcela_selecionado');
    
    	$pedido->titulo         = $titulo_pedido;
    	$pedido->descricao      = $descricao;
    	$pedido->dt_pagamento   = $dt_pagamento;
    	$pedido->tp_pagamento   = 'cadastrado';
    	$pedido->paciente_id    = $paciente_id;
		$pedido->cartao_id		= $cartao_cadastrado->id;
    
    	if (!$pedido->save()) {
    		########### FINISHIING TRANSACTION ##########
    		DB::rollback();
    		#############################################
    		return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
    	}
    
    	//-- pedido id do DoutorHoje----------------------------------
    	$MerchantOrderId = $pedido->id;

    	//-- dados do comprador---------------------------------------
    	$customer = Paciente::findorfail($paciente_id);
    	$customer->load('user');
    	$customer->load('documentos');
    	$customer->load('contatos');
    
    	$customer_name                  = $customer->nm_primario.' '.$customer->nm_secundario; //-- usado no pagamento por debito tambem
    	$customer_identity              = $customer->documentos->first()->te_documento;
    	$customer_Identity_type         = $customer->documentos->first()->tp_documento;
    	$customer_email                 = $customer->user->email;
    	$customer_birthdate             = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", $customer->dt_nascimento);
    
    	$payment_type                   = 'CreditCard'; //-- usado no pagamento por credito apenas, no tipo pagamento, SaveCard
    	$payment_amount                 = ($valor_total-$valor_desconto)*100;
    	$payment_currency               = 'BRL';
    	$payment_country                = 'BRA';
    	
    	$payment_installments           = intval($num_parcela_selecionado); //sizeof($parcelamentos);
    	$payment_softdescriptor         = 'DoutorHoje';
    	$payment_card_token       		= $cartao_cadastrado->card_token; 
    	$payment_holder                 = $cartao_cadastrado->nome_impresso;
    	$payment_security_code          = CVXRequest::post('cod_seg_cartao');
    	$payment_brand                  = $cartao_cadastrado->bandeira;
    
    	$payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"Installments":"'.$payment_installments.'","SoftDescriptor":"'.$payment_softdescriptor.'","CreditCard":{"CardToken":"'.$payment_card_token.'","SecurityCode":"'.$payment_security_code.'","Brand":"'.$payment_brand.'"}}}';
    
    	//dd($payload);
    
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'MerchantId: '.$merchantId, 'MerchantKey: '.$merchantKey));
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload );
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$output = curl_exec($ch);
    	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	

        $cielo_result = json_decode($output);

        \Log::debug("CIELO CHECKOUT");
        \Log::debug(" -- Sended data --");
        \Log::debug( print_r(array('Content-Type: application/json', 'MerchantId: '.$merchantId, 'MerchantKey: '.$merchantKey), true) );
        
        \Log::debug(" -- Result data --");
        \Log::debug( print_r($cielo_result,true) );

    	if ($httpcode == 201) {
    		try {
    			$cielo_status = $cielo_result->Payment->Status;
    			if ($cielo_status == 1 | $cielo_status == 2) {
    				
    				$result_agendamentos = [];
//    				$agendamentos = CVXRequest::post('agendamentos');

					foreach($agendamentoItens as $i=>$item_agendamento) {
						$agendamento = new Agendamento();
						$agendamento->te_ticket = UtilController::getAccessToken();
						$agendamento->cs_status = 10;
						$agendamento->bo_remarcacao = 'N';
						$agendamento->bo_retorno = 'N';
						$agendamento->paciente_id = $item_agendamento->paciente_id;

						if (!empty($item_agendamento->atendimento_id)) {
							$agendamento->dt_atendimento = isset($item_agendamento->dt_atendimento) && !empty($item_agendamento->dt_atendimento) ? \DateTime::createFromFormat('d/m/Y H:i', $item_agendamento->dt_atendimento)->format('Y-m-d H:i:s') : null;
							$agendamento->filial_id = $item_agendamento->filial_id;
                            // $agendamento->clinica_id = $item_agendamento->clinica_id;
							// $agendamento->atendimento_id = $item_agendamento->atendimento_id;
							// $agendamento->profissional_id = isset($item_agendamento->profissional_id) && !empty($item_agendamento->profissional_id) ? $item_agendamento->profissional_id : null;
						} elseif (!empty($item_agendamento->checkup_id)) {
							$agendamento->checkup_id = $item_agendamento->checkup_id;
						}

						//--busca o cupom de desconto------------
						$cupom_desconto = $this->buscaCupomDesconto($cod_cupom_desconto);

						if (sizeof($cupom_desconto) > 0) {
							$agendamento->cupom_id = $cupom_desconto->first()->id;
						}

						if ($agendamento->save()) {
                            $agendamento->atendimentos()->attach( $item_agendamento->atendimento_id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s') ] );
                            
							$agendamento_id = $agendamento->id;
							$agendamento->load('atendimento');
							$agendamento->load('clinica');
							$agendamento->load('filial');
							$agendamento->load('profissional');
							$agendamento->load('paciente');

							$item_pedido = new Itempedido();
							$item_pedido->pedido_id = $MerchantOrderId;
							$item_pedido->agendamento_id = $agendamento_id;

							if (!empty($item_agendamento->atendimento_id)) {
								$item_pedido->valor = $agendamento->atendimentos()->first()->vl_com_atendimento * (1 - $percentual_desconto);
							} else {
								foreach ($item_agendamento->itens as $item) {
									$dataHoraCheckup = new Datahoracheckup();
									$dataHoraCheckup->agendamento_id = $agendamento->id;
									$dataHoraCheckup->itemcheckup_id = $item['id'];

                                    if ( !empty($item['dt_atendimento']) ) {                                        
                                        $dtAtendimento = Carbon::createFromFormat('d/m/Y H:i', $item['dt_atendimento'])->toDateTimeString();
                                        $dataHoraCheckup->dt_atendimento = $dtAtendimento;    
                                    }

									if (!$dataHoraCheckup->save()) {
										DB::rollback();
										return response()->json([
											'mensagem' => 'Erro ao salvar a dataHoraCheckup!'
										], 500);
									}
								}
								$item_pedido->valor = ItemCheckup::query()->where('checkup_id', $checkups_id)->sum('vl_com_checkup');
							}

							if (!$item_pedido->save()) {
								echo "<script>console.log( 'Debug Objects: item do pedido ($MerchantOrderId) não foi salvo. Por favor, tente novamente.' );</script>";
							}

							//--busca pelas especialidades do atendimento--------------------------------------
							$nome_especialidade = "";
							$ds_atendimento = "";

							$especialidade_obj = new Especialidade();
							$especialidade = $especialidade_obj->getNomeEspecialidade($agendamento->id);

							$agendamento->ds_atendimento = $especialidade['ds_atendimento'];
							$agendamento->nome_especialidade = $especialidade['nome_especialidades'];

							//--busca os itens de pedido relacionados------------------------------------------
							$agendamento->load('itempedidos');

							if(!is_null($agendamento->checkup_id)) {
								$agendamento->load('checkup');
								$agendamento->load('datahoracheckups');
							}

							if (!is_null($agendamento->checkup_id))
								$agendamento->load('datahoracheckups');

							array_push($result_agendamentos, $agendamento);

							//--enviar mensagem informando o pre agendamento da solicitacao----------------
							try {
								if (!is_null($agendamento->atendimento_id))
									$this->enviarEmailPreAgendamento($customer, $pedido, $agendamento);
							} catch (Exception $e) {}
						}
					}
    			} else {
    				
    				########### FINISHIING TRANSACTION ##########
    				DB::rollback();
    				#############################################
    				 
    				if ($cielo_status == 0) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "0". O Pagamento não foi Finalizado e portanto, o Pedido não foi realizado. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 3) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "3". O Pagamento foi Negado pelo Autorizador. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 10) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "10". O Pagamento foi Cancelado. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 11) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "11". O Pagamento foi Cancelado após 23:59 do dia de autorização. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 12) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "12". O Pagamento não foi Realizado por estar Aguardando Status da Instituição Financeira. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 13) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "13". O Pagamento foi Cancelado por falha no Processamento. Por favor, tente novamente.']);
    				} elseif ($cielo_status == 20) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "20". O Pagamento foi registrado como Recorrência, devido a uma falha e será cancelado. Por favor, tente novamente.']);
    				} else {
                        $returnMessage = $cielo_result->Payment->ReturnMessage;
                        return response()->json(['status' => false, 'mensagem' => 'Cód: "'. $cielo_status . '". ' . $returnMessage]);   
                    }
    				 
    				// return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo, devido a uma falha inesperada. Por favor, tente novamente.']);
    				
    			}
    		} catch (\Exception $e) {

                \Log::debug(" -- Checkout Exception --");
                \Log::debug( $e->getMessage() );
                \Log::debug( $e->getTraceAsString() );

    			########### FINISHIING TRANSACTION ##########
    			DB::rollback();
    			#############################################
    			return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo, devido a uma falha inesperada. Por favor, tente novamente.']);
    		}
    
    		$pagamento = new Payment();
    
    		$pagamento->merchant_order_id 		= $cielo_result->MerchantOrderId;
    		$pagamento->payment_id 				= $cielo_result->Payment->PaymentId;
    		$pagamento->tid 					= $cielo_result->Payment->Tid;
    		$pagamento->payment_type 			= $cielo_result->Payment->Type;
    		$pagamento->amount 					= $cielo_result->Payment->Amount;
    		$pagamento->currency 				= $cielo_result->Payment->Currency;
    		$pagamento->country 				= $cielo_result->Payment->Country;
    		$pagamento->service_tax_amount 		= $cielo_result->Payment->ServiceTaxAmount;
    		$pagamento->installments 			= $cielo_result->Payment->Installments;
    		$pagamento->interest 				= $cielo_result->Payment->Interest;
    		$pagamento->capture 				= $cielo_result->Payment->Capture;
    		$pagamento->authenticate 			= $cielo_result->Payment->Authenticate;
    		$pagamento->recurrent 				= $cielo_result->Payment->Recurrent;
    		$pagamento->soft_descriptor 		= $cielo_result->Payment->SoftDescriptor;
    		$pagamento->crc_holder 				= $payment_holder;
    		$pagamento->crc_expiration_date 	= $cartao_cadastrado->dt_validade;
    		$pagamento->crc_save_card			= 'false';
    		$pagamento->crc_brand 				= $cielo_result->Payment->CreditCard->Brand;
    		$pagamento->cielo_result 			= $output;
    		$pagamento->pedido_id 				= $cielo_result->MerchantOrderId;
    
    		$pagamento->save();
    		
    		$crc_response = new CreditCardResponse();
    		
    		$crc_response->tid 					= $cielo_result->Payment->Tid;
    		$crc_response->proof_of_sale 		= isset($cielo_result->Payment->ProofOfSale) ? $cielo_result->Payment->ProofOfSale : '';
    		$crc_response->authorization_code 	= isset($cielo_result->Payment->AuthorizationCode) ? $cielo_result->Payment->AuthorizationCode : '';
    		$crc_response->soft_descriptor 		= $cielo_result->Payment->SoftDescriptor;
    		$crc_response->crc_status 			= $cielo_result->Payment->Status;
    		$crc_response->return_code 			= $cielo_result->Payment->ReturnCode;
    		$crc_response->return_message 		= $cielo_result->Payment->ReturnMessage;
    		$crc_response->payment_id 			= $pagamento->id;
    		
    		$crc_response->save();
    		
    		########### FINISHIING TRANSACTION ##########
    		DB::commit();
    		#############################################
    		CVXCart::clear();
    
    		$valor_total_pedido = $valor_total-$valor_desconto;
    
    		$request->session()->put('result_agendamentos', $result_agendamentos);
    		$request->session()->put('pedido', $pedido);
    		$request->session()->put('valor_total_pedido', $valor_total_pedido);
    
    		//return view('payments.finalizar_pedido', compact('result_agendamentos', 'pedido', 'valor_total_pedido'));
    
    		//return redirect()->route('payments.pedido-finalizado')->with('success', 'O Pedido foi realizado com sucesso!');
    		return response()->json(['status' => true, 'mensagem' => 'O Pedido foi realizado com sucesso!', 'pagamento' => $output]);
    	} else {
    		return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
    	}
    }
    
    /**
     * validarCupomDesconto a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validarCupomDesconto($cod_cupom_desconto)
    {
        $cupom_desconto = [];
        
        if ($cod_cupom_desconto == '') {
            return 0;
        }
        
        $ct_date = date('Y-m-d H:i:s');
        
        $cupom_desconto = CupomDesconto::where('codigo', '=', $cod_cupom_desconto)->where('cs_status', '=', 'A')->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->get();
        
        if($cupom_desconto === null) {
            return 0;
        }
        
        $user_session = Auth::user();
        $paciente_id = $user_session->paciente->id;
        $cupom_id = $cupom_desconto->first()->id;
        
        $agendamento_cupom = Agendamento::where('paciente_id', '=', $paciente_id)->where('cupom_id', '=', $cupom_id)->get();
        
        if(sizeof($agendamento_cupom) > 0) {
            return 0;
        }
        
        $percentual = $cupom_desconto->first()->percentual/100;
        
        return $percentual;
    }
    
    /**
     * buscaCupomDesconto a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscaCupomDesconto($cod_cupom_desconto)
    {
        $cupom_desconto = [];
        
        if ($cod_cupom_desconto == '') {
            return $cupom_desconto;
        }
        
        $ct_date = date('Y-m-d H:i:s');
        
        $cupom_desconto = CupomDesconto::where('codigo', '=', $cod_cupom_desconto)->where('cs_status', '=', 'A')->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->get();
        
        if($cupom_desconto === null) {
            return $cupom_desconto;
        }
        
        $user_session = Auth::user();
        $paciente_id = $user_session->paciente->id;
        $cupom_id = $cupom_desconto->first()->id;
        
        $agendamento_cupom = Agendamento::where('paciente_id', '=', $paciente_id)->where('cupom_id', '=', $cupom_id)->get();
        
        if(sizeof($agendamento_cupom) > 0) {
            return [];
        }
        
        return $cupom_desconto;
    }
    
    
    public function testeEnviarEmail(){
    	 
    	$paciente = Paciente::findorfail(21);
    	$paciente->load('user');
    	$paciente->load('documentos');
    	$paciente->load('contatos');
    	 
    	$pedido = Pedido::findorfail(11);
    	
    	$agendamento = Agendamento::findorfail(5);
    	$agendamento->load('profissional');
    	$agendamento->load('clinica');
    	
    	$nome_especialidade = "";
    	
    	foreach ($agendamento->profissional->especialidades as $especialidade) {
    		$nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    	}
    	
    	$agendamento->nome_especialidade = $nome_especialidade;
    	
    	$send_message = $this->enviarEmailPreAgendamento($paciente, $pedido, $agendamento);
    	 
    	if ($send_message) {
    		dd('O e-mail foi enviado com sucesso!');
    		//dd($output);
    	}
    
    	return view('provisorio');
    }
    
    /**
     * enviarEmailPreAgendamento a newly external user created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enviarEmailPreAgendamento($paciente, $pedido, $agendamento)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    
    	# dados da mensagem
    	$mensagem_drhj            		= new Mensagem();
    	 
    	$mensagem_drhj->rma_nome     	= $paciente->nm_primario.' '.$paciente->nm_secundario;
    	$mensagem_drhj->rma_email       = $paciente->user->email;
    	$mensagem_drhj->assunto     	= 'Pré-Agendamento Solicitado';
    
    	$nome 		= $paciente->nm_primario.' '.$paciente->nm_secundario;
    	$email 		= $paciente->user->email;
    	$telefone 	= $paciente->contatos->first()->ds_contato;
    	
    	$nm_primario 			= $paciente->nm_primario;
    	$nr_pedido 				= sprintf("%010d", $pedido->id);
    	$nome_especialidade 	= "Especialidade/exame: <span>".$agendamento->nome_especialidade."</span>";
    	
    	$nome_profissional = '---------';
    	$data_agendamento = '---------';
    	$hora_agendamento = '---------';
    	
    	if (!empty($agendamento->profissional_id)) {
    	    $nome_profissional		= "Dr(a): <span>".$agendamento->profissional->nm_primario." ".$agendamento->profissional->nm_secundario."</span>";
    	}

		if(!empty($agendamento->clinica->tp_prestador)){
			if($agendamento->consulta_id != null | $agendamento->clinica->tp_prestador == 'CLI') {
				$data_agendamento		= date('d', strtotime($agendamento->getRawDtAtendimentoAttribute())).' de '.strftime('%B', strtotime($agendamento->getRawDtAtendimentoAttribute())).' / '.strftime('%A', strtotime($agendamento->getRawDtAtendimentoAttribute())) ;
				$hora_agendamento		= date('H:i', strtotime($agendamento->getRawDtAtendimentoAttribute())).' (por ordem de chegada)';
			}
		}
    	
    	
    	$nome_especialidade 	= "Descrição do atendimento: <span>".$agendamento->ds_atendimento." (".$agendamento->nome_especialidade.")</span>";
    	
    	$endereco_agendamento = '--------------------';
    	
    	//$agendamento->clinica->load('enderecos');
    	$agendamento->filial->load('endereco');
    	$enderecos_clinica = $agendamento->filial->endereco;
    	
    	if ($agendamento->filial->endereco != null) {
    		$enderecos_clinica->load('cidade');
    		$cidade_clinica = $enderecos_clinica->cidade;
    		
    		if ($cidade_clinica != null) {
    			$endereco_agendamento = $enderecos_clinica->te_endereco.', '.$enderecos_clinica->nr_logradouro.', '.$enderecos_clinica->te_bairro.', '.$cidade_clinica->nm_cidade.'/ '.$cidade_clinica->sg_estado;
    		}
    	}
    	
    	$agendamento_status = 'Pré-agendado';
    	 
    	$mensagem_drhj->conteudo     	= "<h4>Pré-Agendamento de Cliente:</h4><br><ul><li>Nome: $nome</li><li>E-mail: $email</li><li>Telefone: $telefone</li></ul>";
    	
    	$mensagem_drhj->save();
    
    	/* if(!$mensagem->save()) {
    		return redirect()->route('landing-page')->with('error', 'A Sua mensagem não foi enviada. Por favor, tente novamente');
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
    	
    	$mensagem_cliente->rma_nome     	= 'Contato DoutorHoje';
    	$mensagem_cliente->rma_email       	= 'contato@doutorhoje.com.br';
    	$mensagem_cliente->assunto     		= 'Pré-Agendamento Solicitado';
    	$mensagem_cliente->conteudo     	= "<h4>Seu Pré-Agendamento:</h4><br><ul><li>Nº do Pedido: $nr_pedido</li><li>$nome_especialidade</li><li>Dr(a): $nome_profissional</li><li>Data: $data_agendamento</li><li>Horário: $hora_agendamento (por ordem de chegada)</li><li>Endereço: $endereco_agendamento</li></ul>";
    	$mensagem_cliente->save();
    	
    	$destinatario                      = new MensagemDestinatario();
    	$destinatario->tipo_destinatario   = 'PC';
    	$destinatario->mensagem_id         = $mensagem_cliente->id;
    	$destinatario->destinatario_id     = $paciente->user->id;
    	$destinatario->save();
    	 
    	$from = 'contato@doutorhoje.com.br';
    	$to = $email;
    	$subject = 'Pré-Agendamento Solicitado';
    
    	$html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoutorHoje</title>
    </head>
    <body>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'>&nbsp;</td>
                <td width='120' style='text-align:right'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoutorHoje - Solicitação de agendamento</span></td>
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
                <td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px; font-weight: bold;'>Solicitação de agendamento</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 28px; line-height: 50px; color: #434342; background-color: #fff; text-align: center; font-weight: bold;'>
                    Olá, <strong style='color: #1d70b7;'>$nm_primario</strong>
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
                    Sua <strong>solicitação</strong> foi realizada com sucesso. Em até 48 horas você<br>
                    receberá a confirmação do agendamento escolhido.
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
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>Nº do pedido: <span>$nr_pedido</span></td>
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
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>$nome_especialidade</td>
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
                <td width='496' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>$nome_profissional</td>
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
        &nbsp;
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: justify;'>
                    Acompanhe no Perfil do Cliente o <em><strong>status</strong></em> da sua solicitação de
                    agendamento. Evite transtornos! Caso ocorra algum imprevisto,
                    impossibilitando o comparecimento ao serviço contratado, nos
                    informe com até 24 horas de antecedência.
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: center;'>
                    É um grande satisfação tê-lo como cliente.<br><br>
                    Abraços,<br>
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
                    Em caso de qualquer dúvida, fique à vontade <br>
                    para responder esse e-mail ou
                    nos contatar no <br><br>
                    <a href='mailto:cliente@doutorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>cliente@doutorhoje.com.br</a>
                    <br><br>
                    Ou ligue para (61) 3221-5350, o atendimento é de<br>
                    segunda à sexta-feira
                    das 8h00 às 18h00. <br><br>
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
    	
//     	echo "<script>console.log( 'Debug Objects: " . $send_message . "' );</script>";
//     	return redirect()->route('provisorio')->with('success', 'A Sua mensagem foi enviada com sucesso!');

    	return $send_message;
    }

	private function listCarrinhoItens()
	{
		$itensCarrinho = CVXCart::getContent()->toArray();

		foreach($itensCarrinho as $item) {
			if(!empty($item['attributes']['atendimento_id'])) {
				$atendimento_id = $item['attributes']['atendimento_id'];
				$list['atendimentos'][$atendimento_id] = $item['id'];
			} elseif(!empty($item['attributes']['checkup_id'])) {
				$checkup_id = $item['attributes']['checkup_id'];
				$list['checkups'][$checkup_id] = $item['id'];
			}
		}
		return $list;
	}
}
