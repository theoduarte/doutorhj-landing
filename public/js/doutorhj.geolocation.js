window.onload = function() {
	var startPos;
	var drhj_latitude = 0;
	var drhj_longitude = 0;
	var geoOptions = {
		timeout: 30 * 1000
	}

	  var geoSuccess = function(position) {
	    startPos 	   = position;
	    drhj_latitude  = startPos.coords.latitude;
	    drhj_longitude = startPos.coords.longitude;
	    
	    var drhj_googlemaps_key = 'AIzaSyCkovLYQa6lqh1suWtV_ZFJ0i9ChWc9hqI';
	    
	    var uf_localizacao = docCookies.getItem('uf_localizacao');
	    
	    jQuery.ajax({
    		type: 'GET',
    	  	url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+drhj_latitude+','+drhj_longitude+'&key='+drhj_googlemaps_key,
    	  	data: {},
			success: function (result) {
				var uf_localizacao = getUFfromGooglemaps(result);
				
				var uf_localizacao_cookie = docCookies.getItem('uf_localizacao');
				var uf_escolha_manual = docCookies.getItem('uf_escolha_manual');
				
				if(uf_escolha_manual != '1' & (uf_localizacao != uf_localizacao_cookie)) {
					
					swal({
						title: 'DoutorHoje: Alerta!',
		                text: 'Sua localização atual (<strong>'+uf_localizacao+'</strong>) é diferente da localização (<strong>'+uf_localizacao_cookie+'</strong>) escolhida. Você deseja mudar?',
		                type: 'warning',
		                showCancelButton: true,
		                confirmButtonClass: 'btn btn-confirm mt-2',
		                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
		                confirmButtonText: 'Sim',
		                cancelButtonText: 'NÃO'
		    	   }).then(function(result) {
		    	    	if(result.dismiss == 'cancel') {
		    	    		uf_escolha_manual = 1;
		    	    		docCookies.setItem('uf_escolha_manual', 1);
		    	    		
		    	        } else {

		    	        	$('#sg_estado_localizacao').val(uf_localizacao);
		    				docCookies.setItem('uf_localizacao', uf_localizacao);
		    		        $('#sg_estado_localizazao_form').val(uf_localizacao);
		    		        
		    		        var ds_uf_localizacao = getDescricaoFromUf(uf_localizacao);
		                    $('#ds_uf_localizacao').html(ds_uf_localizacao);
		    	        }
		    	    });
				} else {
					docCookies.setItem('uf_escolha_manual', 0);
					$('#sg_estado_localizacao').val(uf_localizacao);
    				docCookies.setItem('uf_localizacao', uf_localizacao);
    		        $('#sg_estado_localizazao_form').val(uf_localizacao);
    		        
    		        var ds_uf_localizacao = getDescricaoFromUf(uf_localizacao);
                    $('#ds_uf_localizacao').html(ds_uf_localizacao);
				}
//				var uf_escolha_manual = docCookies.getItem('uf_escolha_manual');
				
//				if(uf_escolha_manual == '1') {
//					uf_localizacao = uf_localizacao_cookie;
//				}
				
//				$('#sg_estado_localizacao').val(uf_localizacao);
//				docCookies.setItem('uf_localizacao', uf_localizacao);
//		        $('#sg_estado_localizazao_form').val(uf_localizacao);
//		        
//		        var ds_uf_localizacao = getDescricaoFromUf(uf_localizacao);
//                $('#ds_uf_localizacao').html(ds_uf_localizacao);
            },
            error: function (result) {
            	$.Notification.notify('error','top right', 'DrHoje', 'Falha no carregamento da sua localização!');
            }
    	});
	    
	    if(uf_localizacao != null) {
	    	var ds_uf_localizacao = getDescricaoFromUf(uf_localizacao);
	    	$('#sg_estado_localizacao').select2('data', { id: uf_localizacao, text: ds_uf_localizacao});
	        $('#ds_uf_localizacao').html(ds_uf_localizacao);
	    }
    	
	  };
	  var geoError = function(error) {
	    console.log('Error occurred. Error code: ' + error.code);
	    // error.code can be:
	    //   0: unknown error
	    //   1: permission denied
	    //   2: position unavailable (error response from location provider)
	    //   3: timed out
	    
	    if(error.code == 0) {
	    	docCookies.removeItem('uf_localizacao');
	    	$.Notification.notify('error','top right', 'DrHoje', 'Falha no carregamento da sua localização!');
	    }
//	    if(error.code == 3) {
//	    	docCookies.removeItem('uf_localizacao');
//	    }
	    if(error.code == 1 | error.code == 3) {
	    	showModalUfLocation();
	    }
	  };

	  navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
};

function showModalUfLocation() {
	
	$('.seleciona-estado').select2({
        width: '100%',
        language: {
            noResults: function (params) {
              return "Nenhum Estado encontrado!";
            }
          }
    });

    var uf_localizacao = docCookies.getItem('uf_localizacao');
    
    $('#sg_estado_localizacao').val(uf_localizacao);
    $('#sg_estado_localizazao_form').val(uf_localizacao);

    //alert(uf_localizacao);
    if(uf_localizacao === null) {
        
    	$('#modalEstado').modal({
            backdrop: 'static',
            keyboard: false,
        });
        
    } else {
    	var ds_uf_localizacao = $('#sg_estado_localizacao').select2('data')[0].text;
    	$('#sg_estado_localizacao').select2('data', { id: uf_localizacao, text: ds_uf_localizacao});
        $('#ds_uf_localizacao').html(ds_uf_localizacao);
    }

    $('#sg_estado_localizacao').change(function(){
        var sg_estado = $(this).val();
        docCookies.setItem('uf_localizacao', sg_estado);
        $('#sg_estado_localizazao_form').val(sg_estado);
    });
}

function getUFfromGooglemaps(input) {
	
	//console.log(input.results);
	var uf = 'SP';
	
	if(input.results.length > 0) {
		uf = input.results[4].address_components[5].short_name;
	}
	return uf; 
}

function getDescricaoFromUf(input) {
	
	var estados = {
			AC: 'Acre',
        AL: 'Alagoas',
        AP: 'Amapá',
        AM: 'Amazonas',
        BA: 'Bahia',
        CE: 'Ceará',
        DF: 'Distrito Federal',
        ES: 'Espírito Santo',
        GO: 'Goiás',
        MA: 'Maranhão',
        MT: 'Mato Grosso',
        MS: 'Mato Grosso do Sul',
        MG: 'Minas Gerais',
        PA: 'Pará',
        PB: 'Paraíba',
        PR: 'Paraná',
        PE: 'Pernambuco',
        PI: 'Piauí',
        RJ: 'Rio de Janeiro',
        RN: 'Rio Grande do Norte',
        RS: 'Rio Grande do Sul',
        RO: 'Rondônia',
        RR: 'Roraima',
        SC: 'Santa Catarina',
        SP: 'São Paulo',
        SE: 'Sergipe',
        TO: 'Tocantins'
	};
	
	return estados[input];
}