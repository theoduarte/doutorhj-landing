<?php

namespace App\Http\Controllers;

use App\CupomDesconto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;

class CupomDescontoController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 		$action = Route::current();
        // 		$action_name = $action->action['as'];
        
        // 		$this->middleware("cvx:$action_name");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \App\CupomDesconto  $cupomDesconto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CupomDesconto  $cupomDesconto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CupomDesconto  $cupomDesconto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CupomDesconto  $cupomDesconto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    
    /**
     * validarCupomDesconto a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validarCupomDesconto(Request $request)
    {
        $cod_cupom_desconto = CVXRequest::post('codigo');
        $cupom_desconto = [];
        
        if ($cod_cupom_desconto == '') {
            return false;
        }
        
        $ct_date = date('Y-m-d H:i:s');
        
        $cupom_desconto = CupomDesconto::where('codigo', '=', $cod_cupom_desconto)->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->get();
        
        if(sizeof($cupom_desconto) <= 0) {
            return response()->json(['status' => false, 'mensagem' => 'CUPOM DE DESCONTO informado, não foi encontrado.']);
        }
        
        $percentual = $cupom_desconto->first()->percentual/100;
        
        //--realiza o desconto nos parcelamentos--------
        
        $valor_total            = CVXCart::getTotal();
        $valor_parcelamento     = CVXRequest::post('valor_parcelamento') != null && CVXRequest::post('valor_parcelamento') != '' ? floatval(CVXRequest::post('valor_parcelamento'))*(1 - $percentual) : CVXRequest::post('valor_parcelamento');
        
        $parcelamentos = [];
        $parcelamentos = array(
            0 => '1x R$ '.number_format( $valor_parcelamento,  2, ',', '.').' sem juros'
        );
        
        if ($valor_total > 200) {
            
            for ($i = 1; $i < 5; $i++) {
                $item_valor =  $valor_parcelamento/$i;
                
                if ($i <= 3) {
                    $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor,  2, ',', '.').' sem juros';
                } elseif ($i > 3) {
                    $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor*1.0129,  2, ',', '.').' com juros (1,29% a.m.)';
                }
            }
        }
        
//         $parcelamentos[1] = "2"."x R$ ".number_format( $valor_parcelamento,  2, ',', '.').' sem juros';
//         $parcelamentos[2] = "3"."x R$ ".number_format( $valor_parcelamento,  2, ',', '.').' sem juros';

        
        $resumo_parcelamento = $parcelamentos[sizeof($parcelamentos)-1];
                
        return response()->json(['status' => true, 'mensagem' => 'O Cupom foi encontrado com sucesso!', 'percentual' => $percentual, 'resumo_parcelamento' => $resumo_parcelamento, 'parcelamentos' => $parcelamentos]);
    }
}
