<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/configSemSessao.php"); ?>
<?php
if (!empty($_POST['token'])) {

    $participante = new \Classe\V3Participante();
    $participante->setToken($_POST['token']);
    $participante->carregarPeloToken();

    $_POST['txtFeedback_preocupacoes_outros'] = $participante->getFeedback_preocupacoes_outros();
    $_POST['txtFeedback_desvantagens'] = $participante->getFeedback_desvantagens();
    $_POST['txtFeedback_vantagens'] = $participante->getFeedback_vantagens();

    $arrayFeedbackPreocupacoes = [];
    if (!empty($participante->getFeedback_preocupacoes())) $arrayFeedbackPreocupacoes = explode(';', $participante->getFeedback_preocupacoes());

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });

            if(<?=!empty($_POST['txtFeedback_preocupacoes_outros'])?'true':'false';?> ||
                <?=!empty($_POST['txtFeedback_desvantagens'])?'true':'false';?> ||
                <?=!empty($_POST['txtFeedback_vantagens'])?'true':'false';?>) $('#modalAgradecimento').modal("show");

            $(document).off('click', '#salvarFeedback');
            $(document).on('click', "#salvarFeedback", function () {
                var $btn = $(this);
                $btn.prop('disabled', true);
                
                overlayStart();
                var feedback_preocupacoes = "";
                $('.feedback_preocupacoes').each(function (e) {
                    if ($(this).is(":checked")) {
                        if (feedback_preocupacoes) feedback_preocupacoes = feedback_preocupacoes + ";"
                        feedback_preocupacoes = feedback_preocupacoes + $(this).val();
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: "php/cadastrarReceituarioV3_4_Agradecimento.php",
                    data: {
                        token: '<?=$_POST['token'];?>',


                        txtFeedback_preocupacoes_outros: $('#txtFeedback_preocupacoes_outros').val(),
                        txtFeedback_desvantagens: $('#txtFeedback_desvantagens').val(),
                        txtFeedback_vantagens: $('#txtFeedback_vantagens').val(),

                        feedback_preocupacoes: feedback_preocupacoes,

                        btnCadastrarReceituarioV3_4_Agradecimento: '1'
                    },
                    complete: function (data, status) {
                        $btn.prop('disabled', false);
                        if (status === 'error' || !data.responseText) {
                            //console.log(data);
                            $('#saida').html(data.responseText);
                            overlayStop();
                        } else {
                            $('#saida').html(data.responseText);

                            $('#modalAgradecimento').modal("show");
                            overlayStop();
                        }
                    }
                });
            });

            if ('<?=in_array("Outros", $arrayFeedbackPreocupacoes) ? 'true' : '';?>') $('.feedback_preocupacoes_outros_class').removeClass('hide');
            else $('.feedback_preocupacoes_outros_class').addClass('hide');

            $('#txtFeedback_preocupacoes_5').on('change', function () {
                if ($(this).is(':checked')) {
                    $('.feedback_preocupacoes_outros_class').removeClass('hide');
                    $('#txtFeedback_preocupacoes_outros').focus();
                } else {
                    $('.feedback_preocupacoes_outros_class').addClass('hide');
                }
            });


            $('#txtFeedback_preocupacoes_1').on('change', function () {
                if ($(this).is(':checked')) {
                    // Desabilitar todos os outros checkboxes
                    $("input[type='checkbox'][name='txtFeedback_preocupacoes']").not(this)
                        .prop('checked', false)
                        .prop('disabled', true);
                    $('.feedback_preocupacoes_outros_class').addClass('hide');
                } else {
                    // Reabilitar todos os outros checkboxes
                    $("input[type='checkbox'][name='txtFeedback_preocupacoes']").not(this).prop('disabled', false);
                }
            });
            $('#txtFeedback_preocupacoes_1').trigger('change');
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Pesquisa Prescritores</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12">
                                <p><strong>Antes de terminarmos, você poderia responder mais três perguntas?</strong></p>
                                <div class="row form-group">
                                    <div class="col col-12 col-md-12">
                                        <div class="orientation-text">
                                            <b>Quais são as suas preocupações com a introdução da inteligência artificial na saúde (assinale todas as que se aplicarem):</b>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input type='checkbox' class="form-check-input feedback_preocupacoes"
                                                           id='txtFeedback_preocupacoes_1'
                                                           name='txtFeedback_preocupacoes'
                                                           value='Nenhuma' <?= in_array("Nenhuma", $arrayFeedbackPreocupacoes) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label" for="txtFeedback_preocupacoes_1">
                                                        Nenhuma
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type='checkbox' class="form-check-input feedback_preocupacoes"
                                                           id='txtFeedback_preocupacoes_2'
                                                           name='txtFeedback_preocupacoes'
                                                           value='Segurança do paciente' <?= in_array("Segurança do paciente", $arrayFeedbackPreocupacoes) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label" for="txtFeedback_preocupacoes_2">
                                                        Segurança do paciente
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type='checkbox' class="form-check-input feedback_preocupacoes"
                                                           id='txtFeedback_preocupacoes_3'
                                                           name='txtFeedback_preocupacoes'
                                                           value='Discriminação de minorias ou pessoas menos favorecidas' <?= in_array("Discriminação de minorias ou pessoas menos favorecidas", $arrayFeedbackPreocupacoes) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label" for="txtFeedback_preocupacoes_3">
                                                        Discriminação de minorias ou pessoas menos favorecidas
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type='checkbox' class="form-check-input feedback_preocupacoes"
                                                           id='txtFeedback_preocupacoes_4'
                                                           name='txtFeedback_preocupacoes'
                                                           value='Interferência na comunicação entre humanos' <?= in_array("Interferência na comunicação entre humanos", $arrayFeedbackPreocupacoes) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label" for="txtFeedback_preocupacoes_4">
                                                        Interferência na comunicação entre humanos
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type='checkbox' class="form-check-input feedback_preocupacoes"
                                                           id='txtFeedback_preocupacoes_5'
                                                           name='txtFeedback_preocupacoes'
                                                           value='Outros' <?= in_array("Outros", $arrayFeedbackPreocupacoes) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label" for="txtFeedback_preocupacoes_5">
                                                        Outros
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col col-12 col-md-12 feedback_preocupacoes_outros_class">
                                                <textarea type='text' class='form-control'
                                                          id='txtFeedback_preocupacoes_outros'
                                                          name='txtFeedback_preocupacoes_outros'
                                                          placeholder=''><?= $_POST['txtFeedback_preocupacoes_outros']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group ">
                                    <div class="col col-12 col-md-12">
                                        <div class="orientation-text">
                                            <b>Na sua opinião, quais são as desvantagens ou riscos potenciais do uso da inteligência artificial para apoiar a comunicação entre o profissional prescritor e o cidadão.</b>
                                        </div>
                                        <textarea rows="5" type='text' class='form-control' id='txtFeedback_desvantagens'
                                                  name='txtFeedback_desvantagens' placeholder=''
                                        ><?= $_POST['txtFeedback_desvantagens']; ?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group ">
                                    <div class="col col-12 col-md-12">
                                        <div class="orientation-text">
                                            <b>
                                                Na sua opinião, quais são as vantagens potenciais do uso da inteligência artificial para apoiar a comunicação entre o profissional prescritor e o cidadão.
                                            </b>
                                        </div>
                                        <textarea rows="5" type='text' class='form-control' id='txtFeedback_vantagens'
                                                  name='txtFeedback_vantagens' placeholder=''
                                        ><?= $_POST['txtFeedback_vantagens']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button id="salvarFeedback" class="btn btn-success btn-block w-100" name="salvarFeedback" type="button">Finalizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
