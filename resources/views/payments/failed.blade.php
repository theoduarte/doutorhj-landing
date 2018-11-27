@extends('layouts.base')
@section('title', 'Pagamento - DoutorHJ')
@push('scripts')
@endpush
@section('content')
    <div class="container">
        <div class="status-pagamento-boleto spb-erro">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <h3>Ocorreu um erro no pagamento!</h3>
            <p>Por favor, tente novamente.</p>
        </div>
    </div>
@endsection