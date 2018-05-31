<?php

namespace App\Http\Controllers;

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
    
    public function fullTransactionDoctorhj(Request $request)
    {
    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');
    	
        //$result_agendamentos = Agendamento::with('atendimento')->with('clinica')->with('profissional')->with('itempedidos')->with('paciente')->get();
        $result_agendamentos = $request->session()->get('result_agendamentos');
        
        if ($result_agendamentos == null) {
            return redirect()->route('landing-page');
        }
        //dd($result_agendamentos);
        //$pedido = [];
        $pedido = $request->session()->get('pedido');
        
        /* $valor_total_pedido = 0;
        
        foreach ($result_agendamentos as $agendamento) {
            if (isset($agendamento->itempedidos) && sizeof($agendamento->itempedidos) > 0) {
                
                $agendamento->itempedidos->first()->load('pedido');
                //             dd($result_agendamentos);
                $pedido = $agendamento->itempedidos->first()->pedido;
                $valor_total_pedido = $valor_total_pedido+$agendamento->itempedidos->first()->valor;
            }
        } */
        $valor_total_pedido = $request->session()->get('valor_total_pedido');
        
        $request->session()->forget('result_agendamentos');
        $request->session()->forget('pedido');
        $request->session()->forget('valor_total_pedido');
        
        return view('payments.finalizar_pedido', compact('result_agendamentos', 'pedido', 'valor_total_pedido'));
    }
    
    /**
     * realiza o pagamento na Cielo por cartao de credito no padrao completo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fullTransaction(Request $request)
    {
        $merchantKey    = env('CIELO_MERCHANT_KEY');
        $merchantId     = env('CIELO_MERCHANT_ID');
        $url            = env('CIELO_URL').'/1/sales';
        
        $tp_pagamento = CVXRequest::post('tipo_pagamento');
        $cod_cupom_desconto = CVXRequest::post('cod_cupom_desconto');
        $percentual_desconto = 0; // '0' indica que o cliente vai pagar 100% do valor total dos produtos-----
        
        if($cod_cupom_desconto != '') {
            $percentual_desconto = $this->validarCupomDesconto($cod_cupom_desconto);
        }
        
        //--verifica se as condicoes de agendamento estao disponiveis------
        $agendamento_disponivel = true;
        $agendamentos = CVXRequest::post('agendamentos');
        
        //--verifica se todos os agendamentos possuem um atendimento relacionado------
        $agendamento_atendimento = true;
        
        for ($i = 0; $i < sizeof($agendamentos); $i++) {
        	 
        	$item_agendamento = json_decode($agendamentos[$i]);
        	
        	$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($item_agendamento->dt_atendimento.":00")))->get();
        	
        	if (sizeof($agendamento) > 0) {
        		$agendamento_disponivel = false;
        	}
        	
        	$atendimento_id_temp = $item_agendamento->atendimento_id;
        	$item_atendimento = Atendimento::findorfail($atendimento_id_temp);
        	
        	if ($item_atendimento == null) {
        		$agendamento_atendimento = false;
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
        
        $save_card = CVXRequest::post('gravar_cartao') == 'on' ? 'true' : 'false';
        //dd($save_card);
        
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
        
        $pedido = new Pedido();
        $titulo_pedido = CVXRequest::post('titulo_pedido');
        $descricao = '';
        $dt_pagamento = date('Y-m-d H:i:s');
        $paciente_id = CVXRequest::post('paciente_id');
        
        $pedido->titulo         = $titulo_pedido;
        $pedido->descricao      = $descricao;
        $pedido->dt_pagamento   = $dt_pagamento;
        $pedido->tp_pagamento   = $tp_pagamento;
        $pedido->paciente_id    = $paciente_id;
        
        if (!$pedido->save()) {
        	########### FINISHIING TRANSACTION ##########
        	DB::rollback();
        	#############################################
            return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
        }
        
        //-- pedido id do DoctorHoje----------------------------------
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
        
        $customer_address_street        = "";
        $customer_address_number        = "";
        $customer_address_complement    = "";
        $customer_address_zipcode       = "";
        $customer_address_city          = "";
        $customer_address_state         = "";
        $customer_address_country       = "";
        
        $customer_delivery_street       = "";
        $customer_delivery_number       = "";
        $customer_delivery_complement   = "";
        $customer_delivery_zipcode      = "";
        $customer_delivery_city         = "";
        $customer_delivery_state        = "";
        $customer_delivery_country      = "";
        
        $payment_type                   = $tp_pagamento == 'credito' ? 'CreditCard' : 'DebitCard'; //-- usado no pagamento por debito tambem
        $payment_amount                 = ($valor_total-$valor_desconto)*100; //-- usado no pagamento por debito tambem
        $payment_return_url             = 'https://doctorhoje.com.br/'; //-- usado no pagamento por debito apenas
        $payment_currency               = 'BRL';
        $payment_country                = 'BRA';
        $payment_serv_taxa              = 0;
        $payment_installments           = sizeof($parcelamentos);
        $payment_interest               = "ByMerchant";
        $payment_capture                = 'true';
        $payment_authenticate           = $tp_pagamento == 'credito' ? 'false' : 'true'; //-- usado no pagamento por debito tambem
        $payment_softdescriptor         = 'doctorhoje';
        $payment_credicard_number       = CVXRequest::post('num_cartao'); //-- usado no pagamento por debito tambem
        $payment_holder                 = CVXRequest::post('nome_impresso_cartao'); //-- usado no pagamento por debito tambem
        $payment_expiration_date        = CVXRequest::post('mes_cartao').'/'.CVXRequest::post('ano_cartao'); //-- usado no pagamento por debito tambem
        $payment_security_code          = CVXRequest::post('cod_seg_cartao'); //-- usado no pagamento por debito tambem
        $payment_save_card              = CVXRequest::post('gravar_cartao') == 'on' ? 'true' : 'false';
        $payment_brand                  = CVXRequest::post('bandeira_cartao'); //-- usado no pagamento por debito tambem
        
        //--payload para CARTAO DE CREDITO
        if ($tp_pagamento == 'credito') {
        	$payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'","Identity":"'.$customer_identity.'","IdentityType":"'.$customer_Identity_type.'","Email":"'.$customer_email.'","Birthdate":"'.$customer_birthdate.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"ServiceTaxAmount":'.$payment_serv_taxa.', "Installments":'.$payment_installments.',"Interest":"'.$payment_interest.'","Capture":'.$payment_capture.',"Authenticate":'.$payment_authenticate.',"SoftDescriptor":"'.$payment_softdescriptor.'","CreditCard":{"CardNumber":"'.$payment_credicard_number.'","Holder":"'.$payment_holder.'","ExpirationDate":"'.$payment_expiration_date.'","SecurityCode":"'.$payment_security_code.'","SaveCard":'.$payment_save_card.',"Brand":"'.$payment_brand.'"}}}';
        }
        
        if ($tp_pagamento == 'debito') {
        	$payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"Authenticate": true,"ReturnUrl":"'.$payment_return_url.'","DebitCard":{"CardNumber":"'.$payment_credicard_number.'","Holder":"'.$payment_holder.'","ExpirationDate":"'.$payment_expiration_date.'","SecurityCode":"'.$payment_security_code.'","Brand":"'.$payment_brand.'"}}}';
        	//$payload = '{"MerchantOrderId":"2014121201","Customer":{"Name":"Theogenes Ferreira Duarte"},"Payment":{"Type":"DebitCard","Amount":100,"Authenticate": true,"ReturnUrl":"https://doctorhoje.com.br/","DebitCard":{"CardNumber":"4001786172267143","Holder":"THEOGENES F DUARTE","ExpirationDate":"12/2021","SecurityCode":"879","Brand":"Visa"}}}';
        }
        
        //dd($payload);
        
        //dd($payload);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'MerchantId: '.$merchantId, 'MerchantKey: '.$merchantKey));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //dd($output);
        if ($httpcode == 201) {
            
        	$cielo_result = json_decode($output);
        	//dd($cielo_result);
        	try {
        		$cielo_status = $cielo_result->Payment->Status;
        		if ($cielo_status == 2) {
        			
        			$result_agendamentos = [];
        			$agendamentos = CVXRequest::post('agendamentos');
        			 
        			for ($i = 0; $i < sizeof($agendamentos); $i++) {
        				 
        				$item_agendamento = json_decode($agendamentos[$i]);
        				//dd($item_agendamento);
        				$agendamento = new Agendamento();
        				 
        				$agendamento->te_ticket         = UtilController::getAccessToken();
        				$agendamento->cs_status         = 10;
        				$agendamento->dt_atendimento    = $item_agendamento->dt_atendimento.":00";
        				$agendamento->bo_remarcacao     = 'N';
        				$agendamento->bo_retorno        = 'N';
        				$agendamento->paciente_id       = $item_agendamento->paciente_id;
        				$agendamento->clinica_id        = $item_agendamento->clinica_id;
        				$agendamento->atendimento_id    = $item_agendamento->atendimento_id;
        				$agendamento->profissional_id   = $item_agendamento->profissional_id;
        				 
        				//--busca o cupom de desconto------------
        				$cupom_desconto = $this->buscaCupomDesconto($cod_cupom_desconto);
        				 
        				if (sizeof($cupom_desconto) > 0) {
        					$agendamento->cupom_id = $cupom_desconto->first()->id;
        				}
        				 
        				if ($agendamento->save()) {
        					$agendamento_id = $agendamento->id;
        					$agendamento->load('atendimento');
        					$agendamento->load('clinica');
        					$agendamento->load('profissional');
        					$agendamento->load('paciente');
        					 
        					$item_pedido = new Itempedido();
        					 
        					$item_pedido->valor     = $agendamento->atendimento->vl_com_atendimento*(1-$percentual_desconto);
        					$item_pedido->pedido_id = $MerchantOrderId;
        					$item_pedido->agendamento_id = $agendamento_id;
        					 
        					if(!$item_pedido->save()) {
        						echo "<script>console.log( 'Debug Objects: item do pedido ($MerchantOrderId) não foi salvo. Por favor, tente novamente.' );</script>";
        					}
        					 
        					//--busca pelas especialidades do atendimento--------------------------------------
        					$agendamento->profissional->load('especialidades');
        					$nome_especialidade = "";
        					 
        					foreach ($agendamento->profissional->especialidades as $especialidade) {
        						$nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
        					}
        					 
        					$agendamento->nome_especialidade = $nome_especialidade;
        					 
        					//--busca os itens de pedido relacionados------------------------------------------
        					$agendamento->load('itempedidos');
        					 
        					array_push($result_agendamentos, $agendamento);
        					 
        					if ($payment_save_card == 'true' & $tp_pagamento == 'credito') {
        			
        						$cartoes_paciente = CartaoPaciente::where('bandeira', '=', $cielo_result->Payment->CreditCard->Brand)
        						->where('nome_impresso', '=', $cielo_result->Payment->CreditCard->Holder)
        						->where('numero', '=', substr($cielo_result->Payment->CreditCard->CardNumber, -4))
        						->where('dt_validade', '=', $cielo_result->Payment->CreditCard->ExpirationDate)
        						->where('card_token', '=', $cielo_result->Payment->CreditCard->CardToken)
        						->where('paciente_id', $paciente_id)
        						->orderBy('nome_impresso', 'desc')->get();
        			
        						if (sizeof($cartoes_paciente) == 0) {
        							 
        							$cartao_paciente = new CartaoPaciente();
        			
        							$cartao_paciente->bandeira			= $cielo_result->Payment->CreditCard->Brand;
        							$cartao_paciente->nome_impresso		= $cielo_result->Payment->CreditCard->Holder;
        							$cartao_paciente->numero			= substr($cielo_result->Payment->CreditCard->CardNumber, -4);
        							$cartao_paciente->dt_validade		= $cielo_result->Payment->CreditCard->ExpirationDate;
        							$cartao_paciente->card_token		= $cielo_result->Payment->CreditCard->CardToken;
        							$cartao_paciente->paciente_id		= $paciente_id;
        			
        							$cartao_paciente->save();
        							 
        							//--relaciona o cartao do cliente ao pedido----------------
        							$pedido->cartao_id = $cartao_paciente->id;
        							$pedido->save();
        						}
        					}
        					 
        					//--enviar mensagem informando o pre agendamento da solicitacao----------------
        					try {
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
        			} elseif ($cielo_status == 1) {
        				return response()->json(['status' => false, 'mensagem' => 'Cód: "1". O Pagamento foi Autorizado, mas não confirmado e portanto, o Pedido não foi realizado. Por favor, tente novamente.']);
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
        			}
        			
        			return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo, devido a uma falha inesperada. Por favor, tente novamente.']);
        		}
            
            } catch (\Exception $e) {
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
            $pagamento->service_tax_amount 		= $tp_pagamento == 'credito' ? $cielo_result->Payment->ServiceTaxAmount : 0;
            $pagamento->installments 			= 0;
            $pagamento->interest 				= $tp_pagamento == 'credito' ? $cielo_result->Payment->Interest : '';
            $pagamento->capture 				= $tp_pagamento == 'credito' ? $cielo_result->Payment->Capture : false;
            $pagamento->authenticate 			= $tp_pagamento == 'credito' ? $cielo_result->Payment->Authenticate : false;
            $pagamento->recurrent 				= $tp_pagamento == 'credito' ? $cielo_result->Payment->Recurrent : false;
            $pagamento->soft_descriptor 		= $tp_pagamento == 'credito' ? $cielo_result->Payment->SoftDescriptor : '';
            
            if($tp_pagamento == 'credito') {
                $pagamento->crc_card_number 	    = $cielo_result->Payment->CreditCard->CardNumber;
                $pagamento->crc_holder 				= $cielo_result->Payment->CreditCard->Holder;
                $pagamento->crc_expiration_date 	= $cielo_result->Payment->CreditCard->ExpirationDate;
                $pagamento->crc_save_card			= $cielo_result->Payment->CreditCard->SaveCard;
                $pagamento->crc_brand 				= $cielo_result->Payment->CreditCard->Brand;
            } else {
                $pagamento->dbc_card_number 	    = $cielo_result->Payment->DebitCard->CardNumber;
                $pagamento->dbc_holder 				= $cielo_result->Payment->DebitCard->Holder;
                $pagamento->dbc_expiration_date 	= $cielo_result->Payment->DebitCard->ExpirationDate;
                $pagamento->crc_save_card			= $cielo_result->Payment->DebitCard->SaveCard;
                $pagamento->dbc_brand 				= $cielo_result->Payment->DebitCard->Brand;
            }
            $pagamento->cielo_result 			= $output;
            $pagamento->pedido_id 				= $cielo_result->MerchantOrderId;
            
            $pagamento->save();
            
            if ($tp_pagamento == 'credito') {
            
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
            }
            
            if ($tp_pagamento == 'debito') {
            
            	$dbc_response = new DebitCardResponse();
            
            	$dbc_response->tid 					= $cielo_result->Payment->Tid;
            	$dbc_response->authentication_url 	= isset($cielo_result->Payment->AuthenticationUrl) ? $cielo_result->Payment->AuthenticationUrl : '';
            	$dbc_response->dbc_status 			= $cielo_result->Payment->Status;
            	$dbc_response->return_code 			= $cielo_result->Payment->ReturnCode;
            	$dbc_response->payment_id 			= $pagamento->id;
            
            	$dbc_response->save();
            }
            
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
    	
    	for ($i = 0; $i < sizeof($agendamentos); $i++) {
    	
    		$item_agendamento = json_decode($agendamentos[$i]);
    		 
    		$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($item_agendamento->dt_atendimento.":00")))->get();
    		 
    		if (sizeof($agendamento) > 0) {
    			$agendamento_disponivel = false;
    		}
    		 
    		$atendimento_id_temp = $item_agendamento->atendimento_id;
    		$item_atendimento = Atendimento::findorfail($atendimento_id_temp);
    		 
    		if ($item_atendimento == null) {
    			$agendamento_atendimento = false;
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
    	
    	$pedido = new Pedido();
    	$titulo_pedido = CVXRequest::post('titulo_pedido');
    	$descricao = '';
    	$dt_pagamento = date('Y-m-d H:i:s');
    	$paciente_id = CVXRequest::post('paciente_id');
    
    	$pedido->titulo         = $titulo_pedido;
    	$pedido->descricao      = $descricao;
    	$pedido->dt_pagamento   = $dt_pagamento;
    	$pedido->tp_pagamento   = 'cadastrado';
    	$pedido->paciente_id    = $paciente_id;
    
    	if (!$pedido->save()) {
    		########### FINISHIING TRANSACTION ##########
    		DB::rollback();
    		#############################################
    		return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
    	}
    
    	//-- pedido id do DoctorHoje----------------------------------
    	$MerchantOrderId = $pedido->id;
    	
    	//--cartao cadastrado do paciente-----------------------------
    	$cartao_cadastrado = CartaoPaciente::findorfail($cartao_paciente);
    
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
    	
    	$payment_installments           = sizeof($parcelamentos);
    	$payment_softdescriptor         = 'DoctorHoje';
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
    	//dd($output);
    	if ($httpcode == 201) {
    
    		$cielo_result = json_decode($output);
    		//dd($cielo_result);
    		try {
    			$cielo_status = $cielo_result->Payment->Status;
    			if ($cielo_status == 2) {
    				
    				$result_agendamentos = [];
    				$agendamentos = CVXRequest::post('agendamentos');
    				
    				for ($i = 0; $i < sizeof($agendamentos); $i++) {
    				
    					$item_agendamento = json_decode($agendamentos[$i]);
    					//dd($item_agendamento);
    					$agendamento = new Agendamento();
    				
    					$agendamento->te_ticket         = UtilController::getAccessToken();
    					$agendamento->cs_status         = 10;
    					$agendamento->dt_atendimento    = $item_agendamento->dt_atendimento.":00";
    					$agendamento->bo_remarcacao     = 'N';
    					$agendamento->bo_retorno        = 'N';
    					$agendamento->paciente_id       = $item_agendamento->paciente_id;
    					$agendamento->clinica_id        = $item_agendamento->clinica_id;
    					$agendamento->atendimento_id    = $item_agendamento->atendimento_id;
    					$agendamento->profissional_id   = $item_agendamento->profissional_id;
    					 
    					//--busca o cupom de desconto------------
    					$cupom_desconto = $this->buscaCupomDesconto($cod_cupom_desconto);
    					 
    					if (sizeof($cupom_desconto) > 0) {
    						$agendamento->cupom_id = $cupom_desconto->first()->id;
    					}
    				
    					if ($agendamento->save()) {
    						$agendamento_id = $agendamento->id;
    						$agendamento->load('atendimento');
    						$agendamento->load('clinica');
    						$agendamento->load('profissional');
    						$agendamento->load('paciente');
    				
    						$item_pedido = new Itempedido();
    				
    						$item_pedido->valor     = $agendamento->atendimento->vl_com_atendimento*(1-$percentual_desconto);
    						$item_pedido->pedido_id = $MerchantOrderId;
    						$item_pedido->agendamento_id = $agendamento_id;
    				
    						if(!$item_pedido->save()) {
    							echo "<script>console.log( 'Debug Objects: item do pedido ($MerchantOrderId) não foi salvo. Por favor, tente novamente.' );</script>";
    						}
    				
    						//--busca pelas especialidades do atendimento--------------------------------------
    						$agendamento->profissional->load('especialidades');
    						$nome_especialidade = "";
    				
    						foreach ($agendamento->profissional->especialidades as $especialidade) {
    							$nome_especialidade = $nome_especialidade.' | '.$especialidade->ds_especialidade;
    						}
    				
    						$agendamento->nome_especialidade = $nome_especialidade;
    				
    						$agendamento->load('itempedidos');
    				
    						array_push($result_agendamentos, $agendamento);
    				
    						//--relaciona o cartao do cliente ao pedido----------------
    						$pedido->cartao_id = $cartao_cadastrado->id;
    						$pedido->save();
    				
    						//--enviar mensagem informando o pre agendamento da solicitacao----------------
    						try {
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
    				} elseif ($cielo_status == 1) {
    					return response()->json(['status' => false, 'mensagem' => 'Cód: "1". O Pagamento foi Autorizado, mas não confirmado e portanto, o Pedido não foi realizado. Por favor, tente novamente.']);
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
    				}
    				 
    				return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo, devido a uma falha inesperada. Por favor, tente novamente.']);
    				
    			}
    		} catch (\Exception $e) {
    			
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
        
        $cupom_desconto = CupomDesconto::where('codigo', '=', $cod_cupom_desconto)->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->get();
        
        if($cupom_desconto === null) {
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
        
        $cupom_desconto = CupomDesconto::where('codigo', '=', $cod_cupom_desconto)->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->get();
        
        if($cupom_desconto === null) {
            return $cupom_desconto;
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
    	
    	$mensagem_cliente->rma_nome     	= 'Contato DoctorHoje';
    	$mensagem_cliente->rma_email       	= 'contato@doctorhoje.com.br';
    	$mensagem_cliente->assunto     		= 'Pré-Agendamento Solicitado';
    	$mensagem_cliente->conteudo     	= "<h4>Seu Pré-Agendamento:</h4><br><ul><li>Nº do Pedido: $nr_pedido</li><li>Especialidade/exame: $nome_especialidade</li><li>Dr(a): $nome_profissional</li><li>Data: $data_agendamento</li><li>Horário: $hora_agendamento (por ordem de chegada)</li><li>Endereço: $endereco_agendamento</li></ul>";
    	$mensagem_cliente->save();
    	
    	$destinatario                      = new MensagemDestinatario();
    	$destinatario->tipo_destinatario   = 'PC';
    	$destinatario->mensagem_id         = $mensagem_cliente->id;
    	$destinatario->destinatario_id     = $paciente->user->id;
    	$destinatario->save();
    	 
    	$from = 'contato@doctorhoje.com.br';
    	$to = $email;
    	$subject = 'Pré-Agendamento Solicitado';
    
    	$html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoctorHoje</title>
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
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoctorHoje - Solicitação de agendamento</span></td>
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
                <td width='34'><img src='https://doctorhoje.com.br/libs/home-template/img/email/numero-pedido.png' width='34' height='30' alt=''/></td>
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
                    Em caso de qualquer dúvida, fique à vontade <br>
                    para responder esse e-mail ou
                    nos contatar no <br><br>
                    <a href='mailto:meajuda@doctorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>meajuda@doctorhoje.com.br</a>
                    <br><br>
                    Ou ligue para (61) 3221-5350, o atendimento é de<br>
                    segunda à sexta-feira
                    das 8h00 às 18h00. <br><br>
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
