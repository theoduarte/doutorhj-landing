
 
<div id="busca-home" class="{{ $class }}  ">
 
	<div class="titulo">
		<span>Quero agendar</span>
	</div>
	<form action="/resultado"   class="form-busca-home form-busca" id="form-buscar" method="get" onsubmit="return validaBuscaAtendimento()">
		<div class="row">
			<div class="form-group col-md-12 col-lg-3">
				<label for="tipo">Tipo de atendimento</label>
				<select id="tipo_atendimento" class="form-control"   name="tipo_atendimento">
					<option value="" disabled selected hidden>Ex.: Consulta</option>
					@foreach($tipoAtendimentos as $tipoAtendimento)
						<option value="{{ $tipoAtendimento->tag_value }}">{{ $tipoAtendimento->ds_atendimento }}</option>
					@endforeach
					@if( $hasActiveCheckup )
						<option value="checkup">Checkups</option>
					@endif
				</select>
			</div>
			<div class="form-group col-md-12 col-lg-3">
				<label for="especialidade">Especialidade ou exame</label>
				<select id="tipo_especialidade" class="form-control select2"   name="tipo_especialidade">
					<option value="" disabled selected hidden>Ex.: Clínica Médica</option>
				</select>
			</div>
			<div class="form-group col-md-12 col-lg-3" id="dvLocalAtendimento">
				<label for="local">Local de atedimento</label>
				<select id="local_atendimento" class="form-control select2"   name="local_atendimento">
					<!-- <option value="" disabled selected hidden>Ex.: Asa Sul</option> -->
					<option value="" disabled selected hidden>Selecione</option>
				</select>
				<i class="cvx-no-loading fa fa-spin fa-spinner"></i>
			</div>
			<input type="hidden" id="sg_estado_localizazao_form" name="sg_estado_localizacao">

			<div class="form-group col-md-12 col-lg-3">
				<button type="button" class="btn btn-primary btn-vermelho efetuar-busca"  >Pesquisar</button>
			</div>
		</div>
	</form>
</div>
 