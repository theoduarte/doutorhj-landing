@extends('layouts.base')
@section('title', 'DoutorHJ: Resultado')

@push('scripts')
@endpush

@section('content')
@if($errors->any())
    <div class="col-12 alert alert-danger">
        @foreach ($errors->all() as $error)<div class="col-5">{{ $error }}</div>@endforeach
    </div>
@endif
<section class="resultado">
    <div class="container">
        <div class="area-container">
            <div class="titulo">
                <strong>{{count($atendimentos)}} @if(count($atendimentos)>1)Resultados @else Resultado @endif da sua pesquisa</strong>
                <p>Após a escolha do prestador, indique a data e horário para realizar o seu agendamento.</p>
            </div>
            <div class="area-alt-busca">
                <a class="btn btn-primary btn-alt-busca" data-toggle="collapse" href="#collapseFormulario" role="button" aria-expanded="false" aria-controls="collapseFormulario">Alterar Busca <i class="fa fa-edit"></i></a>
            </div>
            <div class="collapseFormulario collapse show" id="collapseFormulario">
                <form action="/resultado" class="form-busca-resultado form-busca" method="get" onsubmit="return validaBuscaAtendimento()" >
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <select id="tipo_atendimento" class="form-control select2" name="tipo_atendimento">
                                <option value="" disabled selected hidden>Tipo de atendimento</option>

                                @foreach($tipoAtendimentos as $tipoAtendimento)
                                    <option value="{{ $tipoAtendimento->tag_value }}" @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == $tipoAtendimento->tag_value  ) selected='selected' @endif>{{ $tipoAtendimento->ds_atendimento }}</option>
                                @endforeach

                                @if( $hasActiveCheckup )
                                    <option value="checkup" @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == 'checkup' ) selected='selected' @endif>Checkups</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                <option value="" disabled selected hidden>Ex.: Clínica Médica</option>
                                @foreach($list_atendimentos as $atendimento)
                                    <option value="{{ $atendimento->id }}" @if( !empty($_GET['tipo_especialidade']) && $_GET['tipo_especialidade'] == $atendimento->id ) selected="selected" @endif>{{ $atendimento->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <select id="local_atendimento" class="form-control select2" name="local_atendimento">
                                <option selected hidden value="">TODOS OS LOCAIS</option>
                                @foreach($list_enderecos as $endereco)
                                <option value="{{ $endereco->id }}" @if( !empty($_GET['local_atendimento']) && $_GET['local_atendimento'] == $endereco->id ) selected="selected" @endif>{{ $endereco->te_bairro }} : {{ $endereco->nm_cidade }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <button type="submit" class="btn btn-primary btn-vermelho"><i class="fa fa-search"></i> Alterar Busca</button>
                        </div>
                    </div>
                </form> 
            </div>

            <div class="lista-resultado">
                <div class="row">
                    <div class="col-md-12 col-lg-5">
                        <div class="ordenar-por div-filtro">
                            <select class="form-control" id="ordenar" onchange="if($(this).val() != '') { window.location.href='{{ Request::url() }}?tipo_atendimento={{$_GET['tipo_atendimento']}}&local_atendimento={{$_GET['local_atendimento']}}&tipo_especialidade={{$_GET['tipo_especialidade']}}&sort='+$(this).val() }">
                                <option value="">Ordenar por...</option>
                                <option value="desc" @if( isset($_GET['sort']) && $_GET['sort'] == 'desc' ) selected="selected" @endif>Maior preço</option>
                                <option value="asc" @if( isset($_GET['sort']) && $_GET['sort'] == 'asc' ) selected="selected" @endif>Menor preço</option>
                            </select>
                        </div>
                        <div id="accordion">
                        	@foreach($atendimentos as $atendimento)
                            <div class="card card-resultado">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $atendimento->nm_fantasia }} - {{ $atendimento->tipo }}: {{ $atendimento->te_bairro }}</h5>

                                    <h6 class="card-subtitle">@if( !empty($atendimento->consulta_id) ) Dr. {{ $atendimento->nm_primario.' '.$atendimento->nm_secundario }} @endif</h6>
                                    
                                    <p class="card-text">{{ $atendimento->tag }}</p>
                                    
                                    <p class="card-text">{{ $atendimento->te_endereco.' ('.$atendimento->te_bairro.') '.$atendimento->nm_cidade.'-'.$atendimento->sg_estado }} <a class="link-mapa-mobile" href="https://goo.gl/maps/MPNHA8CLr812">Ver no mapa</a></p>
                                    
                                </div>
                                
                                <div class="card-footer">
                                    <div class="form-check area-seleciona-profissional">
                                        <input type="radio" id="inputProfissional_{{ $atendimento->id.$atendimento->filial_id }}" class="form-check-input" name="radioProfissional_{{ $atendimento->id.$atendimento->filial_id }}" data-toggle="collapse" data-target="#collapse_{{ $atendimento->id.$atendimento->filial_id }}" aria-expanded="false" aria-controls="collapse_{{ $atendimento->id.$atendimento->filial_id }}">
                                        <label class="form-check-label" for="inputProfissional_{{ $atendimento->id.$atendimento->filial_id }}">
                                        Agendar com este profissional
                                        </label>
                                    </div>
                                    <strong>R$ {{ number_format($atendimento->vl_comercial, 2, ',', '.') }}</strong>
                                </div>

                                <div id="collapse_{{ $atendimento->id.$atendimento->filial_id }}" class="collapse" aria-labelledby="heading_{{ $atendimento->id.$atendimento->filial_id }}" data-parent="#accordion">
                                	<form id="form-agendamento{{ $atendimento->id.$atendimento->filial_id }}" action="/agendar-atendimento" method="post">

                                		<input type="hidden" id="tipo_atendimento" name="tipo_atendimento" value="simples">
                                		<input type="hidden" id="atendimento_id" name="atendimento_id" value="{{ $atendimento->id }}">
                                    	<input type="hidden" id="profissional_id" name="profissional_id" value="@if( !empty($atendimento->consulta_id) ) {{ $atendimento->profissional_id }} @endif">
                                    	<input type="hidden" id="paciente_id" name="paciente_id" value="">
                                    	<input type="hidden" id="clinica_id" name="clinica_id" value="{{ $atendimento->clinica_id }}">
                                        <input type="hidden" id="filial_id" name="filial_id" value="{{ $atendimento->filial_id }}">
                                        
                                    	<input type="hidden" id="vl_com_atendimento" name="vl_com_atendimento" value="{{ $atendimento->vl_comercial }}">
                                    	<input type="hidden" name="current_url" value="{{ Request::fullUrl() }}">
                                    	{!! csrf_field() !!}
                                	
	                                    <div class="area-escolher-data">
	                                    	@if( !empty($atendimento->consulta_id) || $atendimento->tp_prestador == 'CLI')
	                                        <div class="titulo-escolhe-data">
	                                            Escolha data e horário
	                                        </div>
	                                        <div class="escolher-data">                                    
	                                            <input type="text" id="selecionaData{{ $atendimento->id }}" class="selecionaData mascaraDataAgendamento" name="data_atendimento" placeholder="Data" autocomplete="off" >
	                                            <label for="selecionaData{{ $atendimento->id }}"><i class="fa fa-calendar"></i></label>
	                                        </div>
	                                        <div class="escolher-hora">                                    
	                                            <input type="text" id="selecionaHora{{ $atendimento->id }}" class="selecionaHora mascaraHoraAgendamento" name="hora_atendimento" placeholder="Horário" autocomplete="off" >
	                                            <label for="selecionaHora{{ $atendimento->id }}"><i class="fa fa-clock-o"></i></label>
	                                        </div>
	                                        <div class="confirma-data">
	                                            <strong><span class="span-data"> -- NENHUMA DATA SELECIONADA -- </span><span class="span-hora"></span></strong>
	                                        </div>
	                                        <div class="mensagem-confirma-data">
	                                            <span>Data e horário sujeito a confirmação</span>
	                                        </div>
	                                        @else
	                                        <span><strong>{{ $atendimento->ds_procedimento }}</strong></span>
	                                        <hr>
	                                        @endif
	                                        <div class="valor-total">
	                                            <span><strong>Total a pagar:</strong> R$ {{ number_format( $atendimento->vl_comercial, 2, ',', '.') }}</span>
	                                        </div>
	                                        <button type="button" class="btn btn-primary btn-vermelho" onclick="validaAgendarAtendimento('form-agendamento{{ $atendimento->id.$atendimento->filial_id }}')">Prosseguir para pagamento</button>
	                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-mapa col-lg-7">
                        <div class="mapa-resultado">
                            <div id="map"></div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script type="text/javascript">        
            var laravel_token = '{{ csrf_token() }}';
            var resizefunc = []; 

            /*********************************
            *
            * CALENDARIO E DATA
            * 
            *********************************/

            jQuery.datetimepicker.setLocale('pt-BR');

            var today_date = new Date();
            var today_date_temp = new Date();
            var today_date_range = new Date();
            var min_date = today_date_temp.setDate(today_date.getDate() + 2);
            var max_date = today_date_range.setMonth(today_date_range.getMonth() + 2);
                
            jQuery('.selecionaData').datetimepicker({                
                timepicker:false,
                format:'d.m.Y',
                minDate: min_date,
                maxDate: max_date,
                beforeShowDay: function(date){ return [date.getDay() == 1 || date.getDay() == 2 || date.getDay() == 3 || date.getDay() == 4 || date.getDay() == 5,""]},
            }).on("input change", function(e){
            	//console.log("Date changed: ", e.target.value);
            	if(e.target.value != '') {
            		var ct_date_temp = ((e.target.value).replace('.', '-').replace('.', '-')).split('-');
                	var ct_date = new Date(ct_date_temp[2], ct_date_temp[1] - 1, ct_date_temp[0]);
                	var days = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];

                	if(ct_date.getDay() == 0 || ct_date.getDay() == 6) {
                		$(this).val('');
                		swal(
					        {
					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
					            text: 'Atendimento não disponível para ser Realizado aos Sábados e Domingos'
					        }
					    );
                	}
                	
                	jQuery(this).parent().parent().find('.confirma-data span.span-data').html((e.target.value).replace('.', '/').replace('.', '/')+"- "+days[ ct_date.getDay() ]+" - ");

                	if(ct_date <= today_date) {
                		$(this).val('');
                        console.log('change');
                		swal(
					        {
					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
					            text: 'A Data informada não está disponível para a Agendamento'
					        }
					    );
					    
                	}
            	}
            }).on("input blur", function(e){
            	//console.log("Date changed: ", e.target.value);
            	if(e.target.value != '') {
            		var ct_date_input = ((e.target.value).replace('.', '-').replace('.', '-')).split('-');
                	var ct_date = new Date(ct_date_input[2], ct_date_input[1] - 1, ct_date_input[0]);
                	
            		if(ct_date <= today_date) {
            			ct_date.setDate(today_date.getDate());
            			var ct_mes = pad((ct_date.getMonth()+1));
            			$(this).val('');
            			console.log('blur');
                        swal(
					        {
					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
					            text: 'A Data informada não está disponível para a Agendamento'
					        }
					    );
            		}

            		var ct_hora = jQuery(this).parent().parent().find('.selecionaHora').val();
            		if(ct_hora != '') {

                		var clinica_id 		= jQuery(this).parent().parent().parent().find('#clinica_id').val();
                		var profissional_id = jQuery(this).parent().parent().parent().find('#profissional_id').val();
                		var dt_agendamento = ct_date_input[2]+'-'+ct_date_input[1]+'-'+ct_date_input[0];
                		
                		if(clinica_id == '') { return false; }
                		if(profissional_id == '') { return false; }
                		
                		jQuery.ajax({
                    		type: 'POST',
                    	  	url: '/consulta-agendamento-disponivel',
                    	  	data: {
                				'clinica_id': clinica_id,
                    	  		'profissional_id': profissional_id,
                    	  		'data_agendamento': dt_agendamento,
                    	  		'hora_agendamento': ct_hora,
                				'_token': laravel_token
                			},
                			success: function (result) {

                				if( !result.status) {
                					swal(
            					        {
            					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
            					            text: result.mensagem
            					        }
            					    );
                				}
                            },
                            error: function (result) {
                            	swal(
                        	        {
                        	            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                        	            text: 'Falha na operação!'
                        	        }
                        	    );
                            }
                    	});
            		}
            	}
            });
            
            jQuery('.selecionaHora').datetimepicker({ 
                datepicker:false,
                format:'H:i',
                step: 30,
                minTime:'08:00',
                maxTime:'18:10',
            }).on("input change", function(e){
            	//console.log("Time changed: ", e.target.value);
            	if(e.target.value != '') {
	            	var ct_hora_temp = (e.target.value).split(':');
	            	var ct_date = jQuery('.selecionaData').parent().parent().find('.confirma-data span.span-data').html();
	            	var ct_date_input = (jQuery(this).parent().parent().find('.selecionaData').val()).split('.');
	            	jQuery(this).parent().parent().find('.confirma-data span.span-hora').html(ct_hora_temp[0]+"H"+ct_hora_temp[1]+"MIN");

	            	var ct_hora = ct_hora_temp[0]+':'+ct_hora_temp[1];
            		if(ct_hora != '') {

                		var clinica_id 		= jQuery(this).parent().parent().parent().find('#clinica_id').val();
                		var profissional_id = jQuery(this).parent().parent().parent().find('#profissional_id').val();
                		var dt_agendamento = ct_date_input[2]+'-'+ct_date_input[1]+'-'+ct_date_input[0];
                		
                		if(clinica_id == '') { return false; }
                		if(profissional_id == '') { return false; }
                		
                		jQuery.ajax({
                    		type: 'POST',
                    	  	url: '/consulta-agendamento-disponivel',
                    	  	data: {
                				'clinica_id': clinica_id,
                    	  		'profissional_id': profissional_id,
                    	  		'data_agendamento': dt_agendamento,
                    	  		'hora_agendamento': ct_hora,
                				'_token': laravel_token
                			},
                			success: function (result) {

                				if( !result.status) {
                					swal(
            					        {
            					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
            					            text: result.mensagem
            					        }        
            					    );
                				}
                            },
                            error: function (result) {
                            	swal(
                        	        {
                        	            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                        	            text: 'Falha na operação!'
                        	        }
                        	    );
                            }
                    	});
            		}
            	}
            });
                
            jQuery('#selecionaData2').datetimepicker({                
                timepicker:false,
                format:'d.m.Y',
                minDate: min_date,
                maxDate: max_date,
                beforeShowDay: function(date){ return [date.getDay() == 1 || date.getDay() == 2 || date.getDay() == 3 || date.getDay() == 4 || date.getDay() == 5,""]}
            });
            jQuery('#selecionaHora2').datetimepicker({ 
                datepicker:false,
                format:'H:i',
                step: 30,
                minTime:'08:00',
                maxTime:'18:10',
            });
                
            /*********************************
            *
            * TROCA COR CARD AO CLICAR
            * 
            *********************************/

            $('.card-resultado').on('show.bs.collapse hide.bs.collapse', function (e) {
                if (e.type=='show') {
                    $(this).addClass("card-resultado-active");
                } else {
                    $(this).removeClass("card-resultado-active");
                }
            });  

            /*********************************
            *
            * COLLAPSE FORM BUSCA MOBILE
            * 
            *********************************/

            jQuery(document).ready(function($) {
            var alterClass = function() {
                var ww = document.body.clientWidth;
                if (ww < 975) {
                $('.collapseFormulario').removeClass('show');
                } else if (ww >= 975) {
                $('.collapseFormulario').addClass('show');
                };
            };
            $(window).resize(function(){
                alterClass();
            });
            //Fire it when the page first loads:
            alterClass();
            });

            function validaAgendarAtendimento(form_id) {
                console.log(form_id);
            	
            	var clinica_id 		= jQuery('#'+form_id).find('#clinica_id').val();
        		var profissional_id = jQuery('#'+form_id).find('#profissional_id').val();
        		
        		if(clinica_id == '') { return false; }
        		if(profissional_id != '') {
        			var ct_date_input = (jQuery('#'+form_id).find('.selecionaData').val()).split('.');
            		var dt_agendamento = ct_date_input[2]+'-'+ct_date_input[1]+'-'+ct_date_input[0];
            		var ct_hora = jQuery('#'+form_id).find('.selecionaHora').val();
           		}
        		if(profissional_id != '' && dt_agendamento == '') { return false; }
        		if(profissional_id != '' && ct_hora == '') { return false; }
        		
        		jQuery.ajax({
            		type: 'POST',
            	  	url: '/consulta-agendamento-disponivel',
            	  	data: {
        				'clinica_id': clinica_id,
            	  		'profissional_id': profissional_id,
            	  		'data_agendamento': dt_agendamento,
            	  		'hora_agendamento': ct_hora,
        				'_token': laravel_token
        			},
        			
        			success: function (result) {

        				if( !result.status) {
        					swal(
    					        {
    					            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
    					            text: result.mensagem
    					        }
    					    );

    					    return false;
        				} else {
        					jQuery('#'+form_id).submit();
            				return true;
        				}
                    },
                    error: function (result) {
                    	swal(
                	        {
                	            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                	            text: 'Falha na operação!'
                	        }
                	    );
                    	return false;
                    }
            	});
            	
            	
            	return false;
            }            

            /*********************************
            *
            * GOOGLE MAPS
            * 
            *********************************/

            function initMap() {
                var locations = [];
                var locais_google_maps = {!! json_encode($atendimentos) !!};
                var latitude_init = locais_google_maps[0].nr_latitude_gps;
                var longitude_init = locais_google_maps[0].nr_longitute_gps;

                for(var i = 0; i < locais_google_maps.length; i++) {
                    locais_google_maps[i].info = "<strong>" + locais_google_maps[i].nm_fantasia + " - " + locais_google_maps[i].tipo + ": " + locais_google_maps[i].nm_nome_fantasia + "</strong><br> " + locais_google_maps[i].te_endereco + "<br> " + locais_google_maps[i].te_bairro + " - " + locais_google_maps[i].nm_cidade + ", " + locais_google_maps[i].sg_estado + ", " + formatCep(locais_google_maps[i].nr_cep) + "<br>";

                    var item = [locais_google_maps[i].info, locais_google_maps[i].nr_latitude_gps, locais_google_maps[i].nr_longitute_gps, i];
                    locations.push(item);
                }

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: new google.maps.LatLng(latitude_init, longitude_init),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow({});

                var marker, i;

                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));

                    google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }

            function formatCep(v){
                v=v.replace(/D/g,"")
                v=v.replace(/^(\d{5})(\d)/,"$1-$2")
                return v
            }
	</script>
	
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkovLYQa6lqh1suWtV_ZFJ0i9ChWc9hqI&callback=initMap" type="text/javascript"></script>
@endpush

@endsection