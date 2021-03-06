﻿<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">
    <title>@yield('title', 'DoutorHJ')</title>
    @push('style')
    <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <!-- Template css -->
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/fontawesome-all.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/jquery.datetimepicker.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap-toggle.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>
        <!-- DoutorHJ Reset CSS -->
        <link rel="stylesheet" href="/css/doutorhj.style.css">
        <!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
            <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
        </div>
        <script src="js/html5shiv.min.js"></script>
        <![endif]-->
        <script src="/libs/home-template/js/jquery-3.3.1.min.js"></script>
        <script src="/libs/comvex-template/js/modernizr.min.js"></script>
        <script src="/libs/home-template/js/jquery.datetimepicker.full.min.js"></script>
        <script src="/libs/home-template/js/bootstrap-toggle.js"></script>
    @endpush
    
    @stack('style')
</head>
<body>
<div class="tudo">
    <!-- <div class="page-loader page-loader-variant-1">
        <div><img class='img-responsive' style='margin-top: -20px;margin-left: -18px;' width='330' height='67' src='/libs/home-template/img/logos/logo-doutor-hoje-vertical.svg' alt='' />
            <div class="offset-top-41 text-center">
                <div class="spinner"></div>
            </div>
        </div>
        </div>  -->
    <header>
        <nav class="navbar navbar-expand-xl">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <h1>Doutor Hoje</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarMobile">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Indique seus Amigos</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Meus Agendamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Minha Conta</a>
                        </li>
                    </ul>
                    <div class="menu-area-logada">
                        <ul>
                            <li>
                                <span class="al-nome-usuario"></span>
                            </li>
                            <li>
                                <div class="dropdown opcoes-menu-usuario drop-notificacoes">
                                    <button class="btn dropdown-toggle btn-notificacoes btn-area-logada" title="Notificações" type="button" id="dropdownNotificacoes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>Notificações </span><i class="fa fa-bell"></i>
                                        <div class="numero-notificacoes">
                                            <span>5</span>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownNotificacoes">
                                        <ul>
                                            <li class="dropdown-item desativado">
                                                <span>Notificações</span>
                                            </li>
                                            <li class="dropdown-item mensagens-menu">
                                                <a href="#">O Dr. Hoje tem uma mensagem urgente. </a>
                                                <span>Há 3 horas</span>
                                            </li>
                                            <li class="dropdown-item mensagens-menu">
                                                <a href="#">Seu EXAME foi confirmado.</a>
                                                <span>Há 1 semana</span>
                                            </li>
                                            <li class="dropdown-item mensagens-menu">
                                                <a href="#">Sua CONSULTA ODONTOLÓGICA está agendada.</a>
                                                <span>Há 2 semanas</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown opcoes-menu-usuario drop-carrinho">
                                    <button class="btn dropdown-toggle btn-carrinho btn-area-logada" title="Meus exames" type="button" id="dropdownCarrinho" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>Pedidos </span><img src="{{ asset('img/pedidos-icon.png') }}" alt="Doutor Hoje">
                                        <!--<div class="numero-notificacoes">
                                            <span>2</span>
                                        </div>-->
                                    </button>
                                    <!--<div class="dropdown-menu" aria-labelledby="dropdownCarrinho">
                                        <ul>
                                            <li class="dropdown-item desativado">
                                                <span>Carrinho</span>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#">Nome Produto 1</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#">Nome Produto 2</a>
                                            </li>
                                        </ul>
                                    </div>-->
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')

    @include('includes/termos-condicoes-user')

    <footer>
        <div class="container">
            <div class="area-logo-rodape">
                <img src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <img class="logo-rodape" src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
                    <div class="info-atendimento">
                        <p>Central de Atendimento</p>
                        <p><strong><i class="fa fa-phone" aria-hidden="true"></i> 0800 727 3620</strong></p>
                        <p><strong><i class="fa fa-whatsapp" aria-hidden="true"></i> (61) 98679-2680</strong></p>
                        <p>Horário de atendimento das 8h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>Sobre Nós</h5>
                    <ul>
                        <li><a href="">Política de Privacidade</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modalTermosUser">Termo de Uso</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="endereco-site">
            <a href="{{ route('landing-page') }}">doutorhoje.com.br</a>
        </div>
        <div class="container">
            <p class="texto-legal-footer">Copyright © 2018 www.doutorhoje.com.br, TODOS OS DIREITOS RESERVADOS. Todo o conteúdo do site,
                todas as fotos, imagens, logotipos, marcas, dizeres, som, software, conjunto imagem, layout,
                aqui veiculados são de propriedade exclusiva do DOUTOR HOJE TECNOLOGIA LTDA. É vedada qualquer
                reprodução, total ou parcial, de qualquer elemento de identidade, sem expressa autorização.
                A violação de qualquer direito mencionado implicará na responsabilização cível e criminal nos
                termos da Lei. DOUTOR HOJE TECNOLOGIA LTDA - CNPJ: 21.520.255/0001-55 SCS Quadra 03 Bloco A
                Edifício Antônia Alves - CEP 70.303-907 - Brasília DF</p>
        </div>
    </footer>
</div>
@push('scripts')
    <script>
        var laravel_token = '{{ csrf_token() }}';
        var resizefunc = [];
    </script>
    <script src="/libs/home-template/js/popper.min.js"></script>
    <script src="/libs/home-template/js/bootstrap.min.js"></script>
@endpush
@stack('scripts')
</body>
</html>