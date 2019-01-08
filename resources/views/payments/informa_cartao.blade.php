@extends('layouts.base')

@section('title', 'Informa Cartão - DoutorHj')

@push('scripts')
	<style>
		.box-minha-conta {
			min-height: 600px;
		}

		.box-cartao {
			padding-top: 10%;
		}

		.campos_endereco {
			display: none;
		}

		.deletar {
			display: none;
		}

		.registrarEndereco {
			display: none;
		}
	</style>
@endpush

@section('content')
	<section class="area-busca-interna minha-conta">
		<div class="container">

			<div class="box-minha-conta">
				@if ($errors->any())
					<div class="alert alert-danger alert-dismissible fade show" style="padding: 10px;">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				<div class="row box-cartao">
					<div class="col-md-6">
						<form method="POST" id="form-cartao_pacientes" action="{{ route('finaliza_pre_autorizacao', ['verify_hash' => $verify_hash]) }}">
							{{csrf_field()}}

							<div class="form-group">
								<label for="numero">Número do cartão</label>
								<input type="text" class="form-control" name="numero" id="numero" placeholder="Insira o número do cartão" value="{{old('numero')}}" required>
							</div>
							<div class="form-group">
								<label for="nome_impresso">Nome do titular (como escrito no cartão)</label>
								<input type="text" class="form-control text-uppercase" id="nome_impresso" name="nome_impresso" placeholder="Insira o nome do titular" value="{{old('nome_impresso')}}" required>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="validade">Validade</label>
											<input type="text" class="form-control" id="validade" name="validade" placeholder="MM/AA" value="{{old('validade')}}" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="codigo_seg">Código de segurança</label>
											<input type="text" class="form-control" id="codigo_seg" name="codigo_seg" placeholder="CVC" value="{{old('codigo_seg')}}" required>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Pagar</button>
						</form>
					</div>
					<div class="col-md-6">
						<div class="card-wrapper"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#form-cartao_pacientes').card({
			// a selector or DOM element for the container
			// where you want the card to appear
			container: '.card-wrapper', // *required*

			formSelectors: {
				numberInput: 'input#numero', // optional — default input[name="number"]
				expiryInput: 'input#validade', // optional — default input[name="expiry"]
				cvcInput: 'input#codigo_seg', // optional — default input[name="cvc"]
				nameInput: 'input#nome_impresso' // optional - defaults input[name="name"]
			},

			width: '100%', // optional — default 350px
			formatting: true, // optional - default true

			// Strings for translation - optional
			messages: {
				validDate: 'valid\ndate', // optional - default 'valid\nthru'
				monthYear: 'mm/yy', // optional - default 'month/year'
			},

			// Default placeholders for rendered fields - optional
			placeholders: {
				number: '•••• •••• •••• ••••',
				name: 'Nome Impresso',
				expiry: '••/••',
				cvc: '•••'
			},

			masks: {
				cardNumber: '•' // optional - mask card number
			},

			// if true, will log helpful messages for setting up Card
			debug: {{env('APP_DEBUG') ? 'true' : 'false'}}
		});
	});
</script>
@endpush