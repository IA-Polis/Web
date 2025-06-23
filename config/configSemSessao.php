<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require '/autoload.php';

//error_reporting(E_ERROR | E_PARSE);
$GLOBALS['NOMESERVIDOR'] = 'localhost';
$GLOBALS['EMAILCONTATO'] = 'email@email.com';
$GLOBALS['DESCRICAOSITE'] = 'IA-Polis';
$GLOBALS['MYSQL_SERVIDOR'] = 'localhost';
$GLOBALS['MYSQL_USUARIO'] = 'localhost';
$GLOBALS['MYSQL_SENHA'] = 'localhost';
$GLOBALS['MYSQL_BANCO'] = 'localhost';
$GLOBALS['SMTP_ENDPOINT'] = '';
$GLOBALS['SMTP_PORT'] = '587';
$GLOBALS['SMTP_USERNAME'] = '';
$GLOBALS['SMTP_PASSWORD'] = '';
$GLOBALS['CAMINHOPADRAO'] = '/localhost';
$GLOBALS['CAMINHOHTML'] = 'https://'.$GLOBALS['NOMESERVIDOR']."/";
$GLOBALS['ACEITA_AUTOCADASTRO'] = false;

$GLOBALS['OPENAI'] = "";
$GLOBALS['HUGGINGFACE'] = "";
$GLOBALS['DEEPINFRA'] = "";

$GLOBALS['GOOGLE_CREDENTIALS'] = '/localhost';

$GLOBALS['PUSHOVERENDPOINT'] = 'https://api.pushover.net/1/messages.json';
$GLOBALS['PUSHOVERTOKEN'] = '';
$GLOBALS['PUSHOVERUSER'] = '';


$GLOBALS['Waha_token'] = "";
$GLOBALS['Waha_session'] = "";

use Exception as Exception;

set_error_handler(function ($errno, $errstr, $errfile = null, $errline)
{
	throw new ErrorException( $errstr, 0, $errno, $errfile, $errline);
}, E_WARNING | E_NOTICE);
?>
