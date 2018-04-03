<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Tipoatendimento;

class EspecialidadeController extends Controller
{
    
    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaEspecialidades()
    {
        $tipo_atendimento = CVXRequest::get('tipo_atendimento');
        $result = [];
        
        if ($tipo_atendimento == 'saude') {
            $tp_atendimento = Tipoatendimento::where('cd_atendimento', 100)->get();
            
            $tp_atendimento->load('consultas');
            dd($tp_atendimento);
            
            $atendimentos = $tp_atendimento->consultas;
            
            foreach ($atendimentos as $atend) {
                $item = [
                    'codigo' => $atend->cd_consulta,
                    'tipo' => 'consulta',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'odonto') {
            
            $tp_atendimento = Tipoatendimento::where('cd_atendimento', 200)->get();
            $tp_atendimento->load('consultas');
            
            $atendimentos = $tp_atendimento->consultas;
            
            foreach ($atendimentos as $atend) {
                $item = [
                    'codigo' => $atend->cd_consulta,
                    'tipo' => 'consulta',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'exame') {
            
            $tp_atendimento = Tipoatendimento::where('cd_atendimento', 300)->get();
            $tp_atendimento->load('procedimentos');
            
            $atendimentos = $tp_atendimento->procedimentos;
            
            foreach ($atendimentos as $atend) {
                $item = [
                    'codigo' => $atend->cd_consulta,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        } elseif ($tipo_atendimento == 'procedimento') {
            
            $tp_atendimento = Tipoatendimento::where('cd_atendimento', 400)->get();
            $tp_atendimento->load('procedimentos');
            
            $atendimentos = $tp_atendimento->procedimentos;
            
            foreach ($atendimentos as $atend) {
                $item = [
                    'codigo' => $atend->cd_consulta,
                    'tipo' => 'procedimento',
                    'descricao' => $atend->ds_consulta
                ];
                
                array_push($result, $item);
            }
            
        }
        
        return response()->json(['status' => true, 'result' => $result->toJson()]);
    }
}
