@extends('layouts.base')

@section('title', 'DoctorHoje')

@push('scripts')

@endpush

@section('content')
    <script>
        // ADICIONAR CLASSE PARA REMOVER IMAGEM DO RODAPE
        $(document).ready(function () {
            $('.medico-parte-2').addClass('remove-imagem-medico');

        });
    </script>
    <section class="contato-prestador">
        <div class="container area-contato">
            <div class="row">
                <div class="col-sm-12 col-md-6 area-form">
                    <div class="form">
                        <div class="main-heading center-holder">
                            <h2>Envie-nos suas Dúvidas ou Sugestões</h2>
                        </div>
                        <form method="post" action="/enviar-contato" class="primary-form">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="nome" class="form-control" name="nome"
                                           placeholder="Digite seu nome" maxlength="150" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="email" id="email" class="form-control" name="email"
                                           placeholder="Digite seu E-mail" maxlength="150" required="required">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="telefone" class="form-control mascaraTelefone"
                                           name="telefone" placeholder="Digite seu Celular" maxlength="20"
                                           required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="mensagem" class="form-control" name="message"
                                              placeholder="Digite sua mensagem..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-vermelho btn-finalizar">Enviar mensagem
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="contact-box">
                        <h4><i class="fa fa-map-marker"></i> Visite-nos</h4>
                        <p>SCS, Quadra 3, Bloco A, nº 107, Sala 103, Ed. Antônia Alves Pereira de Sousa, Asa Sul,
                            Brasília – DF, CEP: 70.303-907</p>
                    </div>
                    <div class="contact-box">
                        <h4><i class="fa fa-phone"></i> Ligue para nós</h4>
                        <p>Central de atendimento: (61) 3221-5350</p>
                    </div>
                    <div class="contact-box">
                        <h4><i class="fa fa-envelope-o"></i> Envie-nos um E-mail</h4>
                        <p>prestador@doctorhoje.com.br<br><br></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {

                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];
                //$.Notification.notify('success', 'top right', 'Solicitação Concluída!', 'teste');

            });

            /*********************************
             *
             * Smooth Scroll
             *
             *********************************/

            $('a[href*="#"]')
                .not('[href="#"]')
                .not('[href="#0"]')
                .click(function (event) {
                    if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                        &&
                        location.hostname == this.hostname
                    ) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: target.offset().top
                            }, 1000, function () {
                                var $target = $(target);
                                $target.focus();
                                if ($target.is(":focus")) {
                                    return false;
                                } else {
                                    $target.attr('tabindex', '-1');
                                    $target.focus();
                                }
                                ;
                            });
                        }
                    }
                });
        </script>

    @endpush

@endsection