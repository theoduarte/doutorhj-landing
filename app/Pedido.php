<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $cartao_id
 * @property int $paciente_id
 * @property string $titulo
 * @property string $descricao
 * @property string $dt_pagamento
 * @property string $tp_pagamento
 * @property int $boleto_id
 * @property string $created_at
 * @property string $updated_at
 * @property CartaoPaciente $cartao_paciente
 * @property Paciente $paciente
 * @property Itempedido[] $itempedidos
 * @property Payment[] $pagamentos
 */
class Pedido extends Model
{
	use Sortable;
	
	public $fillable = ['titulo', 'descricao', 'dt_pagamento', 'tp_pagamento', 'boleto_id'];
	public $sortable = ['id', 'titulo', 'descricao', 'dt_pagamento', 'tp_pagamento', 'boleto_id'];
	
	public function paciente()
	{
		return $this->belongsTo('App\Paciente');
	}
	
	public function cartao_paciente()
	{
		return $this->belongsTo('App\CartaoPaciente', 'cartao_id');
	}
	
	public function itempedidos()
	{
		return $this->hasMany('App\Itempedido');
	}
	
	public function pagamentos()
	{
		return $this->hasMany('App\Payment');
	}
}
