<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Controller@home')->name('landing-page');

Route::get('/home', function () {
    return redirect('/');
});

Route::get('resultado', 'AtendimentoController@consultaAtendimentos')->name('resultado');
Route::get('resultadoApi/{tipo_atendimento}/{tipo_especialidade}/{sg_estado_localizacao}/{local_atendimento?}', 'AtendimentoController@consultaAtendimentosCaixa')->name('resultadoApi');
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

/** rotas de sucesso e falha apos o pagamento transferencia */
Route::get('payment/success/{hash}', 'PaymentController@successPayment');
Route::get('payment/failed/{hash}', 'PaymentController@failedPayment');

Route::get('alteraVigenciaAtiva/{id}', 'PacienteController@alteraVigenciaAtiva')->name('altera_vigencia_ativa');

/*colocar essa rota no local correto*/
Route::get('contato', 'ClinicaController@contatoHomePublica');
Route::get('planos-individuais', 'ClinicaController@planos')->name('planos-individuais');
Route::get('planos-individuais/contratar/{plano}/{identificador}/{details}/{all}', 'ClinicaController@planosContratacao')->name('contratacao');
Route::post('contratar-plano', 'ClinicaController@contratarPlano')->name('contratar-plano');

// Route::get('confirmacao', 'ClinicaController@cadastroAtivado');
Route::get('avaliacao', 'ClinicaController@avaliaAtendimento');
Route::get('campanha/{url_param}/{plano?}', 'CampanhaVendaController@cadastroCampanha')->name('campanha');

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
Route::get('consulta-cep/cep/{cep}', 'Controller@consultaCep')->name('cep');

# rotas da busca landing page
Route::post('consulta-especialidades', 'EspecialidadeController@consultaEspecialidades');
Route::post('registrar-endereco', 'AgendamentoController@MundiEnderecoPaciente');

Route::post('consulta-todos-locais-atendimento', 'EspecialidadeController@consultaTodosLocaisAtendimento');

Route::post('consulta-cartao-paciente', 'CartaoPacienteController@consultaCartao');
Route::post('consulta-endereco-local-atendimento', 'EspecialidadeController@consultaEnderecoLocalAtendimento');
Route::post('consulta-agendamento-disponivel', 'AgendamentoController@consultaAgendamentoDisponivel');

#rota de notificacao CIELO
Route::post('notificacao', 'PaymentController@notificacao')->name('notificacao');

Route::get('agendamentos/empresa/autorizar/{verify_hash}', 'AgendamentoController@autorizaCreditoEmpresarial')->name('autoriza_credito_empresarial');
Route::get('payments/cartao/preautorizar/{verify_hash}', 'PaymentController@informaCartao')->name('informaCartao');
Route::post('payments/cartao/preautorizar/finaliza/{verify_hash}', 'PaymentController@finalizaPreAutorizacao')->name('finaliza_pre_autorizacao');

Route::post('finalizar_pedido', 'PaymentController@fullTransaction')->name('finalizar-pedido')->middleware('auth');

Route::post('finalizar_pedido_cartao_cadastrado', 'PaymentController@fullTransactionSaveCard')->name('finalizar-pedido-cartao-cadastrado')->middleware('auth');
Route::get('concluir_pedido', 'PaymentController@fullTransactionFinish');

#rotas de teste
Route::get('teste_concluir_pedido', 'PaymentController@fullTransactionTeste');
Route::get('teste-envio-email', 'PaymentController@testeEnviarEmail');

Route::post('users/register', 'UserController@register')->name('registrar');
Route::post('enviar-token', 'UserController@sendToken')->name('enviar_token');
Route::get('pacientes/activate/{verify_hash}', 'PacienteController@ativarConta')->name('ativar_conta');
Route::get('pacientes/activate-redirect', 'PacienteController@ativarContaRedirect')->name('activate-redirect');
Route::post('remover-item_carrinho', 'ClinicaController@RemoverItemCarrinho');
Route::post('validar-cupom-desconto', 'CupomDescontoController@validarCupomDesconto')->name('validar_cupom_desconto');
Route::post('validar-cupom-cartao', 'CupomDescontoController@validarCupomCartao')->name('validar_cupom_cartao');


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

#rotas da campanha caixa
Route::post('registrar-caixa', 'UserController@registrarCaixa')->name('registrar-caixa');
Route::get('ofertacertacaixa', 'ClinicaController@ofertaCertaCaixa')->name('oferta-certa-caixa');

Route::post('registrar-campanha', 'CampanhaVendaController@registrarCampanha')->name('registrar-campanha');

Route::post('enviar-email-confirmacao', 'PacienteController@enviarEmailConfirmacao')->name('enviar-email');
Route::get('campanha_venda/activate/{verify_hash}', 'CampanhaVendaController@ativarCampanha')->name('ativar_campanha');

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
