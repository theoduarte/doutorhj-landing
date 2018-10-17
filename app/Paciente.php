<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $user_id
 * @property int $cargo_id
 * @property int $responsavel_id
 * @property int $empresa_id
 * @property string $nm_primario
 * @property string $nm_secundario
 * @property string $cs_sexo
 * @property string $dt_nascimento
 * @property string $access_token
 * @property string $time_to_live
 * @property string $created_at
 * @property string $updated_at
 * @property string $parentesco
 * @property string $cs_status
 * @property string $mundipagg_token
 * @property Cargo $cargo
 * @property Paciente $paciente
 * @property User $user
 * @property Empresa $empresa
 * @property Contato[] $contatos
 * @property Endereco[] $enderecos
 * @property Pedido[] $pedidos
 * @property Agendamento[] $agendamentos
 * @property Documento[] $documentos
 * @property CartaoPaciente[] $cartaoPacientes
 * @property VigenciaPaciente[] $vigenciaPacientes
 * @property Voucher[] $vouchers
 * @property Campanha[] $campanhas
 *
 * @property Plano $plano_ativo
 * @property float $vl_max_consumo
 * @property float $vl_consumido
 * @property float $saldo_empresarial
 */
class Paciente extends Model
{
	use Sortable;
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'cargo_id', 'responsavel_id', 'empresa_id', 'nm_primario', 'nm_secundario', 'cs_sexo', 'dt_nascimento', 'access_token', 'time_to_live', 'created_at', 'updated_at', 'parentesco', 'cs_status', 'mundipagg_token'];

	public $sortable      = ['id', 'nm_primario', 'nm_secundario', 'parentesto' ];
	public $dates 	      = ['dt_nascimento'];

	protected $hidden = ['access_token', 'time_to_live', 'mundipagg_token'];
	protected $appends = ['plano_ativo', 'vl_max_consumo', 'vl_consumido', 'saldo_empresarial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente', 'responsavel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contatos()
    {
        return $this->belongsToMany('App\Contato');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enderecos()
    {
        return $this->belongsToMany('App\Endereco');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany('App\Pedido');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendamentos()
    {
        return $this->hasMany('App\Agendamento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documentos()
    {
        return $this->belongsToMany('App\Documento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartaoPacientes()
    {
        return $this->hasMany('App\CartaoPaciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vigenciaPacientes()
    {
        return $this->hasMany('App\VigenciaPaciente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campanhas()
    {
        return $this->belongsToMany('App\Campanha', 'campanha_clinica');
    }

	public function setDtNascimentoAttribute($data)
	{
		$date = new Carbon($data);
		$date->format('Y-m-d H:i:s');

		$this->attributes['dt_nascimento'] = $date;
	}

	public function getDtNascimentoAttribute()
	{
		$date = new Carbon($this->attributes['dt_nascimento']);
		return $date->format('d/m/Y');
	}

	public function getPlanoAtivoAttribute()
	{
		return Plano::findOrFail($this->getPlanoAtivo($this->attributes['id'])); //some logic to return numbers
	}

	public function getVlMaxConsumoAttribute()
	{
		return $this->getVlMaxConsumo($this->attributes['id']);
	}

	public function getVlConsumidoAttribute()
	{
		return $this->getVlConsumido($this->attributes['id']);
	}

	public function getSaldoEmpresarialAttribute()
	{
		return $this->getSaldoEmpresarial($this->attributes['id']);
	}

	public static function getPlanoAtivo($paciente_id = null)
	{
		if(is_null($paciente_id)) {
			return Plano::OPEN;
		}

		$vigenciaPac = VigenciaPaciente::where(['paciente_id' => $paciente_id, 'cobertura_ativa' => true])
			->where('data_inicio', '<=', date('Y-m-d'))
			->where('data_fim', '>=', date('Y-m-d'))->first();

		if(is_null($vigenciaPac)) {
			return Plano::OPEN;
		} else {
			return $vigenciaPac->plano_id;
		}
	}

	public static function getVlMaxConsumo($paciente_id)
	{
		$vigenciaPac = VigenciaPaciente::where(['paciente_id' => $paciente_id, 'cobertura_ativa' => true])
			->where('data_inicio', '<=', date('Y-m-d'))
			->where('data_fim', '>=', date('Y-m-d'))->first();

		if(!is_null($vigenciaPac) && !is_null($vigenciaPac->paciente->empresa_id)) {
			if(!empty(intval($vigenciaPac->vl_max_consumo))) {
				return intval($vigenciaPac->vl_max_consumo);
			} else {
				return intval($vigenciaPac->paciente->empresa->vl_max_funcionario);
			}
		} else {
			return 0;
		}
	}

	public static function getVlConsumido($paciente_id)
	{
		$paciente = Paciente::findOrFail($paciente_id);

		if($paciente->agendamentos()->get()->count() == 0) {
			return 0;
		}

		$firstDay = date('Y-m-01');
		$lastDay = date('Y-m-t');

		$pedido = Pedido::where('paciente_id', $paciente->id)
			->whereHas('cartao_paciente', function($query) {
				$query->where('tp_cartao_id', TipoCartao::EMPRESARIAL);
			})
			->whereBetween('dt_pagamento', array($firstDay, $lastDay))
			->with(['cartao_paciente', 'itempedidos'])
			->get();
            
           
		$vlConsumido = Itempedido::where('pedido_id', $pedido->pluck('id')->toArray())
			->select(DB::raw('SUM(valor) as vl_consumido'))
			->first();

		if(is_null($vlConsumido)) {
			return 0;
		} else {
			return intval($vlConsumido->vl_consumido);
		}
	}

	public static function getSaldoEmpresarial($paciente_id)
	{
		$saldo = self::getVlMaxConsumo($paciente_id) - self::getVlConsumido($paciente_id);

		if($saldo < 0) {
			return 0;
		} else {
			return intval($saldo);
		}
	}
}
