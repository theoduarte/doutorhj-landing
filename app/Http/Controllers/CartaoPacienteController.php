<?php

namespace App\Http\Controllers;

use App\CartaoPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;

class CartaoPacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartaoPaciente  $cartaoPaciente
     * @return \Illuminate\Http\Response
     */
    public function show(CartaoPaciente $cartaoPaciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartaoPaciente  $cartaoPaciente
     * @return \Illuminate\Http\Response
     */
    public function edit(CartaoPaciente $cartaoPaciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartaoPaciente  $cartaoPaciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartaoPaciente $cartaoPaciente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartaoPaciente  $cartaoPaciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartaoPaciente $cartaoPaciente)
    {
        //
    }
    
    public function consultaCartao()
    {
    	$cartao_id = CVXRequest::post('cartao_id');
    
    	$result = [];
    	
    	if (isset($cartao_id) && $cartao_id != '') {
    		
    		$result = CartaoPaciente::findorfail($cartao_id);
    		
    		return response()->json(['status' => true, 'mensagem' => '', 'cartao' => $result]);
    	}
    
    	return response()->json(['status' => false, 'mensagem' => 'Falha na operação', 'cartao' => $result]);
    }
}
