@extends('layouts.logado')

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
        <div class="">
            <p>Esta consulta <strong>é para você?</strong></p>
        </div>
        <div class="">
            <button type="button" class="btn btn-light btn-beneficiario" data-toggle="collapse" href="#collapseDadosBeneficiario" role="button" aria-expanded="false" aria-controls="collapseDadosBeneficiario">Para outra pessoa</button>
            <button type="button" class="btn btn-vermelho">É para mim</button>                
        </div>
        <div class="collapse area-dados-beneficiario" id="collapseDadosBeneficiario">
            <div class="card card-body">
                <h4>Informe os dados do befeciário</h4>
                <form>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="nomeBeneficiario">Nome</label>
                            <input type="text" class="form-control" id="nomeBeneficiario" placeholder="Nome completo">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="emailBeneficiario">E-mail</label>
                            <input type="email" class="form-control" id="emailBeneficiario" placeholder="Email">                            
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="telefoneBeneficiario">Telefone com DDD</label>
                            <input type="text" class="form-control" id="telefoneBeneficiario" placeholder="Telefone">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="nascimentoBeneficiario">Data de Nascimento</label>
                            <input type="text" class="form-control" id="nascimentoBeneficiario" placeholder="Nome completo">
                        </div>
                        <div class="form-group col-sm-12 titulo-sexo-beneficiario">
                            <label>Sexo</label>                            
                        </div>
                        <div class="form-group col-sm-12 grupo-sexo">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexoBeneficiário" id="sexoFeminino" value="option1">
                                <label class="form-check-label" for="sexoFeminino">Feminino</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexoBeneficiário" id="sexoMasculino" value="option2">
                                <label class="form-check-label" for="sexoMasculino">Masculino</label>
                            </div>
                        </div> 
                        <div class="form-group col-sm-3">
                            <button type="submit" class="btn btn-vermelho">Continuar</button>
                        </div>                        
                    </div>                    
                </form>
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

        });
	</script>	
    
@endpush

@endsection