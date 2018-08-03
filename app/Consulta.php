<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Consulta extends Model
{
	use Sortable;
	
    public $fillable = ['cd_consulta', 'ds_consulta', 'especialidade_id', 'tipoatendimento_id'];
    public $sortable = ['id', 'cd_consulta', 'ds_consulta', 'especialidade_id', 'tipoatendimento_id'];
	
    public function especialidade()
    {
        return $this->belongsTo('App\Especialidade');
    }
    
    public function tipoatendimento()
    {
    	return $this->belongsTo('App\Tipoatendimento');
    }
    
    public function atendimentos()
    {
    	return $this->hasMany('App\Atendimento');
    }
    
    public function tag_populars()
    {
    	return $this->hasMany('App\TagPopular');
    }

    public function getActive(){
        // DB::enableQueryLog();
        $query = DB::table('consultas')
            ->select( DB::raw("COALESCE(tag_populars.cs_tag, atendimentos.ds_preco, consultas.ds_consulta) descricao, 
                atendimentos.id id, 'exame' tipo, consultas.id codigo") )
            ->distinct()
            ->join('atendimentos', function ($join) {
                $join->on('consultas.id', '=', 'atendimentos.consulta_id')
                ->where('atendimentos.cs_status', '=', 'A');
            })
            ->join('clinicas', 'clinicas.id', '=', 'atendimentos.clinica_id')
            ->leftJoin('tag_populars', function($query) { $query->on('tag_populars.procedimento_id', '=', 'consultas.id');})
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('filials')
                      ->whereRaw("filials.clinica_id = clinicas.id AND cs_status = 'A'");
            })
            ->where('atendimentos.cs_status', 'A')
            ->get();

        // dd( DB::getQueryLog() );
        return $query;
    } 
}