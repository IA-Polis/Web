<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarReceituario'])){
    if(isset($_POST['btnEditarReceituario']))
    {
        $newReceituario = new Classe\Receituario();
        $newReceituario->setCodReceituario($_POST['codReceituario']);
        $newReceituario->carregar();

        if(isset($_POST['txtTextoSaidaModificado'])) $newReceituario->setTextoSaidaModificado($_POST['txtTextoSaidaModificado']);
        //else if(isset($_POST['txtTextoSaida'])) $newReceituario->setTextoSaidaModificado($_POST['txtTextoSaida']);
        if(isset($_POST['txtFeedback_adequacaoOrientacao'])) $newReceituario->setFeedback_adequacaoOrientacao($_POST['txtFeedback_adequacaoOrientacao']);
        if(isset($_POST['txtFeedback_adequacaoOrientacao_justificativa'])) $newReceituario->setFeedback_adequacaoOrientacao_justificativa($_POST['txtFeedback_adequacaoOrientacao_justificativa']);
        if(isset($_POST['txtFeedback_aceitabilidade'])) $newReceituario->setFeedback_aceitabilidade($_POST['txtFeedback_aceitabilidade']);
        if(isset($_POST['txtFeedback_aceitabilidade_justificativa'])) $newReceituario->setFeedback_aceitabilidade_justificativa($_POST['txtFeedback_aceitabilidade_justificativa']);
        if(isset($_POST['txtFeedback_orientacoes'])) $newReceituario->setFeedback_orientacoes($_POST['txtFeedback_orientacoes']);
        if(isset($_POST['txtFeedback_orientacoes_justificativa'])) $newReceituario->setFeedback_orientacoes_justificativa($_POST['txtFeedback_orientacoes_justificativa']);
        if(isset($_POST['txtFeedback_llm'])) $newReceituario->setFeedback_llm($_POST['txtFeedback_llm']);
        //if(isset($_POST['txtMotivoConsulta'])) $newReceituario->setMotivoConsulta($_POST['txtMotivoConsulta']);

        if (
            isset($_POST['txtTextoSaidaModificado']) && !empty($_POST['txtTextoSaidaModificado']) &&
            isset($_POST['txtFeedback_adequacaoOrientacao']) && !empty($_POST['txtFeedback_adequacaoOrientacao']) &&
            isset($_POST['txtFeedback_aceitabilidade']) && !empty($_POST['txtFeedback_aceitabilidade']) &&
            isset($_POST['txtFeedback_orientacoes']) && !empty($_POST['txtFeedback_orientacoes'])

        )
        {
            try
            {
                if($_POST['txtFeedback_adequacaoOrientacao'] < 5 && empty($_POST['txtFeedback_adequacaoOrientacao_justificativa'])){
                    throw new Exception("<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: Justificativa da Questão de Adequação das Orientações");
                }
                if($_POST['txtFeedback_aceitabilidade'] < 5 && empty($_POST['txtFeedback_aceitabilidade_justificativa'])){
                    throw new Exception("<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: Justificativa da Questão de Aceitabilidade");
                }
                if($_POST['txtFeedback_orientacoes'] < 5 && empty($_POST['txtFeedback_orientacoes_justificativa'])){
                    throw new Exception("<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: Justificativa da Questão de Orientações");
                }
                $newReceituarioHistorico = new \Classe\ReceituarioHistorico();
                $newReceituarioHistorico->setCodUsuario($newReceituario->getCodUsuario());
                $newReceituarioHistorico->setCodReceituario($newReceituario->getCodReceituario());
                $newReceituarioHistorico->setCodCidadao($newReceituario->getCodCidadao());
                $newReceituarioHistorico->setDataInclusao(date('Y-m-d H:i:s'));
                $newReceituarioHistorico->setCodPrompt($newReceituario->getCodPrompt());
                $newReceituarioHistorico->setMotivoConsulta($newReceituario->getMotivoConsulta());
                $newReceituarioHistorico->setTextoEntrada($newReceituario->getTextoEntrada());
                $newReceituarioHistorico->setTextoSaidaModificado($newReceituario->getTextoSaidaModificado());
                $newReceituarioHistorico->setTextoSaida($newReceituario->getTextoSaida());
                $newReceituarioHistorico->setSimilaridade($newReceituario->getSimilaridade());
                $newReceituarioHistorico->setFeedback_adequacaoOrientacao($newReceituario->getFeedback_adequacaoOrientacao());
                $newReceituarioHistorico->setFeedback_adequacaoOrientacao_justificativa($newReceituario->getFeedback_adequacaoOrientacao_justificativa());
                $newReceituarioHistorico->setFeedback_aceitabilidade($newReceituario->getFeedback_aceitabilidade());
                $newReceituarioHistorico->setFeedback_aceitabilidade_justificativa($newReceituario->getFeedback_aceitabilidade_justificativa());
                $newReceituarioHistorico->setFeedback_orientacoes($newReceituario->getFeedback_orientacoes());
                $newReceituarioHistorico->setFeedback_orientacoes_justificativa($newReceituario->getFeedback_orientacoes_justificativa());
                $newReceituarioHistorico->setFeedback_llm($newReceituario->getFeedback_llm());
                $newReceituarioHistorico->incluir();

                $saida = "<div class='alert alert-success alert-dismissable'>".$newReceituario->salvar()."</div>";
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
            if(!isset($_POST['txtTextoSaidaModificado']) || empty($_POST['txtTextoSaidaModificado'])) $saida .= ' Texto de Saida';
            if(!isset($_POST['txtFeedback_adequacaoOrientacao']) || empty($_POST['txtFeedback_adequacaoOrientacao'])) $saida .= ' Questão de Adequação da Orientação';
            if(!isset($_POST['txtFeedback_aceitabilidade']) || empty($_POST['txtFeedback_aceitabilidade'])) $saida .= ' Questão de Aceitabilidade';
            if(!isset($_POST['txtFeedback_orientacoes']) || empty($_POST['txtFeedback_orientacoes'])) $saida .= ' Questão de Orientações';

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
