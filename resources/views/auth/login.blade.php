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
                <div class="col-md-6">
                    <div class="card card-login-cadastro">
                        <div class="card-header">
							Já é cadastrado?
                        </div>
                        <div class="card-body">
							<span class="card-span">E-mail e Senha obrigatórios para o login.</span>
                            <h5 class="card-title">Dados de acesso</h5>
                            <form action="">
								<div class="row">
									<div class="col-md-4">
										<label for="usuario">E-mail ou Telefone</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" id="usuario" aria-describedby="usuarioHelp" placeholder="Email ou Telefone com DDD">										
									</div>
									<div class="col-md-4">
										<button type="submit" class="btn btn-vermelho">Enviar Token</button>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label for="token">Token de Acesso</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" id="token" aria-describedby="tokenHelp" placeholder="Token de acesso">										
									</div>
									<div class="col-md-4">
										<button type="submit" class="btn btn-vermelho">Acessar Conta</button>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
