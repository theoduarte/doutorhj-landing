<?php

namespace App\Http\Controllers;

use App\CupomDesconto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use Illuminate\Support\Facades\Auth;
use App\Agendamento;

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

    public function validarCupomCartao(Request $request) {

		$cartao = CVXRequest::post('cartao');
		$cupom = CVXRequest::post('cupom');
		$ct_date = date('Y-m-d H:i:s');

		if((strcmp($cartao,$cupom ) ==0)){
			$cupomDesconto = CupomDesconto::where('codigo', '=', ($cartao) )
				->where('codigo', '=',trim( $cupom))
				->where('cs_status', '=', 'A')
				->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))
				->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->first();

			return response()->json(['status' => true, 'mensagem' => $cupomDesconto->titulo ]);
		}else{
			$verificaCupom = CupomDesconto::where('codigo', '=', ($cupom) )
				->where('cs_status', '=', 'A')
				->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))
				->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->first();
			if(!empty($verificaCupom)){
				$cliente = false;
				if(strcmp($verificaCupom->titulo, "Cliente Caixa")==0){
					$cliente=true;
				}else{
					$cliente=false;
				}

				$verificaCupomCartao = CupomDesconto::where('codigo', '=',trim($cartao) )
					->where('cs_status', '=', 'A')
					->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))
					->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->first();


				if($cliente && empty($verificaCupomCartao) ){
					return response()->json(['status' => false,'cliente' =>true, 'cartao'=>false,   'mensagem' => 'Observamos que você ativou um cupom 
					'.$verificaCupom->titulo.', más não informou o cartão do banco fidelizado. Para finalizar o pagamento utilizando o desconto, informe um cartao '.$verificaCupom->titulo.' ou prossiga com pagamento sem o desconto aplicado.']);
				}
				// se  o cupom e o inicio do cartao nao forem iguais, más são cliente caixa retorna true
				if($cliente && !empty($verificaCupomCartao)){
					return response()->json(['status' => true, 'mensagem' => $verificaCupom->titulo ]);
				}
			}
			return response()->json(['status' => null,'cliente' =>null, 'cartao'=>null, 'cupom' => $verificaCupom]);


		}
	}
    /**
     * validarCupomDesconto a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validarCupomDesconto(Request $request)
    {
        $codCupomDesconto = CVXRequest::post('codigo');
        $cupomDesconto = [];
        
        if ( empty( trim($codCupomDesconto) ) ) {
            return response()->json(['status' => false, 'mensagem' => 'Informe o CUPOM DE DESCONTO.']);
        }
        
        $ct_date = date('Y-m-d H:i:s');

        $cupomDesconto = CupomDesconto::where('codigo', '=', $codCupomDesconto)
			->where('cs_status', '=', 'A')
			->whereDate('dt_inicio', '<=', date('Y-m-d H:i:s', strtotime($ct_date)))
			->whereDate('dt_fim', '>=', date('Y-m-d H:i:s', strtotime($ct_date)))->first();

        if( empty($cupomDesconto) ) {
            return response()->json(['status' => false, 'mensagem' => 'CUPOM DE DESCONTO informado, não foi encontrado.']);
        }
        
        $user_session = Auth::user();
        $paciente_id = $user_session->paciente->id;
        $cupom_id = $cupomDesconto->id;

        $agendamentoCupom = Agendamento::where('paciente_id', '=', $paciente_id)->where('cupom_id', '=', $cupom_id)->first();

        if( !empty($agendamentoCupom) ) {
            return response()->json(['status' => false, 'mensagem' => 'O CUPOM DE DESCONTO informado, já foi utilizado por você em um outro Agendamento e não está mais disponível.']);
        }
        
        $percentual = $cupomDesconto->percentual/100;
        
        //--realiza o desconto nos parcelamentos--------
        
        $valorTotal            = CVXCart::getTotal();
        $valorParcelamento     = CVXRequest::post('valor_parcelamento') != null && CVXRequest::post('valor_parcelamento') != '' ? floatval(CVXRequest::post('valor_parcelamento'))*(1 - $percentual) : CVXRequest::post('valor_parcelamento');
        

        $parcelamentos = [];
        
        if ($valorTotal > 200) {
            for ($i = 1; $i <= 5; $i++) {
                $item_valor =  $valorParcelamento/$i;

                if ($i <= 3) {
                    $parcelamentos[] = "$i"."x R$ ".number_format( $item_valor,  2, ',', '.').' sem juros';
                } elseif ($i > 3) {
                    $parcelamentos[] = "$i"."x R$ ".number_format( $item_valor*1.05,  2, ',', '.').' com juros (5% a.m.)';
                }
            }
        }
        else {
            $parcelamentos[] = '1x R$ '.number_format( $valorParcelamento,  2, ',', '.').' sem juros';
        }

        // dd($parcelamentos);
        
        $resumo_parcelamento = $parcelamentos[ count($parcelamentos)-1 ];        
                
        return response()->json(['status' => true, 'mensagem' => 'O Cupom foi encontrado com sucesso!', 'percentual' => $percentual, 'resumo_parcelamento' => $resumo_parcelamento, 'parcelamentos' => $parcelamentos]);
    }
}
