<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5GQV33K');</script>
	<!-- End Google Tag Manager -->
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doctorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">

    <title>@yield('title', 'Doctor HJ')</title>

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
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GQV33K"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="tudo">
    <!-- <div class="page-loader page-loader-variant-1">
        <div><img class='img-responsive' style='margin-top: -20px;margin-left: -18px;' width='330' height='67' src='/libs/home-template/img/logos/logo-doutor-hoje-vertical.svg' alt='' />
            <div class="offset-top-41 text-center">
                <div class="spinner"></div>
            </div>
        </div>
    </div>  -->
    <div class="mensagem-cupom">
        <p>Agende <span>agora</span> sua <span>1ª consulta</span> e GANHE 10% de <span>desconto</span>. Aproveite, por
            tempo limitado! Use o cupom de desconto: <span>DOCTOR10</span></p>
    </div>
    <header>
        @if (Auth::check())
            <nav class="navbar navbar-expand-xl">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <h1>Doctor Hoje</h1>
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
                                                <span>{{ $num_total_notificacoes }}</span>
                                            </div>
                                        </button>
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
                                            <a href="/carrinho" class="btn-carrinho"><i class="fa fa-cart-plus"></i></a>
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
                        <h1>Doctor Hoje</h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMobile">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#area-sobre">O que é o Doctor Hoje</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#como-funciona">Como funciona</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#vantagens">Vantagens</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contato">Contato</a>
                            </li>
                            <li class="nav-item btn-profissional">
                                <a class="nav-link" href="https://prestador.doctorhoje.com.br">Seja um parceiro</a>
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
    <footer class="footer-default">
        <div class="floating-wpp"></div>
        <div class="container">
            <div class="area-logo-rodape">
                <img src="/libs/home-template/img/logo-branca.png" alt="Doctor Hoje">
            </div>
            <!-- teste smartgit -->
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <img class="logo-rodape" src="/libs/home-template/img/logo-branca.png" alt="Doctor Hoje">
                    <div class="info-atendimento">
                        <p>Central de Atendimento</p>
                        <p><strong><i class="fa fa-phone" aria-hidden="true"></i> (61) 3221-5350</strong></p>
                        <p><strong><i class="fa fa-whatsapp" aria-hidden="true"></i> (61) 98679-2680</strong></p>
                        <p>Horário de atendimento das 9h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>Sobre Nós</h5>
                    <ul>
                        <li><a href="#area-sobre">O que é o Doctor Hoje?</a></li>
                        <li><a href="#como-funciona">Como Funciona</a></li>
                        <li><a href="#vantagens">Vantagens</a></li>
                        <li><a href="">Política de Privacidade</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modalTermos">Termo de Uso</a></li>
                        {{--<li><a href="">Trabalhe Conosco</a></li>--}}
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>Clientes</h5>
                    <ul>
                        <li><a href="https://doctorhoje.com.br/login">Seja Cliente</a></li>
                        <li><a href="https://doctorhoje.com.br/login">Área restrita</a></li>
                        <li><a href="#busca-home">Agende Consulta</a></li>
                        <li><a href="#busca-home">Agende Exame</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>PROFISSIONAIS DE SAÚDE </h5>
                    <ul>
                        <li><a href="https://prestador.doctorhoje.com.br/">Seja um parceiro</a></li>
                        <li><a href="#vantagens">Vantagens</a></li>
                        <li><a href="https://prestador.doctorhoje.com.br/login/">Área restrita</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal fade modal-termos" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Termos e Condições de Uso e Política de Segurança e Privacidade</h5>
                    </div>
                    <div class="modal-body">
                        <p><span>TERMOS E CONDIÇÕES – USUÁRIOS FINAIS</span></p>

                        <p><span>Condições gerais de cadastramento e contratação</span></p>
                        <p>1. O presente termo é firmado entre <strong>NEW SERVICE TECNOLOGY LTDA</strong> (DOCTOR HOJE), pessoa jurídica de direito privado, sociedade empresária limitada, inscrita no CNPJ/MF sob o nº 21.520.255/0001-55, com sede no SCS, Quadra 3, Bloco A, nº 107, Sala 103, Ed. Antônia Alves Pereira de Sousa, Brasília – DF, CEP: 70.303-907, proprietário e detentor de todos os direitos da plataforma digital de sérvios tecnológicos “DOCTOR HOJE”, e o USUÁRIO DOS SERVIÇOS, ora denominado USUÁRIO.</p>
                        <p>2. Para utilizar os serviços da plataforma digital DOCTOR HOJE, o USUÁRIO deverá acessar o site <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>, cadastrar e aceitar os termos e condições gerais e todas as políticas e os princípios que o regem.</p>
                        <p><strong>3. Ao acessar o site e se cadastrar, o USUÁRIO manifesta plena aceitação em relação a todos os termos e às condições ora estabelecidas, assim como demais políticas disponibilizadas através desses canais, submetendo-se automaticamente às regras e condições aqui presentes e suas futuras atualizações.</strong></p>

                        <p><span>Conceitos</span></p>
                        <p>4. Para melhor entendimento deste Termo de Uso, DOCTOR HOJE é o prestador do serviço tecnológico de agendamento e pagamento de consultas e exames por meio de uma plataforma digital que contém site e aplicativo mobile; USUÁRIO é a pessoa física cadastrada no site que utiliza a ferramenta tecnológica pra adquirir e agendar consultas e exames; PRESTADOR, pessoa física ou jurídica, devidamente contratada e cadastrada no site, com registro no respectivo órgão de classe, que presta serviços na área médica, odontológica ou paramédica (Ex: psicologia,  fisioterapia, fonoaudiologia e nutrição).</p>

                        <p><span>Do acesso</span></p>
                        <p>5. Para acessar e utilizar o site do DOCTOR HOJE, o USUÁRIO deverá ser juridicamente capaz, ter no mínimo 18 (dezoito) anos de idade e declarar que leu e aceitou integralmente as condições deste Termo. Deverá fornecer os seguintes dados: nome completo, e-mail, telefones celular e fixo, CPF, data de nascimento. A cada novo acesso será enviada senha pelo celular e e-mail. O Usuário deverá manter suas informações cadastrais sempre atualizadas, completas, exatas e verdadeiras, responsabilizando-se integralmente pelo conteúdo de tais informações.</p>
                        <p>6. O nome de usuário e senha de acesso ao site são de uso exclusivo do USUÁRIO, que se compromete a manter tais informações como confidenciais e impedir que terceiros acessem o site utilizando tais informações. Em caso de extravio das informações ou de acesso de terceiros não autorizados, bem como qualquer suspeita ou conhecimento acerca de falha de segurança do site ou perda ou roubo do telefone celular, o USUÁRIO deverá informar imediatamente o DOCTOR HOJE, por meio do e-mail <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a> ou telefone (61) 3221.5350.</p>
                        <p>7. Cabe exclusivamente ao DOCTOR HOJE o direito de modificar o presente Acordo, bem como interromper ou suspender o acesso ao site, a qualquer tempo, sem necessidade de prévio aviso. Em caso de violação aos termos e condições do Acordo, instruções de uso presentes no site ou norma legal aplicável, o DOCTOR HOJE poderá suspender ou impedir o acesso do USUÁRIO ao Site, a qualquer tempo e sem prévia notificação, sem prejuízo da responsabilidade cível e criminal do USUÁRIO decorrente da respectiva violação. </p>
                        <p>8. O USUÁRIO, por sua vez, poderá cancelar o seu cadastramento no site a qualquer tempo e sem qualquer custo. O uso contínuo do site pelo USUÁRIO caracteriza a aceitação dos termos e condições do Acordo que vierem a sofrer alterações.</p>
                        <p>8.1. Se o USUÁRIO cancelar seu cadastramento no site tendo adquirido consulta ou exame e ainda não utilizado, o mesmo terá o prazo de até 30 (dias) da aquisição para a realização dos mesmos, sob pena de perder o valor pago pelos mesmos.</p>

                        <p><span>Do objeto</span></p>
                        <p>9. O objeto da plataforma digital DOCTOR HOJE é a oferta de serviços tecnológicos que permite ao USUÁRIO o agendamento e pagamento de consultas médicas e odontológicas e exames de diagnósticos e terapias, laboratoriais, de imagem e check up, a serem prestados por médicos, odontólogos clínicas e laboratórios (“Prestadores”) ao USUÁRIO interessado na marcação de consultas e exames, conforme disponibilizados no presente Termo de Uso. </p>
                        <p>10. Os serviços tecnológicos disponibilizados pelo DOCTOR HOJE se diferenciam dos serviços de saúde prestados pelo PRESTADOR ao USUÁRIO e incluem o acesso ao site, à página web e aos serviços de pagamento na forma descrita neste Termo e no site <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>, ficando o USUÁRIO responsável pelo bom uso dos serviços. </p>
                        <p>11. Esta plataforma digital não contempla a publicidade ou prestação de serviços médicos ou exames, não equivale a plano privado de assistência à saúde, e não permite o agendamento de atendimentos, consultas ou exames médicos em caráter de urgência ou emergência ou internação de qualquer natureza. Fica o USUÁRIO desde já advertido que atendimentos de urgência ou emergência e internações, devem ser agendados diretamente com o prestador de serviços, e que qualquer dano ao USUÁRIO em decorrência do descumprimento dessa condição não será suportado pelo DOCTOR HOJE. </p>
                        <p>12. O USUÁRIO ESTÁ CIENTE QUE O DOCTOR HOJE É APENAS UMA PLATAFORMA DIGITAL DE SERVIÇOS TECNOLÓGICOS DE AGENDAMENTO E PAGAMENTO DE SERVIÇOS MÉDICOS OU ODONTOLÓGICOS, E QUE NESSA QUALIDADE, NÃO TEM QUALQUER RESPONSABILIDADE TÉCNICA, CIVIL OU CRIMINAL, POR QUALQUER ATO OU FATO DECORRENTE DA PRESTAÇÃO DO SERVIÇO MÉDICO OU ODONTOLÓGICO, CUJO PRESTADOR SE RESPONSABILIZA TOTALMENTE PELA ENTREGA, QUALIDADE, LEGITIMIDADE E INTEGRIDADE DOS SERVIÇOS MÉDICOS OU ODONTOLÓGICOS PRESTADOS AO USUÁRIO. O DOCTOR HOJE SE EXIME, AINDA, DE RESPONSABILIDADE POR EVENTUAL ERRO OU NEGLIGÊNCIA MÉDICA, ERROS EM EXAMES ENVOLVENDO OS SERVIÇOS DE SAÚDE PRESTADOS, OU PELO MAL ATENDIMENTO, INSUFICIÊNCIA DE INFORMAÇÕES, BEM COMO POR DANOS MORAIS OU DE QUALQUER NATUREZA.</p>

                        <p><span>Das responsabilidades do Doctor Hoje</span></p>
                        <p>13. O DOCTOR HOJE é responsável pelo desenvolvimento e manutenção da plataforma digital, bem como pela contratação e habilitação dos PRESTADORES aptos a executarem as atividades médicas ou odontológicas, no que tange a sua condição e registro perante o Conselho Regional de Medicina e de Odontologia do respectivo Estado, não se responsabilizando pelas informações e avaliações constantes no site acerca dos PRESTADORES, e nem, tampouco, pelo grau de experiência profissional e qualificação dos mesmos.</p>
                        <p>14. O DOCTOR HOJE não se responsabiliza pelas consequências decorrentes do descumprimento de obrigações relacionadas às consultas e exames agendados por meio do Site, incluindo cancelamentos e atrasos de médicos, odontólogos ou USUÁRIOS, sendo que sua responsabilidade se restringe aos serviços tecnológicos ofertados pela plataforma digital para acesso e pagamento entre o USUÁRIO e o PRESTADOR de serviços de saúde.</p>
                        <p>15. Por se tratar de um ambiente eletrônico e virtual condicionado ao pleno acesso à Internet por parte do USUÁRIO e dos PRESTADORES, eventualmente, o sistema poderá não estar disponível por motivos técnicos ou falhas da internet, ou por qualquer outro evento fortuito ou de força maior, alheio ao controle do DOCTOR HOJE, o qual se compromete a envidar seus melhores esforços para sanar qualquer anormalidade no funcionamento do Site dentro da menor brevidade possível.</p>

                        <p><span>Das responsabilidades do usuário</span></p>
                        <p>16. O USUÁRIO é exclusivamente responsável, perante o DOCTOR HOJE e/ou terceiros, por todas as práticas diretas e indiretas envolvendo o uso do Site, incluindo a escolha do PRESTADOR de serviço e o pagamento por exames e consultas médicas, bem como pela veracidade dos dados pessoais por ele inseridos em seu cadastro, pelas informações prestadas e por toda a atividade que ocorrer em sua conta de acesso aos serviços.</p>
                        <p>17. É exclusiva responsabilidade do USUÁRIO receber e manter em sigilo sua senha de acesso ao site, que será enviada por sms a cada novo acesso. </p>
                        <p>18. O USUÁRIO deverá notificar o DOCTOR HOJE imediatamente sobre qualquer uso não autorizado de qualquer senha, conta, ou sobre qualquer outra suspeita ou conhecimento acerca de falha na segurança do serviço.</p>
                        <p>19. É facultado ao USUÁRIO o cadastramento de outras pessoas como dependentes no site, para as quais possa a vir a pretender agendar consultas ou exames com os PRESTADORES, ficando ciente e de acordo, desde já, que as cobranças pelos procedimentos realizados por essas pessoas serão pagas pelo USUÁRIO cadastrado, por meio de cartão de débito ou crédito. </p>
                        <p>20. Em nenhuma hipótese será permitida a cessão, venda, aluguel ou outra forma de transferência da conta. Também não se permitirá a manutenção de mais de um cadastro por um mesmo USUÁRIO, ou ainda a criação de novos cadastros por usuários cujos cadastros originais tenham sido cancelados por infrações às políticas do DOCTOR HOJE. Se o DOCTOR HOJE detectar cadastros duplicados, através do sistema de verificação de dados, irá inabilitar definitivamente todos os cadastros duplicados.</p>
                        <p>21. O USUÁRIO tem ciência que o DOCTOR HOJE não tem qualquer ingerência na contratação entre o USUÁRIO e seus bancos ou administradoras de cartões de débito ou crédito. Os USUÁRIOS declaram saber e conhecer todas as condições impostas por suas instituições financeiras para a compra de bens e produtos por cartões de débito ou crediário, dentre elas: taxas de juros, encargos financeiros, limites de crédito, número de parcelas, etc, isentando o DOCTOR HOJE de qualquer responsabilidade quanto a tais condições.</p>
                        <p>22. O USUÁRIO concorda em guardar e manter o DOCTOR HOJE e seus parceiros a salvo e a indenizá-los por quaisquer reclamações, processos, ações, perdas, danos, bem como quaisquer outras responsabilidades decorrentes de seu uso ou utilização indevida do site, bem como por violação deste Termo, violação dos direitos de qualquer outra pessoa ou entidade, ou qualquer violação das declarações, garantias e acordos feitos aqui pelo USUÁRIO.</p>

                        <p><span>Das responsabilidades do Prestador</span></p>
                        <p>23. O PRESTADOR escolhido pelo USUÁRIO prestará os serviços para os quais está contratado junto ao DOCTOR HOJE e cadastrado no Site, diretamente ao USUÁRIO, de forma autônoma e independente, na região onde desenvolve a sua atividade, estando livre para realizar o seu diagnóstico e tratamento da forma como melhor lhe aprouver, inclusive respondendo por eventuais danos médicos causados aos USUÁRIOS, não havendo qualquer ingerência do DOCTOR HOJE em relação ao ato médico realizado, estando todas as Partes absolutamente cientes e concordantes com o fato de que o DOCTOR HOJE é apenas uma plataforma de serviços tecnológicos que não presta serviços de saúde, nem opera como agente ou plano de saúde.</p>
                        <p>24. O USUÁRIO e o PRESTADOR se comprometem a não utilizar o site do DOCTOR HOJE para agendar a prestação de serviços de internação hospitalar de qualquer natureza, de URGÊNCIA e EMERGÊNCIA ou de aconselhamento médico, por telefone ou vídeo, aos USUÁRIOS do DOCTOR HOJE.</p>
                        <p>25. O PRESTADOR se compromete a não prestar serviço ao USUÁRIO que não esteja de posse da senha de atendimento fornecida pelo DOCTOR HOJE, a qual deverá ser validada em sistema na área privativa do prestador no portal <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>.</p>
                        <p>26. Oferecer aos USUÁRIOS da plataforma digital DOCTOR HOJE a mesma atenção em relação aos demais pacientes, bem como que o atendimento seja pautado pelo exercício ético da medicina, com base em parâmetros de competência, excelência, autonomia, sigilo e respeito.</p>
                        <p>27. Não cobrar do USUÁRIO qualquer valor extra referente aos serviços de saúde prestados. </p>

                        <p><span>Instruções gerais para agendamento de consultas médicas e odontológicas</span></p>
                        <p>28. O agendamento de consultas por meio do Site DOCTOR HOJE seguirá as seguintes regras e etapas consecutivas:</p>
                        <ul>
                            <li>
                                <p>Ao acessar o Site pela primeira vez, o USUÁRIO deverá se cadastrar e fazer o login, utilizando o e-mail e senha de acesso;</p>
                            </li>
                            <li>
                                <p>Após cadastrado, o USUÁRIO buscará os PRESTADORES, informando a especialidade e a localidade e com base na respectiva pesquisa, o Site apresentará uma lista de PRESTADORES cadastrados, sendo o critério de ordenamento dos PRESTADORES definido exclusivamente pelo Site;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR, o dia e o horário de agenda pretendido e será encaminhado para a tela de pagamento. O dia e o horário indicados pelo USUÁRIO é um pré-agendamento, que será confirmado em até 48 (quarenta e oito) horas. </p>
                            </li>
                            <li>
                                <p>O USUÁRIO pagará o valor da consulta, conforme estabelecido pelo PRESTADOR, já incluído o valor da taxa de utilização do serviço tecnológico;</p>
                            </li>
                            <li>
                                <p>O pré-agendamento ou a disponibilização de cada consulta só será realizado mediante comprovação de pagamento; caso não haja pagamento confirmado, o pré-agendamento será automaticamente cancelado, sem qualquer prejuízo ao USUÁRIO;</p>
                            </li>
                            <li>
                                <p>O comprovante de pagamento e o código de confirmação da consulta serão enviados para o USUÁRIO por e-mail ou SMS e estarão disponíveis no acesso logado.</p>
                            </li>
                        </ul>

                        <p><span>Instruções gerais para aquisição e/ou agendamento de exames</span></p>
                        <p>29. O agendamento de exames por meio da plataforma digital DOCTOR HOJE seguirá as seguintes regras e etapas consecutivas: </p>
                        <ul>
                            <li>
                                <p>Ao acessar o Site pela primeira vez, o USUÁRIO deverá se cadastrar e fazer o login, utilizando o e-mail e senha de acesso;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO informará o exame desejado e a localidade e com base na respectiva pesquisa, o Site apresentará uma lista de PRESTADORES cadastrados, sendo o critério de ordenamento dos PRESTADORES definidos exclusivamente pelo Site;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR, o dia e o horário de agenda pretendido e será encaminhado para a tela de pagamento. O dia e o horário indicados pelo USUÁRIO é um pré-agendamento, que será confirmado em até 48 (quarenta e oito) horas.</p>
                            </li>
                            <li>
                                <p>O USUÁRIO não está obrigado a apresentar o pedido médico para a aquisição de exames pelo DOCTOR HOJE, sendo a escolha do exame de responsabilidade do USUÁRIO. Entretanto, é aconselhável ao USUÁRIO apresentar pedido médico no dia do exame, que, a critério do PRESTADOR, poderá ou não ser exigido. </p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR e será encaminhado para a tela de pagamento;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO pagará o valor do exame, conforme estabelecido pelo PRESTADOR, já incluído o valor da taxa de utilização do serviço tecnológico.</p>
                            </li>
                            <li>
                                <p>O pré-agendamento ou a disponibilização de cada exame só será realizado mediante comprovação de pagamento; caso não haja pagamento confirmado, o pré-agendamento será automaticamente cancelado, sem qualquer prejuízo ao USUÁRIO;</p>
                            </li>
                            <li>
                                <p>O comprovante de pagamento e o código de confirmação do exame serão enviados para o USUÁRIO por e-mail ou SMS e estarão disponíveis no acesso logado.</p>
                            </li>
                        </ul>

                        <p><span>Reagendamento ou cancelamento de consultas e exames</span></p>
                        <p>30. O USUÁRIO poderá reagendar e/ou cancelar definitivamente a respectiva consulta ou exame por meio do Site ou SAC em até 24 (vinte e quatro) horas antes da data agendada.</p>
                        <p>31. Na hipótese de cancelamento da consulta ou exame com até 24 (vinte e quatro) de antecedência da data agendada, será estornado ao USUÁRIO valor correspondente a 50% (cinquenta por cento) do valor pago. Em nenhuma hipótese haverá estorno do valor total do serviço, já que o simples agendamento de consulta ou exame por meio da plataforma digital enseja a efetivação da prestação dos serviços pelo DOCTOR HOJE.</p>
                        <p>32. Se o USUÁRIO não comparecer no dia da consulta ou procedimento agendado ou se não efetuar a remarcação da consulta ou do procedimento com pelo menos 24 (vinte e quatro) de antecedência ao horário e data marcados, o valor do procedimento (consulta ou exame) não será estornado, será cobrado normalmente, estando o USUÁRIO ciente e plenamente de acordo com o ora estabelecido.</p>
                        <p>33. Os exames ou consultas só poderão ser reagendados uma única vez pelo UUSÁRIO e dentro de 30 (trinta) dias a contar da data do agendamento inicial.</p>
                        <p>34. Na hipótese de exames disponibilizados por PRESTADORES sem necessidade de agendamento (Ex: exames laboratoriais), o USUÁRIO poderá cancelá-los por meio da plataforma digital DOCTOR HOJE em até 7 (sete) dias após a respectiva compra, desde que ainda não os tenha realizado. Nesse caso, será devolvido o valor integral pago pelo USUÁRIO. Para desistência ou cancelamento após o 8º (oitavo) dia da compra, será estornado ao USUÁRIO valor correspondente a 50% (cinquenta por cento) do valor pago.</p>
                        <p>34.1. Todo e qualquer exame que não necessite de agendamento, deverá ser obrigatoriamente realizado em até 60 (sessenta) dias da compra, sob pena de o USUÁRIO perder o valor pago pelo mesmo. </p>
                        <p>35. A devolução quando devida ocorrerá por meio de crédito em conta corrente ou estorno do cartão de crédito, conforme o caso, no prazo máximo de até 5 (cinco) dias úteis do pedido de cancelamento ou no prazo estabelecido pelo cartão de débito ou crédito.</p>
                        <p>36. Se o PRESTADOR cancelar a consulta ou exame agendado, o PRESTADOR ou o USUÁRIO deverão contatar o DOCTOR HOJE, o qual providenciará o reagendamento com outro PRESTADOR com a maior brevidade possível. </p>
                        <p>37. O USUÁRIO poderá exercer o direito de arrependimento e desistir da consulta ou exame adquiridos pela plataforma digital DOCTOR HOJE no prazo máximo de até 7 (sete) dias contados da aquisição, desde que ainda não os tenha realizado. Nesse caso, será devolvido o valor integral pago pelo USUÁRIO.</p>
                        <div class="tabela-termos">
                            <div class="row">

                                <div class="col-md-12 titulo">
                                    Regras para cancelamento e agendamento
                                </div>
                                <div class="col-md-12">
                                    &nbsp;
                                </div>
                                <div class="col-md-4 titulo">
                                    Solicitação/Período
                                </div>
                                <div class="col-md-4 titulo">
                                    Até 24 horas
                                </div>
                                <div class="col-md-4 titulo">
                                    Inferior a 24 horas
                                </div>

                                <div class="col-md-4 linha">
                                    Cancelamento
                                </div>
                                <div class="col-md-4 linha">
                                    Reembolso de 50% do valor pago em até 5 dias úteis
                                </div>
                                <div class="col-md-4 linha">
                                    Sem direito a reembolso
                                </div>

                                <div class="col-md-4 linha">
                                    Reagendamento
                                </div>
                                <div class="col-md-4 linha">
                                    Direito a 1 (um) reagendamento em no máximo 30 dias
                                </div>
                                <div class="col-md-4 linha">
                                    Perda do direito de reagendamento
                                </div>

                                <div class="col-md-4 titulo">
                                    Regras especiais
                                </div>
                                <div class="col-md-4 titulo">
                                    Prazos
                                </div>
                                <div class="col-md-4 titulo">
                                    Condições
                                </div>

                                <div class="col-md-4 linha">
                                    Exames sem necessidade de agendamento
                                </div>
                                <div class="col-md-4 linha">
                                    Realizar até 60 dias da aquisição
                                </div>
                                <div class="col-md-4 linha">
                                    Após 60 dias perderá o direito ao reembolso
                                </div>

                                <div class="col-md-4 linha">
                                    Cancelamento da conta DOCTOR HOJE
                                </div>
                                <div class="col-md-4 linha">
                                    Realizar até 30 dias após pedido de cancelamento da conta
                                </div>
                                <div class="col-md-4 linha">
                                    Após 30 dias perderá o direito ao reembolso
                                </div>

                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <p><span>Instruções para realização de consultas e exames</span></p>
                        <p>38. Na data da consulta ou exame agendado, o USUÁRIO deverá comparecer ao estabelecimento do PRESTADOR com antecedência mínima de 30 (trinta) minutos, sempre munido de documento de identidade, pedido médico ou odontológico, quando for o caso, e código de confirmação da consulta ou do exame fornecido pelo DOCTOR HOJE e disponível na área logada.</p>
                        <p>39. Cabe a cada PRESTADOR indicar livremente os prazos de retorno de consultas médicas ou odontológicas, as quais deverão ser agendadas pelo DOCTOR HOJE. A determinação do tempo necessário para avaliação do USUÁRIO e de seus exames segue critérios técnicos e médicos, sem qualquer interferência do DOCTOR HOJE.</p>
                        <p>40. Na hipótese de realização de exames que ensejem preparo específico (ex.: jejum, dieta, medicação), o USUÁRIO será informado pelo DOCTOR HOJE, pelo e-mail cadastrado.</p>
                        <p>41. Após cada consulta ou exame, o USUÁRIO terá a possibilidade de avaliar o PRESTADOR acessando a plataforma DOCTOR HOJE. Essa avaliação é facultativa e consiste na atribuição de uma nota de 1 (um) a 5 (cinco) para o atendimento do PRESTADOR, para as condições de atendimento do profissional, atendimento da secretária, tempo de espera, estrutura física e acessibilidade. </p>
                        <p>42. O USUÁRIO e PRESTADOR expressamente concordam e reconhecem que o DOCTOR HOJE não tem nenhuma responsabilidade em relação às avaliações dos PRESTADORES realizadas pelos USUÁRIOS, e que essas avaliações não devem ser consideradas divulgações de caráter publicitário.</p>

                        <p><span>Pagamento pelos serviços contratados no site e taxa de agendamento</span></p>
                        <p>43. A remuneração pela contratação do PRESTADOR será paga pelo USUÁRIO por meio da plataforma digital DOCTOR HOJE, por meio de cartão de débito ou crédito.</p>
                        <p>44. O USUÁRIO concorda que o DOCTOR HOJE cobrará uma taxa de utilização do serviço tecnológico prestado, que incidirá sobre o preço de cada consulta ou exame agendado por meio do Site, a qual estará incluída no valor total cobrado por cada consulta ou exame.</p>
                        <p>44.1. Para a utilização do serviço tecnológico o USUÁRIO pagará ao DOCTOR HOJE o valor anual de R$ 48,80 (quarenta e oito reais e oitenta centavos). O USUÁRIO que se cadastrar no DOCTOR HOJE até 30/09/2018, terá desconto de 50% na primeira anuidade, pagando o valor de R$ 24,40 (vinte e quatro reais e quarenta centavos) somente no 6º (sexto) mês após a adesão. A anuidade seguinte será integral, válida para os próximos 12 (doze) meses contados da data da adesão.</p>
                        <p>44.2. O DOCTOR HOJE deixa claro que o valor anual refere-se a utilização do serviço tecnológico e não se trata, nem se equipara a mensalidades ou pagamentos a planos privados de assistência à saúde.</p>
                        <p>45. O USUÁRIO concorda em pagar por todo e qualquer serviço intermediado por meio da plataforma digital DOCTOR HOJE utilizando seu nome, cartão de débito ou crédito ou outras formas de pagamento. Todos os pagamentos feitos através de cartão de débito ou crédito estarão sujeitos à autorização e aprovação da administradora do cartão.</p>
                        <p>45.1. O USUÁRIO, a seu critério, poderá optar pelo armazenamento dos dados de seu cartão de débito ou crédito para facilitar futuras compras. </p>
                        <p>46. O DOCTOR HOJE emitirá nota fiscal eletrônica, a qual será enviada por e-mail ao USUÁRIO. Por se tratar de prestação de serviços tecnológicos de agendamento de consultas ou exames, os valores não são dedutíveis na Declaração de Imposto de Renda ou passíveis de reembolso.</p>
                        <p>47. Os valores correspondentes às consultas e exames poderão, a critério exclusivo do USUÁRIO, ser parcelados em até 2 (duas) parcelas, sem juros. Acima de 3 (três) parcelas serão cobrados juros do cartão, conforme informação que constará do Site. </p>
                        <p>48. O DOCTOR HOJE jamais será responsável por possíveis interrupções nos serviços de pagamentos de empresas contratadas, nem pelas falhas e/ou danos e prejuízos que o uso serviços possam gerar ao USUÁRIO.</p>
                        <p>49. O DOCTOR HOJE não se responsabiliza pelas obrigações tributárias que recaiam sobre as atividades dos PRESTADORES de serviços médicos ou odontológicos.</p>
                        <p>50.  Toda discrepância, erro, omissão e/ou inconveniente referente ao sistema, forma e/ou instituição de pagamento será de exclusiva responsabilidade do USUÁRIO e das instituições de pagamento, não cabendo imputação alguma ao DOCTOR HOJE. Ao optar por utilizar o serviço de controle de pagamentos, o DOCTOR HOJE não tem como evitar ocasionais falhas das referidas instituições e dos sistemas bancários e/ou administradoras de cartão de débito ou crédito.</p>
                        <p>51. Caso ocorram problemas devidos ao seu uso, o USUÁRIO deverá informar o DOCTOR HOJE por e-mail <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a> ou pelo telefone (61) 3221.5350, não gerando obrigação para que o DOCTOR HOJE resolva tais problemas.</p>

                        <p><span>PROPRIEDADE INTELECTUAL</span></p>
                        <p>52. O USUÁRIO concorda que todo o conteúdo referente aos serviços, banco de dados, redes, arquivos e todas as funcionalidades disponíveis no Site são de propriedade exclusiva do DOCTOR HOJE, seus anunciantes e/ou licenciados, e que estão protegidos como direitos autorais, marcas, segredos comerciais e outros direitos referentes a propriedade intelectual e/ou industrial previstos na Legislação Brasileira.</p>
                        <p>52.1. O conteúdo do Site DOCTOR HOJE, incluindo textos, imagens, áudios e/ou vídeos, não poderá ser distribuído, modificado, alterado, transmitido, reutilizado ou reenviado a terceiros pelo USUÁRIO, seja para qual finalidade for, sem a prévia e expressa autorização do DOCTOR HOJE. </p>
                        <p>52.2. É expressamente vedado ao USUÁRIO utilizar os dados ou o conteúdo do Site ou respectivos micro sites para criar compilações e bases de dados de qualquer tipo sem a permissão por escrito do DOCTOR HOJE. Sendo assim, é proibido o uso do conteúdo ou materiais do Site e respectivos micro sites para qualquer propósito que não esteja expressamente autorizado neste Termo de Uso.</p>
                        <p>53. A presença de links para outros sites não implica relação de sociedade, de supervisão, de cumplicidade ou solidariedade do DOCTOR HOJE para com esses sites e seus conteúdos.</p>

                        <p><span>Declarações do usuário</span></p>
                        <p>54. O USUÁRIO declara expressamente e garante, para todos os fins de direito, que possui capacidade jurídica para celebrar este contrato e utilizar os serviços objeto do mesmo, sendo maior de 18 (dezoito) anos de idade.</p>
                        <p>54.1. Os pais ou os representantes legais do menor de idade ou incapaz responderão pelos atos por ele praticados na utilização da plataforma digital, dentre os quais eventuais danos causados a terceiros, práticas de atos vedados pela lei e pelas disposições deste Termo.</p>
                        <p>55. O USUÁRIO garante que não se identificou falsamente, nem forneceu qualquer informação falsa para obter acesso ao serviço do DOCTOR HOJE.</p>
                        <p>56. O USUÁRIO está ciente que o DOCTOR HOJE se reserva o direito de utilizar todos os meios válidos e possíveis para identificar seus USUÁRIOS, bem como de solicitar dados adicionais e documentos que estime serem pertinentes a fim de conferir os dados pessoais informados.</p>
                        <p>57. O USUÁRIO está ciente que o DOCTOR HOJE poderá modificar os termos e condições do presente Termo ou as suas políticas relativas ao serviço a qualquer momento, efetivadas após a publicação de uma versão atualizada do Termo sobre o serviço.</p>
                        <p>58. O USUÁRIO é responsável por verificar regularmente o presente Termo de Uso, sendo que o uso continuado do Serviço após qualquer alteração, constituirá o seu consentimento para tais mudanças.</p>

                        <p><span>Disposições finais</span></p>
                        <p>59. O USUÁRIO poderá contatar o DOCTOR HOJE para tratar de questões referentes ao Site, incluindo dúvidas, reclamações e sugestões, por meio do endereço eletrônico: <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a>. A resposta do DOCTOR HOJE em relação às demandas do USUÁRIO deverá ser realizada em até 5 (cinco) dias úteis.</p>
                        <p>60. A propriedade do Site poderá ser cedida e transferida a qualquer tempo pelo DOCTOR HOJE a terceiros, sem necessidade de anuência do USUÁRIO.</p>
                        <p>61. Cada cláusula deste Termo de Uso deverá ser interpretada de modo a se tornar válida e eficaz à luz da lei aplicável. Caso alguma das cláusulas seja considerada ilícita, dita cláusula deverá ser julgada separadamente do restante do Termo e todas as demais cláusulas continuarão em pleno vigor.</p>
                        <p>62. A disponibilização do Site terá prazo indeterminado, reservando-se ao DOCTOR HOJE o direito de suspender ou interromper, a qualquer momento independentemente de prévio aviso.</p>
                        <p>63. As partes contratantes elegem o foro da Circunscrição Judiciária de Brasília – DF, para a resolução de quaisquer controvérsias oriundas deste Termo de Uso, renunciando a todo e qualquer outro, por mais privilegiado que seja.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-vermelho" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="endereco-site">
            <div class="container">
                <a href="/">www.doctorhoje.com.br</a>
                <div class="redes-sociais">
                    <a href="https://www.instagram.com/doctor_hoje/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/DoctorHoje/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </footer>
    @endif

	@if (Auth::check())
    <footer class="footer-logado">
        <div class="container">
            <div class="area-logo-rodape">
                <img src="/libs/home-template/img/logo-branca.png" alt="Doctor Hoje">
            </div>
            <!-- teste smartgit -->
            <div class="row">
                <div class="col-sm-6 col-md-9">
                    <img class="logo-rodape" src="/libs/home-template/img/logo-branca.png" alt="Doctor Hoje">
                    <div class="info-atendimento">
                        <p>Central de Atendimento</p>
                        <p><strong><i class="fa fa-phone" aria-hidden="true"></i> (61) 3221-5350</strong></p>
                        <p><strong><i class="fa fa-whatsapp" aria-hidden="true"></i> (61) 98679-2680</strong></p>
                        <p>Horário de atendimento das 9h às 18h, de segunda à sexta-feira, excetos feriados.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5>Sobre Nós</h5>
                    <ul>
                        <li><a href="">Política de Privacidade</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modalTermos">Termo de Uso</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal fade modal-termos" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Termos e Condições de Uso e Política de Segurança e Privacidade</h5>
                    </div>
                    <div class="modal-body">
                        <p><span>TERMOS E CONDIÇÕES – USUÁRIOS FINAIS</span></p>

                        <p><span>Condições gerais de cadastramento e contratação</span></p>
                        <p>1. O presente termo é firmado entre <strong>NEW SERVICE TECNOLOGY LTDA</strong> (DOCTOR HOJE), pessoa jurídica de direito privado, sociedade empresária limitada, inscrita no CNPJ/MF sob o nº 21.520.255/0001-55, com sede no SCS, Quadra 3, Bloco A, nº 107, Sala 103, Ed. Antônia Alves Pereira de Sousa, Brasília – DF, CEP: 70.303-907, proprietário e detentor de todos os direitos da plataforma digital de sérvios tecnológicos “DOCTOR HOJE”, e o USUÁRIO DOS SERVIÇOS, ora denominado USUÁRIO.</p>
                        <p>2. Para utilizar os serviços da plataforma digital DOCTOR HOJE, o USUÁRIO deverá acessar o site <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>, cadastrar e aceitar os termos e condições gerais e todas as políticas e os princípios que o regem.</p>
                        <p><strong>3. Ao acessar o site e se cadastrar, o USUÁRIO manifesta plena aceitação em relação a todos os termos e às condições ora estabelecidas, assim como demais políticas disponibilizadas através desses canais, submetendo-se automaticamente às regras e condições aqui presentes e suas futuras atualizações.</strong></p>

                        <p><span>Conceitos</span></p>
                        <p>4. Para melhor entendimento deste Termo de Uso, DOCTOR HOJE é o prestador do serviço tecnológico de agendamento e pagamento de consultas e exames por meio de uma plataforma digital que contém site e aplicativo mobile; USUÁRIO é a pessoa física cadastrada no site que utiliza a ferramenta tecnológica pra adquirir e agendar consultas e exames; PRESTADOR, pessoa física ou jurídica, devidamente contratada e cadastrada no site, com registro no respectivo órgão de classe, que presta serviços na área médica, odontológica ou paramédica (Ex: psicologia,  fisioterapia, fonoaudiologia e nutrição).</p>

                        <p><span>Do acesso</span></p>
                        <p>5. Para acessar e utilizar o site do DOCTOR HOJE, o USUÁRIO deverá ser juridicamente capaz, ter no mínimo 18 (dezoito) anos de idade e declarar que leu e aceitou integralmente as condições deste Termo. Deverá fornecer os seguintes dados: nome completo, e-mail, telefones celular e fixo, CPF, data de nascimento. A cada novo acesso será enviada senha pelo celular e e-mail. O Usuário deverá manter suas informações cadastrais sempre atualizadas, completas, exatas e verdadeiras, responsabilizando-se integralmente pelo conteúdo de tais informações.</p>
                        <p>6. O nome de usuário e senha de acesso ao site são de uso exclusivo do USUÁRIO, que se compromete a manter tais informações como confidenciais e impedir que terceiros acessem o site utilizando tais informações. Em caso de extravio das informações ou de acesso de terceiros não autorizados, bem como qualquer suspeita ou conhecimento acerca de falha de segurança do site ou perda ou roubo do telefone celular, o USUÁRIO deverá informar imediatamente o DOCTOR HOJE, por meio do e-mail <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a> ou telefone (61) 3221.5350.</p>
                        <p>7. Cabe exclusivamente ao DOCTOR HOJE o direito de modificar o presente Acordo, bem como interromper ou suspender o acesso ao site, a qualquer tempo, sem necessidade de prévio aviso. Em caso de violação aos termos e condições do Acordo, instruções de uso presentes no site ou norma legal aplicável, o DOCTOR HOJE poderá suspender ou impedir o acesso do USUÁRIO ao Site, a qualquer tempo e sem prévia notificação, sem prejuízo da responsabilidade cível e criminal do USUÁRIO decorrente da respectiva violação. </p>
                        <p>8. O USUÁRIO, por sua vez, poderá cancelar o seu cadastramento no site a qualquer tempo e sem qualquer custo. O uso contínuo do site pelo USUÁRIO caracteriza a aceitação dos termos e condições do Acordo que vierem a sofrer alterações.</p>
                        <p>8.1. Se o USUÁRIO cancelar seu cadastramento no site tendo adquirido consulta ou exame e ainda não utilizado, o mesmo terá o prazo de até 30 (dias) da aquisição para a realização dos mesmos, sob pena de perder o valor pago pelos mesmos.</p>

                        <p><span>Do objeto</span></p>
                        <p>9. O objeto da plataforma digital DOCTOR HOJE é a oferta de serviços tecnológicos que permite ao USUÁRIO o agendamento e pagamento de consultas médicas e odontológicas e exames de diagnósticos e terapias, laboratoriais, de imagem e check up, a serem prestados por médicos, odontólogos clínicas e laboratórios (“Prestadores”) ao USUÁRIO interessado na marcação de consultas e exames, conforme disponibilizados no presente Termo de Uso. </p>
                        <p>10. Os serviços tecnológicos disponibilizados pelo DOCTOR HOJE se diferenciam dos serviços de saúde prestados pelo PRESTADOR ao USUÁRIO e incluem o acesso ao site, à página web e aos serviços de pagamento na forma descrita neste Termo e no site <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>, ficando o USUÁRIO responsável pelo bom uso dos serviços. </p>
                        <p>11. Esta plataforma digital não contempla a publicidade ou prestação de serviços médicos ou exames, não equivale a plano privado de assistência à saúde, e não permite o agendamento de atendimentos, consultas ou exames médicos em caráter de urgência ou emergência ou internação de qualquer natureza. Fica o USUÁRIO desde já advertido que atendimentos de urgência ou emergência e internações, devem ser agendados diretamente com o prestador de serviços, e que qualquer dano ao USUÁRIO em decorrência do descumprimento dessa condição não será suportado pelo DOCTOR HOJE. </p>
                        <p>12. O USUÁRIO ESTÁ CIENTE QUE O DOCTOR HOJE É APENAS UMA PLATAFORMA DIGITAL DE SERVIÇOS TECNOLÓGICOS DE AGENDAMENTO E PAGAMENTO DE SERVIÇOS MÉDICOS OU ODONTOLÓGICOS, E QUE NESSA QUALIDADE, NÃO TEM QUALQUER RESPONSABILIDADE TÉCNICA, CIVIL OU CRIMINAL, POR QUALQUER ATO OU FATO DECORRENTE DA PRESTAÇÃO DO SERVIÇO MÉDICO OU ODONTOLÓGICO, CUJO PRESTADOR SE RESPONSABILIZA TOTALMENTE PELA ENTREGA, QUALIDADE, LEGITIMIDADE E INTEGRIDADE DOS SERVIÇOS MÉDICOS OU ODONTOLÓGICOS PRESTADOS AO USUÁRIO. O DOCTOR HOJE SE EXIME, AINDA, DE RESPONSABILIDADE POR EVENTUAL ERRO OU NEGLIGÊNCIA MÉDICA, ERROS EM EXAMES ENVOLVENDO OS SERVIÇOS DE SAÚDE PRESTADOS, OU PELO MAL ATENDIMENTO, INSUFICIÊNCIA DE INFORMAÇÕES, BEM COMO POR DANOS MORAIS OU DE QUALQUER NATUREZA.</p>

                        <p><span>Das responsabilidades do Doctor Hoje</span></p>
                        <p>13. O DOCTOR HOJE é responsável pelo desenvolvimento e manutenção da plataforma digital, bem como pela contratação e habilitação dos PRESTADORES aptos a executarem as atividades médicas ou odontológicas, no que tange a sua condição e registro perante o Conselho Regional de Medicina e de Odontologia do respectivo Estado, não se responsabilizando pelas informações e avaliações constantes no site acerca dos PRESTADORES, e nem, tampouco, pelo grau de experiência profissional e qualificação dos mesmos.</p>
                        <p>14. O DOCTOR HOJE não se responsabiliza pelas consequências decorrentes do descumprimento de obrigações relacionadas às consultas e exames agendados por meio do Site, incluindo cancelamentos e atrasos de médicos, odontólogos ou USUÁRIOS, sendo que sua responsabilidade se restringe aos serviços tecnológicos ofertados pela plataforma digital para acesso e pagamento entre o USUÁRIO e o PRESTADOR de serviços de saúde.</p>
                        <p>15. Por se tratar de um ambiente eletrônico e virtual condicionado ao pleno acesso à Internet por parte do USUÁRIO e dos PRESTADORES, eventualmente, o sistema poderá não estar disponível por motivos técnicos ou falhas da internet, ou por qualquer outro evento fortuito ou de força maior, alheio ao controle do DOCTOR HOJE, o qual se compromete a envidar seus melhores esforços para sanar qualquer anormalidade no funcionamento do Site dentro da menor brevidade possível.</p>

                        <p><span>Das responsabilidades do usuário</span></p>
                        <p>16. O USUÁRIO é exclusivamente responsável, perante o DOCTOR HOJE e/ou terceiros, por todas as práticas diretas e indiretas envolvendo o uso do Site, incluindo a escolha do PRESTADOR de serviço e o pagamento por exames e consultas médicas, bem como pela veracidade dos dados pessoais por ele inseridos em seu cadastro, pelas informações prestadas e por toda a atividade que ocorrer em sua conta de acesso aos serviços.</p>
                        <p>17. É exclusiva responsabilidade do USUÁRIO receber e manter em sigilo sua senha de acesso ao site, que será enviada por sms a cada novo acesso. </p>
                        <p>18. O USUÁRIO deverá notificar o DOCTOR HOJE imediatamente sobre qualquer uso não autorizado de qualquer senha, conta, ou sobre qualquer outra suspeita ou conhecimento acerca de falha na segurança do serviço.</p>
                        <p>19. É facultado ao USUÁRIO o cadastramento de outras pessoas como dependentes no site, para as quais possa a vir a pretender agendar consultas ou exames com os PRESTADORES, ficando ciente e de acordo, desde já, que as cobranças pelos procedimentos realizados por essas pessoas serão pagas pelo USUÁRIO cadastrado, por meio de cartão de débito ou crédito. </p>
                        <p>20. Em nenhuma hipótese será permitida a cessão, venda, aluguel ou outra forma de transferência da conta. Também não se permitirá a manutenção de mais de um cadastro por um mesmo USUÁRIO, ou ainda a criação de novos cadastros por usuários cujos cadastros originais tenham sido cancelados por infrações às políticas do DOCTOR HOJE. Se o DOCTOR HOJE detectar cadastros duplicados, através do sistema de verificação de dados, irá inabilitar definitivamente todos os cadastros duplicados.</p>
                        <p>21. O USUÁRIO tem ciência que o DOCTOR HOJE não tem qualquer ingerência na contratação entre o USUÁRIO e seus bancos ou administradoras de cartões de débito ou crédito. Os USUÁRIOS declaram saber e conhecer todas as condições impostas por suas instituições financeiras para a compra de bens e produtos por cartões de débito ou crediário, dentre elas: taxas de juros, encargos financeiros, limites de crédito, número de parcelas, etc, isentando o DOCTOR HOJE de qualquer responsabilidade quanto a tais condições.</p>
                        <p>22. O USUÁRIO concorda em guardar e manter o DOCTOR HOJE e seus parceiros a salvo e a indenizá-los por quaisquer reclamações, processos, ações, perdas, danos, bem como quaisquer outras responsabilidades decorrentes de seu uso ou utilização indevida do site, bem como por violação deste Termo, violação dos direitos de qualquer outra pessoa ou entidade, ou qualquer violação das declarações, garantias e acordos feitos aqui pelo USUÁRIO.</p>

                        <p><span>Das responsabilidades do Prestador</span></p>
                        <p>23. O PRESTADOR escolhido pelo USUÁRIO prestará os serviços para os quais está contratado junto ao DOCTOR HOJE e cadastrado no Site, diretamente ao USUÁRIO, de forma autônoma e independente, na região onde desenvolve a sua atividade, estando livre para realizar o seu diagnóstico e tratamento da forma como melhor lhe aprouver, inclusive respondendo por eventuais danos médicos causados aos USUÁRIOS, não havendo qualquer ingerência do DOCTOR HOJE em relação ao ato médico realizado, estando todas as Partes absolutamente cientes e concordantes com o fato de que o DOCTOR HOJE é apenas uma plataforma de serviços tecnológicos que não presta serviços de saúde, nem opera como agente ou plano de saúde.</p>
                        <p>24. O USUÁRIO e o PRESTADOR se comprometem a não utilizar o site do DOCTOR HOJE para agendar a prestação de serviços de internação hospitalar de qualquer natureza, de URGÊNCIA e EMERGÊNCIA ou de aconselhamento médico, por telefone ou vídeo, aos USUÁRIOS do DOCTOR HOJE.</p>
                        <p>25. O PRESTADOR se compromete a não prestar serviço ao USUÁRIO que não esteja de posse da senha de atendimento fornecida pelo DOCTOR HOJE, a qual deverá ser validada em sistema na área privativa do prestador no portal <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>.</p>
                        <p>26. Oferecer aos USUÁRIOS da plataforma digital DOCTOR HOJE a mesma atenção em relação aos demais pacientes, bem como que o atendimento seja pautado pelo exercício ético da medicina, com base em parâmetros de competência, excelência, autonomia, sigilo e respeito.</p>
                        <p>27. Não cobrar do USUÁRIO qualquer valor extra referente aos serviços de saúde prestados. </p>

                        <p><span>Instruções gerais para agendamento de consultas médicas e odontológicas</span></p>
                        <p>28. O agendamento de consultas por meio do Site DOCTOR HOJE seguirá as seguintes regras e etapas consecutivas:</p>
                        <ul>
                            <li>
                                <p>Ao acessar o Site pela primeira vez, o USUÁRIO deverá se cadastrar e fazer o login, utilizando o e-mail e senha de acesso;</p>
                            </li>
                            <li>
                                <p>Após cadastrado, o USUÁRIO buscará os PRESTADORES, informando a especialidade e a localidade e com base na respectiva pesquisa, o Site apresentará uma lista de PRESTADORES cadastrados, sendo o critério de ordenamento dos PRESTADORES definido exclusivamente pelo Site;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR, o dia e o horário de agenda pretendido e será encaminhado para a tela de pagamento. O dia e o horário indicados pelo USUÁRIO é um pré-agendamento, que será confirmado em até 48 (quarenta e oito) horas. </p>
                            </li>
                            <li>
                                <p>O USUÁRIO pagará o valor da consulta, conforme estabelecido pelo PRESTADOR, já incluído o valor da taxa de utilização do serviço tecnológico;</p>
                            </li>
                            <li>
                                <p>O pré-agendamento ou a disponibilização de cada consulta só será realizado mediante comprovação de pagamento; caso não haja pagamento confirmado, o pré-agendamento será automaticamente cancelado, sem qualquer prejuízo ao USUÁRIO;</p>
                            </li>
                            <li>
                                <p>O comprovante de pagamento e o código de confirmação da consulta serão enviados para o USUÁRIO por e-mail ou SMS e estarão disponíveis no acesso logado.</p>
                            </li>
                        </ul>

                        <p><span>Instruções gerais para aquisição e/ou agendamento de exames</span></p>
                        <p>29. O agendamento de exames por meio da plataforma digital DOCTOR HOJE seguirá as seguintes regras e etapas consecutivas: </p>
                        <ul>
                            <li>
                                <p>Ao acessar o Site pela primeira vez, o USUÁRIO deverá se cadastrar e fazer o login, utilizando o e-mail e senha de acesso;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO informará o exame desejado e a localidade e com base na respectiva pesquisa, o Site apresentará uma lista de PRESTADORES cadastrados, sendo o critério de ordenamento dos PRESTADORES definidos exclusivamente pelo Site;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR, o dia e o horário de agenda pretendido e será encaminhado para a tela de pagamento. O dia e o horário indicados pelo USUÁRIO é um pré-agendamento, que será confirmado em até 48 (quarenta e oito) horas.</p>
                            </li>
                            <li>
                                <p>O USUÁRIO não está obrigado a apresentar o pedido médico para a aquisição de exames pelo DOCTOR HOJE, sendo a escolha do exame de responsabilidade do USUÁRIO. Entretanto, é aconselhável ao USUÁRIO apresentar pedido médico no dia do exame, que, a critério do PRESTADOR, poderá ou não ser exigido. </p>
                            </li>
                            <li>
                                <p>O USUÁRIO escolherá o PRESTADOR e será encaminhado para a tela de pagamento;</p>
                            </li>
                            <li>
                                <p>O USUÁRIO pagará o valor do exame, conforme estabelecido pelo PRESTADOR, já incluído o valor da taxa de utilização do serviço tecnológico.</p>
                            </li>
                            <li>
                                <p>O pré-agendamento ou a disponibilização de cada exame só será realizado mediante comprovação de pagamento; caso não haja pagamento confirmado, o pré-agendamento será automaticamente cancelado, sem qualquer prejuízo ao USUÁRIO;</p>
                            </li>
                            <li>
                                <p>O comprovante de pagamento e o código de confirmação do exame serão enviados para o USUÁRIO por e-mail ou SMS e estarão disponíveis no acesso logado.</p>
                            </li>
                        </ul>

                        <p><span>Reagendamento ou cancelamento de consultas e exames</span></p>
                        <p>30. O USUÁRIO poderá reagendar e/ou cancelar definitivamente a respectiva consulta ou exame por meio do Site ou SAC em até 24 (vinte e quatro) horas antes da data agendada.</p>
                        <p>31. Na hipótese de cancelamento da consulta ou exame com até 24 (vinte e quatro) de antecedência da data agendada, será estornado ao USUÁRIO valor correspondente a 50% (cinquenta por cento) do valor pago. Em nenhuma hipótese haverá estorno do valor total do serviço, já que o simples agendamento de consulta ou exame por meio da plataforma digital enseja a efetivação da prestação dos serviços pelo DOCTOR HOJE.</p>
                        <p>32. Se o USUÁRIO não comparecer no dia da consulta ou procedimento agendado ou se não efetuar a remarcação da consulta ou do procedimento com pelo menos 24 (vinte e quatro) de antecedência ao horário e data marcados, o valor do procedimento (consulta ou exame) não será estornado, será cobrado normalmente, estando o USUÁRIO ciente e plenamente de acordo com o ora estabelecido.</p>
                        <p>33. Os exames ou consultas só poderão ser reagendados uma única vez pelo UUSÁRIO e dentro de 30 (trinta) dias a contar da data do agendamento inicial.</p>
                        <p>34. Na hipótese de exames disponibilizados por PRESTADORES sem necessidade de agendamento (Ex: exames laboratoriais), o USUÁRIO poderá cancelá-los por meio da plataforma digital DOCTOR HOJE em até 7 (sete) dias após a respectiva compra, desde que ainda não os tenha realizado. Nesse caso, será devolvido o valor integral pago pelo USUÁRIO. Para desistência ou cancelamento após o 8º (oitavo) dia da compra, será estornado ao USUÁRIO valor correspondente a 50% (cinquenta por cento) do valor pago.</p>
                        <p>34.1. Todo e qualquer exame que não necessite de agendamento, deverá ser obrigatoriamente realizado em até 60 (sessenta) dias da compra, sob pena de o USUÁRIO perder o valor pago pelo mesmo. </p>
                        <p>35. A devolução quando devida ocorrerá por meio de crédito em conta corrente ou estorno do cartão de crédito, conforme o caso, no prazo máximo de até 5 (cinco) dias úteis do pedido de cancelamento ou no prazo estabelecido pelo cartão de débito ou crédito.</p>
                        <p>36. Se o PRESTADOR cancelar a consulta ou exame agendado, o PRESTADOR ou o USUÁRIO deverão contatar o DOCTOR HOJE, o qual providenciará o reagendamento com outro PRESTADOR com a maior brevidade possível. </p>
                        <p>37. O USUÁRIO poderá exercer o direito de arrependimento e desistir da consulta ou exame adquiridos pela plataforma digital DOCTOR HOJE no prazo máximo de até 7 (sete) dias contados da aquisição, desde que ainda não os tenha realizado. Nesse caso, será devolvido o valor integral pago pelo USUÁRIO.</p>
                        <div class="tabela-termos">
                            <div class="row">

                                <div class="col-md-12 titulo">
                                    Regras para cancelamento e agendamento
                                </div>
                                <div class="col-md-12">
                                    &nbsp;
                                </div>
                                <div class="col-md-4 titulo">
                                    Solicitação/Período
                                </div>
                                <div class="col-md-4 titulo">
                                    Até 24 horas
                                </div>
                                <div class="col-md-4 titulo">
                                    Inferior a 24 horas
                                </div>

                                <div class="col-md-4 linha">
                                    Cancelamento
                                </div>
                                <div class="col-md-4 linha">
                                    Reembolso de 50% do valor pago em até 5 dias úteis
                                </div>
                                <div class="col-md-4 linha">
                                    Sem direito a reembolso
                                </div>

                                <div class="col-md-4 linha">
                                    Reagendamento
                                </div>
                                <div class="col-md-4 linha">
                                    Direito a 1 (um) reagendamento em no máximo 30 dias
                                </div>
                                <div class="col-md-4 linha">
                                    Perda do direito de reagendamento
                                </div>

                                <div class="col-md-4 titulo">
                                    Regras especiais
                                </div>
                                <div class="col-md-4 titulo">
                                    Prazos
                                </div>
                                <div class="col-md-4 titulo">
                                    Condições
                                </div>

                                <div class="col-md-4 linha">
                                    Exames sem necessidade de agendamento
                                </div>
                                <div class="col-md-4 linha">
                                    Realizar até 60 dias da aquisição
                                </div>
                                <div class="col-md-4 linha">
                                    Após 60 dias perderá o direito ao reembolso
                                </div>

                                <div class="col-md-4 linha">
                                    Cancelamento da conta DOCTOR HOJE
                                </div>
                                <div class="col-md-4 linha">
                                    Realizar até 30 dias após pedido de cancelamento da conta
                                </div>
                                <div class="col-md-4 linha">
                                    Após 30 dias perderá o direito ao reembolso
                                </div>

                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <p><span>Instruções para realização de consultas e exames</span></p>
                        <p>38. Na data da consulta ou exame agendado, o USUÁRIO deverá comparecer ao estabelecimento do PRESTADOR com antecedência mínima de 30 (trinta) minutos, sempre munido de documento de identidade, pedido médico ou odontológico, quando for o caso, e código de confirmação da consulta ou do exame fornecido pelo DOCTOR HOJE e disponível na área logada.</p>
                        <p>39. Cabe a cada PRESTADOR indicar livremente os prazos de retorno de consultas médicas ou odontológicas, as quais deverão ser agendadas pelo DOCTOR HOJE. A determinação do tempo necessário para avaliação do USUÁRIO e de seus exames segue critérios técnicos e médicos, sem qualquer interferência do DOCTOR HOJE.</p>
                        <p>40. Na hipótese de realização de exames que ensejem preparo específico (ex.: jejum, dieta, medicação), o USUÁRIO será informado pelo DOCTOR HOJE, pelo e-mail cadastrado.</p>
                        <p>41. Após cada consulta ou exame, o USUÁRIO terá a possibilidade de avaliar o PRESTADOR acessando a plataforma DOCTOR HOJE. Essa avaliação é facultativa e consiste na atribuição de uma nota de 1 (um) a 5 (cinco) para o atendimento do PRESTADOR, para as condições de atendimento do profissional, atendimento da secretária, tempo de espera, estrutura física e acessibilidade. </p>
                        <p>42. O USUÁRIO e PRESTADOR expressamente concordam e reconhecem que o DOCTOR HOJE não tem nenhuma responsabilidade em relação às avaliações dos PRESTADORES realizadas pelos USUÁRIOS, e que essas avaliações não devem ser consideradas divulgações de caráter publicitário.</p>

                        <p><span>Pagamento pelos serviços contratados no site e taxa de agendamento</span></p>
                        <p>43. A remuneração pela contratação do PRESTADOR será paga pelo USUÁRIO por meio da plataforma digital DOCTOR HOJE, por meio de cartão de débito ou crédito.</p>
                        <p>44. O USUÁRIO concorda que o DOCTOR HOJE cobrará uma taxa de utilização do serviço tecnológico prestado, que incidirá sobre o preço de cada consulta ou exame agendado por meio do Site, a qual estará incluída no valor total cobrado por cada consulta ou exame.</p>
                        <p>44.1. Para a utilização do serviço tecnológico o USUÁRIO pagará ao DOCTOR HOJE o valor anual de R$ 9,99 (nove reais e noventa e nove centavos), estando isentos do pagamento da anuidade os USUÁRIOS que se inscreverem no Site até 30 de setembro de 2018. </p>
                        <p>44.2. O DOCTOR HOJE deixa claro que o valor anual refere-se a utilização do serviço tecnológico e não se trata, nem se equipara a mensalidades ou pagamentos a planos privados de assistência à saúde.</p>
                        <p>45. O USUÁRIO concorda em pagar por todo e qualquer serviço intermediado por meio da plataforma digital DOCTOR HOJE utilizando seu nome, cartão de débito ou crédito ou outras formas de pagamento. Todos os pagamentos feitos através de cartão de débito ou crédito estarão sujeitos à autorização e aprovação da administradora do cartão.</p>
                        <p>45.1. O USUÁRIO, a seu critério, poderá optar pelo armazenamento dos dados de seu cartão de débito ou crédito para facilitar futuras compras. </p>
                        <p>46. O DOCTOR HOJE emitirá nota fiscal eletrônica, a qual será enviada por e-mail ao USUÁRIO. Por se tratar de prestação de serviços tecnológicos de agendamento de consultas ou exames, os valores não são dedutíveis na Declaração de Imposto de Renda ou passíveis de reembolso.</p>
                        <p>47. Os valores correspondentes às consultas e exames poderão, a critério exclusivo do USUÁRIO, ser parcelados em até 2 (duas) parcelas, sem juros. Acima de 3 (três) parcelas serão cobrados juros do cartão, conforme informação que constará do Site. </p>
                        <p>48. O DOCTOR HOJE jamais será responsável por possíveis interrupções nos serviços de pagamentos de empresas contratadas, nem pelas falhas e/ou danos e prejuízos que o uso serviços possam gerar ao USUÁRIO.</p>
                        <p>49. O DOCTOR HOJE não se responsabiliza pelas obrigações tributárias que recaiam sobre as atividades dos PRESTADORES de serviços médicos ou odontológicos.</p>
                        <p>50.  Toda discrepância, erro, omissão e/ou inconveniente referente ao sistema, forma e/ou instituição de pagamento será de exclusiva responsabilidade do USUÁRIO e das instituições de pagamento, não cabendo imputação alguma ao DOCTOR HOJE. Ao optar por utilizar o serviço de controle de pagamentos, o DOCTOR HOJE não tem como evitar ocasionais falhas das referidas instituições e dos sistemas bancários e/ou administradoras de cartão de débito ou crédito.</p>
                        <p>51. Caso ocorram problemas devidos ao seu uso, o USUÁRIO deverá informar o DOCTOR HOJE por e-mail <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a> ou pelo telefone (61) 3221.5350, não gerando obrigação para que o DOCTOR HOJE resolva tais problemas.</p>

                        <p><span>PROPRIEDADE INTELECTUAL</span></p>
                        <p>52. O USUÁRIO concorda que todo o conteúdo referente aos serviços, banco de dados, redes, arquivos e todas as funcionalidades disponíveis no Site são de propriedade exclusiva do DOCTOR HOJE, seus anunciantes e/ou licenciados, e que estão protegidos como direitos autorais, marcas, segredos comerciais e outros direitos referentes a propriedade intelectual e/ou industrial previstos na Legislação Brasileira.</p>
                        <p>52.1. O conteúdo do Site DOCTOR HOJE, incluindo textos, imagens, áudios e/ou vídeos, não poderá ser distribuído, modificado, alterado, transmitido, reutilizado ou reenviado a terceiros pelo USUÁRIO, seja para qual finalidade for, sem a prévia e expressa autorização do DOCTOR HOJE. </p>
                        <p>52.2. É expressamente vedado ao USUÁRIO utilizar os dados ou o conteúdo do Site ou respectivos micro sites para criar compilações e bases de dados de qualquer tipo sem a permissão por escrito do DOCTOR HOJE. Sendo assim, é proibido o uso do conteúdo ou materiais do Site e respectivos micro sites para qualquer propósito que não esteja expressamente autorizado neste Termo de Uso.</p>
                        <p>53. A presença de links para outros sites não implica relação de sociedade, de supervisão, de cumplicidade ou solidariedade do DOCTOR HOJE para com esses sites e seus conteúdos.</p>

                        <p><span>Declarações do usuário</span></p>
                        <p>54. O USUÁRIO declara expressamente e garante, para todos os fins de direito, que possui capacidade jurídica para celebrar este contrato e utilizar os serviços objeto do mesmo, sendo maior de 18 (dezoito) anos de idade.</p>
                        <p>54.1. Os pais ou os representantes legais do menor de idade ou incapaz responderão pelos atos por ele praticados na utilização da plataforma digital, dentre os quais eventuais danos causados a terceiros, práticas de atos vedados pela lei e pelas disposições deste Termo.</p>
                        <p>55. O USUÁRIO garante que não se identificou falsamente, nem forneceu qualquer informação falsa para obter acesso ao serviço do DOCTOR HOJE.</p>
                        <p>56. O USUÁRIO está ciente que o DOCTOR HOJE se reserva o direito de utilizar todos os meios válidos e possíveis para identificar seus USUÁRIOS, bem como de solicitar dados adicionais e documentos que estime serem pertinentes a fim de conferir os dados pessoais informados.</p>
                        <p>57. O USUÁRIO está ciente que o DOCTOR HOJE poderá modificar os termos e condições do presente Termo ou as suas políticas relativas ao serviço a qualquer momento, efetivadas após a publicação de uma versão atualizada do Termo sobre o serviço.</p>
                        <p>58. O USUÁRIO é responsável por verificar regularmente o presente Termo de Uso, sendo que o uso continuado do Serviço após qualquer alteração, constituirá o seu consentimento para tais mudanças.</p>

                        <p><span>Disposições finais</span></p>
                        <p>59. O USUÁRIO poderá contatar o DOCTOR HOJE para tratar de questões referentes ao Site, incluindo dúvidas, reclamações e sugestões, por meio do endereço eletrônico: <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a>. A resposta do DOCTOR HOJE em relação às demandas do USUÁRIO deverá ser realizada em até 5 (cinco) dias úteis.</p>
                        <p>60. A propriedade do Site poderá ser cedida e transferida a qualquer tempo pelo DOCTOR HOJE a terceiros, sem necessidade de anuência do USUÁRIO.</p>
                        <p>61. Cada cláusula deste Termo de Uso deverá ser interpretada de modo a se tornar válida e eficaz à luz da lei aplicável. Caso alguma das cláusulas seja considerada ilícita, dita cláusula deverá ser julgada separadamente do restante do Termo e todas as demais cláusulas continuarão em pleno vigor.</p>
                        <p>62. A disponibilização do Site terá prazo indeterminado, reservando-se ao DOCTOR HOJE o direito de suspender ou interromper, a qualquer momento independentemente de prévio aviso.</p>
                        <p>63. As partes contratantes elegem o foro da Circunscrição Judiciária de Brasília – DF, para a resolução de quaisquer controvérsias oriundas deste Termo de Uso, renunciando a todo e qualquer outro, por mais privilegiado que seja.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-vermelho" data-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="endereco-site">
            <div class="container">
                <a href="/">www.doctorhoje.com.br</a>
                <div class="redes-sociais">
                    <a href="https://www.instagram.com/doctor_hoje/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/DoctorHoje/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                </div>
            </div>
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
                headerTitle: 'Whatsapp do Doctor Hoje',
            });
        });
    </script>

@endpush

@stack('scripts')

</body>
</html>
