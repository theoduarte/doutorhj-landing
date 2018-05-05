<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use App\Pedido;
use App\Agendamento;
use App\Paciente;

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
    
    /**
     * realiza o pagamento na Cielo no padrão completo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fullTransaction(Request $request)
    {
        $merchantKey    = env('CIELO_MERCHANT_ID_DESENV');
        $merchantId     = env('CIELO_MERCHANT_KEY_DESENV');
        $url            = env('CIELO_URL_DESENV');
        
        $tp_pagamento = CVXRequest::post('tipo_pagamento');
        
        $valor_total = CVXCart::getTotal();
        $valor_desconto = 10;
        
        //-- determina o numero de parcelas -------
        $valor_parcelamento = $valor_total-$valor_desconto;
        $parcelamentos = array(
            1 => '1x R$ '.number_format( $valor_parcelamento,  2, ',', '.')
        );
        
        if ($valor_total > 200) {
            $parcelamentos = [];
            
            for ($i = 2; $i <= 3; $i++) {
                $item_valor =  $valor_parcelamento/$i;
                $valor_parcelamento[$i] = "$ix R$ ".number_format( $item_valor,  2, ',', '.');
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
        
        $customer_name                  = $customer->nm_primario.' '.$customer->nm_secundario;
        $customer_identity              = $customer->documentos->first()->te_documento;
        $customer_Identity_type         = $customer->documentos->first()->tp_documento;
        $customer_email                 = $customer->user->email;
        $customer_birthdate             = $customer->dt_nascimento;
        
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
        
        $payment_type                   = $tp_pagamento == 'credito' ? 'CreditCard' : 'DebitCard';
        $payment_amount                 = ($valor_total-$valor_desconto)*100;
        $payment_currency               = 'BRL';
        $payment_country                = 'BRA';
        $payment_serv_taxa              = 0;
        $payment_installments           = sizeof($parcelamentos);
        $payment_interest               = "ByMerchant";
        $payment_capture                = true;
        $payment_authenticate           = false;
        $payment_softdescriptor         = 'doctorhoje';
        $payment_credicard_number       = CVXRequest::post('num_cartao_credito');
        $payment_holder                 = CVXRequest::post('nome_impresso_cartao_credito');
        $payment_expiration_date        = CVXRequest::post('mes_cartao_credito').'/'.CVXRequest::post('ano_cartao_credito');
        $payment_security_code          = CVXRequest::post('cod_seg_cartao_credito');
        $payment_save_card              = CVXRequest::post('gravar_cartao_credito');
        $payment_brand                  = CVXRequest::post('bandeira_cartao_credito');
        
        $payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'","Identity":"'.$customer_identity.'","IdentityType":"'.$customer_Identity_type.'","Email":"'.$customer_email.'","Birthdate":"'.$customer_birthdate.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"ServiceTaxAmount":'.$payment_serv_taxa.', "Installments":'.$payment_installments.',"Interest":"'.$payment_interest.'","Capture":'.$payment_capture.',"Authenticate":'.$payment_authenticate.',"SoftDescriptor":"'.$payment_softdescriptor.'","CreditCard":{"CardNumber":"'.$payment_credicard_number.'","Holder":"'.$payment_holder.'","ExpirationDate":"'.$payment_expiration_date.'","SecurityCode":"'.$payment_security_code.'","SaveCard":"'.$payment_save_card.'","Brand":"'.$payment_brand.'"}}}';
        
        //dd($payload);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'MerchantId: '.$merchantId, 'MerchantKey: '.$merchantKey));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($httpcode == 200) {
            
            $agendamentos = json_decode(CVXRequest::post('agendamentos'));
            
            for ($i = 0; $i < sizeof($agendamentos); $i++) {
                
                $agendamento = new Agendamento();
                
                $agendamento->te_ticket         = UtilController::getAccessToken();
                $agendamento->cs_status         = 10;
                $agendamento->dt_atendimento    = $agendamentos[$i]['dt_atendimento'];
                $agendamento->bo_remarcacao     = 'N';
                $agendamento->bo_retorno        = 'N';
                $agendamento->paciente_id       = $agendamentos[$i]['paciente_id'];
                $agendamento->clinica_id        = $agendamentos[$i]['clinica_id'];
                $agendamento->atendimento_id    = $agendamentos[$i]['atendimento_id'];
                $agendamento->profissional_id    = $agendamentos[$i]['profissional_id'];
                
                if ($agendamento->save()) {
                    $agendamento_id = $agendamento->id;
                }
                
            }
            
            return response()->json(['status' => true, 'mensagem' => 'O Pedido foi realizado com sucesso!', 'pagamento' => $output]);
        }
        
        return response()->json(['status' => false, 'mensagem' => 'O Pedido não foi salvo. Por favor, tente novamente.']);
    }
}
