<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?><?php require_once("../config/config.php");
$rest = new Config\REST();
if (isset($_SESSION['PERMISSOES']['cadastrarUsuario'])) {
	if ($_POST['btnCadastrarUsuario']) {
		$newUsuario = new Classe\Usuario();
		$newUsuario->setNome($_POST['txtNome']);
		$newUsuario->setLogin($_POST['txtLogin']);
		if (isset($_POST['txtSenha']) && $_POST['txtSenha']) $newUsuario->setSenha($_POST['txtSenha']);
		else {
			$_POST['txtSenha'] = uniqid();
			$newUsuario->setSenha($_POST['txtSenha']);
		}
		if (isset($_POST['txtTrocaSenha'])) $newUsuario->setTrocaSenha($_POST['txtTrocaSenha']);
		if ($_POST['txtNome'] && $_POST['txtLogin']) {

			if (filter_var($_POST['txtLogin'], FILTER_VALIDATE_EMAIL)) {
				try {
					echo "<div class='alert alert-success alert-dismissable'>" . $newUsuario->incluir() . "</div>";

					if (isset($_POST['cboPapel']) && !empty($_POST['cboPapel'])) {
						$papeis = explode(',',$_POST['cboPapel']);
						foreach($papeis as $papelUsuario)
						{
							$papel = new Classe\Papel();
							$papel->setCodPapel($papelUsuario);
							$papel->carregar();
							if ($papel->getCodPapel()) {
								$newPapelUsuario = new Classe\PapelUsuario();
								$newPapelUsuario->setCodPapel($papel->getCodPapel());
								$newPapelUsuario->setCodUsuario($newUsuario->getCodUsuario());
								$newPapelUsuario->incluir();
							}
						}
					}

					$newEmail = new Config\EnviarEmail();
					$newEmail->setAssunto($GLOBALS['DESCRICAOSITE'] . ' - Confirmação de Cadastro');
					$newEmail->setDestinatario($_POST['txtLogin']);

					$mensagem = "Confirmação de cadastro<br><br>";
					$mensagem .= "Bem-vindo(a) ao " . $GLOBALS['DESCRICAOSITE'] . "!<br>";
					$mensagem .= "Você foi cadastrado(a) com os seguintes dados:<br>";
					$mensagem .= "Login:" . $_POST['txtLogin'] . "<br>";
					$mensagem .= "Senha:" . $_POST['txtSenha'] . "<br>";
					$mensagem .= "<br><br> " . $GLOBALS['NOMESERVIDOR'];

					$newEmail->setMensagem($mensagem);
					$newEmail->enviarEmail();

					$rest->response($saida, 200);
				} catch (Exception $exception) {
					$saida = "<div class='alert alert-danger alert-dismissable'>" . $exception->getMessage() . "</div>";
					$rest->response($saida, 500);
				}
			} else {
				$saida = "<div class='alert alert-danger alert-dismissable'>Email (login) inválido.</div>";
				$rest->response($saida, 400);
			}
		} else {
			$saida = '';
			if(!isset($_POST['txtNome'])) $saida .= ' Nome';
			if(!isset($_POST['txtLogin'])) $saida .= ' Login';
			if(!isset($_POST['txtSenha'])) $saida .= ' Senha';
			$saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: ".$saida."</div>";
			$rest->response($saida,400);
		}
	}
} else {
	$saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
	$rest->response($saida, 401);
}
?>