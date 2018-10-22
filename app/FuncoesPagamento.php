<?php

namespace App;

abstract class FuncoesPagamento 
{
	/**
	 * funcao que retorna array com os dados para criacao de usuarios na mundipagg
	 * 
	 */
    public static function criarUser($nome, $emai){
        $payload =  [
            "name"=> $nome,
            "email"=> $emai,
            "code"=> "DOUTOR_HOJE_001",				
            "type"=> "individual",				
            "metadata"=> [
                "company"=> "Doutor Hoje"
                ]
            ];

        return $payload;
    }

	public static function criarResponse() {
		
	}
	public static function criarTokenCartao($numero, $holdername, $mes, $ano, $cvv) {
		$payload = [
			"type"=> "card",
			"card"=> [
			  "number"=> $numero,
			  "holder_name"=> $holdername,
			  "exp_month"=> $mes,
			  "exp_year"=> $ano,
			  "cvv"=>$cvv    
			]
			];

			return $payload;
	}
    public static function criarCartao($nm_cartao, $holdername,  $mes, $ano, $cvv, $bandeira){
		$payload = [
			"number"=> '5339884372690071',
			"holder_name"=> 'testando',			
			"exp_month"=>'02',
			"exp_year"=>'20',
			"cvv"=> '123',
			"brand"=> 'Visa',
			"private_label"=> false,
			"options"=> [
				"verify_card"=> true
			]
			];

		return $payload;
	}

	public static function criarPagamentoCartaoUnico($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao, $metodo,$cvv) {
		if($metodo ==1){
			return self::card($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao, $metodo,$cvv);
		}else{
			return self::token($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao, $metodo);
		}
	}

	public static function criarPagementoEmpresarial($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao ) {
		$payload = [
			"items"=> [
			[
				"amount"=> $valorEmCentavos,
				"description"=> $produtoDescricao,
				"quantity"=> 1
			]
			],
			"customer_id"=> $customerId,
			"payments"=> [[
			"payment_method"=> "credit_card",
			"credit_card"=> [
				"installments"=> $parcelas,
				"statement_descriptor"=> $descricaoFatura,
				"card_id"=>$cartaoid,				 
			]
			]]
		];

  		return $payload; 
	}

	private static function token($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao, $metodo){
		$payload = [
			"items"=> [
			[
				"amount"=> $valorEmCentavos,
				"description"=> $produtoDescricao,
				"quantity"=> 1
			]
			],
			"customer_id"=> $customerId,
			"payments"=> [[
			"payment_method"=> "credit_card",
			"credit_card"=> [
				"installments"=> $parcelas,
				"statement_descriptor"=> $descricaoFatura,
				"card_token" =>$cartaoid
			]
			]]
		];

  		return $payload;
	}

	private static function card($customerId,$valorEmCentavos,  $parcelas, $descricaoFatura, $cartaoid, $produtoDescricao, $metodo,$cvv){
		$payload = [
			"items"=> [
			[
				"amount"=> $valorEmCentavos,
				"description"=> $produtoDescricao,
				"quantity"=> 1
			]
			],
			"customer_id"=> $customerId,
			"payments"=> [[
			"payment_method"=> "credit_card",
			"credit_card"=> [
				"installments"=> $parcelas,
				"statement_descriptor"=> $descricaoFatura,
				"card_id"=>$cartaoid,
				"card"=> [
					"cvv"=> $cvv
				]
			]
			]]
		];

  		return $payload;
	}

	



	public static function pagamentoBoleto($valorEmCentavos,$costumer_id, $numeroBoleto, $instrucoesBoleto ) {
		$payload =[
			"items"=>[
			[
				"amount"=>$valorEmCentavos,
				"description"=>"Doutor Hoje",
				"quantity"=>1
			]
			],
			"customer_id"=>$costumer_id,
			"payments"=>[				
				[
					"amount"=>$valorEmCentavos,
					"payment_method"=>"boleto",
					"boleto"=> [
						"bank"=>  "033" , // tipo string
						"instructions"=>$instrucoesBoleto,
						"due_at"=> "2020-12-31T00:00:00Z"
					]
				]
			]
					];

		return $payload;
	}

	public static function pagamentoMultiMeio($costumer_id, $valorTotalEmCentavos, $descricaoPedidos,$c1_valorCentavos, $c2_valorCentavos, $c1_parcelas, $c2_parcelas, $c1_descricao, $c2_descricao, $c1_card_id, $c2_card_id, $metodo1, $metodo2 ) {

				$payload = 	[
								"items"=>[
								[
									"amount"=>$valorTotalEmCentavos,
									"description"=>$descricaoPedidos,
									"quantity"=>1
								]
								],
								"customer_id"=>$costumer_id,
								"payments"=>[
									[
										"amount"=>$c1_valorCentavos,
										"payment_method"=>"credit_card",
										"credit_card"=>[
											"installments"=> $c1_parcelas,
											"statement_descriptor"=> $c1_descricao,
											$metodo1 ==1?"card_id" :"card_token" =>$c1_card_id
										]
									],
									[
										"amount"=>$c2_valorCentavos,
										"payment_method"=>"credit_card",
										"credit_card"=>[
											"installments"=> $c2_parcelas,
											"statement_descriptor"=> $c2_descricao,
										$metodo2 ==1?"card_id" :"card_token" =>$c2_card_id
										]
									]
								]
						  ];



		return $payload;

	}

	public static function criarTranferencia($valorEmCentavos, $descricao, $customerId) {
		$payload = 
		[
			"items"=>[
			[
				"amount"=>$valorEmCentavos,
				"description"=>$descricao,
				"quantity"=>1
			]
			],
			"customer_id"=>$customerId,
			"payments"=>[				
				[
					"amount"=>$valorEmCentavos,
					"payment_method"=>"bank_transfer",					 
					"bank_transfer"=>[
						"bank"=> "001"
					]
				]
			]
					];
				

			return $payload;
	}

	public static function criarRecebedor() {
		$payload =[
			"name"=> "Tony Stark",
			"email"=> "ssdasdf@mundipagg.com",
			"description"=> "Recebedor tony stark",
			"document"=> "2622445199320",
			"type"=> "individual",
			"default_bank_account"=> [
			  "holder_name"=> "Tony Stark",
			  "holder_type"=> "individual",
			  "holder_document"=> "2622445199320",
			  "bank"=> "033",			  
			  "account_number"=> "252525",			  
			  "type"=> "checking"			  
			]
			];


		return $payload;
	}
	

}
