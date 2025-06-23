<?php
// Autor: Isaias
// Gerada em 23/12/2016 18:24:15
// Última atualização em 23/12/2016 18:24:15
// Gerada pela classe GeradorClasses C# versão 3.1.0.0
?><?php require_once("../config/config.php");
$rest = new Config\REST();
if ($_POST['btnRecuperarEmail']) {
	try {
		$usuario = new Classe\Usuario();
		if ($_POST['txtLogin'] && $usuario->verificarLogin($_POST['txtLogin'])) {
			if (filter_var($_POST['txtLogin'], FILTER_VALIDATE_EMAIL)) {
				$uid = uniqid();
				$usuario->setTrocaSenha($uid);
				$usuario->salvar('');

				$newEmail = new Config\EnviarEmail();
				$newEmail->setAssunto('Recuperação de senha');
				$newEmail->setDestinatario($usuario->getLogin(), $usuario->getNome());

				$mensagem = "Olá! <br><br> Você nos enviou uma solicitação de troca de senha?<br>Caso positivo clique no link abaixo:<br><br>";
				$mensagem .= "http://" . $GLOBALS['NOMESERVIDOR'] . "/index.php?recuperar=" . $uid;
				$mensagem .= "<br><br> Caso não tenha solicitado a troca de senha, favor ignorar essa mensagem";

				$newEmail->setMensagem($mensagem);
				$newEmail->enviarEmail();

				$saida = "<div class='alert alert-success alert-dismissable'>E-mail enviado com sucesso! Verifique seu e-mail para recuperar sua senha.</div>";
				$rest->response($saida, 200);
			} else {
				$saida = "<div class='alert alert-danger alert-dismissable'>E-mail inválido.</div>";
				$rest->response($saida, 401);
			}
		} else {
			$saida = "<div class='alert alert-danger alert-dismissable'>E-mail inválido.</div>";
			$rest->response($saida, 401);
		}
	} catch (Exception $exception) {
		$saida = "<div class='alert alert-danger alert-dismissable'>Falha no envio do e-mail! Tente novamente!</div>";
		$rest->response($saida, 500);
	}
} else {
	$saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
	$rest->response($saida, 401);
}
?>