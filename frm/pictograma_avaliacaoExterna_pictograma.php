<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php

$numeroItemAtual = $_SESSION['PictogramaAvaliacaoExternaItemAtual'];
$totalItens = $_SESSION['PictogramaAvaliacaoExternaTotal'];

$pictograma = new \Classe\Pictograma();
$pictograma->carregarItemMenosAvaliadoExterno();

$carregarPictogramaAvaliacaoExternaOpcao = new Classe\PictogramaAvaliacaoExternaOpcao();
$colPictogramaAvaliacaoExternaOpcao = new \Config\phpCollection();
$colPictogramaAvaliacaoExternaOpcao = $carregarPictogramaAvaliacaoExternaOpcao->carregarTodosCriterio('codPictograma', $pictograma->getCodPictograma());

?>
<script type="text/javascript">
    $().ready(function () {
        $("form").submit(function (e) {
            e.preventDefault();
            return false;
        });
        $('.saida').html("");
        reforcoStandardSelect();

        $('#cadastrarPictograma_avaliacaoExterna_pictograma').click(function () {
            overlayStart();
            $.ajax({
                method: 'POST',
                url: "php/pictograma_avaliacaoExterna_pictograma.php",
                data: {
                    codPictograma: '<?=$pictograma->getCodPictograma();?>',
                    txtAvaliacao_externa: $("input[type='radio'][name=txtAvaliacao_externa]:checked").val(),
                    btnCadastrarPictogramaAvaliacaoExternaItem: '1'
                },
                complete: function (data, status) {
                    if (status === 'error' || !data.responseText) {
                        console.log(data);
                        $('#saida').html(data.responseText);
                        overlayStop(true);
                    } else {
                        console.log("proximaEtapaPictograma");
                        overlayStop(true);

                        $('#saida').html(data.responseText);
                        window.setTimeout(function () {
                            $('#saida').html("");
                            $(".proximaEtapaPictograma").trigger("click");
                        }, 1e3);
                    }
                }
            });
        });

    });

    function updateRangeValue(value, id) {
        document.getElementById(id).textContent = value + "%";
    }
</script>
<style>
    .centralizado {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="box-title">Imagem <?= $numeroItemAtual . " de " . $totalItens; ?></h4>
            </div>
            <div class="card-body card-block">
                <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col col-12 col-md-12">

                            <img height="200px" width="auto" src="images/pictogramas/<?= $pictograma->getArquivo(); ?>"/>
                            <br>
                            Esta imagem será encontrado em prescrições de medicamentos.
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <b>O que este símbolo significa?</b>
                            <div class="row form-group">
                                <?
                                $auxOpcao = 1;
                                do {
                                    ?>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="avaliacao_externa" id='txtAvaliacao_externa_<?=$auxOpcao;?>'
                                               name='txtAvaliacao_externa'
                                               placeholder=''
                                               value='<?=$colPictogramaAvaliacaoExternaOpcao->current()->getCodPictogramaAvaliacaoExternaOpcao();?>'/>
                                        <label for="txtAvaliacao_externa_<?=$auxOpcao;?>"><?=$colPictogramaAvaliacaoExternaOpcao->current()->getTexto();?></label>
                                    </div>
                                    <?
                                    $auxOpcao++;
                                } while ($colPictogramaAvaliacaoExternaOpcao->has_next());
                                ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarPictograma_avaliacaoExterna_pictograma" name="cadastrarPictograma_avaliacaoExterna_pictograma">Salvar e ir para o próximo</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
</div>
