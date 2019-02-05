/*global primeiraPaginaArray dependentes global Base64 */
$(function(){


	 	/* DADOS OBTIDOS DA PAGINA QUE EXIBE A OPÇÃO DE SELECIONAR O PLANO */
	var detalhes =  JSON.parse(atob(details))
	var alls =  JSON.parse(atob(all))
 	console.log(alls)
	// carrega indices
	alls.map((val) => {
		if(val.plano =="black"){
			preencherDados(  ".nm-black", ".val-black", ".assinar-black", val.plano, val.id, val.valor);
		}
		if(val.plano =="blue"){
			preencherDados( ".nm-blue", ".val-blue", ".assinar-blue", val.plano, val.id, val.valor);

		}
	})

	// verfica qual plano selecionado e adiciona a classe que escurece a coluna
	if(detalhes.plano =="blue"){
		$('.blue-style-ocult').removeClass('ocult-color')
		$('.black-style-ocult').addClass('ocult-color')
	}

	if(detalhes.plano =="black"){
		$('.blue-style-ocult').addClass('ocult-color')
		$('.black-style-ocult').removeClass('ocult-color')
	}


	function preencherDados( classeNome, classeValor, classeAssinar, plano, id, valor) {
		console.log(classeNome, classeValor, classeAssinar, plano, id, valor)
		$(classeNome).empty().append('Plano '+plano.charAt(0).toUpperCase() + plano.slice(1)+'')
		$(classeValor).empty().append(' <small>R$</small> '+ (valor)+'')
	}

 
	// verificar plano selecionado

	var dependentes = []
	var primeiraPaginaArray =[]
 

	primeiraPagina = () => {
	 var nome = $('#nomeUsuario').val();
		var email = $('#emailUsuario').val();
		var cpf = $('#cpfUsuario').val();
		var celular = $('#celularUsuario').val();

		if(nome.length !=0 && email.length != 0 && cpf.length != 0 && celular.length !=0 && isEmail(email) && cpfVerify(cpf)){
 
			primeiraPaginaArray.length =0

			primeiraPaginaArray.push({
				nome:nome,
				email:email,
				cpf:cpf.replace(/\D+/g, ''),
				celular:celular.replace('-',''),
				plano:detalhes.id
			})

 

			next('.primeiraPage')

		}else{

			$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas!');

		}
	}

	$('#codigoCorretor').keydown(function() {
		$('.consultor').slideUp();
		var codigo = $(this).val().replace(/\D/g, '');
		if(codigo.length >0 ){
				console.log(codigo.length)
			if(codigo.length ==10){

				buscarCorretor(codigo);

			}
		}

	})
	function buscarCorretor(codigo) {
		$.ajax({
			type:'get',
			dataType:'json',
			url: url_corretor,
			headers: {
				"Authorization":corretorkey

			},
			data: {
				cpf:codigo,
			},
			timeout: 15000,
			success: function (result) {

				if(result.corretor.length !=0){
					var consultor = result.corretor[0];
					$('#consultorName').empty().append('<strong>Nome: </strong>'+consultor.nm_primario+' '+consultor.nm_primario);
					$('.consultor').slideDown();

				}

			},
			error: function (result) {

				console.log(result)

			}
		});
	}
	function cpfVerify(cpf){
		cpf = cpf.replace(/\D/g, '');
		if(cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
		var result = true;
		[9,10].forEach(function(j){
			var soma = 0, r;
			cpf.split(/(?=)/).splice(0,j).forEach(function(e, i){
				soma += parseInt(e) * ((j+2)-(i+1));
			});
			r = soma % 11;
			r = (r <2)?0:11-r;
			if(r != cpf.substring(j, j+1)) result = false;
		});
		return result;
	}
	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}
 

	$('.prox').click(function() {
		next(".prox")
	})
	planosAdesao = ({dd, classe}) => {

		next(''+classe+'')
	}

	$('.finalizarCompra').click(function(e) {
		e.preventDefault();
		var numeroCard = $('#numero').val();
		var numeroFormatado = numeroCard.replace(/\s{1,}/g, '');
		var titular = $('#nome_impresso').val();
		var validade = $('#validade ').val();
		var divider = validade.split("/");
		var mes = divider[0]
		var ano = divider[1]
		var cvv = $('#codigo_seg').val();

		if(numeroFormatado.length !=0 && titular.length !=0 && validade.length !=0 && mes.length !=0 && ano.length !=0 && cvv.length !=0){
			var card = [{numero:numeroFormatado, titular, mes, ano , cvv}]

			try {

				$('#numero').validateCreditCard(function(result) {


					if(!result.luhn_valid || !result.length_valid    ){
						$.Notification.notify('error','top right', 'DrHoje', 'Informe um número de cartão válido!');
					}else{

						if($('.form-check-input').is(':checked')){


							efetuarPagamento(primeiraPaginaArray,card )

						}else{
							$.Notification.notify('error','top center', 'DrHoje', 'Aceite os termos e condições para realizar o pagamento!');
						}

					}

				});
			} catch (e) { console.log(e); $.Notification.notify('error','top right', 'DrHoje', 'Não conseguimos verificar seu cartão de crédito!');}

		}else{
			$.Notification.notify('error','top right', 'DrHoje', 'Verifique as informações do seu cartão e tente novamente!');
		}



	})

function efetuarPagamento(usuario, card ){
		$('.spinner').fadeIn()

		  	$.ajax({
			type:'post',
			dataType:'json',
			url: '/contratar-plano',
			data: {
				usuario:usuario,
				dependente:dependentes,
				card:card,
				corretor:$('#codigoCorretor').val(),
				'_token': laravel_token
			},
			timeout: 15000,
			success: function (result) {

				next(".finalizarCompra")
				$('#msform').trigger("reset");
			  	$('#progressbar').hide();
				$('.spinner').fadeOut()
				 swal({
						title: '<div class="tit-sweet tit-success"><i class="fa fa-times-circle" aria-hidden="true"></i> Sucesso</div>',
						text: result.message
					})
			},
			error: function (result) {
				$('.spinner').fadeOut()
				var response = result.responseJSON;
				console.log(response)

			}
		});
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

	// codigo consultor
	$("#codigoCorretor").inputmask({
		mask: ['9-9-9-9-9-9-9-9-9-9-9'],
		keepStatic: true
	});
	$("#celularUsuario").inputmask({
		mask: ['(99) 99999-9999'],
		keepStatic: true
	});

	$(".previous").click(function () {
		if (animating) return false;
		animating = true;

		current_fs = $(this).parent().parent().parent().parent().parent().parent().parent();
		previous_fs = $(this).parent().parent().parent().parent().parent().parent().parent().prev();

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
		'                                                    <p class="nome-produto">1. Assinatura Doutor Plano '+plano+'</p>\n' +
		'                                                </div>\n' +
		'                                                <div class="col-md-3">\n' +
		'                                                    <p class="valor-produto">R$ '+detalhes.valor+'</p>\n' +
		'                                                </div>\n' +

		'                                            </div>\n' +
		'                                        </li>\n' +
		'                                        ');



	// ADICIONAR DEPENDENTE
	var addbutton = document.getElementById("addbutton");
	if(addbutton != null) {
		addbutton.addEventListener("click", function () {
			var limite = $('#boxes').children().length +1
			if(limite ==8){
				$.Notification.notify('error','top right', 'DrHoje', 'Só é possivel adicionar 7 dependentes no momento!');
			}else{
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
			}


		});

	}

	myFunction = (dd) =>  {

		var nome = document.getElementById("nomeDependente"+dd).value;
		var cpf = document.getElementById("cpfDependente"+dd).value;
		var cpfLimpo = cpf.replace(/\D+/g, '');

		var dados = '<li class="cpfDependente'+dd+'">\n' +
			'   <div class="row  ">\n' +
			'    <div class="col-md-8">\n' +
			'      <p class="nome-produto">2. Dependente <strong> '+nome+' </strong> Doutor Hoje Plano '+plano+'</p>\n' +
			'          </div>\n' +
			'    <div class="col-md-3">\n' +
			'       <p class="valor-produto">R$ '+detalhes.valor+'</p>\n' +
			'   </div>\n' +
			'   </div>\n' +
			'   </li>';
		if(!$('li').hasClass("cpfDependente"+dd)){
			if(nome.length >0 && cpfLimpo.length ==11){

				if(cpfVerify(cpf)){
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

				}else{

					$('#cpfDependente'+dd).val("");

					$.Notification.notify('error','top right', 'DrHoje', 'Verifique se os dados do Dependente estão corretos!');
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


	next = (dado) => {
		if (animating) return false;
		animating = true;

		current_fs = $(dado).parent().parent().parent().parent().parent().parent().parent();
		next_fs = $(dado).parent().parent().parent().parent().parent().parent().parent().next();

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
