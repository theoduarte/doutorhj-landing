@extends('layouts.base')

@section('title', 'Confirma Beneficiário - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="confirma-beneficiario">
<div class="container">
    <div class="area-container">
        <!--<div class="titulo">
            <strong>Esta consulta é para você?</strong>
            <p>Selecione ou adicione seu cartão, escolha o beneficiário da compra e, caso houver, digite seu cupom de desconto.</p>
            </div>-->
         
         @if($errors->any())
            <div class="col-12 alert alert-danger">
                @foreach ($errors->all() as $error)<div class="col-5">{{$error}}</div>@endforeach
            </div>
         @endif 
        <div class="">
            <p>Esta consulta <strong>é para você?</strong></p>
        </div>
        <div class="">
            <button type="button" class="btn btn-light btn-beneficiario" data-toggle="collapse" href="#collapseDadosBeneficiario" role="button" aria-expanded="false" aria-controls="collapseDadosBeneficiario" style="float: left; margin-right: 10px;">Para outra pessoa</button>
            <form id="form-seleciona-beneficiario-{{ $paciente_titular->id }}" action="/atualiza-carrinho" method="post">
            	{!! csrf_field() !!}
            	
            	<input type="hidden" id="item_id" name="item_id" value="{{ $proximo_item['item_id'] }}">
            	<input type="hidden" id="paciente_id" name="paciente_id" value="{{ $paciente_titular->id }}">
            	<input type="hidden" id="current_url" name="current_url" value="{{ $proximo_item['current_url'] }}">

               	<button type="submit" class="btn btn-vermelho">É para mim</button>
            </form>
            
            <input type="hidden" id="pr_item_id" name="item_id" value="{{ $proximo_item['item_id'] }}">
        	<input type="hidden" id="pr_paciente_id" name="paciente_id" value="{{ $paciente_titular->id }}">
        	<input type="hidden" id="pr_current_url" name="current_url" value="{{ $proximo_item['current_url'] }}">
        </div>
        <div class="collapse area-dados-beneficiario" id="collapseDadosBeneficiario">
            <div class="card card-body">
                <h4>SELECIONE UM BENEFICIÁRIO PARA ESTE ATENDIMENTO</h4>
                <div id="lista-dependentes">
                @for($i = 0; $i < sizeof($dependentes); $i++)
                <form id="form-seleciona-beneficiario-{{ $dependentes[$i]->id }}" action="/atualiza-carrinho" method="post">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="nomeBeneficiario">Nome</label>
                            <input type="text" id="nomeBeneficiario" class="form-control" name="nomeBeneficiario" value="{{ $dependentes[$i]->nm_primario.' '.$dependentes[$i]->nm_secundario }}" placeholder="Nome completo" readonly="readonly">
                            {!! csrf_field() !!}
                            <input type="hidden" id="dep_item_id" name="item_id" value="{{ $proximo_item['item_id'] }}">
                        	<input type="hidden" id="dep_paciente_id" name="paciente_id" value="{{ $dependentes[$i]->id }}">
                        	<input type="hidden" id="dep_current_url" name="current_url" value="{{ $proximo_item['current_url'] }}">
                        </div>
                        <div class="form-group col-sm-1">
                            <label for="emailBeneficiario">Sexo</label>
                            <input type="email" id="sexoBeneficiario" class="form-control" name="sexoBeneficiario" value="@if($dependentes[$i]->cs_sexo == 'M') Masc. @else Fem. @endif" placeholder="Sexo" readonly="readonly">                            
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="telefoneBeneficiario">Parentesco</label>
                            <input type="text" id="parentescoBeneficiario" class="form-control" name="parentescoBeneficiario" value="{{ $dependentes[$i]->parentesco }}" placeholder="Parentesco" readonly="readonly">
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="nascimentoBeneficiario">Data de Nascimento</label>
                            <input type="text" id="nascimentoBeneficiario" class="form-control" name="nascimentoBeneficiario" value="{{ $dependentes[$i]->getDtNascimentoAttribute() }}" placeholder="Data de Nascimento" readonly="readonly">
                        </div>
                        <div class="form-group col-sm-3">
                        	<br>
                            <button type="submit" class="btn btn-vermelho" style="height: 43px;">SELECIONAR DEPENDENTE</button>
                        </div>                        
                    </div>                    
                </form>
                @endfor
                </div>
                @if(sizeof($dependentes) == 0)
                <span id="lbl-no-dependents">NENHUM DEPENDENTE ENCONTRADO!</span>
                @endif
            </div>
            <button type="button" class="btn btn-light btn-azul" data-toggle="modal" data-target="#modalAdicionaDependente" style="margin-top: 10px;">
                <i class="fa fa-plus"></i> Adicionar dependente
            </button>
        </div>
    </div>
    <div class="modal fade" id="modalAdicionaDependente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-adiciona-dependente" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Novo Dependente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="inputNomeDependente">Nome</label>
                            <input type="text" class="form-control" id="inputNomeDependente" placeholder="Nome *" maxlength="50">
                            <input type="hidden" id="inputPacienteId" value="{{ $paciente_titular->id }}">
                        </div>
                        <div class="form-group">
                            <label for="inputNomeDependente">Sobrenome</label>
                            	<input type="text" class="form-control" id="inputNmSecundarioDependente" placeholder="Sobrenome *" maxlength="100">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tp_documento_dependente" class="control-label">Tipo Documento</label>
	                            <select id="tp_documento_dependente" class="form-control" name="tp_documento_dependente">
	                            	<option value="RG">RG</option>
	                            	<option value="CPF">CPF</option>
	                            	<option value="CNASC">Certi. Nasc.</option>
	                            	<option value="CTPS">Cart. Trabalho</option>
	                            </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="te_documento_dependente" class="control-label">Nr. Documento</label>
		                        <input type="text" id="te_documento_dependente" class="form-control" name="te_documento_dependente" placeholder="Nr. Documento">
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-4">
                                <label for="selectGeneroDependente">Gênero</label>
                                <select id="selectGeneroDependente" class="form-control">
                                    <option value="M">Masc.</option>
                                    <option value="F">Fem.</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                            	<label for="selectParentescoDependente">Parentesco</label>
                                <select id="selectParentescoDependente" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="avo">Avô/Avó</option>
                                    <option value="conjuge">Cônjuge/Companheiro</option>
                                    <option value="enteado">Enteado(a)</option>
                                    <option value="filho">Filho(a)</option>
                                    <option value="irmao">Irmã(ão)</option>
                                    <option value="mae">Mãe</option>
                                    <option value="pai">Pai</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group fc-tit-dn">
                            <label>Data de Nascimento</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <select id="selectDiaDependente" class="form-control">
                                    <option value="">Dia</option>
                                    @for($i = 1; $i <= 31; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select id="selectMesDependente" class="form-control">
                                    <option value="">Mês</option>
                                    @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select id="selectAnoDependente" class="form-control">
                                    <option value="">Ano</option>
                                    @for($i = date('Y'); $i >= (date('Y'))-110; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                        	<div class="col-md-12 text-center">
                        		<button type="button" id="btn-add-dependente" class="btn btn-vermelho" style="width: 200px;"><i class="fa fa-floppy-o"></i><span id="lbl-add-dependente" style="margin-left: 10px;"> Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i></span></button>
                        	</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@push('scripts')
    <script type="text/javascript">       
        $(document).ready(function(){

            var laravel_token = '{{ csrf_token() }}';
            var resizefunc = [];

            $('#btn-add-dependente').click(function() {

            	var result = true;
                var nm_primario_dependente = $('#inputNomeDependente');

            	if(nm_primario_dependente.val().length == 0) {
            		nm_primario_dependente.parent().addClass('cvx-has-error');
            		nm_primario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#inputNomeDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var nm_secundario_dependente = $('#inputNmSecundarioDependente');

            	if(nm_secundario_dependente.val().length == 0) {
            		nm_secundario_dependente.parent().addClass('cvx-has-error');
            		nm_secundario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#inputNmSecundarioDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}
            	
            	var tp_documento = $('#tp_documento_dependente');

            	if(tp_documento.val() == '') {
            		tp_documento.parent().addClass('cvx-has-error');
            		tp_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#tp_documento_dependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var nr_documento = $('#te_documento_dependente');

            	if(nr_documento.val().length == 0) {
            		nr_documento.parent().addClass('cvx-has-error');
            		nr_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#te_documento_dependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var sexo_dependente = $('#selectGeneroDependente');

            	if(sexo_dependente.selectedIndex == 0) {
            		sexo_dependente.parent().addClass('cvx-has-error');
            		sexo_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#selectGeneroDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var dt_nasc_dia_dependente = $('#selectDiaDependente');

            	if(dt_nasc_dia_dependente.val() == '') {
            		dt_nasc_dia_dependente.parent().addClass('cvx-has-error');
            		dt_nasc_dia_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#selectDiaDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var dt_nasc_mes_dependente = $('#selectMesDependente');

            	if(dt_nasc_mes_dependente.val() == '') {
            		dt_nasc_mes_dependente.parent().addClass('cvx-has-error');
            		dt_nasc_mes_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#selectMesDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var dt_nasc_ano_dependente = $('#selectAnoDependente');

            	if(dt_nasc_ano_dependente.val() == '') {
            		dt_nasc_ano_dependente.parent().addClass('cvx-has-error');
            		dt_nasc_ano_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#selectAnoDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	var parentesco_dependente = $('#selectParentescoDependente');

            	if(parentesco_dependente.val() == '') {
            		parentesco_dependente.parent().addClass('cvx-has-error');
            		parentesco_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');
            		
            		$('#selectParentescoDependente').keypress(function(){
            			$(this).parent().removeClass('cvx-has-error');
            			$(this).parent().find('span.help-block').remove();
            		});
            		
            		result = false;
            	}

            	if(!result) { return false; }

            	$('#btn-add-dependente').attr('disabled', 'disabled')
                $('#lbl-add-dependente').html('Enviando <i class="fa fa-spin fa-spinner" style="display: inline-block; float: right; font-size: 16px;"></i>');

                var nome_dep 			= nm_primario_dependente.val();
                var sobrenome_dep 		= nm_secundario_dependente.val();
                var tp_documento_dep 	= tp_documento.val();
                var nr_documento_dep 	= nr_documento.val();
                var sexo_dep 			= sexo_dependente.val();
                var parentesco_dep 		= parentesco_dependente.val();
                var dia_nasc_dep 		= dt_nasc_dia_dependente.val();
                var mes_nasc_dep 		= dt_nasc_mes_dependente.val();
                var ano_nasc_dep 		= dt_nasc_ano_dependente.val();
                var paciente_id 		= $('#inputPacienteId').val();

                var item_id 			= $('#pr_item_id').val();
                var paciente_id 		= $('#pr_paciente_id').val();
                var current_url 		= $('#pr_current_url').val();

            	jQuery.ajax({
        			type: 'POST',
        			url: '/add-dependente',
        			data: {
            			'nome': nome_dep,
            			'sobrenome': sobrenome_dep,
            			'tp_documento': tp_documento_dep,
            			'nr_documento': nr_documento_dep,
            			'sexo': sexo_dep,
            			'parentesco': parentesco_dep,
            			'dia_nasc': dia_nasc_dep,
            			'mes_nasc': mes_nasc_dep,
        				'ano_nasc': ano_nasc_dep,
        				'paciente_id': paciente_id,
        				'_token': laravel_token
        			},
                    success: function (result) {
        	            if(result.status) {
            	            
        	            	var dependente = JSON.parse(result.dependente);
        	            	$('#lbl-no-dependents').empty();
        	            	var index = ($('#lista-dependentes').find('form').length)+1;
        	            	
        	            	var content = '<div class="dependente"> \
                              <div class="row"> \
                                  <div class="col-md-10"> \
                                      <span class="nm-dependente"><strong>Dep0'+index+'</strong>: '+dependente.nm_primario+' '+dependente.nm_secundario+'</span> \
                                      <input type="hidden" id="dependente_'+dependente.id+'" class="dependente_id" value="'+dependente.id+'"> \
                                  </div> \
                                  <div class="col-md-2"> \
                                  	  <a class="exclui-dependente"><i class="fa fa-trash"></i></a> \
                                  </div> \
                              </div> \
                          	</div>';

                          	var cs_sexo = dependente.cs_sexo == 'M' ? 'Masc.' : 'Fem.';
                          	var dt_nascimento = dependente.dt_nascimento;

                          	var content = '<form action="/atualiza-carrinho" method="post"> \
                                <div class="row"> \
                                    <div class="form-group col-sm-4"> \
                                        <label for="nomeBeneficiario">Nome</label> \
                                        <input type="text" id="nomeBeneficiario" class="form-control" name="nomeBeneficiario" value="'+dependente.nm_primario+' '+dependente.nm_secundario+'" placeholder="Nome completo" readonly="readonly"> \
                                        <input type="hidden" name="_token" value="'+laravel_token+'"> \
                                        <input type="hidden" id="dep_item_id" name="item_id" value="'+item_id+'"> \
                                    	<input type="hidden" id="dep_paciente_id" name="paciente_id" value="'+dependente.id+'"> \
                                    	<input type="hidden" id="dep_current_url" name="current_url" value="'+current_url+'"> \
                                    </div> \
                                    <div class="form-group col-sm-1"> \
                                        <label for="emailBeneficiario">Sexo</label> \
                                        <input type="email" id="sexoBeneficiario" class="form-control" name="sexoBeneficiario" value="'+cs_sexo+'" placeholder="Sexo" readonly="readonly"> \
                                    </div> \
                                    <div class="form-group col-sm-2"> \
                                        <label for="telefoneBeneficiario">Parentesco</label> \
                                        <input type="text" id="parentescoBeneficiario" class="form-control" name="parentescoBeneficiario" value="'+dependente.parentesco+'" placeholder="Parentesco" readonly="readonly"> \
                                    </div> \
                                    <div class="form-group col-sm-2"> \
                                        <label for="nascimentoBeneficiario">Data de Nascimento</label> \
                                        <input type="text" id="nascimentoBeneficiario" class="form-control" name="nascimentoBeneficiario" value="'+dt_nascimento+'" placeholder="Data de Nascimento" readonly="readonly"> \
                                    </div> \
                                    <div class="form-group col-sm-3"> \
                                    	<br> \
                                    	<button type="submit" class="btn btn-vermelho" style="height: 43px;">SELECIONAR DEPENDENTE</button> \
                                    </div> \
                                    </div> \
                                 </form>';

                          	$('#modalAdicionaDependente').find('input.form-control').val('');
                          	$('#modalAdicionaDependente').find('select.form-control').prop('selectedIndex',0);
                          	
                          	$('#modalAdicionaDependente').modal('toggle');
        	            	$('#lista-dependentes').append(content);
        	            	
        	            	$.Notification.notify('success','top right', 'DrHoje', result.mensagem);
        	            }

        	            $('#btn-add-dependente').removeAttr('disabled')
                        $('#lbl-add-dependente').html('Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                    },
                    error: function (result) {
                    	$('#btn-add-dependente').removeAttr('disabled')
                        $('#lbl-add-dependente').html('Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                        swal(
                            {
                                title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DrHoje</div>',
                                text: 'Falha na operação!'
                            }
                        );
                    }
        		});
            	
            });

        });

        function validaAddBeneficiario() {
            var item_id 			= $('#pr_item_id').val();
            var paciente_id 		= $('#pr_paciente_id').val();
            var current_url 		= $('#pr_current_url').val();

            if(item_id.length == 0 | paciente_id.length == 0 | current_url.length == 0) {
            	swal(
            	        {
            	            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
            	            text: 'O Dependente não foi adicionado. Por favor, verifique as informações e tente novamente!'
            	        }
            	    );

        	    return false;
            }

            $('#item_id').val(item_id);
            $('#paciente_id').val(paciente_id);
            $('#current_url').val(current_url);

            return true;
        }
	</script>	
    
@endpush

@endsection