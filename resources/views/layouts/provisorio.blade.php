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
    	<link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link type="text/css" rel="stylesheet" href="/libs/provisorio/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="/libs/provisorio/css/style.css" />
        <link rel="stylesheet" href="/css/doutorhj.style.css">
        
    	<script src="/libs/comvex-template/js/jquery.min.js"></script>
    	
    	<!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
        <script src="js/html5shiv.min.js"></script>
		<![endif]-->    	
		       
        <script type="text/javascript">
        	var laravel_token = '{{ csrf_token() }}';
        </script>

    @endpush
    
    @stack('style')
</head>
<body>
	<div class="tudo">     
        <header>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item active" style="background-image: url('/libs/provisorio/img/bg3.jpg')">
                        <div class="carousel-caption d-md-block">
                            <img src="/libs/provisorio/img/agende-consultas-com-segurança-do-atendimento-rapido-de-qualidade.png" alt="">
                            <img src="/libs/provisorio/img/logo-doctor-hoje.png" alt="">
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('/libs/provisorio/img/bg4.jpg')">
                        <div class="carousel-caption d-md-block">
                            <img src="/libs/provisorio/img/cansado-de-esperar-meses-por-uma-consulta.png" alt="">
                            <img src="/libs/provisorio/img/logo-doctor-hoje.png" alt="">
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('/libs/provisorio/img/bg1.jpg')">
                        <div class="carousel-caption d-md-block">
                            <img src="/libs/provisorio/img/invista-na-sua-saude-preços-que-cabem-no-seu-bolso.png" alt="">
                            <img src="/libs/provisorio/img/logo-doctor-hoje.png" alt="">
                        </div>
                    </div>
                    <!-- Slide Foure - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('/libs/provisorio/img/bg2.jpg')">
                        <div class="carousel-caption d-md-block">
                            <img src="/libs/provisorio/img/Maior-conveniencia-maior-conforto.png" alt="">
                            <img src="/libs/provisorio/img/logo-doctor-hoje.png" alt="">
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
                <div class="area-form">
                    <div class="form">
                        <h3>Quer chegar primeiro e garantir os benefícios de lançamento?<br>
                        Preencha abaixo:</h3>
                        <form action="/participe" method="post" onsubmit="return validaParticipacao()">
                        	{!! csrf_field() !!}
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="txt" id="nome" class="form-control" name="nome" placeholder="Nome" required="required" maxlength="150">
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="E-mail" required="required" maxlength="150">                            
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input type="txt" id="telefone" class="form-control mascaraTelefone" name="telefone" placeholder="Telefone" required="required" maxlength="20">
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                    <p>É simples, é rápido, é online!</p>
                </div>
            </div>
        </header>

		@include('flash-message')
        @yield('content')
        
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; DoctorHoje 2018</p>
            </div>
            <!-- /.container -->
        </footer>     
    </div>
    @push('scripts')
    	<script>
    		var resizefunc = [];
    	</script>
    	
        <script src="/libs/provisorio/js/jquery-3.3.1.min.js"></script>
        <script src="/libs/provisorio/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="/js/jquery.maskMoney.min.js"></script>
        <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
        
        <!-- Notification js -->
        <script src="/libs/notifyjs/dist/notify.min.js"></script>
        <script src="/libs/notifications/notify-metro.js"></script>
        
        <script src="/libs/comvex-template/js/jquery.core.js"></script>
        <script src="/js/utilitarios.js"></script>
        
        <script>
        	$(document).ready(function () {
        		//$.Notification.notify('success', 'top right', 'Solicitação Concluída!', 'A Sua mensagem foi enviada com sucesso!');
        	});
            const countdown = document.querySelector('.countdown');
            
            // Set Launch Date (ms)
            const launchDate = new Date('May 28, 2018 10:00:00').getTime();
            
            // Update every second
            const intvl = setInterval(() => {
              // Get todays date and time (ms)
              const now = new Date().getTime();
            
              // Distance from now and the launch date (ms)
              const distance = launchDate - now;
            
              // Time calculation
              const days = Math.floor(distance / (1000 * 60 * 60 * 24));
              const hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
              );
              const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
              // Display result
              countdown.innerHTML = `
              <div><p>${days}</p><span>Dias</span></div> 
              <div><p>${hours}</p><span>Horas</span></div>
              <div><p>${mins}</p><span>Minutos</span></div>
              <div><p>${seconds}</p><span>Segundos</span></div>
              `;
            
              // If launch date is reached
              if (distance < 0) {
                // Stop countdown
                clearInterval(intvl);
                // Style and output text
                countdown.style.color = '#17a2b8';
                countdown.innerHTML = 'Launched!';
              }
            }, 1000);
            
        </script>
    @endpush
    
    @stack('scripts')
    
</body>
</html>
