window.onload = function() {
	var startPos;
	var drhj_latitude = 0;
	var drhj_longitude = 0;
	var geoOptions = {
		timeout: 30 * 1000
	}

	  var geoSuccess = function(position) {
	    startPos 	   = position;
	    user_latitude  = startPos.coords.latitude;
	    user_longitude = startPos.coords.longitude;
	  };
	  var geoError = function(error) {
	    console.log('Error occurred. Error code: ' + error.code);
	    // error.code can be:
	    //   0: unknown error
	    //   1: permission denied
	    //   2: position unavailable (error response from location provider)
	    //   3: timed out
	    if(error.code == 0) {
	    	
	    	var drhj_googlemaps_key = 'AIzaSyCkovLYQa6lqh1suWtV_ZFJ0i9ChWc9hqI';
	    	jQuery.ajax({
	    		type: 'GET',
	    	  	url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+drhj_latitude+','+drhj_longitude+'&key='+drhj_googlemaps_key,
	    	  	data: {},
				success: function (result) {
					codeLatLng(result);
	            },
	            error: function (result) {
	            	$.Notification.notify('error','top right', 'DrHoje', 'Falha no carregamento da sua localização!');
	            }
	    	});
	    }
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
        $('#ds_uf_localizacao').html(ds_uf_localizacao);
    }

    $('#sg_estado_localizacao').change(function(){
        var sg_estado = $(this).val();
        docCookies.setItem('uf_localizacao', sg_estado);
        $('#sg_estado_localizazao_form').val(sg_estado);
    });
}

function codeLatLng(results) {
	
	console.log(results)
    if (results[1]) {
      //formatted address
      alert(results[0].formatted_address)
      //find country name
      for (var i=0; i<results[0].address_components.length; i++) {
          for (var b=0; b<results[0].address_components[i].types.length;b++) {

            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
              if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                  //this is the object you are looking for
                  city= results[0].address_components[i];
                  break;
              }
          }
      }
      //city data
      alert(city.short_name + " " + city.long_name)


      } else {
        alert("No results found");
      }
}