@extends('layouts.base')

@section('title', 'Pagamento - DoctorHj')

@push('scripts')

@endpush

@section('content')
    <section class="pagamento">
        <div class="container">
            <div class="area-container">
                <div class="titulo">
                    <strong>Pagamento</strong>
                    <p>Selecione ou adicione seu cartão, escolha o beneficiário da compra e, caso houver, digite seu
                        cupom de desconto.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card card-formulario">
                            <div class="card-header">
                                Cupom de Desconto {{ substr('03/2020', 0, 2) }}
                            </div>
                            <div class="card-body">
                                <span class="card-span">Digite aqui o número do seu cupom</span>
                                <form>
                                    <div class="form-group row">
                                        <div class="col col-lg-7 col-xl-8">
                                            <input type="text" class="form-control" id="inputCupom"
                                                   placeholder="Cupom de desconto">
                                        </div>
                                        <div class="col col-lg-5 col-xl-4">
                                            <button type="submit" class="btn btn-vermelho">Validar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card card-formulario">
                            <div class="card-header">
                                Forma de pagamento
                            </div>
                            <div class="card-body">
                                <form id="form-finalizar-pedido" method="post">
                                    <div class="form-group row area-label">
                                        <label for="selectFormaPagamento" class="col-sm-12">Escolha a Forma de pagamento</label>
                                    </div>
                                    <!-- client data order -->
                                    <input type="hidden" id="titulo_pedido" name="titulo_pedido" value="{{ $titulo_pedido }}" >
                                    <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $user_session->id }}" >
                                    @foreach($carrinho as $index => $item)
                                    <input type="hidden" name="atendimento_id[{{ $index }}]" value="{{ $item['atendimento']->id }}" >
                                    @endforeach
                                    <!-- Formulário cartão de Crédito -->
                                    <div class="form-group row">
                                        <div class="col col-md-6">
                                            <div class="button dropdown">
                                                <select id="selectFormaPagamento" class="form-control" name="tipo_pagamento">
                                                    <option value="">Selecione</option>
                                                    <option value="credito">Crédito</option>
                                                    <option value="debito">Débito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="output">
                                        <div id="selecionaFormaPagamento" class="formas-pagamento"></div>
                                        <!-- Formulário cartão de Crédito -->
                                        <div id="credito" class="formas-pagamento">
                                            <div class="form-group row area-label">
                                                <label for="selectCartaoCredito" class="col-sm-12">Selecione um cartão cadastrado</label>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-md-6">
                                                    <div class="button dropdown">
                                                        <select class="form-control" id="selectCartaoCredito">
                                                            <option>Selecione</option>
                                                            <option>Cartão Visa - final 0889</option>
                                                            <option>Cartão MasterCard - final 0685</option>
                                                            <option>Cartão Cielo - final 6854</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-12 col-sm-6">
                                                    <label for="inputNumeroCartaoCredito">Número do cartão</label>
                                                    <input type="text" id="inputNumeroCartaoCredito" class="form-control input-numero-cartao cvx-checkout_card_number" name="num_cartao_credito" placeholder="Número do cartão" onkeypress="onlyNumbers(event)" maxlength="16">
                                                    <input type="hidden" id="inputBandeiraCartaoCredito" class="inputBandeiraCartaoCredito" name="bandeira_cartao_credito">
                                                </div>
                                                <div class="col col-12 col-sm-6">
                                                    <label for="inputNomeCartaoCredito">Nome impresso no cartão</label>
                                                    <input type="text" id="inputNomeCartaoCredito"  class="form-control" name="nome_impresso_cartao_credito" placeholder="Nome impresso no cartão">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-6 col-sm-6 col-md-3">
                                                    <label for="selectValidadeMesCredito">Validade</label>
                                                    <div class="button dropdown">
                                                        <select id="selectValidadeMesCredito" class="form-control select-validade-mes" name="mes_cartao_credito" >
                                                            <option>Mês</option>
                                                            @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col col-6 col-sm-6 col-md-3">
                                                    <label class="label-validade-ano" for="selectValidadeAnoCredito">&nbsp;</label>
                                                    <div class="button dropdown">
                                                        <select id="selectValidadeAnoCredito" class="form-control" name="ano_cartao_credito">
                                                        	<option>Ano</option>
                                                        	@for($i = date('Y'); $i <= (date('Y')+10); $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                    <label for="inputCodigoCredito" class="label-codigo-seguranca">Código de segurança</label>
                                                    <div class="area-codigo-seguranca">
                                                        <input type="text" id="inputCodigoCredito" class="form-control inputCodigoCredito" name="cod_seg_cartao_credito" placeholder="0000" onkeypress="onlyNumbers(event)" maxlength="3">
                                                        <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Cógido de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-12 col-sm-6">
                                                    <label for="inputCPFCredito">CPF do titular do cartão</label>
                                                    <input type="text" id="inputCPFCredito" class="form-control input-cpf-titular mascaraCPF" name="cpf-titular-cartao-credito" value="{{ $cpf_titular }}" placeholder="CPF do titular do cartão" >
                                                </div>
                                                <div class="col col-12 col-sm-6 codigo-seguranca">
                                                    <label for="selectParcelamentoCredito">Parcelamento</label>
                                                    <div class="button dropdown">
                                                        <select id="selectParcelamentoCredito" class="form-control" name="parcelamento-cartao-credito">
                                                        	@for($i = 1; $i <= sizeof($parcelamentos); $i++)
                                                            <option value="{{ $i }}">{{ $parcelamentos[$i] }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check fc-checkbox">
                                                <input type="checkbox" id="checkGravarCartaoCredito" class="form-check-input" name="gravar_cartao_credito">
                                                <label class="form-check-label" for="checkGravarCartaoCredito">Gravar dados para futuras compras</label>
                                            </div>
                                        </div>
                                        <!-- Formulário cartão de Débito -->
                                        <div id="debito" class="formas-pagamento">
                                            <div class="form-group row area-label">
                                                <label for="selectCartaoDebito" class="col-sm-12">Selecione um cartão cadastrado</label>
                                            </div>
                                            <!-- <div class="form-group row">
                                                <div class="col col-md-6">
                                                    <div class="button dropdown">
                                                        <select id="selectCartaoDebito" class="form-control">
                                                            <option>Selecione</option>
                                                            <option>Cartão Visa - final 0889</option>
                                                            <option>Cartão MasterCard - final 0685</option>
                                                            <option>Cartão Cielo - final 6854</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="form-group row">
                                                <div class="col col-12 col-sm-6">
                                                    <label for="inputNumeroCartaoDebito">Número do cartão</label>
                                                    <input type="text" id="inputNumeroCartaoDebito" class="form-control input-numero-cartao cvx-checkout_card_number" name="num_cartao_credito" placeholder="Número do cartão" onkeypress="onlyNumbers(event)" maxlength="16">
                                                    <input type="hidden" id="inputBandeiraCartaoDebito" class="inputBandeiraCartaoDebito" name="bandeira_cartao_debito">
                                                </div>
                                                <div class="col col-12 col-sm-6">
                                                    <label for="inputNomeCartaoDebito">Nome impresso no cartão</label>
                                                    <input type="text" class="form-control" id="inputNomeCartaoDebito" placeholder="Nome impresso no cartão">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-6 col-sm-6 col-md-3">
                                                    <label for="selectValidadeMesDebito">Validade</label>
                                                    <div class="button dropdown">
                                                        <select id="selectValidadeMesDebito" class="form-control select-validade-mes" name="mes_cartao_debito">
                                                            <option>Mês</option>
                                                            @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col col-6 col-sm-6 col-md-3">
                                                    <label class="label-validade-ano" for="selectValidadeAnoDebito">&nbsp;</label>
                                                    <div class="button dropdown">
                                                        <select id="selectValidadeAnoDebito" class="form-control" name="ano_cartao_debito">
                                                            <option>Ano</option>
                                                        	@for($i = date('Y'); $i <= (date('Y')+10); $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                    <label for="inputCodigoDebito" class="label-codigo-seguranca">Código de segurança</label>
                                                    <div class="area-codigo-seguranca">
                                                        <input type="text" id="inputCodigoDebito" class="form-control" name="cod_seg_cartao_debito" placeholder="000" maxlength="3">
                                                        <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Cógido de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col col-sm-6">
                                                    <label for="inputCPFDebito">CPF do titular do cartão</label>
                                                    <input type="text" id="inputCPFDebito" class="form-control input-cpf-titular mascaraCPF" name="cpf-titular-cartao-debito" value="{{ $cpf_titular }}" placeholder="CPF do titular do cartão">
                                                </div>
                                            </div>
                                            <!-- 
                                            <div class="form-check fc-checkbox">
                                                <input type="checkbox" class="form-check-input" id="checkGravarCartaoDebito">
                                                <label class="form-check-label" for="checkGravarCartaoDebito">Gravar dados para futuras compras</label>
                                            </div>
                                             -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card card-formulario">
                            <div class="card-header">
                                Resumo da compra
                            </div>
                            <div class="card-body">
                                <div id="accordion">
                                	@foreach($carrinho as $index => $item)
                                    <div class="card card-resumo-compra">
                                        <div class="card-header" id="heading_{{ $item['item_id'] }}">
                                            <div class="row">
                                                <div class="nome-produto col-12 col-sm-9" data-toggle="collapse" data-target="#collapse_{{ $item['item_id'] }}" aria-expanded="false" aria-controls="collapse_{{ $item['item_id'] }}">
                                                    <span>{{ $item['atendimento']->ds_preco }}</span>
                                                </div>
                                                <!--<div class="excluir-produto col-2 col-sm-1">
                                                    <a class="close-div" href="#"><i class="fa fa-trash"></i></a>
                                                </div>-->
                                                <div class="valor-produto col-12 col-sm-3">
                                                    <span>R$ {{ $item['atendimento']->getVlComercialAtendimento() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse_{{ $item['item_id'] }}" class="collapse" aria-labelledby="heading_{{ $item['item_id'] }}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Pessoa que utilizará o serviço:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ isset($item['paciente']) ? $item['paciente']->nm_primario.' '.$item['paciente']->nm_secundario : '--------' }}</p>
                                                        <input type="hidden" id="paciente_id_{{ $index }}" name="paciente_id_[{{ $index }}]" value="{{ isset($item['paciente']) ? $item['paciente']->id : 0 }}">
                                                    </div>
                                                </div>
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Médico:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>Dr. {{ $item['profissional']->nm_primario.' '.$item['profissional']->nm_secundario }}</p>
                                                        <input type="hidden" id="profissional_id_{{ $index }}" name="profissional_id_[{{ $index }}]" value="{{ isset($item['profissional']) ? $item['profissional']->id : 0 }}">
                                                    </div>
                                                </div>
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Especialidade:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{  $item['atendimento']->nome_especialidade }}</p>
                                                    </div>
                                                </div>
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Prestador:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ $item['clinica']->nm_fantasia }}</p>
                                                        <input type="hidden" id="clinica_id_{{ $index }}" name="clinica_id_[{{ $index }}]" value="{{ isset($item['clinica']) ? $item['clinica']->id : 0 }}">
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
                                                        <input type="hidden" id="atendimento_id_{{ $index }}" name="atendimento_id_[{{ $index }}]" value="{{ isset($item['atendimento']) ? $item['atendimento']->id : 0 }}">
                                                        <input type="hidden" id="dt_atendimento_{{ $index }}" name="dt_atendimento_[{{ $index }}]" value="{{ date('Y-m-d', strtotime($item['data_agendamento'])) }}">
                                                        <input type="hidden" id="hr_atendimento_{{ $index }}" name="hr_atendimento_[{{ $index }}]" value="{{ $item['hora_agendamento'] }}">
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
                                    
                                    <div class="resumo-compra">
                                        <div class="row">
                                            <div class="col-sm-8 linha-forma-pagamento linha-resumo">
                                                <div class="titulo-resumo">
                                                    <span>Forma de pagamento:</span>
                                                </div>
                                                <div class="dados-resumo">
                                                    <p><span id="resumo_compra_tipo_cartao"></span> - Final XXXX</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="titulo-resumo">
                                                    <span>Valor do(s) serviço(s):</span>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="dados-resumo">
                                                    <p>R$ {{ number_format( $valor_total,  2, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="titulo-resumo">
                                                    <span>Desconto aplicado:</span>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="dados-resumo">
                                                    <p>- R$ {{ number_format( $valor_desconto,  2, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="titulo-resumo">
                                                    <span>Anuidade:</span>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="dados-resumo">
                                                    <p>Isento</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="parcelamento-content" class="row">
                                            <div class="col-md-5">
                                                <div class="titulo-resumo">
                                                    <span>Parcelamento:</span>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="dados-resumo">
                                                    <p>10x com juros (1,29% a.m.) de R$ 48,50</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="titulo-resumo">
                                                    <span>Total a pagar: </span>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="dados-resumo valor-total-produtos">
                                                    <p>R$ {{ number_format( $valor_total-$valor_desconto,  2, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 area-btn-finalizar">
                                                <a href="{{ $url }}" class="btn btn-link btn-continuar-comprando">Continuar comprando</a>
                                            </div>
                                            <div class="col-12 col-md-6 area-btn-finalizar">
                                            	@if(sizeof($carrinho) > 0)
                                                <button type="button" id="btn-finalizar-pedido" class="btn btn-vermelho btn-finalizar"><span id="lbl-finalizar-pedido">Finalizar Pagamento <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i></span></button>
                                                @endif
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
                        if($(this).val() == 'debito') {
                            $('#parcelamento-content').hide();
                            $('#resumo_compra_tipo_cartao').html('Cartão de débito')
                        } else if($(this).val() == 'credito') {
                        	$('#parcelamento-content').show();
                        	$('#resumo_compra_tipo_cartao').html('Cartão de crédito')
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