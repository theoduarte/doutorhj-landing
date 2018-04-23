@extends('layouts.prestador')

@section('title', 'Área Prestador - Doctor Hoje')

@push('scripts')

@endpush

@section('content')
    <section class="login-prestador">
        <script>
            // ADICIONAR CLASSE PARA REMOVER IMAGEM DO RODAPE
            $(document).ready(function () {
                $('.medico-parte-2').addClass('remove-imagem-medico');
            });
        </script>
        <div class="container">
            <div class="area-container">
                <div class="titulo">
                    <strong>Seu Cadastro</strong>
                    <p>Se você já tem cadastro conosco, faça o login para avançar, ou realize o seu pré-cadastro.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card card-formulario c-login">
                            <div class="card-header">
                                Já é cadastrado?
                            </div>
                            <div class="card-body">
                                <span class="card-span">CNPJ ou CRM obrigatórios para o login.</span>
                                <h5 class="card-title">Dados de acesso</h5>
                                <form action="{{ route('login') }}" method="post">

                                    {{ csrf_field() }}

                                    <div class="form-group row area-label">
                                        <label for="inputCnpjCrm" class="col-sm-12">CNPJ ou CRM</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" id="inputCnpjCrm"
                                                   class="form-control mascaraTelefone" placeholder="CNPJ ou CRM">
                                        </div>
                                    </div>
                                    <div class="form-group row area-label">
                                        <label for="inputSenha" class="col-sm-12 ">Senha</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" id="inputSenha" class="form-control" name="cvx_token"
                                                   placeholder="Senha">
                                            <input type="hidden" id="input_hidden_EmailTelefone" name="cvx_telefone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-vermelho btn-entrar"><i
                                                    class="fas fa-sign-in-alt"></i> Entrar
                                        </button>
                                    </div>
                                    <div class="form-group links-login">
                                        <a href="">Esqueci minha senha</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card card-formulario">
                            <div class="card-header">
                                Não é cadastrado?
                            </div>
                            <div class="card-body">
                                <span class="card-span">Inscreva-se para entrarmos em contato.</span>
                                <h5 class="card-title">Dados cadastrais</h5>

                                <form class="form-horizontal " action="{{ route('registrar') }}" method="post">

                                    {{ csrf_field() }}

                                    <div class="form-group row area-label">
                                        <label for="inputClinica" class="col col-sm-12">Clínica</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col col-sm-12">
                                            <input type="text" id="inputClinica" class="form-control" name="clinica"
                                                   placeholder="Nome da clínica" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group row area-label">
                                        <label for="inputCnpj" class="col col-sm-12">CNPJ</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col col-sm-12">
                                            <input type="text" id="inputCnpj" class="form-control" name="cnpj"
                                                   placeholder="CNPJ" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col col-sm-6">
                                            <label for="inputCelular">Celular</label>
                                            <input type="text" id="inputCelular" class="form-control"
                                                   name="" value=""
                                                   placeholder="Celular" required="required">
                                        </div>
                                        <div class="col col-sm-6">
                                            <label for="inputTelefone">Telefone Fixo</label>
                                            <input type="text" id="inputTelefone" class="form-control"
                                                   name="" value=""
                                                   placeholder="Telefone fixo" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col col-sm-6">
                                            <label for="inputEmail">E-mail</label>
                                            <input type="email" id="inputEmail" class="form-control" name="email"
                                                   value="{{ old('email') }}" placeholder="E-mail" required="required">
                                        </div>
                                        <div class="col col-sm-6">
                                            <label for="selectEstado">Estado</label>
                                            <select id="selectEstado" class="form-control" name=""
                                                    required="required">
                                                <option value="">Selecione</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check fc-checkbox">
                                        <input type="checkbox" class="form-check-input" id="termoCheck"
                                               required="required">
                                        <label class="form-check-label" for="termoCheck">Declaro que li e concordo com
                                            os <a href="#">termos de uso do Doctor Hoje</a></label>
                                    </div>
                                    <button type="submit" class="btn btn-vermelho btn-criar-conta"><i
                                                class="fas fa-user"></i> Criar conta
                                    </button>
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

            });
        </script>

    @endpush

@endsection