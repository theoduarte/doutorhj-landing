<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{	  
	public $fillable   = ['cd_especialidade', 'ds_especialidade'];
	
	public function profissionals(){
	    return $this->belongsToMany('App\Profissional');
	}

	public function getNomeEspecialidade($agendamento_id)
	{
		$agendamento = Agendamento::find($agendamento_id);

		//--busca pelas especialidades do atendimento--------------------------------------
		$especialidades = [];
		$ds_atendimento = "";

		if(!is_null($agendamento->atendimento_id)) {
			if(!is_null($agendamento->profissional_id)) {
				$agendamento->profissional->load('especialidades');

				foreach ($agendamento->profissional->especialidades as $especialidade) {
					$especialidades[] = $especialidade->ds_especialidade;
				}
			}

			if(!is_null($agendamento->atendimento->consulta_id)) {
				$agendamento->atendimento->load('consulta');
				$agendamento->atendimento->consulta->load('tag_populars');

				if(!is_null($agendamento->atendimento->consulta->tag_populars->first())) {
					$ds_atendimento = $agendamento->atendimento->consulta->tag_populars->first()->cs_tag;
				}
			} elseif(!is_null($agendamento->atendimento->procedimento_id)) {
				$agendamento->atendimento->load('procedimento');
				$agendamento->atendimento->procedimento->load('tag_populars');

				$especialidades[] = $agendamento->atendimento->procedimento->ds_procedimento;
				if(!is_null($agendamento->atendimento->procedimento->tag_populars->first())) {
					$ds_atendimento = $agendamento->atendimento->procedimento->tag_populars->first()->cs_tag;
				}
			}
		} else {
			return [
				'ds_atendimento' => '',
				'nome_especialidades' => ''
			];
		}


		return [
			'ds_atendimento' => $ds_atendimento,
			'nome_especialidades' => implode(' | ', $especialidades)
		];
	}
}
