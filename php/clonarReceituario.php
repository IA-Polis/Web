<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['cadastrarReceituario'])){
    if(isset($_POST['btnCadastrarReceituario']))
    {
        try {
            $receituario = new Classe\Receituario();
            $receituario->setCodReceituario($_POST['codReceituario']);
            $receituario->carregar();

            $newReceiturario = new \Classe\Receituario();
            //$newReceiturario->setTextoEntrada($receituario->getTextoEntrada());
            $newReceiturario->setCodUsuario($_SESSION['CODIGOUSUARIO']);
            $newReceiturario->setCodPrompt($receituario->getCodPrompt());
            $newReceiturario->setCodCidadao($receituario->getCodCidadao());
            $newReceiturario->setDataInclusao(date('Y-m-d H:i:s'));
            $newReceiturario->incluir();


            $estaPrescricao = new Classe\Prescricao();
            $colPrescricao = new Config\phpCollection();
            $colPrescricao = $estaPrescricao->carregarTodosCriterio('codReceituario', $receituario->getCodReceituario());

            $texto = "";

            if ($colPrescricao->length > 0) {
                do {
                    $newPrescricao = new \Classe\Prescricao();
                    $newPrescricao->setCodReceituario($newReceiturario->getCodReceituario());
                    $newPrescricao->setCodMedicamento($colPrescricao->current()->getCodMedicamento());
                    $newPrescricao->setCodViaAdministracao($colPrescricao->current()->getCodViaAdministracao());
                    $newPrescricao->setCodPrescricao($colPrescricao->current()->getCodPrescricao());
                    $newPrescricao->setCodUnidadeMedida($colPrescricao->current()->getCodUnidadeMedida());
                    $newPrescricao->setConclusaoTratamento($colPrescricao->current()->getConclusaoTratamento());
                    $newPrescricao->setInicioTratamento($colPrescricao->current()->getInicioTratamento());
                    $newPrescricao->setPosologia($colPrescricao->current()->getPosologia());
                    $newPrescricao->setQuantidadeDose($colPrescricao->current()->getQuantidadeDose());
                    $newPrescricao->setRecomendacoes($colPrescricao->current()->getRecomendacoes());
                    $newPrescricao->incluir();
                } while ($colPrescricao->has_next());
            }


            $saida = "<div class='alert alert-success alert-dismissable'>Clone gerado com sucesso. Verifique a lista de Receituarios</div>";
            $rest->response(json_encode($saida), 200);

        }catch (Exception $ex){
            $saida = "<div class='alert alert-danger alert-dismissable'>".$ex->getMessage()."</div>";
            $rest->response(json_encode($saida),500);
        }
    }
}
else
{
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response(json_encode($saida),401);
}
?>
