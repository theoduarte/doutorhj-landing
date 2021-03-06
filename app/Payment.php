<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Payment extends Model
{
	use Sortable;

	const METODO_CRED_EMP 			= 1;
	const METODO_CRED_EMP_CRED_IND 	= 2;
	const METODO_CRED_IND 			= 3;
	const METODO_BOLETO 			= 4;
	const METODO_TRANSFERENCIA 		= 5;


	public $fillable = ['merchant_order_id', 'paymentId', 'tid', 'recurrent', 'cielo_result', 'payment_type', 'amount', 'currency', 'country', 'service_tax_amount', 'installments', 'interest', 'capture', 'authenticate', 'soft_descriptor', 'crc_card_number', 'crc_holder', 'crc_expiration_date', 'crc_security_code', 'crc_save_card', 'crc_brand', 'dbc_customer_name', 'dbc_card_number', 'dbc_holder', 'dbc_expiration_date', 'dbc_security_code', 'dbc_brand'];
	public $sortable = ['id', 'merchant_order_id', 'paymentId', 'tid', 'recurrent', 'cielo_result', 'payment_type', 'amount', 'currency', 'country', 'service_tax_amount', 'installments', 'interest', 'capture', 'authenticate', 'soft_descriptor', 'crc_card_number', 'crc_holder', 'crc_expiration_date', 'crc_security_code', 'crc_save_card', 'crc_brand', 'dbc_customer_name', 'dbc_card_number', 'dbc_holder', 'dbc_expiration_date', 'dbc_security_code', 'dbc_brand'];
	
	public function pedido()
	{
		return $this->belongsTo('App\Pedido');
	}
	
	public function cartao_creditos()
	{
		return $this->hasMany('App\CreditCardResponse');
	}
	
	public function cartao_debitos()
	{
		return $this->hasMany('App\DebitCardResponse');
	}
	/**
	 * Converte os valores recebidos em reais para centavos
	 */
	public static function convertRealEmCentavos($valor){

		$dado = str_replace(".", "", $valor);

		$dado = str_replace(",", ".", $dado);

		$resultado = $dado*100;
		//echo $resultado; die;
		return (int) $resultado;
	}
}
