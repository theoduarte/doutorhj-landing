@extends('layouts.base')

@section('title', 'Meus Agendamentos - DoctorHj')

@push('scripts')

@endpush

@section('content')
    <section class="area-busca-interna minha-conta">
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
            <div class="box-meus-agendamentos">
                <div class="titulo-box">
                    Meus Agendamentos
                </div>
                <div class="lista-agendamentos">
                	@foreach($agendamentos_home as $agendamento)
                	<div class="agendamentos">
                        <div class="row">
                            <div class="col col-lg-2 area-data">
                                <p class="dia">{{ date('d', strtotime($agendamento->dt_atendimento))}}</p>
                                <p class="mes">{{ strftime('%B', strtotime($agendamento->dt_atendimento)) }}</p>
                            </div>
                            <div class="col col-lg-5 area-informacoes">
                                <div class="nome-status">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p class="beneficiario">{{ $agendamento->paciente->nm_primario }}</p>
                                        </div>
                                        <div class="col-lg-5">
                                            <span class="status pre-agendado">Pré-Agendado</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="tipo">{{ $agendamento->atendimento->ds_preco }} <strong>{{ $agendamento->clinica->nm_fantasia }}</strong></p>
                                <p class="profissional">Dr. {{ $agendamento->profissional->nm_primario.' '.$agendamento->profissional->nm_secundario }}</p>
                                <p class="valor">R$ <span>{{ $agendamento->atendimento->getVlComercialAtendimento() }}</span></p>
                                <p class="endereco">{{ $agendamento->endereco_completo }}</p>
                            </div>
                            <div class="col col-lg-4">
                                <p class="tit-token">Token</p>
                                <p class="txt-token">Apresente este código no momento da consulta</p>
                                <div class="area-token">
                                    <p class="token" id="token">{{ $agendamento->te_ticket }}</p>
                                    <p>
                                        <button class="btn btn-azul" type="button" id="copyButton">Copiar</button>
                                        <br>
                                        <span id="successMsg" style="display:none;">Copiado!</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu ddm-opcoes">
                                        <p><a href="">Remarcar</a></p>
                                        <p><a href="">Cancelar</a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                	
                    @endforeach
                    <!-- 
                    <div class="agendamentos">
                        <div class="row">
                            <div class="col col-lg-2 area-data">
                                <p class="dia">28</p>
                                <p class="mes">Abril</p>
                            </div>
                            <div class="col col-lg-5 area-informacoes">
                                <div class="nome-status">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p class="beneficiario">Luiza</p>
                                        </div>
                                        <div class="col-lg-5">
                                            <span class="status confirmado">Confirmado</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="tipo">Consulta Clínica Geral</p>
                                <p class="profissional">Dr. João Camarinha</p>
                                <p class="valor">R$ <span>120,00</span></p>
                                <p class="endereco">SCS Quadra 03, Bloco A, Nº 107, Sala 103 - Ed. Antônia Alves P. de
                                    Sousa - Asa Sul - Brasília/DF</p>
                            </div>
                            <div class="col col-lg-4">
                                <p class="tit-token">Token</p>
                                <p class="txt-token">Apresente este código no momento da consulta</p>
                                <div class="area-token">
                                    <p class="token" id="token">456 813</p>
                                    <p>
                                        <button class="btn btn-azul" type="button" id="copyButton">Copiar</button>
                                        <br>
                                        <span id="successMsg" style="display:none;">Copiado!</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu ddm-opcoes">
                                        <p><a href="">Remarcar</a></p>
                                        <p><a href="">Cancelar</a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="agendamentos">
                        <div class="row">
                            <div class="col col-lg-2 area-data">
                                <p class="dia">28</p>
                                <p class="mes">Abril</p>
                            </div>
                            <div class="col col-lg-5 area-informacoes">
                                <div class="nome-status">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p class="beneficiario">Luiza</p>
                                        </div>
                                        <div class="col-lg-5">
                                            <span class="status cancelado">Cancelado</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="tipo">Consulta Clínica Geral</p>
                                <p class="profissional">Dr. João Camarinha</p>
                                <p class="valor">R$ <span>120,00</span></p>
                                <p class="endereco">SCS Quadra 03, Bloco A, Nº 107, Sala 103 - Ed. Antônia Alves P. de
                                    Sousa - Asa Sul - Brasília/DF</p>
                            </div>
                            <div class="col col-lg-4">
                                <p class="tit-token">Token</p>
                                <p class="txt-token">Apresente este código no momento da consulta</p>
                                <div class="area-token">
                                    <p class="token" id="token">456 813</p>
                                    <p>
                                        <button class="btn btn-azul" type="button" id="copyButton">Copiar</button>
                                        <br>
                                        <span id="successMsg" style="display:none;">Copiado!</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu ddm-opcoes">
                                        <p><a href="">Remarcar</a></p>
                                        <p><a href="">Cancelar</a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     -->
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