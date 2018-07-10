<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * @author Frederico Cruz <frederico.cruz@comvex.com.br>
 * 
 */
class CheckupController extends Controller
{
    /**
     * Consulta lista de check-ups ativos para a busca de landing.
     * 
     * @return Collection
     */
    public function getTituloCheckupAtivo(){
        return DB::table('checkups')
                 ->select(['checkups.titulo'])
                 ->distinct()
                 ->where('checkups.cs_status', \App\Checkup::ATIVO)
                 ->orderBy('checkups.titulo', 'asc')
                 ->get();
    }
    
    /**
     * Consulta tipos de check-up em função do título.
     * 
     * @param string $titulo
     * @return Collection
     */
    public function getTipoCheckupAtivo($titulo){
        return DB::table('checkups')
                 ->select('checkups.tipo')
                 ->where('checkups.cs_status', \App\Checkup::ATIVO)
                 ->distinct()
                 ->where(DB::Raw('to_str(checkups.titulo)'), UtilController::toStr($titulo))
                 ->get();
    }
    
    public function resultadoCheckup()
    {
        return view('checkup.resultado');
    }

    public function carrinhoCheckup()
    {
        return view('checkup.carrinho');
    }
    
    public function pagamentoCheckup()
    {
        return view('checkup.pagamento');
    }

    public function confirmacaoCheckup()
    {
        return view('checkup.confirmacao');
    }
}