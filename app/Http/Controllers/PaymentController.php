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
    
    public function fullTransactionDoctorhj(Request $request)
    {
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
    
    public function fullTransactionTeste(Request $request)
    {
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
    
    /**
     * realiza o pagamento na Cielo no padrão completo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fullTransaction(Request $request)
    {
        $merchantKey    = env('CIELO_MERCHANT_KEY_DESENV');
        $merchantId     = env('CIELO_MERCHANT_ID_DESENV');
        $url            = env('CIELO_URL_DESENV').'/1/sales';
        
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
        
        $payment_type                   = $tp_pagamento == 'credito' ? 'CreditCard' : 'DebitCard';
        $payment_amount                 = ($valor_total-$valor_desconto)*100;
        $payment_currency               = 'BRL';
        $payment_country                = 'BRA';
        $payment_serv_taxa              = 0;
        $payment_installments           = sizeof($parcelamentos);
        $payment_interest               = "ByMerchant";
        $payment_capture                = 'true';
        $payment_authenticate           = 'false';
        $payment_softdescriptor         = 'doctorhoje';
        $payment_credicard_number       = CVXRequest::post('num_cartao_credito');
        $payment_holder                 = CVXRequest::post('nome_impresso_cartao_credito');
        $payment_expiration_date        = CVXRequest::post('mes_cartao_credito').'/'.CVXRequest::post('ano_cartao_credito');
        $payment_security_code          = CVXRequest::post('cod_seg_cartao_credito');
        $payment_save_card              = CVXRequest::post('gravar_cartao_credito') == 'on' ? 'true' : 'false';
        $payment_brand                  = CVXRequest::post('bandeira_cartao_credito');
        
        $payload = '{"MerchantOrderId":"'.$MerchantOrderId.'", "Customer":{"Name":"'.$customer_name.'","Identity":"'.$customer_identity.'","IdentityType":"'.$customer_Identity_type.'","Email":"'.$customer_email.'","Birthdate":"'.$customer_birthdate.'"},"Payment":{"Type":"'.$payment_type.'","Amount":'.$payment_amount.',"ServiceTaxAmount":'.$payment_serv_taxa.', "Installments":'.$payment_installments.',"Interest":"'.$payment_interest.'","Capture":'.$payment_capture.',"Authenticate":'.$payment_authenticate.',"SoftDescriptor":"'.$payment_softdescriptor.'","CreditCard":{"CardNumber":"'.$payment_credicard_number.'","Holder":"'.$payment_holder.'","ExpirationDate":"'.$payment_expiration_date.'","SecurityCode":"'.$payment_security_code.'","SaveCard":'.$payment_save_card.',"Brand":"'.$payment_brand.'"}}}';
        
        //dd($payload);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'MerchantId: '.$merchantId, 'MerchantKey: '.$merchantKey));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //dd($httpcode);
        if ($httpcode == 201) {
            
            $result_agendamentos = [];
            $agendamentos = CVXRequest::post('agendamentos');
            
            for ($i = 0; $i < sizeof($agendamentos); $i++) {
                
                $item_agendamento = json_decode($agendamentos[$i]);
                //dd($item_agendamento);
                $agendamento = new Agendamento();
                
                $agendamento->te_ticket         = UtilController::getAccessToken();
                $agendamento->cs_status         = 10;
                $agendamento->dt_atendimento    = $item_agendamento->dt_atendimento;
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
                    
                    $item_pedido->valor     = $agendamento->atendimento->vl_com_atendimento;
                    $item_pedido->pedido_id = $MerchantOrderId;
                    $item_pedido->agendamento_id = $agendamento_id;
                    
                    if(!$item_pedido->save()) {
                        echo "<script>console.log( 'Debug Objects: item do pedido ($MerchantOrderId) não foi salvo. Por favor, tente novamente.' );</script>";
                    }
                    
                    $agendamento->load('itempedidos');
                    
                    array_push($result_agendamentos, $agendamento);
                }
                
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
}
