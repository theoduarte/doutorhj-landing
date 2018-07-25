<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Checkup extends Model
{
	
	use Sortable;
	
    public $fillable    = ['id', 'titulo', 'vl_total_com', 'vl_total_net', 'cs_status', 'tipo'];
    public $sortable  	= ['id', 'titulo', 'vl_total_com', 'vl_total_net', 'cs_status', 'tipo'];

    const ATIVO = 'A';
    const INATIVO = 'I';
    
    public function itemcheckups(){
    	return $this->hasMany('App\ItemCheckup');
    }
    
    public function agendamentos(){
    	return $this->hasMany('App\Agendamento');
    }
}
