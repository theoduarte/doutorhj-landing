<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('pagamento', 'ClinicaController@paginaPagamento')->middleware('auth')->name('pagamento');
Route::get('informa-beneficiario', 'ClinicaController@informaBeneficiario');
Route::get('confirmacao', 'ClinicaController@confirmaAgendamento');
Route::get('home-prestador', 'ClinicaController@homePrestador');
Route::get('confirma-cadastro', 'ClinicaController@confirmaCadastro');
Route::get('login-prestador', 'ClinicaController@loginPrestador');
Route::get('minha-conta', 'ClinicaController@minhaConta');
Route::get('meus-agendamentos', 'ClinicaController@meusAgendamentos');
Route::get('carrinho', 'ClinicaController@carrinhoDeCompras');
Route::get('home-logado', 'ClinicaController@homeLogado');
Route::get('resultado', 'AtendimentoController@consultaAtendimentos');

Route::resource('clinicas','ClinicaController')->middleware('auth');
Route::resource('profissionals','ProfissionalController')->middleware('auth');
Route::resource('clientes', 'ClienteController')->middleware('auth');
Route::resource('cargos','CargoController')->middleware('auth');
Route::resource('menus','MenuController')->middleware('auth');
Route::resource('itemmenus','ItemmenuController')->middleware('auth');
Route::resource('perfilusers','PerfiluserController')->middleware('auth');
Route::resource('permissaos','PermissaoController')->middleware('auth');
Route::resource('agendamentos','AgendamentoController')->middleware('auth');

# rotas autocomplete
Route::get('consulta-cep/cep/{cep}', 'Controller@consultaCep')->name('cep');
Route::post('consulta-especialidades', 'EspecialidadeController@consultaEspecialidades');
Route::post('consulta-local-atendimento', 'EspecialidadeController@consultaLocalAtendimento');

Route::post('agendar-atendimento', 'AgendamentoController@agendarAtendimento');
Route::post('users/register', 'UserController@register')->name('registrar');
Route::post('enviar-token', 'UserController@sendToken')->name('enviar_token');
Route::get('pacientes/activate/{verify_hash}', 'PacienteController@ativarConta')->name('ativar_conta');

Route::get('consultas/consulta/{consulta}', 'ClinicaController@getConsultas')->middleware('auth');
Route::get('procedimentos/consulta/{consulta}', 'ClinicaController@getProcedimentos')->middleware('auth');
Route::get('consultas/localatendimento/{consulta}', 'AgendamentoController@getLocalAtendimento')->middleware('auth');
Route::get('agenda/profissional/{profissional}', 'AgendamentoController@getProfissional')->middleware('auth');
Route::post('clinicas/{clinica}/edit/add-profissional', 'ClinicaController@addProfissionalStore')->middleware('auth');
Route::post('clinicas/{clinica}/edit/view-profissional', 'ClinicaController@viewProfissionalShow')->middleware('auth');
Route::post('clinicas/{clinica}/edit/delete-profissional', 'ClinicaController@deleteProfissionalDestroy')->middleware('auth');
Route::post('clinicas/{clinica}/edit/add-precificacao-procedimento', 'ClinicaController@addProcedimentoPrecoStore')->middleware('auth');
Route::post('clinicas/{clinica}/edit/delete-procedimento', 'ClinicaController@deleteProcedimentoDestroy')->middleware('auth');
Route::post('clinicas/{clinica}/edit/add-precificacao-consulta', 'ClinicaController@addConsultaPrecoStore')->middleware('auth');
Route::post('clinicas/{clinica}/edit/delete-consulta', 'ClinicaController@deleteConsultaDestroy')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
