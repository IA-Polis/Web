<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_POST['token'])){

    $participante = new \Classe\V3Participante();
    $participante->setToken($_POST['token']);
    $participante->carregarPeloToken();

    if(isset($_POST['btnCadastrarReceituarioV3_4_Agradecimento']) && $participante->getCodParticipante())
    {

        /*$saida = "<div class='alert alert-success alert-dismissable'>".print_r($_POST)."</div>";
        $rest->response($saida,200);*/

        if(isset($_POST['txtFeedback_preocupacoes_outros']) && !empty($_POST['txtFeedback_preocupacoes_outros'])) $participante->setFeedback_preocupacoes_outros($_POST['txtFeedback_preocupacoes_outros']);
        if(isset($_POST['txtFeedback_desvantagens']) && !empty($_POST['txtFeedback_desvantagens'])) $participante->setFeedback_desvantagens($_POST['txtFeedback_desvantagens']);
        if(isset($_POST['txtFeedback_vantagens']) && !empty($_POST['txtFeedback_vantagens'])) $participante->setFeedback_vantagens($_POST['txtFeedback_vantagens']);
        if(isset($_POST['feedback_preocupacoes']) && !empty($_POST['feedback_preocupacoes'])) $participante->setFeedback_preocupacoes($_POST['feedback_preocupacoes']);

        if (
            isset($_POST['txtFeedback_desvantagens']) && !empty($_POST['txtFeedback_desvantagens']) &&
            isset($_POST['txtFeedback_vantagens']) && !empty($_POST['txtFeedback_vantagens']) &&
            isset($_POST['feedback_preocupacoes']) && !empty($_POST['feedback_preocupacoes'])
        )
        {
            try
            {
                $participante->salvar();

                $saida = "<div class='alert alert-success alert-dismissable'>Feedback armazenado com sucesso</div>";
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

            if(!isset($_POST['txtFeedback_desvantagens']) || empty($_POST['txtFeedback_desvantagens'])) $saida .= '<br>Questão de "Desvantagens""';
            if(!isset($_POST['txtFeedback_vantagens']) || empty($_POST['txtFeedback_vantagens'])) $saida .= '<br>Questão "Vantagens"';
            if(!isset($_POST['feedback_preocupacoes']) || empty($_POST['feedback_preocupacoes'])) $saida .= '<br>Questão "Preocupações"';


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
