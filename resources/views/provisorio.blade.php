@extends('layouts.provisorio')

@section('title', 'Vem aí o DoctorHoje...')

@push('scripts')
@endpush

@section('content')
    <!-- Page Content -->
    <section class="contador">
    	<h1>Vem aí a maior plataforma online de agendamento de consultas  e exames, faltam:</h1>
    	<div class="countdown"></div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];                
            });

            /*********************************
            *
            * COPIA TOKEN
            *
            *********************************/

            jQuery(function ($) {

                $('#copyButton').click(function () {
                    var pElement = $('#token')[0];
                    copyToClipboard(pElement, showSuccessMsg);
                });

                function showSuccessMsg() {
                    $('#successMsg').finish().fadeIn(300).fadeOut(1000);
                }

                function copyToClipboard(element, successCallback) {
                    selectText(element);

                    var succeed;
                    try {
                        succeed = document.execCommand('copy');
                    } catch (e) {
                        succeed = false;
                    }

                    if (succeed && typeof(successCallback) === 'function') {
                        successCallback();
                    }
                }

                function selectText(element) {
                    if (/INPUT|TEXTAREA/i.test(element.tagName)) {
                        element.focus();
                        if (element.setSelectionRange) {
                            element.setSelectionRange(0, element.value.length);
                        } else {
                            element.select();
                        }
                        return;
                    }

                    var rangeObj, selection;
                    if (document.createRange) { // IE 9+ and all other browsers
                        rangeObj = document.createRange();
                        rangeObj.selectNodeContents(element);
                        selection = window.getSelection();
                        selection.removeAllRanges();
                        selection.addRange(rangeObj);
                    } else if (document.body.createTextRange) { // IE <=8
                        rangeObj = document.body.createTextRange();
                        rangeObj.moveToElementText(element);
                        rangeObj.select();
                    }
                }

            });

            /*********************************
             *
             * Smooth Scroll
             *
             *********************************/

            $('a[href*="#"]')
                .not('[href="#"]')
                .not('[href="#0"]')
                .click(function(event) {
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
                            }, 1000, function() {
                                var $target = $(target);
                                $target.focus();
                                if ($target.is(":focus")) {
                                    return false;
                                } else {
                                    $target.attr('tabindex','-1');
                                    $target.focus();
                                };
                            });
                        }
                    }
                });


            /*********************************
            *
            * Alerta
            *
            *********************************/

            /* Success

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Sucesso!</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Warning 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Info 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i> Informação</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Question 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-question"><i class="fa fa-question-circle" aria-hidden="true"></i> Tem certeza?</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

            /* Error 

            $(document).ready(function () {
                swal(
                    {
                        title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                        text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'
                    }
                );
            });

            */

        </script>

        

    @endpush
@endsection