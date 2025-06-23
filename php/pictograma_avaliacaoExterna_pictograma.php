<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_POST['btnCadastrarPictogramaAvaliacaoExternaItem']))
{
    $newPictogramaAvaliacaoExternaItem = new Classe\PictogramaAvaliacaoExternaItem();
    if(isset($_SESSION['CodPictogramaAvaliacaoExterna']))$newPictogramaAvaliacaoExternaItem->setCodPictogramaAvaliacaoExterna($_SESSION['CodPictogramaAvaliacaoExterna']);
    if(isset($_POST['codPictograma'])) $newPictogramaAvaliacaoExternaItem->setCodPictograma($_POST['codPictograma']);
    if(isset($_POST['txtAvaliacao_externa'])) $newPictogramaAvaliacaoExternaItem->setCodPictogramaAvaliacaoExternaOpcao($_POST['txtAvaliacao_externa']);
    if (
        isset($_SESSION['CodPictogramaAvaliacaoExterna']) && !empty($_SESSION['CodPictogramaAvaliacaoExterna']) &&
        isset($_POST['codPictograma']) && !empty($_POST['codPictograma']) &&
        isset($_POST['txtAvaliacao_externa']) && !empty($_POST['txtAvaliacao_externa'])
    )
    {
        try
        {
            $saida = "<div class='alert alert-success alert-dismissable'>".$newPictogramaAvaliacaoExternaItem->incluir()."</div>";
            $_SESSION['PictogramaAvaliacaoExternaItemAtual']++;
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
        if(!isset($_SESSION['CodPictogramaAvaliacaoExterna']) || empty($_SESSION['CodPictogramaAvaliacaoExterna'])) $saida .= ' PictogramaAvaliacaoExterna';
        if(!isset($_POST['codPictograma']) || empty($_POST['codPictograma'])) $saida .= ' Pictograma não selecionado';
        if(!isset($_POST['txtAvaliacao_externa']) || empty($_POST['txtAvaliacao_externa'])) $saida .= ' Selecione uma opção';
        $saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: ".$saida."</div>";
        $rest->response($saida,400);
    }
}
?>
