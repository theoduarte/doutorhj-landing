<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
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
    
    <!-- Sweet Alert css -->
    <link href="/libs/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Template theme CSS -->
<!--     <link rel="stylesheet" href="/libs/comvex-template/css/style_dark.css"> -->
    	
    <!-- DoutorHJ Reset CSS -->
    <link rel="stylesheet" href="/css/doutorhj.style.css">
    
    <script src="/libs/home-template/js/jquery-3.3.1.min.js"></script>
	<script src="/libs/home-template/js/popper.min.js"></script>
	<script src="/libs/home-template/js/bootstrap.min.js"></script>
	<script src="/libs/inputmask-4/dist/min/jquery.inputmask.bundle.min.js"></script>
    
<!--     <script src="/libs/comvex-template/js/jquery.min.js"></script> -->
<!-- 	<script src="/libs/home-template/js/popper.min.js"></script> -->
<!-- 	<script src="/libs/home-template/js/bootstrap.min.js"></script> -->
    
    <!-- Notification js -->
	<script src="/libs/notifyjs/dist/notify.min.js"></script>
	<script src="/libs/notifications/notify-metro.js"></script>
	
	<script src="/libs/comvex-template/js/jquery.core.js"></script>
	
	<!-- Sweet Alert Js  -->
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/comvex-template/pages/jquery.sweet-alert.init.js"></script>

    <title>Planos Individuais - Doutor Hoje</title>
</head>
<body>
<div class="lp-pessoa-fisica">
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="/"><img src="/libs/home-template/img/logo-padrao.png" alt="Doutor Hoje"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#planos">Planos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#vantagens">Vantagens</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#perguntas">Perguntas Frequentes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#depoimentos">Depoimentos</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <a href="#contato" class="btn">Assine Agora</a>
                    </form>
                </div>
            </nav>
        </div>
    </header>
    <section>
        <div class="info-corporativo">
            <div class="container">
                <p>Corporativo</p>
            </div>
        </div>
        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 apresentacao">
                        <p>O Doutor Hoje é uma rede que oferece </p>
                        <h1>consultas exames a<br><strong>preços justos.</strong></h1>
                        <img src="/libs/home-template/img/l-pf-cartoes.png" alt="">
                    </div>
                    <div class="col-sm-12 col-md-6 imagem">
                        <img src="/libs/home-template/img/l-pf-banner-topo.png" alt="Menina no colo da mãe, sorrindo, sendo atendida por um médico">
                    </div>
                </div>
            </div>
        </div>
        <div class="tabela-planos"id="planos">
            <div class="container">
                <div class="area-tabela table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class="regras">
                                    <p>Assinando os planos Blue ou Black você pode ter acesso a consultas médicas a
                                        partir de <strong>R$ 29,50*</strong> e descontos de até 80% nos exames.</p>
                                    <p>Na assinatura <strong>Black</strong> Você ainda conta com o bônus de <strong>5
                                            consultas grátis*</strong> em 2019 nas especialidades básicas.</p>
                                    <span>*Válido no DF, consulte demais estados.</span><br>
                                    <span>*Marcação via central de atendimento. 0800 Doutor Hoje</span>
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
                                    <a href="#contato" class="btn btn-blue">Assinar</a>
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
                                    <a href="#contato" class="btn btn-black">Assinar</a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row" class="descricao">Desconto de até 70% em Exames</th>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                            </td>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="descricao">Desconto de até 80% em Exames</th>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                            </td>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="descricao">Programas de Promoção a Saúde e e incentivo de práticas
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
                            <th scope="row" class="descricao">Consultas Especialidades Básicas e Medicina Integrada R$
                                29,50<br>
                                <p class="cobertura">(Clínica Médica, Médico da Família, Cardiologia, Ginecologia,
                                    Dermatologia, Urologia, Psicologia, Acupuntura, Nutricionista e Fonoaudiologia)</p>
                            </th>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano blue contempla este benefício">
                            </td>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="descricao">Consultas Médicas em todas as especialidades R$ 29,50</th>
                            <td></td>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="descricao">Bônus de 5 consultas no 1˚ano</th>
                            <td></td>
                            <td>
                                <img src="/libs/home-template/img/l-pf-check.png" alt="O plano black contempla este benefício">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td><a href="#contato" class="btn btn-blue">Assinar o Plano Blue</a></td>
                            <td><a href="#contato" class="btn btn-black">Assinar o Plano Black</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="beneficios" id="beneficios">
            <div class="container">
                <h3>A rede de saúde Doutor Hoje</h3>
                <div class="row intro">
                    <div class="col-sm-12 col-md-6">
                        <p>O Doutor Hoje é uma rede de consultórios, laboratórios e clínicas presentes em todos os
                            estados do Brasil com consultas e exames médicos a preços acessíveis. <strong>Uma
                                alternativa para
                                quem não tem um plano de saúde.</strong></p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <p>Trata-se de uma solução em saúde para a sua família, com o melhor custo benefício e alta
                            tecnologia. Assim oferecemos um sistema eficiente e integrado de forma que seu atendimento é
                            feito do início ao fim com responsabilidade, ética e competência.</p>
                    </div>
                </div>
                <div class="row area-beneficios">
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-vantagens.png" alt="Vantagens">
                            <p class="titulo">Vantagens</p>
                            <div class="linha"></div>
                            <p class="texto">Com o plano de benefícios Doutor Hoje você tem os melhores preços em
                                consultas e exames em todo Brasil.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-aplicativo.png" alt="Aplicativo Doutor Hoje">
                            <p class="titulo">Aplicativo Doutor Hoje</p>
                            <div class="linha"></div>
                            <p class="texto">Baixe nas lojas. Com ele você tem acesso à agenda de exames e consultas e
                                lembretes e
                                incentivo à programas de saúde</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-consultas.png" alt="Consultas Médicas">
                            <p class="titulo">Consultas Médicas</p>
                            <div class="linha"></div>
                            <p class="texto">Milhares de médicos em todas especialidades, sendo os mais bem avaliados
                                profissionais
                                da saúde.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-exames.png" alt="Exames">
                            <p class="titulo">Exames</p>
                            <div class="linha"></div>
                            <p class="texto">São mais de 3.000 tipos de exames e os mais conceituados laboratórios do
                                país.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">

                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-cobertura.png" alt="Em todo Brasil">
                            <p class="titulo">Em todo Brasil</p>
                            <div class="linha"></div>
                            <p class="texto">Presente em todos os estados brasileiros. Basta localizar o lugar mais
                                próximo de você.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="box-beneficios">
                            <img src="/libs/home-template/img/l-pf-icone-lembrete.png" alt="Lembretes">
                            <p class="titulo">Lembretes</p>
                            <div class="linha"></div>
                            <p class="texto">Nós enviamos um lembrete antes da sua consulta ou exame diretamente  na sua
                                agenda.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">

                    </div>
                </div>
            </div>
        </div>
        <div class="numeros" id="numeros">
            <div class="container">
                <h3>Números impressionantes.</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="box">
                            <p>2.759</p>
                            <span>Especialidades</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="box">
                            <p>11.598</p>
                            <span>Exames</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="box">
                            <p>27</p>
                            <span>Capitais</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="perguntas" id="perguntas">
            <div class="container">
                <h3>Perguntas Frequentes</h3>
                <div class="area-perguntas">
                    <h4>Sobre o Doutor Hoje</h4>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Comprei o plano Black e preciso utilizar meu bônus de 5 consultas. Como marcar?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="panel-body">
                                    <p> Ligue para 0800 727 36 20 e agende seu horário.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Como funciona Doutor Hoje?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="panel-body">
                                    <p>Com ou sem assinatura de planos Você pode comprar consultas e exames a preços
                                        justos. Basta acessar doutor.com.br escolher qual serviço de saúde precisa,
                                        agendar e pagar com qualquer cartão de crédito.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Doutor Hoje é um Plano de Saúde?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="panel-body">
                                    <p>Não. O Doutor Hoje é uma rede de saúde disponibiliza acesso a consultas e exames
                                        a preços justos.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Quem emite o cartão Doutor Hoje?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                <div class="panel-body">
                                    <p>Não necessariamente. Você pode comprar qualquer consulta ou exames no site Doutor
                                        Hoje. Porém assinando o Blue ou Black Você tem acesso a consulta a partir de R$
                                        29,50 e descontos de até 80% em exames.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="planos" id="planos">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6">

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="titulo">
                            <p><strong>Escolha o plano:</strong><br>
                                perfeito para você</p>
                            <p class="auxiliar">Sem restrição, o Doutor Hoje é<br>
                                para toda a família!</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="box-planos">
                                    <img src="/libs/home-template/img/l-pf-cartao-blue.png" alt="Cartão Blue">
                                    <div class="texto">
                                        <p class="nome-plano nome-blue">blue</p>
                                        <p class="apoio">consultas a partir de:</p>
                                        <p class="valor">R$29,50</p>
                                        <p class="frequencia">R$ 29,50 MENSAIS</p>
                                        <a href="#contato" class="btn btn-blue">Peça o seu</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="box-planos">
                                    <img src="/libs/home-template/img/l-pf-cartao-black.png" alt="Cartão Black">
                                    <div class="texto">
                                        <p class="nome-plano">black</p>
                                        <p class="apoio">consultas a partir de:</p>
                                        <p class="valor">R$29,50</p>
                                        <p class="frequencia">R$ 29,50 MENSAIS</p>
                                        <a href="#contato" class="btn btn-black">Peça o seu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="depoimentos" id="depoimentos">
            <div class="container">
                <h3>Veja os nossos clientes dizem sobre nós</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="box-depoimento">
                            <img src="/libs/home-template/img/l-pf-cliente1.png" alt="">
                            <p class="nome">Fernanda Lúcia de Souza</p>
                            <p class="funcao">Cliente Doutor Hoje Blue</p>
                            <p class="texto">O serviço é excelente e muito rápido. Já fiz minhas consultas de rotinas e
                                as dos meus filhos e economizei bastante em relação ao particular.</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="box-depoimento">
                            <img src="/libs/home-template/img/l-pf-cliente1.png" alt="">
                            <p class="nome">Fernanda Lúcia de Souza</p>
                            <p class="funcao">Cliente Doutor Hoje Blue</p>
                            <p class="texto">O serviço é excelente e muito rápido. Já fiz minhas consultas de rotinas e
                                as dos meus filhos e economizei bastante em relação ao particular.</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="box-depoimento">
                            <img src="/libs/home-template/img/l-pf-cliente1.png" alt="">
                            <p class="nome">Fernanda Lúcia de Souza</p>
                            <p class="funcao">Cliente Doutor Hoje Blue</p>
                            <p class="texto">O serviço é excelente e muito rápido. Já fiz minhas consultas de rotinas e
                                as dos meus filhos e economizei bastante em relação ao particular.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contato" id="contato">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="box-contato">
                            <div class="textura"></div>
                            <div class="area-contato">
                                <div class="area-form">
                                    <p class="titulo">Tem interesse?</p>
                                    <p class="sub">Fale com a gente </p>
                                    <form id="form-contato-pf" class="form-horizontal m-t-20" action="{{ route('enviar-email') }}" method="post" onsubmit="return validarContato()">
                    					{!! csrf_field() !!}
                                        <div class="form-group {{ $errors->has('nome') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" placeholder="Nome" required="required">
                                            @if ($errors->has('nome'))
                            				<span class="help-block text-danger"><strong>{{ $errors->first('nome') }}</strong></span>
		                    				@endif
                                        </div>
                                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="E-mail" required="required">
                                            @if ($errors->has('email'))
                            				<span class="help-block text-danger"><strong>{{ $errors->first('email') }}</strong></span>
		                    				@endif
                                        </div>
                                        <div class="form-group {{ $errors->has('telefone') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control mascaraTelefone" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="Telefone" required="required">
                                            @if ($errors->has('telefone'))
                            				<span class="help-block text-danger"><strong>{{ $errors->first('telefone') }}</strong></span>
		                    				@endif
                                        </div>
                                        <div class="form-group {{ $errors->has('mensagem') ? ' has-error' : '' }}">
                                            <textarea class="form-control" id="mensagem" name="mensagem" rows="6" placeholder="Mensagem" required="required">{{ old('mensagem') }}</textarea>
                                            @if ($errors->has('mensagem'))
                            				<span class="help-block text-danger"><strong>{{ $errors->first('mensagem') }}</strong></span>
		                    				@endif
                                        </div>
                                        <button type="submit" id="btn-submit" class="btn" >Enviar</button>
                                    </form>
                                </div>
                                <div class="area-telefone">
                                    <div class="icone">
                                        <img src="/libs/home-template/img/l-pf-icone-contato.png" alt="">
                                    </div>
                                    <div class="telefones">
                                        <p class="titulo">Central de Atendimento</p>
                                        <p class="numeros-tel">0800 727 3620</p>
                                        <p class="numeros-tel">(61) 3221 5350</p>
                                        <p class="numeros-tel">(61) 9 8363 9661</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer-lp-pf">
        <div class="container">
            <div class="area-menu-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <p class="titulo">Sobre nós</p>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <ul>
                                    <li><a href="#planos">Planos</a></li>
                                    <li><a href="#vantagens">Vantagens</a></li>
                                    <li><a href="#perguntas">Perguntas Frequentes</a></li>
                                    <li><a href="#depoimentos">Depoimentos</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <ul>
                                    <li><a href="mailto:contato@doutorhoje.com.br">contato@doutorhoje.com.br</a></li>
                                    <li><a href="tel:08007273620">0800 727 3620</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="area-app">
                            <img class="smartphone" src="/libs/home-template/img/l-pf-smartphone.png" alt="">
                            <div class="links">
                                <img class="logo" src="/libs/home-template/img/logo-padrao.png" alt="" class="drhj">
                                <p>Baixe o app</p>
                                <a href="https://itunes.apple.com/br/app/doutor-hoje/id1442870073" target="_blank"><img src="/libs/home-template/img/l-pf-app-apple.png" alt="App Store"></a>
                                <a href="https://play.google.com/store/apps/details?id=br.com.comveex.doctor" target="_blank"><img src="/libs/home-template/img/l-pf-app-google.png" alt="Google Play"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="faixa">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <p>Copyright © 2018 Doutor Hoje - Todos os direitos reservados</p>
                    </div>
                    <div class="col-6">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/DoctorHoje/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/doutor_hoje/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@include('flash-message')
<script type="text/javascript">
$(document).ready(function() {
	
	$(".mascaraTelefone").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999"],
        keepStatic: true
    });
});

function validarContato() {

	if($('#nome').val().length === 0 || $('#email').val().length === 0 || $('#telefone').val().length === 0 || $('#mensagem').val().length === 0 || isEmail($('email').val() == false)) {
		return false;
	}

	$('#btn-submit').attr('disabled', 'disabled').html('<i class="fa fa-spinner fa-spin"></i> Enviando...');

	return true;
}

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!regex.test(email)) {
		return false;
	} else {
	    return true;
	}
}
</script>
</body>
</html>