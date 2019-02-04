<?php

namespace App\Http\Controllers;

use App\Checkup;
use App\ItemCheckup;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PrestadoresRequest;
use App\Http\Requests\EditarPrestadoresRequest;
use Illuminate\Support\Facades\Request as CVXRequest;
use LaravelLegends\PtBrValidator\Validator as CVXValidador;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use App\Clinica;
use App\User;
use App\Cargo;
use App\Cidade;
use App\Profissional;
use App\Atendimento;
use App\Estado;
use App\Especialidade;
use App\Documento;
use App\Contato;
use App\Endereco;
use App\Procedimento;
use App\Responsavel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PacienteSender;
use App\Consulta;
use App\CartaoPaciente;
use App\Paciente;
use App\Filial;
use App\Plano;
use GuzzleHttp\Client;
use App\VigenciaPaciente;
use MundiAPILib\MundiAPIClient;
use App\FuncoesPagamento;
use GuzzleHttp\Psr7\Response;

use App\Http\Requests ;

class ClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	function __construct() {
		if(env('APP_ENV') != 'production') {
			$to = env('API_URL_HOMOLOG') ;
		}else{
			$to = env('API_URL_PROD') ;
		}
		$this->url_api = $to;

	}


    public function cadastroAtivado()
    {
        /*Request::flash();*/
        return view('auth.confirmacao');
    }
    
    public function ofertaCertaCaixa()
    {
    	/*Request::flash();*/
    	return view('oferta-certa-caixa');
    }

    public function avaliaAtendimento()
    {
        /*Request::flash();*/
        return view('avaliacao');
    }

    public function index()
    {
        $prestadores = Clinica::where(function($query){
                                        if(!empty(Request::input('nm_busca'))){
                                            switch (Request::input('tp_filtro')){
                                                case "nm_razao_social" :
                                                    $query->where(DB::raw('to_str(nm_razao_social)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                                                    break;
                                                case "nm_fantasia" :
                                                    $query->where(DB::raw('to_str(nm_fantasia)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                                                    break;
                                                default:
                                                    $query->where(DB::raw('to_str(nm_razao_social)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                                            }
                                        }
                                    })->sortable()->paginate(20);
        $prestadores->load('contatos');
        $prestadores->load('responsavel');

        Request::flash();

        return view('clinicas.index', compact('prestadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::orderBy('ds_estado')->get();
        $cargos  = Cargo::orderBy('ds_cargo')->get(['id', 'ds_cargo']);

        $precoconsultas = null;
        $precoprocedimentos = null;

//         $list_profissionals = Clinica::findorfail($idClinica)->load('profissionals');
        $list_profissionals = [];

        return view('clinicas.create', compact('estados', 'cargos', 'precoprocedimentos', 'precoconsultas', 'list_profissionals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrestadoresRequest $request)
    {
        # dados de acesso do usuário que é o profissional responsável pela empresa
        $usuario            = new User();
        $usuario->name      = $request->input('name_responsavel');
        $usuario->email     = $request->input('email');
        $usuario->password  = bcrypt($request->input('password'));
        $usuario->tp_user   = 'CLI';
        $usuario->cs_status = 'A';
        $usuario->perfiluser_id = 2;
        $usuario->save();


        # documento da empresa CNPJ
        $documentoCnpj      = new Documento();
        $documentoCnpj->tp_documento = 'CNPJ';
        $documentoCnpj->te_documento = UtilController::retiraMascara($request->input('te_documento'));
        $documentoCnpj->save();
        $documento_ids = [$documentoCnpj->id];


        # endereco da empresa
        $endereco           = new Endereco($request->all());
        $cidade             = Cidade::where(['cd_ibge'=>$request->input('cd_cidade_ibge')])->get()->first();
        $endereco->nr_cep = UtilController::retiraMascara($request->input('nr_cep'));
        $endereco->cidade()->associate($cidade);
        $endereco->nr_latitude_gps = $request->input('nr_latitude_gps');
        $endereco->nr_longitute_gps = $request->input('nr_longitute_gps');
        $endereco->save();
        $endereco_ids = [$endereco->id];

        # responsavel pela empresa
        $responsavel      = new Responsavel();
        $responsavel->telefone = $request->input('telefone_responsavel');;
        $responsavel->cpf = UtilController::retiraMascara($request->input('cpf_responsavel'));
        $responsavel->user_id = $usuario->id;
        $responsavel->save();

        # telefones 
        $arContatos = array();

        $contato1             = new Contato();
        $contato1->tp_contato = $request->input('tp_contato1');
        $contato1->ds_contato = $request->input('ds_contato1');
        $contato1->save();
        array_push($arContatos, $contato1->id);

        if(!empty($request->input('ds_contato2'))){
            $contato2             = new Contato();
            $contato2->tp_contato = $request->input('tp_contato2');
            $contato2->ds_contato = $request->input('ds_contato2');
            $contato2->save();
            array_push($arContatos, $contato2->id);
        }

        if(!empty($request->input('ds_contato3'))){
            $contato3             = new \App\Contato();
            $contato3->tp_contato = $request->input('tp_contato3');
            $contato3->ds_contato = $request->input('ds_contato3');
            $contato3->save();
            array_push($arContatos, $contato3->id);
        }

        # clinica
        $clinica = Clinica::create($request->all());
        $clinica->responsavel_id = $responsavel->id;
        $clinica->save();

        $prestador = $this->setClinicaRelations($clinica, $documento_ids, $endereco_ids, $arContatos);

        return redirect()->route('clinicas.index')->with('success', 'O prestador foi cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idClinica)
    {
        $estados = Estado::orderBy('ds_estado')->get();
        $cargos  = Cargo::orderBy('ds_cargo')->get(['id', 'ds_cargo']);


        $prestador = Clinica::findorfail($idClinica);
        $prestador->load('enderecos');
        $prestador->load('contatos');
        $prestador->load('documentos');
        $prestador->load('profissionals');

        $user   = User::findorfail($prestador->responsavel->user_id);
        $cidade = Cidade::findorfail($prestador->enderecos->first()->cidade_id);
        $documentoprofissional = [];

        $precoprocedimentos = Atendimento::where(['clinica_id'=> $idClinica, 'consulta_id'=> null])->get();
        $precoprocedimentos->load('procedimento');

        $precoconsultas = Atendimento::where(['clinica_id'=> $idClinica, 'procedimento_id'=> null])->get();
        $precoconsultas->load('consulta');


        return view('clinicas.show', compact('estados', 'cargos', 'prestador', 'user', 'cargo', 'cidade', 'documentoprofissional', 'precoprocedimentos', 'precoconsultas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idClinica)
    {
        $estados = Estado::orderBy('ds_estado')->get();
        $cargos  = Cargo::orderBy('ds_cargo')->get(['id', 'ds_cargo']);

        $get_term = CVXRequest::get('search_term');
        $search_term = UtilController::toStr($get_term);

        $prestador = Clinica::findorfail($idClinica);
        $prestador->load('enderecos');
        $prestador->load('contatos');
        $prestador->load('documentos');
        //$prestador->load('profissional');


        $documentosclinica = $prestador->documentos;

        $user   = User::findorfail($prestador->responsavel->user_id);
        $precoprocedimentos = Atendimento::where('clinica_id', $idClinica)->where('procedimento_id', '<>', null)->orderBy('ds_preco', 'asc')->get();
        $precoconsultas =     Atendimento::where('clinica_id', $idClinica)->where('consulta_id', '<>', null)->orderBy('ds_preco', 'asc')->get();

        $documentoprofissional = [];

        //$prestador->load('profissionals')->orderBy('updated_at', 'desc');

        if($search_term != '') {
            $list_profissionals = Profissional::where(DB::raw('to_str(nm_primario)'), 'LIKE', '%'.$search_term.'%')->where('clinica_id', $prestador->id)->where('cs_status', '=', 'A')->orderBy('updated_at', 'desc')->get();
        } else {
            $list_profissionals = Profissional::where('clinica_id', $prestador->id)->where('cs_status', '=', 'A')->orderBy('updated_at', 'desc')->get();
        }

        $list_especialidades = Especialidade::orderBy('ds_especialidade', 'asc')->pluck('ds_especialidade', 'id');

        return view('clinicas.edit', compact('estados', 'cargos', 'prestador', 'user',
                                                'documentoprofissional', 'precoprocedimentos',
                                                'precoconsultas', 'documentosclinica', 'list_profissionals', 'list_especialidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditarPrestadoresRequest $request, $idClinica)
    {
        $prestador = Clinica::findOrFail($idClinica);

        $prestador->update($request->all());

        //--atualizar usuário-----------------
        $usuario_id         = CVXRequest::post('responsavel_user_id');
        $usuario            = User::findorfail($usuario_id);
        $usuario->name      = $request->input('name_responsavel');
        $usuario->password  = bcrypt($request->input('password'));
        $usuario->save();

        //--salvar CNPJ------------------------
        $documento_ids = [];
        $cnpj_id = CVXRequest::post('cnpj_id');
        $documento = Documento::findorfail($cnpj_id);
        $documento->tp_documento = CVXRequest::post('tp_documento_'.$cnpj_id);
        $documento->te_documento = UtilController::retiraMascara(CVXRequest::post('te_documento_'.$cnpj_id));
        $documento->save();
        $documento_ids = [$documento->id];

        //--salvar enderecos----------------------
        $endereco_ids = [];
        $endereco_id = CVXRequest::post('endereco_id');
        $endereco = Endereco::findorfail($endereco_id);
        $endereco->nr_cep = UtilController::retiraMascara(CVXRequest::post('nr_cep'));
        $endereco->sg_logradouro = CVXRequest::post('sg_logradouro');
        $endereco->te_endereco = CVXRequest::post('te_endereco');
        $endereco->nr_logradouro = CVXRequest::post('nr_logradouro');
        $endereco->te_complemento = CVXRequest::post('te_complemento');
        $endereco->nr_latitude_gps = CVXRequest::post('nr_latitude_gps');
        $endereco->nr_longitute_gps = CVXRequest::post('nr_longitute_gps');
        $endereco->te_bairro = CVXRequest::post('te_bairro');
        $endereco->te_bairro = CVXRequest::post('te_bairro');
        $endereco->save();
        $endereco_ids = [$endereco->id];

        //--salvar contatos----------------------
        $contato_ids = [];
        $contato_id = CVXRequest::post('contato_id');
        $contato = Contato::findorfail($contato_id);
        $contato->tp_contato = CVXRequest::post('tp_contato_'.$contato_id);
        $contato->ds_contato = CVXRequest::post('ds_contato_'.$contato_id);
        $contato->save();
        $contato_ids = [$contato->id];

        # responsavel pela empresa
        $responsavel_id         = CVXRequest::post('responsavel_id');
        $responsavel            = Responsavel::findorfail($responsavel_id);
        $responsavel->telefone  = $request->input('telefone_responsavel');
        $responsavel->save();

        $prestador = $this->setClinicaRelations($prestador, $documento_ids, $endereco_ids, $contato_ids);
        $prestador->save();
        //$prestador->save();

        return redirect()->route('clinicas.index')->with('success', 'Prestador alterado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idClinica)
    {
        $clinica = Clinica::findorfail($idClinica);
        $clinica->forceDelete();
        $clinica->contatos()->forceDelete();
        $clinica->enderecos()->forceDelete();
        $clinica->documentos()->forceDelete();
        $clinica->user()->forceDelete();
        Atendimento::where('clinica_id', $idClinica)->delete();


        return redirect()->route('clinicas.index')->with('success', 'Clínica excluída com sucesso!');
    }

    /**
     * Consulta para alimentar autocomplete
     *
     * @param string $term
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProcedimentos($termo){
        $arResultado = array();
        $procedimentos = Procedimento::where(DB::raw('to_str(ds_procedimento)'), 'like', '%'.UtilController::toStr($termo).'%')->get();

        foreach ($procedimentos as $query)
        {
            $arResultado[] = [ 'id' =>  $query->id.' | '.$query->cd_procedimento .' | '.$query->ds_procedimento, 'value' => $query->ds_procedimento ];
        }

        return Response()->json($arResultado);
    }

    /**
     * Consulta para alimentar autocomplete
     *
     * @param string $termo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConsultas($termo){
        $arResultado = array();
        $consultas = Consulta::where(DB::raw('to_str(ds_consulta)'), 'like', '%'.UtilController::toStr($termo).'%')->get();

        foreach ($consultas as $query)
        {
            $arResultado[] = [ 'id' => $query->id.' | '.$query->cd_consulta.' | '.$query->ds_consulta, 'value' => $query->ds_consulta ];
        }

        return Response()->json($arResultado);
    }

    //############# PERFORM RELATIONSHIP ##################
    /**
     * Perform relationship.
     *
     * @param  \App\Perfiluser  $perfiluser
     * @return \Illuminate\Http\Response
     */
    private function setClinicaRelations(Clinica $prestador, array $documento_ids, array $endereco_ids, array $contato_ids)
    {
        $prestador->documentos()->sync($documento_ids);
        $prestador->enderecos()->sync($endereco_ids);
        $prestador->contatos()->sync($contato_ids);

        return $prestador;
    }

    /**
     * Perform relationship.
     *
     * @param  \App\Profissional  $profissional
     * @return \Illuminate\Http\Response
     */
    private function setProfissionalRelations(Profissional $profissional, array $documento_ids, array $contatos_ids)
    {
        $profissional->documentos()->sync($documento_ids);
        //$profissional->contatos()->sync($contatos_ids);

        return $profissional;
    }

    //############# AJAX SERVICES ##################
    /**
     * addProfissionalStore a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProfissionalStore(Request $request)
    {
        $clinica_id = CVXRequest::post('clinica_id');
        $clinica = Clinica::findorfail($clinica_id);

        $profissional_id = CVXRequest::post('profissional_id');
        if ($profissional_id != '') {
            $profissional = Profissional::findorfail($profissional_id);
            $profissional->load('documentos');
        }

        if (isset($profissional) && isset($profissional->documentos) && sizeof($profissional->documentos) > 0) {
            $documento_id = $profissional->documentos[0]->id;
            $documento = Documento::findorfail($documento_id);

            $documento->tp_documento = CVXRequest::post('tp_documento');
            $documento->te_documento = CVXRequest::post('te_documento');
            $documento->save();

            $documento_ids = [$documento->id];
        } else {
            $documento = new Documento();
            $documento->tp_documento =  CVXRequest::post('tp_documento');
            $documento->te_documento =  CVXRequest::post('te_documento');
            $documento->save();
            $documento_ids = [$documento->id];
        }

        //         $contato = new Contato();
        //         $contato->save();
        //         $contatos_ids = [$contato->id];
        $contatos_ids = [];

        if (!isset($profissional)) {
            $profissional = new Profissional();
        }
        $profissional->nm_primario = CVXRequest::post('nm_primario');
        $profissional->nm_secundario = CVXRequest::post('nm_secundario');
        $profissional->cs_sexo = CVXRequest::post('cs_sexo');
        $profissional->dt_nascimento = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1", CVXRequest::post('dt_nascimento'));
        $profissional->clinica_id = intval($clinica_id);
        $profissional->especialidade_id = CVXRequest::post('especialidade_id');
        $profissional->tp_profissional = CVXRequest::post('tp_profissional');
        $profissional->cs_status = CVXRequest::post('cs_status');

        if (!$profissional->save()) {
            return response()->json(['status' => false, 'mensagem' => 'O Profissional não foi salvo. Por favor, tente novamente.']);
        }

        $profissional = $this->setProfissionalRelations($profissional, $documento_ids, $contatos_ids);
        $profissional->save();

        $profissional->load('especialidade');

        return response()->json(['status' => true, 'mensagem' => 'O Profissional foi salvo com sucesso!', 'profissional' => $profissional->toJson()]);
    }

    /**
     * viewProfissionalShow a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewProfissionalShow()
    {
        $profissional_id = CVXRequest::post('profissional_id');
        $profissional = Profissional::findorfail($profissional_id);
        $profissional->load('documentos');

        return response()->json(['status' => true, 'mensagem' => '', 'profissional' => $profissional->toJson()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProfissionalDestroy()
    {
        $profissional_id = CVXRequest::post('profissional_id');
        $profissional = Profissional::findorfail($profissional_id);
        $profissional->cs_status = 'I';

        if (!$profissional->save()) {
            return response()->json(['status' => false, 'mensagem' => 'O Profissional não foi removido. Por favor, tente novamente.']);
        }

        return response()->json(['status' => true, 'mensagem' => 'O Profissional foi removido com sucesso!', 'profissional' => $profissional->toJson()]);
    }

    /**
     * addProcedimentoPrecoStore a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProcedimentoPrecoStore(Request $request)
    {
        $atendimento_id = CVXRequest::post('atendimento_id');
        $atendimento = $atendimento_id != '' ? Atendimento::findorfail($atendimento_id) : [];

        $clinica_id = CVXRequest::post('clinica_id');
        $procedimento_id = CVXRequest::post('procedimento_id');
        $ds_procedimento = CVXRequest::post('ds_procedimento');
        $vl_procedimento = CVXRequest::post('vl_procedimento');

        if (sizeof($atendimento) == 0) {
            $atendimento = new Atendimento();
        }
        $atendimento->ds_preco =  $ds_procedimento;
        $atendimento->vl_atendimento = UtilController::moedaBanco($vl_procedimento);
        $atendimento->clinica_id = $clinica_id;
        $atendimento->procedimento_id = $procedimento_id;
        $atendimento->cs_status = 'A';

        if (!$atendimento->save()) {
            return response()->json(['status' => false, 'mensagem' => 'O Procedimento não foi salvo. Por favor, tente novamente.']);
        }

        $atendimento->load('procedimento');

        return response()->json(['status' => true, 'mensagem' => 'O Procedimento foi salvo com sucesso!', 'atendimento' => $atendimento->toJson()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProcedimentoDestroy()
    {
        $atendimento_id = CVXRequest::post('atendimento_id');
        $atendimento = Atendimento::findorfail($atendimento_id);
        $atendimento->cs_status = 'I';

        if (!$atendimento->save()) {
            return response()->json(['status' => false, 'mensagem' => 'O Atendimento não foi removido. Por favor, tente novamente.']);
        }

        return response()->json(['status' => true, 'mensagem' => 'O Atendimento foi removido com sucesso!', 'atendimento' => $atendimento->toJson()]);
    }

    /**
     * addConsultaPrecoStore a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addConsultaPrecoStore(Request $request)
    {
        $atendimento_id = CVXRequest::post('atendimento_id');
        $atendimento = $atendimento_id != '' ? Atendimento::findorfail($atendimento_id) : [];

        $clinica_id = CVXRequest::post('clinica_id');
        $consulta_id = CVXRequest::post('consulta_id');
        $ds_consulta = CVXRequest::post('ds_consulta');
        $vl_consulta = CVXRequest::post('vl_consulta');

        if (sizeof($atendimento) == 0) {
            $atendimento = new Atendimento();
        }
        $atendimento->ds_preco =  $ds_consulta;
        $atendimento->vl_atendimento = UtilController::moedaBanco($vl_consulta);
        $atendimento->clinica_id = $clinica_id;
        $atendimento->consulta_id = $consulta_id;
        $atendimento->cs_status = 'A';

        if (!$atendimento->save()) {
            return response()->json(['status' => false, 'mensagem' => 'A Consulta não foi salva. Por favor, tente novamente.']);
        }

        $atendimento->load('consulta');

        return response()->json(['status' => true, 'mensagem' => 'A Consulta foi salva com sucesso!', 'atendimento' => $atendimento->toJson()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConsultaDestroy()
    {
        $atendimento_id = CVXRequest::post('atendimento_id');
        $atendimento = Atendimento::findorfail($atendimento_id);
        $atendimento->cs_status = 'I';

        if (!$atendimento->save()) {
            return response()->json(['status' => false, 'mensagem' => 'A Consulta não foi removida. Por favor, tente novamente.']);
        }

        return response()->json(['status' => true, 'mensagem' => 'A Consulta foi removida com sucesso!', 'atendimento' => $atendimento->toJson()]);
    }

    //############# PUBLIC SERVICES - NOT AUTHENTICATED ##################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findClinicaSearch()
    {
        $prestadores = Clinica::where(function($query){
            if(!empty(Request::input('nm_busca'))){
                switch (Request::input('tp_filtro')){
                    case "nm_razao_social" :
                        $query->where(DB::raw('to_str(nm_razao_social)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                        break;
                    case "nm_fantasia" :
                        $query->where(DB::raw('to_str(nm_fantasia)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                        break;
                    default:
                        $query->where(DB::raw('to_str(nm_razao_social)'), 'like', '%'.UtilController::toStr(Request::input('nm_busca')).'%');
                }
            }
        })->sortable()->paginate(20);
        $prestadores->load('contatos');
        $prestadores->load('responsavel');

        Request::flash();

        return view('resultado', compact('prestadores'));
    }

    /**
     * paginaPagamento a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginaPagamento() {

    	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	date_default_timezone_set('America/Sao_Paulo');

    	$cartCollection = CVXCart::getContent();
    	$itens = $cartCollection->toArray();


      
    	$carrinho = [];
    	$user_session = Auth::user()->paciente;
    	$url = Request::root();
    	$titulo_pedido = "";
    	$user_session->load('documentos');
        
		$plano_id = Paciente::getPlanoAtivo($user_session->id);
        $endereco_paciente=[];
        if (Auth::check()) {

            $endereco_paciente =[];
            
            $endereco = $user_session->enderecos()->first();

            if(!is_null($endereco) && $endereco->cs_status == Endereco::ATIVO) {
                $cidade = Cidade::where('id',$endereco->cidade_id) ->first();
                array_push($endereco_paciente,$endereco->toArray());
                array_push($endereco_paciente,$cidade->toArray());            
            }
        }
       
    	foreach ($itens as $item) {
			$paciente_tmp_id = $item['attributes']['paciente_id'];
			$paciente = Paciente::findOrFail($paciente_tmp_id);

			if($item['attributes']['tipo_atendimento'] == 'simples') {
				$atendimento_tmp_id = $item['attributes']['atendimento_id'];
				$profissional_tmp_id = $item['attributes']['profissional_id'];
				$clinica_tmp_id = $item['attributes']['clinica_id'];
				$filial_tmp_id = $item['attributes']['filial_id'];

				$atendimento = Atendimento::where(['atendimentos.id' => $atendimento_tmp_id])
					->with(['precoAtivo' => function($query) use($plano_id) {
						$query->where('precos.plano_id', '=', $plano_id);
					}])->first();

				$profissional = isset($profissional_tmp_id) && $profissional_tmp_id != 'null' ? Profissional::findOrFail($profissional_tmp_id) : null;
				$clinica = Clinica::findOrFail($clinica_tmp_id);
				$filial = Filial::findOrFail($filial_tmp_id);

				$url = $item['attributes']['current_url'];

				if ($atendimento->procedimento_id != null) {
					$atendimento->load('procedimento');

					$nome_especialidade = $atendimento->procedimento->ds_procedimento;
					$ds_atendimento = $atendimento->procedimento->tag_populars->first()->cs_tag;

					$atendimento->nome_especialidade = $nome_especialidade;
					$atendimento->ds_atendimento = $ds_atendimento;

					$titulo_pedido = "Exame: " . $user_session->nm_primario . " " . $user_session->nm_secundario;
				}

				if ($atendimento->consulta_id != null) {
					$atendimento->load('consulta');
					$atendimento->load('profissional');
					$atendimento->profissional->load('especialidades');

					$nome_especialidade = "";

					foreach ($atendimento->profissional->especialidades as $especialidade) {
						$nome_especialidade = $nome_especialidade . ' | ' . $especialidade->ds_especialidade;
					}
                    //dd($atendimento->consulta->tag_populars->first()->cs_tag); die;
					$ds_atendimento = $atendimento->consulta->tag_populars->first()->cs_tag;
                    
					$atendimento->nome_especialidade = $nome_especialidade;
					$atendimento->ds_atendimento = $ds_atendimento;


					$titulo_pedido = "Consulta: " . $user_session->nm_primario . " " . $user_session->nm_secundario;
				}

				if (isset($clinica)) {
					$clinica->load('enderecos');
				}

				if (isset($filial)) {
					$filial->load('endereco');
				}

				$data_atendimento = $item['attributes']['data_atendimento'];
				$hora_atendimento = $item['attributes']['hora_atendimento'];

				$item_carrinho = array(
					'item_id' => $item['id'],
					'valor' => $item['price'],
					'atendimento' => $atendimento,
					'profissional' => $profissional,
					'clinica' => $clinica,
					'filial' => $filial,
					'paciente' => $paciente,
					'data_agendamento' => isset($data_atendimento) ? $data_atendimento : null,
					'hora_agendamento' => isset($hora_atendimento) ? $hora_atendimento : null,
					'current_url' => $url
				);
			} elseif($item['attributes']['tipo_atendimento'] == 'checkup') {
				$checkup_tmp_id = $item['attributes']['checkup_id'];

				$carrinhoItensCheckup = $item['attributes']['items_checkup'];

				$checkup = Checkup::findOrFail($checkup_tmp_id);

				$titulo_pedido = "Checkup: " . $user_session->nm_primario . " " . $user_session->nm_secundario;

				$item_checkups = ItemCheckup::query()->where('checkup_id', $checkup_tmp_id)
					->with(['atendimento.consulta', 'atendimento.procedimento', 'atendimento.clinica.enderecos'])
					->select('item_checkups.*')
					->join('atendimentos', 'atendimentos.id', '=', 'item_checkups.atendimento_id')
					->orderByRaw('coalesce(atendimentos.consulta_id, atendimentos.procedimento_id)')
					->get();

				foreach($item_checkups as $itemCheckup) {
					$key = array_search($itemCheckup->id, array_column($carrinhoItensCheckup, 'id'));
					if(!empty($carrinhoItensCheckup[$key]['data_agendamento']) || !empty($carrinhoItensCheckup[$key]['hora_agendamento'])) {
						$dataHoraAgendamento = $carrinhoItensCheckup[$key]['data_agendamento'] . ' ' . $carrinhoItensCheckup[$key]['hora_agendamento'];
						$itemCheckup->dataHoraAgendamento = \DateTime::createFromFormat('d.m.Y H:i', $dataHoraAgendamento)->format('d/m/Y H:i');
					}
				}

				$item_carrinho = [
					'item_id' 				=> $item['id'],
					'valor' 				=> $item['price'],
					'atendimento' 			=> null,
					'profissional' 			=> null,
					'clinica' 				=> null,
					'filial' 				=> null,
					'paciente'				=> $paciente,
					'data_agendamento' 		=> null,
					'hora_agendamento' 		=> null,
					'current_url' 			=> $url,
					'checkup'				=> $checkup,
					'itens_checkup'			=> $item_checkups,
				];
//				dd($item_carrinho);
			}

    		array_push($carrinho, $item_carrinho);
    	}

    	$valor_total = ( CVXCart::getTotal());
    	$valor_desconto = 0;
        $cpf_titular="";
        if(isset($user_session->documentos->first()->te_documento)){
            $cpf_titular = $user_session->documentos->first()->te_documento;
        }
    	

    	$valor_parcelamento = $valor_total-$valor_desconto;
        $parcelamentos = [];
        
    	$parcelamentos = array(
    	    1 => '1x R$ '.number_format( $valor_parcelamento,  2, ',', '.').' sem juros'
    	);

    	if ($valor_total > 200) {

    	    for ($i = 2; $i <= 5; $i++) {
    	        $item_valor =  $valor_parcelamento/$i;
    	        
    	        if ($i <= 3) {
    	            $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor,  2, ',', '.').' sem juros';
    	        } elseif ($i > 3) {
    	            $parcelamentos[$i] = "$i"."x R$ ".number_format( $item_valor*1.05,  2, ',', '.').' com juros (5% a.m.)';
    	        }
    	    }
    	}
    	
    	$cartoes_gravados = CartaoPaciente::where('paciente_id', $user_session->id)->where('cs_status','like','A')->get();


        $plano_paciente = $resultado = Paciente::getPlanoAtivo($user_session->id);
        
    	$responsavel_id = $user_session->id;
    	$pacientes = Paciente::where('responsavel_id', $responsavel_id)->where('cs_status', '=', 'A')->orWhere('id', $responsavel_id)->orderBy('responsavel_id', 'desc')->get();

        if (Auth::check()) {
            $paciente = Auth::user()->paciente;
        }

    	return view('pagamento', compact('url', 'paciente','endereco_paciente', 'user_session','plano_paciente', 'cpf_titular', 'carrinho', 'valor_total', 'valor_desconto', 'titulo_pedido', 'parcelamentos', 'cartoes_gravados', 'pacientes'));
    }

    /*colocar essa rota no local correto*/
    public function contatoHomePublica(){
        return view('mensagems.contato');
    }
    public function planos(){

		try{
			$client = new Client(['timeout'  => 1500,]);

			$response = $client->request('get', $this->url_api.'listar-plano', [
				'headers' => [
					'Authorization'     => env('TOKEN_PAGAMENTO_PRE_AUTORIZAR')
				],
			]);

			$data=$response->getBody()->read(2000000) ;


		}catch (\Exception $ee){}

		$response = json_decode($data, true);
		$planos =[];
		foreach ($response as  $dd){

			foreach ($dd['data'] as $datum) {

				if($datum['name'] == "blue"  ){

					$pp = [
						"nome" => $datum['name'],
						"id" =>$datum['id'],
						"price" =>$datum['minimum_price']
					];
					array_push($planos,$pp);


				}


				if( $datum['name'] =="black"){
					$pp = [
						"nome" => $datum['name'],
						"id" =>$datum['id'],
						"price" => $datum['minimum_price']
					];
					array_push($planos,$pp);
				}
			 }

		}



        return view('planos-individuais.index',["planos" =>  ($planos)]);
    }
    public function planosContratacao( $plano, $identificador, $details, $all){

		$plano = explode("=", $plano);
		$identificador =explode("=", $identificador);
		$details =explode("=", $details);
		$all =explode("=", $all);

		$key = env("TOKEN_PAGAMENTO_PRE_AUTORIZAR");

		$paths = array('values' => $key, "url" => $this->url_api.'gerar-plano-pagamento', "plano" => $plano[1], "idplano" =>$identificador[1] , "detalhes" =>$details[1] , "all" => $all[1]) ;
		return view('planos-individuais.contratacao', $paths);
    }

    public function contratarPlano() {
		$req =  CVXRequest::toArray();

		$usuario = $req['usuario'];;
		$card = $req['card'];
		$corretor = $req['corretor'];
		$dependente = isset($req['dependente']) ? $req['dependente'] : [];


		if(count($dependente)>0){

			$form = [
				'dependente' => json_encode($dependente),
				'cartao' =>json_encode($card),
				'usuario' =>json_encode($usuario),
				'corretor' => $corretor

			];
		}else{
			$form = [
				'cartao' =>json_encode($card),
				'usuario' => json_encode($usuario),
				'corretor' => $corretor
			];
		}


		try{
			$client = new Client(['timeout'  => 1500,]);


			 $client->request('POST','http://192.168.1.87:8080/api/v1/gerar-plano-pagamento', [
				'headers' => [
					'Authorization'     => env('TOKEN_PAGAMENTO_PRE_AUTORIZAR')
				],
				'form_params' =>  ($form)
			]);

			return response()->json([
				'message' => 'Pagamento realizado com sucesso!'
			], 200);
		}catch (\Exception $ee){
			return response()->json([
				'message' => 'Ocorreou um error ao processar o pagamento!',
				'details' =>$ee->getMessage()
			], 500);
		}


	}
    public function confirmaAgendamento(){
        return view('confirmacao');
    }
    public function homePrestador(){
        return view('home-prestador');
    }
    public function confirmaCadastro(){
        return view('confirma-cadastro');
    }
    public function loginPrestador(){
        return view('login-prestador');
    }

    /**
     * removerItemCarrinho the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function removerItemCarrinho()
    {
    	$cart_id = CVXRequest::post('cart_id');

    	if(isset($cart_id)) {
    	    $item = CVXCart::get($cart_id);
			if(!empty($item)) {
				$valor_item = $item->price;

				if (CVXCart::remove($cart_id)) {
					return response()->json(['status' => true, 'mensagem' => 'O Item foi removido com sucesso!', 'valor_item' => $valor_item]);
				}
			}
    	}

    	return response()->json(['status' => false, 'mensagem' => 'O Item não foi removido. Por favor, tente novamente']);
    }
    
    public function homeLogado(){

    	/* $verify_hash = "teste";
    	$from = 'contato@doutorhoje.com.br';
    	$to = 'teocomp@msn.com';
    	$subject = 'Contato DoutorHoje';
    	$url = route('ativar_conta', $verify_hash);
    	$html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head><title>DoutorHoje Ativação</title></head>
    <body>
        <h2><a href='$url'>Clique no link aqui para Ativar sua conta DoutorHoje</a></h2>
    </body>
</html>
HEREDOC;

    	$html_message = str_replace(array("\r", "\n"), '', $html_message);
    	//dd($html_message);

    	$send_message = UtilController::sendMail($to, $from, $subject, $html_message);
    	//dd($send_message);
    	if ($send_message) {
    	    dd('O e-mail foi enviado com sucesso!');
    	    //dd($output);
    	} */

        return view('home-logado');
    }

    public function testeEnviarEmail(){

        $verify_hash = "teste";
         $from = 'contato@doutorhoje.com.br';
         $to = 'teocomp@msn.com';
         $subject = 'Contato DoutorHoje';
         $url = route('ativar_conta', $verify_hash);
         $html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoutorHoje</title>
    </head>
    <body style='margin: 0;'>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'>&nbsp;</td>
                <td width='120' style='text-align:right'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoutorHoje - Confirmação de cadastro</span></td>
                <td width='120' style='text-align:right'><a href='#' target='_blank' style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Abrir no navegador</a></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td><img src='h1.png' width='600' height='113' alt=''/></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px;'><strong>Confirmação de cadastro</strong></td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 28px; line-height: 50px; color: #434342; background-color: #fff; text-align: center;'>
                    Olá, <strong style='color: #1d70b7;'>Thaiane</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
                    <strong>Seja bem-vindo(a)</strong> e obrigado(a) por escolher o Doutor Hoje. Estamos muito felizes em saber que agora você faz parte da melhor plataforma de consultas e exames do Distrito Federal. Nosso objetivo é facilitar sua vida e buscar os melhores serviços de saúde à preços acessíveis. Você pode consultar seus dados cadastrais no nosso site e em breve pelo seu celular no aplicativo Doutor Hoje.
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='220' style='background-color: #fff;'>&nbsp;</td>
                <td width='159' style='text-align: center;'>
                    <img src='devices.png' width='155' height='74' alt=''/>
                </td>
                <td width='221' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='130' style='background-color: #fff;'>&nbsp;</td>
                <td width='340' style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 50px; color: #434342; text-align: center;'>
                    <a href='#' style='color: #ffffff; text-decoration: none;'><strong style='color: #ffffff;'>CLIQUE AQUI PARA ATIVAR SEU CADASTRO</strong></a>
                </td>
                <td width='130' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
                    Seu cadastro foi realizado através do e-mail:
                    <span style='color: #1d70b7;'><strong>thaianepinheiro.1@gmail.com</strong></span><br>
                    <br>
                    Para logar no seu perfil, digite seu e-mail e token recebido por SMS
                    a cada novo acesso.                     
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: center;'>
                    Abraços,<br>
                    Equipe Doutor Hoje                    
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='209'></td>
                <td width='27'><a href='#'><img src='facebook.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='youtube.png' width='27' height='24' alt=''/></a></td>
                <td width='27'><a href='#'><img src='instagram.png' width='27' height='24' alt=''/></a></td>
                <td width='210'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='30'></td>
                <td width='540' style='line-height:16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#434342; text-align: center;'>
                    Em caso de qualquer dúvida, fique à vontade <br>
                    para responder esse e-mail ou
                    nos contatar no <br><br>
                    <a href='mailto:cliente@doutorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>cliente@doutorhoje.com.br</a>
                    <br><br>
                    Ou ligue para 0800 727 3620, o atendimento é de<br>
                    segunda à sexta-feira
                    das 8h00 às 18h00. <br><br>
                    <strong>Doutor Hoje</strong> 2018 
                </td>
                <td width='30'></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
            <tr style='background-color: #f9f9f9;'>
                <td width='513'>
                    &nbsp;
                </td>
            </tr>
        </table>
    </body>
</html>
HEREDOC;

         $html_message = str_replace(array("\r", "\n"), '', $html_message);
         //dd($html_message);

         $send_message = UtilController::sendMail($to, $from, $subject, $html_message);
         dd($send_message);
         if ($send_message) {
            dd('O e-mail foi enviado com sucesso!');
         //dd($output);
         }

        return view('home-logado');
    }
}