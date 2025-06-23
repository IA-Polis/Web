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
    $carregarReceituario = new Classe\ReceituarioV2();
    //print_r($_POST);
    if ($_POST['codReceituarioV2']) {
        $carregarReceituario->setCodReceituarioV2($_POST['codReceituarioV2']);
        $carregarReceituario->carregar();
        $_POST['cboPrompt'] = $carregarReceituario->getCodPrompt();
        $_POST['cboUsuario'] = $carregarReceituario->getCodUsuario();
        $_POST['txtDataInclusao'] = $carregarReceituario->getDataInclusao();
        $_POST['txtMotivoConsulta'] = $carregarReceituario->getMotivoConsulta();
        $_POST['txtTextoEntrada'] = $carregarReceituario->getTextoEntrada();
        $_POST['txtTextoSaida'] = $carregarReceituario->getTextoSaida();
        $_POST['txtTextoSaidaModificado'] = $carregarReceituario->getTextoSaidaModificado();
        $_POST['txtFeedback_adequacao'] = $carregarReceituario->getFeedback_adequacao();
        $_POST['txtFeedback_clareza'] = $carregarReceituario->getFeedback_clareza();
        $_POST['txtFeedback_personalizacao'] = $carregarReceituario->getFeedback_personalizacao();
        $_POST['txtFeedback_comparacao'] = $carregarReceituario->getFeedback_comparacao();
        $_POST['txtFeedback_confianca'] = $carregarReceituario->getFeedback_confianca();
        $_POST['txtFeedback_textoLivre'] = $carregarReceituario->getFeedback_textoLivre();

        if (!empty($carregarReceituario->getFeedback_errosLLM())) $arrayFeedbackErrosLLM = explode(';', $carregarReceituario->getFeedback_errosLLM());
    }

    $estaPrescricao = new Classe\Prescricao();
    $colPrescricao = new Config\phpCollection();
    $colPrescricao = $estaPrescricao->carregarTodosCriterio('codReceituarioV2', $carregarReceituario->getCodReceituarioV2());

    $prompt = new \Classe\Prompt();
    if ($carregarReceituario->getCodPrompt()) {
        $prompt->setCodPrompt($carregarReceituario->getCodPrompt());
        $prompt->carregar();
    } else {
        $prompt->setCodPrompt(25);
        $prompt->carregar();
    }


    $cidadao = new \Classe\Cidadao();
    $sexo = new \Classe\Sexo();
    $escolaridade = new \Classe\Escolaridade();
    if (isset($_POST['codCidadao'])) {
        $cidadao->setCodCidadao($_POST['codCidadao']);
        $cidadao->carregar();

        $sexo->setCodSexo($cidadao->getCodSexo());
        $sexo->carregar();

        $escolaridade->setCodEscolaridade($cidadao->getCodEscolaridade());
        $escolaridade->carregar();
    }

    $cidadaoTexto = "Nome:" . $cidadao->getNome() . "<br>Sexo:" . $sexo->getNome() . "<br>Escolaridade:" . $escolaridade->getEscolaridade();

    $esconderMotivo = true;
    if (!$carregarReceituario->getTextoEntrada()) {
        $estaPrescricao = new Classe\Prescricao();
        $saidaTextoPrescricao = nl2br($estaPrescricao->gerarTextoPrescricao(null, $carregarReceituario->getCodReceituarioV2()));


        $texto = "";

        if ($saidaTextoPrescricao) {
        } else {
            $texto = "Receituário sem prescrições. Cadastre pelo menos uma prescrição.";
            $esconderMotivo = true;
        }
    } else {
        $texto = nl2br($carregarReceituario->getTextoEntrada());
    }

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            reforcoStandardSelect();

            $('#editarReceituario').click(function () {
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
                    url: "php/editarReceituarioV2.php",
                    data: {
                        codReceituarioV2: $('#codReceituarioV2').val(),
                        txtFeedback_adequacao: $("#feedback_adequacao").val(),
                        txtFeedback_clareza: $("#feedback_clareza").val(),
                        txtFeedback_personalizacao: $("#feedback_personalizacao").val(),
                        txtFeedback_comparacao: $("#feedback_comparacao").val(),
                        txtFeedback_confianca: $("#feedback_confianca").val(),
                        txtFeedback_errosLlm: feedback_errosLlm,
                        txtFeedback_textoLivre: $("#txtFeedback_textoLivre").val(),
                        numeroAtual: '<?=$numeroItemAtual;?>',
                        btnEditarReceituario: '1'
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Rodada: <?=$prompt->getRodada();?></h3>
                    <h4 class="box-title">Receituário <?=$numeroItemAtual." de ".$totalItens;?> <button type="submit" class="btn btn-primary btn-block btn-sm anterior">Anterior</button> <button type="submit" class="btn btn-primary btn-block btn-sm proximoItem">Próximo</button></h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="proximoItem" type="hidden" id="proximoItem" class="proximoItem" value="<?=$_POST['codReceituarioV2'];?>">
                        <input name="codReceituarioV2" type="hidden" id="codReceituarioV2"
                               value="<?= $_POST['codReceituarioV2']; ?>">
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <b class="form-text text-muted">Input para a IA</b>

                                <p id='txtTextoEntrada' name='txtTextoEntrada'><?= $texto; ?></p>
                            </div>
                        </div>
                        <div class="row form-group ">

                            <div class="col col-12 col-md-12">
                                Saída gerada pela IA (<?=$prompt->getTipo();?>)
                                <textarea rows="5" type='text' class='form-control' id='txtTextoSaida'
                                          name='txtTextoSaida' placeholder=''
                                          disabled><?= $_POST['txtTextoSaida']; ?></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                Texto de Referência
                                <textarea rows="5" type='text' class='form-control' id='txtTextoSaidaModificado'
                                          name='txtTextoSaidaModificado'
                                          placeholder=''
                                          disabled><?= $_POST['txtTextoSaidaModificado']; ?></textarea>
                            </div>
                        </div>
                        <style>
                            .orientation-text {
                                margin-top: 50px;
                                margin-bottom: 30px;
                            }

                            .range-wrapper {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                            }

                            .range-container {
                                position: relative;
                                display: flex;
                                align-items: center;
                                flex-grow: 1;
                            }

                            .range-container input[type="range"] {
                                margin: 0 10px;
                                flex-grow: 1;
                            }

                            .range-container .rangeValue {
                                position: absolute;
                                top: -20px;
                                left: 50%;
                                transform: translateX(-50%);
                                font-weight: bold;
                            }
                        </style>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>As orientações estão de acordo com as boas práticas de uso para o medicamento</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>não estão de acordo</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue" id="rangeValueFeedback_adequacao"><?= !is_null($carregarReceituario->getFeedback_adequacao()) ? $carregarReceituario->getFeedback_adequacao() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_adequacao"
                                               name='feedback_adequacao'
                                               id='feedback_adequacao'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_adequacao())? $carregarReceituario->getFeedback_adequacao() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_adequacao')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>estão totalmente de acordo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>As orientações são suficientemente claras para o paciente tomar corretamente o medicamento</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>não são claras</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue" id="rangeValueFeedback_clareza"><?= !is_null($carregarReceituario->getFeedback_clareza()) ? $carregarReceituario->getFeedback_clareza() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_clareza"
                                               name='feedback_clareza'
                                               id='feedback_clareza'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_clareza()) ? $carregarReceituario->getFeedback_clareza() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_clareza')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>são claras</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>As orientações consideram as características do paciente, com empatia comparável a um texto escrito por humanos</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>não consideram</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue" id="rangeValueFeedback_personalizacao"><?= !is_null($carregarReceituario->getFeedback_personalizacao())? $carregarReceituario->getFeedback_personalizacao() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_personalizacao"
                                               name='feedback_personalizacao'
                                               id='feedback_personalizacao'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_personalizacao()) ? $carregarReceituario->getFeedback_personalizacao() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_personalizacao')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>consideram plenamente</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>Qual é a sua confiança para atuar como um avaliador desta prescrição.</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>nenhuma confiança</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue" id="rangeValueFeedback_confianca"><?= !is_null($carregarReceituario->getFeedback_confianca()) ? $carregarReceituario->getFeedback_confianca() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_confianca"
                                               name='feedback_confianca'
                                               id='feedback_confianca'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_confianca())? $carregarReceituario->getFeedback_confianca() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_confianca')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>total confiança</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>Compare o texto gerado pela IA e o texto de referência. Com base nessa comparação, como você avalia as chances de um texto gerado pela IA ser melhor que um texto de referência?</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>O texto gerado pela IA é inferior ao texto de referência</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue" id="rangeValueFeedback_comparacao"><?= !is_null($carregarReceituario->getFeedback_comparacao()) ? $carregarReceituario->getFeedback_comparacao() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_comparacao"
                                               name='feedback_comparacao'
                                               id='feedback_comparacao'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_comparacao()) ? $carregarReceituario->getFeedback_comparacao() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_comparacao')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>O texto gerado pela IA é superior ao texto de referência</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>Assinale erros da LLM (se houver)</b>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='1'
                                                   name='feedback_errosLlm'
                                                   value='1' <?= in_array(1, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="1">
                                                Tipo 1 - Orientações podem levar ao uso incorreto deste medicamento
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='2'
                                                   name='feedback_errosLlm'
                                                   value='2' <?= in_array(2, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="2">
                                                Tipo 2 - Orientações de uso são contraditórias ou vagas
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='3'
                                                   name='feedback_errosLlm'
                                                   value='3' <?= in_array(3, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="3">
                                                Tipo 3 - Faltam orientações essenciais de uso
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='4'
                                                   name='feedback_errosLlm'
                                                   value='4' <?= in_array(4, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="4">
                                                Tipo 4 - Há erros factuais (não médicos)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='5'
                                                   name='feedback_errosLlm'
                                                   value='5' <?= in_array(5, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="5">
                                                Tipo 5 - Há orientação sem suporte científico
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='6'
                                                   name='feedback_errosLlm'
                                                   value='6' <?= in_array(6, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="6">
                                                Tipo 6 - Há orientação não solicitada
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm" id='7'
                                                   name='feedback_errosLlm'
                                                   value='7' <?= in_array(7, $arrayFeedbackErrosLLM) ? 'checked' : ''; ?>/>
                                            <label class="form-check-label" for="7">
                                                Tipo 7 - Há alucinação (informação fabricada / inventada)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <div class="orientation-text">
                                    <b>Observações (opcional)</b>
                                </div>
                                <div class="row range-wrapper">
                                        <textarea rows="2" type='text' class='form-control' id='txtFeedback_textoLivre'
                                                  name='txtFeedback_textoLivre' placeholder=''
                                        ><?=$_POST['txtFeedback_textoLivre'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-block btn-sm anterior">Receituário Anterior (não salvar)</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarReceituario" name="editarReceituario">Salvar e ir para o próximo</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
