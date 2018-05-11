<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', 'Controller@home')->name('landing-page');

Route::get('pagamento', 'ClinicaController@paginaPagamento')->middleware('auth')->name('pagamento');
Route::get('informa-beneficiario', 'ClinicaController@informaBeneficiario');
Route::get('confirmacao', 'ClinicaController@confirmaAgendamento');
Route::get('home-prestador', 'ClinicaController@homePrestador');
Route::get('confirma-cadastro', 'ClinicaController@confirmaCadastro');
Route::get('login-prestador', 'ClinicaController@loginPrestador');
Route::get('minha-conta', 'AgendamentoController@minhaConta')->name('minha-conta')->middleware('auth');
Route::get('meus-agendamentos', 'AgendamentoController@meusAgendamentos')->name('meus-agendamentos')->middleware('auth');

Route::get('carrinho', 'AgendamentoController@carrinhoDeCompras')->name('carrinho');
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
Route::post('consulta-cartao-paciente', 'CartaoPacienteController@consultaCartao');
Route::post('consulta-todos-locais-atendimento', 'EspecialidadeController@consultaTodosLocaisAtendimento');
Route::post('consulta-endereco-local-atendimento', 'EspecialidadeController@consultaEnderecoLocalAtendimento');

#rota de notificacao CIELO
Route::post('notificacao', 'PaymentController@notificacao')->name('notificacao');

Route::post('finalizar_pedido', 'PaymentController@fullTransaction')->name('finalizar-pedido')->middleware('auth');
Route::post('finalizar_pedido_cartao_cadastrado', 'PaymentController@fullTransactionSaveCard')->name('finalizar-pedido-cartao-cadastrado')->middleware('auth');
Route::get('concluir_pedido', 'PaymentController@fullTransactionDoctorhj');

#rotas de teste
Route::get('teste_concluir_pedido', 'PaymentController@fullTransactionTeste');
Route::get('teste-envio-email', 'ClinicaController@testeEnviarEmail');

Route::post('agendar-atendimento', 'AgendamentoController@agendarAtendimento');
Route::post('users/register', 'UserController@register')->name('registrar');
Route::post('enviar-token', 'UserController@sendToken')->name('enviar_token');
Route::get('pacientes/activate/{verify_hash}', 'PacienteController@ativarConta')->name('ativar_conta');
Route::post('remover-item_carrinho', 'ClinicaController@RemoverItemCarrinho');

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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
