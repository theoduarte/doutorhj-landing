<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>DoutorHoje</title>
    </head>
    <body>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='600' style='text-align:left'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='600' style='text-align:center'><span style='font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#bbb;'>Doutor Hoje - Solicitação de assinatura!</span></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='184' style='background-color: #fff;'>&nbsp;</td>
                <td width='233'><img src='{{ Request::root() }}/img/email/header.png' width='233' height='50' alt=''/></td>
                <td width='183' style='background-color: #fff;'>&nbsp;</td>
          </tr>
    </table><br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 26px; color: #434342; background-color: #fff; text-align: center;'><strong>Contato de Prestador Interessado</strong><br><br>O Prestador abaixo entrou em contato conosco pelo sistema <a href='https://empresarial.doutorhoje.com.br'>https://empresarial.doutorhoje.com.br</a> com interesse de Realizar uma assinatura de plano.</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td ><img src='{{ Request::root() }}/img/email/sombra.png' width='600' height='38' alt=''/></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 18px; line-height: 22px; color: #1d70b7; background-color: #fff;'>Dados informado:</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='130' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'><strong>Nome</strong></td>
			  <td width='410' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{ $nome }}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
	<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='130' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'><strong>E-mail</strong></td>
			  <td width='410' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{ $email }}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
	<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='130' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'><strong>Telefone</strong></td>
			  <td width='410' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{ $telefone }}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
	<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='130' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'><strong>Mensagem</strong></td>
			  <td width='410' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'><em>{{ $mensagem }}</em></td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='120' style='background-color: #1d70b7;'>&nbsp;</td>
                <td width='360' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 46px; background-color: #1d70b7; text-align: center;'><a href='https://doutorhoje.com.br' style='color: #ffffff; text-decoration: none;'>WWW.DOUTORHOJE.COM.BR</a></td>
                <td width='120' style='background-color: #1d70b7;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='225'>&nbsp;</td>
                <td width='30'><a href='https://www.instagram.com/doutor_hoje/'><img src='{{ Request::root() }}/img/email/instagram.png' alt='' width='30' height='31' border='0'/></a></td>
                <td width='30'>&nbsp;</td>
                <td width='30'><img src='{{ Request::root() }}/img/email/facebook.png' width='30' height='30' alt=''/></td>
                <td width='30'>&nbsp;</td>
                <td width='30'><a href='https://wa.me/5561986792680'><img src='{{ Request::root() }}/img/email/whatsapp.png' width='30' height='30' alt=''/></a></td>
                <td width='225'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
    </body>
</html>