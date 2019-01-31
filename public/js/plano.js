$(function(){
	/*global primeiraPaginaArray dependentes*/
	var dependentes = []
	var primeiraPaginaArray =[]
	primeiraPagina = () => {

		var nome = $('#nomeUsuario').val();
		var email = $('#emailUsuario').val();
		var cpf = $('#cpfUsuario').val();
		var celular = $('#celularUsuario').val();
		if(nome.length !=0 && email.length != 0 && cpf.length != 0 && celular.length !=0){
			primeiraPaginaArray.length =0

			primeiraPaginaArray.push({
				nome:nome,
				email:email,
				cpf:cpf,
				celular:celular
			})

			if(dependentes.length !=0){
				primeiraPaginaArray.push({dependentes:dependentes})
			}

			next()
		}
	}

	finalizarCompra = () => {
		console.log(primeiraPaginaArray)
		var numero = $('#inputNumeroCartaoCredito').val();
		var titular = $('#nomeCartao').val();
		var mes = $('#mesVencimento ').val();
		var ano = $('#anoVencimento').val();
		var cvv = $('#cvvCartao').val();
		console.log({numero, titular, mes, ano, cvv})

	}




	// MULTI STEP FORM
	var current_fs, next_fs, previous_fs; //fieldsets
	var left, opacity, scale; //fieldset properties which we will animate
	var animating; //flag to prevent quick multi-click glitches
	var dadosArray = []

	$('#msform').submit(function () {
		return false;
	});


	$("#cpfUsuario").inputmask({
		mask: ['999.999.999-99'],
		keepStatic: true
	});
	$("#celularUsuario").inputmask({
		mask: ['(99) 99999-9999'],
		keepStatic: true
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
			'                                            <input type="text" class="form-control col-sm-8 cpfs-depe"  name="cpf" onkeyup="myFunction( '+quantidade+')"   id="cpfDependente'+quantidade+'" placeholder="CPF do dependente">\n' +
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





	myFunction = (dd) =>  {

		var nome = document.getElementById("nomeDependente"+dd).value;
		var cpf = document.getElementById("cpfDependente"+dd).value;
		var cpfLimpo = cpf.replace(/\D+/g, '');
		var plano ="blue";
		var valor = "35,90";
		var dados = '<li class="cpfDependente'+dd+'">\n' +
			'   <div class="row  ">\n' +
			'    <div class="col-md-8">\n' +
			'      <p class="nome-produto">2. Dependente <strong> '+nome+' </strong> Doutor Hoje '+plano+'</p>\n' +
			'          </div>\n' +
			'    <div class="col-md-3">\n' +
			'       <p class="valor-produto">R$ '+valor+'</p>\n' +
			'   </div>\n' +
			'   </div>\n' +
			'   </li>';
		if(!$('li').hasClass("cpfDependente"+dd)){
			if(nome.length >0 && cpfLimpo.length ==11){
				$('.items-pedido').append(dados);

				if(dependentes.length >0){
					var dad = dependentes.filter(x => x.cpf === cpfLimpo);
					if(dad.length ==0){
						dependentes.push({
							nome:nome,
							cpf:cpfLimpo
						})
					}

				}else{
					dependentes.push({
						nome:nome,
						cpf:cpfLimpo
					})
				}


			}
		}

		verificarDependentesIguais(cpfLimpo,dd, nome, cpf)
	}

	verificarDependentesIguais = (cpf, dd) => {

		if($('.box-individual .box-dependente').length >1){
			$.each($('.box-individual'),function() {
				var items = $(this).find('.box-dependente') ;
				var input = items.find("input[name=cpf]").val();
				if(input.length !=0){
					var cpfLimpo = input.replace(/\D+/g, '');
					if(cpfLimpo==cpf){
						$('#boxes'+dd).remove();
						$('.cpfDependente'+dd).remove();
						swal(
							{
								title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ops</div>',
								text: "Não é possivel adicionar dependentes com CPF iguais."
							}
						);
					}
				}

			})
		}



	}
	removerDependente = (dd) => {

		let boxes = $("#boxes"+dd).find(".form-row")
		var input = boxes.find("input[name=cpf]").val();
		var cpfLimpo = input.replace(/\D+/g, '');
		$.each(dependentes, function(i){
			if(dependentes[i].cpf === cpfLimpo) {
				dependentes.splice(i,1);
				return false;
			}
		});
		$('#boxes'+dd).remove();
		$('.cpfDependente'+dd).remove();
	}


	next = () => {
		if (animating) return false;
		animating = true;

		current_fs = $(".primeiraPage").parent().parent().parent().parent();
		next_fs = $(".primeiraPage").parent().parent().parent().parent().next();

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
	}
	previous = () => {

	}



	onlyNumbers =(evt) =>
	{
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		var keychar = String.fromCharCode(key);
		var keycheck = /^[0-9_\b]+$/;

		if (!(key == 8 || key == 9 || key == 17 || key == 27 || key == 44 || key == 46 || key == 37 || key == 39)) {
			if (!keycheck.test(keychar)) {
				theEvent.returnValue = false;//for IE
				if (theEvent.preventDefault) {
					theEvent.preventDefault();//Firefox
				}
			}
		}
	}

})
