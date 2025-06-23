<?php
// Autor: Isaias
// Gerada em 23/12/2016 18:24:15
// Última atualização em 23/12/2016 18:24:15
// Gerada pela classe GeradorClasses C# versão 3.1.0.0
?><?php require_once("../config/config.php");
$rest = new Config\REST();
if ($_POST['btnAlterarSenha']) {
	try {
		$usuario = new Classe\Usuario();
		if (isset($_POST['uid']) && $_POST['uid'] && $usuario->verificarUid($_POST['uid'])) {
			if (isset($_POST['txtNovaSenha']) && isset($_POST['txtNovaSenhaConfirmacao']) && $_POST['txtNovaSenha'] != '' && $_POST['txtNovaSenha'] == $_POST['txtNovaSenhaConfirmacao']) {
				if (isset($_POST['txtLogin']) && $_POST['txtLogin'] && $_POST['txtLogin'] == $usuario->getLogin()) {
					$uid = uniqid();
					$usuario->setTrocaSenha('');
					$usuario->setVerificado(true);
					$usuario->setSenha($_POST['txtNovaSenha']);
					$usuario->salvar(1);
					$saida = "<div class='alert alert-success alert-dismissable'>Senha alterada com sucesso!</div>";
					$rest->response($saida, 200);
				} else {
					$saida = "<div class='alert alert-danger alert-dismissable'>Usuario não confere.</div>";
					$rest->response($saida, 401);
				}
			} else {
				$saida = "<div class='alert alert-danger alert-dismissable'>Senhas não conferem.</div>";
				$rest->response($saida, 401);
			}
		} else {
			$saida = "<div class='alert alert-danger alert-dismissable'>Token Invalido.</div>";
			$rest->response($saida, 401);
		}
	} catch (Exception $exception) {
		$saida = "<div class='alert alert-danger alert-dismissable'>Falha no envio do e-mail! Tente novamente!</div>";
		$rest->response($saida, 500);
	}
}
?>
