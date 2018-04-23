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
                    	<input type="hidden" name="current_url" value="{{ $url }}">
                        <div id="accordion">
                        	@foreach($carrinho as $item)
                            <div class="card card-resumo-compra">
                                <div class="card-header" id="heading_{{ $item['item_id'] }}">
                                    <div class="row">
                                        <div class="nome-produto col-10 col-sm-7" data-toggle="collapse"
                                             data-target="#collapse_{{ $item['item_id'] }}" aria-expanded="false"
                                             aria-controls="collapseOne">
                                            <span>{{ $item['atendimento']->ds_preco }}</span>
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
                                            <span>R$ {{ $item['atendimento']->getVlComercialAtendimento() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse_{{ $item['item_id'] }}" class="collapse" aria-labelledby="heading_{{ $item['item_id'] }}"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Pessoa que utilizará o serviço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ isset($user_session) ? $user_session->name : '--------' }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Médico:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Dr. {{ $item['profissional']->nm_primario.' '.$item['profissional']->nm_secundario }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Especialidade:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ isset($item['atendimento']->procedimento_id) ? $item['atendimento']->procedimento->especialidade->ds_especialidade : isset($item['atendimento']->consulta_id) ? $item['atendimento']->consulta->especialidade->ds_especialidade : '--------' }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Prestador:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ $item['clinica']->nm_fantasia }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Endereço:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ $item['clinica']->enderecos->first()->te_endereco.', '.$item['clinica']->enderecos->first()->nr_logradouro.', '.$item['clinica']->enderecos->first()->te_bairro }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Data pré-agendada:</span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ date('d/m/Y', strtotime($item['data_agendamento'])) }} - {{ strftime('%A', strtotime($item['data_agendamento'])) }}</p>
                                            </div>
                                        </div>
                                        <div class="linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Horário pré-agendado: </span>
                                            </div>
                                            <div class="dados-resumo">
                                                <p>{{ date('H', strtotime($item['hora_agendamento'])).'h'.date('i', strtotime($item['hora_agendamento'])).'min' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- 
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
                             -->

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
                                            <p><strong>R$ <span>{{ $valor_total }}</span></strong></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 area-btn-finalizar">
                                        <a href="{{ $url }}" class="btn btn-link btn-continuar-comprando">Continuar comprando</a>
                                    </div>
                                    <div class="col-12 col-md-6 area-btn-finalizar">
                                    	<a href="{{ route('pagamento')}}" class="btn btn-vermelho btn-finalizar">Finalizar Pagamento </a>
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
