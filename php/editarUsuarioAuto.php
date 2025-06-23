<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['LOGADO'])){
	if($_POST['btnEditarUsuario'])
	{
		$newUsuario = new Classe\Usuario();
		$newUsuario->setCodUsuario($_SESSION['CODIGOUSUARIO']);
		$newUsuario->carregar();
		if($newUsuario->getCodUsuario()) {
			if($_POST['txtSenhaNova']) {
				if ($_POST['txtSenhaAtual'] && $newUsuario->verificarLoginSenha($newUsuario->getLogin(), $_POST['txtSenhaAtual'])) {

					if (isset($_POST['txtSenhaNova']) && isset($_POST['txtSenhaNovaConfirmacao']) && $_POST['txtSenhaNova'] != '' && $_POST['txtSenhaNova'] == $_POST['txtSenhaNovaConfirmacao']) {
						$newUsuario->setNome($_POST['txtNome']);
						$newUsuario->setTrocaSenha('');
						$newUsuario->setSenha($_POST['txtSenhaNova']);
						$newUsuario->salvar(1);
						$saida = "<div class='alert alert-success alert-dismissable'>Senha alterada com sucesso!</div>";
						$rest->response($saida, 200);
					} else {
						$saida = '';
						$saida = "<div class='alert alert-danger alert-dismissable'>Senhas não conferem.</div>";
						$rest->response($saida, 400);
					}
				} else {
					$saida = '';
					$saida = "<div class='alert alert-danger alert-dismissable'>Senha atual não confere.</div>";
					$rest->response($saida, 400);
				}
			}

			if (isset($_POST['txtNome']) || isset($_POST['txtImagem'])) {
				try {
					if(isset($_POST['txtNome']))$newUsuario->setNome($_POST['txtNome']);
					if(isset($_POST['txtImagem']))
					{
						$newUsuario->setImagem($_POST['txtImagem']);
						Config\Suporte::resize_image("/tmp/".$_POST['txtImagem'],100,100,false);
						if(!rename("/tmp/".$_POST['txtImagem'],"../images/avatar/".$_POST['txtImagem'])) throw new Exception("Ocorreu um erro ao tentar copiar a imagem!",1);
						$_SESSION['IMAGEMUSUARIO'] = $_POST['txtImagem'];
					}
					$saida = "<div class='alert alert-success alert-dismissable'>" . $newUsuario->salvar() . "</div>";
					$rest->response($saida, 200);
				} catch (Exception $exception) {
					$saida = "<div class='alert alert-danger alert-dismissable'>" . $exception->getMessage() . "</div>";
				}
			} else {
				$saida = '';
				if (!isset($_POST['txtNome'])) $saida .= ' Nome';
				$saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: " . $saida . "</div>";
				$rest->response($saida, 400);
			}


		} else {
			$saida = "<div class='alert alert-danger alert-dismissable'>Usuário não encontrado.</div>";
			$rest->response($saida, 400);
		}
	}
}
else
{
	$saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
	$rest->response($saida,401);
}
?>
