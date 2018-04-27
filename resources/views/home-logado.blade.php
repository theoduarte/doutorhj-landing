@extends('layouts.logado')

@section('title', 'Home - DoctorHj')

@push('scripts')

@endpush

@section('content')
    <section class="area-busca-interna home-logado">
        <div class="container">
            <div class="busca-home">
                <div class="titulo">
                    <span>Quero agendar</span>
                </div>
                <form action="/resultado" class="form-busca-home" method="get">
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="tipo">Tipo de atendimento</label>
                            <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                <option>Ex.: Consulta</option>
                                <option value="saude">Consulta Médica</option>
                                <option value="odonto">Consulta Odontológica</option>
                                <option value="exame">Exames</option>
                                <option value="procedimento">Procedimento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="especialidade">Especialidade ou exame</label>
                            <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                <option>Ex.: Clínica Médica</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                                <option>Opção 3</option>
                                <option>Opção 4</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="local">Local de atendimento</label>
                            <input type="text" id="local_atendimento" class="form-control cvx-local-atendimento"
                                   name="local_atendimento" placeholder="Ex.: Asa Sul">
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
                    <div class="col-md-12 col-lg-6">
                        <div class="link-agendamentos">
                            <p>Não se esqueça da sua<br> próxima consulta e/ou exame</p>
                            <button type="button" class="btn btn-light">Meus agendamentos</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="proxima-consulta">
                            <div class="tit-pc">
                                <p>Sua próxima consulta é</p>
                                <p class="data-consulta">28 de Abril</p>
                            </div>
                            <div class="resumo">
                                <div class="nome-status">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p class="beneficiario">Luiza</p>
                                        </div>
                                        <div class="col-lg-5">
                                            <span class="status agendado">Agendado</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="tipo">Consulta Clínica Geral</p>
                                <p class="profissional">Dr. João Camarinha</p>
                                <p class="valor">R$ <span>120,00</span></p>
                                <p class="endereco">SCS Quadra 03, Bloco A, Nº 107, Sala 103 - Ed. Antônia Alves P. de
                                    Sousa - Asa Sul - Brasília/DF</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-noticias-home">
            <div class="container">
                <div class="titulo">Saúde Hoje</div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                 alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o CBD </h5>
                                <p class="card-text">However, the American Food and Drug Administration (FDA) has not
                                    approved the medicinal use of CBD. Research is ongoing, and the legal status of this
                                    and other cannabinoids varies.</p>
                                <a href="#" class="btn btn-link">Leia mais</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                 alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o CBD </h5>
                                <p class="card-text">However, the American Food and Drug Administration (FDA) has not
                                    approved the medicinal use of CBD. Research is ongoing, and the legal status of this
                                    and other cannabinoids varies.</p>
                                <a href="#" class="btn btn-link">Leia mais</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="/libs/home-template/img/blog-capa-post-1.jpg"
                                 alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Pesquisa da USP comprova mais 20 novas funções para o CBD </h5>
                                <p class="card-text">However, the American Food and Drug Administration (FDA) has not
                                    approved the medicinal use of CBD. Research is ongoing, and the legal status of this
                                    and other cannabinoids varies.</p>
                                <a href="#" class="btn btn-link">Leia mais</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];
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
        </script>

    @endpush

@endsection