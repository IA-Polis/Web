<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['editarReceituario'])) { ?>
    <?php

    $numeroItemAtual = 0;
    if(isset($_POST['numeroItemAtual'])) $numeroItemAtual = $_POST['numeroItemAtual'];

    $totalItens = 0;
    if(isset($_POST['totalItens'])) $totalItens = $_POST['totalItens'];


    $arrayFeedbackErrosLLM = [];
    $carregarPictogramaAvaliacaoCompreensibilidade = new Classe\PictogramaAvaliacaoCompreensibilidade();
    //print_r($_POST);
    if ($_POST['codPictogramaAvaliacaoCompreensibilidade']) {
        $carregarPictogramaAvaliacaoCompreensibilidade->setCodPictogramaAvaliacaoCompreensibilidade($_POST['codPictogramaAvaliacaoCompreensibilidade']);
        $carregarPictogramaAvaliacaoCompreensibilidade->carregar();
        $_POST['txtDataInclusao'] = $carregarPictogramaAvaliacaoCompreensibilidade->getDataInclusao();
        $_POST['txtSignificado'] = $carregarPictogramaAvaliacaoCompreensibilidade->getSignificado();
        $_POST['txtEntendimento'] = $carregarPictogramaAvaliacaoCompreensibilidade->getEntendimento();
    }

    $pictograma = new \Classe\Pictograma();
    $pictograma->setCodPictograma($carregarPictogramaAvaliacaoCompreensibilidade->getCodPictograma());
    $pictograma->carregar();

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            reforcoStandardSelect();

            $('#editarPictogramaAvaliacaoCompreensibilidade').click(function () {
                overlayStart();
                var feedback_errosLlm = "";
                $('.feedback_errosLlm').each(function (e) {
                    if ($(this).is(":checked")) {
                        if (feedback_errosLlm) feedback_errosLlm = feedback_errosLlm + ";"
                        feedback_errosLlm = feedback_errosLlm + $(this).val();
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: "php/pictograma_testeCompreensibilidade_editar.php",
                    data: {
                        codPictogramaAvaliacaoCompreensibilidade: $('#codPictogramaAvaliacaoCompreensibilidade').val(),
                        txtSignificado: $("#txtSignificado").val(),
                        txtEntendimento: $("#txtEntendimento").val(),
                        numeroAtual: '<?=$numeroItemAtual;?>',
                        btnEditarPictogramaAvaliacaoCompreensibilidade: '1'
                    },
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('#saida').html(data.responseText);
                            overlayStop(true);
                        } else {
                            overlayStop(true);
                            /*setTimeout(() => {
                                $(".proxima").trigger("click");
                            }, "1000");*/

                            $('#saida').html(data.responseText);
                            window.setTimeout(function () {
                                $('#saida').html("");
                            }, 4e3);

                            $(".proximoItem").trigger("click");
                        }
                    }
                });
            });

        });

        function updateRangeValue(value,id) {
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
                    <h4 class="box-title">Imagem <?=$numeroItemAtual." de ".$totalItens;?> <button type="submit" class="btn btn-primary btn-block btn-sm anterior">Anterior</button> <button type="submit" class="btn btn-primary btn-block btn-sm proximoItem">Próximo</button></h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="proximoItem" type="hidden" id="proximoItem" class="proximoItem" value="<?=$_POST['codPictogramaAvaliacaoCompreensibilidade'];?>">
                        <input name="codPictogramaAvaliacaoCompreensibilidade" type="hidden" id="codPictogramaAvaliacaoCompreensibilidade"
                               value="<?= $_POST['codPictogramaAvaliacaoCompreensibilidade']; ?>">
                        <div class="row form-group">
                            <div class="col col-12 col-md-12 centralizado">

                                <img height="200px" width="auto" src="images/pictogramas/<?=$pictograma->getArquivo();?>"/>
                                <br>
                                Esta imagem será encontrado em prescrições de medicamentos.
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>O que esta imagem significa para você?</b>
                                </div>
                                <div class="row range-wrapper">
                                        <textarea rows="2" type='text' class='form-control' id='txtSignificado'
                                                  name='txtSignificado' placeholder=''
                                        ><?=$_POST['txtSignificado'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>O que você entende que pode fazer de acordo com essa imagem?</b>
                                </div>
                                <div class="row range-wrapper">
                                        <textarea rows="2" type='text' class='form-control' id='txtEntendimento'
                                                  name='txtEntendimento' placeholder=''
                                        ><?=$_POST['txtEntendimento'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-block btn-sm anterior">Imagem Anterior (não salvar)</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarPictogramaAvaliacaoCompreensibilidade" name="editarPictogramaAvaliacaoCompreensibilidade">Salvar e ir para o próximo</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
