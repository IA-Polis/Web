<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/configSemSessao.php"); ?>
<?php
try {
    if (!empty($_POST['id'])) {

        $participante = new \Classe\V3Participante();
        $participante->setToken($_POST['id']);
        $participante->carregarPeloToken();

        //echo $participante->getCodParticipante();

        $receituarioV3 = new \Classe\V3Receituario();

        if ($participante->getCodParticipante()) {

            $colReceituarioV3 = new \Config\phpCollection();
            $colReceituarioV3 = $receituarioV3->carregarTodosCriterio('codParticipante', $participante->getCodParticipante());

            $etapa = 1;
            $codReceituarioV3 = 0;

            if ($colReceituarioV3->length == 0) {
                $distribuicao = new \Classe\V3Distribuicao();
                $colDistribuicao = new \Config\phpCollection();
                $colDistribuicao = $distribuicao->carregarListaProximo($participante->getCodTipoParticipante());
                if ($colDistribuicao->length) {
                    $first = true;

                    do {
                        $newReceituario = new \Classe\V3Receituario();
                        $newReceituario->setCodParticipante($participante->getCodParticipante());
                        $newReceituario->setCodPrompt($colDistribuicao->current()->getCodPrompt());
                        $newReceituario->setCodContexto($colDistribuicao->current()->getCodContexto());
                        $newReceituario->setDataInclusao(date('Y-m-d H:i:s'));
                        $newReceituario->incluir();

                        if ($first) {
                            $first = false;
                            $receituario = $newReceituario;
                            $participante->setNumero($colDistribuicao->current()->getNumero());
                            $participante->salvar();
                        }
                    } while ($colDistribuicao->has_next());
                } else {
                    throw new Exception("Não foi possível carregar a distribuição. Entre em contato, por gentileza, pelo e-mail iapolis@medicina.ufmg.br");
                }

            }

            $colReceituarioV3 = new \Config\phpCollection();
            $colReceituarioV3 = $receituarioV3->carregarTodosCriterio('codParticipante', $participante->getCodParticipante());

            $numeroItemAtual = 0;
            $totalItens = $colReceituarioV3->length;

            $sair = false;
            $first = true;

            if ($colReceituarioV3->length) {
                do {
                    if (empty($colReceituarioV3->current()->getCodMedicamento()) && $first) {
                        $etapa = 1;
                        $sair = true;
                    } else if (empty($colReceituarioV3->current()->getCodMedicamento())) {
                        $etapa = 2;
                        $sair = true;
                    } else if (empty($colReceituarioV3->current()->getFeedback_sus_correto())) {
                        $etapa = 3;
                        $sair = true;
                    }
                    $numeroItemAtual++;
                    $codReceituarioV3 = $colReceituarioV3->current()->getCodReceituarioV3();
                    $first = false;
                } while ($colReceituarioV3->has_next() && !$sair);
            }
            if(!$sair){
                $etapa = 4;
            }
            $colReceituarioV3->rewind();
            ?>


            <div id="saida"></div>
            <div id="receituarioV3"></div>


            <script type="text/javascript">
                $().ready(function () {
                    var arrayReceituarioV3 = [];
                    var auxReceituarioV3 = 0;

                    <?
                    if ($colReceituarioV3->length) {
                        do{
                            ?>
                            arrayReceituarioV3[auxReceituarioV3++] = "<?=$colReceituarioV3->current()->getCodReceituarioV3();?>";
                            <?
                        } while ($colReceituarioV3->has_next());
                    }
                    ?>
                    $("form").submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                    var etapa = '<?=$etapa;?>';
                    let token = '<?=$participante->getToken();?>';
                    let codReceituarioV3 = '<?=$codReceituarioV3;?>';
                    let numeroItemAtual = '<?=$numeroItemAtual;?>';
                    let totalItens = '<?=$totalItens;?>';

                    //console.log(etapa);
                    //console.log("Numero atual: "+numeroItemAtual);

                    goEtapa();

                    $(document).one('click', ".proximaEtapa", function () {
                        etapa++;
                        //console.log(etapa);
                        goEtapa();
                    });

                    function goEtapa() {
                        if (etapa == 1) {
                            $.ajax({
                                method: 'POST',
                                url: "frm/cadastrarReceituarioV3_1_Apresentacao.php",
                                data: {
                                    token: token,
                                    numeroItemAtual: numeroItemAtual,
                                    totalItens: totalItens
                                },
                                complete: function (data, status) {
                                    if (status === 'error' || !data.responseText) {
                                        //console.log(data);
                                        $('#saida').html(data.responseText);
                                        overlayStop(true);
                                    } else {
                                        overlayStop(true);
                                        $('#receituarioV3').html(data.responseText);
                                    }
                                }
                            });
                        } else if (etapa == 2) {
                            //console.log("FOI PARA "+etapa);
                            $.ajax({
                                method: 'POST',
                                url: "frm/cadastrarReceituarioV3_2_Prescricao.php",
                                data: {
                                    codReceituarioV3: codReceituarioV3,
                                    numeroItemAtual: numeroItemAtual,
                                    totalItens: totalItens,
                                    arrayReceituarioV3:arrayReceituarioV3,
                                    token: token
                                },
                                complete: function (data, status) {

                                    if (status === 'error' || !data.responseText) {
                                        console.log(data);
                                        $('#saida').html(data.responseText);
                                        overlayStop(true);
                                    } else {
                                        console.log("ELSE");
                                        overlayStop(true);
                                        $('#receituarioV3').html(data.responseText);
                                    }
                                }
                            });
                        } else if (etapa == 3) {
                            //console.log("FOI PARA "+etapa);
                            $.ajax({
                                method: 'POST',
                                url: "frm/cadastrarReceituarioV3_3_Avaliacao.php",
                                data: {
                                    codReceituarioV3: codReceituarioV3,
                                    numeroItemAtual: numeroItemAtual,
                                    totalItens: totalItens,
                                    arrayReceituarioV3:arrayReceituarioV3,
                                    token: token
                                },
                                complete: function (data, status) {
                                    if (status === 'error' || !data.responseText) {
                                        //console.log(data);
                                        $('#saida').html(data.responseText);
                                        overlayStop(true);
                                    } else {
                                        overlayStop(true);
                                        $('#receituarioV3').html(data.responseText);
                                    }
                                }
                            });
                        } else if (etapa >= 4) {
                            $.ajax({
                                method: 'POST',
                                url: "frm/cadastrarReceituarioV3_4_Agradecimento.php",
                                data: {
                                    codReceituarioV3: codReceituarioV3,
                                    token: token
                                },
                                complete: function (data, status) {
                                    if (status === 'error' || !data.responseText) {
                                        //console.log(data);
                                        $('#saida').html(data.responseText);
                                        overlayStop(true);
                                    } else {
                                        overlayStop(true);
                                        $('#receituarioV3').html(data.responseText);
                                    }
                                }
                            });
                        }
                    }
                });
            </script>
            <?php

        } else {
            echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
        }
    } else
        echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
} catch (Exception $e) {
    echo "<div class='alert alert-danger alert-dismissable'><p>" . $e->getMessage() . "</p></div>";
}
