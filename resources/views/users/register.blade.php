@extends('layouts.base')

@section('title', 'Resultado - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="resultado">
    <div class="container">
        <div class="area-container">
            <div class="titulo text-center">
                <strong>Sua Conta foi Criada com Sucesso!</strong>
                <p>Para ativa-la acesse seu E-mail e clique no link de Ativação</p>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script type="text/javascript">        
            var laravel_token = '{{ csrf_token() }}';
            var resizefunc = [];
	</script>
@endpush

@endsection
