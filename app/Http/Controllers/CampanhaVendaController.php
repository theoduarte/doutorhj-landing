<?php

namespace App\Http\Controllers;

use App\CampanhaVenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Http\Requests\CampanhaRequest;
use App\Empresa;
use Illuminate\Support\Facades\DB;
use App\Campanha;
use App\Anuidade;
use App\Paciente;
use App\User;
use MundiAPILib\MundiAPIClient;
use App\FuncoesPagamento;
use App\VigenciaPaciente;
use App\Documento;
use App\Contato;
use App\TermosCondicoes;
use App\TermosCondicoesUsuarios;

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
    public function registrarCampanha(CampanhaRequest $request)
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
			# realiza a busca pela campanha
			$campanha_id = $request->input('a7cadgygey6yp3uc');
			$campanha = CampanhaVenda::with('empresa', 'plano')->where(['id' => $campanha_id])->first();
			
			# realiza a busca pela anuidade vigencia
// 			DB::enableQueryLog();
			$anuidade = Anuidade::where(['empresa_id' => $campanha->empresa_id, 'plano_id' => $campanha->plano_id, 'cs_status' => 'A'])->whereDate('data_inicio', '<=', date('Y-m-d H:i:s'))->whereDate('data_fim', '>=', date('Y-m-d H:i:s'))->whereNull('deleted_at')->first();
// 			dd( DB::getQueryLog() );
			
			if(is_null($anuidade)) {
				DB::rollback();
				return redirect()->route('landing-page')->with('error-alert', 'Esta Campanha ('.$campanha->url_param.') não está vigente ou está inativa!');
			}

    		# dados de acesso do usuário paciente
    		//     		DB::enableQueryLog();
    		$usuario = User::where(['email' => $request->input('email'), 'cs_status' => 'A'])->first();
    		//     		dd( DB::getQueryLog() );
    		$user_id = 0;
    
    		if(is_null($usuario)) {
    			$usuario  = new User();
    			$usuario->cs_status = 'I';
    		} else {
    			$user_id = $usuario->id;
    		}
    		//     		dd($usuario);
    
    		$usuario->name      		= $request->input('nm_primario').' '.$request->input('nm_secundario');
    		$usuario->email     		= $request->input('email');
    		$usuario->password  		= bcrypt(UtilController::retiraMascara($request->input('te_documento')).'@paciente');
    		$usuario->access_token		= bcrypt($access_token);
    		$usuario->tp_user   		= 'PAC';
    		$usuario->perfiluser_id 	= 3;
    		$usuario->save();
    		
    		$user_id = $usuario->id;
    		// passa os valores para montar o objeto a ser enviado
    		$resultado = FuncoesPagamento::criarUser($request->input('nm_primario') . ' ' . $request->input('nm_secundario'),  $request->input('email'));
    		 
    		// cria o usuario na mundipagg
    		$userCreate = $client->getCustomers()->createCustomer( $resultado );
    		 
			# dados do paciente
			$paciente = [];
    		if($user_id != 0) {
    			$paciente = Paciente::where(['user_id' => $user_id])->first();
    		}
			
			if(is_null($paciente)) {
				$paciente = new Paciente();
			}
			$paciente->user_id 		= $user_id;
			$dt_nascimento = $request->input('ano_nascimento').'-'.$request->input('mes_nascimento').'-'.$request->input('dia_nascimento');
    		//     		dd($paciente);
    		$paciente->nm_primario      = $request->input('nm_primario');
    		$paciente->nm_secundario    = $request->input('nm_secundario');
    		$paciente->cs_sexo     		= $request->input('cs_sexo');
			$paciente->dt_nascimento 	= $dt_nascimento;

			if(is_null($paciente->empresa_id)) {
				$paciente->empresa_id = $campanha->empresa_id;
			}
			
    		$paciente->access_token    	= $access_token;
    		$paciente->time_to_live    	= date('Y-m-d H:i:s', strtotime($time_to_live . '+2 hour'));
    		$paciente->mundipagg_token  = $userCreate->id; // armazena o mundipagg_token do usuario criado
    		//dd($usuario);
    		$paciente->save();
    		 
    		############# coloca vigencia no cliente da campanha ##############
    		$vigencia = VigenciaPaciente::where(['paciente_id' => $paciente->id, 'anuidade_id' => $anuidade->id])->first();
    		
    		if (!is_null($vigencia)) {
    			DB::rollback();	
    			return redirect()->route('campanha', ['url_param' => $campanha->url_param])->with('info-alert', 'Você já faz parte da Campanha: '.$campanha->url_param.'!');
    		}
    		
    		$vigencia 					= new VigenciaPaciente();
    		$vigencia->data_inicio 		= date('Y-m-d');
    		$vigencia->data_fim 		= date('Y-m-d');
    		$vigencia->cobertura_ativa 	= true;
    		$vigencia->vl_max_consumo	= 0;
    		$vigencia->paciente_id 		= $paciente->id;
    		$vigencia->anuidade_id 		= $anuidade->id;
    		$vigencia->save();
    
    		# cpf do paciente
    		$documento = Documento::with(['pacientes'])->where(['te_documento' => UtilController::retiraMascara($request->input('te_documento'))])->first();
    		//     		dd($paciente);
    		if (empty($documento)) {
    			$documento = new Documento();
    		}
    
    		$documento->tp_documento 	= 'CPF';
    		$documento->te_documento 	= UtilController::retiraMascara($request->input('te_documento'));
    		$documento->save();
    		$documento_ids = [$documento->id];
    
    		#################################################################
    
    		# contato do paciente
    		$contato1 = Contato::with(['pacientes'])->where(['ds_contato' => $request->input('ds_contato')])->first();
    
    		if (empty($contato1)) {
    			$contato1 = new Contato();
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
    		$termosCondicoesUsuarios->user_id = $user_id;
    		$termosCondicoesUsuarios->termo_condicao_id = $termosCondicoesActual->id;
    		$termosCondicoesUsuarios->save();
    		 
    		//$send_message = $this->enviaEmailAtivacaoCaixa($paciente);
    
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    
    	########### FINISHIING TRANSACTION ##########
    	DB::commit();
    	#############################################
    	 
    	//     	return view('oferta-certa-caixa', compact('access_token'));
    	return redirect()->route('landing-page')->with('success-alert', 'Seu cadastro na Campanha ('.$campanha->url_param.') foi realizada com sucesso!');
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
