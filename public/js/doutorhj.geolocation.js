window.onload = function() {
	var startPos;
	  var geoOptions = {
	     timeout: 30 * 1000
	  }

	  var geoSuccess = function(position) {
	    startPos = position;
	    document.getElementById('startLat').value = startPos.coords.latitude;
	    document.getElementById('startLon').value = startPos.coords.longitude;
	  };
	  var geoError = function(error) {
	    console.log('Error occurred. Error code: ' + error.code);
	    // error.code can be:
	    //   0: unknown error
	    //   1: permission denied
	    //   2: position unavailable (error response from location provider)
	    //   3: timed out
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