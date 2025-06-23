<?php
// Autor: Isaias
// Gerada em 16/01/2019 12:26:14
// Última atualização em 16/01/2019 12:26:14
// Versão 3.5.1.0
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['cadastrarPapelFuncionalidade'])){
    if(isset($_POST['btnCadastrarPapelFuncionalidade']))
    {
        $newPapelFuncionalidade = new Classe\PapelFuncionalidade();
        if(isset($_POST['cboPapel'])) $newPapelFuncionalidade->setCodPapel($_POST['cboPapel']);
        if(isset($_POST['cboFuncionalidade'])) $newPapelFuncionalidade->setCodFuncionalidade($_POST['cboFuncionalidade']);
        if (isset($_POST['cboPapel']) && isset($_POST['cboFuncionalidade']))
        {
            try
            {
                $saida = "<div class='alert alert-success alert-dismissable'>".$newPapelFuncionalidade->incluir()."</div>";
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
            if(!isset($_POST['cboPapel'])) $saida .= ' Papel';
            if(!isset($_POST['cboFuncionalidade'])) $saida .= ' Funcionalidade';
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
