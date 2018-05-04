@extends('layouts.logado')

@section('title', 'Pagamento - DoctorHj')

@push('scripts')

@endpush

@section('content')
<section class="pagamento">
    <div class="container">
        <div class="area-container">
            <div class="titulo">
                <strong>Pagamento</strong>
                <p>Selecione ou adicione seu cartão, escolha o beneficiário da compra e, caso houver, digite seu cupom de desconto.</p>
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
                                        <input type="text" class="form-control" id="inputCupom" placeholder="Cupom de desconto">
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
                            <form>
                                <div class="form-group row area-label">
                                    <label for="selectFormaPagamento" class="col-sm-12">Escolha a Forma de pagamento</label>                       
                                </div>
                                <!-- Formulário cartão de Crédito -->
                                <div class="form-group row">
                                    <div class="col col-md-6">
                                        <div class="button dropdown">
                                            <select class="form-control" id="selectFormaPagamento">
                                                <option value="selecionaFormaPagamento">Selecione</option>
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
                                                <input type="text" class="form-control input-numero-cartao" id="inputNumeroCartaoCredito" placeholder="Número do cartão">
                                            </div>
                                            <div class="col col-12 col-sm-6">
                                                <label for="inputNomeCartaoCredito">Nome impresso no cartão</label>
                                                <input type="email" class="form-control" id="inputNomeCartaoCredito" placeholder="Nome impresso no cartão">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col col-6 col-sm-6 col-md-3">
                                                <label for="selectValidadeMesCredito">Validade</label>
                                                <div class="button dropdown">
                                                    <select class="form-control select-validade-mes" id="selectValidadeMesCredito">
                                                        <option>Mês</option>
                                                        <option>Janeiro</option>
                                                        <option>Fevereiro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col col-6 col-sm-6 col-md-3">
                                                <label class="label-validade-ano" for="selectValidadeAnoCredito">&nbsp;</label>
                                                <div class="button dropdown">
                                                    <select class="form-control" id="selectValidadeAnoCredito">
                                                        <option>Ano</option>
                                                        <option>2018</option>
                                                        <option>2019</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                <label for="inputCodigoCredito" class="label-codigo-seguranca">Código de segurança</label>
                                                <div class="area-codigo-seguranca">
                                                    <input type="text" class="form-control" id="inputCodigoCredito" placeholder="000">
                                                    <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Cógido de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col col-12 col-sm-6">
                                                <label for="inputCPFCredito">CPF do titular do cartão</label>
                                                <input type="text" class="form-control input-cpf-titular" id="inputCPFCredito" placeholder="CPF do titular do cartão">
                                            </div>
                                            <div class="col col-12 col-sm-6 codigo-seguranca">
                                                <label for="selectParcelamentoCredito">Parcelamento</label>
                                                <div class="button dropdown">
                                                    <select class="form-control" id="selectParcelamentoCredito">
                                                        <option>1x R$ 300,00</option>
                                                        <option>2x R$ 150,00</option>
                                                        <option>3x R$ 100,00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check fc-checkbox">
                                            <input type="checkbox" class="form-check-input" id="checkGravarCartaoCredito">
                                            <label class="form-check-label" for="checkGravarCartaoCredito">Gravar dados para futuras compras</label>
                                        </div>
                                    </div>
                                    <!-- Formulário cartão de Débito -->
                                    <div id="debito" class="formas-pagamento">
                                        <div class="form-group row area-label">
                                            <label for="selectCartaoDebito" class="col-sm-12">Selecione um cartão cadastrado</label>                       
                                        </div>
                                        <div class="form-group row">
                                            <div class="col col-md-6">
                                                <div class="button dropdown">
                                                    <select class="form-control" id="selectCartaoDebito">
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
                                                <label for="inputNumeroCartaoDebito">Número do cartão</label>
                                                <input type="text" class="form-control input-numero-cartao" id="inputNumeroCartaoDebito" placeholder="Número do cartão">
                                            </div>
                                            <div class="col col-12 col-sm-6">
                                                <label for="inputNomeCartaoDebito">Nome impresso no cartão</label>
                                                <input type="email" class="form-control" id="inputNomeCartaoDebito" placeholder="Nome impresso no cartão">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col col-6 col-sm-6 col-md-3">
                                                <label for="selectValidadeMesDebito">Validade</label>
                                                <div class="button dropdown">
                                                    <select class="form-control select-validade-mes" id="selectValidadeMesDebito">
                                                        <option>Mês</option>
                                                        <option>Janeiro</option>
                                                        <option>Fevereiro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col col-6 col-sm-6 col-md-3">
                                                <label class="label-validade-ano" for="selectValidadeAnoDebito">&nbsp;</label>
                                                <div class="button dropdown">
                                                    <select class="form-control" id="selectValidadeAnoDebito">
                                                        <option>Ano</option>
                                                        <option>2018</option>
                                                        <option>2019</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                <label for="inputCodigoDebito" class="label-codigo-seguranca">Código de segurança</label>
                                                <div class="area-codigo-seguranca">
                                                    <input type="text" class="form-control" id="inputCodigoDebito" placeholder="000">
                                                    <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Cógido de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col col-sm-6">
                                                <label for="inputCPFDebito">CPF do titular do cartão</label>
                                                <input type="text" class="form-control input-cpf-titular" id="inputCPFDebito" placeholder="CPF do titular do cartão">
                                            </div>
                                            <!--                                            
                                                <div class="col col-sm-6 codigo-seguranca">
                                                    <label for="selectParcelamentoDebito">Parcelamento</label>
                                                    <div class="button dropdown">
                                                        <select class="form-control" id="selectParcelamentoDebito">
                                                            <option>1x R$ 300,00</option>
                                                            <option>2x R$ 150,00</option>
                                                            <option>3x R$ 100,00</option>
                                                        </select>
                                                    </div>                                            
                                                </div>
                                                -->
                                        </div>
                                        <div class="form-check fc-checkbox">
                                            <input type="checkbox" class="form-check-input" id="checkGravarCartaoDebito">
                                            <label class="form-check-label" for="checkGravarCartaoDebito">Gravar dados para futuras compras</label>
                                        </div>
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
                                <div class="card card-resumo-compra">
                                    <div class="card-header" id="headingOne">
                                        <div class="row">
                                            <div class="nome-produto col-10 col-sm-8" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <span>Eletrocardiograma</span>
                                            </div>
                                            <div class="excluir-produto col-2 col-sm-1">
                                                <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                            </div>                                            
                                            <div class="valor-produto col-12 col-sm-3">
                                                <span>R$ 180,00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
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
                                                    <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED. ADV, S/N </p>
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
                                    <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="row">
                                            <div class="nome-produto col-10 col-sm-8">
                                                <span>Hemograma</span>
                                            </div>
                                            <div class="excluir-produto col-2 col-sm-1">
                                                <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                            </div>                                         
                                            <div class="valor-produto col-12 col-sm-3">
                                                <span>R$ 90,00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
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
                                                    <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED. ADV, S/N </p>
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
                                    <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <div class="row">
                                            <div class="nome-produto col-10 col-sm-8">
                                                <span>Ecografia</span>
                                            </div>
                                            <div class="excluir-produto col-2 col-sm-1">
                                                <a class="close-div" href="#"><i class="far fa-trash-alt"></i></a>
                                            </div>                                         
                                            <div class="valor-produto col-12 col-sm-3">
                                                <span>R$ 220,00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
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
                                                    <p>SGAS QUADRA 915 CONJUNTO SL 023 A 037 - SEGUNDO SUBSOLO ED. ADV, S/N </p>
                                                </div>
                                            </div>
                                            <div class="linha-resumo">
                                                <div class="titulo-resumo">
                                                    <span>Data agendada:</span>    
                                                </div>
                                                <div class="dados-resumo">
                                                    <p>26/03/2018 - Segunda-feira</p>
                                                </div>
                                            </div>
                                            <div class="linha-resumo">
                                                <div class="titulo-resumo">
                                                    <span>Horário agendado:</span>    
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
                                        <div class="col-sm-8 linha-forma-pagamento linha-resumo">
                                            <div class="titulo-resumo">
                                                <span>Forma de pagamento:</span>    
                                            </div>
                                            <div class="dados-resumo">
                                                <p>Cartão de débito - Final XXXX</p>
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
                                                <p>R$ 490,00</p>
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
                                                <p>- R$ 10,00</p>
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
                                    <div class="row">
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
                                                <p>R$ 120,00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 area-btn-finalizar">
                                            <button type="button" class="btn btn-link btn-continuar-comprando">Continuar comprando</button>
                                        </div>
                                        <div class="col-12 col-md-6 area-btn-finalizar">                                           
                                            <button type="submit" class="btn btn-vermelho btn-finalizar">Finalizar Pedido</button>
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
        $(document).ready(function(){

            var laravel_token = '{{ csrf_token() }}';
            var resizefunc = []; 

            /*********************************
            *
            * ALTERA FORMULARIO PAGAMENTO
            * 
            *********************************/

            $(function() {
                $('#selectFormaPagamento').change(function(){
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

            $(".close-div").on("click", function(event) {
              event.preventDefault();
                if(confirm("Tem certeza que deseja excluir esse produto?")) {
                    $(this).parent().parent().parent().parent().remove();
                }
             });

        });
	</script>	
    
@endpush

@endsection