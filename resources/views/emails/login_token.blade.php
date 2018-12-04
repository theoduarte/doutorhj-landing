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
                <td width='600' style='text-align:center'><span style='font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#bbb;'>Doutor Hoje - Novo token de acesso</span></td>
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
                <td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 36px; line-height: 60px;'><strong>Novo token de acesso</strong></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 18px; line-height: 18px; color: #000; background-color: #fff; text-align: center;'>
                    <strong>Olá,</strong> <strong style='color: #1d70b7;'>{{ strtoupper($paciente_nm_primario) }}</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 26px; color: #434342; background-color: #fff; text-align: center;'>
                    Segue abaixo seu <strong>token de acesso</strong>, com seis dígitos, conforme solicitado em <strong>{{$data_solicitacao}}.</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='240' style='background-color: #fff;'>&nbsp;</td>
                <td width='120' style='font-family:Arial, Helvetica, sans-serif; font-size: 20px; line-height: 46px; background-color: #a21b26; text-align: center; color: #fff;'>
                    {{$access_token}}
                </td>
                <td width='240' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height: 26px; color: #434342; background-color: #fff; text-align: center;'>
                    Esse token expira em 2 horas. <br>Enviaremos um novo token a cada vez que acessar a área logada.</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
        <br>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 12px; line-height: 26px; color: #999; background-color: #fff; text-align: center;'>
                    Mensagem automática, por favor não responda a esse e-mail.
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>