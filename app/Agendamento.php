<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Carbon;

class Agendamento extends Model
{
    use Sortable;
    
    public $fillable  = ['id', 'te_ticket', 'dt_consulta1', 'dt_consulta2', 'dt_consulta3', 'obs_agendamento', 
                         'obs_cancelamento', 'profissional_id', 'paciente_id', 'clinica_id', 'dt_atendimento', 'cs_status'];
    
    public $sortable  = ['id', 'te_ticket', 'dt_consulta1', 'dt_consulta2', 'dt_consulta3', 'dt_atendimento', 'cs_status'];
    
    public $dates 	  = ['dt_atendimento', 'dt_consulta1', 'dt_consulta2', 'dt_consulta3'];
    
    
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }
    
    public function clinica()
    {
        return $this->belongsTo('App\Clinica');
    }
    
    public function profissional()
    {
        return $this->belongsTo('App\Profissional');
    }
    
    public function atendimento()
    {
        return $this->belongsTo('App\Atendimento');
    }
    
    public function itempedidos()
    {
        return $this->hasMany('App\ItemPedido');
    }
    
    public function getDtConsultaPrimariaAttribute()
    {
        $date = new Carbon($this->attributes['dt_consulta_primaria']);
        return $date->format('d/m/Y g:i A');
    }
}