<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/configSemSessao.php"); ?>
<?php
if (!empty($_POST['token'])) {

    $numeroItemAtual = 0;
    if(isset($_POST['numeroItemAtual'])) $numeroItemAtual = $_POST['numeroItemAtual'];

    $totalItens = 0;
    if(isset($_POST['totalItens'])) $totalItens = $_POST['totalItens'];

    try {

        $receituario = new Classe\V3Receituario();
        if ($_POST['codReceituarioV3']) {
            $receituario->setcodReceituarioV3($_POST['codReceituarioV3']);
            $receituario->carregar();
        }

        $contexto = new \Classe\V3Contexto();
        $contexto->setCodContexto($receituario->getCodContexto());
        $contexto->carregar();

        $contextoMedicamento = new \Classe\V3ContextoMedicamento();
        $colContextoMedicamento = new \Config\phpCollection();
        $colContextoMedicamento = $contextoMedicamento->carregarTodosCriterio('codContexto',$contexto->getCodContexto());

        $listaMedicamento = [];
        $listaVia = [];
        if($colContextoMedicamento->length){
            do{
                $listaMedicamento[] = $colContextoMedicamento->current()->getCodMedicamento();
                $listaVia[] = $colContextoMedicamento->current()->getCodViaAdministracao();
            }while($colContextoMedicamento->has_next());
        }

        ?>
        <script type="text/javascript">
            $().ready(function () {

                reforcoStandardSelect();

                $("form").submit(function (e) {
                    e.preventDefault();
                    return false;
                });
                arrayUnidadeMedida = [];

                $.ajax({
                    method: 'POST',
                    url: "php/arrayUnidadeMedidaPlural.php",
                    dataType: "json",
                    complete: function (data, status) {
                        //console.log(data);
                        arrayUnidadeMedida = Object.values(data.responseJSON);
                    }
                });

                $('#saida').html("");

                $("#cboFrequencia").chosen({
                    disable_search_threshold: 10,
                    no_results_text: "Não encontrado!",
                    width: "20%"
                });

                $("#cboTurno").chosen({
                    disable_search_threshold: 10,
                    no_results_text: "Não encontrado!",
                    width: "20%"
                });


                var next = false;


                $(document).off('click', "#cadastrarPrescricao");
                $(document).on('click', "#cadastrarPrescricao", function () {

                    var $btn = $(this);
                    $btn.prop('disabled', true);

                    overlayStart();
                    modalSaidaPrescricao("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='<?=$GLOBALS['CAMINHOHTML']?>assets/images/load-32_256.gif'/></div>",false,false,false);
                    $.ajax({
                        method: 'POST',
                        url: "php/cadastrarReceituarioV3_2_Prescricao.php",
                        data: {
                            codReceituarioV3: '<?=$receituario->getCodReceituarioV3();?>',
                            cboViaAdministracao: $('#cboViaAdministracao').val(),
                            cboUnidadeMedida: $('#cboUnidadeMedida').val(),
                            cboMedicamento: $('#cboMedicamento').val(),
                            txtQuantidadeDose: $('#txtQuantidadeDose').val(),
                            txtQuantidadeSolicitada: $('#txtQuantidadeSolicitada').val(),
                            txtInicioTratamento: $('#txtInicioTratamento').val(),
                            txtConclusaoTratamento: $('#txtConclusaoTratamento').val(),
                            txtRecomendacoes: $('#txtRecomendacoes').val(),
                            txtPosologia: posologia,
                            btnCadastrarPrescricao: '1'
                        },
                        dataType: "json",
                        complete: function (data, status) {
                            // $('#modalPrescricao').modal("hide");
                            $btn.prop('disabled', false);
                            //console.log(data);
                            $('#saida').html("");
                            if (status === 'error' || !data.responseText) {
                                //console.log(data);
                                $('#saida').html(data.responseText);
                                //console.log("Chamou 1")
                                next = false;
                                modalSaidaPrescricao(data.responseText);
                                overlayStop();
                            } else {
                                $('#saida').html(data.responseText);
                                overlayStop();
                                //console.log("Chamou 2")
                                next = true;
                                modalSaidaPrescricao(data.responseText);
                                //$(".proximaEtapa").trigger("click");
                            }
                        }
                    });
                });

                function modalSaidaPrescricao(saida,mostrarCancelar = false,mostrarConfirmar = true){
                    if(mostrarCancelar) $('#modalPrescricaoCancel').removeClass('hide');
                    else  $('#modalPrescricaoCancel').addClass('hide');
                    if(mostrarConfirmar) $('#modalPrescricaoDelete').removeClass('hide');
                    else  $('#modalPrescricaoDelete').addClass('hide');
                    $('#modalPrescricao').find('.modal-body').html(saida);
                    $('#modalPrescricao').modal("show");
                    $('#modalPrescricaoDelete').off('click');
                    $('#modalPrescricaoDelete').on('click', function (e) {
                        if(next){
                            //console.log("Entrou Next");
                            arrayReceituarioV3 = <?=json_encode($_POST['arrayReceituarioV3']);?>;
                            $.ajax({
                                method: 'POST',
                                url: "frm/cadastrarReceituarioV3_3_Avaliacao.php",
                                data: {
                                    codReceituarioV3: '<?=$receituario->getCodReceituarioV3();?>',
                                    numeroItemAtual: '<?=$numeroItemAtual;?>',
                                    totalItens: '<?=$totalItens;?>',
                                    token: '<?=$_POST['token'];?>',
                                    arrayReceituarioV3:arrayReceituarioV3
                                },
                                complete: function (data, status) {
                                    if (status === 'error' || !data.responseText) {
                                        //console.log(data);
                                        $('#saida').html(data.responseText);
                                        overlayStop(true);
                                    } else {
                                        overlayStop(true);
                                        $('#saida').html("");
                                        $('#receituarioV3').off();
                                        $('#receituarioV3').html(data.responseText);
                                    }
                                }
                            });
                        }
                    });
                }

                var posologiaPadrao = "<b style='color: red;'>Nenhuma informação adicionada</b>";
                var posologia = posologiaPadrao;

                var frequencia = "";
                var txtFrequenciaVezes = "";
                var cboFrequencia = "";

                var turno = "";
                var txtTurnoVezes = "";
                var cboTurno = "";
                var quantidade = "";

                var intervalo = "";
                var doseUnica = "";

                var tipoDuracaoRemonta = "";

                $('.intervalo').click(function () {
                    posologia = "a cada " + this.id.replace('h', ' horas');
                    intervalo = posologia;
                    $('#txtIntervalo').val(this.id.replace('h', ' horas'));

                    remonta();
                });
                $('#txtIntervalo').keyup(function () {
                    posologia = "a cada " + $(this).val() + " horas";
                    intervalo = posologia;

                    remonta();
                });

                $('#txtQuantidadeDose').keyup(function () {
                    if ($('#cboUnidadeMedida').val() && $('#txtQuantidadeDose').val()) {
                        if ($('#txtQuantidadeDose').val() > 1) quantidade = $('#txtQuantidadeDose').val() + " " + arrayUnidadeMedida[$('#cboUnidadeMedida').val()] + ", ";
                        else quantidade = $('#txtQuantidadeDose').val() + " " + $('#cboUnidadeMedida option:selected').text().toLowerCase() + ", ";

                        remonta();
                    } else {
                        quantidade = "";
                        remonta();
                    }
                });
                $('#cboUnidadeMedida').change(function () {
                    if ($('#txtQuantidadeDose').val()) {
                        if ($('#txtQuantidadeDose').val() > 1) quantidade = $('#txtQuantidadeDose').val() + " " + arrayUnidadeMedida[$(this).val()] + ", ";
                        else quantidade = $('#txtQuantidadeDose').val() + " " + $('#cboUnidadeMedida option:selected').text().toLowerCase() + ", ";
                        remonta();
                    } else {
                        quantidade = "";
                        remonta();
                    }
                });
                $('.frequencia').click(function () {
                    frequencia = this.id + " vez(es)";
                    $('#txtFrequencia').val(this.id.replace('x', ''));
                    remonta();
                });
                $('#txtFrequencia').keyup(function () {
                    frequencia = $('#txtFrequencia').val() + " vez(es)";
                    remonta();
                });
                $('#txtFrequenciaVezes').keyup(function () {
                    if ($(this).val()) {
                        txtFrequenciaVezes = " a cada " + $(this).val().replace('h', ' horas');
                        cboFrequencia = " " + $('#cboFrequencia').val();
                    } else {
                        txtFrequenciaVezes = "";
                        cboFrequencia = "";
                    }
                    remonta();
                });
                $('#cboFrequencia').change(function () {
                    if (txtFrequenciaVezes) {
                        if ($(this).val()) cboFrequencia = " " + $(this).val();
                        else cboFrequencia = "";
                    } else cboFrequencia = "";
                    remonta();
                });

                function remonta() {
                    if (doseUnica) {
                        posologia = quantidade + doseUnica + tipoDuracaoRemonta;
                    } else if (frequencia) {
                        posologia = quantidade + frequencia + txtFrequenciaVezes + cboFrequencia + tipoDuracaoRemonta;
                    } else if (turno) {
                        posologia = quantidade + turno + txtTurnoVezes + cboTurno + tipoDuracaoRemonta;
                    } else if (intervalo) {
                        posologia = quantidade + intervalo + tipoDuracaoRemonta;
                        //console.log("ENTROU ", tipoDuracaoRemonta);
                    } else {
                        posologia = posologiaPadrao;
                    }
                    $('#posologia').html('<b>'+posologia+"<b>");
                }

                $('.turno').click(function () {
                    turno = "pela " + this.id;
                    remonta();
                });
                $('#txtTurnoVezes').keyup(function () {
                    if ($(this).val()) {
                        txtTurnoVezes = " a cada " + $(this).val().replace('h', ' horas');
                        cboTurno = " " + $('#cboTurno').val();
                    } else {
                        txtTurnoVezes = "";
                        cboTurno = "";
                    }
                    remonta();
                });
                $('#cboTurno').change(function () {
                    if (txtTurnoVezes) {
                        if ($(this).val()) cboTurno = " " + $(this).val();
                        else cboTurno = "";
                    } else cboTurno = "";
                    remonta();
                });


                $('.tabMenu').click(function () {

                    $('.tabMenu').removeClass('active');
                    $(this).addClass('active');
                    $('.nav-tabs li').removeClass('active');
                    $(this).parent().addClass('active');
                    $('.tab-pane').removeClass('active');
                    var target = $(this).attr('href');  // Obtém o id do target da aba
                    $(target).addClass('active');

                    intervalo = "";
                    frequencia = "";
                    turno = "";
                    if (quantidade) posologia = quantidade;
                    else posologia = posologiaPadrao;
                    remonta();
                });


                $('#txtInicioTratamento').on('input', function () {
                    recalculaConclusaoTratamento();
                });

                $("#txtDuracao").change(function () {
                    recalculaConclusaoTratamento();
                });

                $("#cboDuracao").change(function () {
                    recalculaConclusaoTratamento();
                });
                $("#doseUnica").change(function () {
                    if ($('#doseUnica').is(":checked")) {
                        $('.divNaoDoseUnica').addClass('hide');
                        doseUnica = "dose unica";
                        $("#txtDuracao").val(1);
                        $("#txtDuracao").attr('disabled', true);
                        $("#cboDuracao").val(1);
                        $("#cboDuracao").attr('disabled', true);
                        $("#cboDuracao").trigger("chosen:updated");
                        $("#txtConclusaoTratamento").val($("#txtInicioTratamento").val());
                        $("#txtConclusaoTratamento").attr('disabled', true);
                    } else {
                        $('.divNaoDoseUnica').removeClass('hide');
                        $("#txtDuracao").val("");
                        $("#txtDuracao").attr('disabled', false);
                        $('#cboDuracao option').each(function () {
                            $(this)[0].selected = false;
                        });
                        $("#cboDuracao").attr('disabled', false);
                        $("#cboDuracao").trigger("chosen:updated");
                        $("#txtConclusaoTratamento").val("");
                        $("#txtConclusaoTratamento").attr('disabled', false);
                        doseUnica = "";
                    }

                    remonta();
                });

                function recalculaConclusaoTratamento() {
                    if (!$('#doseUnica').is(":checked")) $("#txtConclusaoTratamento").attr('disabled', false);
                    if ($("#txtInicioTratamento").val() && $("#txtDuracao").val() && $('#cboDuracao').val()) {

                        var dataInicio = $("#txtInicioTratamento").val();
                        var duracao = $("#txtDuracao").val();
                        var tipoDuracao = $('#cboDuracao').val();

                        //console.log(tipoDuracao);

                        var salvar = true;
                        var periodo = "days";
                        if (tipoDuracao == 2) periodo = "weeks";
                        else if (tipoDuracao == 3) periodo = "months";
                        else if (tipoDuracao == 4) salvar = false;
                        else if (tipoDuracao == 5) salvar = false;

                        tipoDuracaoRemonta = ", durante " + duracao + " " + $("#cboDuracao option:selected").text();

                        if(periodo == "days") duracao = duracao-1;

                        if (salvar) {
                            var new_date = moment(dataInicio, "YYYY-MM-DD").add(duracao, periodo);
                            $("#txtConclusaoTratamento").val(new_date.format('YYYY-MM-DD'));
                        } else {
                            $("#txtConclusaoTratamento").val("");
                            $("#txtConclusaoTratamento").attr('disabled', true);
                        }


                    } else {
                        $("#txtConclusaoTratamento").val("");
                        tipoDuracaoRemonta = "";
                    }

                    remonta();
                }


            });
        </script>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title"> Pesquisa Prescritores: Prescrição <?=$numeroItemAtual." de ".$totalItens;?></h4>
                    </div>
                    <div class="card-body card-block">
                        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    <b>Contexto:</b><br><br>
                                    Nome:<?=$contexto->getCidadaoNome();?><br>
                                    Sexo:<?=$contexto->getCidadaoSexo();?><br>
                                    <br>
                                    <?=$contexto->getTexto();?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6 col-sm-12">
                                    <small class="form-text text-muted">Princípio ativo / medicamento <span
                                                style="color:red">*</span></small>
                                    <?php
                                    $comboMedicamento = new Classe\Medicamento();
                                    echo $comboMedicamento->combo('', 'cboMedicamento', '',implode(',', $listaMedicamento));
                                    ?>
                                </div>
                                <div class="col col-md-6 col-sm-12">
                                    <small class="form-text text-muted">Via de Administração <span
                                                style="color:red">*</span></small>
                                    <?php
                                    $comboViaAdministracao = new Classe\ViaAdministracao();
                                    echo $comboViaAdministracao->combo('', 'cboViaAdministracao', '',implode(',', $listaVia));
                                    ?>
                                </div>
                                <div class="col col-md-6 col-sm-12">
                                    <small class="form-text text-muted">Quantidade da dose <span
                                                style="color:red">*</span></small>
                                    <input type='number' class='form-control' id='txtQuantidadeDose'
                                           name='txtQuantidadeDose'
                                           placeholder='' value=''/>
                                </div>
                                <div class="col col-md-6 col-sm-12">
                                    <small class="form-text text-muted">Unidade de Medida <span
                                                style="color:red">*</span></small>
                                    <?php
                                    $comboUnidadeMedida = new Classe\UnidadeMedida();
                                    echo $comboUnidadeMedida->combo('', 'cboUnidadeMedida', '');
                                    ?>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <small class="form-text text-muted">Dose única
                                    <input type='checkbox' id='doseUnica' name='doseUnica'/>
                            </div>
                            <div class="row form-group divNaoDoseUnica">
                                <div class="col-12" style="margin-top: 10px;">
                                    <ul class="nav nav-tabs" style="border-bottom: 3px solid #007bff; padding-bottom: 10px;">
                                        <li class="nav-item active">
                                            <a class="nav-link active tabMenu" data-toggle="tab" href="#intervalo" style="font-size: 16px; font-weight: bold; color: #007bff; padding: 10px 15px;">
                                                Intervalo
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link tabMenu" data-toggle="tab" href="#frequencia" style="font-size: 16px; font-weight: bold; color: #007bff; padding: 10px 15px;">
                                                Frequência
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link tabMenu" data-toggle="tab" href="#turno" style="font-size: 16px; font-weight: bold; color: #007bff; padding: 10px 15px;">
                                                Turno
                                            </a>
                                        </li>
                                    </ul>
                                    <br>
                                    <div class="tab-content">
                                        <div id="intervalo" class="tab-pane active">
                                            A cada
                                            <button type="button" class="intervalo" id="4h"
                                                    name="4h">4h
                                            </button>
                                            <button type="button" class="intervalo" id="6h"
                                                    name="6h">6h
                                            </button>
                                            <button type="button" class="intervalo" id="8h"
                                                    name="8h">8h
                                            </button>
                                            <button type="button" class="intervalo" id="12h"
                                                    name="12h">12h
                                            </button>
                                            <button type="button" class="intervalo" id="24h"
                                                    name="24h">24h
                                            </button>
                                            <input type='number' id='txtIntervalo' name='txtIntervalo'
                                                   placeholder='' value=''/> horas
                                        </div>
                                        <div id="frequencia" class="tab-pane">
                                            <div class="row">
                                                <div class="col col-12 col-md-12">
                                                    <button type="button" class="frequencia" id="1x"
                                                            name="1x">1x
                                                    </button>
                                                    <button type="button" class="frequencia" id="2x"
                                                            name="2x">2x
                                                    </button>
                                                    <button type="button" class="frequencia" id="3x"
                                                            name="3x">3x
                                                    </button>
                                                    <button type="button" class="frequencia" id="4x"
                                                            name="4x">4x
                                                    </button>
                                                    <input type='number' id='txtFrequencia' name='txtFrequencia'
                                                           placeholder='' value=''/> vez(es) a cada

                                                    <input type='number' id='txtFrequenciaVezes'
                                                           name='txtFrequenciaVezes'
                                                           placeholder='' value=''/>
                                                    <select class='standardSelect' id='cboFrequencia'
                                                            name='cboFrequencia'
                                                            data-placeholder='Selecione a frequência'>
                                                        <option label='default'></option>
                                                        <option value='dia(s)' selected>Dia(s)</option>
                                                        <option value='semana(s)'>Semana(s)</option>
                                                        <option value='mês(es)'>Mês(es)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="turno" class="tab-pane">
                                            <div class="row">
                                                <div class="col col-12 col-md-12">
                                                    <input type='radio' class="turno" id='Manhã' name='txtTurno'
                                                           placeholder='' value=''/> Manhã
                                                    <input type='radio' class="turno" id='Tarde' name='txtTurno'
                                                           placeholder='' value=''/> Tarde
                                                    <input type='radio' class="turno" id='Noite' name='txtTurno'
                                                           placeholder='' value=''/> Noite

                                                    &nbsp;&nbsp;a cada

                                                    <input type='number' id='txtTurnoVezes' name='txtTurnoVezes'
                                                           placeholder='' value=''/>
                                                    <select class='standardSelect' id='cboTurno' name='cboTurno'
                                                            data-placeholder='Selecione a frequência'>
                                                        <option label='default'></option>
                                                        <option value='dia(s)' selected>Dia(s)</option>
                                                        <option value='semana(s)'>Semana(s)</option>
                                                        <option value='mês(es)'>Mês(es)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col col-md-6">
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <p>Posologia</p>
                                            <div id="posologia"><p style='color: red;'>Nenhuma informação adicionada</p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col col-md-4 col-sm-6">
                                    <small class="form-text text-muted">Inicio do Tratamento <span
                                                style="color:red">*</span></small>
                                    <input type='date' class='form-control' id='txtInicioTratamento'
                                           name='txtInicioTratamento' placeholder='' value=''/>
                                </div>
                                <div class="col col-md-4 col-sm-6">
                                    <small class="form-text text-muted"> Duração <span
                                                style="color:red">*</span></small>
                                    <input type='number' class='form-control' id='txtDuracao' name='txtDuracao'
                                           placeholder='' value=''/>
                                </div>
                                <div class="col col-md-4 col-sm-6">
                                    <small class="form-text text-muted"> Tipo duração <span
                                                style="color:red">*</span></small>
                                    <?php
                                    $comboDuracao = new Classe\Duracao();
                                    echo $comboDuracao->combo('', 'cboDuracao', '');
                                    ?>
                                </div>
                                <div class="col col-12 col-md-12">
                                    <small class="form-text text-muted"> Data de Conclusão</small>
                                    <input type='date' class='form-control' id='txtConclusaoTratamento'
                                           name='txtConclusaoTratamento'
                                           placeholder='' value=''/>
                                </div>
                                <div class="col col-12 col-md-12">
                                    <small class="form-text text-muted"> Quantidade solicitada<span
                                                style="color:red">*</span></small>
                                    <input type='number' class='form-control' id='txtQuantidadeSolicitada'
                                           name='txtQuantidadeSolicitada'
                                           placeholder='' value=''/>
                                </div>
                                <div class="col col-12 col-md-12">
                                    <small class="form-text text-muted"><b>Recomendações</b></small>
                                    <textarea class='form-control' id='txtRecomendacoes'
                                              name='txtRecomendacoes'></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-block w-100"
                                            id="cadastrarPrescricao"
                                            name="cadastrarPrescricao">&nbsp;Salvar prescrição e ir para próxima etapa
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } catch (Exception $ex) {
        echo "<div class='alert alert-danger alert-dismissable'><p>" . $ex->getMessage() . "</p></div>";
    }
} else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
