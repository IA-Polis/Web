<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_POST['btnPictograma_avaliacaoExterna_apresentacao']))
{
    $newPictogramaAvaliacaoExterna = new Classe\PictogramaAvaliacaoExterna();
    if(isset($_POST['txtApresentacao_idade'])) $newPictogramaAvaliacaoExterna->setIdade($_POST['txtApresentacao_idade']);
    if(isset($_POST['txtApresentacao_genero'])) $newPictogramaAvaliacaoExterna->setGenero($_POST['txtApresentacao_genero']);
    if(isset($_POST['txtApresentacao_escolaridade'])) $newPictogramaAvaliacaoExterna->setEscolaridade($_POST['txtApresentacao_escolaridade']);
    $newPictogramaAvaliacaoExterna->setDataInclusao(date('Y-m-d H:i:s'));
    try
    {
        $saida = "<div class='alert alert-success alert-dismissable'>".$newPictogramaAvaliacaoExterna->incluir()."</div>";
        $_SESSION['CodPictogramaAvaliacaoExterna'] = $newPictogramaAvaliacaoExterna->getCodPictogramaAvaliacaoExterna();
        $rest->response($saida,200);
    }
    catch (Exception $exception)
    {
        $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
        $rest->response($saida,500);
    }
}
?>
