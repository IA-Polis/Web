<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarPapelFuncionalidade']))
{
	if($_POST['btnEditarPapelFuncionalidade'])
	{
		if ($_POST['codPapel'])
		{
			try
			{				
				$apagarPapeisFuncinalidades = new Classe\PapelFuncionalidade();
				$apagarPapeisFuncinalidades->setCodPapel($_POST['codPapel']);
				$apagarPapeisFuncinalidades->excluirPeloPapel();

				if(isset($_POST['cboFuncionalidade']) && is_array($_POST['cboFuncionalidade']))
				{
					for ($aux = 0; $aux < count($_POST['cboFuncionalidade']); $aux++)
					{
						$newPapelFuncionalidade = new Classe\PapelFuncionalidade;
						$newPapelFuncionalidade->setCodPapel($_POST['codPapel']);
						$newPapelFuncionalidade->setCodFuncionalidade($_POST['cboFuncionalidade'][$aux]['value']);
						$saida = $newPapelFuncionalidade->incluir();
					}
				}

				$saida =  "<div class='alert alert-success alert-dismissable'>$saida</div>";
				$rest->response($saida,200);
			}
			catch (Exception $exception)
			{
				$saida =  "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
				$rest->response($saida,500);
			}
		}
		else 
		{
			$saida =  "<div class='alert alert-danger alert-dismissable'>É necessário preencher TODOS os campos!".mysql_error()."</div>";
			$rest->response($saida,400);
		}
	}
}
else
{
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response($saida,401);
}
?>
