<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarReceituario'])){
    //print_r($_POST);
    if(isset($_POST['btnEditarReceituario']))
    {
        $newReceituario = new Classe\ReceituarioV2();
        $newReceituario->setCodReceituarioV2($_POST['codReceituarioV2']);
        $newReceituario->carregar();

        if(isset($_POST['txtFeedback_adequacao']) && !empty($_POST['txtFeedback_adequacao'])) $newReceituario->setFeedback_adequacao($_POST['txtFeedback_adequacao']);
        else  $newReceituario->setFeedback_adequacao(0);
        if(isset($_POST['txtFeedback_clareza']) && !empty($_POST['txtFeedback_clareza'])) $newReceituario->setFeedback_clareza($_POST['txtFeedback_clareza']);
        else  $newReceituario->setFeedback_clareza(0);
        if(isset($_POST['txtFeedback_personalizacao']) && !empty($_POST['txtFeedback_personalizacao'])) $newReceituario->setFeedback_personalizacao($_POST['txtFeedback_personalizacao']);
        else  $newReceituario->setFeedback_personalizacao(0);
        if(isset($_POST['txtFeedback_comparacao']) && !empty($_POST['txtFeedback_comparacao'])) $newReceituario->setFeedback_comparacao($_POST['txtFeedback_comparacao']);
        else  $newReceituario->setFeedback_comparacao(0);
        if(isset($_POST['txtFeedback_confianca']) && !empty($_POST['txtFeedback_confianca'])) $newReceituario->setFeedback_confianca($_POST['txtFeedback_confianca']);
        else  $newReceituario->setFeedback_confianca(0);
        if(isset($_POST['txtFeedback_textoLivre']) && !empty($_POST['txtFeedback_textoLivre'])) $newReceituario->setFeedback_textoLivre($_POST['txtFeedback_textoLivre']);
        else  $newReceituario->setFeedback_textoLivre(0);
        if(isset($_POST['txtFeedback_errosLlm']) && !empty($_POST['txtFeedback_errosLlm'])) $newReceituario->setFeedback_errosLLM($_POST['txtFeedback_errosLlm']);
        else  $newReceituario->setFeedback_errosLLM(0);

        if (
            isset($_POST['txtFeedback_adequacao']) &&
            isset($_POST['txtFeedback_clareza']) &&
            isset($_POST['txtFeedback_personalizacao']) &&
            isset($_POST['txtFeedback_comparacao']) &&
            isset($_POST['txtFeedback_confianca'])

        )
        {
            try
            {
                $newReceiturarioHistoricoV2 = new \Classe\ReceituarioV2Historico();
                $newReceiturarioHistoricoV2->setCodReceituarioV2($newReceituario->getCodReceituarioV2());
                $newReceiturarioHistoricoV2->setTextoSaidaModificado($newReceituario->getTextoSaidaModificado());
                $newReceiturarioHistoricoV2->setCodCidadao($newReceituario->getCodCidadao());
                $newReceiturarioHistoricoV2->setMotivoConsulta($newReceituario->getMotivoConsulta());
                $newReceiturarioHistoricoV2->setCodPrompt($newReceituario->getCodPrompt());
                $newReceiturarioHistoricoV2->setDataInclusao($newReceituario->getDataInclusao());
                $newReceiturarioHistoricoV2->setTextoEntrada($newReceituario->getTextoEntrada());
                $newReceiturarioHistoricoV2->setTextoEntradaSistema($newReceituario->getTextoEntradaSistema());
                $newReceiturarioHistoricoV2->setCodUsuario($newReceituario->getCodUsuario());
                $newReceiturarioHistoricoV2->incluir();

                $newReceituario->salvar();

                $saida = "<div class='alert alert-success alert-dismissable'>Avaliação do receituário ".$_POST['numeroAtual']." armazenado com sucesso</div>";
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
            if(!isset($_POST['txtFeedback_adequacao']) || empty($_POST['txtFeedback_adequacao'])) $saida .= ' Questão de Adequação';
            if(!isset($_POST['txtFeedback_clareza']) || empty($_POST['txtFeedback_clareza'])) $saida .= ' Questão de Clareza';
            if(!isset($_POST['txtFeedback_personalizacao']) || empty($_POST['txtFeedback_personalizacao'])) $saida .= ' Questão da Personalização';
            if(!isset($_POST['txtFeedback_comparacao']) || empty($_POST['txtFeedback_comparacao'])) $saida .= ' Questão da Comparação';
            if(!isset($_POST['txtFeedback_confianca']) || empty($_POST['txtFeedback_confianca'])) $saida .= ' Questão da Confiança';

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
