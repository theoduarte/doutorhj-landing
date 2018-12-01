@extends('layouts.base')
@section('title', 'Pagamento - DoutorHJ')
@push('scripts')
@endpush
@section('content')
    <div class="container">
        <div class="status-pagamento-boleto spb-erro">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <h3>Ocorreu um erro no processamento do pagamento!</h3>
            <p>Por favor, entre em contato com a Doutor Hoje para verificarmos o que ocorreu.</p>
        </div>
    </div>
@endsection