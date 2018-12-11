<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
	public $fillable   = ['tp_contato', 'ds_contato'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function pacientes()
	{
		return $this->belongsToMany('App\Paciente');
	}
}