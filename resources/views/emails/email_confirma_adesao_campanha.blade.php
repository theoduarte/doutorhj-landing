<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>Doutor Hoje</title>
    </head>
    <body>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='600' style='text-align:left'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='600' style='text-align:center'><span style='font-family:Verdana, Helvetica, sans-serif; font-size:10px; color:#bbb;'>Doutor Hoje - Bem vindo ao Doutor Hoje!</span></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='184' style='background-color: #fff;'>&nbsp;</td>
                <td width='233'><img src='{{ Request::root() }}/img/logo-home-header.png' width='233' height='50' alt=''/></td>
                <td width='183' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Verdana, Helvetica, sans-serif; font-size: 32px; line-height: 26px; color: #434342; background-color: #fff; text-align: center;'><strong>Bem-Vindo!</strong></td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 26px; color: #434342; background-color: #fff;'>Obrigado por assinar o Doutor Hoje. Sua inscrição está pronta, para utilizar os benefícios acesse <a href='www.doutorhoje.com.br'>www.doutorhoje.com.br</a> e faça login com seu número de celular.</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Verdana, Helvetica, sans-serif; font-size: 18px; line-height: 22px; color: #1d70b7; background-color: #fff;'>Dados informados</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>Nome:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$nome_completo}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>CPF:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$cpf}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>E-mail:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$paciente_email}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>Gênero:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$cs_sexo}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>Nascimento:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$dt_nascimento}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>Celular:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$ds_contato}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='108' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: #333; background-color: #fff;'><strong>Empresa:</strong></td>
                <td width='432' style='font-family:Verdana, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #333; background-color: #fff;'>{{$nm_fantasia}}</td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #1d70b7;'>&nbsp;</td>
                <td width='540' style='font-family:Verdana, Helvetica, sans-serif; font-size: 16px; line-height: 46px; background-color: #1d70b7; text-align: center;'><a href='https://doutorhoje.com.br' style='color: #ffffff; text-decoration: none;'>Acesse o Doutor Hoje para utilizar os benefícios</a></td>
                <td width='30' style='background-color: #1d70b7;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='225'>&nbsp;</td>
                <td width='30'><a href='https://www.instagram.com/doutor_hoje/'><img src='{{ Request::root() }}/img/email/instagram.png' alt='' width='30' height='31' border='0'/></a></td>
                <td width='30'>&nbsp;</td>
                <td width='30'><a href='https://www.facebook.com/DoctorHoje/'><img src='{{ Request::root() }}/img/email/facebook.png' width='30' height='30' alt=''/></a></td>
                <td width='30'>&nbsp;</td>
                <td width='30'><a href='https://wa.me/5561986792680'><img src='{{ Request::root() }}/img/email/whatsapp.png' width='30' height='30' alt=''/></a></td>
                <td width='225'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
    </body>
</html>