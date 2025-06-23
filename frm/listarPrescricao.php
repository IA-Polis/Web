<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<? if (isset($_SESSION['PERMISSOES']['listarPrescricao'])) {

    $cadastrarPrescricao = "";
    if (isset($_POST['cadastrarPrescricao'])) $cadastrarPrescricao = $_POST['cadastrarPrescricao'];

    $receituario = new \Classe\Receituario();
    if (isset($_POST['codReceituario'])) {
        $receituario->setCodReceituario($_POST['codReceituario']);
        $receituario->carregar();
    }
    $cidadao = new \Classe\Cidadao();
    if (isset($_POST['codCidadao'])) {
        $cidadao->setCodCidadao($_POST['codCidadao']);
        $cidadao->carregar();
    }

    $gerarGPT = false;

    if (isset($_POST['tipo'])) {
        if($_POST['tipo'] == 2){
            $gerarGPT = true;
        }else if($_POST['tipo'] == 3){
            $cadastrarPrescricao = true;
        }
    }

    ?>
    <div id="prescricao1"></div>
    <div id="saida" class="saida"></div>
    <div id="prescricao2">
        <script type="text/javascript">
            $().ready(function () {
                var cadastrarPrescricao = '<?=$cadastrarPrescricao;?>';
                if (cadastrarPrescricao) {
                    $.post("frm/cadastrarPrescricao.php", {codReceituario: '<?=$receituario->getCodReceituario();?>'}, function (resultado) {
                        $('#prescricao1').html(resultado);
                    });
                }

                $('#btnAddPrescricao').click(function () {
                    $('#prescricao1').html('');
                    overlayStart();
                    $.post("frm/cadastrarPrescricao.php", {codReceituario: '<?=$receituario->getCodReceituario();?>'}, function (resultado) {
                        $('#prescricao1').html(resultado);
                        overlayStop();
                    });
                });
                var gerarGPT = '<?=$gerarGPT;?>';
                if (gerarGPT) {
                    $('#prescricao1').html('');
                    overlayStart();
                    $.post("frm/editarReceituario.php", {codReceituario: '<?=$receituario->getCodReceituario();?>'}, function (resultado) {
                        $('#prescricao1').html(resultado);
                        overlayStop();
                    });
                }
                $('#btnGerarGPT').click(function () {
                    $('#prescricao1').html('');
                    overlayStart();
                    $.post("frm/editarReceituario.php", {codReceituario: '<?=$receituario->getCodReceituario();?>'}, function (resultado) {
                        $('#prescricao1').html(resultado);
                        overlayStop();
                    });
                });

                $('.editarPrescricao').click(function () {
                    $('#prescricao1').html('');
                    overlayStart();
                    $.post("frm/editarPrescricao.php", {codPrescricao: this.id}, function (resultado) {
                        $('#prescricao1').html(resultado);
                        overlayStop();
                    });
                });
                $('.excluirPrescricao').click(function () {
                    var codPrescricao = this.id;
                    $('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este Prescricao?');
                    $('#modalExclusao').modal("show");
                    $('#modalExclusaoDelete').on('click', function (e) {
                        overlayStart();
                        $.ajax({
                            method: 'POST',
                            url: "php/excluirPrescricao.php",
                            data: {
                                codPrescricao: codPrescricao,
                                btnExcluirPrescricao: '1'
                            },
                            dataType: "json",
                            complete: function (data, status) {
                                if (status === 'error' || !data.responseText) {
                                    console.log(data);
                                    $('.saida').html(data.responseText);
                                    overlayStop();
                                } else {
                                    $('.saida').html(data.responseText);
                                    $('#linhaPrescricao' + codPrescricao).addClass('hide');
                                    overlayStop();
                                }
                            }
                        });
                    });
                });
                $('#dinamicPrescricao').DataTable({
                    stateSave: true,
                    "aLengthMenu": [
                        [10, 25, 50, 100, 200, -1],
                        [10, 25, 50, 100, 200, "Todos"],
                    ],
                    "language": {
                        "emptyTable": "Lista vazia",
                        "info": "Mostrando _START_ até _END_ de um total de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "infoFiltered": "(filtrado de um total de _MAX_ total records)",
                        "infoPostFix": ".",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "loadingRecords": "Carregando...",
                        "processing": "Processando...",
                        "search": "Busca: ",
                        "zeroRecords": "Nenhum registro encontrado",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "aria": {
                            "sortAscending": ": ative para ordenar coluna de forma crescente",
                            "sortDescending": ": ative para ordenar coluna de forma decrescente"
                        }
                    }
                });
            });
        </script>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarPrescricao'])) { ?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddPrescricao"
                                    name="btnAddPrescricao">Cadastrar Prescrição
                            </button>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarPrescricao'])) { ?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnGerarGPT"
                                    name="btnGerarGPT">Gerar GPT deste receituario
                            </button>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title">Prescrições do Receituario</h4>
                    </div>
                    <div class="card-body">
                        <table id="dinamicPrescricao"
                               class="dynamic-table table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Código da prescrição</th>
                                <th>Medicamento</th>
                                <th>Via</th>
                                <th>Unidade</th>
                                <th>Quantidade</th>
                                <th>Posologia</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $estaPrescricao = new Classe\Prescricao();
                            $colPrescricao = new Config\phpCollection();
                            $colPrescricao = $estaPrescricao->carregarTodosCriterio('codReceituario', $receituario->getCodReceituario());
                            if ($colPrescricao->length > 0) {
                                $aux = 1;
                                do {
                                    ?>
                                    <tr id='linhaPrescricao<?= $colPrescricao->current()->getCodPrescricao(); ?>'>
                                        <td><?= $colPrescricao->current()->getCodPrescricao(); ?></td>
                                        <?php
                                        $foreingMedicamento =  new Classe\Medicamento();
                                        $foreingMedicamento->setCodMedicamento($colPrescricao->current()->getCodMedicamento());
                                        $foreingMedicamento->carregar();
                                        ?>
                                        <td><?=$foreingMedicamento->getNoPrincipioAtivo()." ".$foreingMedicamento->getConcentracao();?></td>
                                        <?php
                                        $foreingViaAdministracao = new Classe\ViaAdministracao();
                                        $foreingViaAdministracao->setCodViaAdministracao($colPrescricao->current()->getCodViaAdministracao());
                                        $foreingViaAdministracao->carregar();
                                        ?>
                                        <td><?= $foreingViaAdministracao->getViaAdministracao(); ?></td>
                                        <?php
                                        $foreingUnidadeMedida = new Classe\UnidadeMedida();
                                        $foreingUnidadeMedida->setCodUnidadeMedida($colPrescricao->current()->getCodUnidadeMedida());
                                        $foreingUnidadeMedida->carregar();
                                        ?>
                                        <td><?= $foreingUnidadeMedida->getUnidadeMedida(); ?></td>
                                        <td><?= $colPrescricao->current()->getQuantidadeDose(); ?></td>
                                        <td><?= $colPrescricao->current()->getPosologia(); ?></td>
                                        <td>
                                            <? if (isset($_SESSION['PERMISSOES']['editarPrescricao'])) {
                                                ?><a style="cursor:pointer" href="#" title="Editar Prescricao"
                                                     class="editarPrescricao "
                                                     id="<?= $colPrescricao->current()->getCodPrescricao(); ?>"><i
                                                            class="ti ti-pencil"></i></a><?
                                            } ?>
                                            <? if (isset($_SESSION['PERMISSOES']['excluirPrescricao'])) {
                                                ?><a style="cursor:pointer" href="#" Title="Excluir Prescricao"
                                                     class="excluirPrescricao "
                                                     id="<?= $colPrescricao->current()->getCodPrescricao(); ?>"><i
                                                            class="ti ti-git-pull-request-closed"></i></a><?
                                            } ?>
                                        </td>
                                    </tr>
                                    <?
                                } while ($colPrescricao->has_next());
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
