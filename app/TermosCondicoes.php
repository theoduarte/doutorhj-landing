<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TermosCondicoes extends Model
{
    protected $fillable = ['dt_inicial', 'dt_final', 'ds_termo'];

    public function setDtInicialAttribute($value)
    {
        if (empty($value)){
            return;
        }
        
        $this->attributes['dt_inicial'] = Carbon::createFromFormat('d/m/Y', $value)->toDatetimeString();
    }

    public function setDtFinalAttribute($value)
    {
        if (empty($value)){
            return;
        }
        
        $this->attributes['dt_final'] = Carbon::createFromFormat('d/m/Y', $value)->toDatetimeString();
    }

    public function getDtInicialAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDtFinalAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }


    public function getActual(){
        return $this->whereRaw( "'" . Carbon::now()->toDateTimeString() . "' between dt_inicial and dt_final")->first();
    }

    public function getByAuth(){
        $result = DB::select("  SELECT *
                                  FROM TERMOS_CONDICOES TC
                                 WHERE ID = (SELECT TERMO_CONDICAO_ID
                                          FROM TERMOS_CONDICOES_USUARIOS
                                         WHERE ID = (SELECT MAX(ID) ID
                                                       FROM TERMOS_CONDICOES_USUARIOS
                                                      WHERE USER_ID = ?) );", [Auth::user()->id] );
        return !empty($result) ? $result[0] : $this->getActual();
    }
}