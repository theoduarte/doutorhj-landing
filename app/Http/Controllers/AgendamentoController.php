<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Agendamento;
use App\Clinica;
use App\Profissional;
use App\Estado;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agenda = Agendamento::where(function($query){}
        
                                       )->orderBy('dt_atendimento')
                                        ->sortable()->paginate(20);
        
        $agenda->load(['Clinica'=>function($query){
//             $idClinica = (int)Request::input('clinica_id');
//             if(!empty($idClinica)) { $query->findorfail( 10 ); }
        }]);
            
        $agenda->load(['Paciente'=>function($query){
//             $paciente = Request::input('nm_paciente');
            
//             if(!empty($paciente)){
//                 $query->where(DB::raw('to_str(CONCAT(nm_primario, nm_secundario)) as nome'),
//                     'like', '%'.UtilController::toStr($paciente).'%');
//             }
        }]);
        
        $agenda->load('Profissional');
        
        Request::flash();
        
        return view('agenda.index', compact('agenda'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idAgenda)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idAgenda)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idAgenda)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAgenda)
    {
        
    }
    
    /**
     * Realiza o agendamento de um usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agendarAtendimento(Request $request)
    {
    	$agendamento = Agendamento::create($request->all());
    	 
    	$agendamento->save();
    	 
    	return redirect()->route('resultado')->with('success', 'O Agendamento foi realizado com sucesso!');
    }
    
    /**
     * Consulta para alimentar autocomplete
     * 
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocalAtendimento($consulta){
        $arJson = array();
        $consultas = Clinica::where(DB::raw('to_str(nm_razao_social)'), 
                                            'like', '%'.UtilController::toStr($consulta).'%')->get();
        $consultas->load('documentos');
        
        foreach ($consultas as $query)
        {
            $nrDocumento = null;
            foreach($query->documentos as $objDocumento){
                if( $objDocumento->tp_documento == 'CNPJ' ){
                    $nrDocumento = $objDocumento->te_documento;
                }
            }
            
            $teDocumento = (!empty($nrDocumento)) ? ' - CNPJ: ' . UtilController::formataCnpj($nrDocumento) : null;
            $arJson[] = [ 'id' => $query->id, 'value' => $query->nm_razao_social . $teDocumento];
        }
        
        return Response()->json($arJson);
    }
    
    /**
     * Consulta para alimentar autocomplete
     * 
     * @param string $consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfissional($profissional){
        $arJson = array();
        $profissional = Profissional::where(function($query){
//                         dd(Request::all());
                # $query->where(DB::raw('to_str(CONCAT(nm_primario, nm_secundario))'),'like', '%'.UtilController::toStr($profissional).'%');
            
            
                                                })->get();
        $profissional->load('documentos');
        
        foreach ($profissional as $query)
        {
            foreach($query->documentos as $objDocumento){
                if( $objDocumento->tp_documento == 'CRM' or 
                        $objDocumento->tp_documento == 'CRO' ){
                    
                    $estado = Estado::findorfail((int)$objDocumento->estado_id);
                    $teDocumento = $objDocumento->te_documento.' '.$objDocumento->tp_documento.'/'.$estado->sg_estado;
                }
            }
            
            $arJson[] = [ 'id' => $query->id, 'value' => $query->nm_primario.' '.$query->nm_secundario. ' '. $teDocumento];
        }
        
        return Response()->json($arJson);
    }
}