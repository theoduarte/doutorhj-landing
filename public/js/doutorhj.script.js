$(document).ready(function () {
	
	$('#tipo_atendimento').change(function(){
		var tipo_atendimento = $(this).val();
		
		if(tipo_atendimento == '') { return false; }
		
		jQuery.ajax({
    		type: 'POST',
    	  	url: '/consulta-especialidades',
    	  	data: {
				'tipo_atendimento': $(this).val(),
				'_token': laravel_token
			},
			success: function (result) {

				if( result != null) {
					var json = JSON.parse(result.atendimento);
					
					$('#tipo_especialidade').empty();
					for(var i=0; i < json.length; i++) {
						var option = '<option value="'+json[i].id+'">'+json[i].descricao+'</option>';
						$('#tipo_especialidade').append($(option));
					}
					
				}
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
            }
    	});
		
	});
	
	try {
		var $cardinput = $('.cvx-checkout_card_number');
		$('.cvx-checkout_card_number').validateCreditCard(function(result) {		
			//console.log(result);
			if (result.card_type != null)
			{
				$('.inputCodigoCredito').attr('maxlength', 3);
				switch (result.card_type.name)
				{
					case "visa":
						$cardinput.css('background-position', '5px -38px');
						$cardinput.addClass('card_visa');
						$('.inputBandeiraCartaoCredito').val('Visa');
						break;

					case "visa_electron":
						$cardinput.css('background-position', '5px -80px');
						$cardinput.addClass('card_visa_electron');
						//$('.inputBandeiraCartaoCredito').val('Visa');
						break;

					case "mastercard":
						$cardinput.css('background-position', '5px -122px');
						$cardinput.addClass('card_mastercard');
						$('.inputBandeiraCartaoCredito').val('Master');
						break;

					case "maestro":
						$cardinput.css('background-position', '5px -164px');
						$cardinput.addClass('card_maestro');
						//$('.inputBandeiraCartaoCredito').val('Master');
						break;

					case "diners_club_international":
						$cardinput.css('background-position', '5px -206px');
						$cardinput.addClass('card_discover');
						$('.inputBandeiraCartaoCredito').val('Diners');
						break;

					case "amex":
						$cardinput.css('background-position', '5px -290px');
						$cardinput.addClass('card_amex');
						$('.inputBandeiraCartaoCredito').val('Amex');
						$('.inputCodigoCredito').attr('maxlength', 4);
						break;
						
					case "diners_club_carte_blanche":
						$cardinput.css('background-position', '5px -248px');
						$cardinput.addClass('card_discover');
						$('.inputBandeiraCartaoCredito').val('Diners');
						break;
					
					case "elo":
						$cardinput.css('background-position', '5px -332px');
						$cardinput.addClass('card_maestro');
						$('.inputBandeiraCartaoCredito').val('Elo');
						break;
						
					default:
						$cardinput.css('background-position', '5px 4px');
						break;					
				}
			} else {
				$cardinput.css('background-position', '5px 4px');
			}

			// Check for valid card numbere - only show validation checks for invalid Luhn when length is correct so as not to confuse user as they type.
			if (result.length_valid || $cardinput.val().length > 16)
			{
				if (result.luhn_valid) {
					$cardinput.parent().removeClass('has-error').addClass('has-success');
				} else {
					$cardinput.parent().removeClass('has-success').addClass('has-error');
				}
			} else {
				$cardinput.parent().removeClass('has-success').removeClass('has-error');
			}
		});
	} catch (e) {}
	
	$('#btn-finalizar-pedido').click(function(){
		
		var result = true;
		var numero_cartao 	= $('#inputNumeroCartaoCredito');
		var nome_impresso 	= $('#inputNomeCartaoCredito');
		var mes_credito 	= $('#selectValidadeMesCredito');
		var ano_credito 	= $('#selectValidadeAnoCredito');
		var cod_seg 		= $('#inputCodigoCredito');
		var cpf_titular 	= $('#inputCPFCredito');
		var parcelamento 	= $('#selectParcelamentoCredito');
		
		if(numero_cartao.val().length == 0) {
			numero_cartao.parent().addClass('cvx-has-error');
			numero_cartao.parent().append('<span class="help-block text-danger"><strong>Este Cartão não é válido</strong></span>');
			
			$('#inputNumeroCartaoCredito').keypress(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		if(nome_impresso.val().length == 0) {
			nome_impresso.parent().addClass('cvx-has-error');
			nome_impresso.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
			
			$('#inputNomeCartaoCredito').keypress(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		if(mes_credito.val().length == 0) {
			mes_credito.parent().addClass('cvx-has-error');
			mes_credito.parent().append('<span class="help-block text-danger"><strong>Mês Cartão</strong></span>');
			
			$('#selectValidadeMesCredito').change(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		if(ano_credito.val().length == 0) {
			ano_credito.parent().addClass('cvx-has-error');
			ano_credito.parent().append('<span class="help-block text-danger"><strong>Ano Cartão</strong></span>');
			
			$('#selectValidadeAnoCredito').change(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		if(cod_seg.val().length == 0) {
			cod_seg.parent().addClass('cvx-has-error');
			cod_seg.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
			
			$('#inputCodigoCredito').keypress(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		if(cpf_titular.val().length == 0) {
			cpf_titular.parent().addClass('cvx-has-error');
			cpf_titular.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
			
			$('#inputCPFCredito').keypress(function(){
				$(this).parent().removeClass('cvx-has-error');
				$(this).parent().find('span.help-block').remove();
			});
			
			result = false;
		}
		
		var num_itens = $('.card-resumo-compra').length;
		var agendamentos = [];
		
		for(var i = 0; i < num_itens; i++) {
			var item = '{"dt_atendimento":"'+$('#dt_atendimento_'+i).val()+'","paciente_id":'+$('#paciente_id_'+i).val()+',"clinica_id":'+ $('#clinica_id_'+i).val()+',"atendimento_id":'+ $('#atendimento_id_'+i).val()+',"profissional_id":'+$('#profissional_id_'+i).val()+'}';
			agendamentos.push(item);
		}
		
		var tipo_pagamento = $('#selectFormaPagamento').val();
		var titulo_pedido = $('#titulo_pedido').val();
		var paciente_id = $('#paciente_id').val();
		
		var num_cartao_credito = numero_cartao.val();
		var nome_impresso_cartao_credito = nome_impresso.val();
		var mes_cartao_credito = mes_credito.val();
		var ano_cartao_credito = ano_credito.val();
		var cod_seg_cartao_credito = cod_seg.val();
		var gravar_cartao_credito = $('#checkGravarCartaoCredito').val();
		var bandeira_cartao_credito = $('#inputBandeiraCartaoCredito').val();
		
		$.ajax({
			type:'post',
			   dataType:'json',
			   url: '/finalizar_pedido',
			   data: {
				   'tipo_pagamento': tipo_pagamento,
				   'titulo_pedido': titulo_pedido,
				   'paciente_id': paciente_id,
				   'num_cartao_credito': num_cartao_credito,
				   'nome_impresso_cartao_credito': nome_impresso_cartao_credito,
				   'mes_cartao_credito': mes_cartao_credito,
				   'ano_cartao_credito': ano_cartao_credito,
				   'cod_seg_cartao_credito': cod_seg_cartao_credito,
				   'gravar_cartao_credito': gravar_cartao_credito,
				   'bandeira_cartao_credito': bandeira_cartao_credito,
				   'agendamentos': agendamentos,
				   '_token': laravel_token
			   },
			   timeout: 15000,
			   success: function (result) {

				  if(result.status) {
					  $.Notification.notify('success','top right', 'DrHoje', result.mensagem);
					  window.location.href='/concluir_pedido';
				  }
			  },
			  error: function (result) {
	          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
	          }
		});
		
		if(!result) {
			$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Por favor, verifique os campos e tente novamente.');
		}
		
		return result;
	});
	
	$(".select2").select2({
		language: 'pt-BR'
	});
	
	/*$( "#local_atendimento" ).keyup(function() {
		
		var search_term = $(this).val();
		
		if(search_term.length < 3){ return false; }
		
		var tipo_atendimento = $('#tipo_atendimento').val();
		var procedimento_id = $('#tipo_especialidade').val();
		var tipo_especialidade = $('#tipo_atendimento').val() == 'saude' | $('#tipo_atendimento').val() == 'odonto' ? 'consulta' : 'procedimento';
		
		$( "#local_atendimento" ).autocomplete({
			source: function( request, response ) {
				$.ajax( {
					type: 'POST',
					url      : "/consulta-local-atendimento",
					dataType : "json",
					data: {
						'search_term': search_term,
						'tipo_atendimento': tipo_atendimento,
						'procedimento_id': procedimento_id,
						'tipo_especialidade': tipo_especialidade,
						'_token': laravel_token
					},
					success  : function( data ) {
						response( data );
					}
				});
			},
			minLength : 3,
			select: function(event, ui) {
				arProcedimento = ui.item.id.split(' | ');
				
				$('input[name="procedimento_id"]').val(arProcedimento[0]);
				$('input[name="cd_procedimento"]').val(arProcedimento[1]);
				$('input[name="descricao_procedimento"]').val(arProcedimento[2]);
			}
		});
	});*/
	
	$( '#local_atendimento' ).keyup(function() {
		$(this).parent().find('.cvx-no-loading').addClass('cvx-input-loading');
	});
	
	$( '#local_atendimento' ).autocomplete({
		type:'post',
		dataType: 'json',
		params: {
			'search_term': function() { return $('#local_atendimento').val(); },
			'tipo_atendimento': function() { return $('#tipo_atendimento').val(); },
			'atendimento_id': function() { return $('#tipo_especialidade').val(); },
			'tipo_especialidade': function() { return $('#tipo_atendimento').val() == 'saude' | $('#tipo_atendimento').val() == 'odonto' ? 'consulta' : 'procedimento'; },
			'_token': laravel_token
		},
		minChars: 3,
		serviceUrl: "/consulta-local-atendimento",
	    onSelect: function (result) {
	    	$( '#local_atendimento' ).parent().find('.cvx-no-loading').removeClass('cvx-input-loading');
	    	$('#endereco_id').val(result.id);			
	    },
	    onSearchComplete: function (ui) {
	    	$( '#local_atendimento' ).parent().find('.cvx-no-loading').removeClass('cvx-input-loading');
	    	var tipo_atendimento = $('#tipo_atendimento').val();
	    	var atendimento_id = $('#tipo_especialidade').val();
	    	
    	    if($(this).val().length > 3 & tipo_atendimento.length > 0 & atendimento_id.length > 0) {
        	    buscarEndereco($(this), tipo_atendimento, atendimento_id);
    	    }
	    }
	});
	
	$('#btn-finalizar-pedido').click(function(){
		
		
	});
	
});

function buscarEndereco(input, tipo_atendimento, atendimento_id) {

	//alert('cnpj: '+cnpj);
	var search_term = $(input).val();
	
	$.ajax({
		type:'post',
		   dataType:'json',
		   url: '/consulta-endereco-local-atendimento',
		   data: {
			   'search_term': search_term,
			   'tipo_atendimento': tipo_atendimento,
			   'atendimento_id': atendimento_id,
			   '_token': laravel_token
		   },
		   timeout: 15000,
		   success: function (result) {

			  if(result.status) {

				  //$(input).val(result.endereco.nm_cidade);
				  $('#endereco_id').val(result.endereco.id);

			  }
		  },
		  error: function (result) {
          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
          }
	});
}

function numberToReal(numero) {
	
	var c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = numero < 0 ? "-" : "", i = parseInt(numero = Math.abs(+numero || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(numero - i).toFixed(c).slice(2) : "");
}

function moedaParaNumero(valor)
{
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}

function validaBuscaAtendimento() {
	
	var tipo_atendimento = $('#tipo_atendimento');
	var tipo_especialidade = $('#tipo_especialidade');
	var endereco_id = $('#endereco_id');
	
	if( tipo_atendimento.val().length == 0 ) {
		
		tipo_atendimento.parent().addClass('cvx-has-error');
		tipo_atendimento.focus();
		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Selecione o Tipo de Atentimento');
		
		$('.cvx-has-error .form-control').change(function(){
			$(this).parent().removeClass('cvx-has-error');
		});
		
		return false;
	}
	
	if( tipo_especialidade.val().length == 0 ) {
		tipo_especialidade.parent().addClass('cvx-has-error');
		tipo_especialidade.focus();
		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Selecione a Especialidade ou Exame');
		
		$('.cvx-has-error .form-control').change(function(){
			$(this).parent().removeClass('cvx-has-error');
		});
		
		return false;
	}
	
	if( endereco_id.val().length == 0 ) {
		endereco_id.parent().addClass('cvx-has-error');
		endereco_id.focus();
		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Endereço não localizado. Por favor, tente novamente.');
		
		$('.cvx-has-error .form-control').keyup(function(){
			$(this).parent().removeClass('cvx-has-error');
		});
		
		return false;
	}
	
	
	return true;
}

function onlyNumbers(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;

    var keychar = String.fromCharCode(key);
    //alert(keychar);
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