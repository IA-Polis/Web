<?php
/**
 * Created by IntelliJ IDEA.
 * User: isaias
 * Date: 20/06/2017
 * Time: 13:23
 */
namespace Config {
	use Exception as Exception;
	class Pushover
	{

		public static function enviaPush($mensagem,$title=null)
		{
			$postData = array('token' => $GLOBALS['PUSHOVERTOKEN'], 'user' => $GLOBALS['PUSHOVERUSER'], 'message' => $mensagem, 'title' => $title);
			$ch = curl_init($GLOBALS['PUSHOVERENDPOINT']);
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded'
				),
				CURLOPT_POSTFIELDS => http_build_query($postData)
			));

			// Send the request
			$response = curl_exec($ch);
			if ($response === FALSE) {
				throw new Exception("Problemas no CURL Pushover", 1);
			}

			$responseData = json_decode($response, TRUE);
			if (!isset($responseData['status']) || $responseData['status'] != '1') {
				throw new Exception("Problemas na API Pushover:" . print_r($responseData['errors'], true), 1);
			}
		}
	}
}