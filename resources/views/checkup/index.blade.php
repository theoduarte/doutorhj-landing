@extends('layouts.base')

@section('title', 'DoctorHoje: Resultado')

@push('scripts')

@endpush

@section('content')
    <section class="resultado resultado-checkup">
        <div class="container">
            <div class="area-container">
                <div class="area-alt-busca">
                    <a class="btn btn-primary btn-alt-busca" data-toggle="collapse" href="#collapseFormulario" role="button" aria-expanded="false" aria-controls="collapseFormulario">Alterar
                        Busca <i class="fa fa-edit"></i></a>
                </div>
                <div class="collapseFormulario collapse show" id="collapseFormulario">
                    <form action="/resultado" class="form-busca-resultado" method="get" onsubmit="return validaBuscaAtendimento()">
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                    <option>Checkup</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="tipo_especialidade" class="form-control" name="tipo_especialidade">
                                    <option>Acima de 60 anos - Masculino</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="local_atendimento" class="form-control" name="local_atendimento">
                                    <option>Todos</option>
                                    <option>Básico</option>
                                    <option>Intermediário</option>
                                    <option>Completo</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <button type="submit" class="btn btn-primary btn-vermelho"><i class="fa fa-search"></i>
                                    Alterar Busca
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="titulo">
                    <strong>3 resultados para Checkup acima de 60 anos masculino - Asa Sul</strong>
                    <p>Escolha abaixo um dos pacotes de exames para seu checkup</p>
                </div>
                <div class="lista">
                    <div class="accordion">
                        <div class="card">
                            <div class="card-header" id="headingUm">
                                <div class="resumo">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-8 col-xl-9">
                                            <div class="resumo-pacote">
                                                <h4>Checkup Básico com 34 procedimentos</h4>
                                                <span class="incluso">Incluso nesse pacote:</span>
                                                <ul class="quantidade">
                                                    <li><span>4</span> consultas</li>
                                                    <li><span>6</span> exames</li>
                                                    <li><span>3</span> raio-x</li>
                                                    <li><span>1</span> avaliação cardio vascular</li>
                                                </ul>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseUm" aria-expanded="true" aria-controls="collapseOne">
                                                    ver lista de procedimentos
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="valores">
                                                <div class="mercado">
                                                    <p>Valor de mercado</p>
                                                    <span>R$ 1.242,45</span>
                                                </div>
                                                <div class="drhj">
                                                    <p>Procedimentos individuais no Doctor Hoje</p>
                                                    <span>R$ 1.129,50</span>
                                                </div>
                                                <div class="checkup">
                                                    <p>Valor do Checkup</p>
                                                    <span>R$ 809,51</span>
                                                    <button class="btn btn-vermelho" type="button" data-toggle="collapse" data-target="#collapseUm" aria-expanded="true" aria-controls="collapseOne">
                                                        Agendar este Checkup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="collapseUm" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">

                                    {{-- CONSULTAS --}}

                                    <div id="consultas" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Consultas
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Clínico-cardiológica com smokerlyser para tabagistas
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento001" id="clinicaProcedimento001" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento001">
                                                                Biocárdios - SEPS Q 709/909 BL F - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Dermatológica com dermatoscópio
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento002" id="clinicaProcedimento002" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento002">
                                                                Cimed - Casa 01, Quadra 02 - Taguatinga Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Oftalmológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento003" id="clinicaProcedimento003" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento003">
                                                                Pacini - SEPS Q 715/915 - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Urológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento004" id="clinicaProcedimento004" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento004">
                                                                Aliança - Setor Médico Hospitalar Norte 2 BL C, CJ 22 Edifício Dr. Crispim - Asa Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- EXAMES --}}

                                    <div id="exames" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Exames
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Acido úrico
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento005" id="clinicaProcedimento005" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento005">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        B12 sérica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento006" id="clinicaProcedimento006" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento006">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Colesterol total e frações
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento007" id="clinicaProcedimento007" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento007">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Creatinina
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento008" id="clinicaProcedimento008" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento008">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Dosagem de 25OH Vit D
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento009" id="clinicaProcedimento009" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento009">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- IMAGEM --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento010" id="clinicaProcedimento010" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento010">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US abdomen total
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento011" id="clinicaProcedimento011" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento011">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US próstata
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento012" id="clinicaProcedimento012" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento012">
                                                                Villas Boas - SHLS 716 Conjunto N, Bloco D - Asa Sul, Brasília
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- AVALIAÇÃO --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento013" id="clinicaProcedimento013" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento013">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-vermelho prosseguir" type="button">
                                            Prosseguir para pagamento
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingDois">
                                <div class="resumo">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-8 col-xl-9">
                                            <div class="resumo-pacote">
                                                <h4>Checkup Intermediário com 41 procedimentos</h4>
                                                <span class="incluso">Incluso nesse pacote:</span>
                                                <ul class="quantidade">
                                                    <li><span>4</span> consultas</li>
                                                    <li><span>6</span> exames</li>
                                                    <li><span>3</span> raio-x</li>
                                                    <li><span>1</span> avaliação cardio vascular</li>
                                                </ul>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseDois" aria-expanded="true" aria-controls="collapseOne">
                                                    ver lista de procedimentos
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="valores">
                                                <div class="mercado">
                                                    <p>Valor de mercado</p>
                                                    <span>R$ 1.242,45</span>
                                                </div>
                                                <div class="drhj">
                                                    <p>Procedimentos individuais no Doctor Hoje</p>
                                                    <span>R$ 1.129,50</span>
                                                </div>
                                                <div class="checkup">
                                                    <p>Valor do Checkup</p>
                                                    <span>R$ 974,32</span>
                                                    <button class="btn btn-vermelho" type="button" data-toggle="collapse" data-target="#collapseDois" aria-expanded="true" aria-controls="collapseOne">
                                                        Agendar este Checkup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="collapseDois" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">

                                    {{-- CONSULTAS --}}

                                    <div id="consultas" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Consultas
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Clínico-cardiológica com smokerlyser para tabagistas
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento014" id="clinicaProcedimento014" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento014">
                                                                Biocárdios - SEPS Q 709/909 BL F - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Dermatológica com dermatoscópio
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento015" id="clinicaProcedimento015" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento015">
                                                                Cimed - Casa 01, Quadra 02 - Taguatinga Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Oftalmológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento016" id="clinicaProcedimento016" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento016">
                                                                Pacini - SEPS Q 715/915 - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Urológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento017" id="clinicaProcedimento017" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento017">
                                                                Aliança - Setor Médico Hospitalar Norte 2 BL C, CJ 22 Edifício Dr. Crispim - Asa Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- EXAMES --}}

                                    <div id="exames" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Exames
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Acido úrico
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento018" id="clinicaProcedimento018" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento018">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        B12 sérica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento019" id="clinicaProcedimento019" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento019">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Colesterol total e frações
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento020" id="clinicaProcedimento020" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento020">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Creatinina
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento021" id="clinicaProcedimento021" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento021">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Dosagem de 25OH Vit D
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento022" id="clinicaProcedimento022" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento022">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- IMAGEM --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento023" id="clinicaProcedimento023" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento023">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US abdomen total
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento024" id="clinicaProcedimento024" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento024">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US próstata
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento025" id="clinicaProcedimento025" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento025">
                                                                Villas Boas - SHLS 716 Conjunto N, Bloco D - Asa Sul, Brasília
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- AVALIAÇÃO --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento026" id="clinicaProcedimento026" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento026">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-vermelho prosseguir" type="button">
                                            Prosseguir para pagamento
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingTres">
                                <div class="resumo">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-8 col-xl-9">
                                            <div class="resumo-pacote">
                                                <h4>Checkup Completo com 34 procedimentos</h4>
                                                <span class="incluso">Incluso nesse pacote:</span>
                                                <ul class="quantidade">
                                                    <li><span>4</span> consultas</li>
                                                    <li><span>6</span> exames</li>
                                                    <li><span>3</span> raio-x</li>
                                                    <li><span>1</span> avaliação cardio vascular</li>
                                                </ul>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTres" aria-expanded="true" aria-controls="collapseOne">
                                                    ver lista de procedimentos
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="valores">
                                                <div class="mercado">
                                                    <p>Valor de mercado</p>
                                                    <span>R$ 1.242,45</span>
                                                </div>
                                                <div class="drhj">
                                                    <p>Procedimentos individuais no Doctor Hoje</p>
                                                    <span>R$ 1.129,50</span>
                                                </div>
                                                <div class="checkup">
                                                    <p>Valor do Checkup</p>
                                                    <span>R$ 1.161,00</span>
                                                    <button class="btn btn-vermelho" type="button" data-toggle="collapse" data-target="#collapseTres" aria-expanded="true" aria-controls="collapseOne">
                                                        Agendar este Checkup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="collapseTres" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">

                                    {{-- CONSULTAS --}}

                                    <div id="consultas" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Consultas
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Clínico-cardiológica com smokerlyser para tabagistas
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento027" id="clinicaProcedimento027" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento027">
                                                                Biocárdios - SEPS Q 709/909 BL F - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Dermatológica com dermatoscópio
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento028" id="clinicaProcedimento028" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento028">
                                                                Cimed - Casa 01, Quadra 02 - Taguatinga Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Oftalmológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento029" id="clinicaProcedimento029" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento029">
                                                                Pacini - SEPS Q 715/915 - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Consulta Urológica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento030" id="clinicaProcedimento030" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento030">
                                                                Aliança - Setor Médico Hospitalar Norte 2 BL C, CJ 22 Edifício Dr. Crispim - Asa Norte, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- EXAMES --}}

                                    <div id="exames" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Exames
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Acido úrico
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento031" id="clinicaProcedimento031" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento031">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        B12 sérica
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento032" id="clinicaProcedimento032" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento032">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Colesterol total e frações
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento033" id="clinicaProcedimento033" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento033">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Creatinina
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento034" id="clinicaProcedimento034" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento034">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        Dosagem de 25OH Vit D
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento035" id="clinicaProcedimento035" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento035">
                                                                Sabin - Setor Bancário Sul Q 1 Bloco C Loja 16 - Asa Sul, Brasília - DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- IMAGEM --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento036" id="clinicaProcedimento036" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento036">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US abdomen total
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento037" id="clinicaProcedimento037" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento037">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento multi-exames">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="informativo">
                                                        Os procedimentos acima serão realizados em uma mesma clínica,
                                                        necessitando assim de apenas uma data e horário
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        US próstata
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento038" id="clinicaProcedimento038" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento038">
                                                                Villas Boas - SHLS 716 Conjunto N, Bloco D - Asa Sul, Brasília
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- AVALIAÇÃO --}}

                                    <div id="imagem" class="pacote-procedimentos">
                                        <div class="titulo">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    Imagem
                                                </div>
                                                <div class="col-xl-4">
                                                    Escolha data e horário
                                                </div>
                                            </div>
                                        </div>
                                        <div class="procedimento">
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <div class="nome">
                                                        RX tórax PA
                                                        <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="<u>BREVE</u> <b>descrição</b> <em>do procedimento.</em> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="clinicas">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="clinicaProcedimento039" id="clinicaProcedimento039" value="option1" checked>
                                                            <label class="form-check-label" for="clinicaProcedimento039">
                                                                CRB - SHLS Conj. B Bloco A - Brasília, DF
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="escolher-data">
                                                        <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                        <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                    </div>
                                                    <div class="escolher-hora">
                                                        <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                        <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-vermelho prosseguir" type="button">
                                            Prosseguir para pagamento
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            var laravel_token = '{{ csrf_token() }}';
            var resizefunc = [];

            /*********************************
             *
             * COLLAPSE FORM BUSCA MOBILE
             *
             *********************************/

            jQuery(document).ready(function($) {
                var alterClass = function() {
                    var ww = document.body.clientWidth;
                    if (ww < 975) {
                        $('.collapseFormulario').removeClass('show');
                    } else if (ww >= 975) {
                        $('.collapseFormulario').addClass('show');
                    };
                };
                $(window).resize(function(){
                    alterClass();
                });
                //Fire it when the page first loads:
                alterClass();
            });

            /*********************************
             *
             * TROCA COR CARD AO CLICAR
             *
             *********************************/

            $('.card').on('show.bs.collapse hide.bs.collapse', function (e) {
                if (e.type == 'show') {
                    $(this).addClass("card-active");
                } else {
                    $(this).removeClass("card-active");
                }
            });

            /*********************************
             *
             * DATA E HORA
             *
             *********************************/

            jQuery.datetimepicker.setLocale('pt-BR');

            /* DATA */

            jQuery('.selecionaData').datetimepicker({
                timepicker: false,
                format: 'd.m.Y'
            });

            /* HORA */

            jQuery('.selecionaHora').datetimepicker({
                datepicker: false,
                format: 'H:i',
                step: 30,
                minTime: '08:00',
                maxTime: '18:10',
            });

        </script>
    @endpush

@endsection
