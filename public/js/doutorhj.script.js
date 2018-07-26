$(document).ready(function () {
	$('#tipo_atendimento').change(function(){
		var tipo_atendimento = $(this).val();
		if(tipo_atendimento == '') { return false; }
		
		
		if( $(this).val() == 'saude' || $(this).val() == 'odonto' || $(this).val() == 'exame' ){
			$('label[for="especialidade"]').text("Especialidade ou exame");
			$('label[for="local"]').text("Local de Atendimento");
			$('.form-busca').attr('action', '/resultado');
			$('.form-busca').attr('onsubmit', 'return validaBuscaAtendimento()');
		}else if( $(this).val() == 'checkup' ){
			$('label[for="especialidade"]').text("Check-up");
			$('label[for="local"]').text("Tipo de Check-up");
			$('.form-busca').attr('action', '/resultado-checkup');
			$('.form-busca').attr('onsubmit', 'return validaBuscaCheckup()');
		}
		$('#local_atendimento').empty();
		
		
		jQuery.ajax({
    		type: 'POST',
    	  	url: '/consulta-especialidades',
    	  	data: {
				'tipo_atendimento': tipo_atendimento,
				'_token'		  : laravel_token
			},
			success: function (result) {
				if( result != null) {
					var json = JSON.parse(result.atendimento);

					$('#tipo_especialidade').empty();

					if( $('#tipo_atendimento').val() != 'checkup' ){
						for(var i=0; i < json.length; i++) {
							var option = '<option value="'+json[i].id+'">'+json[i].descricao+'</option>';
							$('#tipo_especialidade').append($(option));
						}

						var atendimento_id = $('#tipo_especialidade option:first').val();
						if(atendimento_id == '') { return false; }

						jQuery.ajax({
				    		type: 'POST',
				    	  	url: '/consulta-todos-locais-atendimento',
				    	  	data: {
								'tipo_atendimento': tipo_atendimento,
				    	  		'atendimento_id': atendimento_id,
								'_token': laravel_token
							},
							success: function (result) {
								if( result != null) {
									var json = result.endereco;
									$('#local_atendimento').empty();
									var option = '<option value="TODOS">TODOS OS LOCAIS</option>';
									$('#local_atendimento').append($(option));
									
									for(var i=0; i < json.length; i++) {
										option = '<option value="'+json[i].id+'">'+json[i].value+'</option>';
										$('#local_atendimento').append($(option));
									}
									
									if(json.length > 0) {
										$('#local_atendimento option[value="'+json[0].id+'"]').prop("selected", true);
										$('#endereco_id').val(json[0].id);
									}
								}
				            },
				            error: function (result) {
				            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
				            }
				    	});
					}else{
						for(var i=0; i < json.length; i++) {
							var option = '<option value="'+json[i].descricao+'">'+json[i].descricao+'</option>';
							$('#tipo_especialidade').append($(option));
						}

						jQuery.ajax({
							type: 'POST',
							url: '/consulta-tipos-checkup',
							data: {
								'tipo_atendimento': $('select[name="tipo_especialidade"]').val(),
								'_token': laravel_token
							},
							success: function (result) {
								if( result != null) {
									var json = result;
									
									$('#local_atendimento').empty();
									var option = '<option value="TODOS">TODOS</option>';
									$('#local_atendimento').append($(option));
									
									for(var i=0; i < json.length; i++) {
										option = '<option value="'+json[i].tipo+'">'+json[i].tipo+'</option>';
										$('#local_atendimento').append($(option));
									}
									
									if(json.length > 0) {
										$('#local_atendimento option[value="'+json[0].tipo+'"]').prop("selected", true);
									}									
								}
							},
							error: function (result) {
								$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
							}
						});
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
			if (result.card_type != null)
			{
				$('.inputCodigoCredito').attr('maxlength', 3);
				switch (result.card_type.name)
				{
					case "visa":
						$cardinput.css('background-position', '5px -38px');
						$cardinput.addClass('card_visa');
						$('.inputBandeiraCartaoCredito').val('Visa');
						$('.inputBandeiraCartaoDebito').val('Visa');
						break;

					case "visa_electron":
						$cardinput.css('background-position', '5px -80px');
						$cardinput.addClass('card_visa_electron');
						$('.inputBandeiraCartaoCredito').val('Visa');
						$('.inputBandeiraCartaoDebito').val('Visa');
						break;
						$checkup
					case "mastercard":
						$cardinput.css('background-position', '5px -122px');
						$cardinput.addClass('card_mastercard');
						$('.inputBandeiraCartaoCredito').val('Master');
						break;

					case "maestro":
						$cardinput.css('background-position', '5px -164px');
						$cardinput.addClass('card_maestro');
						$('.inputBandeiraCartaoDebito').val('Maestro');
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
						$cardinput.addClass('card_maestro');$checkup
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
		var tipo_pagamento = $('#selectFormaPagamento').val();
		var cartao_cadastrado = $('#selectCartaoCredito').val();
		
		if(tipo_pagamento == 'credito' && cartao_cadastrado == '') {
			pagarCartaoCredito();
		} else if(tipo_pagamento == 'debito' && cartao_cadastrado == '') {
			pagarCartaoDebito();
		} else if(cartao_cadastrado != '') {
			pagarCartaoCadastrado();
		}
	});
	
	$(".select2").select2({
		language: 'pt-BR'
	});
	
	$('#tipo_especialidade').change(function(){
		if( $('#tipo_atendimento').val() != 'checkup' ){
			var atendimento_id = $(this).val();
			var tipo_atendimento = $('#tipo_atendimento').val();
			
			if(atendimento_id == '') { return false; }
			
			
			jQuery.ajax({
	    		type: 'POST',
	    	  	url: '/consulta-todos-locais-atendimento',
	    	  	data: {
					'tipo_atendimento': tipo_atendimento,
	    	  		'atendimento_id': atendimento_id,
					'_token': laravel_token
				},
				success: function (result) {
	
					if( result != null) {
						var json = result.endereco;
						
						$('#local_atendimento').empty();
						var option = '<option value="TODOS">TODOS OS LOCAIS</option>';
						$('#local_atendimento').append($(option));
						
						for(var i=0; i < json.length; i++) {
							option = '<option value="'+json[i].id+'">'+json[i].value+'</option>';
							$('#local_atendimento').append($(option));
						}
						
						if(json.length > 0) {
							$('#local_atendimento option[value="'+json[0].id+'"]').prop("selected", true);
							$('#endereco_id').val(json[0].id);
						}
						
					}
	            },
	            error: function (result) {
	            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
	            }
	    	});
		}else{
			jQuery.ajax({
				type: 'POST',
				url: '/consulta-tipos-checkup',
				data: {
					'tipo_atendimento': $('select[name="tipo_especialidade"]').val(),
					'_token': laravel_token
				},
				success: function (result) {
					if( result != null) {
						var json = result;
						
						$('#local_atendimento').empty();
						var option = '<option value="TODOS">TODOS</option>';
						$('#local_atendimento').append($(option));
						
						for(var i=0; i < json.length; i++) {
							option = '<option value="'+json[i].tipo+'">'+json[i].tipo+'</option>';
							$('#local_atendimento').append($(option));
						}
						
						if(json.length > 0) {
							$('#local_atendimento option[value="'+json[0].tipo+'"]').prop("selected", true);
							$('#endereco_id').val(json[0].tipo);
						}									
					}
				},
				error: function (result) {
					$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
				}
			});
		}
	});
	
	$('#local_atendimento').change(function(){
		
		var endereco_id = $(this).val();
		
		if(endereco_id == '') { return false; }
		
		$('#endereco_id').val(endereco_id);
	});
	
	$('#selectCartaoCredito').change(function(){
		
		if($(this).val() != '') {
			
			var cartao_id = $(this).val();
			
			jQuery.ajax({
	    		type: 'POST',
	    	  	url: '/consulta-cartao-paciente',
	    	  	data: {
					'cartao_id': cartao_id,
					'_token': laravel_token
				},
				success: function (result) {

					if(result) {
						var json = result.cartao;
						$('#inputNomeSaveCard').val(json.nome_impresso);
						$('#inputNumFinalSaveCard').val(json.numero);
						$('#inputExpirationDateSaveCard').val(json.dt_validade);
						$('#inputBrandSaveCard').val(json.bandeira);
						$('#inputSaveCardId').val(json.id);
						
						$('.row-payment-card').css('display', 'none');
						$('.row-payment.repayment').css('display', 'flex');
						$('.row-card-token').css('display', 'flex');


						$('#resumo_compra_final_cartao').html( $('#inputNumFinalSaveCard').val() );
					}
					else {
						$('.row-payment.repayment').css('display', 'none');
						$('#resumo_compra_final_cartao').html( 'XXXX' );	
					}
	            },
	            error: function (result) {
	            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
	            }
	    	});
		} else {
			$('.row-payment-card').css('display', 'flex');
			$('.row-card-token').css('display', 'none');
			$('.row-payment.repayment').css('display', 'flex');
			$('#resumo_compra_final_cartao').html( 'XXXX' );	
		}
	});
	
});

function pagarCartaoCredito() {
	var result = true;
	var numero_cartao 	= $('#inputNumeroCartaoCredito');
	var nome_impresso 	= $('#inputNomeCartaoCredito');
	var mes_credito 	= $('#selectValidadeMesCredito');
	var ano_credito 	= $('#selectValidadeAnoCredito');
	var cod_seg 		= $('#inputCodigoCredito');
	var cpf_titular 	= $('#inputCPFCredito');
	var parcelamento 	= $('#selectParcelamentoCredito');
	var cupom_desconto 	= $('#inputCupom');
	var pacientes		= $('.paciente_agendamento_id');
	
	if(numero_cartao.val().length < 16) {
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
	
	pacientes.each(function(){
		
		if($(this).val() == '0') {
			
			swal(
		        {
		            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DrHoje: informa!</div>',
		            text: 'É necessário Definir o Paciente em cada Atendimento para poder Finalizar o Pedido!'
		        }
		    );
			
			result = false;
		}
	});
	
	var num_itens = $('.card-resumo-compra').length;
	var agendamentos = [];
	
	for(var i = 0; i < num_itens; i++) {
		var dt_atendimento = $('#dt_atendimento_'+i).val()+' '+ $('#hr_atendimento_'+i).val();
		var profissional_id_temp = $('#profissional_id_'+i).val();
		var atendimento_id_temp = $('#atendimento_id_'+i).val();
		var checkup_id_temp = $('#checkup_id_'+i).val();
		var clinica_id_temp = $('#clinica_id_'+i).val();
		var filial_id_temp = $('#filial_id_'+i).val();
		
		if(typeof profissional_id_temp === 'undefined') {
			profissional_id_temp = 'null';
		}
		
		var dt_atendimento_temp = $('#dt_atendimento_'+i).val();
		
		if(typeof dt_atendimento_temp === 'undefined') dt_atendimento = 'null';
		if(typeof atendimento_id_temp === 'undefined') atendimento_id_temp = 'null';
		if(typeof checkup_id_temp === 'undefined') checkup_id_temp = 'null';
		if(typeof clinica_id_temp === 'undefined') clinica_id_temp = 'null';
		if(typeof filial_id_temp === 'undefined') filial_id_temp = 'null';

		var paciente_agendamento_id = $('#paciente_id_'+i).val();
		
		var item = '{"dt_atendimento":"'+dt_atendimento+'","paciente_id":'+paciente_agendamento_id+',"clinica_id":'+
			clinica_id_temp+',"filial_id":'+ filial_id_temp+',"atendimento_id":'+ atendimento_id_temp+',"profissional_id":'+
			profissional_id_temp+',"checkup_id":'+ checkup_id_temp+'}';
		agendamentos.push(item);
	}
	
	$('#btn-finalizar-pedido').attr('disabled', 'disabled');
    $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('Processando... <i class="fa fa-spin fa-spinner" style="float: right; font-size: 16px;"></i>');
    setTimeout(function(){ $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>'); $('#btn-finalizar-pedido').removeAttr('disabled'); }, 30000);
	
	var tipo_pagamento = $('#selectFormaPagamento').val();
	var titulo_pedido = $('#titulo_pedido').val();
	var paciente_id = $('#paciente_id').val();
	
	var num_cartao_credito = numero_cartao.val();
	var nome_impresso_cartao_credito = nome_impresso.val();
	var mes_cartao_credito = mes_credito.val();
	var ano_cartao_credito = ano_credito.val();
	var cod_seg_cartao_credito = cod_seg.val();
	var gravar_cartao_credito = $('#checkGravarCartaoCredito').is(':checked') ? 'on' : 'off';
	var bandeira_cartao_credito = $('#inputBandeiraCartaoCredito').val();
	var cod_cupom_desconto = $('#inputCupom').val();
	var num_parcela_selecionado = $('#selectParcelamentoCredito2').is(':visible') ? $('#selectParcelamentoCredito2').val() : $('#selectParcelamentoCredito').val();

	console.log(num_parcela_selecionado);
	
	if(!result) {
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Por favor, verifique os campos e tente novamente.');
		swal(
				{
                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                    text: 'Por favor, verifique os campos e tente novamente.'
                }
            );
		$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
      	$('#btn-finalizar-pedido').removeAttr('disabled');
		
		return false;
	}
	
	$.ajax({
		type:'post',
		   dataType:'json',
		   url: '/finalizar_pedido',
		   data: {
			   'tipo_pagamento': tipo_pagamento,
			   'titulo_pedido': titulo_pedido,
			   'paciente_id': paciente_id,
			   'num_cartao': num_cartao_credito,
			   'nome_impresso_cartao': nome_impresso_cartao_credito,
			   'mes_cartao': mes_cartao_credito,
			   'ano_cartao': ano_cartao_credito,
			   'cod_seg_cartao': cod_seg_cartao_credito,
			   'gravar_cartao': gravar_cartao_credito,
			   'bandeira_cartao': bandeira_cartao_credito,
			   'cod_cupom_desconto': cod_cupom_desconto,
			   'num_parcela_selecionado': num_parcela_selecionado,
			   'agendamentos': agendamentos,
			   '_token': laravel_token
		   },
		   timeout: 15000,
		   success: function (result) {

			  if(result.status) {
				  $.Notification.notify('success','top right', 'DrHoje', result.mensagem);
				  window.location.href='/concluir_pedido';
			  } else {
//				  $.Notification.notify('error','top right', 'DrHoje', result.mensagem);
				  swal(
							{
			                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje: Ocorreu um erro</div>',
			                    text: result.mensagem
			                }
			            );
				  $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
				  $('#btn-finalizar-pedido').removeAttr('disabled');
			  }
		  },
		  error: function (result) {
			  swal(
						{
		                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje</div>',
		                    text: 'Falha na operação!'
		                }
		            );
          	$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
          	$('#btn-finalizar-pedido').removeAttr('disabled');
          }
	});
		
	return result;
}

function pagarCartaoDebito() {
	
	var result = true;
	var numero_cartao 	= $('#inputNumeroCartaoDebito');
	var nome_impresso 	= $('#inputNomeCartaoDebito');
	var mes_debito 		= $('#selectValidadeMesDebito');
	var ano_debito 		= $('#selectValidadeAnoDebito');
	var cod_seg 		= $('#inputCodigoDebito');
	var cpf_titular 	= $('#inputCPFDebito');
	var cupom_desconto 	= $('#inputCupom');
	var pacientes		= $('.paciente_agendamento_id');
	
	if(numero_cartao.val().length < 16) {
		numero_cartao.parent().addClass('cvx-has-error');
		numero_cartao.parent().append('<span class="help-block text-danger"><strong>Este Cartão não é válido</strong></span>');
		
		$('#inputNumeroCartaoDebito').keypress(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(nome_impresso.val().length == 0) {
		nome_impresso.parent().addClass('cvx-has-error');
		nome_impresso.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
		
		$('#inputNomeCartaoDebito').keypress(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(mes_debito.val().length == 0) {
		mes_debito.parent().addClass('cvx-has-error');
		mes_debito.parent().append('<span class="help-block text-danger"><strong>Mês Cartão</strong></span>');
		
		$('#selectValidadeMesDebito').change(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(ano_debito.val().length == 0) {
		ano_debito.parent().addClass('cvx-has-error');
		ano_debito.parent().append('<span class="help-block text-danger"><strong>Ano Cartão</strong></span>');
		
		$('#selectValidadeAnoDebito').change(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(cod_seg.val().length == 0) {
		cod_seg.parent().addClass('cvx-has-error');
		cod_seg.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
		
		$('#inputCodigoDebito').keypress(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(cpf_titular.val().length == 0) {
		cpf_titular.parent().addClass('cvx-has-error');
		cpf_titular.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
		
		$('#inputCPFDebito').keypress(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	pacientes.each(function(){
		
		if($(this).val() == '0') {
			
			swal(
		        {
		            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DrHoje: informa!</div>',
		            text: 'É necessário Definir o Paciente em cada Atendimento para poder Finalizar o Pedido!'
		        }
		    );
			
			result = false;
		}
	});	
	
	var num_itens = $('.card-resumo-compra').length;
	var agendamentos = [];
	
	for(var i = 0; i < num_itens; i++) {
		var dt_atendimento = $('#dt_atendimento_'+i).val()+' '+ $('#hr_atendimento_'+i).val();
		var profissional_id_temp = $('#profissional_id_'+i).val();
		var atendimento_id_temp = $('#atendimento_id_'+i).val();
		var checkup_id_temp = $('#checkup_id_'+i).val();
		var clinica_id_temp = $('#clinica_id_'+i).val();
		var filial_id_temp = $('#filial_id_'+i).val();

		if(typeof profissional_id_temp === 'undefined') {
			profissional_id_temp = 'null';
		}

		var dt_atendimento_temp = $('#dt_atendimento_'+i).val();

		if(typeof dt_atendimento_temp === 'undefined') dt_atendimento = 'null';
		if(typeof atendimento_id_temp === 'undefined') atendimento_id_temp = 'null';
		if(typeof checkup_id_temp === 'undefined') checkup_id_temp = 'null';
		if(typeof clinica_id_temp === 'undefined') clinica_id_temp = 'null';
		if(typeof filial_id_temp === 'undefined') filial_id_temp = 'null';

		var paciente_agendamento_id = $('#paciente_id_'+i).val();

		var item = '{"dt_atendimento":"'+dt_atendimento+'","paciente_id":'+paciente_agendamento_id+',"clinica_id":'+
			clinica_id_temp+',"filial_id":'+ filial_id_temp+',"atendimento_id":'+ atendimento_id_temp+',"profissional_id":'+
			profissional_id_temp+',"checkup_id":'+ checkup_id_temp+'}';
		agendamentos.push(item);
	}
	
	$('#btn-finalizar-pedido').attr('disabled', 'disabled');
    $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('Processando... <i class="fa fa-spin fa-spinner" style="float: right; font-size: 16px;"></i>');
    setTimeout(function(){ $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>'); $('#btn-finalizar-pedido').removeAttr('disabled'); }, 30000);
	
	var tipo_pagamento = $('#selectFormaPagamento').val();
	var titulo_pedido = $('#titulo_pedido').val();
	var paciente_id = $('#paciente_id').val();
	
	var num_cartao_debito = numero_cartao.val();
	var nome_impresso_cartao_debito = nome_impresso.val();
	var mes_cartao_debito = mes_debito.val();
	var ano_cartao_debito = ano_debito.val();
	var cod_seg_cartao_debito = cod_seg.val();
	var bandeira_cartao_debito = $('#inputBandeiraCartaoDebito').val();
	var cod_cupom_desconto = $('#inputCupom').val();
	
	if(!result) {
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Por favor, verifique os campos e tente novamente.');
		swal(
				{
                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                    text: 'Por favor, verifique os campos e tente novamente.'
                }
            );
		$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
      	$('#btn-finalizar-pedido').removeAttr('disabled');
		
		return false;
	}
	
	$.ajax({
		type:'post',
		   dataType:'json',
		   url: '/finalizar_pedido',
		   data: {
			   'tipo_pagamento': tipo_pagamento,
			   'titulo_pedido': titulo_pedido,
			   'paciente_id': paciente_id,
			   'num_cartao': num_cartao_debito,
			   'nome_impresso_cartao': nome_impresso_cartao_debito,
			   'mes_cartao': mes_cartao_debito,
			   'ano_cartao': ano_cartao_debito,
			   'cod_seg_cartao': cod_seg_cartao_debito,
			   'bandeira_cartao': bandeira_cartao_debito,
			   'cod_cupom_desconto': cod_cupom_desconto,
			   'agendamentos': agendamentos,
			   '_token': laravel_token
		   },
		   timeout: 15000,
		   success: function (result) {

			  if(result.status) {
				  $.Notification.notify('success','top right', 'DrHoje', result.mensagem);
				  window.location.href='/concluir_pedido';
			  } else {
				  swal(
							{
			                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje: Ocorreu um erro</div>',
			                    text: result.mensagem
			                }
			            );
				  $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
				  $('#btn-finalizar-pedido').removeAttr('disabled');
			  }
		  },
		  error: function (result) {
//          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
			swal(
						{
		                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje</div>',
		                    text: 'Falha na operação!'
		                }
		            );
          	$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
          	$('#btn-finalizar-pedido').removeAttr('disabled');
          }
	});
	
	return result;
}

function pagarCartaoCadastrado() {
	
	var result = true;
	var cartao_id 		= $('#selectCartaoCredito');
	var nome_impresso 	= $('#inputNomeSaveCard');
	var final_cartao 	= $('#inputNumFinalSaveCard');
	var dt_validade 	= $('#inputExpirationDateSaveCard');
	var cod_seg 		= $('#inputCodigoSegSaveCard');
	var parcelamento 	= $('#selectParcelamentoCredito');
	var cupom_desconto 	= $('#inputCupom');
	var pacientes		= $('.paciente_agendamento_id');
	
	if(cartao_id.val().length == 0) {
		cartao_id.parent().addClass('cvx-has-error');
		cartao_id.parent().append('<span class="help-block text-danger"><strong>Nenhum Cartão foi selecionado</strong></span>');
		
		$('#selectCartaoCredito').change(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	if(cod_seg.val().length == 0) {
		cod_seg.parent().addClass('cvx-has-error');
		cod_seg.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
		
		$('#inputCodigoSegSaveCard').keypress(function(){
			$(this).parent().removeClass('cvx-has-error');
			$(this).parent().find('span.help-block').remove();
		});
		
		result = false;
	}
	
	pacientes.each(function(){
		
		if($(this).val() == '0') {
			
			swal(
		        {
		            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DrHoje: informa!</div>',
		            text: 'É necessário Definir o Paciente em cada Atendimento para poder Finalizar o Pedido!'
		        }
		    );
			
			result = false;
		}
	});
	
	var num_itens = $('.card-resumo-compra').length;
	var agendamentos = [];
	
	for(var i = 0; i < num_itens; i++) {
		var dt_atendimento = $('#dt_atendimento_'+i).val()+' '+ $('#hr_atendimento_'+i).val();
		var profissional_id_temp = $('#profissional_id_'+i).val();
		var atendimento_id_temp = $('#atendimento_id_'+i).val();
		var checkup_id_temp = $('#checkup_id_'+i).val();
		var clinica_id_temp = $('#clinica_id_'+i).val();
		var filial_id_temp = $('#filial_id_'+i).val();

		if(typeof profissional_id_temp === 'undefined') {
			profissional_id_temp = 'null';
		}

		var dt_atendimento_temp = $('#dt_atendimento_'+i).val();

		if(typeof dt_atendimento_temp === 'undefined') dt_atendimento = 'null';
		if(typeof atendimento_id_temp === 'undefined') atendimento_id_temp = 'null';
		if(typeof checkup_id_temp === 'undefined') checkup_id_temp = 'null';
		if(typeof clinica_id_temp === 'undefined') clinica_id_temp = 'null';
		if(typeof filial_id_temp === 'undefined') filial_id_temp = 'null';

		var paciente_agendamento_id = $('#paciente_id_'+i).val();

		var item = '{"dt_atendimento":"'+dt_atendimento+'","paciente_id":'+paciente_agendamento_id+',"clinica_id":'+
			clinica_id_temp+',"filial_id":'+ filial_id_temp+',"atendimento_id":'+ atendimento_id_temp+',"profissional_id":'+
			profissional_id_temp+',"checkup_id":'+ checkup_id_temp+'}';
		agendamentos.push(item);
	}
	
	$('#btn-finalizar-pedido').attr('disabled', 'disabled');
    $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('Processando... <i class="fa fa-spin fa-spinner" style="float: right; font-size: 16px;"></i>');
    setTimeout(function(){ $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>'); $('#btn-finalizar-pedido').removeAttr('disabled'); }, 30000);
	
	var tipo_pagamento = 'cadastrado';
	var titulo_pedido = $('#titulo_pedido').val();
	var paciente_id = $('#paciente_id').val();
	
	var cartao_paciente = cartao_id.val();
	var nome_impresso_cartao_credito = nome_impresso.val();
	var final_cartao_credito = final_cartao.val();
	var validade_cartao_credito = dt_validade.val();
	var cod_seg_cartao_credito = cod_seg.val();
	var cod_cupom_desconto = $('#inputCupom').val();
	var num_parcela_selecionado = $('#selectParcelamentoCredito2').is(':visible') ? $('#selectParcelamentoCredito2').val() : $('#selectParcelamentoCredito').val();

	console.log(num_parcela_selecionado);
	
	if(!result) {
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Por favor, verifique os campos e tente novamente.');
		swal(
				{
                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                    text: 'Por favor, verifique os campos e tente novamente.'
                }
            );
		$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
      	$('#btn-finalizar-pedido').removeAttr('disabled');
		
		return false;
	}
	
	$.ajax({
		type:'post',
		   dataType:'json',
		   url: '/finalizar_pedido_cartao_cadastrado',
		   data: {
			   'tipo_pagamento': tipo_pagamento,
			   'titulo_pedido': titulo_pedido,
			   'paciente_id': paciente_id,
			   'cartao_paciente': cartao_paciente,
			   'nome_impresso_cartao': nome_impresso_cartao_credito,
			   'final_cartao_credito': final_cartao_credito,
			   'validade_cartao_credito': validade_cartao_credito,
			   'cod_seg_cartao': cod_seg_cartao_credito,
			   'cod_cupom_desconto': cod_cupom_desconto,
			   'agendamentos': agendamentos,
			   'num_parcela_selecionado': num_parcela_selecionado,
			   '_token': laravel_token
		   },
		   timeout: 15000,
		   success: function (result) {

			  if(result.status) {
				  $.Notification.notify('success','top right', 'DrHoje', result.mensagem);
				  window.location.href='/concluir_pedido';
			  } else {
//				  $.Notification.notify('info','top right', 'DrHoje', result.mensagem);
				  swal(
		                    {
		                        title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i> Informação</div>',
		                        text: result.mensagem
		                    }
		                );
				  $('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
		          $('#btn-finalizar-pedido').removeAttr('disabled');
			  }
		  },
		  error: function (result) {
//          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
		  swal(
					{
	                    title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje</div>',
	                    text: 'Falha na operação!'
	                }
	            );
          	$('#btn-finalizar-pedido').find('#lbl-finalizar-pedido').html('FINALIZAR PAGAMENTO <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
          	$('#btn-finalizar-pedido').removeAttr('disabled');
          }
	});
	
	return result;
}

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
//          	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
			  swal(
					  {
						  title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i>DrHoje</div>',
						  text: 'Falha na operação!'
					  }
		       	);
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

function pad(n){
    return n > 9 ? "" + n: "0" + n;
}

function validaBuscaAtendimento() {
	var tipo_atendimento = $('#tipo_atendimento');
	var tipo_especialidade = $('#tipo_especialidade');
	var local_atendimento = $('#local_atendimento');
	var endereco_id = $('#endereco_id');
	
	if( tipo_atendimento.val().length == 0 ) {
		
		tipo_atendimento.parent().addClass('cvx-has-error');
		tipo_atendimento.focus();
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Selecione o Tipo de Atentimento');
		swal(
				  {
					  title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i>DrHoje: Solicitação Falhou!</div>',
					  text: 'Selecione o Tipo de Atendimento para Prosseguir'
				  }
	       	);
		
		$('.cvx-has-error .form-control').change(function(){
			$(this).parent().removeClass('cvx-has-error');
		});
		
		return false;
	}
	
	if( tipo_especialidade.val().length == 0 ) {
		tipo_especialidade.parent().addClass('cvx-has-error');
		tipo_especialidade.focus();
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Selecione a Especialidade ou Exame');
		swal(
				  {
					  title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i>DrHoje: Solicitação Falhou!</div>',
					  text: 'Selecione a Especialidade/Exame para Prosseguir'
				  }
	       	);
		
		$('.cvx-has-error .form-control').change(function(){
			$(this).parent().removeClass('cvx-has-error');
		});
		
		return false;
	}
	

	if( $('#tipo_atendimento').val() != 'checkup' && local_atendimento.val().length == 0 | endereco_id.val().length == 0 ) {
		endereco_id.parent().addClass('cvx-has-error');
		endereco_id.focus();
//		$.Notification.notify('error','top right', 'Solicitação Falhou!', 'Endereço não localizado. Por favor, tente novamente.');
		swal(
				  {
					  title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i>DrHoje: Solicitação Falhou!</div>',
					  text: 'Endereço não localizado. Por favor, tente novamente.'
				  }
	       	);
		
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