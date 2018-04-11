@extends('layouts.logado')

@section('title', 'Confirma Agendamento - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="confirmacao">
    <div class="container">
        <div class="area-container">
            <div class="titulo">
                <strong>Confirmação de agendamento</strong>            
            </div>
            <div class="row">
                <div class="col-md-12 texto-confirmacao">
                    <p>Temos uma boa notícia! Sua <strong>solicitação de agendamento</strong> foi efetuada com sucesso. Atenção ao horário e data do serviço escolhido.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-6">
                    <div class="dados-confirmacao">
                        <ul>
                            <li><i class="fas fa-shopping-cart"></i> Nº do pedido: <span>000000</span></li>
                            <li><i class="fas fa-medkit"></i> Especialidade/ exame Dr(a): <span>---</span></li>
                            <li><i class="far fa-calendar-alt"></i> <span>21 de março / quarta-feira</span></li>
                            <li><i class="far fa-clock"></i> <span>9h00 (por ordem de chegada)</span></li>
                            <li><i class="fas fa-map-marker-alt"></i> <span>Rua Antenor Lemos, 57 709 Menino Jesus Porto Alegre/ RS</span></li>
                            <li><i class="far fa-check-circle"></i> Status: <span>Agendado</span></li>
                        </ul>
                    </div>
                    <div class="token-atendimento">
                        <p>Apresente esse código à secretária do médico ou clínica:</p>
                        <div class="codigo-token">
                            TOKEN PARA ATENDIMENTO: <span>XYZ1989</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="condicoes">
                        <p>Evite transtornos! Caso ocorra algum imprevisto, impossibilitando o comparecimento ao serviço contratado ou reagendamento, nos informe com até 24 horas de antecedência, evitando prejuízo e aplicação de multa.</p>
                        <table class="table table-bordered tabela-condicoes">
                            <thead>
                                <tr>
                                    <th scope="col">Solicitação</th>
                                    <th scope="col">Até 24h</th>
                                    <th scope="col">Mais de 24h</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cancelamento</td>                                
                                    <td>Reembolso de 50% do valor pago em até 5 dias úteis.</td>
                                    <td>Sem direito a reembolso.</td>
                                </tr>
                                <tr>
                                    <td>Reagendamento</td>
                                    <td>Direito a 1 (um) reagendamento em no máximo 30 dias.</td>
                                    <td>Perda do direito de reagendamento.</td>
                                </tr>                            
                            </tbody>
                        </table>
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

        });
	</script>	
    
@endpush

@endsection