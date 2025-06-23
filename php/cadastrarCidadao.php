<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['cadastrarCidadao'])){
    if(isset($_POST['btnCadastrarCidadao']))
    {
        $newCidadao = new Classe\Cidadao();
        if(isset($_POST['txtNome'])) $newCidadao->setNome($_POST['txtNome']);
        if(isset($_POST['txtIdade'])) $newCidadao->setIdade($_POST['txtIdade']);
        if(isset($_POST['cboSexo'])) $newCidadao->setCodSexo($_POST['cboSexo']);
        $newCidadao->setCodUsuario($_SESSION['CODIGOUSUARIO']);
        if(isset($_POST['cboEscolaridade'])) $newCidadao->setCodEscolaridade($_POST['cboEscolaridade']);
        if (isset($_POST['txtNome']) && isset($_POST['txtIdade']) && isset($_POST['cboSexo']) && isset($_POST['cboEscolaridade']))
        {
            try
            {
                $saida = "<div class='alert alert-success alert-dismissable'>".$newCidadao->incluir()."</div>";
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
            if(!isset($_POST['txtNome'])) $saida .= ' Nome';
            if(!isset($_POST['txtIdade'])) $saida .= ' Idade';
            if(!isset($_POST['cboSexo'])) $saida .= ' Sexo';
            if(!isset($_POST['cboEscolaridade'])) $saida .= ' Escolaridade';
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
