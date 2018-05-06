<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

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
