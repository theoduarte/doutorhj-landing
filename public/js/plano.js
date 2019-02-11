/*global primeiraPaginaArray dependentes global Base64 */
$(function(){


	 	/* DADOS OBTIDOS DA PAGINA QUE EXIBE A OPÇÃO DE SELECIONAR O PLANO */
	var detalhes =  JSON.parse(atob(details))
	var alls =  JSON.parse(atob(all))

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
		$('.assinar-bt-black').css({cursor:"default"});
		$('.blue-style-ocult').removeClass('ocult-color')
		$('.black-style-ocult').addClass('ocult-color')

		$('.assinar-bt-blue').click(function() {
			planosAdesao({dd:'foi', classe:'.blue'})
		})
	}

	if(detalhes.plano =="black"){
		$('.assinar-bt-blue').css({cursor:"default"});
		$('.assinar-bt-black').click(function() {
			planosAdesao({dd:'foi', classe:'.black'})
		})

		$('.blue-style-ocult').addClass('ocult-color')
		$('.black-style-ocult').removeClass('ocult-color')
	}


	function preencherDados( classeNome, classeValor, classeAssinar, plano, id, valor) {

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
				nome:nome.toUpperCase(),
				email:email.toUpperCase(),
				cpf:cpf.replace(/\D+/g, ''),
				celular:celular.replace('-',''),
				plano:detalhes.id
			})

 

			next('.primeiraPage')

		}else{

			if(!isEmail(email)){
				$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas, E-mail inválido ');
			}
			if(!cpfVerify(cpf)){
				$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas, CPF inválido ');
			}else{
				$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas e tente novamente ');
			}


		}
	}

	$('#codigoCorretor').keydown(function() {
		$('.consultor').slideUp();
		var codigo = $(this).val().replace(/\D/g, '');
		if(codigo.length >0 ){

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

				}else{



					$('#codigoCorretor').val('');
					$.Notification.notify('error','top right', 'DrHoje', 'Não encontramos nenhum consultor vinculado a este codigo!');
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

		var numeroCard = $('#numero').val();
		var numeroFormatado = numeroCard.replace(/\s{1,}/g, '');
		var titular = $('#nome_impresso').val();
		var validade = $('#validade ').val();
		var divider = validade.split("/");
		var mes = divider[0]
		var ano = divider[1]
		var cvv = $('#codigo_seg').val();

		if(numeroFormatado.length !=0 && titular.length !=0 && validade.length !=0 && mes.length !=0 && ano.length !=0 && cvv.length !=0){
			var card = [{numero:numeroFormatado, titular:titular.toUpperCase() , mes, ano , cvv}]



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

			return false;
		}else{
			$.Notification.notify('error','top right', 'DrHoje', 'Verifique as informações do seu cartão e tente novamente!');
			return false;
		}



	})

function efetuarPagamento(usuario, card ){
		$('.spinner').fadeIn()

			let corretor =$('#codigoCorretor').val();

		  	$.ajax({
			type:'post',
			dataType:'json',
			url: '/contratar-plano',
			data: {
				usuario:usuario,
				dependente:dependentes,
				card:card,
				corretor:corretor.replace(/\s{1,}/g, ''),
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

				try{
					var response = result.responseJSON;
					var res = response.details.split("response:")
					var error =JSON.parse(res[1]);
					var errors =error.errors != undefined ? error.errors : '';

					swal({
						title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> '+response.message+'</div>',
						text: error.message+' '+errors
					})

				}catch (e) {
					swal({
						title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> ops</div>',
						text: 'Não conseguimos processar o pagamento'
					})
				}

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
		'                                                    <p class="nome-produto"><i class="fa fa-chevron-right"></i> Assinatura Doutor Hoje Plano '+plano+'</p>\n' +
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


				var nomeVerificar = $('#nomeUsuario').val();
				var emailVerificar = $('#emailUsuario').val();
				var cpfVerificar = $('#cpfUsuario').val();
				var celularVerificar = $('#celularUsuario').val();

				if(nomeVerificar.length !=0 && emailVerificar.length != 0 && cpfVerificar.length != 0 && celularVerificar.length !=0 && isEmail(emailVerificar) && cpfVerify(cpfVerificar)){
					var limite = $('#boxes').children().length +1
					if(limite ==8){
						$.Notification.notify('error','top right', 'DrHoje', 'Só é possivel adicionar 7 dependentes no momento!');
					}else{
						var boxes = document.getElementById("boxes");
						var quantidade = $('#boxes').children().length +  1 ;

						if(verificarInputs()){
							$.Notification.notify('error','top right', 'DrHoje', 'Preencha os dados do depedente antes de adicionar um novo!');
						}else{

							var data = (' <div id="boxes'+quantidade+'" class="box-dependente ">\n' +
								'                                          <div class="btn-excluir">\n' +
								'                                                    <a class="excluir-produto" href="javascript:;" onclick="removerDependente('+quantidade+')">Remover Dependente</a>\n' +
								'                                                </div> \n' +
								'                                        <div class="form-row">\n' +
								'                                            <label class="col-sm-4 col-form-label" for="nomeDependente">Nome Completo do Dependente</label>\n' +
								'                                            <input type="text" maxlength="40" class="form-control col-sm-8 text-uppercase" onkeyup="myFunction( '+quantidade +')" id="nomeDependente'+quantidade+'" placeholder="Nome do dependente">\n' +
								'                                        </div>\n' +
								'                                        <div class="form-row">\n' +
								'                                            <label class="col-sm-4 col-form-label" for="cpfDependente">CPF do Dependente</label>\n' +
								'                                            <input type="text" class="form-control col-sm-8 cpfs-depe"  name="cpf" onkeyup="myFunction( '+quantidade +')"   id="cpfDependente'+quantidade+'" placeholder="CPF do dependente">\n' +
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

					}
				} else {
					if(!isEmail(emailVerificar)){
						$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas, E-mail inválido ');
					}
					if(!cpfVerify(cpfVerificar)){
						$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas, CPF inválido ');
					}else{
						$.Notification.notify('error','top right', 'DrHoje', 'Ops, verifique as informações inseridas e tente novamente ');
					}

				}

		});

	}

	verificarInputs = () => {
		var data =false;
		for (var i=1; i<8; i++){
			var cpf = $( "#cpfDependente"+i).val();
			var nome = $( "#nomeDependente"+i).val();

			try{
				if( cpf.length  == 0 ||  nome.length==0){
					data = true;
				}
			}catch (e) {}


		}

		return data

	}

	myFunction = (dd ) =>  {


		var nome = document.getElementById("nomeDependente"+dd).value;
		var cpf = document.getElementById("cpfDependente"+dd).value;
		var cpfTitular = document.getElementById("cpfUsuario").value;
		var cpfLimpo = cpf.replace(/\D+/g, '');
		var cpfTitularLimpo =  cpfTitular.replace(/\D+/g, '');
		var numDepe = dd+1;
		var dados = '<li class="cpfDependente'+dd+'">\n' +
			'   <div class="row  ">\n' +
			'    <div class="col-md-8">\n' +
			'      <p class="nome-produto"><i class="fa fa-chevron-right"></i>  Dependente <strong> '+nome.toUpperCase()+' </strong> Doutor Hoje Plano '+plano+'</p>\n' +
			'          </div>\n' +
			'    <div class="col-md-3">\n' +
			'       <p class="valor-produto">R$ '+detalhes.valor+'</p>\n' +
			'   </div>\n' +
			'   </div>\n' +
			'   </li>';
		var dadoTitular = dependentes.filter(x => x.cpf === cpfTitularLimpo);



		 if(cpfTitularLimpo ==cpfLimpo || dadoTitular.length !=0){
			 $.Notification.notify('error','top right', 'DrHoje', 'Não é possivel adicionar o CPF do titular como dependente!');
			 $('#cpfDependente'+dd).val("");
		 }else{

			 if(!$('li').hasClass("cpfDependente"+dd)){
				 if(nome.length >1 && cpfLimpo.length ==11){
					 if(cpfVerify(cpf)){
						 $("#nomeDependente"+dd).prop('disabled', true);
						 $("#cpfDependente"+dd).prop('disabled', true);
						 $('.items-pedido').append(dados);

						 if(dependentes.length >0){
							 var dad = dependentes.filter(x => x.cpf === cpfLimpo);
							 if(dad.length ==0){
								 dependentes.push({
									 nome:nome.toUpperCase(),
									 cpf:cpfLimpo
								 })
							 }

						 }else{

							 dependentes.push({
								 nome:nome.toUpperCase(),
								 cpf:cpfLimpo
							 })
						 }

					 }else{

						 $('#cpfDependente'+dd).val("");

						 $.Notification.notify('error','top right', 'DrHoje', 'Verifique se os dados do Dependente estão corretos!');
					 }

				 }
			 }

			 if($('li').hasClass("cpfDependente"+dd)){
				 if(nome.length <4 || cpfLimpo.length <11){
					 $.each(dependentes, function(i){
						 if(dependentes[i].cpf === cpfLimpo) {
							 dependentes.splice(i,1);
							 return false;
						 }
					 });
					 $('.cpfDependente'+dd).remove();
				 }

			 }

		 }

		verificarDependentesIguais(cpfLimpo,dd )

	}

	verificarDependentesIguais = (cpf, dd) => {

		if($(' .box-dependente').length >1){
			for (var j=1; j < $(' .box-dependente').length; j++){
				var items = $('.box-individual').find('#boxes'+j);
			try{
				var input = items.find("input[name=cpf]").val();
				if(input.length !=0){
					var cpfLimpo = input.replace(/\D+/g, '');

					if(cpfLimpo==cpf){
						$('#boxes'+dd).remove();
						$('.cpfDependente'+dd).remove();
						swal({

							title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ops</div>',
							text: "Não é possivel adicionar dependentes com CPF iguais."
						});
					}
				}
			}catch (e) {}


			}

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
