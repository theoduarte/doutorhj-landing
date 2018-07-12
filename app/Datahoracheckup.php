<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Datahoracheckup extends Model
{
	
	use Sortable;
	
	public $fillable  = ['id', 'dt_atendimento', 'agendamento_id', 'dt_atendimento'];
	public $sortable  = ['id', 'dt_atendimento', 'agendamento_id', 'dt_atendimento'];
    
	public function itemcheckup(){
		return $this->belongsTo('App\ItemCheckup');
	}
	
	public function agendamento(){
		return $this->belongsTo('App\Agendamento');
	}
}
