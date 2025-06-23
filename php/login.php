<?php
// Autor: Isaias
// Gerada em 23/12/2016 18:24:15
// Última atualização em 23/12/2016 18:24:15
// Gerada pela classe GeradorClasses C# versão 3.1.0.0
?>
<?php require_once("../config/config.php");
use Exception as Exception;
$rest = new Config\REST();
if($_POST['btnLogarUsuario'])
{
    try
    {
        $usuario = new Classe\Usuario();
        if($_POST['txtLogin'] && $_POST['txtSenha'] && $usuario->verificarLoginSenha($_POST['txtLogin'],$_POST['txtSenha']))
        {
        	if($usuario->getVerificado()) {
				session_unset();
				$_SESSION['LOGADO'] = true;
				$_SESSION['NOMEUSUARIO'] = $usuario->getNome();
				$_SESSION['CODIGOUSUARIO'] = $usuario->getCodUsuario();
				if($usuario->getImagem()) $_SESSION['IMAGEMUSUARIO'] = $usuario->getImagem();
				else $_SESSION['IMAGEMUSUARIO'] =$_SESSION['IMAGEMUSUARIO'] = 'defaultUser.png';

				file_put_contents("../log/php/login.txt", date('Y-m-d H:i:s') . " : NOMEUSUARIO = " . $usuario->getNome() . " CODIGOUSUARIO = " . $usuario->getCodUsuario() . " \n ", FILE_APPEND | LOCK_EX);

				$sistema = new Classe\PapelUsuario();

				$colPapelUsuario = $sistema->carregarTodosCriterio("codUsuario", $usuario->getCodUsuario());

				if ($colPapelUsuario->length > 0) {
					do {
						$papelFuncionalidade = new Classe\PapelFuncionalidade();
						$colPapelFuncionalidade = new Config\phpCollection();
						$colPapelFuncionalidade = $papelFuncionalidade->carregarTodosCriterio('codPapel', $colPapelUsuario->current()->getCodPapel());
						if ($colPapelFuncionalidade->length > 0) {
							do {

								$funcionalidade = new Classe\Funcionalidade();
								$funcionalidade->setCodFuncionalidade($colPapelFuncionalidade->current()->getCodFuncionalidade());
								$funcionalidade->carregar();

								$_SESSION['PERMISSOES'][$funcionalidade->getNome()] = 1;

							} while ($colPapelFuncionalidade->has_next());
						}

						$_SESSION['PERMISSOES'][$funcionalidade->getNome()] = 1;

					} while ($colPapelUsuario->has_next());
				}
				$saida = 'Usuário Autenticado!';
				$rest->response($saida, 200);
			}
			else {
				$saida = "<div class='alert alert-danger alert-dismissable'>Usuário não verificado.</div>";
				$rest->response($saida,401);
        	}
        }
        else  throw new Exception("Login inválido. Verifique usuário e senha.",1);
    }
    catch (Exception $exception)
    {
        $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
		$rest->response($saida,500);
    }
}
else
{
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response($saida,401);
}             
?>
