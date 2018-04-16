@extends('layouts.base')

@section('title', 'Resultado - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="resultado">
    <div class="container">
        <div class="area-container">
            <div class="titulo text-center">
                <strong>Sua Conta foi ativada com Sucesso!</strong>
                <p><a href="/login" class="btn btn-primary">Clique aqui e faça seu Login</a></p>
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
