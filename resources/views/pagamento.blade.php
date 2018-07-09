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
                                Cupom de Desconto
                            </div>
                            <div class="card-body">
                                <span class="card-span">Digite aqui o número do seu cupom</span>
                                <form>
                                    <div class="form-group row">
                                        <div class="col col-lg-7 col-xl-8">
                                            <input type="text" class="form-control" id="inputCupom" name="inputCupom" placeholder="Cupom de desconto">
                                            <i class="cvx-check-cupom-desconto cvx-no-loading fa fa-check-circle text-success"></i>
                                        </div>
                                        <div class="col col-lg-5 col-xl-4">
                                            <button type="button" id="btn-validar-cupom" class="btn btn-vermelho">Validar</button>
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
                                                    <!-- <option value="debito">Débito</option> -->
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
                                                        <select class="form-control" id="selectCartaoCredito" name="selectCartaoCredito">
                                                            <option value="">Novo Cartão</option>
                                                            @foreach($cartoes_gravados as $item)
                                                            <option value="{{ $item->id }}">Cartão {{ $item->bandeira }} - final {{ $item->numero }}</option>
                                    						@endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row row-payment-card">
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
                                            <div class="form-group row row-payment-card">
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
                                            <div class="form-group row row-payment-card">
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
                                            <div class="form-check fc-checkbox row-payment-card">
                                                <input type="checkbox" id="checkGravarCartaoCredito" class="form-check-input" name="gravar_cartao_credito">
                                                <label class="form-check-label" for="checkGravarCartaoCredito">Gravar dados para futuras compras</label>
                                            </div>
                                            
                                            <div class="form-group row row-card-token">
                                                <div class="col col-12 col-sm-12">
                                                	<br>
                                                    <h6 style="color: rgb(70, 117, 184); text-transform: uppercase; font-weight: 700;">PAGAMENTO DINÂMICO</h6>
                                                    <label>Informe apenas o código de segurança do seu cartão</label>
                                                    <input type="hidden" id="inputSaveCardId"  name="save_card_id">
                                                </div>
                                            </div>
                                            <div class="form-group row row-card-token">
                                            	<div class="col col-12 col-sm-8">
                                                    <label for="inputNomeSaveCard">Nome Impresso</label>
                                                    <input type="text" id="inputNomeSaveCard"  class="form-control" name="nome_impresso_save_card" placeholder="Nome impresso" readonly="readonly">
                                                </div>
                                                <div class="col col-12 col-sm-4">
                                                    <label for="inputNumFinalSaveCard">Final do Cartão</label>
                                                    <input type="text" id="inputNumFinalSaveCard"  class="form-control" name="num_final_save_card" placeholder="Final do cartão" readonly="readonly">
                                                </div>   
                                            </div>
                                            <div class="form-group row row-card-token">
                                                <div class="col col-12 col-sm-4">
                                                    <label for="inputExpirationDateSaveCard">Validade</label>
                                                    <input type="text" id="inputExpirationDateSaveCard"  class="form-control" name="expiration_date_save_card" placeholder="Validade" readonly="readonly">
                                                </div>
                                                <div class="col col-12 col-sm-4">
                                                	<label for="inputBrandSaveCard">Bandeira</label>
                                                    <input type="text" id="inputBrandSaveCard"  class="form-control" name="brand_save_card" placeholder="Bandeira" readonly="readonly">
                                                </div>
                                                <div class="col col-12 col-sm-4">
                                                	<label for="inputCodigoSegSaveCard" class="label-codigo-seguranca">Código seg.</label>
                                                    <div class="area-codigo-seguranca">
                                                        <input type="text" id="inputCodigoSegSaveCard" class="form-control" name="cod_seg_save_card" placeholder="000" maxlength="3">
                                                    </div>
                                                </div>   
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
                                                    <span>{{ $item['atendimento']->ds_atendimento }}</span>
                                                </div>
                                                <!--<div class="excluir-produto col-2 col-sm-1">
                                                    <a class="close-div" href="#"><i class="fa fa-trash"></i></a>
                                                </div>-->
                                                <div class="valor-produto col-12 col-sm-3">
                                                    <span>R$ {{ $item['atendimento']->getVlComercialAtendimento() }}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="valor-produto col-12 col-sm-12">
                                                    <select id="selectPacienteAgendamento_{{ $item['item_id'] }}" class="form-control select-paciente-agendamento" name="selectCartaoCredito">
                                                    	<option>Selecione o Paciente deste Atendimento</option>
                                                    	@foreach($pacientes as $paciente)
                                                    	<option value="{{ $paciente->id }}" @if($item['paciente']->id == $paciente->id) selected="selected" @endif>@if($paciente->responsavel_id == null) (T) @else <span>(D)</span> @endif {{ $paciente->nm_primario.' '.$paciente->nm_secundario }}</option>
                                                    	@endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse_{{ $item['item_id'] }}" class="collapse" aria-labelledby="heading_{{ $item['item_id'] }}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Pessoa que utilizará o serviço:</span>
                                                    </div>
                                                    <div class="dados-resumo dados-resumo-paciente">
                                                        <p class=" @if($item['paciente']->id != null) text-primary @else text-danger @endif">
                                                        @if($item['paciente']->id != null) {{ $item['paciente']->nm_primario.' '.$item['paciente']->nm_secundario }} @else -- PACIENTE AINDA NÃO INDICADO-- @endif
                                                        </p>
                                                        <input type="hidden" id="paciente_id_{{ $index }}" class="paciente_agendamento_id" name="paciente_id_[{{ $index }}]" value="@if($item['paciente']->id != null) {{ $item['paciente']->id }} @else 0 @endif">
                                                    </div>
                                                </div>
                                                @if($item['profissional'] != null && $item['profissional'] != 'null' & $item['atendimento']->consulta_id != null)
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
                                                @else
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Descrição do Atendimento:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ $item['atendimento']->ds_atendimento }} <br><em>({{  $item['atendimento']->nome_especialidade }})</em></p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Prestador:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ $item['clinica']->nm_fantasia }}  - Und: ( {{ $item['filial']->nm_nome_fantasia }} )</p>
                                                        <input type="hidden" id="clinica_id_{{ $index }}" name="clinica_id_[{{ $index }}]" value="{{ isset($item['clinica']) ? $item['clinica']->id : 0 }}">
                                                        <input type="hidden" id="filial_id_{{ $index }}" name="filial_id_[{{ $index }}]" value="{{ isset($item['filial']) ? $item['filial']->id : 0 }}">
                                                    </div>
                                                </div>
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Endereço:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ $item['filial']->endereco->te_endereco.', '.$item['filial']->endereco->nr_logradouro.', '.$item['filial']->endereco->te_bairro }}</p>
                                                        <input type="hidden" id="atendimento_id_{{ $index }}" name="atendimento_id_[{{ $index }}]" value="{{ isset($item['atendimento']) ? $item['atendimento']->id : 0 }}">
                                                    </div>
                                                </div>
                                                @if($item['data_agendamento'] != null && $item['data_agendamento'] != 'null')
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Data pré-agendada:</span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ date('d/m/Y', strtotime($item['data_agendamento'])) }} - {{ strftime('%A', strtotime($item['data_agendamento'])) }}</p>
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
                                                 @else
                                                <div class="linha-resumo">
                                                    <div class="titulo-resumo">
                                                        <span>Observação do Atendimento: </span>
                                                    </div>
                                                    <div class="dados-resumo">
                                                        <p>{{ $item['clinica']->obs_procedimento }}</p>
                                                    </div>
                                                </div>
                                                @endif
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
                                                    <p><span id="resumo_compra_tipo_cartao"></span> - Final <span id="resumo_compra_final_cartao">XXXX</span></p>
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
                                                    <input type="hidden" id="valor_servicos" value="{{ $valor_total }}">
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
                                                    <input type="hidden" id="valor_desconto" value="{{ $valor_desconto }}">
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
                                                <div id="resumo_parcelamento" class="dados-resumo">
                                                    <!-- <p>10x com juros (5% a.m.) de R$ 48,50</p> -->
                                                    <p>{{ $parcelamentos[sizeof($parcelamentos)] }}</p>
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
                localStorage.setItem('activeCupom', 'f');
                
                /*********************************
                 *
                 * ALTERA FORMULARIO PAGAMENTO
                 *
                 *********************************/

                $(function () {
                    $('#selectFormaPagamento').change(function () {
                    	$('.row-payment-card').css('display', 'flex');
                    	$('.row-card-token').css('display', 'none');
                    	$('#selectCartaoCredito').prop('selectedIndex',0);
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

                $('.select-paciente-agendamento').change(function(){

                	var element_id = $(this).attr('id');
                    if($(this).val() == 0){ return false; }

                    var paciente_id = $('#'+element_id+" :selected").val();
                    var nome_paciente = $('#'+element_id+" :selected").text();
                    nome_paciente = nome_paciente.replace("(T)", "");
                    nome_paciente = nome_paciente.replace("(D)", "");
                    
                    $(this).parent().parent().parent().parent().find('div.collapse').find('div.dados-resumo-paciente').find('input.paciente_agendamento_id').val(paciente_id);
                    $(this).parent().parent().parent().parent().find('div.collapse').find('div.dados-resumo-paciente').find('p').html(nome_paciente).removeClass('text-danger').addClass('text-primary');
                });

                $('#inputNumeroCartaoCredito').keydown(function(){
                    if($(this).val().length >= 15) {
                    	//alert($(this).val());
                        var num_cartao = $('#inputNumeroCartaoCredito').val();
                        $('#resumo_compra_final_cartao').html(num_cartao.substr(-4));
                    } else {
                    	$('#resumo_compra_final_cartao').html('XXXX');
                    }
                });

                $('#inputNumeroCartaoCredito').blur(function(){
                	var num_cartao = $(this).val();
                	$('#resumo_compra_final_cartao').html(num_cartao.substr(-4));
                });

                $('#btn-validar-cupom').click(function(){

                	var codigo = $('#inputCupom').val();
                	var activeCupom = localStorage.getItem('activeCupom');
                	var valor_total = $('#valor_servicos').val();
                	
                    if(codigo.length == 0 | activeCupom == 't') { return false; }

                    $.ajax({
                		type:'post',
                		   dataType:'json',
                		   url: '/validar-cupom-desconto',
                		   data: {
                			   'codigo': codigo,
                			   'valor_parcelamento': valor_total,
                			   '_token': laravel_token
                		   },
                		   timeout: 15000,
                		   success: function (result) {
                			   
                    		   if(result.status) {
                        		   
                        		   var desconto = valor_total*result.percentual;
                        		   var valor_com_desconto = valor_total-desconto;
                        		   var parcelamentos = result.parcelamentos;
                        		   
                        		   //localStorage.setItem('activeCupom', 'f');
                        		   $('.cvx-check-cupom-desconto').removeClass('cvx-no-loading');
                        		   $('#valor_desconto').parent().find('p').html('- R$ '+numberToReal(desconto));
                        		   $('.valor-total-produtos').find('p').html('R$ '+numberToReal(valor_com_desconto));

                        		   $('#selectParcelamentoCredito').empty();
               						for(var i=0; i < parcelamentos.length; i++) {
               							var option = '<option value="'+(i+1)+'">'+parcelamentos[i]+'</option>';
               							$('#selectParcelamentoCredito').append($(option));
               						}

               						$('#resumo_parcelamento p').html(result.resumo_parcelamento);
                        		   
                        		} else {
                            	
                    			   swal(
                						{
                		                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                		                    text: result.mensagem
                		                }
                		            );
                    			   
                    			}
                		  },
                		  error: function (result) {
                          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
                          }
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