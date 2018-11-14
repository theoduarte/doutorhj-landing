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

    public function getActive($planoId, $uf_localizacao) {
        DB::enableQueryLog();
        $query = DB::table('consultas')
            ->select( DB::raw("COALESCE(tag_populars.cs_tag, atendimentos.ds_preco, consultas.ds_consulta) descricao, 'consulta' tipo, consultas.id") )
            ->distinct()
            ->join('atendimentos', function ($join) {
                $join->on('consultas.id', '=', 'atendimentos.consulta_id')
                	->where('atendimentos.cs_status', '=', 'A');
            })
            ->join('clinicas', 'clinicas.id', '=', 'atendimentos.clinica_id')
            ->join('tag_populars', function($query) { $query->on('tag_populars.consulta_id', '=', 'consultas.id');})
			->join('precos as pr', function($join8) use ($planoId) {
				$join8->on('pr.atendimento_id', '=', 'atendimentos.id')
					->where('pr.cs_status', '=', 'A')
					->where('pr.data_inicio', '<=', date('Y-m-d H:i:s'))
					->where('pr.data_fim', '>=', date('Y-m-d H:i:s'))
					->where(function($query) use ($planoId) {
						$query->where('pr.plano_id', '=', $planoId)
							->orWhere('pr.plano_id', '=', Plano::OPEN);
					});
			})
			->whereExists(function ($query) use ($uf_localizacao) {
                $query->select(DB::raw(1))
                      ->from('filials')
                      ->join('enderecos', function($join1) { $join1->on('filials.endereco_id', '=', 'enderecos.id');})
                      ->join('cidades', function($join2) use ($uf_localizacao) { $join2->on('cidades.id', '=', 'enderecos.cidade_id')->on('cidades.sg_estado', '=', DB::raw("'$uf_localizacao'"));})
                      ->whereRaw("filials.clinica_id = clinicas.id AND filials.cs_status = 'A'");
            })
            ->where('atendimentos.cs_status', 'A')
            ->orderby('descricao', 'asc')
            ->get();
        print_r($query);
        //print_r(DB::getQueryLog() );die;
        dd( DB::getQueryLog() );
        return $query;
    } 


    public function getActiveAddress( $consultaId, $uf_localizacao ){
        
        DB::enableQueryLog();
        $query = DB::select("   select string_agg( CAST(id AS varchar), ',' ) id, string_agg( CAST(filial_id AS varchar), ',' ) filial_id, 
                                       te_bairro, nm_cidade
                                  from (
                                select distinct e.id, e.te_bairro, cd.nm_cidade, f.id filial_id
                                  from filials f
                                  join enderecos e on (f.endereco_id = e.id)
                                  join cidades cd on (e.cidade_id = cd.id AND cd.sg_estado = ".DB::raw("'$uf_localizacao'").")
                                  join clinicas c on (f.clinica_id = c.id)
                                  join atendimentos at on (c.id = at.clinica_id)
                                 where at.cs_status = 'A'
                                   and c.cs_status = 'A'
                                   and at.consulta_id = $consultaId) general
                                 group by te_bairro, nm_cidade
                                 order by te_bairro");
        //dd( DB::getQueryLog() );
        //dd($query);
        return $query;
    }

    public function getActiveAtendimentos( $consultaId, $enderecoIds, $sortItem, $planoId, $uf_localizacao ) {
        DB::enableQueryLog();

        $query = DB::table('atendimentos as at')
			->distinct()
			->selectRaw("at.id, pr.vl_comercial, at.ds_preco, c.id clinica_id, p.id consulta_id, COALESCE(tp.cs_tag, at.ds_preco, p.ds_consulta) tag,".
				"case when f.eh_matriz = 'S' then 'Matriz' else 'Filial' end tipo, e.id endereco_id, e.sg_logradouro,".
				"e.te_endereco, e.nr_logradouro, e.te_bairro, e.nr_cep,".
                "e.nr_latitude_gps, e.nr_longitute_gps, c.id cidade_id, cd.nm_cidade, cd.sg_estado, p.ds_consulta,".
				"c.nm_fantasia, c.tp_prestador, f.eh_matriz, f.nm_nome_fantasia, f.id filial_id,".
				"pf.id profissional_id, pf.nm_primario, pf.nm_secundario")
			->join('consultas as p', 'at.consulta_id', '=', 'p.id')
			->leftJoin('tag_populars as tp', 'p.id', '=', 'tp.consulta_id')
			->join('clinicas as c', 'at.clinica_id', '=', 'c.id')
			->leftJoin('filials as f', 'c.id', '=', 'f.clinica_id')
			->leftJoin('enderecos as e', 'f.endereco_id', '=', 'e.id')
			->join('cidades as cd', function($join9) use ($uf_localizacao) { $join9->where('e.cidade_id', '=', DB::raw('"cd"."id"'))->where('cd.sg_estado', '=', DB::raw("'$uf_localizacao'")); } )
			->join('profissionals as pf', 'at.profissional_id', '=', 'pf.id')
			->join('precos as pr', function($join8) use ($planoId) {
				$join8->where('pr.id', function($query) {
					$query->select('id')
						->from('precos')
						->whereRaw('atendimento_id = at.id')
						->where('cs_status', '=', 'A')
						->where('data_inicio', '<=', date('Y-m-d H:i:s'))
						->where('data_fim', '>=', date('Y-m-d H:i:s'))
						->limit(1);
				});
			})
			->where('at.cs_status', 'A')
			->where('c.cs_status', 'A')
			->where('f.cs_status', 'A')
			->where('pf.cs_status', 'A')
			->where('at.consulta_id', $consultaId);
		
		
//		dd($query->get()->toArray());
		
        if( !empty($enderecoIds) ) {
            $query->whereIn('f.endereco_id', explode(',', $enderecoIds) );
        }

        $query->orderBy('pr.vl_comercial', $sortItem)
			->orderBy('f.eh_matriz', 'desc')
			->orderBy('c.nm_fantasia', 'asc')
			->orderBy('pf.nm_primario', 'asc');
		
		$result = $query->get();
		//dd( DB::getQueryLog() );
		
		return $result;
    }
}