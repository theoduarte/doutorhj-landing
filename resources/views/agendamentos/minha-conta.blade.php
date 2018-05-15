@extends('layouts.base')

@section('title', 'DoctorHj: Minha Conta')

@push('scripts')

@endpush

@section('content')
    <section class="area-busca-interna minha-conta">
        <div class="container">
            <div class="busca-home">
                <div class="titulo">
                    <span>Quero agendar</span>
                </div>
                <form action="/resultado" class="form-busca-home" method="get">
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="tipo">Tipo de atendimento</label>
                            <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                            	<option value="" disabled selected hidden>Ex.: Consulta</option>
                            	<option value="saude">Consulta Médica</option>
                            	<option value="odonto">Consulta Odontológica</option>
                            	<option value="exame">Exames</option>
                            	<!-- <option value="procedimento">Procedimento</option> -->
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="especialidade">Especialidade ou exame</label>
                            <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                <option value="" disabled selected hidden>Ex.: Clínica Médica</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="local">Local de antedimento</label>
                            <select id="local_atendimento" class="form-control select2" name="local_atendimento">
                            	<option value="" disabled selected hidden>Ex.: Asa Sul</option>
                            </select>
                            <i class="cvx-no-loading fa fa-spin fa-spinner"></i>
                            <input type="hidden" id="endereco_id" name="endereco_id">
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <button type="submit" class="btn btn-primary btn-vermelho">Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-minha-conta">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-cadastro" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-caret-right"></i> Cadastro</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-pagamento" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-caret-right"></i> Pagamento</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-notificacoes" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-caret-right"></i> Notificações</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sugestoes" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-caret-right"></i> Deixe sua Sugestão</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sair" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-caret-right"></i> Sair</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-9 conteudo">
                        <div class="tab-content" id="v-pills-tabContent">

                            <!-- Cadastro -->

                            <div class="tab-pane fade show active" id="v-pills-cadastro" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 col-dados-cadastro">
                                        <span class="label-titulo">Cadastro</span>
                                        <form>
                                            <fieldset disabled>
                                                <div class="form-group">
                                                    <label for="inputNome">Nome</label>
                                                    <input type="text" id="inputNome"  class="form-control" value="{{ $user_paciente->paciente->nm_primario.' '.$user_paciente->paciente->nm_secundario }}" placeholder="Nome completo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail">Email</label>
                                                    <input type="email" id="inputEmail" class="form-control" value="{{ $user_paciente->email }}" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputTelefone">Telefone</label>
                                                    <input type="text" id="inputTelefone" class="form-control" value="{{ $user_paciente->paciente->contatos->first()->ds_contato }}" placeholder="Telefone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="selectGenero">Gênero</label>
                                                    <select id="selectGenero" class="form-control">
                                                        <option @if( $user_paciente->paciente->cs_sexo == 'M') selected="selected" @endif>Homem</option>
                                                        <option @if( $user_paciente->paciente->cs_sexo == 'F') selected="selected" @endif>Mulher</option>
                                                    </select>
                                                </div>
                                                <div class="form-group fc-tit-dn">
                                                    <label>Data de Nascimento</label>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <select id="selectDia" class="form-control">
                                                        	@for($i = 1; $i < 32; $i++)
                                                            <option @if( $dt_nascimento[0] == $i) selected="selected" @endif >{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectMes" class="form-control">
                                                        	@for($i = 1; $i <= 12; $i++)
                                                            <option @if( $dt_nascimento[1] == $i) selected="selected" @endif >{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectAno" class="form-control">
                                                        	@for($i = date('Y'); $i >= (date('Y')-100); $i--)
                                                            <option @if( $dt_nascimento[2] == $i) selected="selected" @endif>{{ sprintf("%04d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-lista-dependentes">
                                        <span class="label-titulo">Dependentes</span>
                                        <div class="lista-dependentes">
                                        	@for($i = 0; $i < sizeof($dependentes); $i++)
                                            <div class="dependente">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <span class="nm-dependente">Dep0{{ ($i+1) }}: {{ $dependentes[$i]->nm_primario.' '.$dependentes[$i]->nm_secundario }}</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a class="exclui-dependente" href="#"><iclass="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfor
                                            @if(sizeof($dependentes) == 0)
                                            NENHUM DEPENDENTE ENCONTRADO!
                                            @endif
                                            <!-- <div class="dependente">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <span class="nm-dependente">Nome Dependente 2</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a class="exclui-dependente" href="#"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dependente">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <span class="nm-dependente">Nome Dependente 3</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a class="exclui-dependente" href="#"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

                                        <button type="button" class="btn btn-light btn-add-dependente"
                                                data-toggle="modal"
                                                data-target="#modalAdicionaDependente">
                                            <i class="fa fa-plus"></i> Adicionar dependente
                                        </button>

                                        <!-- Modal adicionar dependente -->

                                        <div class="modal fade" id="modalAdicionaDependente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-adiciona-dependente" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Novo Dependente</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                            </div>
                                                            <div class="form-row">
                                                                <label for="inputNomeDependente">Nome</label>
                                                                <input type="text" class="form-control" id="inputNomeDependente" placeholder="Nome *" maxlength="50">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputNomeDependente">Sobrenome</label>
                                                                	<input type="text" class="form-control" id="inputNmSecundarioDependente" placeholder="Sobrenome *" maxlength="100">
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="tp_documento_dependente" class="control-label">Tipo Documento</label>
										                            <select id="tp_documento_dependente" class="form-control" name="tp_documento_dependente">
										                            	<option value="RG">RG</option>
										                            	<option value="CPF">CPF</option>
										                            	<option value="CNASC">Certi. Nasc.</option>
										                            	<option value="CTPS">Cart. Trabalho</option>
										                            </select>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="te_documento_dependente" class="control-label">Nr. Documento</label>
											                        <input type="text" id="te_documento_dependente" class="form-control" name="te_documento_dependente" placeholder="Nr. Documento">
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-row">
                                                                <div class="col-md-4">
                                                                    <label for="selectGeneroDependente">Gênero</label>
                                                                    <select id="selectGeneroDependente" class="form-control">
                                                                        <option value="M">Masc.</option>
                                                                        <option value="F">Fem.</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8">
                                                                	<label for="selectParentescoDependente">Parentesco</label>
                                                                    <select id="selectParentescoDependente" class="form-control">
                                                                        <option value="">Selecione</option>
                                                                        <option value="avo">Avô/Avó</option>
                                                                        <option value="conjuge">Cônjuge/Companheiro</option>
                                                                        <option value="enteado">Enteado(a)</option>
                                                                        <option value="filho">Filho(a)</option>
                                                                        <option value="irmao">Irmã(ão)</option>
                                                                        <option value="pai">Mãe</option>
                                                                        <option value="pai">Pai</option>
                                                                        <option value="outros">Outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group fc-tit-dn">
                                                                <label>Data de Nascimento</label>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectDiaDependente" class="form-control">
                                                                        <option value="">Dia</option>
                                                                        @for($i = 1; $i <= 31; $i++)
			                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
			                                                            @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectMesDependente" class="form-control">
                                                                        <option value="">Mês</option>
                                                                        @for($i = 1; $i <= 12; $i++)
			                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
			                                                            @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectAnoDependente" class="form-control">
                                                                        <option value="">Ano</option>
                                                                        @for($i = date('Y'); $i >= (date('Y'))-110; $i--)
			                                                            <option value="{{ $i }}">{{ $i }}</option>
			                                                            @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                            	<div class="col-md-12 text-center">
                                                            		<button type="button" id="btn-add-dependente" class="btn btn-vermelho" style="width: 200px;"><i class="fa fa-floppy-o"></i><span id="lbl-add-dependente" style="margin-left: 10px;"> Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i></span></button>
                                                            	</div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="label-titulo">Alteração Cadastral</span>
                                        <p>Para alterar as informações do seu cadastro é necessário entrar em contato com a nossa central de atendimento pelo número: <strong>(61) 3221-5350</strong></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagamento -->

                            <div class="tab-pane fade" id="v-pills-pagamento" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div>
                                    <div class="area-tipo-plano">
                                        <div class="row">
                                            <div class="col-md-6 atp1">
                                                <p class="nome-plano">Plano Premium</p>
                                                <p class="valor-anuidade">Anuidade Doctor Hoje R$ 9.99</p>
                                            </div>
                                            <div class="col-md-6 atp2">
                                                <p class="valor-plano">1 ano grátis</p>
                                                <a class="link-indique-amigo" href="#">Indique um Amigo</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-5">
                                            <span class="label-titulo">Cartões Salvos</span>
                                            <div class="box-pagamento lista-cartoes">
                                                <div class="cartao">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="bandeira visa"></div>
                                                            <p>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a class="exclui-cartao" href="#"><i
                                                                        class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cartao">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="bandeira mastercard"></div>
                                                            <p>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">4385</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a class="exclui-cartao" href="#"><i
                                                                        class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cartao">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="bandeira diners"></div>
                                                            <p>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">6573</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a class="exclui-cartao" href="#"><i
                                                                        class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cartao">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="bandeira amex"></div>
                                                            <p>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">5048</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a class="exclui-cartao" href="#"><i
                                                                        class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-light btn-add-cartao"
                                                    data-toggle="modal" data-target="#modalAdicionarCartao"><i
                                                        class="fa fa-plus"></i>
                                                Adicionar cartão
                                            </button>
                                            <div class="modal fade" id="modalAdicionarCartao" tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="modalAdicionarCartao" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Adicionar
                                                                cartão</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group row">
                                                                    <div class="col col-12 col-sm-6">
                                                                        <label for="inputNumeroCartaoDebito">Número do
                                                                            cartão</label>
                                                                        <input type="text"
                                                                               class="form-control input-numero-cartao"
                                                                               id="inputNumeroCartaoDebito"
                                                                               placeholder="Número do cartão">
                                                                    </div>
                                                                    <div class="col col-12 col-sm-6">
                                                                        <label for="inputNomeCartaoDebito">Nome impresso
                                                                            no cartão</label>
                                                                        <input type="email" class="form-control"
                                                                               id="inputNomeCartaoDebito"
                                                                               placeholder="Nome impresso no cartão">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col col-6 col-sm-6 col-md-3">
                                                                        <label for="selectValidadeMesDebito">Validade</label>
                                                                        <div class="button dropdown">
                                                                            <select class="form-control select-validade-mes"
                                                                                    id="selectValidadeMesDebito">
                                                                                <option>Mês</option>
                                                                                <option>Janeiro</option>
                                                                                <option>Fevereiro</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col col-6 col-sm-6 col-md-3">
                                                                        <label class="label-validade-ano"
                                                                               for="selectValidadeAnoDebito">&nbsp;</label>
                                                                        <div class="button dropdown">
                                                                            <select class="form-control"
                                                                                    id="selectValidadeAnoDebito">
                                                                                <option>Ano</option>
                                                                                <option>2018</option>
                                                                                <option>2019</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                                        <label for="inputCodigoDebito"
                                                                               class="label-codigo-seguranca">Código
                                                                            de segurança</label>
                                                                        <div class="area-codigo-seguranca">
                                                                            <input type="text" class="form-control" id="inputCodigoDebito" placeholder="000">
                                                                            <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Código de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-vermelho">Adicionar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-7">
                                            <span class="label-titulo">Últimas Transações</span>
                                            <div class="box-pagamento lista-transacoes">
                                                <div class="transacoes">
                                                    <div class="row">
                                                        <div class="col-sm-3 area-data">
                                                            <p class="dia">
                                                                28
                                                            </p>
                                                            <p class="mes">
                                                                Abr
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="tipo">
                                                                Consulta Cardiologia
                                                            </p>
                                                            <p class="clinica">
                                                                Clínica Alvorada
                                                            </p>
                                                            <p class="cartao-utilizado">
                                                                <span class="bandeira-extenso">Visa </span>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="valor">R$ <span>100</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="transacoes">
                                                    <div class="row">
                                                        <div class="col-sm-3 area-data">
                                                            <p class="dia">
                                                                28
                                                            </p>
                                                            <p class="mes">
                                                                Abr
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="tipo">
                                                                Consulta Cardiologia
                                                            </p>
                                                            <p class="clinica">
                                                                Clínica Alvorada
                                                            </p>
                                                            <p class="cartao-utilizado">
                                                                <span class="bandeira-extenso">Visa </span>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="valor">R$ <span>100</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="transacoes">
                                                    <div class="row">
                                                        <div class="col-sm-3 area-data">
                                                            <p class="dia">
                                                                28
                                                            </p>
                                                            <p class="mes">
                                                                Abr
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="tipo">
                                                                Consulta Cardiologia
                                                            </p>
                                                            <p class="clinica">
                                                                Clínica Alvorada
                                                            </p>
                                                            <p class="cartao-utilizado">
                                                                <span class="bandeira-extenso">Visa </span>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="valor">R$ <span>100</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="transacoes">
                                                    <div class="row">
                                                        <div class="col-sm-3 area-data">
                                                            <p class="dia">
                                                                28
                                                            </p>
                                                            <p class="mes">
                                                                Abr
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="tipo">
                                                                Consulta Cardiologia
                                                            </p>
                                                            <p class="clinica">
                                                                Clínica Alvorada
                                                            </p>
                                                            <p class="cartao-utilizado">
                                                                <span class="bandeira-extenso">Visa </span>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="valor">R$ <span>100</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="transacoes">
                                                    <div class="row">
                                                        <div class="col-sm-3 area-data">
                                                            <p class="dia">
                                                                28
                                                            </p>
                                                            <p class="mes">
                                                                Abr
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="tipo">
                                                                Consulta Cardiologia
                                                            </p>
                                                            <p class="clinica">
                                                                Clínica Alvorada
                                                            </p>
                                                            <p class="cartao-utilizado">
                                                                <span class="bandeira-extenso">Visa </span>
                                                                <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                <span class="final">9010</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="valor">R$ <span>100</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notificações -->

                            <div class="tab-pane fade" id="v-pills-notificacoes" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <div class="opcoes-notificacao">
                                    <div class="tit-opcoes-notificacao">
                                        <span>E-mail</span>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleLembrete"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleLembrete" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleConfirmacao"><strong>Confirmação</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleConfirmacao" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleCancelamento"><strong>Cancelamento</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleCancelamento" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="tit-opcoes-notificacao tit-not-mob">
                                        <span>Mobile</span>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleLembreteMobile"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleLembreteMobile" checked type="checkbox"
                                                   data-toggle="toggle" data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleConfirmacaoMobile"><strong>Confirmação</strong> de
                                                consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleConfirmacaoMobile" checked type="checkbox"
                                                   data-toggle="toggle" data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-9 col-lg-5">
                                            <label for="toggleCancelamentoMobile"><strong>Cancelamento</strong> de
                                                consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <input id="toggleCancelamentoMobile" checked type="checkbox"
                                                   data-toggle="toggle" data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sugestões -->

                            <div class="tab-pane fade" id="v-pills-sugestoes" role="tabpanel"
                                 aria-labelledby="v-pills-settings-tab">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <span class="label-titulo">Avalie o Doctor Hoje</span>
                                        <p>Deixe sua avaliação e nos ajude a deixar o Doctor Hoje melhor ainda.</p>
                                        <p>Dê uma nota de 1 a 5 estrelas para cada tópico abaixo, sendo 1 para péssimo e
                                            5 para excelente.</p>
                                        <div class="nota-avaliacao nota-servico">
                                            <p>Serviço</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input"
                                                       id="servico-nota-5" name="rating-input-servico">
                                                <label for="servico-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="servico-nota-4" name="rating-input-servico">
                                                <label for="servico-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="servico-nota-3" name="rating-input-servico">
                                                <label for="servico-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="servico-nota-2" name="rating-input-servico">
                                                <label for="servico-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="servico-nota-1" name="rating-input-servico">
                                                <label for="servico-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-navegacao">
                                            <p>Navegação</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input"
                                                       id="navegacao-nota-5" name="rating-input-navegacao">
                                                <label for="navegacao-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="navegacao-nota-4" name="rating-input-navegacao">
                                                <label for="navegacao-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="navegacao-nota-3" name="rating-input-navegacao">
                                                <label for="navegacao-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="navegacao-nota-2" name="rating-input-navegacao">
                                                <label for="navegacao-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="navegacao-nota-1" name="rating-input-navegacao">
                                                <label for="navegacao-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-organizacao">
                                            <p>Organização</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input"
                                                       id="organizacao-nota-5" name="rating-input-organizacao">
                                                <label for="organizacao-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="organizacao-nota-4" name="rating-input-organizacao">
                                                <label for="organizacao-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="organizacao-nota-3" name="rating-input-organizacao">
                                                <label for="organizacao-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="organizacao-nota-2" name="rating-input-organizacao">
                                                <label for="organizacao-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="organizacao-nota-1" name="rating-input-organizacao">
                                                <label for="organizacao-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-facilidade">
                                            <p>Facilidade</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input"
                                                       id="facilidade-nota-5" name="rating-input-facilidade">
                                                <label for="facilidade-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="facilidade-nota-4" name="rating-input-facilidade">
                                                <label for="facilidade-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="facilidade-nota-3" name="rating-input-facilidade">
                                                <label for="facilidade-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="facilidade-nota-2" name="rating-input-facilidade">
                                                <label for="facilidade-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="facilidade-nota-1" name="rating-input-facilidade">
                                                <label for="facilidade-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-atendimento">
                                            <p>Rede de Atendimento</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input"
                                                       id="atendimento-nota-5" name="rating-input-atendimento">
                                                <label for="atendimento-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="atendimento-nota-4" name="rating-input-atendimento">
                                                <label for="atendimento-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="atendimento-nota-3" name="rating-input-atendimento">
                                                <label for="atendimento-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="atendimento-nota-2" name="rating-input-atendimento">
                                                <label for="atendimento-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input"
                                                       id="atendimento-nota-1" name="rating-input-atendimento">
                                                <label for="atendimento-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <span class="label-titulo">Mais alguma sugestão?</span>
                                        <p>Deixe sua avaliação e nos ajude a deixar o Doctor Hoje melhor ainda.</p>
                                        <form>
                                            <div class="form-group">
                                                <textarea class="form-control" id="textareaSugestao"
                                                          rows="6"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-vermelho">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Sair -->

                            <div class="tab-pane fade" id="v-pills-sair" role="tabpanel"
                                 aria-labelledby="v-pills-settings-tab">
                                <div class="itens-sair">
                                    <span class="label-titulo">Obrigado por usar o Doctor Hoje</span>
                                </div>
                                <div class="itens-sair">
                                    <img src="/libs/home-template/img/doctor-hoje-notebook.png" alt="">
                                </div>
                                <div class="itens-sair">
                                    <span>Você tem certeza que deseja sair?</span>
                                    <div class="btns-sair">
                                        <button type="button" class="btn btn-light" onclick="window.location.href='{{ route("logout") }}'">Sim</button>
                                        <button type="submit" class="btn btn-vermelho">Não</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];

                $('#btn-add-dependente').click(function() {

                	var result = true;
                    var nm_primario_dependente = $('#inputNomeDependente');

                	if(nm_primario_dependente.val().length == 0) {
                		nm_primario_dependente.parent().addClass('cvx-has-error');
                		nm_primario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#inputNomeDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var nm_secundario_dependente = $('#inputNmSecundarioDependente');

                	if(nm_secundario_dependente.val().length == 0) {
                		nm_secundario_dependente.parent().addClass('cvx-has-error');
                		nm_secundario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#inputNmSecundarioDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}
                	
                	var tp_documento = $('#tp_documento_dependente');

                	if(tp_documento.val() == '') {
                		tp_documento.parent().addClass('cvx-has-error');
                		tp_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#tp_documento_dependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var nr_documento = $('#te_documento_dependente');

                	if(nr_documento.val().length == 0) {
                		nr_documento.parent().addClass('cvx-has-error');
                		nr_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#te_documento_dependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var sexo_dependente = $('#selectGeneroDependente');

                	if(sexo_dependente.selectedIndex == 0) {
                		sexo_dependente.parent().addClass('cvx-has-error');
                		sexo_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#selectGeneroDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var dt_nasc_dia_dependente = $('#selectDiaDependente');

                	if(dt_nasc_dia_dependente.val() == '') {
                		dt_nasc_dia_dependente.parent().addClass('cvx-has-error');
                		dt_nasc_dia_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#selectDiaDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var dt_nasc_mes_dependente = $('#selectMesDependente');

                	if(dt_nasc_mes_dependente.val() == '') {
                		dt_nasc_mes_dependente.parent().addClass('cvx-has-error');
                		dt_nasc_mes_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#selectMesDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var dt_nasc_ano_dependente = $('#selectAnoDependente');

                	if(dt_nasc_ano_dependente.val() == '') {
                		dt_nasc_ano_dependente.parent().addClass('cvx-has-error');
                		dt_nasc_ano_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#selectAnoDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	var parentesco_dependente = $('#selectParentescoDependente');

                	if(parentesco_dependente.val() == '') {
                		parentesco_dependente.parent().addClass('cvx-has-error');
                		parentesco_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
                		
                		$('#selectParentescoDependente').keypress(function(){
                			$(this).parent().removeClass('cvx-has-error');
                			$(this).parent().find('span.help-block').remove();
                		});
                		
                		result = false;
                	}

                	if(!result) { return false; }

                	$('#btn-add-dependente').attr('disabled', 'disabled')
                    $('#lbl-add-dependente').html('Enviando <i class="fa fa-spin fa-spinner" style="display: inline-block; float: right; font-size: 16px;"></i>');

                    var nome_dep 			= nm_primario_dependente.val();
                    var sobrenome_dep 		= nm_secundario_dependente.val();
                    var tp_documento_dep 	= tp_documento.val();
                    var nr_documento_dep 	= nr_documento.val();
                    var sexo_dep 			= sexo_dependente.val();
                    var parentesco_dep 		= parentesco_dependente.val();
                    var dia_nasc_dep 		= dt_nasc_dia_dependente.val();
                    var mes_nasc_dep 		= dt_nasc_mes_dependente.val();
                    var ano_nasc_dep 		= dt_nasc_ano_dependente.val();
                    var paciente_id 		= $('#paciente_id').val();

                	jQuery.ajax({
            			type: 'POST',
            			url: '/add-dependente',
            			data: {
                			'nome': nome_dep,
                			'sobrenome': sobrenome_dep,
                			'tp_documento': tp_documento_dep,
                			'nr_documento': nr_documento_dep,
                			'sexo': sexo_dep,
                			'parentesco': parentesco_dep,
                			'dia_nasc': dia_nasc_dep,
                			'mes_nasc': mes_nasc_dep
            				'ano_nasc': ano_nasc_dep,
            				'_token': laravel_token
            			},
                        success: function (result) {
                            
                            var profissional = JSON.parse(result.profissional);
                            
            	            if(result.status) {
            	            	$(element).parent().parent().remove();
            	            	$.Notification.notify('success','top right', 'DrHoje', result.mensagem);
            	            }
                        },
                        error: function (result) {
                            $.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
                        }
            		});
                	
                });
            });

            /*********************************
             *
             * REMOVE PRODUTO DEPENDENTE E CARTÃO
             *
             *********************************/
            $(".exclui-dependente").on("click", function (event) {
                event.preventDefault();
                if (confirm("Tem certeza que deseja excluir esse dependente?")) {
                    $(this).parent().parent().parent().remove();
                }
            });

            $(".exclui-cartao").on("click", function (event) {
                event.preventDefault();
                if (confirm("Tem certeza que deseja excluir esse cartão?")) {
                    $(this).parent().parent().parent().remove();
                }
            });

            /*********************************
             *
             * ATIVA TOOLTIP
             *
             *********************************/

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

    @endpush

@endsection