@extends('layouts.base')
@section('title', 'Pagamento - DoctorHj')
@push('scripts')
@endpush
@section('content')
    <section class="pagamento">
        <div class="container">
            <div class="area-container">
                <div class="titulo">
                    <strong>Pré-agendamento realizado com sucesso!</strong>
                    <p>Sua <b>solicitação</b> foi realizada com sucesso. Em até 48 horas você receberá a
                        confirmação do agendamento escolhido.
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card card-formulario card-concluir">
                            <div class="card-header">
                                NÚMERO DO PEDIDO: {{ sprintf("%08d", $pedido->id) }}
                            </div>
                            <div class="card-body">
                                <div id="accordion">
                                    @foreach($result_agendamentos as $index => $agendamento)
                                        <div class="card card-resumo-compra">
                                            <div class="card-header" id="heading_{{ $agendamento->id }}">
                                                <div class="row">
                                                    <div class="nome-produto col-12 col-sm-7" data-toggle="collapse"
                                                         data-target="#collapse_{{ $agendamento->id }}"
                                                         aria-expanded="true"
                                                         aria-controls="collapse_{{ $agendamento->id }}">
                                                        <div>
                                                            <span>{{ $agendamento->atendimento->ds_preco }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="numero-token col-12 col-sm-5">
                                                        <div>
                                                            <?php /* <span>TOKEN DE ATENDIMENTO: {{ $agendamento->te_ticket }}</span> */ ?>
                                                            <span>●●●●●●</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="collapse_{{ $agendamento->id }}" class="collapse show"
                                                 aria-labelledby="heading_{{ $agendamento->id }}"
                                                 data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-5">
                                                            <div class="linha-resumo">
                                                                    <div class="titulo-resumo">
                                                                        <span>Pessoa que utilizará o serviço:</span>
                                                                    </div>
                                                                    <div class="dados-resumo">
                                                                        <p>{{ isset($agendamento->paciente) ? $agendamento->paciente->nm_primario.' '.$agendamento->paciente->nm_secundario : '--------' }}</p>
                                                                    </div>
                                                            </div>
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Data pré-agendada:</span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>{{ date('d/m/Y', strtotime($agendamento->getRawDtAtendimentoAttribute())) }} - {{ strftime('%A', strtotime($agendamento->getRawDtAtendimentoAttribute())) }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Horário pré-agendado: </span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>{{ date('H', strtotime($agendamento->getRawDtAtendimentoAttribute())).'h'.date('i', strtotime($agendamento->getRawDtAtendimentoAttribute())).'min' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Endereço:</span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>{{ $agendamento->filial->endereco->te_endereco.', '.$agendamento->filial->endereco->nr_logradouro.', '.$agendamento->filial->endereco->te_bairro }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-4">
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Médico:</span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>
                                                                        Dr. {{ $agendamento->profissional->nm_primario.' '.$agendamento->profissional->nm_secundario }}
                                                                    </p>
                                                                    <input type="hidden" id="profissional_id_{{ $index }}" name="profissional_id_[{{ $index }}]" value="{{ isset($agendamento->profissional) ? $agendamento->profissional->id : 0 }}">
                                                                </div>
                                                            </div>
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Especialidade:</span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>{{  $agendamento->nome_especialidade }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo">
                                                                    <span>Prestador:</span>
                                                                </div>
                                                                <div class="dados-resumo">
                                                                    <p>{{ $agendamento->clinica->nm_fantasia }} - Und: ( {{ $agendamento->filial->nm_nome_fantasia }} )</p>
                                                                    <input type="hidden" id="clinica_id_{{ $index }}" name="clinica_id_[{{ $index }}]" value="{{ isset($agendamento->clinica) ? $agendamento->clinica->id : 0 }}">
                                                                    <input type="hidden" id="filial_id_{{ $index }}" name="filial_id_[{{ $index }}]" value="{{ isset($agendamento->filial) ? $agendamento->filial->id : 0 }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-3">
                                                            <div class="linha-resumo">
                                                                <div class="titulo-resumo text-right">
                                                                    <span>VALOR DO ATENDIMENTO:</span>
                                                                </div>
                                                                <div class="dados-resumo text-right">
                                                                    <h3>
                                                                        <strong>R$ {{ $agendamento->itempedidos->first()->getVlItempedido() }}</strong>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="concluir-total">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4>VALOR TOTAL DO PEDIDO</h4>
                                            </div>
                                            <div class="col-md-2">
                                                <h3>
                                                    <strong>R$ {{ number_format( $valor_total_pedido,  2, ',', '.') }}</strong>
                                                </h3>
                                            </div>
                                        </div>
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
            $(document).ready(function () {

                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];

                /*********************************
                 *
                 * ALTERA FORMULARIO PAGAMENTO
                 *
                 *********************************/

                $(function () {
                    $('#selectFormaPagamento').change(function () {
                        if ($(this).val() == 'debito') {
                            $('#parcelamento-content').hide();
                        } else if ($(this).val() == 'credito') {
                            $('#parcelamento-content').show();
                        }
                        $('.formas-pagamento').hide();
                        $('#' + $(this).val()).show();
                    });
                });

                /*********************************
                 *
                 * ATIVA TOOLTIP
                 *
                 *********************************/

                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })

                /*********************************
                 *
                 * REMOVE PRODUTO
                 *
                 *********************************/

                $(".close-div").on("click", function (event) {
                    event.preventDefault();
                    if (confirm("Tem certeza que deseja excluir esse produto?")) {
                        $(this).parent().parent().parent().parent().remove();
                    }
                });

            });
        </script>
    @endpush
@endsection