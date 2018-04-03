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
				$( this ).addClass( "done" );

				if( result != null) {
					var json = JSON.parse(result.endereco);

					$('#te_endereco').val(json.logradouro);
					$('#te_bairro').val(json.bairro);
					$('#nm_cidade').val(json.cidade);
					$('#sg_estado').val(json.estado);
					$('#cd_cidade_ibge').val(json.ibge);
					$('#nr_latitude_gps').val(json.latitude);
					$('#nr_longitute_gps').val(json.longitude);
					
				} else {

					$('#te_endereco').val('');
					$('#te_bairro').val('');
					$('#nm_cidade').val('');
					$('#sg_estado').val('');
					$('#cd_cidade_ibge').val('');
					$('#sg_logradouro').prop('selectedIndex',0);
					$('#nr_latitude_gps').val('');
					$('#nr_longitute_gps').val('');
				}
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
            }
    	});
		
	});
	
	$( "#list_especialidade" ).blur(function() {
    	jQuery.ajax({
    		type: 'GET',
    	  	url: '/consulta-cep/cep/'+this.value,
    	  	data: {
				'nr_cep': this.value,
				'_token': laravel_token
			},
			success: function (result) {
				$( this ).addClass( "done" );

				if( result != null) {
					var json = JSON.parse(result.endereco);

					$('#te_endereco').val(json.logradouro);
					$('#te_bairro').val(json.bairro);
					$('#nm_cidade').val(json.cidade);
					$('#sg_estado').val(json.estado);
					$('#cd_cidade_ibge').val(json.ibge);
					$('#nr_latitude_gps').val(json.latitude);
					$('#nr_longitute_gps').val(json.longitude);
					
				} else {

					$('#te_endereco').val('');
					$('#te_bairro').val('');
					$('#nm_cidade').val('');
					$('#sg_estado').val('');
					$('#cd_cidade_ibge').val('');
					$('#sg_logradouro').prop('selectedIndex',0);
					$('#nr_latitude_gps').val('');
					$('#nr_longitute_gps').val('');
				}
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha na operação!');
            }
    	});
	});
	
});