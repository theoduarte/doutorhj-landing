@extends('layouts.base')

@section('title', 'Resultado - Doctor HJ')

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
                <strong>Resultados da sua pesquisa</strong>
                <p>Após a escoha do prestador, indique a data e horário para realizar o seu agendamento.</p>
            </div>
            <div class="area-alt-busca">
                <a class="btn btn-primary btn-alt-busca" data-toggle="collapse" href="#collapseFormulario" role="button" aria-expanded="false" aria-controls="collapseFormulario">Alterar Busca <i class="fas fa-edit"></i></a>
            </div>
            <div class="collapseFormulario collapse show" id="collapseFormulario">
                <form action="" class="form-busca-resultado">
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <select class="form-control" id="tipo">
                                <option>Tipo de atendimento</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                                <option>Opção 3</option>
                                <option>Opção 4</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <select id="list_especialidade" class="form-control">
                                <option>Especialidade</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                                <option>Opção 3</option>
                                <option>Opção 4</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <select class="form-control" id="local">
                                <option>Local</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                                <option>Opção 3</option>
                                <option>Opção 4</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <button type="button" class="btn btn-primary btn-vermelho"><i class="fas fa-search"></i> Alterar Busca</button>
                        </div>
                    </div>
                </form> 
            </div>                        
            <div class="lista-resultado">
                <div class="row">
                    <div class="col-md-12 col-lg-5">
                        <div class="ordenar-por div-filtro">
                            <select class="form-control" id="ordenar">
                                <option>Ordenar por...</option>
                                <option>Maior preço</option>
                                <option>Menor preço</option>
                            </select>
                        </div>
                        <div id="accordion">
                        	@foreach($atendimentos as $atendimento)
                            <div class="card card-resultado">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $atendimento->clinica->nm_fantasia }}</h5>
                                    <h6 class="card-subtitle">Dr. {{ $atendimento->profissional->nm_primario.' '.$atendimento->profissional->nm_secundario }}</h6>
                                    <p class="card-text">@if( $tipo_atendimento == 'saude' ) Clínica médica @else Clínica Odontológica @endif </p>
                                    <p class="card-text">{{ $atendimento->clinica->enderecos[0]->te_endereco.' ('.$atendimento->clinica->enderecos[0]->te_bairro.') '.$atendimento->clinica->enderecos[0]->cidade->nm_cidade.'-'.$atendimento->clinica->enderecos[0]->cidade->estado->sg_estado }} <a class="link-mapa-mobile" href="https://goo.gl/maps/MPNHA8CLr812">Ver no mapa</a></p>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="form-check area-seleciona-profissional">
                                        <input id="inputProfissional_{{ $atendimento->id.$atendimento->profissional->id }}" class="form-check-input" name="radioProfissional_{{ $atendimento->id.$atendimento->profissional->id }}" type="radio" data-toggle="collapse" data-target="#collapse_{{ $atendimento->id.$atendimento->profissional->id }}" aria-expanded="false" aria-controls="collapse_{{ $atendimento->id.$atendimento->profissional->id }}">
                                        <label class="form-check-label" for="inputProfissional_{{ $atendimento->id.$atendimento->profissional->id }}">
                                        Agendar com este profissional
                                        </label>
                                    </div>
                                    <strong>R$ {{ $atendimento->getVlComercialAtendimento() }}</strong>
                                </div>
                                <div id="collapse_{{ $atendimento->id.$atendimento->profissional->id }}" class="collapse" aria-labelledby="heading_{{ $atendimento->id.$atendimento->profissional->id }}" data-parent="#accordion">
                                	<form id="form-agendamento{{ $atendimento->id }}" action="/agendar-atendimento" method="post">
                                		<input type="hidden" id="atendimento_id" name="atendimento_id" value="{{ $atendimento->id }}">
                                    	<input type="hidden" id="profissional_id" name="profissional_id" value="{{ $atendimento->profissional->id }}">
                                    	<input type="hidden" id="paciente_id" name="paciente_id" value="">
                                    	<input type="hidden" id="clinica_id" name="clinica_id" value="{{ $atendimento->clinica->id }}">
                                    	<input type="hidden" id="vl_com_atendimento" name="vl_com_atendimento" value="{{ $atendimento->vl_com_atendimento }}">
                                    	
                                    	<!-- <input type="hidden" name="current_url" value="{{ Request::root().'/'.Request::path().'/'.str_replace(Request::url(), '',Request::fullUrl()) }}"> -->
                                    	<input type="hidden" name="current_url" value="{{ Request::fullUrl() }}">
                                    	{!! csrf_field() !!}
                                	
	                                    <div class="area-escolher-data">
	                                        <div class="titulo-escolhe-data">
	                                            Escolha data e horário
	                                        </div>
	                                        <div class="escolher-data">                                    
	                                            <input type="text" id="selecionaData{{ $atendimento->id }}" class="selecionaData" name="data_atendimento" placeholder="Data">
	                                            <label for="selecionaData{{ $atendimento->id }}"><i class="far fa-calendar-alt"></i></label>
	                                        </div>
	                                        <div class="escolher-hora">                                    
	                                            <input type="text" id="selecionaHora{{ $atendimento->id }}" class="selecionaHora" name="hora_atendimento" placeholder="Horário">
	                                            <label for="selecionaHora{{ $atendimento->id }}"><i class="far fa-clock"></i></label>
	                                        </div>
	                                        <div class="confirma-data">
	                                            <span>{{ date('d/m/Y') }} - {{ strftime('%A', strtotime('today')) }} - {{ date('H').'h'.date('i').'min' }}</span>
	                                        </div>
	                                        <div class="mensagem-confirma-data">
	                                            <span>Data e horário sugeito a confirmação</span>
	                                        </div>
	                                        <div class="valor-total">
	                                            <span><strong>Total a pagar:</strong> R$ {{ $atendimento->getVlComercialAtendimento() }}</span>
	                                        </div>
	                                        <button type="submit" class="btn btn-primary btn-vermelho">Prosseguir para pagamento</button>
	                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            <div class="card card-resultado">
                                <div class="card-body">
                                    <h5 class="card-title">ACREDITAR CLÍNICA MÉDICA S.A</h5>
                                    <h6 class="card-subtitle">Dr. Alexandre José</h6>
                                    <p class="card-text">Clínica médica</p>
                                    <p class="card-text">Edifício Pio X - 716 Sul (Asa Sul) Brasilia, DF <a class="link-mapa-mobile" href="https://goo.gl/maps/MPNHA8CLr812">Ver no mapa</a></p>
                                </div>
                                <div class="card-footer">
                                    <div class="form-check area-seleciona-profissional">
                                        <input id="inputProfissional2" class="form-check-input" name="radioProfissional" type="radio" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <label class="form-check-label" for="inputProfissional2">
                                        Agendar com este profissional
                                        </label>
                                    </div>
                                    <strong>R$ 173,00</strong>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="area-escolher-data">
                                        <div class="titulo-escolhe-data">
                                            Escolha data e horário
                                        </div>
                                        <div class="escolher-data">                                    
                                            <input id="selecionaData2" class="selecionaData" type="text" placeholder="Data">
                                            <label for="selecionaData2"><i class="far fa-calendar-alt"></i></label>
                                        </div>
                                        <div class="escolher-hora">                                    
                                            <input id="selecionaHora2" class="selecionaData" type="text" placeholder="Horário">
                                            <label for="selecionaHora2"><i class="far fa-clock"></i></label>
                                        </div>
                                        <div class="confirma-data">
                                            <span>26/03/2018 - Segunda-feira - 10h30min</span>
                                        </div>
                                        <div class="mensagem-confirma-data">
                                            <span>Data e horário sugeito a confirmação</span>
                                        </div>
                                        <div class="valor-total">
                                            <span><strong>Total a pagar:</strong> R$ 173,00</span>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-vermelho">Prosseguir para pagamento</button>
                                    </div>
                                </div>
                            </div>
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
                
            jQuery('.selecionaData').datetimepicker({                
                timepicker:false,
                format:'d.m.Y'
            }).on("input change", function(e){
            	console.log("Date changed: ", e.target.value);
            });
            
            jQuery('.selecionaHora').datetimepicker({ 
                datepicker:false,
                format:'H:i',
                step: 10,
            }).on("input change", function(e){
            	console.log("Time changed: ", e.target.value);
            });
                
            jQuery('#selecionaData2').datetimepicker({                
                timepicker:false,
                format:'d.m.Y',
            });
            jQuery('#selecionaHora2').datetimepicker({ 
                datepicker:false,
                format:'H:i',
                step: 10,
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

            /*********************************
            *
            * GOOGLE MAPS
            * 
            *********************************/

            function initMap() {

                var clinicaUm = {
                    info: '<strong>Check Up Centro Médico</strong><br>\
                                SDS Bloco O Ed. Venâncio VI 221 a 227<br> Brasília, DF, 70393-905<br>\
                                <a href="https://goo.gl/Y9UUWt">Obter direção</a>',
                    lat: -15.7987496,
                    long: -47.8949315
                };

                var clinicaDois = {
                    info: '<strong>Actual Clínica Médica e Psicologia</strong><br>\
                                SCS Quadra 6 Bloco A Lote 150/170 - Edifício<br> Carioca 5 andar Sala 514/15,<br> Q. 6 - Asa Sul, Brasília - DF, 70325-900<br>\
                                <a href="https://goo.gl/JWt3Tp">Obter direção</a>',
                    lat: -15.7960663,
                    long: -47.8927361
                };

                var clinicaTres = {
                    info: '<strong>Clínica Devas</strong><br>\r\
                                SDN CNB Etapa III - S 4104, Setor de<br> Diversões Norte - Brasília, DF, 70077-000<br>\
                                <a href="https://goo.gl/2JdPbn">Obter direção</a>',
                    lat: -15.7920841,
                    long: -47.8859702
                };

                var locations = [
                [clinicaUm.info, clinicaUm.lat, clinicaUm.long, 0],
                [clinicaDois.info, clinicaDois.lat, clinicaDois.long, 1],
                [clinicaTres.info, clinicaTres.lat, clinicaTres.long, 2],
                ];

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: new google.maps.LatLng(-15.7987496, -47.8949315),
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
                }
            }        
	</script>
	
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkovLYQa6lqh1suWtV_ZFJ0i9ChWc9hqI&callback=initMap" type="text/javascript"></script>
@endpush

@endsection
