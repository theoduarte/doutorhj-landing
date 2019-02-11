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
    <script src="/libs/card-master/dist/jquery.card.js"></script>


    <title>Planos Individuais - Doutor Hoje</title>
    <style>
        #checkout_card_number {
            background-image: url(cards.png);
            background-position: 3px 3px;
            background-size: 40px 252px; /* 89 x 560 */
            background-repeat: no-repeat;
            padding-left: 48px;
        }

        .spinner {

            background-color: #1b71b9cf;
            width: 100%;
            height: 100vh;
            line-height: 50px;
            text-align: center;

            color: white;

            /* pura mágica */
            position: fixed;
            z-index: 20;

        }

        .cube1, .cube2 {
            background-color: white;
            width: 18px;
            height: 18px;
            position: absolute;
            top: 50%;
            left: 50%;

            -webkit-animation: sk-cubemove 1.8s infinite ease-in-out;
            animation: sk-cubemove 1.8s infinite ease-in-out;
        }

        .cube2 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        @-webkit-keyframes sk-cubemove {
            25% {
                -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5)
            }
            50% {
                -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg)
            }
            75% {
                -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5)
            }
            100% {
                -webkit-transform: rotate(-360deg)
            }
        }

        @keyframes sk-cubemove {
            25% {
                transform: translateX(42px) rotate(-90deg) scale(0.5);
                -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5);
            }
            50% {
                transform: translateX(42px) translateY(42px) rotate(-179deg);
                -webkit-transform: translateX(42px) translateY(42px) rotate(-179deg);
            }
            50.1% {
                transform: translateX(42px) translateY(42px) rotate(-180deg);
                -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg);
            }
            75% {
                transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
                -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
            }
            100% {
                transform: rotate(-360deg);
                -webkit-transform: rotate(-360deg);
            }
        }
    </style>
</head>
<body>
<div class="lp-pessoa-fisica-pagamento">
    <div class="spinner" style="display:none">

        <div class="cube1"></div>
        <div class="cube2"></div>
    </div>
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
                                    <th scope="col " class="blue-style-ocult">
                                        <div class="info-valores">
                                            <p class="nome-plano nm-blue"></p>
                                            <p class="apoio">assinatura por:</p>
                                            <p class="valor val-blue">

                                            </p>
                                        </div>
                                    </th>
                                    <th scope="col" class="black-style-ocult">
                                        <div class="info-valores">
                                            <p class="nome-plano nm-black"></p>
                                            <p class="apoio">assinatura por:</p>
                                            <p class="valor val-black">

                                            </p>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row" class="descricao">Consultas a partir de:</th>
                                    <td class="blue-style-ocult">
                                        <span>R$ 29,50</span>
                                        <p class="obs">apenas no Distrito Federal</p>
                                    </td>
                                    <td class="black-style-ocult">
                                        <span>R$ 29,50</span>
                                        <p class="obs">apenas no Distrito Federal</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Rede com preços justos com mais de 2700
                                        especialidades, mais de 11500 exames e em todo o Brasil
                                    </th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto de até 70% em Consultas e Exames</th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-close.png" alt="Esse plano não contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto de até 80% em Consultas e Exames</th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-close.png" alt="Esse plano não contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Programas de Promoção a Saúde e e incentivo de
                                        práticas
                                        saudáveis
                                    </th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Orientação Médica por Telefone</th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Desconto em Medicamentos</th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
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
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Consultas Médicas em todas as especialidades R$
                                        29,50
                                    </th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-close.png" alt="Esse plano não contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="descricao">Bônus de 5 consultas por ano *<br>
                                        <p class="cobertura">(Clínica Médica, Médico da Família, Cardiologia,
                                            Ginecologia,
                                            Dermatologia, Urologia, Psicologia, Acupuntura, Nutricionista e
                                            Fonoaudiologia)</p>
                                    </th>
                                    <td class="blue-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-close.png" alt="Esse plano não contempla contempla este benefício">
                                    </td>
                                    <td class="black-style-ocult">
                                        <img src="/libs/home-template/img/l-pf-check.png" alt="Esse plano contempla este benefício">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="blue-style-ocult">
                                        <a href="javascript:;" style="width: 100%; line-height: 50px;" class="btn btn-blue blue assinar-bt-blue">Assinar</a>
                                    </td>
                                    <td class="black-style-ocult">
                                        <a href="javascript:;" style="width: 100%; line-height: 50px;" class="btn btn-black black assinar-bt-black">Assinar</a>
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

                                    <input type="text" maxlength="64" class="form-control col-sm-8 text-uppercase" title="Informe um nome correto" id="nomeUsuario" name="nomeUsuario" placeholder="Seu nome">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="emailUsuario">E-mail</label>
                                    <input type="email" maxlength="64" class="form-control col-sm-8 text-uppercase" id="emailUsuario" name="emailUsuario" placeholder="exemplo@email.com.br">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cpfUsuario">CPF</label>
                                    <input type="text" class="form-control col-sm-8" id="cpfUsuario" name="cpfUsuario" placeholder="000.000.000-00">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="celularUsuario">Celular com DDD</label>
                                    <input type="text" class="form-control col-sm-8" id="celularUsuario" name="celularUsuario" placeholder="(00) 00000-0000">
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
                                            <input type="button" name="next" class="btn btn-blue next action-button primeiraPage" onclick="primeiraPagina()" value="Próximo"/>
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
                                    Você comprou com um consultor de vendas?
                                    <div class="form-group">
                                        <label for="codigoCorretor1">Código do consultor</label>
                                        <input type="text" class="form-control" id="codigoCorretor" aria-describedby="codigoHelp" placeholder="Insira o código">
                                        <small id="codigoHelp" class="form-text text-muted">(Ignore esse campo caso não
                                            haja consultor)
                                        </small>
                                        <div class="consultor" style="display:none">
                                            <hr>
                                            <label for="codigoCorretor1">Consultor</label>
                                            <small id="consultorName" class="form-text text-muted"></small>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6 card-validation">
                            <div class="area-form-cont">

                                <h2 class="fs-title">Agora configure o<br>
                                    <strong>seu pagamento</strong></h2>

                                <div class="form-row">
                                    <div class="col-sm-12 card-wrapper"></div>
                                    <!-- <input type="text" class="form-control col-sm-8 input-numero-cartao" id="numeroCartao"   placeholder="0000 0000 0000 0000" onkeypress="onlyNumbers(event)" maxlength="16"> -->

                                </div>
                                <hr>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="numeroCartao">N. do cartão</label>
                                    <input type="text" class="form-control col-sm-7" name="numero" id="numero" placeholder="Insira o número do cartão" required>
                                    <!-- <input type="text" class="form-control col-sm-8 input-numero-cartao" id="numeroCartao"   placeholder="0000 0000 0000 0000" onkeypress="onlyNumbers(event)" maxlength="16"> -->
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="nomeCartao">Nome impresso no
                                        cartão</label>
                                    <input type="text" maxlength="40" class="form-control col-sm-7  text-uppercase" id="nome_impresso" name="nome_impresso" placeholder="Insira o nome do titular" required>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="mesVencimento">Validade</label>

                                    <input type="text" class="form-control col-sm-3" id="validade" name="validade" placeholder="MM/AA" required>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cvvCartao">Código de segurança</label>

                                    <input type="text" class="form-control col-sm-2" id="codigo_seg" name="codigo_seg" placeholder="CVC" required>
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
                                            <input type="button" name="submit" class="btn btn-blue submit action-button   finalizarCompra" value="Finalizar compra"/>
                                            <!--  <input type="button" name="next" class="btn btn-blue next action-button prox" value="Próximo"/> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalTermoUso" tabindex="-1" role="dialog" aria-labelledby="modalTermoUsoTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTermoUsoTitle">Termo de uso</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tabBlueTermos" role="tab" aria-controls="home" aria-selected="true">Plano
                                                        Blue</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tabBlackTermos" role="tab" aria-controls="profile" aria-selected="false">Plano
                                                        Black</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="tabBlueTermos" role="tabpanel" aria-labelledby="home-tab">
                                                    <h3>PRODUTO BLUE – INDIVIDUAL</h3>
                                                    <p>Por este instrumento, de um lado o a <strong>DOUTOR HOJE TECNOLOGIA LTDA</strong>,
                                                        Nome Fantasia: <strong>DOUTOR HOJE</strong>, pessoa jurídica de direito privado,
                                                        sociedade empresária limitada inscrita no CNPJ/MF sob o número
                                                        21.520.255/0001-55, com sede no SCS, Quadra 03, Bloco A, n° 107,
                                                        1° andar, Sala 103, Edifício: ANTONIA ALVES PEREIRA DE SOUSA-Asa
                                                        Sul, CEP 70.303-907, na cidade de Brasília, Distrito Federal,
                                                        neste ato representada na forma de seu Contrato Social, adiante
                                                        designada <span>CONTRATADA</span>, e do outro lado, o <strong>CLIENTE</strong>, designado e
                                                        qualificado no preâmbulo deste contrato, adiante designado
                                                        <span>CLIENTE</span>, resolvem celebrar este <strong>CONTRATO</strong> de acordo com as
                                                        cláusulas e condições a seguir.</p>
                                                    <h3>CLÁUSULA PRIMEIRA – DO OBJETO</h3>
                                                    <p><strong>1.1</strong> O presente Contrato tem por objeto o fornecimento dos
                                                        produtos e serviços oferecidos pela plataforma digital <strong>DOUTOR
                                                            HOJE</strong>, que consiste no agendamento e pagamento de consultas e
                                                        exames médicos a serem realizados na rede contratada da <strong>DOUTOR
                                                            HOJE.</strong></p>
                                                    <p><strong>1.2</strong> Fazem parte deste Contrato os Termos de Uso e Política de
                                                        Privacidade da plataforma <strong>DOUTOR HOJE</strong>, constante na área logada
                                                        do site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>, bem como eventuais anexos e
                                                        benefícios adicionais, quando for o caso.</p>
                                                    <h3>CLÁUSULA SEGUNDA - DAS OBRIGAÇÕES DAS PARTES</h3>
                                                    <p><strong>2.1</strong> São obrigações do <strong>CLIENTE: a)</strong> acessar o site
                                                        <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>, para o agendamento e pagamentos das
                                                        consultas e exames, cujo acesso será pessoal e protegido por
                                                        senha definida para cada <strong>CLIENTE,</strong> a cada novo acesso. <strong>b)</strong>
                                                        fornecer os dados necessários para o cadastro, tais como: I)
                                                        nome; II) data de nascimento; III) número CPF; IV) Telefone
                                                        celular; V) e-mail. <strong>c)</strong> pagar pelos serviços contratados na forma
                                                        estipulada na Cláusula do Pagamento.</p>
                                                    <p><strong>2.2</strong> São obrigações da <strong>CONTRATADA: a)</strong> disponibilizar rede de
                                                        prestadores de serviços parceiros nas diversas especialidades
                                                        reconhecidas pelo Conselho Federal de Medicina; <strong>b)</strong> efetuar a
                                                        cobrança direta dos valores referentes a consultas e exames
                                                        médicos contratados pelos <strong>CLIENTES. c)</strong> responsabilizar-se pelos
                                                        serviços tecnológicos e de agendamentos por ela oferecidos, bem
                                                        como pelas verificações e cadastro de profissionais e clínicas,
                                                        <strong>não se responsabilizando, em nenhuma hipótese,</strong> pela qualidade do
                                                        atendimento realizado pelo prestador de serviços, ficando as
                                                        partes deste contrato isentas de responsabilidade civil e penal
                                                        proveniente de execução dos serviços médicos ou paramédicos.</p>
                                                    <h3>CLÁUSULA TERCEIRA – DO PRODUTO, VALORES, PAGAMENTO E
                                                        REAJUSTE</h3>
                                                    <p><strong>3.1</strong> O produto <strong>DOUTOR HOJE</strong> disponibilizado ao <strong>CLIENTE</strong> será o
                                                        Produto <strong>BLUE</strong>, que possui as seguintes características:</p>
                                                    <p><strong>3.1.1</strong> Aquisição de Consultas a R$ 29,50 (vinte e nove reais e
                                                        cinquenta centavos) no Distrito Federal e nas especialidades
                                                        básicas: ginecologia, cardiologia, clínica médica, médico de
                                                        família, dermatologia, urologia, nutrição, acupuntura,
                                                        fonoaudiologia e psicologia, a serem realizadas <strong>exclusivamente
                                                            na rede credenciada indicada e agendada pela Central de
                                                            Atendimento DOUTOR HOJE.</strong></p>
                                                    <p><strong>3.1.2</strong> Demais consultas e exames, em qualquer localidade onde haja
                                                        rede <strong>DOUTOR HOJE,</strong> com preços especiais para o produto <strong>BLUE,</strong>
                                                        conforme constam no site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>.</p>
                                                    <p><strong>3.1.3</strong> Desconto em medicamentos: desconto nas farmácias
                                                        conveniadas à DOUTOR HOJE.</p>
                                                    <p><strong>3.1.4</strong> Orientação Médica por Telefone: Serviço de orientação
                                                        médica aos <strong>CLIENTES</strong> da <strong>DOUTOR HOJE</strong>, que visa ampliar o acesso às
                                                        informações de saúde e compreende:</p>
                                                    <ul>
                                                        <li>
                                                            <p>Ligação gratuita de telefone fixo ou móvel</p>
                                                        </li>
                                                        <li>
                                                            <p>Atendimento 24 horas por dia, 365 dias por ano</p>
                                                        </li>
                                                        <li>
                                                            <p>Obtenção de informações sobre saúde</p>
                                                        </li>
                                                        <li>
                                                            <p>Obtenção de dicas para melhorar a qualidade de vida</p>
                                                        </li>
                                                        <li>
                                                            <p>Tira dúvidas cotidianas, como sinais e sintomas de
                                                                doenças e também de medicamentos já prescritos</p>
                                                        </li>
                                                    </ul>
                                                    <p><strong>3.2</strong> Para a utilização da plataforma <strong>DOUTOR HOJE</strong> o <strong>CLIENTE</strong> pagará
                                                        à <strong>CONTRATADA a assinatura mensal de R$ 35,50 (trinta e cinco
                                                            reais e cinquenta centavos), por CLIENTE cadastrado (por pessoa
                                                            inscrita), referente ao produto BLUE.</strong> O pagamento será realizado
                                                        por meio de cartão de crédito.</p>
                                                    <p><strong>3.3</strong> A vigência destes benefícios terá início a contar da data do
                                                        primeiro pagamento, sendo esta a data de vencimento das demais
                                                        parcelas mensais.</p>
                                                    <p><strong>3.4</strong> Os valores estipulados nesta cláusula poderão ser reajustados
                                                        anualmente.</p>
                                                    <p><strong>3.5</strong> As aquisições de consultas e exames serão pagos diretamente
                                                        pelos <strong>CLIENTES</strong> ao <strong>DOUTOR HOJE</strong>. Os valores dos exames constam no
                                                        site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>, de acordo com o produto descrito
                                                        nesta Cláusula, e podem sofrer alterações a qualquer tempo. A
                                                        tabela de consultas será reajustada anualmente.</p>
                                                    <p><strong>3.6</strong> O <strong>CLIENTE</strong> poderá exercer o direito de arrependimento,
                                                        desistir da aquisição dos benefícios da <strong>DOUTOR HOJE</strong> e ser
                                                        reembolsado do valor pago, no prazo máximo de até 7 (sete) dias
                                                        contados da assinatura deste contrato, desde que ainda não tenha
                                                        realizado nenhuma consulta ou exame.</p>
                                                    <h3>CLÁUSULA QUARTA – DA VIGÊNCIA E RESCISÃO</h3>
                                                    <p><strong>4.1</strong> O presente Contrato vigorará a partir da data da sua
                                                        assinatura por prazo indeterminado.</p>
                                                    <p><strong>4.2</strong> <strong>Fidelidade:</strong> Este contrato não poderá ser rescindido ou
                                                        denunciado antes de 12 (doze) meses de vigência, sob pena de
                                                        pagamento de 20% (vinte por cento) do valor correspondente à
                                                        soma das mensalidades restantes e vincendas para completar o
                                                        período de 12 (doze) meses.</p>
                                                    <p><strong>4.3</strong> Após a vigência inicial de 12 (doze) meses, este contrato
                                                        poderá ser rescindido a qualquer tempo, sem multa, mediante
                                                        solicitação do <strong>CLIENTE</strong> pela Central de Atendimento ou pelo site
                                                        <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>.</p>
                                                    <h3>CLÁUSULA QUINTA - USO DA REDE DOUTOR HOJE</h3>
                                                    <p><strong>5.1</strong> A utilização da rede de assistência de consultas e exames se
                                                        faz exclusivamente por meio de uso da plataforma digital pelo
                                                        site www.doutorhoje.com.br ou pelo aplicativo. O cliente faz a
                                                        escolha da consulta ou exame, da especialidade, dia e horário
                                                        pretendidos, e após, efetua o pagamento, por cartão de crédito
                                                        ou transferência bancária. O dia e o horário indicados pelo
                                                        <strong>CLIENTE</strong> é um pré-agendamento, que será confirmado pelo DOUTOR
                                                        HOJE em até 48 (quarenta e oito) horas.</p>
                                                    <h3>CLÁUSULA SEXTA – DO FORO</h3>
                                                    <p><strong>6.1</strong> As partes elegem o foro da Circunscrição Judiciária de
                                                        Brasília – DF para dirimir qualquer divergência ou dúvida que
                                                        possa surgir, com renúncia de qualquer outro, por mais
                                                        privilegiado que seja.</p>
                                                </div>
                                                <div class="tab-pane fade" id="tabBlackTermos" role="tabpanel" aria-labelledby="profile-tab">
                                                    <h3>PRODUTO BLACK – INDIVIDUAL</h3>
                                                    <p>Por este instrumento, de um lado o a <strong>DOUTOR HOJE TECNOLOGIA LTDA,</strong>
                                                        Nome Fantasia: <strong>DOUTOR HOJE,</strong> pessoa jurídica de direito privado,
                                                        sociedade empresária limitada inscrita no CNPJ/MF sob o número
                                                        21.520.255/0001-55, com sede no SCS, Quadra 03, Bloco A, n° 107,
                                                        1° andar, Sala 103, Edifício: ANTONIA ALVES PEREIRA DE SOUSA-Asa
                                                        Sul, CEP 70.303-907, na cidade de Brasília, Distrito Federal,
                                                        neste ato representada na forma de seu Contrato Social, adiante
                                                        designada <strong>CONTRATADA,</strong> e do outro lado, o <strong>CLIENTE,</strong> designado e
                                                        qualificado no preâmbulo deste contrato, adiante designado
                                                        <strong>CLIENTE,</strong> resolvem celebrar este <strong>CONTRATO</strong> de acordo com as
                                                        cláusulas e condições a seguir. </p>
                                                    <h3>CLÁUSULA PRIMEIRA – DO OBJETO</h3>
                                                    <p><strong>1.1</strong> O presente Contrato tem por objeto o fornecimento dos
                                                        produtos e serviços oferecidos pela plataforma digital <strong>DOUTOR
                                                            HOJE,</strong> que consiste no agendamento e pagamento de consultas e
                                                        exames médicos a serem realizados na rede contratada da <strong>DOUTOR
                                                            HOJE.</strong></p>
                                                    <p><strong>1.2</strong> Fazem parte deste Contrato os Termos de Uso e Política de
                                                        Privacidade da plataforma <strong>DOUTOR HOJE,</strong> constante na área logada
                                                        do site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>, bem como eventuais anexos e
                                                        benefícios adicionais, quando for o caso.</p>
                                                    <h3>CLÁUSULA SEGUNDA - DAS OBRIGAÇÕES DAS PARTES</h3>
                                                    <p><strong>2.1</strong> São obrigações do <strong>CLIENTE: a)</strong> acessar o site
                                                        www.doutorhoje.com.br, para o agendamento e pagamentos das
                                                        consultas e exames, cujo acesso será pessoal e protegido por
                                                        senha definida para cada <strong>CLIENTE,</strong> a cada novo acesso. <strong>b)</strong>
                                                        fornecer os dados necessários para o cadastro, tais como: I)
                                                        nome; II) data de nascimento; III) número CPF; IV) Telefone
                                                        celular; V) e-mail. <strong>c)</strong> pagar pelos serviços contratados na forma
                                                        estipulada na Cláusula do Pagamento.</p>
                                                    <p><strong>2.2</strong> São obrigações da <strong>CONTRATADA: a)</strong> disponibilizar rede de
                                                        prestadores de serviços parceiros nas diversas especialidades
                                                        reconhecidas pelo Conselho Federal de Medicina; <strong>b)</strong> efetuar a
                                                        cobrança direta dos valores referentes a consultas e exames
                                                        médicos contratados pelos <strong>CLIENTES. c)</strong> responsabilizar-se pelos
                                                        serviços tecnológicos e de agendamentos por ela oferecidos, bem
                                                        como pelas verificações e cadastro de profissionais e clínicas,
                                                        <strong>não se responsabilizando, em nenhuma hipótese,</strong> pela qualidade do
                                                        atendimento realizado pelo prestador de serviços, ficando as
                                                        partes deste contrato isentas de responsabilidade civil e penal
                                                        proveniente de execução dos serviços médicos ou paramédicos.</p>
                                                    <h3>CLÁUSULA TERCEIRA – DO PRODUTO, VALORES, PAGAMENTO E
                                                        REAJUSTE</h3>
                                                    <p><strong>3.1</strong> O produto <strong>DOUTOR HOJE</strong> disponibilizado ao <strong>CLIENTE</strong> será o
                                                        Produto <strong>BLACK,</strong> que possui as seguintes características:</p>
                                                    <p><strong>3.1.1</strong> Bônus de 5 (cinco) Consultas por ano, por <strong>CLIENTE,</strong> no
                                                        Distrito Federal e nas especialidades básicas: ginecologia,
                                                        cardiologia, clínica médica, médico de família, dermatologia,
                                                        urologia, nutrição, acupuntura, fonoaudiologia e psicologia, a
                                                        serem realizadas <strong>exclusivamente na rede credenciada indicada e
                                                            agendada pela Central de Atendimento DOUTOR HOJE.</strong> </p>
                                                    <p><strong>3.1.2</strong> Tabela Especial Black:</p>
                                                    <ul>
                                                        <li>
                                                            <p>a) Consultas em todas as especialidades a R$ 29,50 (vinte
                                                                e nove reais e cinquenta centavos), constantes na rede
                                                                disponível no Distrito Federal; </p>
                                                        </li>
                                                        <li>
                                                            <p>b) Consultas e exames, em qualquer localidade onde haja
                                                                rede <strong>DOUTOR HOJE,</strong> com preços especiais para o produto
                                                                <strong>BLACK,</strong> conforme constam no site
                                                                <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>.</p>
                                                        </li>
                                                    </ul>
                                                    <p><strong>3.1.3</strong> Desconto em medicamentos: desconto nas farmácias
                                                        conveniadas à <strong>DOUTOR HOJE.</strong></p>
                                                    <p><strong>3.1.4</strong> Orientação Médica por Telefone: Serviço de orientação
                                                        médica aos <strong>CLIENTES</strong> da <strong>DOUTOR HOJE,</strong> que visa ampliar o acesso às
                                                        informações de saúde e compreende:</p>
                                                    <ul>
                                                        <li>
                                                            <p>• Ligação gratuita de telefone fixo ou móvel</p>
                                                        </li>
                                                        <li>
                                                            <p>• Atendimento 24 horas por dia, 365 dias por ano</p>
                                                        </li>
                                                        <li>
                                                            <p>• Obtenção de informações sobre saúde</p>
                                                        </li>
                                                        <li>
                                                            <p>• Obtenção de dicas para melhorar a qualidade de vida</p>
                                                        </li>
                                                        <li>
                                                            <p>• Tira dúvidas cotidianas, como sinais e sintomas de
                                                                doenças e também de medicamentos já prescritos</p>
                                                        </li>
                                                    </ul>
                                                    <p><strong>3.2</strong> Para a utilização da plataforma <strong>DOUTOR HOJE</strong> o <strong>CLIENTE</strong> pagará
                                                        à <strong>CONTRATADA</strong> a <strong>assinatura mensal de R$ 69,50 (sessenta e nove
                                                            reais e cinquenta centavos), por CLIENTE cadastrado (por pessoa
                                                            inscrita), referente ao produto BLACK.</strong> O pagamento será
                                                        realizado por meio de cartão de crédito.</p>
                                                    <p><strong>3.3</strong> A vigência destes benefícios terá início a contar da data do
                                                        primeiro pagamento, sendo esta a data de vencimento das demais
                                                        parcelas mensais.</p>
                                                    <p><strong>3.4</strong> Os valores estipulados nesta cláusula poderão ser reajustados
                                                        anualmente.</p>
                                                    <p><strong>3.5</strong> As aquisições de consultas e exames serão pagos diretamente
                                                        pelos <strong>CLIENTES</strong> ao <strong>DOUTOR HOJE.</strong> Os valores dos exames constam no
                                                        site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>, de acordo com o produto descrito
                                                        nesta Cláusula, e podem sofrer alterações a qualquer tempo. A
                                                        tabela de consultas será reajustada anualmente.</p>
                                                    <p><strong>3.6</strong> O <strong>CLIENTE</strong> poderá exercer o direito de arrependimento,
                                                        desistir da aquisição dos benefícios da <strong>DOUTOR HOJE</strong> e ser
                                                        reembolsado do valor pago, no prazo máximo de até 7 (sete) dias
                                                        contados da assinatura deste contrato, desde que ainda não tenha
                                                        realizado nenhuma consulta ou exame. </p>
                                                    <h3>CLÁUSULA QUARTA – DA VIGÊNCIA E RESCISÃO</h3>
                                                    <p><strong>4.1</strong> O presente Contrato vigorará a partir da data da sua
                                                        assinatura por prazo indeterminado.</p>
                                                    <p><strong>4.2</strong> <strong>Fidelidade:</strong> Este contrato não poderá ser rescindido ou
                                                        denunciado antes de 12 (doze) meses de vigência, sob pena de
                                                        pagamento de 20% (vinte por cento) do valor correspondente à
                                                        soma das mensalidades restantes e vincendas para completar o
                                                        período de 12 (doze) meses.</p>
                                                    <p><strong>4.3</strong> Após a vigência inicial de 12 (doze) meses, este contrato
                                                        poderá ser rescindido a qualquer tempo, sem multa, mediante
                                                        solicitação do <strong>CLIENTE</strong> pela Central de Atendimento ou pelo site
                                                        <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>.</p>
                                                    <h3>CLÁUSULA QUINTA - USO DA REDE DOUTOR HOJE</h3>
                                                    <p><strong>5.1</strong> A utilização da rede de assistência de consultas e exames se
                                                        faz exclusivamente por meio de uso da plataforma digital pelo
                                                        site <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a> ou pelo aplicativo. O cliente faz a
                                                        escolha da consulta ou exame, da especialidade, dia e horário
                                                        pretendidos, e após, efetua o pagamento, por cartão de crédito,
                                                        transferência bancária. O dia e o horário indicados pelo <strong>CLIENTE</strong>
                                                        é um pré-agendamento, que será confirmado pelo <strong>DOUTOR HOJE</strong> em
                                                        até 48 (quarenta e oito) horas.</p>
                                                    <h3>CLÁUSULA SEXTA – DO FORO</h3>
                                                    <p><strong>6.1</strong> As partes elegem o foro da Circunscrição Judiciária de
                                                        Brasília – DF para dirimir qualquer divergência ou dúvida que
                                                        possa surgir, com renúncia de qualquer outro, por mais
                                                        privilegiado que seja.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">
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
                                    <p>Dentro de 24 horas comerciais nós ativaremos o seu cadastro para você pode cuidar
                                        da sua saúde!‍</p>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="area-atendimento">
                                        <p>Central de Atendimento</p>
                                        <ul>
                                            <li>
                                                <p>0800 727-3620</p>
                                            </li>
                                            <li>
                                                <p>(61) 3221-5350</p>
                                            </li>
                                            <li>
                                                <p>(61) 98363-9661</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="imagem">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><strong>Verifique seu e-mail</strong></p>
                                    <p>Em alguns instantes você receberá o comprovante da assinatura Doutor Hoje.</p>
                                </div>
                                <div class="col-sm-6">
                                    <img src="/libs/home-template/img/l-pf-smartphone.png" alt="Pessoas no computador">
                                </div>
                            </div>
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
    var plano = '{{ $plano }}';
    var id = '{{ $idplano }}';
    var details = '{{ $detalhes }}';
    var all = '{{ $all }}';
    var corretorkey = "csadfasdfsdfdfdsa";
    var url_corretor = '{{$url_corretor}}';

    var plano_descricao = "Plano Blue";
    var valor = "36,50";
    var key = '{{ $values }}';
    var url = '{{ $url }}';
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.card-validation').card({
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '.card-wrapper', // *required*

            formSelectors: {
                numberInput: 'input#numero', // optional — default input[name="number"]
                expiryInput: 'input#validade', // optional — default input[name="expiry"]
                cvcInput: 'input#codigo_seg', // optional — default input[name="cvc"]
                nameInput: 'input#nome_impresso' // optional - defaults input[name="name"]
            },

            width: '100%', // optional — default 350px
            formatting: true, // optional - default true

            // Strings for translation - optional
            messages: {
                validDate: 'valid\ndate', // optional - default 'valid\nthru'
                monthYear: 'mm/yy', // optional - default 'month/year'
            },

            // Default placeholders for rendered fields - optional
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Nome Impresso',
                expiry: '••/••',
                cvc: '•••'
            },

            masks: {
                cardNumber: '•' // optional - mask card number
            }

            // if true, will log helpful messages for setting up Card

        });
    });
</script>

</body>
</html>