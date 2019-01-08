<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<title>DoutorHoje</title>
</head>
<body>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr style='background-color:#fff;'>
		<td width='480' style='text-align:left'>&nbsp;</td>
		<td width='120' style='text-align:right'>&nbsp;</td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr style='background-color:#fff;'>
		<td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoutorHoje - Autorizada utilização do crédito empresarial</span></td>
		<td width='120' style='text-align:right'><a href='#' target='_blank' style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Abrir no navegador</a></td>
	</tr>
</table>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td><img src='https://doutorhoje.com.br/libs/home-template/img/email/h1.png' width='600' height='113' alt='DoutorHoje'/></td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px; font-weight: bold;'>Pagamento do Agendamento</td>
	</tr>
</table>
<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
		<td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
			A <strong>utilização</strong> do crédito empresarial foi aprovada. Agora é necessário realizar o pagamento da diferença
			 no seu cartão pessoal. Abaixo um resumo da transação:
		</td>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
	</tr>
</table>
<br>
<br>

<table width='600' align='center' style='background-color: #fff;'>
	<tr style='background-color: #fff;'>
		<th width='135' style='border:1px solid black;'>Paciente</th>
		<th width='135' style='border:1px solid black;'>Produto</th>
		<th width='135' style='border:1px solid black;'>Preço</th>
	</tr>
	@foreach($agendamentos as $agendamento)
		<tr style='background-color: #fff;'>
			<td width='180' style='border:1px solid black;'>{{$agendamento->paciente->nm_primario}}</td>
			<td width='250' style='border:1px solid black;'>{{$agendamento->atendimento->ds_preco}}</td>
			<td width='40' style='text-align: right; border:1px solid black;'>R$ {{number_format($agendamento->itempedidos()->sum('valor'), 2, ',', '.')}}</td>
		</tr>
	@endforeach
</table>

<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='513'>
			&nbsp;
		</td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='30'></td>
		<td width='483' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>
			O valor aprovado para debitar do crédito empresarial foi R${{number_format($itemPedidoEmpresarial->sum('valor'), 2, ',', '.')}}. Para efeturar o pré-agendamento
			 é necessário pagar a diferença no seu cartão pessoal. <a href='{{$url}}' target='_blank'>Clique aqui</a> para efeturar o pagamento dos
			 R${{number_format($itemPedidoIndividual->sum('valor'), 2, ',', '.')}} restantes.
		</td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='513'>
			&nbsp;
		</td>
	</tr>
</table>

<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
		<td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: justify;'>
			Acompanhe no Perfil do Cliente o <em><strong>status</strong></em> da sua solicitação de
			 agendamento. Evite transtornos! Caso ocorra algum imprevisto,
			 impossibilitando o comparecimento ao serviço contratado, nos
			 informe com até 24 horas de antecedência.
		</td>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
	</tr>
</table>
<br>
<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
		<td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: center;'>
			É um grande satisfação tê-lo como cliente.<br><br>
			Abraços,<br>
			Equipe Doutor Hoje
		</td>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
	</tr>
</table>
<br>
<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='513'>
			&nbsp;
		</td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='209'></td>
		<td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/facebook.png' width='27' height='24' alt=''/></a></td>
		<td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/youtube.png' width='27' height='24' alt=''/></a></td>
		<td width='27'><a href='#'><img src='https://doutorhoje.com.br/libs/home-template/img/email/instagram.png' width='27' height='24' alt=''/></a></td>
		<td width='210'></td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='513'>
			&nbsp;
		</td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='30'></td>
		<td width='540' style='line-height:16px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#434342; text-align: center;'>
			Em caso de qualquer dúvida, fique à vontade <br>
			para responder esse e-mail ou
			nos contatar no <br><br>
			<a href='mailto:cliente@doutorhoje.com.br' style='color:#1d70b7; text-decoration: none;'>cliente@doutorhoje.com.br</a>
			<br><br>
			Ou ligue para 0800 727 3620, o atendimento é de<br>
			segunda à sexta-feira
			das 8h00 às 18h00. <br><br>
			<strong>Doutor Hoje</strong> 2018
		</td>
		<td width='30'></td>
	</tr>
</table>
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='513'>
			&nbsp;
		</td>
	</tr>
</table>
</body>
</html>