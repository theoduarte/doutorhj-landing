<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Cidade;
use App\Endereco;
use App\Estado;
use App\Especialidade;
use App\Paciente;
use App\User;

use Illuminate\Support\Facades\Request;
use App\Http\Requests\PacientesRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as CVXRequest;
use Illuminate\Support\Facades\Crypt;

/**
 * @author Frederico Cruz <frederico.cruz@s1saude.com.br>
 * 
 */
class PacienteController extends Controller
{    
    /**
     * Método para mostrar a página de cadastro do paciente 
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(){
        $arCargos        = Cargo::orderBy('ds_cargo')->get(['id', 'ds_cargo']);
        $arEstados       = Estado::orderBy('ds_estado')->get();
        $arEspecialidade = Especialidade::orderBy('ds_especialidade')->get();
        
        return view('paciente', ['arEstados' => $arEstados, 'arCargos'=> $arCargos, 'arEspecialidade'=>$arEspecialidade]);
    }
    
    /**
     * ativarConta the specified resource in storage.
     *
     * @param  String  $verify_hash
     * @return \Illuminate\Http\Response
     */
    public function ativarConta($verify_hash)
    {
        //$this->validate($request, Volunteer::$rules);
        
        $paciente_id = Crypt::decryptString($verify_hash);
        
        $paciente = Paciente::findOrFail($paciente_id);
        
        if($paciente === null) {
            return view('welcome');
        }
        
        $user_id = $paciente->user->id;
        $user = User::findOrFail($user_id);
        $user->cs_status = 'A';
        $user->save();
        
        return view('pacientes.activate');
    }
    
     
    /**
     * 
     * @param PacientesRequest $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function gravar(PacientesRequest $request){
        DB::beginTransaction();
        
        try{
            $usuario = new User();
            $usuario->name = strtoupper($request->input('nm_primario').' '.$request->input('nm_secundario'));
            $usuario->email = $request->input('email');
            $usuario->password = bcrypt($request->input('password'));
            $usuario->tp_user = 'PAC';
            $usuario->save();  
            
            
            $documento = new \App\Documento($request->all());
            $documento->save();
            
            
            $endereco = new Endereco($request->all());
            $idCidade = Cidade::where(['cd_ibge'=>$request->input('cd_ibge_cidade')])->get(['id'])->first();
            $endereco->cidade_id = $idCidade->id;
            $endereco->save();
            
            
            # telefones ---------------------------------------------
            $arContatos = array();
            
            $contato1 = new \App\Contato();
            $contato1->tp_contato = $request->input('tp_contato1');
            $contato1->ds_contato = $request->input('ds_contato1');
            $contato1->save();
            $arContatos[] = $contato1->id;
            
            if(!empty($request->input('ds_contato2'))){
                $contato2 = new \App\Contato();
                $contato2->tp_contato = $request->input('tp_contato2');
                $contato2->ds_contato = $request->input('ds_contato2');
                $contato2->save();
                $arContatos[] = $contato2->id;
            }
            
            
            if(!empty($request->input('ds_contato3'))){
                $contato3 = new \App\Contato();
                $contato3->tp_contato = $request->input('tp_contato3');
                $contato3->ds_contato = $request->input('ds_contato3');
                $contato3->save();
                $arContatos[] = $contato3->id;
            }
            
            $paciente  = new \App\Paciente($request->all());
            $paciente->users_id = $usuario->id;       
            $paciente->save();

            
            $paciente->contatos()->attach($arContatos);
            $paciente->enderecos()->attach([$endereco->id]);
            $paciente->documentos()->attach([$documento->id]);
            $paciente->save();
            
            DB::commit();
            
            return redirect()->route('home', ['nome' => $request->input('nm_primario')]);
        } catch (\Exception $e){
            DB::rollBack(); 
            
            throw new \Exception($e->getCode().'-'.$e->getMessage());
        }
    }
    
    /**
     * addDependenteStore a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDependenteStore(Request $request)
    {
        $nm_primario_dep    = CVXRequest::post('nome');
        $nm_secundario_dep  = CVXRequest::post('sobrenome');
        $tp_documento_dep   = CVXRequest::post('tp_documento');
        $nr_documento_dep   = CVXRequest::post('nr_documento');
        $sexo_dep           = CVXRequest::post('sexo');
        $parentesco_dep     = CVXRequest::post('parentesco');
        $dia_nasc_dep       = CVXRequest::post('dia_nasc');
        $mes_nasc_dep       = CVXRequest::post('mes_nasc');
        $ano_nasc_dep       = CVXRequest::post('ano_nasc');
        
        $dependente                 = new Paciente();
        $dependente->nm_primario    = $nm_primario_dep;
        $dependente->nm_secundario  = $nm_secundario_dep;
        $dependente->parentesco     = $parentesco_dep;
        $dependente->cs_sexo        = $sexo_dep;
        $dependente->dt_nascimento  = $ano_nasc_dep.'-'.$mes_nasc_dep.'-'.$dia_nasc_dep.' 00:00:00';
        
        $usuario->password  = bcrypt($request->input('password'));
        $usuario->tp_user   = 'CLI';
        $usuario->cs_status = 'A';
        $usuario->perfiluser_id = 2;
        $usuario->save();
        
        if (!$atendimento->save()) {
            return response()->json(['status' => false, 'mensagem' => 'O Procedimento não foi salvo. Por favor, tente novamente.']);
        }
        
        $atendimento->load('procedimento');
        
        return response()->json(['status' => true, 'mensagem' => 'O Procedimento foi salvo com sucesso!', 'atendimento' => $atendimento->toJson()]);
    }
}
