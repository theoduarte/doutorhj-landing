<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">
    <title>@yield('title', 'Doutor HJ')</title>
@push('style')
    <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <!-- Template css -->
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/fontawesome-all.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/jquery.datetimepicker.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>
        <!-- DoutorHJ Reset CSS -->
        <link rel="stylesheet" href="/css/doutorhj.style.css">
        <!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
            <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img
                    src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                    alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
        </div>
        <script src="js/html5shiv.min.js"></script>
        <![endif]-->
        <script src="/libs/home-template/js/jquery-3.3.1.min.js"></script>
        <script src="/libs/comvex-template/js/modernizr.min.js"></script>
        <script src="/libs/home-template/js/jquery.datetimepicker.full.min.js"></script>
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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMobile"
                        aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarMobile">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">O que é o Doutor Hoje?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Como funciona?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Benefícios da parceria</a>
                        </li>
                        <li class="nav-item nav-item-mobile">
                            <a class="nav-link" href="#">Contato</a>
                        </li>
                        <li class="nav-item btn-entrar">
                            <a class="nav-link" href="#">Entrar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')
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
                        <p><strong>(61) 3221-5350</strong></p>
                        <p>Horário de atendimento das 9h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 parte-medico medico-parte-2">
                    <img src="/libs/home-template/img/medico-parte2.png" alt="">
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>PROFISSIONAIS DE SAÚDE </h5>
                    <ul>
                        <li><a href="">Seja um parceiro</a></li>
                        <li><a href="">Vantagens</a></li>
                        <li><a href="">Área restrita</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="endereco-site">
            <a href="www.doutorhoje.com.br">www.doutorhoje.com.br</a>
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