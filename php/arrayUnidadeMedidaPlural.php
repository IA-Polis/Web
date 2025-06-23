<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
$estaUnidadeMedida = new Classe\UnidadeMedida();
$colUnidadeMedida = new Config\phpCollection();
$colUnidadeMedida = $estaUnidadeMedida->carregarTodosCriterio('', '');
$saida[0] = "";
if ($colUnidadeMedida->length > 0) {
    do {
        $saida[$colUnidadeMedida->current()->getCodUnidadeMedida()] = mb_strtolower($colUnidadeMedida->current()->getUnidadeMedidaPlural());
    } while ($colUnidadeMedida->has_next());
}

$rest->response(json_encode($saida),200);
?>