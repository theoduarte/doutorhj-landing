@extends('layouts.base')
@section('title', 'DoctorHoje: Resultado')

@push('scripts')
	<script>
        $(document).ready(function () {
            var local_atendimento = '{{$local_atendimento}}';
            $('#tipo_especialidade').change();
			
            trataFormConsulta();
			
			// override
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
								parecer = (json[i].value == local_atendimento) ? 'selected' : null;

        						
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
        						parecer = (json[i].value == local_atendimento) ? 'selected' : null;

        						
        						$('#local_atendimento').empty();
        						var option = '<option value="TODOS" '+parecer+'>TODOS</option>';
        						$('#local_atendimento').append($(option));
        						
        						for(var i=0; i < json.length; i++) {
        							option = '<option value="'+json[i].tipo+'" '+parecer+'>'+json[i].tipo+'</option>';
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
        });
	</script>
@endpush

@section('content')
    <section class="resultado resultado-checkup">
        <div class="container">
            <div class="area-container">
                <div class="area-alt-busca">
                    <a class="btn btn-primary btn-alt-busc$consultaa" data-toggle="collapse" href="#collapseFormulario" role="button" aria-expanded="false" aria-controls="collapseFormulario">Alterar
                        Busca <i class="fa fa-edit"></i></a>
                </div>
                <div class="collapseFormulario collapse show" id="collapseFormulario">
                    <form action="/resultado-checkup" class="form-busca-resultado" method="get" onsubmit="return validaBuscaAtendimento()">
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                    <option value="" disabled selected hidden>Tipo de atendimento</option>
                                    <option value="saude"   @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == 'saude'   ) selected='selected' @endif >Consulta Médica</option>
                                    <option value="odonto"  @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == 'odonto'  ) selected='selected' @endif >Consulta Odontológica</option>
                                    <option value="exame"   @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == 'exame'   ) selected='selected' @endif >Exames</option>
                                    <option value="checkup" @if( isset($_GET['tipo_atendimento']) && $_GET['tipo_atendimento'] == 'checkup' ) selected='selected' @endif >Check-up</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="tipo_especialidade" class="form-control" name="tipo_especialidade">
                                    <option value="" disabled selected hidden>Especialidade</option>
                                    @foreach($checkup as $obj)
                                    	<option value="{{$obj->titulo}}" @if( isset($_GET['tipo_especialidade']) && $_GET['tipo_especialidade'] == $obj->titulo ) selected='selected' @endif>{{$obj->titulo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <select id="local_atendimento" class="form-control" name="local_atendimento">
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-3">
                                <button type="submit" class="btn btn-primary btn-vermelho"><i class="fa fa-search"></i>
                                    Alterar Busca
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="titulo">
                    <strong>{{count($consulta)}} resultados para Checkup</strong>
                    <p>Escolha abaixo um dos pacotes de exames para seu checkup</p>
                </div>
				<div class="lista">
                  <div class="accordion" id="accordionResultado">
      	  			@foreach( $consulta as $checkup )
                          <div class="card">
                              <div class="card-header" id="headingTres">
                                  <div class="resumo">
                                      <div class="row">
                                          <div class="col-md-6 col-lg-8 col-xl-9">
                                              <div class="resumo-pacote">
                                                  <h4>Checkup {{$checkup['titulo']}} {{$checkup['tipo']}} com {{$checkup['total_procedimentos']}} procedimentos</h4>
                                                  <span class="incluso">Incluso nesse pacote:</span>
                                                  <ul class="quantidade">
                                                  	@foreach( $checkup['total_camadas'] as $camada => $total )
                                                      <li><span>{{$total}}</span> {{$camada}}</li>
                                                      @endforeach
                                                  </ul>
                                                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$checkup['titulo']}}{{$checkup['tipo']}}" aria-expanded="true" aria-controls="collapseOne">
                                                      ver lista de procedimentos
                                                  </button>
                                              </div>
                                          </div>
                                          <div class="col-md-6 col-lg-4 col-xl-3">
                                              <div class="valores">
                                                  <div class="mercado">
                                                      <p>Valor de mercado</p>
                                                      <span>R$ {{$checkup['total_vl_mercado']}}</span>
                                                  </div>
                                                  <div class="drhj">
                                                      <p>Procedimentos individuais no Doctor Hoje</p>
                                                      <span>R$ {{$checkup['total_vl_individual']}}</span>
                                                  </div>
                                                  <div class="checkup">
                                                      <p>Valor do Checkup</p>
                                                      <span>R$ {{$checkup['total_com_checkup']}}</span>
                                                      <button class="btn btn-vermelho" type="button" data-toggle="collapse" data-target="#collapse{{$checkup['titulo']}}{{$checkup['tipo']}}" aria-expanded="true" aria-controls="collapseOne">
                                                          Agendar este Checkup
                                                      </button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
          
                              <div id="collapse{{$checkup['titulo']}}{{$checkup['tipo']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionResultado">
                                  <div class="card-body">
      	  						@foreach($checkup['camadas'] as $titulo => $procedimento)
      	  							<div id="consultas" class="pacote-procedimentos">
                                              <div class="titulo">
                                                  <div class="row">
                                                      <div class="col-xl-8">
                                                          {{$titulo}}
                                                      </div>
                                                      <div class="col-xl-4">
                                                          Escolha data e horário
                                                      </div>
                                                       </div>
                                              </div>
                                              @foreach($procedimento as $codigo => $descricao)
                                                  <div class="procedimento">
                                                      <div class="row">
                                                          <div class="col-xl-8">
                                                              <div class="nome">
                                                                  <button type="button" class="btn btn-tooltip" data-toggle="tooltip" data-html="true" title="{{@$descricao['descricao']}}">
                                                                      <i class="fa fa-info-circle" aria-hidden="true">{{@$descricao['descricao']}}</i>
                                                                  </button>
                                                              </div>
                                                              <div class="clinicas">
                                                                  <div class="form-check">
                                                                      <label class="form-check-label" for="clinicaProcedimento027">
                                                                          {{@$descricao['prestador']}} - {{@$descricao['endereco']}}
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-xl-4">
                                                              <div class="escolher-data">
                                                                  <input id="selecionaDataUm" class="selecionaData" type="text" placeholder="Data">
                                                                  <label for="selecionaDataUm"><i class="fa fa-calendar"></i></label>
                                                              </div>
                                                              <div class="escolher-hora">
                                                                  <input id="selecionaHoraUm" class="selecionaHora" type="text" placeholder="Horário">
                                                                  <label for="selecionaHoraUm"><i class="fa fa-clock-o"></i></label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
      	  								@endforeach
                                          </div>																			
      	  						@endforeach
                                  </div>
                              </div>
                          </div>
      	  			@endforeach
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

            /*********************************
             *
             * TROCA COR CARD AO CLICAR
             *
             *********************************/
            $('.card').on('show.bs.collapse hide.bs.collapse', function (e) {
                if (e.type == 'show') {
                    $(this).addClass("card-active");
                } else {
                    $(this).removeClass("card-active");
                }
            });

            /*********************************
             *
             * DATA E HORA
             *
             *********************************/
            jQuery.datetimepicker.setLocale('pt-BR');

            /* DATA */
            jQuery('.selecionaData').datetimepicker({
                timepicker: false,
                format: 'd.m.Y'
            });

            /* HORA */
            jQuery('.selecionaHora').datetimepicker({
                datepicker: false,
                format: 'H:i',
                step: 30,
                minTime: '08:00',
                maxTime: '18:10',
            });

        </script>
    @endpush
@endsection