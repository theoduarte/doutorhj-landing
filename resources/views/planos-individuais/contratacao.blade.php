<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Comvex">
    <meta name="keywords" content="doutorhj saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">
    <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>
    <link href="/libs/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/doutorhj.style.css">
    <script src="/libs/home-template/js/jquery-3.3.1.min.js"></script>
    <script src="/libs/home-template/js/popper.min.js"></script>
    <script src="/libs/home-template/js/bootstrap.min.js"></script>
    <script src="/libs/home-template/js/jquery.easing.min.js"></script>
    <script src="/libs/inputmask-4/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="/libs/notifyjs/dist/notify.min.js"></script>
    <script src="/libs/notifications/notify-metro.js"></script>
    <script src="/libs/comvex-template/js/jquery.core.js"></script>
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/comvex-template/pages/jquery.sweet-alert.init.js"></script>
    <title>Planos Individuais - Doutor Hoje</title>

</head>
<body>
<div class="lp-pessoa-fisica-pagamento">
    <header>
        <div class="container">

        </div>
    </header>
    <section>
        <div class="container">
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="area-form-cont">
                                <h2 class="fs-title">Cadastre-se para utilizar<br>
                                    <strong>o Doutor Hoje</strong></h2>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="nomeUsuario">Nome Completo</label>
                                    <input type="text" class="form-control col-sm-8" id="nomeUsuario" placeholder="Seu nome">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="emailUsuario">E-mail</label>
                                    <input type="email" class="form-control col-sm-8" id="emailUsuario" placeholder="exemplo@email.com.br">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cpfUsuario">CPF</label>
                                    <input type="text" class="form-control col-sm-8" id="cpfUsuario" placeholder="000.000.000-00">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="celularUsuario">Celular com DDD</label>
                                    <input type="text" class="form-control col-sm-8" id="celularUsuario" placeholder="Seu nome">
                                </div>
                            </div>
                            <div class="area-dependente">
                                <div id="boxes">
                                    <div class="box-dependente active">
                                        <p>Dependente 1</p>
                                        <div class="form-row">
                                            <label class="col-sm-4 col-form-label" for="nomeDependente">Nome Completo do Dependente</label>
                                            <input type="text" class="form-control col-sm-8" id="nomeDependente" placeholder="Nome do dependente">
                                        </div>
                                        <div class="form-row">
                                            <label class="col-sm-4 col-form-label" for="cpfDependente">CPF do Dependente</label>
                                            <input type="text" class="form-control col-sm-8" id="cpfDependente" placeholder="CPF do dependente">
                                        </div>
                                    </div>
                                </div>
                                <a id="addbutton" href=""><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Adicionar Dependente</a>
                            </div>
                            <div class="area-btn">
                                <input type="button" name="next" class="btn btn-blue next action-button" value="Próximo"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="area-resumo-cont">
                                <div class="lista-pedido">
                                    <p>Pedido</p>
                                    <ul>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p class="nome-produto">1. Assinatura Doutor Hoje Blue</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="valor-produto">R$ 35,50</p>
                                                </div>
                                                <div class="col-md-1">
                                                    <a class="excluir-produto" href=""><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p class="nome-produto">2. Dependente Doutor Hoje Blue</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="valor-produto">R$ 35,50</p>
                                                </div>
                                                <div class="col-md-1">
                                                    <a class="excluir-produto" href=""><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p class="nome-produto">3. Dependente Doutor Hoje Blue</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="valor-produto">R$ 35,50</p>
                                                </div>
                                                <div class="col-md-1">
                                                    <a class="excluir-produto" href=""><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="area-form-cont">
                                <h2 class="fs-title">Cadastre-se para utilizar<br>
                                    <strong>o Doutor Hoje</strong></h2>
                                <div class="form-group">
                                    <label for="nomeUsuario">Nome Completo</label>
                                    <input type="text" class="form-control" id="nomeUsuario" placeholder="Seu nome">
                                </div>
                                <div class="form-group">
                                    <label for="emailUsuario">Email address</label>
                                    <input type="email" class="form-control" id="emailUsuario" placeholder="exemplo@email.com.br">
                                </div>
                                <div class="form-group">
                                    <label for="cpfUsuario">CPF</label>
                                    <input type="text" class="form-control" id="cpfUsuario" placeholder="000.000.000-00">
                                </div>
                                <div class="form-group">
                                    <label for="celularUsuario">Celular com DDD</label>
                                    <input type="text" class="form-control" id="celularUsuario" placeholder="Seu nome">
                                </div>
                            </div>
                            <div class="area-btn">
                                <input type="button" name="previous" class="btn btn-link previous action-button" value="voltar"/>
                                <input type="submit" name="submit" class="btn btn-blue submit action-button" value="Finalizar compra"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="area-resumo-cont">
                                Resumo 2
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    Conclusão
                </fieldset>
            </form>
        </div>
    </section>
    {{--<footer class="footer-lp-pf">
        <div class="container">

        </div>
    </footer>--}}
</div>
@include('flash-message')
<script>
    $(document).ready(function () {

        // MULTI STEP FORM
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent().parent().parent().parent();
            next_fs = $(this).parent().parent().parent().parent().next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'transform': 'scale(' + scale + ')'});
                    next_fs.css({'left': left, 'opacity': opacity});
                },
                duration: 500,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeOutQuint'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent().parent().parent().parent();
            previous_fs = $(this).parent().parent().parent().parent().prev();

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                },
                duration: 500,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeOutQuint'
            });
        });

        $(".submit").click(function () {
            return false;
        })

        // ADICIONAR DEPENDENTE
        var addbutton = document.getElementById("addbutton");
        addbutton.addEventListener("click", function () {
            var boxes = document.getElementById("boxes");
            var clone = boxes.firstElementChild.cloneNode(true);
            boxes.appendChild(clone);
        });

    });
</script>
</body>
</html>