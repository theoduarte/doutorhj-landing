<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemCheckup extends Model
{
	use Sortable;
	
    public $fillable 	= ['id', 'cs_status', 'num_etapa', 'checkup_id', 'atendimento_id', 'vl_mercado', 'vl_com_checkup', 'vl_net_checkup'];
    public $sortable  	= ['id', 'cs_status', 'num_etapa', 'checkup_id', 'atendimento_id', 'vl_mercado', 'vl_com_checkup', 'vl_net_checkup'];
    
    const ATIVO = 'A';
    const INATIVO = 'I';
    
    public function itemcheckup(){
        return $this->belongsTo('App\Checkup');
    }
    
    public function atendimento(){
        return $this->belongsTo('App\Atendimento');
    }
    
    public function datahoracheckups()
    {
    	return $this->hasMany('App\Datahoracheckup');
    }
}
