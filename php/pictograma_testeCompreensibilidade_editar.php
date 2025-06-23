<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarReceituario'])){
    //print_r($_POST);
    if(isset($_POST['btnEditarPictogramaAvaliacaoCompreensibilidade']))
    {
        $newPictogramaAvaliacaoCompreensibilidade = new Classe\PictogramaAvaliacaoCompreensibilidade();
        $newPictogramaAvaliacaoCompreensibilidade->setCodPictogramaAvaliacaoCompreensibilidade($_POST['codPictogramaAvaliacaoCompreensibilidade']);
        $newPictogramaAvaliacaoCompreensibilidade->carregar();

        if(isset($_POST['txtSignificado']) && !empty($_POST['txtSignificado'])) $newPictogramaAvaliacaoCompreensibilidade->setSignificado($_POST['txtSignificado']);
        else  $newPictogramaAvaliacaoCompreensibilidade->setSignificado("");
        if(isset($_POST['txtEntendimento']) && !empty($_POST['txtEntendimento'])) $newPictogramaAvaliacaoCompreensibilidade->setEntendimento($_POST['txtEntendimento']);
        else  $newPictogramaAvaliacaoCompreensibilidade->setEntendimento("");


        if (
            isset($_POST['txtSignificado'])  && !empty($_POST['txtSignificado']) &&
            isset($_POST['txtEntendimento'])  && !empty($_POST['txtEntendimento'])

        )
        {
            try
            {
                $newPictogramaAvaliacaoCompreensibilidade->setDataInclusao(date('Y-m-d H:i:s'));
                $newPictogramaAvaliacaoCompreensibilidade->salvar();

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
            if(!isset($_POST['txtSignificado']) || empty($_POST['txtSignificado'])) $saida .= ' Questão de Significado';
            if(!isset($_POST['txtEntendimento']) || empty($_POST['txtEntendimento'])) $saida .= ' Questão de Entendimento';

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
