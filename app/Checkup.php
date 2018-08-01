<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Checkup extends Model
{
	
	use Sortable;
	
    public $fillable    = ['id', 'titulo', 'vl_total_com', 'vl_total_net', 'cs_status', 'tipo'];
    public $sortable  	= ['id', 'titulo', 'vl_total_com', 'vl_total_net', 'cs_status', 'tipo'];

    const ATIVO = 'A';
    const INATIVO = 'I';
    
    public function itemcheckups(){
    	return $this->hasMany('App\ItemCheckup');
    }
    
    public function agendamentos(){
    	return $this->hasMany('App\Agendamento');
    }

    public function getActive() {
        return $this->where('cs_status', 'A')->get();
    }

    public function getSummary( $checkupId ) {
        return DB::select(" SELECT CK.ID, TP.DS_ATENDIMENTO, E.DS_ESPECIALIDADE ESPECIALIDADE, COUNT(1) QTY
                              FROM CHECKUPS CK
                              JOIN ITEM_CHECKUPS ICK ON (CK.ID = ICK.CHECKUP_ID)
                              JOIN ATENDIMENTOS AT ON (ICK.ATENDIMENTO_ID = AT.ID)
                              JOIN CONSULTAS C ON (AT.CONSULTA_ID = C.ID)
                              JOIN ESPECIALIDADES E ON (C.ESPECIALIDADE_ID = E.ID)
                              JOIN TIPOATENDIMENTOS TP ON (C.TIPOATENDIMENTO_ID = TP.ID)
                              WHERE CK.ID = ?
                              GROUP BY CK.ID, TP.DS_ATENDIMENTO, E.DS_ESPECIALIDADE
                            UNION
                            SELECT CK.ID, TP.DS_ATENDIMENTO, GP.DS_GRUPO ESPECIALIDADE, COUNT(1) QTY
                              FROM CHECKUPS CK
                              JOIN ITEM_CHECKUPS ICK ON (CK.ID = ICK.CHECKUP_ID)
                              JOIN ATENDIMENTOS AT ON (ICK.ATENDIMENTO_ID = AT.ID)
                              JOIN PROCEDIMENTOS P ON (AT.PROCEDIMENTO_ID = P.ID)
                              JOIN GRUPO_PROCEDIMENTOS GP ON (P.GRUPOPROCEDIMENTO_ID = GP.ID)
                              JOIN TIPOATENDIMENTOS TP ON (P.TIPOATENDIMENTO_ID = TP.ID)
                              WHERE CK.ID = ?
                              GROUP BY CK.ID, TP.DS_ATENDIMENTO, GP.DS_GRUPO", [$checkupId,$checkupId] );
    }
}
