<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">
  
    <title>@yield('title', 'Doutor HJ')</title>

    @push('style')
    
    	<!-- Google fonts -->
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    	
    	<!-- Template css -->
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
        
        <!-- Switchery CSS-->
    	<link rel="stylesheet" href="/libs/switchery/switchery.min.css">
        
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/jquery.datetimepicker.min.css" />
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css" />
        <link type="text/css" rel="stylesheet" href="/libs/select2/css/select2.min.css" />
        
        <!-- Template theme CSS -->
    	<!-- <link rel="stylesheet" href="/libs/comvex-template/css/style_dark.css"> -->
        
        <!-- JQueryUI -->
    	<!-- <link rel="stylesheet" href="/libs/jquery-ui-themes/jquery-ui.css"> -->
    	
    	<!-- JQuery Autocomplete -->
    	<link rel="stylesheet" href="/libs/jquery-autocomplete/css/styles.css">
    	
        <!-- DoutorHJ Reset CSS -->
    	<link rel="stylesheet" href="/css/doutorhj.style.css">
    	
    	<!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
        <script src="js/html5shiv.min.js"></script>
		<![endif]-->    	
        
        <script src="/libs/comvex-template/js/jquery.min.js"></script>
        <script src="/libs/comvex-template/js/modernizr.min.js"></script>
        <script src="/libs/home-template/js/jquery.datetimepicker.full.min.js"></script>
        <script src="/libs/home-template/js/popper.min.js"></script>
    	<script src="/libs/home-template/js/bootstrap.min.js"></script>
        <script src="/libs/select2/js/select2.min.js"></script>
        <script src="/libs/select2/js/i18n/pt-BR.js"></script>
        <script src="/libs/jquery-autocomplete/js/jquery.autocomplete.min.js"></script>
        <script src="/libs/switchery/switchery.min.js"></script>
        
        <script src="/libs/jquery-credit-card/jquery.creditCardValidator.js"></script>
        
        <script src="/js/doutorhj.script.js"></script>
        
        <script type="text/javascript">
        	var laravel_token = '{{ csrf_token() }}';
        </script>

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
                                <a class="nav-link" href="{{ route("meus-agendamentos") }}">Meus Agendamentos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route("minha-conta") }}">Minha Conta</a>
                            </li>
        				</ul>
        				<div class="menu-area-logada">
                                <ul>
                                    <li>
                                        <span class="al-nome-usuario">{{ Auth::user()->paciente->nm_primario }}</span>
                                    </li>
                                    <li>
                                        <div class="dropdown opcoes-menu-usuario drop-notificacoes">
                                            <button class="btn dropdown-toggle btn-notificacoes btn-area-logada" title="Notificações" type="button" id="dropdownNotificacoes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span>Notificações </span><i class="fa fa-bell"></i>
                                                <div class="numero-notificacoes">
                                                    <span>0</span>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownNotificacoes">
                                                <ul>
                                                    <li class="dropdown-item desativado">
                                                        <span>Notificações</span>
                                                    </li>
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
                                                    <li class="dropdown-item mensagens-menu">
                                                        <a href="#">NENHUM ENCONTRADA</a>
                                                        <!-- <span>Há 2 semanas</span> -->
                                                    </li>
                                                </ul>                                                
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown opcoes-menu-usuario drop-carrinho">
                                            <button class="btn dropdown-toggle btn-carrinho btn-area-logada" title="Carrinho de Compras" type="button" id="dropdownCarrinho" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="window.location.href=$(this).find('a').attr('href')">
                                               <a href="/carrinho" class="btn-carrinho"><i class="fa fa-cart-plus"></i></a>
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
                                <a class="nav-link" href="#area-sobre">O que é o Doutor Hoje?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#como-funciona">Como funciona?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#vantagens">Vantagens</a>
                            </li>
                            <li class="nav-item btn-profissional">
                                <a class="nav-link" href="#">Sou profissional de saúde</a>
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
        
        <footer>
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
                            <p><strong>(61) 3221-5350</strong></p>
                            <p>Horário de atendimento das 9h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>Sobre Nós</h5>
                        <ul>
                            <li><a href="#area-sobre">O que é o Doutor Hoje?</a></li>
                            <li><a href="#como-funciona">Como Funciona</a></li>
                            <li><a href="#vantagens">Vantagens</a></li>
                            <li><a href="">Política de Privacidade</a></li>
                            <li><a href="">Termos de Uso</a></li>
                            <li><a href="">Trabalhe Conosco</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5>Clientes</h5>
                        <ul>
                            <li><a href="">Seja Cliente</a></li>
                            <li><a href="">Área restrita</a></li>
                            <li><a href="">Agende Consulta</a></li>
                            <li><a href="">Agende Exame</a></li>
                            <li><a href="">Vantagens</a></li>
                        </ul>
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
                <a href="/">www.doctorhoje.com.br</a>
            </div>
        </footer>        
    </div>
    @push('scripts')
    	<script>
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
    @endpush
    
    @stack('scripts')
    
</body>
</html>
