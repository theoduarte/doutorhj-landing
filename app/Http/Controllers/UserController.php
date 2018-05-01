<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paciente;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Mail\PacienteSender;
use App\Documento;
use App\Contato;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuariosRequest;

class UserController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Register a newly external user created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UsuariosRequest $request)
    {
    	$access_token = UtilController::getAccessToken();
    	$time_to_live = date('Y-m-d H:i:s');
    	
//     	$encrypted = Crypt::encryptString('5');
    	
//     	$decrypted = Crypt::decryptString($encrypted);
    	
    	# dados de acesso do usuário paciente
    	$usuario            		= new User();
    	$usuario->name      		= $request->input('nm_primario').' '.$request->input('nm_secundario');
    	$usuario->email     		= $request->input('email');
    	$usuario->password  		= bcrypt($access_token);
    	$usuario->tp_user   		= 'PAC';
    	$usuario->cs_status 		= 'I';
    	$usuario->perfiluser_id 	= 3;
    	$usuario->save();
    	
    	# dados do paciente
    	$paciente           		= new Paciente();
    	$paciente->user_id 			= $usuario->id;
    	$paciente->nm_primario      = $request->input('nm_primario');
    	$paciente->nm_secundario    = $request->input('nm_secundario');
    	$paciente->cs_sexo     		= $request->input('cs_sexo');
    	$paciente->dt_nascimento 	= preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", CVXRequest::post('dt_nascimento'));
    	$paciente->access_token    	= $access_token;
    	$paciente->time_to_live    	= date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
    	//dd($usuario);
    	$paciente->save();
    	
    	# cpf do paciente
    	$documento 					= new Documento();
    	$documento->tp_documento 	=  'CPF';
    	$documento->te_documento 	=  UtilController::retiraMascara($request->input('te_documento'));
    	$documento->save();
    	$documento_ids = [$documento->id];
    	
    	# contato do paciente
    	$contato1             		= new Contato();
    	$contato1->tp_contato 		= 'CP';
    	$contato1->ds_contato 		= $request->input('ds_contato');
    	$contato1->save();
    	$contato_ids = [$contato1->id];
    	
    	$paciente = $this->setPacienteRelations($paciente, $documento_ids, $contato_ids);
    	
    	# envia o e-mail de ativação
    	Mail::to($usuario->email)->send(new PacienteSender($paciente));
    	
    	return view('users.register', compact('access_token'));
    }
    
    /**
     * sendToken the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendToken(Request $request)
    {   
        //DB::enableQueryLog();
        $ds_contato = UtilController::retiraMascara(CVXRequest::post('ds_contato'));
        $contato1 = Contato::where(DB::raw("regexp_replace(ds_contato , '[^0-9]*', '', 'g')"), '=', $ds_contato)->get();
        //$query = DB::getQueryLog();
        //print_r($query);
        $contato = $contato1->first();
        $contato_id = $contato->id;
        
        $paciente_temp = Paciente::with('user')
        	->join('contato_paciente', function($join1) { $join1->on('pacientes.id', '=', 'contato_paciente.paciente_id');})
	        ->join('contatos', function($join2) use ($contato_id) { $join2->on('contato_paciente.contato_id', '=', 'contatos.id')->on('contatos.id', '=', DB::raw($contato_id));})
	        ->select('pacientes.*')
	        ->get();
	    
        $user = $paciente_temp->first()->user;
        
        if($user === null) {
            return view('login');
        }
        
        # atualiza o token do paciente
        $paciente = $paciente_temp->first();
        
        $access_token = UtilController::getAccessToken();
        $time_to_live = date('Y-m-d H:i:s');
        
        $paciente->access_token = $access_token;
        $paciente->time_to_live = date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
        $paciente->save();
        
        # realiza a criptografia do token do paciente
        $user->password = bcrypt($access_token);
        $user->save();
        
        $number = UtilController::retiraMascara($contato->ds_contato);
        $remetente = 'DoctorHoje';
        $message = "Seu Novo Token de acesso ao DoctorHoje: $access_token";
        
        UtilController::sendSms($number, $remetente, $message);
    }
    
    //############# PERFORM RELATIONSHIP ##################
    /**
     * Perform relationship.
     *
     * @param  Paciente  $paciente, array $documento_ids, array $documento_ids
     * @return \Illuminate\Http\Response
     */
    private function setPacienteRelations(Paciente $paciente, array $documento_ids, array $contatos_ids)
    {
    	$paciente->documentos()->sync($documento_ids);
    	$paciente->contatos()->sync($contatos_ids);
    
    	return $paciente;
    }
}
