<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['excluirPapelFuncionalidade'])){
if(isset($_POST['btnExcluirPapelFuncionalidade']))
{
    $newPapelFuncionalidade = new Classe\PapelFuncionalidade();
    $newPapelFuncionalidade->setCodPapelFuncionalidade($_POST['codPapelFuncionalidade']);
    try
    {
        $saida = "<div class='alert alert-success alert-dismissable'>".$newPapelFuncionalidade->excluir()."</div>";
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
