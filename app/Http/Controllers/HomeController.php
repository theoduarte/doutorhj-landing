<?php

namespace App\Http\Controllers;

use App\TermosCondicoes;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        $termosCondicoes = new TermosCondicoes();
        $termosCondicoesActual = $termosCondicoes->getActual();

        return view( 'terms-and-conditions', ['termosCondicoesActual' => $termosCondicoesActual->ds_termo] );
    }
}
