<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    /**
     * 
     * 
     * @param string $titulo
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getTipoCheckup($titulo){
        $checkup = DB::table('checkups')
                     ->select('checkups.titulo', 'checkups.tipo')
                     ->where('checkups.cs_status', \App\Checkup::ATIVO)
                     ->distinct()
                     ->where(DB::Raw('to_str(checkups.titulo)'), UtilController::toStr($titulo))->get();
        
        return Response()->json($checkup);
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
