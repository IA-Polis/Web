<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<? if (isset($_SESSION['PERMISSOES']['listarCidadao'])) { ?>
    <div id="cidadao1"></div>
    <div id="saida" class="saida"></div>
    <div id="cidadao2">
        <script type="text/javascript">
            $().ready(function () {
                reforcoStandardSelect();
                $.post("frm/listarCidadaoFiltro.php", {
                    radioMostrarCidadao:'mostrarMeusReceituarios',
                    cboPrompt: '19'
                }, function (resultado) {
                    $('#divListarCidadaoFiltro').html(resultado);
                    overlayStop();
                });
                $(".radioMostrarCidadao").change(function (){
                    $.post("frm/listarCidadaoFiltro.php", {
                        radioMostrarCidadao:$(this).val(),
                        cboPrompt:$('#cboPrompt').val()
                    }, function (resultado) {
                        $('#divListarCidadaoFiltro').html(resultado);
                        overlayStop();
                    });
                });
                $("#cboPrompt").change(function (){
                    $.post("frm/listarCidadaoFiltro.php", {
                        radioMostrarCidadao:$(this).val(),
                        cboPrompt:$('#cboPrompt').val()
                    }, function (resultado) {
                        $('#divListarCidadaoFiltro').html(resultado);
                        overlayStop();
                    });
                });

            });
        </script>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarCidadao'])) { ?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddCidadao"
                                    name="btnAddCidadao">Cadastrar Cidadão
                            </button>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarCidadao'])) { ?>
                            <input type="radio" name="radioMostrarCidadao" id="radioMostrarCidadao" class="radioMostrarCidadao" value="mostrarTodosCidadaos"/> Mostrar todos cidadãos <br>
                            <input type="radio" name="radioMostrarCidadao" id="radioMostrarCidadao" class="radioMostrarCidadao" value="mostrarMeusCidadaos"/> Mostrar somente os cidadãos que eu cadastrei <br>
                            <input type="radio" name="radioMostrarCidadao" id="radioMostrarCidadao" class="radioMostrarCidadao" value="mostrarMeusReceituarios" checked/> Mostrar somente os cidadãos que eu cadastrei receituario
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarCidadao'])) {
                            $prompt = new \Classe\Prompt();
                            ?><small class="form-text text-muted">Rodada</small><?
                            echo $prompt->combo('19','cboPrompt',false);
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="divListarCidadaoFiltro">

            </div>
        </div>
    </div>
<? } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>

