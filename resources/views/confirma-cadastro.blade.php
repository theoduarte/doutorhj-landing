@extends('layouts.logado')

@section('title', 'Confirma Agendamento - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="confirma-cadastro">
    <div class="container">
        <div class="area-container">
            <div class="titulo">
                <strong>Estamos quase lá!</strong>            
            </div>
            <div class="row">
                <div class="col-md-12 texto-confirmacao">
                    <p>Seja bem-vindo(a) e obrigado(a) por escolher o Doctor Hoje.</p>
                    <p>Acesse seu email e clique no link para ativar seu cadastro.</span></p>
                    <p>Lembre-se de verificar também sua caixa de spam e lixeira.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p><strong>Não recebeu o email de confirmação?</strong></p>
                    <p>Clique no botão abaixo e reenviaremos novamente um e-mail de confirmação para paulo@kenobi.com.br.</p>
                    <button type="button" class="btn btn-vermelho">Reenviar e-mail</button>
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