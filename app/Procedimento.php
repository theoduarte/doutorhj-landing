<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Procedimento extends Model
{
	use Sortable;
	
	public $fillable = ['cd_procedimento', 'ds_procedimento', 'tipoatendimento_id', 'grupoprocedimento_id'];
    public $sortable = ['id', 'cd_procedimento', 'ds_procedimento', 'tipoatendimento_id', 'grupoprocedimento_id'];

    private static $_tipoAtendimentoExameProcedimento = [3,4];
    
    private static $_tipoAtendimentoOdonto = [2];
    
    public function tipoatendimento()
    {
        return $this->belongsTo('App\TipoAtendimento');
    }
    
    public function grupoprocedimento()
    {
    	return $this->belongsTo('App\GrupoProcedimento');
    }
    
    public function atendimentos()
    {
        return $this->hasMany('App\Atendimento');
    }
    
    public function tag_populars()
    {
    	return $this->hasMany('App\TagPopular');
    }
    
    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidade');
    }
    
    public function cupom_descontos()
    {
        return $this->belongsToMany('App\CupomDesconto');
    }

    public function getActiveExameProcedimento(){
        // DB::enableQueryLog();
        $query = DB::table('procedimentos')
            ->select( DB::raw("COALESCE(tag_populars.cs_tag, atendimentos.ds_preco, procedimentos.ds_procedimento) descricao, 
                atendimentos.id id, 'exame' tipo, procedimentos.id codigo") )
            ->distinct()
            ->join('atendimentos', function ($join) {
                $join->on('procedimentos.id', '=', 'atendimentos.procedimento_id')
                ->where('atendimentos.cs_status', '=', 'A');
            })
            ->join('clinicas', 'clinicas.id', '=', 'atendimentos.clinica_id')
            ->leftJoin('tag_populars', function($query) { $query->on('tag_populars.procedimento_id', '=', 'procedimentos.id');})
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('filials')
                      ->whereRaw("filials.clinica_id = clinicas.id AND cs_status = 'A'");
            })
            ->where('atendimentos.cs_status', 'A')
            ->whereIn('procedimentos.tipoatendimento_id', self::$_tipoAtendimentoExameProcedimento)
            ->get();

        // dd( DB::getQueryLog() );
        return $query;
    } 

    public function getActiveOdonto(){
        // DB::enableQueryLog();
        $query = DB::table('procedimentos')
            ->select( DB::raw("COALESCE(tag_populars.cs_tag, atendimentos.ds_preco, procedimentos.ds_procedimento) descricao, 
                atendimentos.id id, 'exame' tipo, procedimentos.id codigo") )
            ->distinct()
            ->join('atendimentos', function ($join) {
                $join->on('procedimentos.id', '=', 'atendimentos.procedimento_id')
                ->where('atendimentos.cs_status', '=', 'A');
            })
            ->join('clinicas', 'clinicas.id', '=', 'atendimentos.clinica_id')
            ->leftJoin('tag_populars', function($query) { $query->on('tag_populars.procedimento_id', '=', 'procedimentos.id');})
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('filials')
                      ->whereRaw("filials.clinica_id = clinicas.id AND cs_status = 'A'");
            })
            ->where('atendimentos.cs_status', 'A')
            ->whereIn('procedimentos.tipoatendimento_id', self::$_tipoAtendimentoOdonto)
            ->get();

        // dd( DB::getQueryLog() );
        return $query;
    } 
    
}