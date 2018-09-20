<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5GQV33K');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhoje saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">

    <title>@yield('title', 'DoutorHJ')</title>

@push('style')

    <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">

        <!-- Template css -->
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>

        <!-- Sweet Alert css -->
        <link href="/libs/sweet-alert/sweetalert2.css" rel="stylesheet" type="text/css"/>

        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/jquery.datetimepicker.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/switchery.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/select2/css/select2.min.css"/>

        <!-- Carosssel logo parceiros -->
        <link rel="stylesheet" href="/libs/owlcarousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="/libs/owlcarousel/assets/owl.theme.default.min.css">

        <!-- Float WhatsApp -->
        <link rel="stylesheet" href="/libs/floating-whatsapp/floating-wpp.css">

        <!-- JQuery Autocomplete -->
        <link rel="stylesheet" href="/libs/jquery-autocomplete/css/styles.css">

        <!-- DoutorHJ Reset CSS -->
        <link rel="stylesheet" href="/css/doutorhj.style.css">

        <!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
            <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
        </div>
        <script src="js/html5shiv.min.js"></script>
        <![endif]-->

        <script src="/libs/comvex-template/js/jquery.min.js"></script>
        <script src="/libs/comvex-template/js/modernizr.min.js"></script>
        <script src="/libs/home-template/js/jquery.datetimepicker.full.min.js"></script>
        <script src="/libs/home-template/js/popper.min.js"></script>
        <script src="/libs/home-template/js/bootstrap.min.js"></script>
        <script src="/libs/home-template/js/bootstrap.bundle.min.js"></script>
        <script src="/libs/select2/js/select2.min.js"></script>
        <script src="/libs/select2/js/i18n/pt-BR.js"></script>
        <script src="/libs/jquery-autocomplete/js/jquery.autocomplete.min.js"></script>
        <script src="/libs/switchery/switchery.min.js"></script>
        <script src="/libs/owlcarousel/owl.carousel.min.js"></script>
        <script src="/libs/floating-whatsapp/floating-wpp.min.js"></script>

        <script src="/libs/jquery-credit-card/jquery.creditCardValidator.js"></script>

        <script src="/js/doutorhj.script.js"></script>

        <script type="text/javascript">
            var laravel_token = '{{ csrf_token() }}';
        </script>

    @endpush

    @stack('style')
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GQV33K" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="tudo">
    <header>
        @if (Auth::check())
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('meus-agendamentos') }}">Meus Agendamentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('minha-conta') }}">Minha Conta</a>
                            </li>
                        </ul>
                        <div class="menu-area-logada">
                            <ul>
                                <li>
                                    <span class="al-nome-usuario">{{ Auth::user()->paciente->nm_primario }}</span>
                                </li>
                                <li>
                                    <div class="dropdown opcoes-menu-usuario drop-notificacoes">
                                    <!-- <button class="btn dropdown-toggle btn-notificacoes btn-area-logada" title="Notificações" type="button" id="dropdownNotificacoes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span>Notificações </span><i class="fa fa-bell"></i>
                                            <div class="numero-notificacoes">
                                                <span>{{ $num_total_notificacoes }}</span>
                                            </div>
                                        </button> -->
                                        <div class="dropdown-menu dropdownNotificacoes" aria-labelledby="dropdownNotificacoes">
                                            <ul>
                                                <li class="dropdown-item desativado">
                                                    <span style="font-size: 14px;">Notificações</span>
                                                </li>
                                            @for($i = 0; $i < sizeof($notificacoes_app); $i++)
                                                <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                        <div class="notify-icon @if($notificacoes_app[$i]->visualizado) bg-primary @else bg-success @endif">
                                                            <i class="fa @if($notificacoes_app[$i]->visualizado)  fa-envelope-open  @else fa-envelope-o @endif"></i>
                                                        </div>
                                                        <p class="notify-details">Contato
                                                            <b>{{ $notificacoes_app[$i]->nome_remetente }}</b><br>
                                                            <small class="text-muted">{{ $notificacoes_app[$i]->time_ago }}</small>
                                                        </p>
                                                    </a>
                                            @endfor
                                            <!-- <li class="dropdown-item mensagens-menu">
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
                                                    </li> -->
                                                @if(sizeof($notificacoes_app) > 0)
                                                    <a href="/notificacoes" class="dropdown-item notify-item notify-all">Ver
                                                        Tudo</a>
                                                @else
                                                    <li class="dropdown-item mensagens-menu">
                                                        <a href="#">NENHUM ENCONTRADA</a>
                                                        <!-- <span>Há 2 semanas</span> -->
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown opcoes-menu-usuario drop-carrinho">
                                        <button class="btn dropdown-toggle btn-carrinho btn-area-logada" title="Carrinho de Compras" type="button" id="dropdownCarrinho" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.location.href=$(this).find('a').attr('href')">
                                            <a href="/carrinho" class="btn-carrinho"><img src="{{ asset('img/pedidos-icon.png') }}" alt="Pedidos"> </a>
                                            <div class="numero-notificacoes">
                                                <span>{{ $cvx_num_itens_carrinho }}</span>
                                            </div>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        @else
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
                                <a class="nav-link" href="{{ route('landing-page') }}#area-sobre">O que é o Doutor
                                    Hoje</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('landing-page') }}#como-funciona">Como funciona</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('landing-page') }}#vantagens">Vantagens</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="/contato">Contato</a>
                            </li> -->
                            <li class="nav-item btn-profissional">
                                <a class="nav-link" href="https://prestador.doutorhoje.com.br">Seja um parceiro</a>
                            </li>
                            <li class="nav-item btn-entrar">
                                <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
    </header>

    @include('flash-message')
    @yield('content')

    @if (!Auth::check())
        @include('includes/termos-condicoes')
        <footer class="footer-default">
            <div class="floating-wpp"></div>
            <div class="container">
                <div class="area-logo-rodape">
                    <img src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
                </div>
                <!-- teste smartgit -->
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <img class="logo-rodape" src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
                        <div class="info-atendimento">
                            <p>Central de Atendimento</p>
                            <p><strong><i class="fa fa-phone" aria-hidden="true"></i> (61) 3221-5350</strong></p>
                            <p><strong><i class="fa fa-whatsapp" aria-hidden="true"></i> (61) 98679-2680</strong></p>
                            <p>Horário de atendimento das 8h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>Sobre Nós</h5>
                        <ul>
                            <li><a href="{{ route('landing-page') }}#area-sobre">O que é o Doutor Hoje?</a></li>
                            <li><a href="{{ route('landing-page') }}#como-funciona">Como Funciona</a></li>
                            <li><a href="{{ route('landing-page') }}#vantagens">Vantagens</a></li>
                            <li><a href="{{ route('landing-page') }}#" data-toggle="modal" data-target="#modalTermos">Termo
                                    de Uso & Política de Privacidade</a></li>
                            {{--<li><a href="">Trabalhe Conosco</a></li>--}}
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>Clientes</h5>
                        <ul>
                            <li><a href="{{ route('login') }}">Seja Cliente</a></li>
                            <li><a href="{{ route('login') }}">Área restrita</a></li>
                            <li><a href="{{ route('landing-page') }}#busca-home">Agende Consulta</a></li>
                            <li><a href="{{ route('landing-page') }}#busca-home">Agende Exame</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>PROFISSIONAIS DE SAÚDE </h5>
                        <ul>
                            <li><a href="https://prestador.doutorhoje.com.br/">Seja um parceiro</a></li>
                            <li><a href="#vantagens">Vantagens</a></li>
                            <li><a href="https://prestador.doutorhoje.com.br/login/">Área restrita</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="endereco-site">
                <div class="container">
                    <a href="{{ route('landing-page') }}">doutorhoje.com.br</a>
                    <div class="redes-sociais">
                        <a href="https://www.instagram.com/doutor_hoje/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://www.facebook.com/DoctorHoje/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                    </div>
                </div>
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
    @else
        @include('includes/termos-condicoes-user')
        <footer class="footer-logado">
            <div class="container">
                <div class="area-logo-rodape">
                    <img src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
                </div>
                <!-- teste smartgit -->
                <div class="row">
                    <div class="col-sm-6 col-md-9">
                        <img class="logo-rodape" src="/libs/home-template/img/logo-branca.png" alt="Doutor Hoje">
                        <div class="info-atendimento">
                            <p>Central de Atendimento</p>
                            <p><strong><i class="fa fa-phone" aria-hidden="true"></i> (61) 3221-5350</strong></p>
                            <p><strong><i class="fa fa-whatsapp" aria-hidden="true"></i> (61) 98679-2680</strong></p>
                            <p>Horário de atendimento das 8h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>Sobre Nós</h5>
                        <ul>
                            <li>
                                <a href="{{ route('landing-page') }}#" data-toggle="modal" data-target="#modalTermosUsers">Termo
                                    de Uso & Política de Privacidade</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="endereco-site">
                <div class="container">
                    <a href="{{ route('landing-page') }}">doutorhoje.com.br</a>
                    <div class="redes-sociais">
                        <a href="https://www.instagram.com/doutor_hoje/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://www.facebook.com/DoctorHoje/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                    </div>
                </div>
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
    @endif

</div>
@push('scripts')
    <script>
        var laravel_token = '{{ csrf_token() }}';
        var resizefunc = [];
    </script>

    <script src="/libs/switchery/switchery.min.js"></script>

    <!-- Counter Up  -->
    <script src="/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="/libs/counterup/jquery.counterup.min.js"></script>

    <!-- skycons -->
    <script src="/libs/skyicons/skycons.min.js" type="text/javascript"></script>

    <!-- Sweet Alert Js  -->
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/comvex-template/pages/jquery.sweet-alert.init.js"></script>

    <!-- Multi Select Js Quicksearch Js  -->
    <script type="text/javascript" src="/libs/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/libs/jquery-quicksearch/jquery.quicksearch.js"></script>

    <!-- Notification js -->
    <script src="/libs/notifyjs/dist/notify.min.js"></script>
    <script src="/libs/notifications/notify-metro.js"></script>

    <!-- Plugins  -->
    <script type="text/javascript" src="/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript" src="/libs/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script type="text/javascript" src="/libs/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>

    <script type="text/javascript" src="/libs/moment/moment.js"></script>
    <script type="text/javascript" src="/libs/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

    <script type="text/javascript" src="/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/libs/bootstrap-daterangepicker/daterangepicker.js"></script>




    <script type="text/javascript" src="/js/jquery.maskMoney.min.js"></script>

    <!-- Custom main Js -->
    <script src="/libs/comvex-template/js/jquery.core.js"></script>
    <!-- <script src="/libs/comvex-template/js/jquery.app.js"></script> -->
    <!-- <script src="/libs/comvex-template/js/jquery.form-advanced.init.js"></script> -->
    <!-- <script src="/libs/comvex-template/js/jquery.tree.js"></script> -->

    <!-- <script src="/libs/jquery-ui/jquery-ui.js"></script> -->

    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script src="/js/utilitarios.js"></script>

    <script>
        $(function () {
            $('.floating-wpp').floatingWhatsApp({
                phone: '+5561986792680',
                popupMessage: 'Bem vindo! Envie sua dúvida e logo responderemos:',
                showPopup: true,
                position: 'right', // left or right
                autoOpen: false, // true or false
                //autoOpenTimer: 4000,
                message: '',
                //headerColor: 'orange', // enable to change msg box color
                headerTitle: 'Whatsapp do Doutor Hoje',
            });
        });
    </script>

@endpush

@stack('scripts')

</body>
</html>
