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