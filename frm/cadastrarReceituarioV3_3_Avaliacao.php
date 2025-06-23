<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_POST['codReceituarioV3'])) { ?>
    <?php


    $numeroItemAtual = 0;
    if (isset($_POST['numeroItemAtual'])) $numeroItemAtual = $_POST['numeroItemAtual'];

    $totalItens = 0;
    if (isset($_POST['totalItens'])) $totalItens = $_POST['totalItens'];


    $arrayFeedbackErrosLLM = [];
    $carregarReceituario = new Classe\V3Receituario();
    if ($_POST['codReceituarioV3']) {
        $carregarReceituario->setcodReceituarioV3($_POST['codReceituarioV3']);
        $carregarReceituario->carregar();
    }

    $_POST['txtRecomendacoes'] = $carregarReceituario->getRecomendacoes();
    $_POST['txtTextoSaida'] = $carregarReceituario->getTextoSaida();

    $prompt = new \Classe\Prompt();
    if ($carregarReceituario->getCodPrompt()) {
        $prompt->setCodPrompt($carregarReceituario->getCodPrompt());
        $prompt->carregar();
    }

    $contexto = new \Classe\V3Contexto();
    $contexto->setCodContexto($carregarReceituario->getCodContexto());
    $contexto->carregar();

    $cidadaoTexto = "Nome:" . $contexto->getCidadaoNome() . "<br>Sexo:" . $contexto->getCidadaoSexo();
    $texto = nl2br($carregarReceituario->getTextoEntrada());

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            reforcoStandardSelect();

            var totalItens = parseInt('<?= $totalItens;?>');
            var numeroItemAtual = parseInt('<?= $numeroItemAtual;?>');

            //console.log("Total itens: " + totalItens);

            $(document).off('click', '#editarReceituario');
            $(document).on('click', "#editarReceituario", function () {

                var $btn = $(this);
                $btn.prop('disabled', true);

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
                    url: "php/cadastrarReceituarioV3_3_Avaliacao.php",
                    data: {
                        codReceituarioV3: '<?=$carregarReceituario->getCodReceituarioV3();?>',
                        txtFeedback_confianca: $("#feedback_confianca").val(),

                        txtFeedback_sus_correto: $("input[type='radio'][name=txtFeedback_sus_correto]:checked").val(),
                        txtFeedback_sus_incorreto: $("input[type='radio'][name=txtFeedback_sus_incorreto]:checked").val(),
                        txtFeedback_sus_relevante: $("input[type='radio'][name=txtFeedback_sus_relevante]:checked").val(),
                        txtFeedback_sus_irrelevante: $("input[type='radio'][name=txtFeedback_sus_irrelevante]:checked").val(),
                        txtFeedback_sus_clara: $("input[type='radio'][name=txtFeedback_sus_clara]:checked").val(),
                        txtFeedback_sus_naoclara: $("input[type='radio'][name=txtFeedback_sus_naoclara]:checked").val(),
                        txtFeedback_sus_compreensivel: $("input[type='radio'][name=txtFeedback_sus_compreensivel]:checked").val(),
                        txtFeedback_sus_incompreensivel: $("input[type='radio'][name=txtFeedback_sus_incompreensivel]:checked").val(),
                        txtFeedback_sus_util: $("input[type='radio'][name=txtFeedback_sus_util]:checked").val(),
                        txtFeedback_sus_inutil: $("input[type='radio'][name=txtFeedback_sus_inutil]:checked").val(),

                        txtFeedback_errosLlm: feedback_errosLlm,
                        txtFeedback_textoLivre: $("#txtFeedback_textoLivre").val(),

                        btnEditarReceituario: '1'
                    },
                    complete: function (data, status) {
                        $btn.prop('disabled', false);
                        //console.log(data);
                        if (status === 'error' || !data.responseText) {

                            $('#saida').html(data.responseText);
                            modalSaidaAvaliacao(data.responseText, false,false,totalItens,numeroItemAtual);
                            overlayStop(true);
                        } else {
                            overlayStop(true);

                            //console.log("VAI CHAMAR COM TRUE");
                            $('#saida').html(data.responseText);
                            modalSaidaAvaliacao(data.responseText, true,false,totalItens,numeroItemAtual);
                        }
                    }
                });
            });
        });

        function modalSaidaAvaliacao(saida, next = false, mostrarCancelar = false,totalItens,numeroItemAtual) {
            if (mostrarCancelar) $('#modalExclusaoCancel').removeClass('hide');
            else $('#modalExclusaoCancel').addClass('hide');
            $('#modalExclusao').find('.modal-body').html(saida);
            $('#modalExclusao').modal("show");
            $('#modalExclusaoDelete').off('click');
            $('#modalExclusaoDelete').on('click', function (e) {
                if (next) {
                    //console.log(totalItens);
                    //console.log(numeroItemAtual);
                    if(totalItens>numeroItemAtual) {

                        //console.log("entrou if");

                        arrayReceituarioV3 = <?=json_encode($_POST['arrayReceituarioV3']);?>;
                        var auxReceituarioV3 = arrayReceituarioV3.indexOf('<?=$carregarReceituario->getCodReceituarioV3();?>');
                        var codReceituarioV3 = arrayReceituarioV3[auxReceituarioV3+1];

                        $.ajax({
                            method: 'POST',
                            url: "frm/cadastrarReceituarioV3_2_Prescricao.php",
                            data: {
                                codReceituarioV3: codReceituarioV3,
                                numeroItemAtual: '<?=$numeroItemAtual+1;?>',
                                totalItens: totalItens,
                                arrayReceituarioV3:arrayReceituarioV3,
                                token: '<?=$_POST['token'];?>',
                            },
                            complete: function (data, status) {

                                if (status === 'error' || !data.responseText) {
                                    //console.log(data);
                                    $('#saida').html(data.responseText);
                                    overlayStop(true);
                                } else {
                                    console.log("ELSE");
                                    overlayStop(true);
                                    $('#saida').html("");
                                    $('#receituarioV3').off();
                                    $('#receituarioV3').html(data.responseText);
                                }
                            }
                        });
                    }else{

                        //console.log("entrou else");
                        $.ajax({
                            method: 'POST',
                            url: "frm/cadastrarReceituarioV3_4_Agradecimento.php",
                            data: {
                                codReceituarioV3: '<?=$carregarReceituario->getCodReceituarioV3();?>',
                                token: '<?=$_POST['token'];?>',
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
                }else{
                    console.log("Não entrou next");
                }
            });
        }

        function updateRangeValue(value, id) {
            document.getElementById(id).textContent = value + "%";
        }

    </script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Pesquisa Prescritores:
                        Avaliação <?= $numeroItemAtual . " de " . $totalItens; ?></h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b class="form-text text-muted">Input para a IA</b>

                                <p id='txtTextoEntrada' name='txtTextoEntrada'><?= $texto; ?></p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                Suas recomendações
                                <textarea rows="5" type='text' class='form-control' id='txtRecomendacoes'
                                          name='txtRecomendacoes'
                                          placeholder=''
                                          disabled><?= $_POST['txtRecomendacoes']; ?></textarea>
                            </div>
                        </div>
                        <div class="row form-group ">
                            <div class="col col-md-12">
                                Saída gerada pela IA
                                <textarea rows="5" type='text' class='form-control' id='txtTextoSaida'
                                          name='txtTextoSaida' placeholder=''
                                          disabled><?= $_POST['txtTextoSaida']; ?></textarea>
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
                            <div class="col col-md-12">
                                <div class="orientation-text">
                                    <b>Me sinto confiante, com o conhecimento necessário para atuar como avaliador desta simulação de prescrição.</b>
                                </div>
                                <div class="row range-wrapper">
                                    <div class="col-2 text-right">
                                        <span>nenhuma confiança</span>
                                    </div>
                                    <div class="col-8 range-container">
                                        <span class="rangeValue"
                                              id="rangeValueFeedback_confianca"><?= !is_null($carregarReceituario->getFeedback_confianca()) ? $carregarReceituario->getFeedback_confianca() . "%" : "50%"; ?></span>
                                        <input type='range' class="feedback_confianca"
                                               name='feedback_confianca'
                                               id='feedback_confianca'
                                               placeholder=''
                                               min="0" max="100"
                                               value='<?= !is_null($carregarReceituario->getFeedback_confianca()) ? $carregarReceituario->getFeedback_confianca() : "50"; ?>'
                                               oninput="updateRangeValue(this.value,'rangeValueFeedback_confianca')"/>
                                    </div>
                                    <div class="col-2 text-left">
                                        <span>total confiança</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <h3>Para as afirmativas abaixo, escolha a opção que melhor represente sua opinião:</h3>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações apresentadas estão corretas, de acordo com o que é amplamente aceito
                                    na área da saúde.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_correto" id='txtFeedback_sus_correto_1'
                                               name='txtFeedback_sus_correto'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_correto_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_correto" id='txtFeedback_sus_correto_2'
                                               name='txtFeedback_sus_correto'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_correto_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_correto" id='txtFeedback_sus_correto_3'
                                               name='txtFeedback_sus_correto'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_correto_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_correto" id='txtFeedback_sus_correto_4'
                                               name='txtFeedback_sus_correto'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_correto_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_correto" id='txtFeedback_sus_correto_5'
                                               name='txtFeedback_sus_correto'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_correto_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações são suficientemente claras para a pessoa (cidadão) tomar/usar
                                    corretamente o medicamento.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_clara" id='txtFeedback_sus_clara_1'
                                               name='txtFeedback_sus_clara'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_clara_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_clara" id='txtFeedback_sus_clara_2'
                                               name='txtFeedback_sus_clara'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_clara_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_clara" id='txtFeedback_sus_clara_3'
                                               name='txtFeedback_sus_clara'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_clara_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_clara" id='txtFeedback_sus_clara_4'
                                               name='txtFeedback_sus_clara'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_clara_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_clara" id='txtFeedback_sus_clara_5'
                                               name='txtFeedback_sus_clara'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_clara_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações sugeridas são úteis para complementar o texto da receita que eu elaborei.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_util" id='txtFeedback_sus_util_1'
                                               name='txtFeedback_sus_util'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_util_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_util" id='txtFeedback_sus_util_2'
                                               name='txtFeedback_sus_util'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_util_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_util" id='txtFeedback_sus_util_3'
                                               name='txtFeedback_sus_util'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_util_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_util" id='txtFeedback_sus_util_4'
                                               name='txtFeedback_sus_util'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_util_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">

                                        <input type='radio' class="feedback_sus_util" id='txtFeedback_sus_util_5'
                                               name='txtFeedback_sus_util'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_util_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações geradas contêm informações prejudiciais ou incorretas sobre o uso
                                    dos
                                    medicamentos.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incorreto"
                                               id='txtFeedback_sus_incorreto_1'
                                               name='txtFeedback_sus_incorreto'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_incorreto_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incorreto"
                                               id='txtFeedback_sus_incorreto_2'
                                               name='txtFeedback_sus_incorreto'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_incorreto_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incorreto"
                                               id='txtFeedback_sus_incorreto_3'
                                               name='txtFeedback_sus_incorreto'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_incorreto_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incorreto"
                                               id='txtFeedback_sus_incorreto_4'
                                               name='txtFeedback_sus_incorreto'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_incorreto_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incorreto"
                                               id='txtFeedback_sus_incorreto_5'
                                               name='txtFeedback_sus_incorreto'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_incorreto_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações são escritas de forma acessível e compreensível para a pessoa
                                    (cidadão).</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_compreensivel"
                                               id='txtFeedback_sus_compreensivel_1'
                                               name='txtFeedback_sus_compreensivel'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_compreensivel_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_compreensivel"
                                               id='txtFeedback_sus_compreensivel_2'
                                               name='txtFeedback_sus_compreensivel'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_compreensivel_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_compreensivel"
                                               id='txtFeedback_sus_compreensivel_3'
                                               name='txtFeedback_sus_compreensivel'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_compreensivel_3">Nem concordo nem
                                            discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_compreensivel"
                                               id='txtFeedback_sus_compreensivel_4'
                                               name='txtFeedback_sus_compreensivel'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_compreensivel_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_compreensivel"
                                               id='txtFeedback_sus_compreensivel_5'
                                               name='txtFeedback_sus_compreensivel'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_compreensivel_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações cobrem os aspectos relevantes para o uso correto do
                                    medicamento.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_relevante"
                                               id='txtFeedback_sus_relevante_1'
                                               name='txtFeedback_sus_relevante'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_relevante_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_relevante"
                                               id='txtFeedback_sus_relevante_2'
                                               name='txtFeedback_sus_relevante'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_relevante_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_relevante"
                                               id='txtFeedback_sus_relevante_3'
                                               name='txtFeedback_sus_relevante'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_relevante_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_relevante"
                                               id='txtFeedback_sus_relevante_4'
                                               name='txtFeedback_sus_relevante'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_relevante_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_relevante"
                                               id='txtFeedback_sus_relevante_5'
                                               name='txtFeedback_sus_relevante'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_relevante_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>Minha receita não melhorou com as orientações geradas pela IA</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_inutil"
                                               id='txtFeedback_sus_inutil_1'
                                               name='txtFeedback_sus_inutil'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_inutil_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_inutil"
                                               id='txtFeedback_sus_inutil_2'
                                               name='txtFeedback_sus_inutil'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_inutil_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_inutil"
                                               id='txtFeedback_sus_inutil_3'
                                               name='txtFeedback_sus_inutil'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_inutil_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_inutil"
                                               id='txtFeedback_sus_inutil_4'
                                               name='txtFeedback_sus_inutil'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_inutil_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_inutil"
                                               id='txtFeedback_sus_inutil_5'
                                               name='txtFeedback_sus_inutil'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_inutil_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações apresentam informações desorganizadas e difíceis de entender para a pessoa (cidadão).</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_naoclara"
                                               id='txtFeedback_sus_naoclara_1'
                                               name='txtFeedback_sus_naoclara'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_naoclara_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_naoclara"
                                               id='txtFeedback_sus_naoclara_2'
                                               name='txtFeedback_sus_naoclara'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_naoclara_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_naoclara"
                                               id='txtFeedback_sus_naoclara_3'
                                               name='txtFeedback_sus_naoclara'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_naoclara_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_naoclara"
                                               id='txtFeedback_sus_naoclara_4'
                                               name='txtFeedback_sus_naoclara'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_naoclara_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_naoclara"
                                               id='txtFeedback_sus_naoclara_5'
                                               name='txtFeedback_sus_naoclara'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_naoclara_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações fornecem à pessoa (cidadão) informações excessivamente técnicas.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incompreensivel"
                                               id='txtFeedback_sus_incompreensivel_1'
                                               name='txtFeedback_sus_incompreensivel'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_incompreensivel_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incompreensivel"
                                               id='txtFeedback_sus_incompreensivel_2'
                                               name='txtFeedback_sus_incompreensivel'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_incompreensivel_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incompreensivel"
                                               id='txtFeedback_sus_incompreensivel_3'
                                               name='txtFeedback_sus_incompreensivel'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_incompreensivel_3">Nem concordo nem
                                            discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incompreensivel"
                                               id='txtFeedback_sus_incompreensivel_4'
                                               name='txtFeedback_sus_incompreensivel'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_incompreensivel_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_incompreensivel"
                                               id='txtFeedback_sus_incompreensivel_5'
                                               name='txtFeedback_sus_incompreensivel'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_incompreensivel_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <b>As orientações não incluem informações suficientes para que a pessoa (cidadão)
                                    faça o
                                    uso correto do medicamento.</b>
                                <div class="row form-group">
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_irrelevante"
                                               id='txtFeedback_sus_irrelevante_1'
                                               name='txtFeedback_sus_irrelevante'
                                               placeholder=''
                                               value='1'/>
                                        <label for="txtFeedback_sus_irrelevante_1">Discordo totalmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_irrelevante"
                                               id='txtFeedback_sus_irrelevante_2'
                                               name='txtFeedback_sus_irrelevante'
                                               placeholder=''
                                               value='2'/>
                                        <label for="txtFeedback_sus_irrelevante_2">Discordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_irrelevante"
                                               id='txtFeedback_sus_irrelevante_3'
                                               name='txtFeedback_sus_irrelevante'
                                               placeholder=''
                                               value='3'/>
                                        <label for="txtFeedback_sus_irrelevante_3">Nem concordo nem discordo</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_irrelevante"
                                               id='txtFeedback_sus_irrelevante_4'
                                               name='txtFeedback_sus_irrelevante'
                                               placeholder=''
                                               value='4'/>
                                        <label for="txtFeedback_sus_irrelevante_4">Concordo parcialmente</label>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <input type='radio' class="feedback_sus_irrelevante"
                                               id='txtFeedback_sus_irrelevante_5'
                                               name='txtFeedback_sus_irrelevante'
                                               placeholder=''
                                               value='5'/>
                                        <label for="txtFeedback_sus_irrelevante_5">Concordo totalmente</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-12">
                                <div class="orientation-text">
                                    <b>Caso tenha encontrado erro(s), marque o(s) tipo(s) de erro detectado(s)</b>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm"
                                                   id='feedback_errosLlm_1'
                                                   name='feedback_errosLlm'
                                                   value='1'/>
                                            <label class="form-check-label" for="feedback_errosLlm_1">
                                                Orientações podem levar ao uso incorreto deste medicamento
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm"
                                                   id='feedback_errosLlm_2'
                                                   name='feedback_errosLlm'
                                                   value='2'/>
                                            <label class="form-check-label" for="feedback_errosLlm_2">
                                                Orientações de uso são contraditórias ou vagas
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm"
                                                   id='feedback_errosLlm_3'
                                                   name='feedback_errosLlm'
                                                   value='3'/>
                                            <label class="form-check-label" for="feedback_errosLlm_3">
                                                Há erros factuais (não médicos)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type='checkbox' class="form-check-input feedback_errosLlm"
                                                   id='feedback_errosLlm_4'
                                                   name='feedback_errosLlm'
                                                   value='4'/>
                                            <label class="form-check-label" for="feedback_errosLlm_4">
                                                Há informação que não está relacionada com a prescrição ou que é totalmente sem sentido (alucinação do modelo)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <div class="orientation-text">
                                    <b>Comentários (texto-livre)</b>
                                </div>
                                <div class="row range-wrapper">
                                        <textarea rows="2" type='text' class='form-control' id='txtFeedback_textoLivre'
                                                  name='txtFeedback_textoLivre' placeholder=''
                                        ></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-block w-100"
                                        id="editarReceituario"
                                        name="editarReceituario">Salvar avaliação e ir para próxima etapa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>