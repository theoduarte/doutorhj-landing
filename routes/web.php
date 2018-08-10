<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Controller@home')->name('landing-page');

Route::get('resultado', 'AtendimentoController@consultaAtendimentos');
Route::get('resultado-checkup', 'CheckupController@resultadoCheckup');
Route::post('agendar-atendimento', 'AgendamentoController@agendarAtendimento');
Route::get('informa-beneficiario', 'AgendamentoController@informaBeneficiario')->middleware('auth')->name('informa-beneficiario');
Route::post('atualiza-carrinho', 'AgendamentoController@atualizaCarrinho')->name('atualiza-carrinho');
Route::get('carrinho', 'AgendamentoController@carrinhoDeCompras')->name('carrinho');
Route::get('carrinho-checkup', 'CheckupController@carrinhoCheckup');
Route::get('pagamento', 'ClinicaController@paginaPagamento')->middleware('auth')->name('pagamento');
Route::get('pagamento-checkup', 'CheckupController@pagamentoCheckup');
Route::get('confirmacao', 'ClinicaController@confirmaAgendamento');
Route::get('confirmacao-checkup', 'CheckupController@confirmacaoCheckup');
Route::post('consulta-tipos-checkup','CheckupController@getTipoCheckupAtivo');
Route::get('terms-and-conditions','HomeController@terms')->middleware('web');

/*colocar essa rota no local correto*/
Route::get('contato', 'ClinicaController@contatoHomePublica');

Route::get('home-prestador', 'ClinicaController@homePrestador');
Route::get('confirma-cadastro', 'ClinicaController@confirmaCadastro');
Route::get('login-prestador', 'ClinicaController@loginPrestador');
Route::get('minha-conta', 'AgendamentoController@minhaConta')->name('minha-conta')->middleware('auth');
Route::get('meus-agendamentos', 'AgendamentoController@meusAgendamentos')->name('meus-agendamentos')->middleware('auth');
Route::post('remarcar-agendamento', 'AgendamentoController@remarcarAgendamento')->name('remarcar_agendamento')->middleware('auth');
Route::post('cancelar-agendamento', 'AgendamentoController@cancelarAgendamento')->name('cancelar_agendamento')->middleware('auth');

Route::get('home-logado', 'ClinicaController@homeLogado');

Route::post('participe', 'MensagemController@participe');

# rotas autocomplete
Route::get('consulta-cep/cep/{cep}', 'Controller@cuse Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
onsultaCep')->name('cep');

# rotas da busca landing page
Route::post('consulta-especialidades', 'EspecialidadeController@consultaEspecialidades');
Route::post('consulta-todos-locais-atendimento', 'EspecialidadeController@consultaTodosLocaisAtendimento');

Route::post('consulta-cartao-paciente', 'CartaoPacienteController@consultaCartao');
Route::post('consulta-endereco-local-atendimento', 'EspecialidadeController@consultaEnderecoLocalAtendimento');
Route::post('consulta-agendamento-disponivel', 'AgendamentoController@consultaAgendamentoDisponivel');

#rota de notificacao CIELO
Route::post('notificacao', 'PaymentController@notificacao')->name('notificacao');

Route::post('finalizar_pedido', 'PaymentController@fullTransaction')->name('finalizar-pedido')->middleware('auth');
Route::post('finalizar_pedido_cartao_cadastrado', 'PaymentController@fullTransactionSaveCard')->name('finalizar-pedido-cartao-cadastrado')->middleware('auth');
Route::get('concluir_pedido', 'PaymentController@fullTransactionDoctorhj');

#rotas de teste
Route::get('teste_concluir_pedido', 'PaymentController@fullTransactionTeste');
Route::get('teste-envio-email', 'PaymentController@testeEnviarEmail');

Route::post('users/register', 'UserController@register')->name('registrar');
Route::post('enviar-token', 'UserController@sendToken')->name('enviar_token');
Route::get('pacientes/activate/{verify_hash}', 'PacienteController@ativarConta')->name('ativar_conta');
Route::get('pacientes/activate-redirect', 'PacienteController@ativarContaRedirect')->name('activate-redirect');
Route::post('remover-item_carrinho', 'ClinicaController@RemoverItemCarrinho');
Route::post('validar-cupom-desconto', 'CupomDescontoController@validarCupomDesconto')->name('validar_cupom_desconto');

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

Route::post('add-dependente', 'PacienteController@addDependenteStore')->middleware('auth');
Route::post('delete-dependente', 'PacienteController@deleteDependenteDestroy')->middleware('auth');

Route::get('notificacoes','MensagemController@getListaNotificacoes')->middleware('auth');
Route::get('notificacoes/visualizado/{id}','MensagemController@setStatusVisualizado')->middleware('auth');
Route::get('ver-notificacoes/{id}','MensagemController@verNotificacao')->middleware('auth');


Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
