<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Controllers\UtilController;
use Whoops\Exception\ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $exception)
    {   
    	$result = '';
    	
    	/* if ($exception instanceof \HttpResponseException) {
    		return $exception->getResponse();
    		
    	} elseif ($exception instanceof ModelNotFoundException) {
    		
    		//$exception = new NotFoundHttpException($exception->getMessage(), $exception);
    		
    		try {
    			$result = str_replace(array('\r','\n'),'','model: '.$exception->getModel().' | message: '.$exception->getMessage().' | code:'.$exception->getCode().' | file:'.$exception->getFile().' | line:'.$exception->getLine());
    			$this->sendException($result);
    		} catch (\Exception $e) {}
    		
    		return response()->view('errors.404', [], 404);
    		
    	} elseif ($exception instanceof \AuthenticationException) {
    		
    		return $this->unauthenticated($request, $exception);
    		
    	} elseif ($exception instanceof \AuthorizationException) {
    		
    		$exception = new HttpException(403, $exception->getMessage());
    		
    	} elseif ($exception instanceof \ValidationException && $exception->getResponse()) {
    		
    		return $exception->getResponse();
    		
    	} elseif ($exception instanceof \ErrorException ) {
    		
    		try {
    			$result = str_replace(array('\r','\n'),'', 'message: '.$exception->getMessage().' | code:'.$exception->getCode().' | file:'.$exception->getFile().' | line:'.$exception->getLine());
    			$this->sendException($result);
    		} catch (\Exception $e) {}
    		
        	return response()->view('errors.500', [], 500);
    	}
    	
    	if ($this->isHttpException($exception)) {
    		return $this->toIlluminateResponse($this->renderHttpException($exception), $exception);
    	} */
    	
        return parent::render($request, $exception);
    }
    
    public function sendException($text_exception) {
    	$from = 'contato@doutorhoje.com.br';
    	$to = 'teocomp@gmail.com';
    	$subject = 'Exceção Sistema DoutorHoje';
    	
    	$text_exception = str_replace('\\', '|', "<pre>model: App\Endereco | message: No query results for model [App\Endereco]  | code:0 | file:/var/www/html/cvxdoutorhj-landing/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php | line:333</pre>");
    	
    	$html_message = <<<HEREDOC
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <title>Log Sistema DoutorHoje</title>
    </head>
    <body style='margin: 0;'>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'>&nbsp;</td>
                <td width='120' style='text-align:right'>&nbsp;</td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr style='background-color:#fff;'>
                <td width='480' style='text-align:left'><span style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Log Sistema DoutorHoje</span></td>
                <td width='120' style='text-align:right'><a href='#' target='_blank' style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#434342;'>Abrir no navegador</a></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td><img src='https://doutorhoje.com.br/libs/home-template/img/email/h1.png' width='600' height='113' alt=''/></td>
            </tr>
        </table>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td style='background: #1d70b7; font-family:Arial, Helvetica, sans-serif; text-align: center; color: #ffffff; font-size: 28px; line-height: 80px;'><strong>Log Sistema DoutorHoje</strong></td>
            </tr>
        </table>
        <br>
        <table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
            <tr>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
                <td width='540' style='font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: #434342; background-color: #fff; text-align: justify;'>
                    <strong>$text_exception</strong>
                </td>
                <td width='30' style='background-color: #fff;'>&nbsp;</td>
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
HEREDOC;
    	 
    	$html_message = str_replace(array("\r", "\n"), '', $html_message);
    	 
    	$send_message = UtilController::sendMail($to, $from, $subject, $html_message);
		UtilController::sendMail('vitor.pagani.92@gmail.com', $from, $subject, $html_message);
    	 
    	echo "<script>console.log( 'Debug Objects: " . $send_message . "' );</script>";
    }
}
