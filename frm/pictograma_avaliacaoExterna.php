<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php
try {

    $_SESSION['CodPictogramaAvaliacaoExterna'] = null;
    $_SESSION['PictogramaAvaliacaoExternaTotal'] = 5;
    $_SESSION['PictogramaAvaliacaoExternaItemAtual'] = 1;

    if (isset($_SESSION['CodPictogramaAvaliacaoExterna'])) {


        $pictogramaAvaliacaoExterna = new \Classe\PictogramaAvaliacaoExterna();
        $pictogramaAvaliacaoExterna->setCodPictogramaAvaliacaoExterna($_SESSION['CodPictogramaAvaliacaoExterna']);
        $pictogramaAvaliacaoExterna->carregar();

        if ($pictogramaAvaliacaoExterna->getCodPictogramaAvaliacaoExterna()) {

            $pictogramaAvaliacaoExternaItem = new \Classe\PictogramaAvaliacaoExternaItem();

            $colPictogramaAvaliacaoExternaItem = new \Config\phpCollection();
            $colPictogramaAvaliacaoExternaItem = $pictogramaAvaliacaoExternaItem->carregarTodosCriterio('codPictogramaAvaliacaoExterna', $pictogramaAvaliacaoExterna->getCodPictogramaAvaliacaoExterna());

            if ($colPictogramaAvaliacaoExternaItem->length < $_SESSION['PictogramaAvaliacaoExternaTotal']) {
                $etapa = 2;
                $_SESSION['PictogramaAvaliacaoExternaItemAtual'] = $colPictogramaAvaliacaoExternaItem->length + 1;
            } else {
                $etapa = 3;
            }
        } else {
            $etapa = 1;
        }
    } else $etapa = 1;
    ?>


    <div id="saida"></div>
    <div id="pictogramaAvaliacaoExterna"></div>


    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
            var total = '<?=$_SESSION['PictogramaAvaliacaoExternaTotal'];?>';
            var atual = '<?=$_SESSION['PictogramaAvaliacaoExternaItemAtual'];?>';
            var etapa = '<?=$etapa;?>';

            goEtapa();

            $('#proximaEtapaPictograma').click(function() {
                console.log(etapa);
                console.log(atual);
                console.log(total);
                atual++;
                if(etapa == 2 && atual <= total) goEtapa();
                else {
                    etapa++;
                    goEtapa();
                }
            });

            $(document).one('click', ".proximaEtapaApresentacao", function () {
                etapa++;
                goEtapa();
            });



            function goEtapa() {

                if (etapa == 1) {
                    $.ajax({
                        method: 'POST',
                        url: "frm/pictograma_avaliacaoExterna_apresentacao.php",
                        data: {},
                        complete: function (data, status) {
                            if (status === 'error' || !data.responseText) {
                                //console.log(data);
                                $('#saida').html(data.responseText);
                                overlayStop(true);
                            } else {
                                overlayStop(true);
                                $('#pictogramaAvaliacaoExterna').html(data.responseText);
                            }
                        }
                    });
                } else if (etapa == 2) {
                    //console.log("FOI PARA "+etapa);
                    $.ajax({
                        method: 'POST',
                        url: "frm/pictograma_avaliacaoExterna_pictograma.php",
                        data: {},
                        complete: function (data, status) {
                            if (status === 'error' || !data.responseText) {
                                //console.log(data);
                                $('#saida').html(data.responseText);
                                overlayStop(true);
                            } else {
                                overlayStop(true);
                                $('#pictogramaAvaliacaoExterna').html(data.responseText);
                            }
                        }
                    });
                } else if (etapa >= 3) {
                    $.ajax({
                        method: 'POST',
                        url: "frm/pictograma_avaliacaoExterna_agradecimento.php",
                        data: {},
                        complete: function (data, status) {
                            if (status === 'error' || !data.responseText) {
                                //console.log(data);
                                $('#saida').html(data.responseText);
                                overlayStop(true);
                            } else {
                                overlayStop(true);
                                $('#pictogramaAvaliacaoExterna').html(data.responseText);
                            }
                        }
                    });
                }
            }
        });
    </script>
    <input name="proximaEtapaPictograma" type="hidden" id="proximaEtapaPictograma" class="proximaEtapaPictograma" value="1">
    <?php
} catch (Exception $e) {
    echo "<div class='alert alert-danger alert-dismissable'><p>" . $e->getMessage() . "</p></div>";
}
