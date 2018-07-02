<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCheckup extends Model
{
    public $fillable = ['cs_status', 'num_etapa', 'checkup_id', 'atendimento_id', 'vl_mercado'];
    
    const ATIVO = 'A';
    const INATIVO = 'I';
    
    public function itemcheckup(){
        return $this->belongsTo('App\ItemCheckup');
    }
    
    public function agendamento(){
        return $this->belongsTo('App\Agendamento');
    }
}
