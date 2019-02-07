<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
    <meta name="description" content="Cadastre-se e aproveite todos os benefícios dessa parceria">
    <meta name="keywords" content="doutorhoje saúde consulta médico sus plano de saúde">
    <meta name="author" content="Theogenes Ferreira Duarte">

    <title>@yield('title', 'DoutorHoje'): Campanha - {{$campanha->empresa->nome_fantasia}}</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/libs/sweet-alert/sweetalert2.css"/>
    <link rel="stylesheet" href="/libs/home-template/css/style.css"/>
    <link rel="stylesheet" href="/libs/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="/libs/jquery-autocomplete/css/styles.css">
    
    <!-- Sweet Alert css -->
    <link href="/libs/sweet-alert/sweetalert2.css" rel="stylesheet" type="text/css"/>
    
    <link rel="stylesheet" href="/css/doutorhj.style.css">
    <link rel="stylesheet" href="/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.css"/>
    
    <script src="/libs/comvex-template/js/jquery.min.js"></script>
    <script src="/libs/comvex-template/js/popper.min.js"></script>
    <script src="/libs/comvex-template/js/bootstrap.min.js"></script>
    
    <!-- Notification js -->
    <script src="/libs/notifyjs/dist/notify.min.js"></script>
    <script src="/libs/notifications/notify-metro.js"></script>
    
    <script src="/libs/comvex-template/js/jquery.core.js"></script>
</head>
<body>
	@if ($errors->any())
		<script type="text/javascript">
		$(document).ready(function () {
		
			$.Notification.notify('error','top right', 'Solicitação Falhou!', '<ul style="margin-left: -30px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>');
		});
		</script>
		{{--<div class="alert alert-danger alert-dismissible fade show" style="padding: 10px;">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>--}}
	@endif
    <div class="cont-form-campanha">
    	 @include('flash-message')
        <div class="container">
            <div class="area-form-campanha">
                <div class="logos-parceria">
                    <div class="titulo">
                        Uma parceira
                    </div>
                    <div class="area-logo-parceiro">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="logo">
                                    <img src="/libs/home-template/img/logo-padrao.png" alt="Doutor Hoje">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="logo">
                                    <p>{{$campanha->empresa->nome_fantasia}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="subtitulo">
                    <p>complete seu cadastro para<br>
                        <strong>ativar sua assinatura</strong></p>
                </div>

                <form action="{{ route('registrar-campanha') }}" method="post" onsubmit="return validaRegistrar()">
                
                	{{ csrf_field() }}
                    <div class="form-group row {{ $errors->has('nm_primario') ? ' cvx-has-error' : '' }}">
                        <label for="nm_primario" class="col-sm-4 col-form-label">Nome</label>
                        <div class="col-sm-8">
                            <input type="text" id="nm_primario" class="form-control" name="nm_primario" value="{{ old('nm_primario') }}" placeholder="Seu nome" required="required" maxlength="50">
                            <input type="hidden" name="a7cadgygey6yp3uc" value="{{ $campanha->id }}">
                            @if ($errors->has('nm_primario'))
                            	<span class="help-block"><strong>{{ $errors->first('nm_primario') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('nm_secundario') ? ' cvx-has-error' : '' }}">
                        <label for="nm_secundario" class="col-sm-4 col-form-label">Sobrenome</label>
                        <div class="col-sm-8">
                            <input type="text" id="nm_secundario" class="form-control" name="nm_secundario" value="{{ old('nm_secundario') }}" placeholder="Seu sobrenome" required="required" maxlength="50">
                            @if ($errors->has('nm_secundario'))
                            	<span class="help-block"> <strong>{{ $errors->first('nm_secundario') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('te_documento') ? ' cvx-has-error' : '' }}">
                        <label for="te_documento" class="col-sm-4 col-form-label">CPF</label>
                        <div class="col-sm-8">
                            <input type="text" id="te_documento" class="form-control mascaraCPF" name="te_documento" value="{{ old('te_documento') }}" placeholder="000.000.000-00" required="required">
                            @if ($errors->has('te_documento'))
                            	<span class="help-block"> <strong>{{ $errors->first('te_documento') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('email') ? ' cvx-has-error' : '' }}">
                        <label for="email" class="col-sm-4 col-form-label">E-mail</label>
                        <div class="col-sm-8">
                            <input type="email" id="inputEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="exemplo@email.com.br" required="required" maxlength="250">
                            @if ($errors->has('email'))
                            	<span class="help-block"> <strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cs_sexo" class="col-sm-4 col-form-label">Gênero</label>
                        <div class="col-sm-8">
                            <select id="cs_sexo" class="form-control" name="cs_sexo">
                                <option value="M" @if(old('cs_sexo') == 'M') selected="selected" @endif >Masculino</option>
                                <option value="F" @if(old('cs_sexo') == 'F') selected="selected" @endif>Feminino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dia_nascimento" class="col-sm-4 col-form-label">Data de nascimento</label>
                        <div class="col-4 col-sm-2">
                            <select id="dia_nascimento" class="form-control" name="dia_nascimento" required="required" style="width: 75px;">
                            	<option>Dia</option>
                            	@for($i = 1; $i < 32; $i++)
                            	<option value="{{ $i }}" @if(old('dia_nascimento') == $i) selected="selected" @endif>{{ sprintf("%02d", $i) }}</option>
                            	@endfor
                            </select>
                        </div>
                        <div class="col-4 col-sm-3">
                            <select id="mes_nascimento" class="form-control" name="mes_nascimento" required="required">
                            	<option>Mês</option>
                            	@for($i = 1; $i <= 12; $i++)
                            	<option value="{{ $i }}" @if(old('mes_nascimento') == $i) selected="selected" @endif>{{ sprintf("%02d", $i) }}</option>
                            	@endfor
                            </select>
                        </div>
                        <div class="col-4 col-sm-3">
                            <select id="ano_nascimento" class="form-control" name="ano_nascimento" required="required">
                                <option>Ano</option>
                                @for($i = date('Y'); $i >= (date('Y')-100); $i--)
                                <option value="{{ $i }}" @if(old('ano_nascimento') == $i) selected="selected" @endif>{{ sprintf("%04d", $i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('ds_contato') ? ' cvx-has-error' : '' }}">
                        <label for="ds_contato" class="col-sm-4 col-form-label">Celular</label>
                        <div class="col-sm-8">
                            <input type="text" id="ds_contato" class="form-control mascaraTelefone" name="ds_contato" value="{{ old('ds_contato') }}" placeholder="(00) 00000-0000" required="required">
                            @if ($errors->has('ds_contato'))
                            	<span class="help-block"> <strong>{{ $errors->first('ds_contato') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('confirma_ds_contato') ? ' cvx-has-error' : '' }}">
                        <label for="confirma_ds_contato" class="col-sm-4 col-form-label">Confirme o celular</label>
                        <div class="col-sm-8">
                            <input type="text" id="confirma_ds_contato" class="form-control mascaraTelefone" name="confirma_ds_contato" value="{{ old('confirma_ds_contato') }}" placeholder="(00) 00000-0000" required="required">
                            @if ($errors->has('confirma_ds_contato'))
                            	<span class="help-block"> <strong>{{ $errors->first('confirma_ds_contato') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="aceita_termos" class="form-check-input" name="aceita_termos" value="" required="required">
                        <label class="form-check-label" for="aceita_termos">
                            Declaro que li e aceito os <a href="javascript:;" data-toggle="modal" data-target="#modalTermos">termos de uso</a> do Doutor Hoje
                        </label>
                    </div>
                    <button type="submit" class="btn btn-azul">Complete seu registro e comece a cuidar da sua saúde</button>
                </form>

                <div class="modal fade" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="modalTermosTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTermosTitle">Termos de uso do Doutor Hoje</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/libs/comvex-template/js/jquery.min.js"></script>
    <script src="/libs/home-template/js/bootstrap.min.js"></script>
    <script src="/libs/select2/js/select2.min.js"></script>
    <script src="/libs/select2/js/i18n/pt-BR.js"></script>
    <script src="/libs/jquery-credit-card/jquery.creditCardValidator.js"></script>
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
    <script src="/libs/jquery-ui/jquery-ui.js"></script>
	<script src="/libs/comvex-template/js/jquery.inputmask.bundle.js"></script>
	
	<!-- Notification js -->
    <script src="/libs/notifyjs/dist/notify.min.js"></script>
    <script src="/libs/notifications/notify-metro.js"></script>
    
    <!-- Sweet Alert Js  -->
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/comvex-template/pages/jquery.sweet-alert.init.js"></script>
    
    <script src="/libs/comvex-template/js/jquery.core.js"></script>
    
    <script>
        var laravel_token = '{{ csrf_token() }}';
        var resizefunc = [];

        $(".mascaraCPF").inputmask({
    		mask: ['999.999.999-99'],
    		keepStatic: true
    	});

        $(".mascaraTelefone").inputmask({
            mask: ["(99) 9999-9999", "(99) 99999-9999"],
            keepStatic: true
    	});

        function validaRegistrar() {

            var contato1 = $('#ds_contato').val();
            var contato2 = $('#confirma_ds_contato').val();

            if (contato1 != contato2) {
                swal(
                    {
                        title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
                        text: 'Os números de telefone informados devem ser iguais!'
                    }
                );
                return false;
            }

            return true;
        }
    </script>

</body>
</html>
