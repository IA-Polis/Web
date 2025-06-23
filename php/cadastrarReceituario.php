<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['cadastrarReceituario'])){
    if(isset($_POST['btnCadastrarReceituario']))
    {
        $newReceituario = new Classe\Receituario();

        $prompt = new \Classe\Prompt();
        $prompt->carregarPadrao();
        $newReceituario->setCodPrompt($prompt->getCodPrompt());
        $newReceituario->setCodUsuario($_SESSION['CODIGOUSUARIO']);
        $newReceituario->setCodCidadao($_POST['codCidadao']);
        $newReceituario->setDataInclusao(date('Y-m-d H:i:s'));

        try
        {
            $mensagemRetorno = "<div class='alert alert-success alert-dismissable'>".$newReceituario->incluir()."</div>";

            $saida['saida'] = $mensagemRetorno;
            $saida['codReceituario'] = $newReceituario->getCodReceituario();
            $rest->response(json_encode($saida),200);
        }
        catch (Exception $exception)
        {
            $saida['saida'] = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
            $rest->response(json_encode($saida),500);
        }
    }
}
else
{
    $saida['saida'] = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response(json_encode($saida),401);
}
?>
