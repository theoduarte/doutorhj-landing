@extends('layouts.prestador')

@section('title', 'Confirma Beneficiário - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="home-prestador">
    <div class="area-banner">
        <div class="container">            
            <h2>Quer encher a agenda com novos pacientes?</h2>
            <p>Concheça o Doutor Hoje. Uma nova plataforma que vai aumentar a sua carteira de clientes.</p>               
        </div>        
    </div>
    <div class="areas area-passos-cadastro">
        <div class="container">
            <div class="titulo">
                <h3>Como se cadastrar</h3>
                <div class="linha"></div>
            </div>
            <div class="passos-cadastro">
                <div class="row">
                    <div class="col-md-4">
                        <div class="icone">
                            <img src="../../libs/home-template/img/icone-pre-cadastro.png" alt="">
                        </div>
                        <div class="titulo">
                            Solicite o pré-cadastro
                        </div>
                        <div class="texto">
                            Preencha os dados do formulário 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icone">
                            <img src="../../libs/home-template/img/icone-aguarde.png" alt="">
                        </div>
                        <div class="titulo">
                            Aguarde
                        </div>
                        <div class="texto">
                            Analisamos os seus dados e entramos em contato
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icone">
                            <img src="../../libs/home-template/img/icone-confirmacao.png" alt="">
                        </div>
                        <div class="titulo">
                            Confirmação
                        </div>
                        <div class="texto">
                        Seja bem-vindo! Com o contrato em mãos, o Doutor Hoje passa a indicar centenas de pacientes para você.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="areas area-sobre">
        <div class="container">
            <div class="titulo">
                <h3>Sobre o Doctor Hoje</h3>
                <div class="linha"></div>
            </div>
            <p>Uma plataforma digital onde os profissionais de saúde dispõem algumas horas da sua agenda   para centenas de pacientes que buscam qualidade de atendimento particular a custos que cabem no orçamento. Aumento o faturamento de sua clínica, venha para o Doutor Hoje.  </p>
        </div>
    </div>
    <div class="areas area-como-funciona">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6"></div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="titulo">
                        <h3>Como funciona?</h3>
                        <div class="linha"></div>
                        <p>Uma plataforma digital onde os profissionais de saúde dispõem algumas horas da sua agenda   para centenas de pacientes que buscam qualidade de atendimento particular a custos que cabem no orçamento. Aumento o faturamento de sua clínica, venha para o Doutor Hoje.</p>
                    </div>
                    <ul>
                        <li>
                            <img src="../../libs/home-template/img/icone-prestador-passo1.png" alt="">
                            <p>O paciente acessa doutorhoje.com.br e faz a busca do prestador de seu interesse</p>
                        </li>
                        <li>
                            <img src="../../libs/home-template/img/icone-prestador-passo2.png" alt="">
                            <p>Acessa o sistema de agendamento, escolhendo data e horário de preferência</p>
                        </li>
                        <li>
                            <img src="../../libs/home-template/img/icone-prestador-passo3.png" alt="">
                            <p>Realiza o pagamento</p></li>
                        <li>
                            <img src="../../libs/home-template/img/icone-prestador-passo4.png" alt="">
                            <p>O prestador receberá o contato do Doutor Hoje para confirmação do agendamento</p>
                        </li>
                        <li>
                            <img src="../../libs/home-template/img/icone-prestador-passo5.png" alt="">
                            <p>Os honorários serão pagos em até 20 dias</p>
                        </li>
                    </ul>
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