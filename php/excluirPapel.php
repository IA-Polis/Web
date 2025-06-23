<?php
// Autor: Isaias
// Gerada em 30/01/2019 12:34:42
// Última atualização em 30/01/2019 12:34:42
// Versão 3.6.0.0
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['excluirPapel'])){
if(isset($_POST['btnExcluirPapel']))
{
    $newPapel = new Classe\Papel();
    $newPapel->setCodPapel($_POST['codPapel']);
    try
    {
        $saida = "<div class='alert alert-success alert-dismissable'>".$newPapel->excluir()."</div>";
        $rest->response($saida,200);
    }
    catch (Exception $exception)
    {
        $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
        $rest->response($saida,500);
    }
}
} else {
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response($saida,401);
}
?>
