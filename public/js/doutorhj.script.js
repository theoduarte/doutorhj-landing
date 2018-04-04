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
						var option = '<option value="'+json[i].id+'" tipo="'+json[i].tipo+'">'+json[i].descricao+'</option>';
						$('#tipo_especialidade').append($(option));
					}
					
				}
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
            }
    	});
		
	});
	
	$(".select2").select2();
	
	$( "#local_atendimento" ).keyup(function() {
		
		var search_term = $(this).val();
		if(search_term.length < 3){ return false; }
		
		var tipo_atendimento = $('#tipo_atendimento').val();
		var procedimento_id = $('#tipo_especialidade').val();
		var tipo_especialidade = $('#tipo_especialidade').attr('tipo');
		
    	jQuery.ajax({
    		type: 'POST',
    	  	url: '/consulta-local-atendimento',
    	  	data: {
				'search_term': search_term,
				'tipo_atendimento': tipo_atendimento,
				'procedimento_id': procedimento_id,
				'tipo_especialidade': tipo_especialidade,
				'_token': laravel_token
			},
			success: function (result) {

				if( result != null) {
					var json = JSON.parse(result.endereco);
					
				}
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
            }
    	});
	});
	
});