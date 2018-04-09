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
	
	$(".select2").select2();
	
	$( "#local_atendimento" ).keyup(function() {
		
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
	});
	
});