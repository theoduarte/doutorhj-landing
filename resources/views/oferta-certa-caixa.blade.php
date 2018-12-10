@extends('layouts.base')

@section('title', 'DoutorHoje: Oferta Certa Caixa - Página em Construção')

@push('scripts')
@endpush

@section('content')

    <!-- HOME -->
    <section>
    	<div class="container-alt">
    		<div class="row" style="margin: 0px;">
    			<div class="col-sm-12 text-center">
    				<div class="home-wrapper" style="margin: 60px 0px;">
    					<h1 class="icon-main text-primary m-b-25"><img alt="site-em-construção" src="{{ Request::root() }}/img/site-under-construction.png"></h1>
    					<h3 class="home-text text-uppercase">Esta página está em Construção</h3>
    					<h4 class="mt-3">Por favor, visite ela mais tarde.</h4>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
    <!-- END HOME -->
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                
            });

            $('.carousel').carousel({
                interval: 7000
            });

            /*********************************
             *
             * CARROSSEL PARCEIROS
             *
             *********************************/

            $(document).ready(function () {
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    responsive: {
                        0: {
                            items: 3
                        },
                        600: {
                            items: 4
                        },
                        1000: {
                            items: 8
                        }
                    }
                })
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