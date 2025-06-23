<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarPapelUsuario'])){
    if(isset($_POST['btnEditarPapelUsuario']))
    {
        $newPapelUsuario = new Classe\PapelUsuario();
        $newPapelUsuario->setCodPapelUsuario($_POST['codPapelUsuario']);
        $newPapelUsuario->carregar();
        if(isset($_POST['cboUsuario'])) $newPapelUsuario->setCodUsuario($_POST['cboUsuario']);
        if(isset($_POST['cboPapel'])) $newPapelUsuario->setCodPapel($_POST['cboPapel']);
        if (isset($_POST['cboUsuario']) && isset($_POST['cboPapel']))
        {
            try
            {
                $saida = "<div class='alert alert-success alert-dismissable'>".$newPapelUsuario->salvar()."</div>";
                $rest->response($saida,200);
            }
            catch (Exception $exception)
            {
                $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
                $rest->response($saida,500);
            }
        }
        else
        {
            $saida = '';
            if(!isset($_POST['cboUsuario'])) $saida .= ' Usuario';
            if(!isset($_POST['cboPapel'])) $saida .= ' Papel';
            $saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: ".$saida."</div>";
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
