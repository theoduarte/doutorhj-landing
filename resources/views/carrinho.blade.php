@extends('layouts.base')

@section('title', 'Carrinho de Compras - DoutorHJ')

@push('scripts')

@endpush

@section('content')
    <section class="carrinho">
        <div class="container">
            <div class="area-container">
                <div class="titulo">
                    <strong>Carrinho de compras</strong>
                </div>
                <div class="produtos-carrinho">

                    <div class="card-body">
                        <div id="accordion">

                            <div class="card card-resumo-compra">
                                <div class="card-header" id="headingOne">
                                    <div class="row">
                                        <div class="nome-produto col-10 col-sm-7" data-toggle="collapse"
                                             data-target="#collapseOne" aria-expanded="false"
                                             aria-controls="collapseOne">
                                            <span>Eletrocardiograma</span>
                                        </div>
                                        <div class="detalhes-produto col-12 col-sm-2" data-toggle="collapse"
                                             data-target="#collapseOne" aria-expanded="false"
                                             aria-controls="collapseOne">
                                            <span>+ detalhes</span>
                                        </div>
                                        <div class="excluir-produto col-2 col-sm-1">
                                            <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                        <div class="valor-produto col-12 col-sm-2">
                                            <span>R$ 180,00</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Pessoa que utilizará o serviço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>João Silva Souza</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Médico:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Dr. Alexandre José</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Especialidade:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Cardiologia</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Prestador:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Acreditar Clínica Médica S.A.</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Endereço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED.
                                                    ADV, S/N </p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Data pré-agendada:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>26/03/2018 - Segunda-feira</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Horário pré-agendado: </span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>10h30min</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-resumo-compra">
                                <div class="card-header" id="headingTwo">
                                    <div class="row">
                                        <div class="nome-produto col-10 col-sm-7" data-toggle="collapse"
                                             data-target="#collapseTwo" aria-expanded="false"
                                             aria-controls="collapseTwo">
                                            <span>Eletrocardiograma</span>
                                        </div>
                                        <div class="detalhes-produto col-12 col-sm-2" data-toggle="collapse"
                                             data-target="#collapseTwo" aria-expanded="false"
                                             aria-controls="collapseTwo">
                                            <span>+ detalhes</span>
                                        </div>
                                        <div class="excluir-produto col-2 col-sm-1">
                                            <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                        <div class="valor-produto col-12 col-sm-2">
                                            <span>R$ 180,00</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Pessoa que utilizará o serviço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>João Silva Souza</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Médico:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Dr. Alexandre José</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Especialidade:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Cardiologia</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Prestador:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Acreditar Clínica Médica S.A.</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Endereço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED.
                                                    ADV, S/N </p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Data pré-agendada:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>26/03/2018 - Segunda-feira</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Horário pré-agendado: </span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>10h30min</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-resumo-compra">
                                <div class="card-header" id="headingTree">
                                    <div class="row">
                                        <div class="nome-produto col-10 col-sm-7" data-toggle="collapse"
                                             data-target="#collapseTree" aria-expanded="false"
                                             aria-controls="collapseTree">
                                            <span>Eletrocardiograma</span>
                                        </div>
                                        <div class="detalhes-produto col-12 col-sm-2" data-toggle="collapse"
                                             data-target="#collapseTree" aria-expanded="false"
                                             aria-controls="collapseTree">
                                            <span>+ detalhes</span>
                                        </div>
                                        <div class="excluir-produto col-2 col-sm-1">
                                            <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                        <div class="valor-produto col-12 col-sm-2">
                                            <span>R$ 180,00</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTree" class="collapse" aria-labelledby="headingTree"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Pessoa que utilizará o serviço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>João Silva Souza</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Médico:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Dr. Alexandre José</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Especialidade:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Cardiologia</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Prestador:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Acreditar Clínica Médica S.A.</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Endereço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED.
                                                    ADV, S/N </p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Data pré-agendada:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>26/03/2018 - Segunda-feira</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Horário pré-agendado: </span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>10h30min</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="resumo-compra">
                                <div class="row">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-3">
                                        <div class="titulo-resumo">
                                            <span>Valor do(s) serviço(s):</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dados-resumo">
                                            <p><strong>R$ <span>540,00</span></strong></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 area-btn-finalizar">
                                        <button type="button" class="btn btn-link btn-continuar-comprando">
                                            Continuar comprando
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6 area-btn-finalizar">
                                        <button type="submit" class="btn btn-vermelho btn-finalizar">Finalizar
                                            Pagamento
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
        </script>
    @endpush

@endsection
