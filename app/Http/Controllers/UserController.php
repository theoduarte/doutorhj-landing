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
use App\TermosCondicoes;
use App\TermosCondicoesUsuarios;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuariosRequest;
use Illuminate\Support\Carbon;
use App\FuncoesPagamento;
use MundiAPILib\MundiAPIClient;

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
        
        $basicAuthUserName = env('MUNDIPAGG_KEY');
		$basicAuthPassword = "";
		
        $client = new MundiAPIClient($basicAuthUserName, $basicAuthPassword);
        
//     	$encrypted = Crypt::encryptString('5');
    	
//     	$decrypted = Crypt::decryptString($encrypted);
    	
    	# dados de acesso do usuário paciente
    	$usuario            		= new User();
    	$usuario->name      		= $request->input('nm_primario').' '.$request->input('nm_secundario');
    	$usuario->email     		= $request->input('email');
    	$usuario->password  		= bcrypt(UtilController::retiraMascara($request->input('te_documento')).'@paciente');
		$usuario->access_token		= bcrypt($access_token);
    	$usuario->tp_user   		= 'PAC';
    	$usuario->cs_status 		= 'I';
    	$usuario->perfiluser_id 	= 3;
    	$usuario->save();

        // passa os valores para montar o objeto a ser enviado
		$resultado = FuncoesPagamento::criarUser($request->input('nm_primario') . ' ' . $request->input('nm_secundario'),  $request->input('email'));

		// cria o usuario na mundipagg
        $userCreate = $client->getCustomers()->createCustomer( $resultado );
            
    	# dados do paciente
    	$paciente           		= new Paciente();
    	$paciente->user_id 			= $usuario->id;
    	$paciente->nm_primario      = $request->input('nm_primario');
    	$paciente->nm_secundario    = $request->input('nm_secundario');
    	$paciente->cs_sexo     		= $request->input('cs_sexo');
    	$paciente->dt_nascimento 	= preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", CVXRequest::post('dt_nascimento'));
    	$paciente->access_token    	= $access_token;
        $paciente->time_to_live    	= date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
        $paciente->mundipagg_token  = $userCreate->id; // armazena o mundipagg_token do usuario criado
    	//dd($usuario);
    	$paciente->save();
    	
    	# cpf do paciente
    	$documento 					= new Documento();
    	$documento->tp_documento 	= 'CPF';
    	$documento->te_documento 	= UtilController::retiraMascara($request->input('te_documento'));
    	$documento->save();
    	$documento_ids = [$documento->id];
    	
    	# contato do paciente
    	$contato1             		= new Contato();
    	$contato1->tp_contato 		= 'CP';
    	$contato1->ds_contato 		= $request->input('ds_contato');
    	$contato1->save();
    	$contato_ids = [$contato1->id];
    	
    	$paciente = $this->setPacienteRelations($paciente, $documento_ids, $contato_ids);

        # vinculação com o termo e condição
        $termosCondicoes = new TermosCondicoes();
        $termosCondicoesActual = $termosCondicoes->getActual();

        $termosCondicoesUsuarios = new TermosCondicoesUsuarios();
        $termosCondicoesUsuarios->user_id = $usuario->id;
        $termosCondicoesUsuarios->termo_condicao_id = $termosCondicoesActual->id;
        $termosCondicoesUsuarios->save();

		$send_message = $this->enviaEmailAtivacao($paciente);

//     	return view('users.register', compact('access_token'));
		return view('auth.login', compact('access_token'));
    }

	public static function enviaEmailAtivacao(Paciente $paciente)
	{
		$usuario = $paciente->user;

		# envia o e-mail de ativação
		//Mail::to($usuario->email)->send(new PacienteSender($paciente));
		//$this->from('administrador@comvex.com.br', 'DoutorHoje')->subject('Contato DoutorHoje')->view('emails.paciente_verificacao_conta')->with(['verify_hash' => Crypt::encryptString($this->paciente->id)])
		$verify_hash = Crypt::encryptString($paciente->id);
		$from = 'contato@doutorhoje.com.br';
		$to = $usuario->email;
		$subject = 'Contato DoutorHoje';

		$paciente_nm_primario = $paciente->nm_primario;
		$paciente_email = $usuario->email;

		$url = route('ativar_conta', $verify_hash);
		//$html_message = "<!DOCTYPE html><html><head><title>DoutorHoje Ativação</title></head><body><h2><a href='$url'>Clique no link aqui para Ativar sua conta DoutorHoje</a></h2></body></html>";
		
		$html_message = view('emails.email_confirma_cadastro', compact('paciente_nm_primario', 'url', 'paciente_email'))->render();

		$html_message = str_replace(array("\r", "\n", "\t"), '', $html_message);

		$send_message = UtilController::sendMail($to, $from, $subject, $html_message);

		return $send_message;
	}

    /**
     * sendTokenEmail a newly external user created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendTokenEmail($access_token, $email_destinatario, $paciente_nm_primario, $data_solicitacao)
    {
        
        $from = 'contato@doutorhoje.com.br';
        $to = $email_destinatario;
        $subject = 'NOVO TOKEN DoutorHoje';
        
        $html_message = view('emails.login_token', compact('access_token', 'email_destinatario', 'paciente_nm_primario', 'data_solicitacao'))->render();
        
        $html_message = str_replace(array("\r", "\n", "\t"), '', $html_message);
        
        $send_message = UtilController::sendMail($to, $from, $subject, $html_message);
        
//         echo "<script>console.log( 'Debug Objects: " . $send_message . "' );</script>";
        
        return $send_message;
    }
    
    /**
     * sendToken the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendToken(Request $request)
    {
        // DB::enableQueryLog();
        $ds_contato = UtilController::retiraMascara(CVXRequest::post('ds_contato'));
        $contato1 = Contato::where(DB::raw("regexp_replace(ds_contato , '[^0-9]*', '', 'g')"), '=', $ds_contato)->get();
        // $query = DB::getQueryLog();
        // print_r($query);
        $contato = $contato1->first();

		if(is_null($contato)) {
			return response()->json(['status' => false, 'mensagem' => 'Telefone não cadastrado.']);
		}

        $contato_id = $contato->id;
        
        $paciente_temp = Paciente::with('user')
        	->join('contato_paciente', function($join1) { $join1->on('pacientes.id', '=', 'contato_paciente.paciente_id');})
	        ->join('contatos', function($join2) use ($contato_id) { $join2->on('contato_paciente.contato_id', '=', 'contatos.id')->on('contatos.id', '=', DB::raw($contato_id));})
	        ->select('pacientes.*')
	        ->get();
	  
        $user_send_token = $paciente_temp->first()->user;
        
        //--quando o usuario tenta logar sem ter se cadastrado
        if($user_send_token === null) {
            return response()->json(['status' => false, 'mensagem' => 'Usuário não foi localizado. Por favor, tente novamente.']);
        }
        
        # atualiza o token do paciente
        $paciente = $paciente_temp->first();
        
        $access_token = UtilController::getAccessToken();
        $time_to_live = date('Y-m-d H:i:s');
        
        $paciente->access_token = $access_token;
        $paciente->time_to_live = date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
       
        $paciente->save();
        
        # realiza a criptografia do token do paciente
        $user_send_token->access_token = bcrypt($access_token);
        
        $user_send_token->save();
        
        $number = UtilController::retiraMascara($contato->ds_contato);
        $remetente = 'DoutorHoje';
        $message = "Seu Novo Token de acesso ao DoutorHoje: $access_token";

        $send_sms_token = UtilController::sendSms($number, $remetente, $message);
        
        //$timestamp = date('Y-m-d H:i:s')->setTimezone('America/Sao_Paulo');
        
        $email_destinatario     = $user_send_token->email;
        $paciente_nm_primario   = $paciente->nm_primario;
        $data_solicitacao       = date('d.m.Y').' às '.date('H:i:s');
        //$data_solicitacao       = date('d.m.Y', strtotime($timestamp)).' às '.date('H:i:s', strtotime($timestamp));
        $send_token_email = $this->sendTokenEmail($access_token, $email_destinatario, $paciente_nm_primario, $data_solicitacao);
        
        if($send_token_email != '1') {
            return response()->json(['status' => false, 'mensagem' => 'Seu TOKEN não foi enviado. Por favor, tente novamente.']);
        }
        
        return response()->json(['status' => true, 'mensagem' => 'Seu TOKEN foi enviado via SMS e também para seu E-mail com sucesso!']);
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
