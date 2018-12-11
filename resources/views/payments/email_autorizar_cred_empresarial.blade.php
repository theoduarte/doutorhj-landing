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
		<td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>DoutorHoje - Solicitação de Pré-Agendamento</span></td>
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
		<td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px; font-weight: bold;'>Solicitação de Pré-Agendamento</td>
	</tr>
</table>
<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
		<td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 28px; line-height: 50px; color: #434342; background-color: #fff; text-align: center; font-weight: bold;'>
			Olá, <strong style='color: #1d70b7;'>{{$paciente->empresa->nome_fantasia}}</strong>
		</td>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
	</tr>
</table>
<br>
<br>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
		<td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff;'>
			O colaborador solicitou a utilização do credito empresarial.
		</td>
		<td width='30' style='background-color: #fff;'>&nbsp;</td>
	</tr>
</table>
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
		<td width='30'></td>
		<td width='483' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>
			O colaborador {{$paciente->nm_primario}} {{$paciente->nm_secundario}} está solicitando o uso de R${{number_format($vlPedidoEmpresarial, 2, ',', '.')}} do crédito empresarial.
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
<table width='600' border='0' cellspacing='0' cellpadding='10' align='center'>
	<tr style='background-color: #f9f9f9;'>
		<td width='30'></td>
		<td width='483' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342;'>
			<a href='{{$url}}' target='_blank'>Clique aqui</a> para auttorizar a utilização do crédito empresarial pelo colaborador.
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