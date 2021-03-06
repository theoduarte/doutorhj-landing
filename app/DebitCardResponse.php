<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DebitCardResponse extends Model
{
	use Sortable;
	
	public $fillable = ['authentication_url', 'tid', 'return_url', 'dbc_status', 'return_code'];
	public $sortable = ['id', 'proof_of_sale', 'tid', 'authorization_code', 'soft_descriptor', 'crc_status', 'return_code', 'return_message'];
	
	public function pagamento()
	{
		return $this->belongsTo('App\Payment');
	}
}
