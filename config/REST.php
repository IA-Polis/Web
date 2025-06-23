<?php
/* File : Rest.inc.php
 * Author : Arun Kumar Sekar
*/
namespace Config {
	class REST
	{

		public $_allow = array();
		public $_content_type = "application/json";
		public $_request = array();

		private $_method = "";
		private $_code = 200;

		public function __construct()
		{
			// Allow from any origin
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
				// you want to allow, and if so:
				header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
				header('Access-Control-Allow-Credentials: true');
				header('Access-Control-Max-Age: 86400');    // cache for 1 day
			}

			// Access-Control headers are received during OPTIONS requests
			if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

				if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
					// may also be using PUT, PATCH, HEAD etc
					header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

				if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
					header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

				exit(0);
			}
			$this->inputs();
		}

		public function get_referer()
		{
			return $_SERVER['HTTP_REFERER'];
		}

		public function response($data, $status)
		{
			$this->_code = ($status) ? $status : 200;
			$this->set_headers();
			echo $data;
			exit;
		}

		private function get_status_message()
		{
			$status = array(
				100 => 'Continue',
				101 => 'Switching Protocols',
				200 => 'OK',
				201 => 'Created',
				202 => 'Accepted',
				203 => 'Non-Authoritative Information',
				204 => 'No Content',
				205 => 'Reset Content',
				206 => 'Partial Content',
				300 => 'Multiple Choices',
				301 => 'Moved Permanently',
				302 => 'Found',
				303 => 'See Other',
				304 => 'Not Modified',
				305 => 'Use Proxy',
				306 => '(Unused)',
				307 => 'Temporary Redirect',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				402 => 'Payment Required',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				406 => 'Not Acceptable',
				407 => 'Proxy Authentication Required',
				408 => 'Request Timeout',
				409 => 'Conflict',
				410 => 'Gone',
				411 => 'Length Required',
				412 => 'Precondition Failed',
				413 => 'Request Entity Too Large',
				414 => 'Request-URI Too Long',
				415 => 'Unsupported Media Type',
				416 => 'Requested Range Not Satisfiable',
				417 => 'Expectation Failed',
				422 => 'User already exists',
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				502 => 'Bad Gateway',
				503 => 'Service Unavailable',
				504 => 'Gateway Timeout',
				505 => 'HTTP Version Not Supported');
			return ($status[$this->_code]) ? $status[$this->_code] : $status[500];
		}

		public function get_request_method()
		{
			return $_SERVER['REQUEST_METHOD'];
		}

		private function inputs()
		{
			switch ($this->get_request_method()) {
				case "POST":
					$saidaPost2 = json_decode(file_get_contents('php://input'), true);
					if (!$saidaPost2) $saidaPost2 = $_POST;
					$this->_request = $this->cleanInputs($saidaPost2);
					break;
				case "GET":
				case "DELETE":
					$this->_request = $this->cleanInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"), $this->_request);
					$this->_request = $this->cleanInputs($this->_request);
					break;
				default:
					$this->response('', 406);
					break;
			}
		}

		private function cleanInputs($data)
		{
			$clean_input = array();
			if (is_array($data)) {
				foreach ($data as $k => $v) {
					$clean_input[$k] = $this->cleanInputs($v);
				}
			} else {
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}

		private function set_headers()
		{
			header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
			header("Content-Type:" . $this->_content_type);
		}

		private function getAuthorizationHeader(){
			$headers = null;
			if (isset($_SERVER['Authorization'])) {
				$headers = trim($_SERVER["Authorization"]);
			}
			else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
				$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
			} elseif (function_exists('apache_request_headers')) {
				$requestHeaders = apache_request_headers();
				// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
				$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
				//print_r($requestHeaders);
				if (isset($requestHeaders['Authorization'])) {
					$headers = trim($requestHeaders['Authorization']);
				}
			}
			return $headers;
		}
		/**
		 * get access token from header
		 * */
		public function getBearerToken() {
			$headers = $this->getAuthorizationHeader();
			// HEADER: Get the access token from the header
			if (!empty($headers)) {
				if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
					return $matches[1];
				}
			}
			return null;
		}
	}
}
?>