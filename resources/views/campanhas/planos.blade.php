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

    <title>@yield('title', 'DoutorHoje')</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/libs/sweet-alert/sweetalert2.css"/>
    <link rel="stylesheet" href="/libs/home-template/css/style.css"/>
    <link rel="stylesheet" href="/libs/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="/libs/jquery-autocomplete/css/styles.css">
    <link rel="stylesheet" href="/css/doutorhj.style.css">
    <link rel="stylesheet" href="/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.css"/>
</head>
<body>

    <div class="cont-form-campanha">
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
                                    <p>Ideal Saúde</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="subtitulo">
                    <p>complete seu cadastro para<br>
                        <strong>ativar sua assinatura</strong></p>
                </div>

                <form>
                    <div class="form-group row">
                        <label for="inputNome" class="col-sm-4 col-form-label">Nome</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputNome" placeholder="Seu nome">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSobrenome" class="col-sm-4 col-form-label">Sobrenome</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputSobrenome" placeholder="Seu sobrenome">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCPF" class="col-sm-4 col-form-label">CPF</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputCPF" placeholder="000.000.000-00">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-4 col-form-label">E-mail</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail" placeholder="exemplo@email.com.br">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputNome" class="col-sm-4 col-form-label">Gênero</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputNome" placeholder="Seu sobrenome">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mesNascimento" class="col-sm-4 col-form-label">Data de nascimento</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="mesNascimento">
                                <option>Mês</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" id="anoNascimento">
                                <option>Ano</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCelular" class="col-sm-4 col-form-label">Celular</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputCelular" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputConfCelular" class="col-sm-4 col-form-label">Confirme o celular</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputConfCelular" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
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

    <script>
        var laravel_token = '{{ csrf_token() }}';
        var resizefunc = [];
    </script>

    <script src="/libs/comvex-template/js/jquery.min.js"></script>
    <script src="/libs/home-template/js/bootstrap.min.js"></script>
    <script src="/libs/select2/js/select2.min.js"></script>
    <script src="/libs/select2/js/i18n/pt-BR.js"></script>
    <script src="/libs/jquery-credit-card/jquery.creditCardValidator.js"></script>
    <script src="/libs/sweet-alert/sweetalert2.min.js"></script>
    <script src="/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/inputMask.min.js"></script>
    <script>

    </script>

</body>
</html>
