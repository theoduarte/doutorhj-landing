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
                                <div id="boxes" class="box-individual">

                                </div>
                                <a id="addbutton" href="javascript:;"><i class="fa fa-plus-circle" aria-hidden="true"></i>
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
                                    <ul class="items-pedido">


                                    </ul>
                                </div>
                                <div class="codigo-corretor">
                                    Você comprou com um corretor?
                                    <div class="form-group">
                                        <label for="codigoCorretor1">Código do corretor</label>
                                        <input type="number" class="form-control" id="codigoCorretor" aria-describedby="codigoHelp" placeholder="Insira o código">
                                        <small id="codigoHelp" class="form-text text-muted">(Ignore esse campo se sua
                                            compra foi online)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="area-form-cont">
                                <h2 class="fs-title">Agora configure o<br>
                                    <strong>seu pagamento</strong></h2>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="numeroCartao">N. do cartão</label>
                                    <input type="text" class="form-control col-sm-8" id="numeroCartao" placeholder="0000 0000 0000 0000">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="nomeCartao">Nome impresso no
                                        cartão</label>
                                    <input type="email" class="form-control col-sm-8" id="nomeCartao" placeholder="Nome do titular">
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="mesVencimento">Validade</label>
                                    <select class="form-control col-sm-2" id="mesVencimento">
                                        <option>Mês</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    <select class="form-control col-sm-2" id="mesVencimento">
                                        <option>Ano</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                        <option>2024</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-4 col-form-label" for="cvvCartao">Código de segurança</label>
                                    <input type="text" class="form-control col-sm-2" id="cvvCartao" placeholder="000">
                                </div>
                            </div>
                            <div class="area-btn">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Declaro que li e aceito os
                                        <a href="javascript:;" data-toggle="modal" data-target="#modalTermoUso">termos
                                            de uso</a> do Doutor Hoje
                                    </label>
                                </div>
                                <input type="button" name="previous" class="btn btn-link previous action-button" value="voltar"/>
                                <input type="submit" name="submit" class="btn btn-blue submit action-button" value="Finalizar compra"/>
                                <input type="button" name="next" class="btn btn-blue next action-button" value="Próximo"/>
                            </div>

                            <div class="modal fade" id="modalTermoUso" tabindex="-1" role="dialog" aria-labelledby="modalTermoUsoTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTermoUsoTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Fechar
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                                    </ul>
                                </div>
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
        $('.items-pedido').empty().append('<li>\n' +
			'                                            <div class="row">\n' +
			'                                                <div class="col-md-8">\n' +
			'                                                    <p class="nome-produto">1. Assinatura Doutor Hoje Blue</p>\n' +
			'                                                </div>\n' +
			'                                                <div class="col-md-3">\n' +
			'                                                    <p class="valor-produto">R$ 35,50</p>\n' +
			'                                                </div>\n' +

			'                                            </div>\n' +
			'                                        </li>\n' +
			'                                        ');



        // ADICIONAR DEPENDENTE
        var addbutton = document.getElementById("addbutton");
        addbutton.addEventListener("click", function () {
            var boxes = document.getElementById("boxes");
            var quantidade = $('#boxes').children().length +Math.floor(Math.random() * 100) + 1 ;

		    var data = (' <div id="boxes'+quantidade+'" class="box-dependente ">\n' +
			  '                                          <div class="btn-excluir">\n' +
			  '                                                    <a class="excluir-produto" href="javascript:;" onclick="removerDependente('+quantidade+')">remover dependente</a>\n' +
			  '                                                </div> \n' +
				'                                        <div class="form-row">\n' +
				'                                            <label class="col-sm-4 col-form-label" for="nomeDependente">Nome Completo do Dependente</label>\n' +
				'                                            <input type="text" class="form-control col-sm-8" onkeyup="myFunction( '+quantidade+')" id="nomeDependente'+quantidade+'" placeholder="Nome do dependente">\n' +
				'                                        </div>\n' +
				'                                        <div class="form-row">\n' +
				'                                            <label class="col-sm-4 col-form-label" for="cpfDependente">CPF do Dependente</label>\n' +
				'                                            <input type="text" class="form-control col-sm-8 cpfs-depe"   onkeyup="myFunction( '+quantidade+')"   id="cpfDependente'+quantidade+'" placeholder="CPF do dependente">\n' +
				'                                        </div>\n' +
				'                                    </div>');
			$('#boxes').append(data);
            $('.box-individual').stop().animate({
                scrollTop: $('.box-individual')[0].scrollHeight
            }, 800);

			$("#cpfDependente"+quantidade).inputmask({
				mask: ['999.999.999-99'],
				keepStatic: true
			});

		});



		myFunction = (dd) => {

            var nome = document.getElementById("nomeDependente"+dd).value;
			var cpf = document.getElementById("cpfDependente"+dd).value;
			var cpfLimpo = cpf.replace(/\D+/g, '');
            var plano ="blue";
            var valor = "35,90";
			 if(nome.length >0 && cpfLimpo.length ==11){
				 $('.items-pedido').append('<li>\n' +
					 '                                            <div class="row">\n' +
					 '                                                <div class="col-md-8">\n' +
					 '                                                    <p class="nome-produto">2. Dependente '+nome+' Doutor Hoje '+plano+'</p>\n' +
					 '                                                </div>\n' +
					 '                                                <div class="col-md-3">\n' +
					 '                                                    <p class="valor-produto">R$ '+valor+'</p>\n' +
					 '                                                </div>\n' +
					 '                                            </div>\n' +
					 '                                        </li>');

             }else{

             }

        }
		removerDependente = (dd) => {
			$('#boxes'+dd).remove();
		}

    });
</script>
</body>
</html>