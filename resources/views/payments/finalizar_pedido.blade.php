@extends('layouts.base')
@section('title', 'Pagamento - DoutorHJ')
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
                                    @foreach($agendamentos as  $agendamento)
                                    
                                  
                                        {{
                                            
                                           

                                          var_dump($agendamento)
                                        
                                        
                                        }}
                                      
                                        

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