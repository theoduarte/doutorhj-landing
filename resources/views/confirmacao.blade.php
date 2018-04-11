@extends('layouts.logado')

@section('title', 'Confirma Agendamento - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="confirma-beneficiario">
<div class="container">
    <div class="area-container">
        <div class="titulo">
            <strong>Confirmação de agendamento</strong>
            <p>Temos uma boa notícia! Sua solicitação de agendamento foi efetuada com sucesso. Atenção ao horário e data do serviço escolhido.</p>
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