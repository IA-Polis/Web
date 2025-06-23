<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?><?php require_once("../config/config.php");
$rest = new Config\REST();
if (isset($_SESSION['PERMISSOES']['editarUsuario'])) {
	if ($_POST['btnEditarUsuario']) {
		$newUsuario = new Classe\Usuario();
		$newUsuario->setCodUsuario($_POST['codUsuario']);
		$newUsuario->carregar();
		if ($newUsuario->getCodUsuario()) {
			$newUsuario->setNome($_POST['txtNome']);
			$newUsuario->setLogin($_POST['txtLogin']);
			$newUsuario->setSenha($_POST['txtSenha']);
			if ($_POST['txtNome'] && $_POST['txtLogin'] && $_POST['txtSenha']) {
				try {
					$papeisUsuario = new Classe\PapelUsuario();
					$papeisUsuario->setCodUsuario($newUsuario->getCodUsuario());
					$papeisUsuario->excluirUsuario();

					if (isset($_POST['cboPapel']) && !empty($_POST['cboPapel'])) {
						foreach ($_POST['cboPapel'] as $papelUsuario) {
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
					$saida = "<div class='alert alert-success alert-dismissable'>" . $newUsuario->salvar() . "</div>";
					$rest->response($saida, 200);
				} catch (Exception $exception) {
					$saida = "<div class='alert alert-danger alert-dismissable'>" . $exception->getMessage() . "</div>";
				}
			} else {
				$saida = '';
				if (!isset($_POST['txtNome'])) $saida .= ' Nome';
				if (!isset($_POST['txtLogin'])) $saida .= ' Login';
				if (!isset($_POST['txtSenha'])) $saida .= ' Senha';
				$saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: " . $saida . "</div>";
				$rest->response($saida, 400);
			}
		} else {
			$saida = "<div class='alert alert-danger alert-dismissable'>Usuário não encontrado.</div>";
			$rest->response($saida, 400);
		}
	}
} else {
	$saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
	$rest->response($saida, 401);
}
?>
