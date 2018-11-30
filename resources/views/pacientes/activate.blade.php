@extends('layouts.base')

@section('title', 'Resultado - DoutorHJ')

@push('scripts')

@endpush

@section('content')
<section class="login">
	<div class="container">
		<div class="area-container">
			<div class="row">
				<div class="col-md-12 col-lg-6">
					<div class="boas-vindas-cadastro">
						<h4>Parabéns!</h4>
						<p>
							Seu cadastro foi concluído com sucesso. Você recebera um novo
							email com mais informações sobre o Doutor Hoje. <br>
							<br>Para logar na sua conta, digite seu celular e insira o token
							que receberá por SMS e E-mail.
						</p>
					</div>
				</div>
				<div class="col-md-12 col-lg-6">
					<div class="card card-formulario c-login">
						<div class="card-header">Faça seu login</div>
						<div class="card-body">
							<h5 class="card-title">Dados de acesso</h5>
							<form action="{{ route('login') }}" method="post" onsubmit="return validaCriarConta()">

								{{ csrf_field() }}

								<div class="form-group row area-label btn-send-token">
									<label for="inputEmailTelefone" class="col-sm-12">Celular</label>
								</div>
								<div class="form-group row btn-send-token">
									<div class="col col-lg-6 col-xl-7">
										<input type="text" id="inputEmailTelefone" class="form-control mascaraTelefone" placeholder="Número do Celular">
									</div>
									<div class="col col-lg-6 col-xl-5">
										<button type="button" id="btn-send-token" class="btn btn-vermelho">
											<i class="fa fa-key"></i>
											<span id="lbl-enviar-token">Enviar Token <i class="fa fa-spin fa-spinner" style="display: none; font-size: 14px; margin-left: 5px;"></i></span>
										</button>
									</div>
								</div>
								<div class="form-group row area-label btn-login-token" style="display: none;">
									<label for="inputToken" class="col-sm-12 ">Token de Acesso</label>
								</div>
								<div class="form-group row btn-login-token" style="display: none;">
									<div class="col col-lg-7 col-xl-8">
										<input type="text" id="inputToken" class="form-control" name="cvx_token" placeholder="Token de Acesso">
										<input type="hidden" id="input_hidden_EmailTelefone" name="cvx_telefone">
									</div>
									<div class="col col-lg-5 col-xl-4">
										<button type="submit" id="btn-login-token" class="btn btn-vermelho">
											<i class="fa fa-arrow-right"></i> Acessar Conta
										</button>
									</div>
								</div>
								<div class="form-group links-login">
									<a href="">Esqueci meu login</a> | <a onclick="$('.btn-send-token').show(); $('.btn-login-token').hide();">Reenviar Token</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@push('scripts')
<script type="text/javascript">
$(document).ready(function () {
	var laravel_token = '{{ csrf_token() }}';
	var resizefunc = [];

    //$('.btn-login-token').hide();
    
    $('#btn-send-token').click(function () {
        if ($('#inputEmailTelefone').val().length < 15) {
            swal(
                    {
                        title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DoutorHoje Informa:</div>',
                        text: 'O telefone informado não é válido'
                     }
                 );
            return false;
        }

                    var ds_contato = $('#inputEmailTelefone').val();
                    $('#input_hidden_EmailTelefone').val(ds_contato);

                    $('#btn-send-token').attr('disabled', 'disabled');
                    $('#btn-send-token').find('#lbl-enviar-token').html('Processando... <i class="fa fa-spin fa-spinner" style="display: inline-block; font-size: 14px; margin-left: 5px;"></i>');
                    setTimeout(function () {
                        $('#btn-send-token').find('#lbl-enviar-token').html('Enviar Token <i class="fa fa-spin fa-spinner" style="display: none; font-size: 14px; margin-left: 5px;"></i>');
                        $('#btn-send-token').removeAttr('disabled');
                    }, 30000);

                    jQuery.ajax({
                        type: 'POST',
                        url: "{{ route('enviar_token') }}",
                        data: {
                            'ds_contato': ds_contato,
                            '_token': laravel_token
                        },
                        success: function (result) {

                            if (result.status) {
                                $.Notification.notify('success', 'top right', 'DrHoje', result.mensagem);

                                $('.btn-send-token').hide();
                                $('.btn-login-token').show();

                            } else {

                                swal(
                                    {
                                        title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> DoutorHoje Informa:</div>',
                                        text: result.mensagem
                                    }
                                );
                            }

                            $('#btn-send-token').find('#lbl-enviar-token').html('Enviar Token <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                            $('#btn-send-token').removeAttr('disabled');
                        },
                        error: function (result) {
                            $.Notification.notify('error', 'top right', 'DrHoje', 'Falha na operação!');
                            $('#btn-send-token').find('#lbl-enviar-token').html('Enviar Token <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                            $('#btn-send-token').removeAttr('disabled');
                        }
                    });
                });

                /*********************************
                 *
                 * CALENDARIO
                 *
                 *********************************/

                jQuery.datetimepicker.setLocale('pt-BR');

                /* jQuery('#inputNascimento').datetimepicker({
                    timepicker:false,
                    format:'d.m.Y',
                }); */
            });

            function validaRegistrar() {

                if ($('#inputNome').val().length == 0) return false;
                if ($('#inputSobrenome').val().length == 0) return false;
                if ($('#inputEmail').val().length == 0) return false;
                if ($('#cs_sexo').val().length == 0) return false;
                if ($('#inputNascimento').val().length == 0) return false;
                if ($('#inputCPF').val().length == 0) return false;
                if ($('#inputCelular').val().length == 0) return false;

                $('#btn-criar-conta').attr('disabled', 'disabled');
                $('#btn-criar-conta').find('#lbl-criar-conta').html('Processando... <i class="fa fa-spin fa-spinner" style="float: right; font-size: 16px;"></i>');
                setTimeout(function () {
                    $('#btn-criar-conta').find('#lbl-criar-conta').html('Criar conta <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                    $('#btn-criar-conta').removeAttr('disabled');
                }, 30000);

                return true;
            }

            function validaCriarConta() {

                if ($('#inputEmailTelefone').val().length == 0) return false;
                if ($('#input_hidden_EmailTelefone').val().length == 0) return false;
                if ($('#inputToken').val().length == 0) return false;

                return true;
            }
</script>
@endpush

@endsection
