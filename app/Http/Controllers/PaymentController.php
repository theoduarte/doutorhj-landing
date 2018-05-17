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
         
        for ($i = 0; $i < sizeof($agendamentos); $i++) {
        	 
        	$item_agendamento = json_decode($agendamentos[$i]);
        	
        	$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($item_agendamento->dt_atendimento.":00")))->get();
        	
        	if (sizeof($agendamento) > 0) {
        		$agendamento_disponivel = false;
        	}
        }
         
        if (!$agendamento_disponivel) {
        	return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.']);
        }
        
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
        	
        		for ($i = 2; $i <= 3; $i++) {
        			$item_valor =  $valor_parcelamento/$i;
        			$valor_parcelamento[$i] = "$ix R$ ".number_format( $item_valor,  2, ',', '.');
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
            return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
        }
        
        //-- pedido id do DoctorHoje----------------------------------
        $MerchantOrderId = $pedido->id;
        
        //-- dados do comprador---------------------------------------
        $customer = Paciente::findorfail($paciente_id);
        $customer->load('user');
        $customer->load('documentos');
        
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
        $payment_return_url             = CVXRequest::root().'/concluir_pedido'; //-- usado no pagamento por debito apenas
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
        	$payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"Authenticate":'.$payment_authenticate.',"ReturnUrl":"'.$payment_return_url.'","DebitCard":{"CardNumber":"'.$payment_credicard_number.'","Holder":"'.$payment_holder.'","ExpirationDate":"'.$payment_expiration_date.'","SecurityCode":"'.$payment_security_code.'","Brand":"'.$payment_brand.'"}}}';
        }
        
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
                    	}
                    }
                }
                
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
            $pagamento->crc_holder 				= $cielo_result->Payment->CreditCard->Holder;
            $pagamento->crc_expiration_date 	= $cielo_result->Payment->CreditCard->ExpirationDate;
            $pagamento->crc_save_card			= $cielo_result->Payment->CreditCard->SaveCard;
            $pagamento->crc_brand 				= $cielo_result->Payment->CreditCard->Brand;
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
            	$dbc_response->proof_of_sale 		= isset($cielo_result->Payment->ProofOfSale) ? $cielo_result->Payment->ProofOfSale : '';
            	$dbc_response->authorization_code 	= isset($cielo_result->Payment->AuthorizationCode) ? $cielo_result->Payment->AuthorizationCode : '';
            	$dbc_response->soft_descriptor 		= $cielo_result->Payment->SoftDescriptor;
            	$dbc_response->crc_status 			= $cielo_result->Payment->Status;
            	$dbc_response->return_code 			= $cielo_result->Payment->ReturnCode;
            	$dbc_response->return_message 		= $cielo_result->Payment->ReturnMessage;
            	$dbc_response->payment_id 			= $pagamento->id;
            
            	$dbc_response->save();
            }
            
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
    	
    	for ($i = 0; $i < sizeof($agendamentos); $i++) {
    	
    		$item_agendamento = json_decode($agendamentos[$i]);
    		
    		$agendamento = Agendamento::where('clinica_id', '=', $item_agendamento->clinica_id)->where('profissional_id', $item_agendamento->profissional_id)->where('dt_atendimento', '=', date('Y-m-d H:i:s', strtotime($item_agendamento->dt_atendimento.":00")))->get();
    		
    		if (sizeof($agendamento) > 0) {
    			$agendamento_disponivel = false;
    		}
    	}
    	
    	if (!$agendamento_disponivel) {
        	return response()->json(['status' => false, 'mensagem' => 'O seu Agendamento não foi realizado, pois um dos horários escolhidos não estão disponíveis. Por favor, tente novamente.']);
        }
    
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
    
    	$customer_name                  = $customer->nm_primario.' '.$customer->nm_secundario; //-- usado no pagamento por debito tambem
    	$customer_identity              = $customer->documentos->first()->te_documento;
    	$customer_Identity_type         = $customer->documentos->first()->tp_documento;
    	$customer_email                 = $customer->user->email;
    	$customer_birthdate             = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", $customer->dt_nascimento);
    
    	$payment_type                   = 'CreditCard'; //-- usado no pagamento por credito apenas, no tipo pagamento, SaveCard
    	$payment_amount                 = ($valor_total-$valor_desconto)*100;
    	$payment_currency               = 'BRL';
    	$payment_country                = 'BRA';
    	
    	$payment_installments           = 1;
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
    				
    			}
    
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
}
