@extends('layouts.logado')

@section('title', 'Meus Agendamentos - DoutorHJ')

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
            <div class="box-meus-agendamentos">

            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];
            });
        </script>

    @endpush

@endsection