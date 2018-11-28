@extends('layouts.base')

@section('title', 'DoutorHJ: Login')

@push('scripts')

@endpush

@section('content')
    <section class="login">
        <div class="container">
            <div class="area-container area-avaliacao">
                <div class="titulo">
                    <strong>Avaliação</strong>
                    {{--<p>Se você já tem cadastro conosco, faça o login para avançar, ou realize o seu cadastro.</p>--}}
                </div>
                <div class="nota-atendimento">
                    <p>Seu processo de compra da consulta/exame<br>no site Doutor Hoje vale quantas estrelas?</p>
                    <span class="rating">
                        <input type="radio" class="rating-input" id="compra-nota-5" name="rating-input-compra">
                        <label for="compra-nota-5" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="compra-nota-4" name="rating-input-compra">
                        <label for="compra-nota-4" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="compra-nota-3" name="rating-input-compra">
                        <label for="compra-nota-3" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="compra-nota-2" name="rating-input-compra">
                        <label for="compra-nota-2" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="compra-nota-1" name="rating-input-compra">
                        <label for="compra-nota-1" class="rating-star"></label>
                    </span>
                </div>

                <div class="nota-atendimento">
                    <p>O atendimento que recebeu na clínica/laboratório<br>vale quantas estrelas?</p>
                    <span class="rating">
                        <input type="radio" class="rating-input" id="atendimento-nota-5" name="rating-input-atendimento">
                        <label for="atendimento-nota-5" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="atendimento-nota-4" name="rating-input-atendimento">
                        <label for="atendimento-nota-4" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="atendimento-nota-3" name="rating-input-atendimento">
                        <label for="atendimento-nota-3" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="atendimento-nota-2" name="rating-input-atendimento">
                        <label for="atendimento-nota-2" class="rating-star"></label>
                        <input type="radio" class="rating-input" id="atendimento-nota-1" name="rating-input-atendimento">
                        <label for="atendimento-nota-1" class="rating-star"></label>
                    </span>
                </div>

            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">

        </script>
    @endpush

@endsection
