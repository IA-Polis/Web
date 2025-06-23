<?php
// Autor: Isaias
// Gerada em 30/01/2019 12:34:40
// Última atualização em 30/01/2019 12:34:40
// Versão 3.6.0.0
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['excluirUsuario'])){
if(isset($_POST['btnExcluirUsuario']))
{
    $newUsuario = new Classe\Usuario();
    $newUsuario->setCodUsuario($_POST['codUsuario']);
    try
    {
        $saida = "<div class='alert alert-success alert-dismissable'>".$newUsuario->excluir()."</div>";
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
