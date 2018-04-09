<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Tipoatendimento;
use App\Consulta;

class AtendimentoController extends Controller
{
    
    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaAtendimentos()
    {
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $result = [];
        
        if ($tipo_atendimento == 'saude') {
            
            $tp_atendimento = DB::table('consultas')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'consultas.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "100");})
                ->select('consultas.*', 'consultas.id', 'consultas.cd_consulta', 'consultas.ds_consulta')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'consulta',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'odonto') {
            
            $tp_atendimento = DB::table('consultas')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'consultas.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "200");})
                ->select('consultas.*', 'consultas.id', 'consultas.cd_consulta', 'consultas.ds_consulta')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'consulta',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'exame') {
            
            $tp_atendimento = DB::table('procedimentos')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'procedimentos.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "300");})
                ->select('procedimentos.*', 'procedimentos.id', 'procedimentos.cd_procedimento', 'procedimentos.ds_procedimento')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_procedimento
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'procedimento') {
            
            $tp_atendimento = DB::table('procedimentos')
                ->join('tipoatendimentos', function($join1) { $join1->on('tipoatendimentos.id', '=', 'procedimentos.tipoatendimento_id')->where('tipoatendimentos.cd_atendimento', '=', "400");})
                ->select('procedimentos.*', 'procedimentos.id', 'procedimentos.cd_procedimento', 'procedimentos.ds_procedimento')
                ->get();
            
            foreach ($tp_atendimento as $atend) {
                $item = [
                    'id' => $atend->id,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_procedimento
                ];
                
                array_push($result, $item);
            }
            
        }
        
        return view('resultado', compact('result'));
    }
}
