<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">
    <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>
    <link href="/libs/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/doutorhj.style.css">
    <script src="/libs/home-template/js/jquery-3.3.1.min.js"></script>
    <script src="/libs/home-template/js/popper.min.js"></script>
    <script src="/libs/home-template/js/bootstrap.min.js"></script>
    <script src="/libs/home-template/js/jquery.easing.min.js"></script>
    <script src="/libs/inputmask-4/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="/libs/notifyjs/dist/notify.min.js"></script>
    <script src="/libs/notifications/notify-metro.js"></script>
    <script src="/libs/comvex-template/js/jquery.core.js"></script>
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/comvex-template/pages/jquery.sweet-alert.init.js"></script>
    <script src="/libs/jquery-credit-card/jquery.creditCardValidator.js"></script>
    <script src="/js/plano.js"></script>
    <title>Planos Individuais - Doutor Hoje</title>

</head>
<body>
<div class="lp-pessoa-fisica-pagamento">
    <header>
        <div class="container">
            <img class="logo-drhj" src="/libs/home-template/img/logo-padrao.png" alt="Doutor Hoje">
        </div>
    </header>
    <section>
        <div class="container">
            <form method="post" id="msform" name="pagamento">
                <ul id="progressbar">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <fieldset>
                    <div class="tabela-planos">
                        <div class="area-tabela table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="regras">
                                            <h3>Escolha o plano<br>
                                                <strong>perfeito para você</strong></h3>
                                        </div>
                                    </th>
                                    <th scope="col">
                                        <div class="info-valores">
                                            <p class="nome-plano nm-blue">blue</p>
                                            <p class="apoio">consultas a partir de:</p>
                                            <p class="valor">
                                                <small>R$</small>
                                                35,50
                                            </p>
                                        </div>
                                    </th>
                                    <th scope="col">
                                        <div class="info-valores">
                                            <p class="nome-plano nm-black">black</p>
                                            <p class="apoio">consultas a partir de:</p>
                                            <p class="valor">
                                                <small>R$</small>
                                                69,50
                                            </p>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row" class="descricao">Consultas a partir de:</th>
                                    <td>
                                        <span>R$ 29,50</span>
                                        <p class="obs">apenas no Distrito Federal</p>
                                    </td>
                                    <td>
                                        <span>R$ 29,50</span>
                                        <p class="obs">apenas no Distrito Federal</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto de até 70% em Consultas e Exames</th>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto de até 80% em Consultas e Exames</th>
                                    <td></td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Programas de Promoção a Saúde e e incentivo de
                                        práticas
                                        saudáveis
                                    </th>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                                    </td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Orientação Médica por Telefone</th>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                                    </td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto em Medicamentos</th>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                                    </td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Consultas, Especialidades Básicas e Medicina
                                        Integrada R$
                                        29,50<br>
                                        <p class="cobertura">(Clínica Médica, Médico da Família, Cardiologia,
                                            Ginecologia,
                                            Dermatologia, Urologia, Psicologia, Acupuntura, Nutricionista e
                                            Fonoaudiologia)</p>
                                    </th>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                                    </td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Consultas Médicas em todas as especialidades R$
                                        29,50
                                    </th>
                                    <td></td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Bônus de 5 consultas por ano *<br>
                                        <p class="cobertura">(Clínica Médica, Médico da Família, Cardiologia,
                                            Ginecologia,
                                            Dermatologia, Urologia, Psicologia, Acupuntura, Nutricionista e
                                            Fonoaudiologia)</p>
                                    </th>
                                    <td></td>
                                    <td>
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td>
                                        <a href="javascript:;" style="width: 100%; line-height: 50px;" class="btn btn-blue blue" onClick="planosAdesao({dd:'foi', classe:'.blue'})">Assinar</a>
                                    </td>
                                    <td>
                                        <a href="javascript:;" style="width: 100%; line-height: 50px;" class="btn btn-black black" onClick="planosAdesao({dd:'foi', classe:'.blue'})">Assinar</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="area-form-cont">
                                <h2 class="fs-title">Cadastre-se para utilizar<br>
                                    <strong>o Doutor Hoje</strong></h2>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="nomeUsuario">Nome Completo</label>
                                    <input type="text" class="form-control col-sm-8" title="Informe um nome correto" required id="nomeUsuario" name="nomeUsuario" placeholder="Seu nome">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="emailUsuario">E-mail</label>
                                    <input type="email" class="form-control col-sm-8" required id="emailUsuario" name="emailUsuario" placeholder="exemplo@email.com.br">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cpfUsuario">CPF</label>
                                    <input type="text" class="form-control col-sm-8" required id="cpfUsuario" name="cpfUsuario" placeholder="000.000.000-00">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="celularUsuario">Celular com DDD</label>
                                    <input type="text" class="form-control col-sm-8" required id="celularUsuario" name="celularUsuario" placeholder="(00) 00000-0000">
                                </div>
                            </div>
                            <div class="area-dependente">
                                <div id="boxes" class="box-individual">

                                </div>
                                <a id="addbutton" class="btn-adicionar-dependente" href="javascript:;"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Adicionar Dependente</a>
                            </div>
                            <div class="area-btn">
                                <div>
                                    <div>
                                        <div>
                                            <input type="button" name="previous" class="btn btn-link previous action-button" value="voltar"/>
                                            <input type="submit" name="next" class="btn btn-blue next action-button primeiraPage" onclick="primeiraPagina()" value="Próximo"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="area-resumo-cont">
                                <div class="lista-pedido">
                                    <h3>Pedido</h3>
                                    <ul class="items-pedido"></ul>
                                </div>
                                <div class="codigo-corretor">
                                    Você comprou com um corretor?
                                    <div class="form-group">
                                        <label for="codigoCorretor1">Código do corretor</label>
                                        <input type="number" class="form-control" id="codigoCorretor" aria-describedby="codigoHelp" placeholder="Insira o código">
                                        <small id="codigoHelp" class="form-text text-muted">(Ignore esse campo se sua
                                            compra foi online)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="area-form-cont">
                                <h2 class="fs-title">Agora configure o<br>
                                    <strong>seu pagamento</strong></h2>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="numeroCartao">N. do cartão</label>
                                    <input type="text" class="form-control col-sm-8 input-numero-cartao cvx-checkout_card_number" id="numeroCartao" placeholder="0000 0000 0000 0000" onkeypress="onlyNumbers(event)" maxlength="16">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="nomeCartao">Nome impresso no
                                        cartão</label>
                                    <input type="text" class="form-control col-sm-8" id="nomeCartao" name="titular" placeholder="Nome do titular" maxlength="30">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="mesVencimento">Validade</label>
                                    <select class="form-control col-sm-2" name="mes" required id="mesVencimento">
                                        <option selected>Mês</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    <select class="form-control col-sm-2" name="ano" required id="anoVencimento">
                                        <option selected>Ano</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                        <option>2024</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cvvCartao">Código de segurança</label>
                                    <input type="text" class="form-control col-sm-2" name="codigo" required id="cvvCartao" placeholder="000" maxlength="3">
                                </div>
                            </div>

                            <div class="area-btn">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" value="" id="aceitaTermos">
                                    <label class="form-check-label link-termo-uso" for="aceitaTermos">

                                        Declaro que li e aceito os
                                        <a href="javascript:;" data-toggle="modal" data-target="#modalTermoUso">termos
                                            de uso</a> do Doutor Hoje
                                    </label>
                                </div>
                                <div>
                                    <div>
                                        <div>
                                            <input type="button" name="previous" class="btn btn-link previous action-button" value="voltar"/>
                                            <input type="submit" name="submit" class="btn btn-blue submit action-button  " onclick="finalizarCompra()" value="Finalizar compra"/>
                                            <input type="button" name="next" class="btn btn-blue next action-button prox" value="Próximo"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modalTermoUso" tabindex="-1" role="dialog" aria-labelledby="modalTermoUsoTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTermoUsoTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Fechar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="area-resumo-cont">
                                <div class="lista-pedido">
                                    <h3>Pedido</h3>
                                    <ul class="items-pedido"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="boas-vindas">
                        <div class="mensagem">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Muito bem!</h3>
                                    <p>Agora você já pode agendar sua consulta e/ou exame por um preço exclusivo</p>
                                </div>
                                <div class="col-md-6">
                                    <a href="https://www.doutorhoje.com.br" target="_blank">Agende sua 1a consulta</a>
                                </div>
                            </div>
                        </div>
                        <div class="imagem">

                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </section>
    {{--<footer class="footer-lp-pf">
        <div class="container">
            <p>Central de Atendimento</p>
            <p class="numeros">0800 727 3620 / (61) 3221 5350</p>
        </div>
    </footer>--}}
</div>
@include('flash-message')

<script>
    var laravel_token = '{{ csrf_token() }}';
    var plano = "plan_LDZN8oS7nh90argx";
    var plano_descricao = "Plano Blue";
    var valor = "36,50";
    var key = '{{ $values }}';
    var url = '{{ $url }}';

</script>
</body>
</html>