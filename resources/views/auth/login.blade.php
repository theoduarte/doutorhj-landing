@extends('layouts.base')

@section('title', 'DoutorHJ: Login')

@push('scripts')

@endpush

@section('content')
<section class="login">
    <div class="container">
        <div class="area-container">
            <div class="titulo">
                <strong>Seu Cadastro</strong>
                <p>Se você já tem cadastro conosco, faça o login para avançar, ou realize o seu cadastro.</p>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card card-formulario c-login">
                        <div class="card-header">
                            Já é cadastrado?
                        </div>
                        <div class="card-body">
                            <span class="card-span">E-mail ou Celular obrigatórios para o login.</span>
                            <h5 class="card-title">Dados de acesso</h5>
                            <form>
                                <div class="form-group row area-label">
                                    <label for="inputEmailTelefone" class="col-sm-12">E-mail ou Celular</label>                       
                                </div>
                                <div class="form-group row">
                                    <div class="col col-lg-7 col-xl-8">
                                        <input type="text" class="form-control" id="inputEmailTelefone" placeholder="E-mail ou Celular">
                                    </div>
                                    <div class="col col-lg-5 col-xl-4">
                                        <button type="submit" class="btn btn-vermelho"><i class="fas fa-key"></i> Enviar Token</button>
                                    </div>
                                </div>
                                <div class="form-group row area-label">
                                    <label for="inputToken" class="col-sm-12 ">Token de Acesso</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col col-lg-7 col-xl-8">
                                        <input type="text" class="form-control" id="inputToken" placeholder="Token de Acesso">
                                    </div>
                                    <div class="col col-lg-5 col-xl-4">
                                        <button type="submit" class="btn btn-vermelho"><i class="fas fa-arrow-right"></i> Acessar Conta</button>
                                    </div>
								</div>
								<div class="form-group links-login">
									<a href="">Esqueci meu login</a> | <a href="">Reenviar Token</a>
								</div>								
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card card-formulario">
                        <div class="card-header">
                            Ainda não tem cadastro?
                        </div>
                        <div class="card-body">
                            <span class="card-span">Cadastre-se para obter acesso e continuar.</span>
                            <h5 class="card-title">Dados cadastrais</h5>
                            
                            <form class="form-horizontal " action="{{ route('register') }}" method="post">
                            	
                            	{{ csrf_field() }}
                            	
                                <div class="form-group row area-label {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="inputNome" class="col col-sm-12">Nome</label>
                                </div>
                                <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col col-sm-12">
                                        <input type="text" id="inputNome" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nome completo">
                                        @if ($errors->has('name'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('name') }}</strong>
						                    </span>
						                @endif
                                    </div>
                                </div>
                                <div class="form-group row area-label {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="inputEmail" class="col col-sm-12">E-mail</label>
                                </div>
                                <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col col-sm-12">
                                        <input type="email" id="inputEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail">
                                        @if ($errors->has('email'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('email') }}</strong>
						                    </span>
						                @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col col-sm-6">
                                        <label for="inputSexo">Sexo</label>
                                        <select id="cs_sexo" class="form-control" name="cs_sexo" >
                                        	<option value="">Sexo</option>
			                            	<option value="M" @if( old('cs_sexo') == 'M' ) selected="selected" @endif >Masculino</option>
			                            	<option value="F" @if( old('cs_sexo') == 'F' ) selected="selected" @endif>Feminino</option>
			                            </select>
                                    </div>
                                    <div class="col col-sm-6 {{ $errors->has('dt_nascimento') ? ' has-error' : '' }}">
                                        <label for="inputTelefone">Data de Nascimento</label>
                                        <input type="text" id="inputNascimento" class="form-control mascaraData" name="dt_nascimento" value="{{ old('dt_nascimento') }}" placeholder="Data de Nascimento">
                                        @if ($errors->has('dt_nascimento'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
						                    </span>
						                @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col col-sm-6">
                                        <label for="inputCPF">CPF</label>
                                        <input type="text" id="inputCPF" class="form-control mascaraCPF" placeholder="CPF">
                                    </div>
                                    <div class="col col-sm-6">
                                        <label for="inputCelular">Celular</label>
                                        <input type="text" id="inputCelular" class="form-control mascaraTelefone" placeholder="Celular">
                                    </div>
                                </div>
                                <div class="form-check fc-checkbox">
                                    <input type="checkbox" class="form-check-input" id="termoCheck">
                                    <label class="form-check-label" for="termoCheck">Declaro que li e concordo com os <a href="#">termos de uso do Doctor Hoje</a></label>
                                </div>
                                <button type="submit" class="btn btn-vermelho btn-criar-conta"><i class="fas fa-user"></i> Criar conta</button>
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
		$(document).ready(function(){
			var laravel_token = '{{ csrf_token() }}';
			var resizefunc = []; 

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
		})		     
	</script>
@endpush

@endsection
