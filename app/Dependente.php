<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Dependente extends Model
{
	use Sortable;
	
	public $fillable      = ['id', 'nm_primario', 'nm_secundario', 'cs_sexo', 'dt_nascimento', 'parentesto', 'paciente_id', 'documento_id'];
	public $sortable      = ['id', 'nm_primario', 'nm_secundario', 'cs_sexo', 'dt_nascimento', 'parentesto'];
	public $dates 	      = ['dt_nascimento'];
	
	public function paciente(){
		return $this->belongsTo('App\Paciente');
	}
	
	public function documento(){
		return $this->belongsTo('App\Documento');
	}
}
