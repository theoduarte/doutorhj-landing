<?php

namespace App;

use App\Http\Controllers\UtilController;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $plano_id
 * @property int $paciente_id
 * @property string $data_inicio
 * @property string $data_fim
 * @property boolean $cobertura_ativa
 * @property float $vl_max_consumo
 * @property string $created_at
 * @property string $updated_at
 * @property Plano $plano
 * @property Paciente $paciente
 */
class VigenciaPaciente extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['plano_id', 'paciente_id', 'data_inicio', 'data_fim', 'vl_max_consumo', 'cobertura_ativa', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plano()
    {
        return $this->belongsTo('App\Plano');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

	public function setVlMaxConsumoAttribute($value)
	{
		$this->attributes['vl_max_consumo'] = UtilController::removeMaskMoney($value);
	}

	public function getVlMaxConsumoAttribute()
	{
		return number_format( $this->attributes['vl_max_consumo'],  2, ',', '.');
	}
}
