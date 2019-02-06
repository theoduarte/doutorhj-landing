<?php

namespace App\Http\Controllers;

use App\CampanhaVenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Empresa;
use Illuminate\Support\Facades\DB;
use App\Campanha;

class CampanhaVendaController extends Controller
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

    public function cadastroCampanha($url_param, $plano = null)
    {
        /*Request::flash();*/
//     	dd($plano);

    	$campanha = CampanhaVenda::with('empresa', 'plano')->where(['url_param' => $url_param, 'cs_status' => 'A'])->whereDate('data_inicio', '<=', date('Y-m-d'))->whereDate('data_fim', '>=', date('Y-m-d'))->first();
    	
    	if(is_null($campanha)) {
    		return redirect()->route('landing-page')->with('error-alert', 'Esta Campanha ('.$url_param.') não está vigente ou está inativa!');
    	}
        
        return view('campanhas.planos', compact('campanha'));
    }

    /**
    * Register in campanha on  a newly external user created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registrarCampanha(Request $request)
    {
    	$access_token = UtilController::getAccessToken();
    	$time_to_live = date('Y-m-d H:i:s');
    
    	$basicAuthUserName = env('MUNDIPAGG_KEY');
    	$basicAuthPassword = "";
    
    	$client = new MundiAPIClient($basicAuthUserName, $basicAuthPassword);
    
    	########### STARTING TRANSACTION ############
    	DB::beginTransaction();
    	#############################################

    	try {
    		# dados de acesso do usuário paciente
    		//     		DB::enableQueryLog();
    		$usuario = User::where(['email' => $request->input('email')])->first();
    		//     		dd( DB::getQueryLog() );
    		$user_id = 0;
    
    		if(is_null($usuario)) {
    			$usuario            	= new User();
    		} else {
    			$user_id = $usuario->id;
    		}
    		//     		dd($usuario);
    
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
    
    		if($user_id != 0) {
    			$paciente = Paciente::where(['user_id' => $user_id])->first();
    		} else {
    			$paciente           	= new Paciente();
    			$paciente->user_id 		= $usuario->id;
    		}
    		//     		dd($paciente);
    		$paciente->nm_primario      = $request->input('nm_primario');
    		$paciente->nm_secundario    = $request->input('nm_secundario');
    		$paciente->cs_sexo     		= $request->input('cs_sexo');
    		$paciente->dt_nascimento 	= preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", CVXRequest::post('dt_nascimento'));
    		$paciente->empresa_id       = 5;
    		$paciente->access_token    	= $access_token;
    		$paciente->time_to_live    	= date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
    		$paciente->mundipagg_token  = $userCreate->id; // armazena o mundipagg_token do usuario criado
    		//dd($usuario);
    		$paciente->save();
    		 
    		############# coloca vigencia no colaborador CAIXA ##############
    		$vigencia 					= new VigenciaPaciente();
    		$vigencia->data_inicio 		= date('Y-m-d', strtotime('2018-12-10'));
    		$vigencia->data_fim 		= date('Y-m-d', strtotime('2019-12-10'));
    		$vigencia->cobertura_ativa 	= true;
    		$vigencia->vl_max_consumo	= 0;
    		$vigencia->paciente_id 		= $paciente->id;
    		$vigencia->anuidade_id 		= 34;
    		$vigencia->save();
    
    		# cpf do paciente
    		$documento = Documento::with(['pacientes'])->where(['te_documento' => UtilController::retiraMascara($request->input('te_documento'))])->first();
    		//     		dd($paciente);
    		if (empty($documento)) {
    			$documento 					= new Documento();
    		} else {
    			//     			if($documento->pacientes->first()->id != $paciente->id) {
    			//     				DB::rollback();
    			//     				return redirect()->route('oferta-certa-caixa')->with('error-alert', 'O Documento que você está tentando usar pertence a outro usuário. Por favor, verifique.');
    			//     			}
    		}
    
    		$documento->tp_documento 	= 'CPF';
    		$documento->te_documento 	= UtilController::retiraMascara($request->input('te_documento'));
    		$documento->save();
    		$documento_ids = [$documento->id];
    
    		#################################################################
    
    		# contato do paciente
    		$contato1 = Contato::with(['pacientes'])->where(['ds_contato' => $request->input('ds_contato')])->first();
    
    		if (empty($contato1)) {
    			$contato1             		= new Contato();
    		} else {
    			//     			if($contato1->pacientes->first()->id != $paciente->id) {
    			//     				DB::rollback();
    			//     				return redirect()->route('oferta-certa-caixa')->with('error-alert', 'O Contato que você está tentando usar pertence a outro usuário. Por favor, verifique.');
    			//     			}
    		}
    
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
    		 
    		$send_message = $this->enviaEmailAtivacaoCaixa($paciente);
    
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    
    	########### FINISHIING TRANSACTION ##########
    	DB::commit();
    	#############################################
    	 
    	//     	return view('oferta-certa-caixa', compact('access_token'));
    	return view('auth.login', compact('access_token'));
    }
}
