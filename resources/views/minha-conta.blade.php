@extends('layouts.logado')

@section('title', 'Confirma Agendamento - DoutorHJ')

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
                                <option>Ex.: Consulta</option>
                                <option value="saude">Consulta Médica</option>
                                <option value="odonto">Consulta Odontológica</option>
                                <option value="exame">Exames</option>
                                <option value="procedimento">Procedimento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="especialidade">Especialidade ou exame</label>
                            <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                <option>Ex.: Clínica Médica</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                                <option>Opção 3</option>
                                <option>Opção 4</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="local">Local de antedimento</label>
                            <input type="text" id="local_atendimento" class="form-control cvx-local-atendimento"
                                   name="local_atendimento" placeholder="Ex.: Asa Sul">
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
                    <div class="col-md-3 menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-cadastro"
                               role="tab"
                               aria-controls="v-pills-home" aria-selected="true"><i class="fas fa-caret-right"></i>
                                Cadastro</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-pagamento"
                               role="tab"
                               aria-controls="v-pills-profile" aria-selected="false"><i class="fas fa-caret-right"></i>
                                Pagamento</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                               href="#v-pills-notificacoes"
                               role="tab"
                               aria-controls="v-pills-messages" aria-selected="false"><i class="fas fa-caret-right"></i>
                                Notificações</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sugestoes"
                               role="tab"
                               aria-controls="v-pills-settings" aria-selected="false"><i class="fas fa-caret-right"></i>
                                Deixe sua Sugestão</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sair"
                               role="tab"
                               aria-controls="v-pills-settings" aria-selected="false"><i class="fas fa-caret-right"></i>
                                Sair</a>
                        </div>
                    </div>
                    <div class="col-md-9 conteudo">
                        <div class="tab-content" id="v-pills-tabContent">

                            <!-- Cadastro -->

                            <div class="tab-pane fade show active" id="v-pills-cadastro" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="label-titulo">Cadastro</span>
                                        <form>
                                            <fieldset disabled>
                                                <div class="form-group">
                                                    <label for="inputNome">Nome</label>
                                                    <input type="text" class="form-control" id="inputNome"
                                                           placeholder="Samyr Almeida">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail">Email</label>
                                                    <input type="email" class="form-control" id="inputEmail"
                                                           placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputTelefone">Telefone</label>
                                                    <input type="text" class="form-control" id="inputTelefone"
                                                           placeholder="(61) 9 8241 4090">
                                                </div>
                                                <div class="form-group">
                                                    <label for="selectGenero">Gênero</label>
                                                    <select id="selectGenero" class="form-control">
                                                        <option>Homem</option>
                                                    </select>
                                                </div>
                                                <div class="form-group fc-tit-dn">
                                                    <label>Data de Nascimento</label>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <select id="selectDia" class="form-control">
                                                            <option>09</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectMes" class="form-control">
                                                            <option>09</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectAno" class="form-control">
                                                            <option>1994</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="label-titulo">Dependentes</span>
                                        <div class="lista-dependentes">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td>Nome Dependente 1</td>
                                                </tr>
                                                <tr>
                                                    <td>Nome Dependente 2</td>
                                                </tr>
                                                <tr>
                                                    <td>Nome Dependente 3</td>
                                                </tr>
                                                <tr>
                                                    <td>Nome Dependente 4</td>
                                                </tr>
                                                <tr>
                                                    <td>Nome Dependente 5</td>
                                                </tr>
                                                <tr>
                                                    <td>Nome Dependente 6</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-adicionar-dependentes btn-vermelho"
                                                data-toggle="modal" data-target="#modalAdicionaDependente">
                                            Adicionar Dependentes <i class="fas fa-user-plus"></i></button>

                                        <!-- Modal adicionar dependente -->

                                        <div class="modal fade" id="modalAdicionaDependente" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-adiciona-dependente"
                                                 role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Novo
                                                            Dependente</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="inputNomeDependente">Nome</label>
                                                                <input type="text" class="form-control"
                                                                       id="inputNomeDependente"
                                                                       placeholder="Nome *">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputEmailDependente">E-mail</label>
                                                                <input type="email" class="form-control"
                                                                       id="inputEmailDependente"
                                                                       placeholder="E-mail">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputTelefoneDependente">Telefone</label>
                                                                <input type="text" class="form-control"
                                                                       id="inputTelefoneDependente"
                                                                       placeholder="Telefone">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="selectGenero">Gênero</label>
                                                                <select id="selectGenero" class="form-control">
                                                                    <option>Masculino</option>
                                                                    <option>Feminino</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group fc-tit-dn">
                                                                <label>Data de Nascimento</label>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectDiaDependente"
                                                                            class="form-control">
                                                                        <option>Dia</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectMesDependente"
                                                                            class="form-control">
                                                                        <option>Mês</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectAnoDependente"
                                                                            class="form-control">
                                                                        <option>Ano</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link"
                                                                data-dismiss="modal">Fechar
                                                        </button>
                                                        <button type="button" class="btn btn-vermelho">Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="label-titulo">Alteração Cadastral</span>
                                        <p>Para alterar as informações do seu cadastro é necessário entrar em contato
                                            com a nossa central de atendimento pelo número: <strong>(61)
                                                3221-5350</strong></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagamento -->

                            <div class="tab-pane fade" id="v-pills-pagamento" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">2
                            </div>

                            <!-- Notificações -->

                            <div class="tab-pane fade" id="v-pills-notificacoes" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <div class="opcoes-notificacao">
                                    <div class="tit-opcoes-notificacao">
                                        <span>E-mail</span>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleLembrete"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="toggleLembrete" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleConfirmacao"><strong>Confirmação</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="toggleConfirmacao" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleCancelamento"><strong>Cancelamento</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="toggleCancelamento" checked type="checkbox" data-toggle="toggle"
                                                   data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="tit-opcoes-notificacao tit-not-mob">
                                        <span>Mobile</span>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleLembreteMobile"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="toggleLembreteMobile" checked type="checkbox"
                                                   data-toggle="toggle" data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleConfirmacaoMobile"><strong>Confirmação</strong> de
                                                consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input id="toggleConfirmacaoMobile" checked type="checkbox"
                                                   data-toggle="toggle" data-on="Sim" data-off="Não">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-md-5">
                                            <label for="toggleCancelamentoMobile"><strong>Cancelamento</strong> de
                                                consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-md-2">
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
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <span class="label-titulo">Mais alguma sugestão?</span>
                                        <p>Deixe sua avaliação e nos ajude a deixar o Doctor Hoje melhor ainda.</p>
                                        <form>
                                            <div class="form-group">
                                                <textarea class="form-control" id="textareaSugestao" rows="6"></textarea>
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
                                        <button type="submit" class="btn btn-light">Sim</button>
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

            });

            // Estrelas avaliação


        </script>

    @endpush

@endsection