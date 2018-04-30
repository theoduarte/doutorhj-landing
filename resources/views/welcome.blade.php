@extends('layouts.base')

@section('title', 'Home - DoctorHJ')

@push('scripts')

@endpush

@section('content')
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
                                    <option value="">Ex.: Consulta</option>
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
                                <input type="text" id="local_atendimento" class="form-control cvx-local-atendimento" name="local_atendimento" placeholder="Ex.: Asa Sul">
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
        <div class="area-sobre">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col1-sobre">
                        <p>O que é o Doctor hoje?</p>
                        <p>O Doctor Hoje é uma<br>plataforma digital que facilita o <strong>acesso a consultas e
                                exames</strong> com <strong>preços justos</strong> que cabem no seu orçamento.</p>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-sm-12 col-md-5 col2-sobre">
                        <p>O Doctor Hoje reúne uma ampla rede de profissionais de saúde em Brasília que, por meio da
                            plataforma, oferecem o acesso a consultas
                            e exames com preços reduzidos. Não é cobrado mensalidades, carências ou taxas de adesão (NÃO
                            somos um plano ou seguro saúde).
                        </p>
                        <a href="#">Acesse e comece a usar agora mesmo <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="area-passos">
            <div class="container">
                <div class="titulo-home">
                    <span>É tão fácil que você você não vai acreditar</span>
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
        <div class="area-vantagens">
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
                            <p>Consultas e exames com preços reduzidos, sem mensalidades e sem precisar carências.</p>
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
                                com o médico de sua preferência.</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="icone-vantagem">
                            <img src="/libs/home-template/img/icone-vantagem4.png" alt="">
                        </div>
                        <div class="texto-vantagem">
                            <h4>Moderno</h4>
                            <p>A agendamento online oferece á comodidade do agendamento da consulta e exame pela
                                internet, no seu computador ou celular.</p>
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
                            <p>Mais de 500 prestadores em Brasília, 56 especialidades e 1200 exames. </p>
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
                            pagamentos.</p>
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
                            novidades.</p>
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
@endsection
