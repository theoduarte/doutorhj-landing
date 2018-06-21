<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resultadoCheckup()
    {
        return view('checkup.index');
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
