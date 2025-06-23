<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['cadastrarPapel'])){
	if($_POST['btnCadastrarPapel'])
	{
		$newPapel = new Classe\Papel();		
		$newPapel->setNome($_POST['txtNome']);
		$newPapel->setDescricao($_POST['txtDescricao']);
		if ($_POST['txtNome'])
		{
			try
			{
				$saida =  "<div class='alert alert-success alert-dismissable'>".$newPapel->incluir()."</div>";
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
			$saida =  "<div class='alert alert-danger alert-dismissable'>É necessário preencher o campo nome!".mysql_error()."</div>";
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
