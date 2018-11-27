<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $agendamento_id
 * @property int $pedido_id
 * @property float $valor
 * @property string $created_at
 * @property string $updated_at
 * @property Agendamento $agendamento
 * @property Pedido $pedido
 */
class Itempedido extends Model
{
    use Sortable;
    
    public $fillable  = ['id', 'valor', 'pedido_id', 'agendamento_id'];
    public $sortable  = ['id', 'valor'];
    
    public function agendamento()
    {
        return $this->belongsTo('App\Agendamento');
    }
    
    public function pedido()
    {
        return $this->belongsTo('App\Pedido');
    }
    
    public function getVlItempedido()
    {
        return number_format( $this->attributes['valor'],  2, ',', '.');
    }
}
