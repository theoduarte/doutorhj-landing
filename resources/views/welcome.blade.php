@extends('layouts.base')

@section('title', 'Home: DoctorHoje')

@push('scripts')
@endpush

@section('content')
    @if (Auth::check())
        <section class="area-busca-interna home-logado">
            <div class="container">
                <div class="busca-home">
                    <div class="titulo">
                        <span>Quero agendar</span>
                    </div>
                    <form action="/resultado" class="form-busca-home" method="get" onsubmit="return validaBuscaAtendimento()">
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-3">
                                <label for="tipo">Tipo de atendimento</label>
                                <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                    <option value="" disabled selected hidden>Ex.: Consulta</option>
                                    <option value="saude">Consulta Médica</option>
                                    <option value="odonto">Consulta Odontológica</option>
                                    <option value="exame">Exames</option>
                                    <!-- <option value="procedimento">Procedimento</option> -->
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <label for="especialidade">Especialidade ou exame</label>
                                <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                    <option value="" disabled selected hidden>Ex.: Clínica Médica</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <label for="local">Local de antedimento</label>
                                <!-- <input type="text" id="local_atendimento" class="form-control cvx-local-atendimento" name="local_atendimento" placeholder="Ex.: Asa Sul"> -->
                                <select id="local_atendimento" class="form-control select2" name="local_atendimento">
                                    <option value="" disabled selected hidden>Ex.: Asa Sul</option>
                                </select>
                                <i class="cvx-no-loading fa fa-spin fa-spinner"></i>
                                <input type="hidden" id="endereco_id" name="endereco_id">
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <button type="submit" class="btn btn-primary btn-vermelho">Pesquisar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-resumo-home">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="link-agendamentos">
                                <p>Não se esqueça da sua<br> próxima consulta e/ou exame</p>
                                <button type="button" class="btn btn-light"
                                        onclick="window.location.href='{{ route("meus-agendamentos") }}'">Ver meus
                                    agendamentos
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach($agendamentos_home as $agendamento)
                                    <div class="proxima-consulta col-sm-12 col-md-6">
                                        <div class="area-pc">
                                            <div class="tit-pc">
                                                {{--<p>Sua próxima consulta é</p>--}}
                                                <p class="data-consulta">Dia {{ date('d', strtotime($agendamento->getRawDtAtendimentoAttribute()))}}
                                                    de {{ strftime('%B', strtotime($agendamento->getRawDtAtendimentoAttribute())) }}
                                                    às <span>{{ date('H', strtotime($agendamento->getRawDtAtendimentoAttribute())) }}
                                                        hora(s)
                                                        @if(date('i', strtotime($agendamento->getRawDtAtendimentoAttribute())) != '00')
                                                            e {{ date('i', strtotime($agendamento->getRawDtAtendimentoAttribute())) }}
                                                            minuto(s) @endif</span></p>

                                            </div>
                                            <div class="resumo">
                                                <div class="nome-status">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="beneficiario">{{ $agendamento->paciente->nm_primario }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            @if($agendamento->getRawCsStatusAttribute() == 10)
                                                                <span class="status pre-agendado">Pré-Agendado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 20)
                                                                <span class="status confirmado">Confirmado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 30)
                                                                <span class="status nao-confirmado">Não Confirmado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 40)
                                                                <span class="status finalizado">Finalizado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 50)
                                                                <span class="status ausente">Não compareceu</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 60)
                                                                <span class="status cancelado">Cancelado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 70)
                                                                <span class="status agendado">Agendado</span>
                                                            @elseif($agendamento->getRawCsStatusAttribute() == 80)
                                                                <span class="status retorno">Retorno de Consulta</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="tipo">
                                                    <span><strong>Procedimento:</strong> {{ $agendamento->atendimento->ds_preco }}</span>
                                                    <br>
                                                    <span><strong>Prestador:</strong> {{ $agendamento->clinica->nm_fantasia }}</span>
                                                </p>
                                                {{--<p class="profissional">
                                                    Dr. {{ $agendamento->profissional->nm_primario.' '.$agendamento->profissional->nm_secundario }}</p>
                                                <p class="valor">R$ <span>{{ $agendamento->valor_total }}</span></p>--}}
                                                <p class="endereco"><strong>Endereço:</strong> {{ $agendamento->endereco_completo }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-noticias-home">
                <div class="container">
                    <div class="titulo">Saúde Hoje</div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 card-post">
                            <div class="card">
                                <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o
                                        CBD </h5>
                                    <p class="card-text">However, the American Food and Drug Administration (FDA) has
                                        not
                                        approved the medicinal use of CBD. Research is ongoing, and the legal status of
                                        this
                                        and other cannabinoids varies.
                                    </p>
                                    <a href="#" class="btn btn-link">Leia mais</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 card-post">
                            <div class="card">
                                <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o CBD </h5>
                                    <p class="card-text">However, the American Food and Drug Administration (FDA) has not
                                        approved the medicinal use of CBD. Research is ongoing, and the legal status of this
                                        and other cannabinoids varies.
                                    </p>
                                    <a href="#" class="btn btn-link">Leia mais</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 card-post">
                            <div class="card">
                                <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o CBD </h5>
                                    <p class="card-text">However, the American Food and Drug Administration (FDA) has not
                                        approved the medicinal use of CBD. Research is ongoing, and the legal status of this
                                        and other cannabinoids varies.
                                    </p>
                                    <a href="#" class="btn btn-link">Leia mais</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section>
            <div class="area-banner">
                <div class="container">
                    <div class="frase">
                        <p>Conheça o novo jeito de cuidar da sua saúde</p>
                        <p>Agende consultas e exames.<br>
                            É simples, é rápido, é online!
                        </p>
                    </div>
                    <div class="busca-home">
                        <div class="titulo">
                            <span>Quero agendar</span>
                        </div>
                        <form action="/resultado" class="form-busca-home" method="get" onsubmit="return validaBuscaAtendimento()">
                            <div class="row">
                                <div class="form-group col-md-12 col-lg-3">
                                    <label for="tipo">Tipo de atendimento</label>
                                    <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                        <option value="" disabled selected hidden>Ex.: Consulta</option>
                                        <option value="saude">Consulta Médica</option>
                                        <option value="odonto">Consulta Odontológica</option>
                                        <option value="exame">Exames</option>
                                        <!-- <option value="procedimento">Procedimento</option> -->
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-3">
                                    <label for="especialidade">Especialidade ou exame</label>
                                    <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                        <option value="">Ex.: Clínica Médica</option>
                                        <!-- <option>Opção 1</option>
                                            <option>Opção 2</option>
                                            <option>Opção 3</option>
                                            <option>Opção 4</option> -->
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-3">
                                    <label for="local">Local de antedimento</label>
                                    <!-- <input type="text" id="local_atendimento" class="form-control cvx-local-atendimento" name="local_atendimento" placeholder="Ex.: Asa Sul"> -->
                                    <select id="local_atendimento" class="form-control select2" name="local_atendimento">
	                                    <option value="">Ex.: Asa Sul</option>
	                                </select>
                                    <i class="cvx-no-loading fa fa-spin fa-spinner"></i>
                                    <input type="hidden" id="endereco_id" name="endereco_id">
                                </div>
                                <div class="form-group col-md-12 col-lg-3">
                                    <button type="submit" class="btn btn-primary btn-vermelho">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="area-sobre" class="area-sobre">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col1-sobre">
                            <p>O que é o Doctor hoje?</p>
                            <p>O Doctor Hoje é uma<br>plataforma digital que facilita o <strong>acesso a consultas e
                                    exames</strong> com <strong>preços justos</strong> que cabem no seu orçamento.
                            </p>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-sm-12 col-md-5 col2-sobre">
                            <p>O Doctor Hoje reúne uma ampla rede de profissionais de saúde em Brasília que, por meio da
                                plataforma, oferecem o acesso a consultas
                                e exames com preços reduzidos. Não é cobrado mensalidades, carências ou taxas de adesão (NÃO
                                somos um plano ou seguro saúde).
                            </p>
                            <a href="#">Acesse e comece a usar agora mesmo <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="como-funciona" class="area-passos">
                <div class="container">
                    <div class="titulo-home">
                        <span>É tão fácil que você não vai acreditar</span>
                        <h3>Veja como é fácil levar saúde para sua família</h3>
                        <p>São apenas 5 passos para você cuidar da sua saúde.<br>
                            Chega de mensalidades caras para serviços que nem sempre você usa.
                        </p>
                    </div>
                    <div class="steps">
                        <div class="step step1">
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step1.png" alt="">
                            </div>
                            <div class="traco"></div>
                            <div class="numero">
                                <span>1</span>
                            </div>
                            <div class="texto">
                                <p>Selecione o tipo<br>de atendimento</p>
                            </div>
                        </div>
                        <div class="step step2">
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step2.png" alt="">
                            </div>
                            <div class="traco"></div>
                            <div class="numero">
                                <span>2</span>
                            </div>
                            <div class="texto">
                                <p>Escolha<br>o local</p>
                            </div>
                        </div>
                        <div class="step step3">
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step3.png" alt="">
                            </div>
                            <div class="traco"></div>
                            <div class="numero">
                                <span>3</span>
                            </div>
                            <div class="texto">
                                <p>Faça<br>a sugestão<br>do dia e horário</p>
                            </div>
                        </div>
                        <div class="step step4">
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step4.png" alt="">
                            </div>
                            <div class="traco"></div>
                            <div class="numero">
                                <span>4</span>
                            </div>
                            <div class="texto">
                                <p>Realize<br>o pagamento</p>
                            </div>
                        </div>
                        <div class="step step5">
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step5.png" alt="">
                            </div>
                            <div class="traco"></div>
                            <div class="numero">
                                <span>5</span>
                            </div>
                            <div class="texto">
                                <p>Pronto!<br>Agora é só ir ao médico<br>e cuidar da sua saúde</p>
                            </div>
                        </div>
                    </div>
                    <div class="steps-mobile">
                        <div class="step step1">
                            <div class="numero">
                                <span>1</span>
                            </div>
                            <div class="traco"></div>
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step1.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Selecione o tipo<br>de atendimento</p>
                            </div>
                        </div>
                        <div class="step step2">
                            <div class="numero">
                                <span>2</span>
                            </div>
                            <div class="traco"></div>
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step2.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Escolha<br>o local</p>
                            </div>
                        </div>
                        <div class="step step3">
                            <div class="numero">
                                <span>3</span>
                            </div>
                            <div class="traco"></div>
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step3.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Faça a sugestão<br>do dia e horário</p>
                            </div>
                        </div>
                        <div class="step step4">
                            <div class="numero">
                                <span>4</span>
                            </div>
                            <div class="traco"></div>
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step4.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Realize<br>o pagamento</p>
                            </div>
                        </div>
                        <div class="step step5">
                            <div class="numero">
                                <span>5</span>
                            </div>
                            <div class="traco"></div>
                            <div class="icone">
                                <img src="/libs/home-template/img/icone-step5.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Pronto!<br>Agora é só ir ao médico<br>e cuidar da sua saúde</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="vantagens" class="area-vantagens">
                <div class="container">
                    <div class="titulo-home">
                        <span>Você só tem a ganhar</span>
                        <h3>Vantagens em escolher o Doctor Hoje</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem1.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Mais barato</h4>
                                <p>Consultas e exames com preços reduzidos, sem mensalidades e sem carências.</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem2.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Controle total</h4>
                                <p>Pague somente ao utilizar e acompanhe todo o histórico de suas consultas e exames. </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem3.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Não fique esperando</h4>
                                <p>Realize suas consultas ou exames o quanto antes. No máximo em 10 dias você será atendido
                                    com o médico de sua preferência.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem4.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Moderno</h4>
                                <p>A agendamento online oferece a comodidade do agendamento da consulta e exame no seu computador ou celular.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem5.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Onde você precisar</h4>
                                <p>Mais de 700 prestadores em Brasília, 56 especialidades e 1200 exames. </p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="icone-vantagem">
                                <img src="/libs/home-template/img/icone-vantagem6.png" alt="">
                            </div>
                            <div class="texto-vantagem">
                                <h4>Seja avisado</h4>
                                <p>O sistema envia lembretes do dia e horário da consulta.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="area-participe">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 col-xl-6 order-lg-2 box-banner-conheca">
                            <div class="area-imagem">
                                <img src="/libs/home-template/img/banner-participe.jpg" alt="Venha fazer parte você também">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-6 order-lg-1">
                            <div class="titulo-home">
                                <span>Venha fazer parte você também</span>
                                <h3>Você é profissional de saúde?</h3>
                            </div>
                            <p>Entre em contato e venha participar da nossa plataforma. O Doctor Hoje conecta você a
                                milhares de clientes. Oferecemos sistema para o gerenciamento da sua agenda e
                                pagamentos.
                            </p>
                            <button type="button" class="btn btn-primary btn-vermelho">Saiba mais</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="area-aplicativo">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-5 area-imagem-aplicativo">
                            <img src="/libs/home-template/img/aplicativo-smartphone.png" alt="Aplicativo Doctor Hoje">
                        </div>
                        <div class="col-sm-12 col-md-7 area-texto-aplicativo">
                            <div class="titulo-home">
                                <span>a comodidade anda junto com você </span>
                                <h3>Aplicativo Doctor Hoje</h3>
                            </div>
                            <p>Com o aplicativo Doctor Hoje, você poderá ter acesso a todas as funcionalidades na palma da
                                sua mão. Agende, pague, veja suas marcações, altere horários e ainda fique por dentro das
                                novidades.
                            </p>
                            <p><strong>Em breve disponível:</strong></p>
                            <ul class="link-aplicativos">
                                <li><a href="https://play.google.com/store/apps" target="_blank">Google Play</a></li>
                                <li><a href="https://www.apple.com/br/itunes/" target="_blank">App Store</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];     

                $('#tipo_especialidade option:first').prop("selected", true);
                $('#local_atendimento option:first').prop("selected", true);           
            });

            /*********************************
            *
            * COPIA TOKEN
            *
            *********************************/

            jQuery(function ($) {

                $('#copyButton').click(function () {
                    var pElement = $('#token')[0];
                    copyToClipboard(pElement, showSuccessMsg);
                });

                function showSuccessMsg() {
                    $('#successMsg').finish().fadeIn(300).fadeOut(1000);
                }

                function copyToClipboard(element, successCallback) {
                    selectText(element);

                    var succeed;
                    try {
                        succeed = document.execCommand('copy');
                    } catch (e) {
                        succeed = false;
                    }

                    if (succeed && typeof(successCallback) === 'function') {
                        successCallback();
                    }
                }

                function selectText(element) {
                    if (/INPUT|TEXTAREA/i.test(element.tagName)) {
                        element.focus();
                        if (element.setSelectionRange) {
                            element.setSelectionRange(0, element.value.length);
                        } else {
                            element.select();
                        }
                        return;
                    }

                    var rangeObj, selection;
                    if (document.createRange) { // IE 9+ and all other browsers
                        rangeObj = document.createRange();
                        rangeObj.selectNodeContents(element);
                        selection = window.getSelection();
                        selection.removeAllRanges();
                        selection.addRange(rangeObj);
                    } else if (document.body.createTextRange) { // IE <=8
                        rangeObj = document.body.createTextRange();
                        rangeObj.moveToElementText(element);
                        rangeObj.select();
                    }
                }

            });

            /*********************************
             *
             * Smooth Scroll
             *
             *********************************/

            $('a[href*="#"]')
                .not('[href="#"]')
                .not('[href="#0"]')
                .click(function(event) {
                    if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                        &&
                        location.hostname == this.hostname
                    ) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: target.offset().top
                            }, 1000, function() {
                                var $target = $(target);
                                $target.focus();
                                if ($target.is(":focus")) {
                                    return false;
                                } else {
                                    $target.attr('tabindex','-1');
                                    $target.focus();
                                };
                            });
                        }
                    }
                });


            /*********************************
            *
            * Alerta
            *
            *********************************/

            /* Success

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Sucesso!</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Warning 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Info 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i> Informação</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Question 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-question"><i class="fa fa-question-circle" aria-hidden="true"></i> Tem certeza?</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Error 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

        </script>

    @endpush
@endsection