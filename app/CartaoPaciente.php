<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CartaoPaciente extends Model
{
	use Sortable;
	
	public $fillable      = ['id', 'bandeira', 'nome_impresso', 'numero', 'ano_vencimento', 'mes_vencimento', 'codigo_seg', 'paciente_id', 'card_token'];
	public $sortable      = ['id', 'bandeira', 'nome_impresso', 'numero', 'paciente_id'];
	
	public function paciente(){
		return $this->belongsTo('App\Paciente');
	}
	
	public function pedidos()
	{
		return $this->hasMany('App\Pedido');
	}
}
