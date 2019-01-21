<?php

namespace App\Http\Controllers;

class UtilController extends Controller
{
	/**
	 * toStr method
	 *
	 * @param string $input
	 * @return string
	 */
	public static function toStr($input)
	{
		$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
				'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
				'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
				'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
				'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ª' => '', 'º' => '' );
	
		$titulo = strtolower(strtr($input, $unwanted_array));
	
		return $titulo;
	}
	
	/**
	 * getBetween method
	 *
	 * @param string $input
	 * @return string
	 */
	public static function getBetween($string, $start = "", $end = "")
	{
	    if (strpos($string, $start)) { // required if $start not exist in $string
	        $startCharCount = strpos($string, $start) + strlen($start);
	        $firstSubStr = substr($string, $startCharCount, strlen($string));
	        $endCharCount = strpos($firstSubStr, $end);
	        if ($endCharCount == 0) {
	            $endCharCount = strlen($firstSubStr);
	        }
	        return substr($firstSubStr, 0, $endCharCount);
	    } else {
	        return '';
	    }
	}
	
	/**
	 * Retira máscara de CPF, CNPJ, Telefone e outros.
	 * @param string $input
	 */
	public static function retiraMascara($input)
	{
// 	   return str_replace(',', '', 
// 	               str_replace('/', '', 
// 	                   str_replace('.', '', 
// 	                       str_replace('-', '', 
// 	                           str_replace('.', '', $input)))));
	    return preg_replace("/[^0-9]/", "", $input);
	}
	
	/**
	 * Trata valor monetário para banco.
	 * Ex.: moedaBanco(1.300,40) retorna 1300.40
	 * 
	 * @param string $input
	 * @return float
	 */
	public static function moedaBanco($input)
	{
		$source = array('.', ',');
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $input); //remove os pontos e substitui a virgula pelo ponto
		return floatval($valor); //retorna o valor formatado para gravar no banco
	}
	
	/**
	 * Formata número para formato de moeda R$.
	 * Ex.: formataMoeda(1300.40) retorna 1.300,40
	 * 
	 * @param float $input
	 * @return string
	 */
	public static function formataMoeda($input)
	{
	    return number_format( $input,  2, ',', '.'); 
	}
	
	/**
	 * Coloca máscara no CPF
	 * Ex.: formataCpf(00812743199); retorna 008.127.431-99
	 * 
	 * @param string $nrCpf
	 */
	public static function formataCpf($nrCpf)
	{
	    $parte_um     = substr($nrCpf, 0, 3);
	    $parte_dois   = substr($nrCpf, 3, 3);
	    $parte_tres   = substr($nrCpf, 6, 3);
	    $parte_quatro = substr($nrCpf, 9, 2);
	    
	    return "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
	}
	
	/**
	 * Coloca máscara no CNPJ
	 * Ex.: formataCnpj(10696691000163); retorna 10.696.691/0001-63
	 *
	 * @param string $nrCpf
	 */
	public static function formataCnpj($nrCnpj)
	{
	    $parte_um     = substr($nrCnpj, 0, 2);
	    $parte_dois   = substr($nrCnpj, 2, 3);
	    $parte_tres   = substr($nrCnpj, 5, 3);
	    $parte_quatro = substr($nrCnpj, 8, 4);
	    $parte_cinto  = substr($nrCnpj, -2);
	    
	    return "$parte_um.$parte_dois.$parte_tres/$parte_quatro-$parte_cinto";
	}
	
	/**
	 * Coloca máscara no CEP
	 * Ex.: formataCep(10696600); retorna 10.696-600
	 *
	 * @param string $nrcep
	 */
	public static function formataCep($nrcep)
	{
	    
	    return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '${1}.${2}-${3}', $nrcep);
	}
	
	/**
	 * gera random string
	 * Ex.: WSWQKTQK92JP15IP
	 *
	 * @param integer $len
	 */
	public static function randHash($len=32)
	{
	    return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
	}
	
	/**
	 * gera token de acesso para o paciente
	 * Ex.: 602154
	 *
	 */
	public static function getAccessToken()
	{
		return sprintf('%06d', rand(0, 999999));
	}
	
	/**
	 * Recebe data de updated_at
	 * o tempo desde esse momento
	 *
	 * Ex.: timeAgo("Y-m-d H:i:s")
	 *
	 * @param string $data
	 * @return \App\Http\Controllers\Carbon
	 */
	public static function timeAgo($time_ago)
	{
	    $time_ago = strtotime($time_ago);
	    $cur_time   = time();
	    $time_elapsed   = $cur_time - $time_ago;
	    $seconds    = $time_elapsed ;
	    $minutes    = round($time_elapsed / 60 );
	    $hours      = round($time_elapsed / 3600);
	    $days       = round($time_elapsed / 86400 );
	    $weeks      = round($time_elapsed / 604800);
	    $months     = round($time_elapsed / 2600640 );
	    $years      = round($time_elapsed / 31207680 );
	    // Seconds
	    if($seconds <= 60){
	        return "Agora mesmo";
	    }
	    //Minutes
	    else if($minutes <=60){
	        if($minutes==1){
	            return "1 min atrás";
	        }
	        else{
	            return "$minutes min atrás";
	        }
	    }
	    //Hours
	    else if($hours <=24){
	        if($hours==1){
	            return "1 hr atrás";
	        }else{
	            return "$hours hrs atrás";
	        }
	    }
	    //Days
	    else if($days <= 7){
	        if($days==1){
	            return "ontem";
	        }else{
	            return "$days dias atrás";
	        }
	    }
	    //Weeks
	    else if($weeks <= 4.3){
	        if($weeks==1){
	            return "1 sem. atrás";
	        }else{
	            return "$weeks semanas";
	        }
	    }
	    //Months
	    else if($months <=12){
	        if($months==1){
	            return "1 mês atrás";
	        }else{
	            return "$months meses";
	        }
	    }
	    //Years
	    else{
	        if($years==1){
	            return "1 ano atrás";
	        }else{
	            return "$years anos";
	        }
	    }
	}
	
	/**
	 * sendSms method
	 *
	 * @param string $number Destinatários que receberam a mensagem. DDD+Número, separados por vírgula caso possua mais de um.
	 * @param string $remetente Nome do Remetente até 32 caracteres. Utilizado somente na organização dos relatórios
	 * @param string $message Conteúdo da mensagem que será enviada. Tamanho máximo de 2048 caracteres.
	 */
	public static function sendSms($number, $remetente, $message)
	{
	    $comtele_api_key = env('COMTELE_API_KEY');
		$url = "https://sms.comtele.com.br/Api/$comtele_api_key/SendMessage";
	
		$data = [
				'content' => $message,
				'sender' => $remetente,
				'receivers' => $number
		];
	
		$fields = http_build_query($data);
		$post = curl_init();
	
		$url = $url.'?'.$fields;
	
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, 1);
		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
	
		$result['status'] = curl_exec($post);
	
		curl_close($post);
	
		if($result['status'] == false) {
			$result['error'] = 'Curl error: ' . curl_error($post);
		}
	
		return $result;
	}
	
	/**
	 * sendMail method
	 *
	 * @param string $number Destinatários que receberam a mensagem. DDD+Número, separados por vírgula caso possua mais de um.
	 * @param string $remetente Nome do Remetente até 32 caracteres. Utilizado somente na organização dos relatórios
	 * @param string $message Conteúdo da mensagem que será enviada. Tamanho máximo de 2048 caracteres.
	 */
	public static function sendMail($to, $from, $subject, $html_message)
	{
		$token = env('SENDGRID_API_KEY');
		$url = 'https://api.sendgrid.com/v3/mail/send';
		 
		if(env('APP_ENV') != 'production') {
			$to = env('APP_EMAIL_DEV') ?? 'vitor.pagani.92@gmail.com';
		}
	
		if(!is_array($to)) {
			$to = [
					[
							'email' => $to,
							'name' => ''
					]
			];
		}
		
		$email = [
				'personalizations' => [[
						'to' => $to,
						'subject' => $subject
				]],
				"from" => [
						'email' => $from,
						'name' => 'Contato DoutorHoje'
				],
				'content' => [[
						'type'=> 'text/html',
						'value' => $html_message
				]]
		];
		 
		$payload = json_encode($email, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		// 	    $payload = '{"personalizations": [{"to": [{"email": "'.$to.'"}]}],"from": {"email": "'.$from.'"},"subject": "'.$subject.'","content": [{"type": "text/html", "value": "'.$html_message.'"}]}';
		 
		//dd($payload);
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		 
		if ($output == "") {
			return true;
		}
		 
		return $output;
	}

	
	/**
	 * @author Felipe Braz
	 * @website https://www.braz.pro.br/blog
	 * @param int $cartao
	 * @param int $cvc
	 * @return array
	 */
	static function validaCartao($cartao, $cvc=false){
		$cartao = preg_replace("/[^0-9]/", "", $cartao);
		if($cvc) $cvc = preg_replace("/[^0-9]/", "", $cvc);

		$cartoes = array(
			'Visa' => array('len' => array(13,16),    'cvc' => 3),
			'MasterCard' => array('len' => array(16),       'cvc' => 3),
			'Diners' => array('len' => array(14,16),    'cvc' => 3),
			'Elo' => array('len' => array(16),       'cvc' => 3),
			'Amex' => array('len' => array(15),       'cvc' => 4),
			'Discover' => array('len' => array(16),       'cvc' => 4),
			'Aura' => array('len' => array(16),       'cvc' => 3),
			'JCB' => array('len' => array(16),       'cvc' => 3),
			'Hipercard'  => array('len' => array(13,16,19), 'cvc' => 3),
		);

		switch($cartao){
			case (bool) preg_match('/^(636368|438935|504175|451416|636297)/', $cartao) :
				$bandeira = 'Elo';
				break;

			case (bool) preg_match('/^(606282)/', $cartao) :
				$bandeira = 'Hipercard';
				break;

			case (bool) preg_match('/^(5067|4576|4011)/', $cartao) :
				$bandeira = 'Elo';
				break;

			case (bool) preg_match('/^(3841)/', $cartao) :
				$bandeira = 'Hipercard';
				break;

			case (bool) preg_match('/^(6011)/', $cartao) :
				$bandeira = 'Discover';
				break;

			case (bool) preg_match('/^(622)/', $cartao) :
				$bandeira = 'Discover';
				break;

			case (bool) preg_match('/^(301|305)/', $cartao) :
				$bandeira = 'Diners';
				break;

			case (bool) preg_match('/^(34|37)/', $cartao) :
				$bandeira = 'Amex';
				break;

			case (bool) preg_match('/^(36,38)/', $cartao) :
				$bandeira = 'Diners';
				break;

			case (bool) preg_match('/^(64,65)/', $cartao) :
				$bandeira = 'Discover';
				break;

			case (bool) preg_match('/^(50)/', $cartao) :
				$bandeira = 'Aura';
				break;

			case (bool) preg_match('/^(35)/', $cartao) :
				$bandeira = 'JCB';
				break;

			case (bool) preg_match('/^(60)/', $cartao) :
				$bandeira = 'Hipercard';
				break;

			case (bool) preg_match('/^(4)/', $cartao) :
				$bandeira = 'Visa';
				break;

			case (bool) preg_match('/^(5)/', $cartao) :
				$bandeira = 'MasterCard';
				break;

			default:
				return array('', false, false);
		}



		$dados_cartao = $cartoes[$bandeira];
		if(!is_array($dados_cartao)) return array(false, false, false);

		$valid     = true;
		$valid_cvc = false;

		if(!in_array(strlen($cartao), $dados_cartao['len'])) $valid = false;
		if($cvc AND strlen($cvc) <= $dados_cartao['cvc'] AND strlen($cvc) !=0) $valid_cvc = true;
		return array($bandeira, $valid, $valid_cvc);
	}
}