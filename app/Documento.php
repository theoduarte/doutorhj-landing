<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Documento extends Model
{
	use Sortable;

    public $fillable = ['tp_documento', 'te_documento', 'nr_serie', 'dt_expedicao', 'dt_validade', 'sg_orgao_expedidor', 'estado_id'];
    public $sortable = ['tp_documento', 'te_documento'];
	public $dates 	 = ['dt_expedicao', 'dt_validade'];
	public $timestamps = true;

	const TP_CPF 		= 'CPF';
	const TP_RG			= 'RG';
	const TP_CNASC		= 'CNASC';
	const TP_CTPS		= 'CTPS';

	public function estado(){
		return $this->belongsTo('App\Estado'); 
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function pacientes()
	{
		return $this->belongsToMany('App\Paciente');
	}
}