<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $clinica_id
 * @property int $consulta_id
 * @property int $procedimento_id
 * @property int $profissional_id
 * @property string $ds_preco
 * @property string $cs_status
 * @property string $created_at
 * @property string $updated_at
 * @property Clinica $clinica
 * @property Consulta $consulta
 * @property Procedimento $procedimento
 * @property Profissional $profissional
 * @property Preco[] $precos
 * @property AgendamentoAtendimento[] $agendamentoAtendimentos
 * @property Filial[] $filials
 * @property ItemCheckup[] $itemCheckups
 * @property Agendamento[] $agendamentos
 */

class Atendimento extends Model
{
	use Sortable;
	
	public $fillable  = ['id', 'vl_com_atendimento', 'vl_net_atendimento', 'ds_preco'];
	public $sortable  = ['id', 'vl_com_atendimento', 'vl_net_atendimento', 'ds_preco'];

	const ATIVO = 'A';
	const INATIVO = 'I';
	
	public function clinica(){
	    return $this->belongsTo('App\Clinica');
	}
	
	public function consulta(){
	    return $this->belongsTo('App\Consulta');
	}
    
	public function procedimento(){
	    return $this->belongsTo('App\Procedimento');
	}
    
	public function profissional(){
	    return $this->belongsTo('App\Profissional');
	}

	public function agendamentos()
    {
        return $this->belongsToMany('App\Agendamento');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function precos()
	{
		return $this->hasMany('App\Preco')
			->where('cs_status', '=', 'A')
			->where('data_inicio', '<=', date('Y-m-d H:i:s'))
			->where('data_fim', '>=', date('Y-m-d H:i:s'));
	}

	public function precoAtivo()
	{
		return $this->hasOne('App\Preco')
			->where('cs_status', '=', 'A')
			->where('data_inicio', '<=', date('Y-m-d H:i:s'))
			->where('data_fim', '>=', date('Y-m-d H:i:s'));
	}

	public function getPrecoByPlano($plano_id, $atendimento_id = null)
	{
		$atendimento_id = $atendimento_id ?? $this->attributes['id'];

		$preco = Preco::where(['atendimento_id' => $atendimento_id, 'plano_id' => $plano_id, 'cs_status' => 'A'])
			->where('data_inicio', '<=', date('Y-m-d H:i:s'))
			->where('data_fim', '>=', date('Y-m-d H:i:s'))->first();

		return $preco;
	}

	/*public function agendamentos()
	{
	    return $this->hasMany('App\Agendamento');
	}*/
	
	public function getVlAtendimentoAttribute($valor){
	    return number_format( $valor,  2, ',', '.'); 
	}
	
	public function getVlComercialAtendimento()
	{
		return number_format( $this->attributes['vl_comercial'],  2, ',', '.');
	}
	
	public function getVlNetAtendimento()
	{
		return number_format( $this->attributes['vl_net'],  2, ',', '.');
	}
}
