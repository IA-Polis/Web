<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['cadastrarPrescricao'])) {

    $receituario = new \Classe\Receituario();
    if (isset($_POST['codReceituario'])) {
        $receituario->setCodReceituario($_POST['codReceituario']);
        $receituario->carregar();
    }
    else{
        $_POST['codReceituario'] = 2435;
        $receituario->setCodReceituario(2435);
        $receituario->carregar();
    }

    ?>
    <script type="text/javascript">
        $().ready(function () {
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
                    console.log(data);
                    arrayUnidadeMedida = Object.values(data.responseJSON);
                }
            });

            $('.saida').html("");
            reforcoStandardSelect();
            $('#cadastrarPrescricao').click(function () {
                cadastrarPrescricao(1);
            });
            $('#cadastrarPrescricaoGerarGPT').click(function () {
                cadastrarPrescricao(2);
            });
            $('#cadastrarPrescricaoCadastrarOutra').click(function () {
                cadastrarPrescricao(3);
            });

            function cadastrarPrescricao(tipo = 1) {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/cadastrarPrescricao.php",
                    data: {
                        cboReceituario: $('#cboReceituario').val(),
                        cboViaAdministracao: $('#cboViaAdministracao').val(),
                        cboUnidadeMedida: $('#cboUnidadeMedida').val(),
                        cboMedicamento: $('#cboMedicamento').val(),
                        txtQuantidadeDose: $('#txtQuantidadeDose').val(),
                        txtQuantidadeSolicitada: $('#txtQuantidadeSolicitada').val(),
                        txtInicioTratamento: $('#txtInicioTratamento').val(),
                        txtConclusaoTratamento: $('#txtConclusaoTratamento').val(),
                        txtPosologia: posologia,
                        btnCadastrarPrescricao: '1'
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseText);
                            overlayStop();
                        } else {
                            $('.saida').html(data.responseText);
                            overlayStop();
                            $('#prescricao1').html('');
                            $('#prescricao2').html('');

                            $.post("frm/listarPrescricao.php", {
                                codReceituario: '<?=$receituario->getCodReceituario();?>',
                                codCidadao: '<?=$receituario->getCodCidadao();?>',
                                tipo: tipo
                            }, function (resultado2) {
                                $('#prescricao2').html(resultado2);
                            });
                        }
                    }
                });
            }

            var posologiaPadrao = "Nenhuma informação adicionada";
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
                posologia = "a cada " + this.id;
                intervalo = posologia;
                $('#txtIntervalo').val(this.id.replace('h', ''));

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
                    txtFrequenciaVezes = " a cada " + $(this).val();
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
                if(doseUnica){
                    posologia = quantidade + doseUnica + tipoDuracaoRemonta;
                } else if (frequencia) {
                    posologia = quantidade + frequencia + txtFrequenciaVezes + cboFrequencia + tipoDuracaoRemonta;
                } else if (turno) {
                    posologia = quantidade + turno + txtTurnoVezes + cboTurno + tipoDuracaoRemonta;
                } else if (intervalo) {
                    posologia = quantidade + intervalo + tipoDuracaoRemonta;
                    console.log("ENTROU ",tipoDuracaoRemonta);
                } else {
                    posologia = posologiaPadrao;
                }
                $('#posologia').html(posologia);
            }

            $('.turno').click(function () {
                turno = "pela " + this.id;
                remonta();
            });
            $('#txtTurnoVezes').keyup(function () {
                if ($(this).val()) {
                    txtTurnoVezes = " a cada " + $(this).val();
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
                intervalo = "";
                frequencia = "";
                turno = "";
                if (quantidade) posologia = quantidade;
                else posologia = posologiaPadrao;
                remonta();
            });

            $("#txtInicioTratamento").keyup(function () {
                recalculaConclusaoTratamento();
            });

            $("#txtDuracao").change(function () {
                recalculaConclusaoTratamento();
            });

            $("#cboDuracao").change(function () {
                recalculaConclusaoTratamento();
            });
            $("#doseUnica").change(function () {
                if($('#doseUnica').is(":checked")){
                    $('.divNaoDoseUnica').addClass('hide');
                    doseUnica = "dose unica";
                }else{
                    $('.divNaoDoseUnica').removeClass('hide');
                    doseUnica = "";
                }

                remonta();
            });

            function recalculaConclusaoTratamento() {
                $("#txtConclusaoTratamento").attr('disabled', false);
                if ($("#txtInicioTratamento").val() && $("#txtDuracao").val() && $('#cboDuracao').val()) {

                    var dataInicio = $("#txtInicioTratamento").val();
                    var duracao = $("#txtDuracao").val();
                    var tipoDuracao = $('#cboDuracao').val();

                    console.log(tipoDuracao);

                    var salvar = true;
                    var periodo = "days";
                    if (tipoDuracao == 2) periodo = "weeks";
                    else if (tipoDuracao == 3) periodo = "months";
                    else if (tipoDuracao == 4) salvar = false;
                    else if (tipoDuracao == 5) salvar = false;

                    if (salvar) {
                        var new_date = moment(dataInicio, "YYYY-MM-DD").add(duracao, periodo);
                        $("#txtConclusaoTratamento").val(new_date.format('YYYY-MM-DD'));
                    } else {
                        $("#txtConclusaoTratamento").val("");
                        $("#txtConclusaoTratamento").attr('disabled', true);
                    }

                    tipoDuracaoRemonta = ", durante "+duracao+" "+$( "#cboDuracao option:selected" ).text();
                } else{
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
                    <h4 class="box-title"> Cadastrar Prescrição</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="cboReceituario" type="hidden" id="cboReceituario"
                               value="<?= $_POST['codReceituario']; ?>">
                        <div class="row form-group">
                            <div class="col col-6 col-md-6">
                                <small class="form-text text-muted">Princípio ativo / medicamento <span
                                            style="color:red">*</span></small>
                                <?php
                                $comboMedicamento = new Classe\Medicamento();
                                echo $comboMedicamento->combo('', 'cboMedicamento', '');
                                ?>
                            </div>
                            <div class="col col-6 col-md-6">
                                <small class="form-text text-muted">Via de Administração <span
                                            style="color:red">*</span></small>
                                <?php
                                $comboViaAdministracao = new Classe\ViaAdministracao();
                                echo $comboViaAdministracao->combo('', 'cboViaAdministracao', '');
                                ?>
                            </div>
                            <div class="col col-6 col-md-6">
                                <small class="form-text text-muted">Quantidade da dose <span style="color:red">*</span></small>
                                <input type='number' class='form-control' id='txtQuantidadeDose'
                                       name='txtQuantidadeDose'
                                       placeholder='' value=''/>
                            </div>
                            <div class="col col-6 col-md-6">
                                <small class="form-text text-muted">Unidade de Medida <span
                                            style="color:red">*</span></small>
                                <?php
                                $comboUnidadeMedida = new Classe\UnidadeMedida();
                                echo $comboUnidadeMedida->combo('', 'cboUnidadeMedida', '');
                                ?>
                            </div>
                        </div>
                        <div class="col col-6 col-md-6">
                            <small class="form-text text-muted">Dose única
                                <input type='checkbox' id='doseUnica' name='doseUnica'/>
                        </div>
                        <div class="row form-group divNaoDoseUnica">
                            <div class="col col-12 col-md-12" style="margin-top: 10px">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a class="active tabMenu" data-toggle="tab" href="#intervalo">Intervalo &nbsp;
                                            &nbsp;</a>
                                    </li>
                                    <li>
                                        <a class="tabMenu" data-toggle="tab" href="#frequencia">Frequência &nbsp;
                                            &nbsp;</a>
                                    </li>
                                    <li>
                                        <a class="tabMenu" data-toggle="tab" href="#turno">Turno &nbsp; &nbsp;</a>
                                    </li>
                                </ul>
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
                                            <div class="col col-6 col-md-6">
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

                                                <input type='number' id='txtFrequenciaVezes' name='txtFrequenciaVezes'
                                                       placeholder='' value=''/>
                                            </div>
                                            <div class="col col-2 col-md-2">
                                                <select class='standardSelect' id='cboFrequencia' name='cboFrequencia'
                                                        data-placeholder='Selecione a frequência'>
                                                    <option label='default'></option>
                                                    <option value='Dia(s)' selected>Dia(s)</option>
                                                    <option value='Semana(s)'>Semana(s)</option>
                                                    <option value='Mês(es)'>Mês(es)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="turno" class="tab-pane">
                                        <div class="row">
                                            <div class="col col-4 col-md-4">
                                                <input type='radio' class="turno" id='Manhã' name='txtTurno'
                                                       placeholder='' value=''/> Manhã
                                                <input type='radio' class="turno" id='Tarde' name='txtTurno'
                                                       placeholder='' value=''/> Tarde
                                                <input type='radio' class="turno" id='Noite' name='txtTurno'
                                                       placeholder='' value=''/> Noite

                                                &nbsp;&nbsp;a cada

                                                <input type='number' id='txtTurnoVezes' name='txtTurnoVezes'
                                                       placeholder='' value=''/>
                                            </div>
                                            <div class="col col-2 col-md-2">
                                                <select class='standardSelect' id='cboTurno' name='cboTurno'
                                                        data-placeholder='Selecione a frequência'>
                                                    <option label='default'></option>
                                                    <option value='Dia(s)' selected>Dia(s)</option>
                                                    <option value='Semana(s)'>Semana(s)</option>
                                                    <option value='Mês(es)'>Mês(es)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                        <div class="col col-6 col-md-6">
                            <div class="row form-group">
                                <div class="col col-6 col-md-6">
                                    <small class="form-text text-muted">Posologia</small>
                                    <div id="posologia">Nenhuma informação adicionada</div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-4 col-md-4">
                                <small class="form-text text-muted">Inicio do Tratamento <span
                                            style="color:red">*</span></small>
                                <input type='date' class='form-control' id='txtInicioTratamento'
                                       name='txtInicioTratamento' placeholder='' value=''/>
                            </div>
                            <div class="col col-4 col-md-4">
                                <small class="form-text text-muted"> Duração <span style="color:red">*</span></small>
                                <input type='text' class='form-control' id='txtDuracao' name='txtDuracao'
                                       placeholder='' value=''/>
                            </div>
                            <div class="col col-4 col-md-4">
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
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarPrescricao"
                                        name="cadastrarPrescricao">Salvar Prescrição
                                </button>
                            </div>
                            <!--<div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-block btn-sm"
                                        id="cadastrarPrescricaoGerarGPT"
                                        name="cadastrarPrescricaoGerarGPT">Salvar Prescrição e gerar GPT do Receituario
                                </button>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-block btn-sm"
                                        id="cadastrarPrescricaoCadastrarOutra"
                                        name="cadastrarPrescricaoCadastrarOutra">Salvar Prescrição e cadastrar outra
                                </button>
                            </div>-->
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
