<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<? if (isset($_SESSION['PERMISSOES']['listarReceituario'])) {


    $codPrompt = '';
    if(isset($_POST['codPrompt'])){
        $codPrompt = $_POST['codPrompt'];
    }


    $codReceituario = "";
    if(isset($_POST['codReceituario'])){
        $codReceituario = $_POST['codReceituario'];
    }

    $cidadao = new \Classe\Cidadao();
    $sexo = new \Classe\Sexo();
    $escolaridade = new \Classe\Escolaridade();
    if(isset($_POST['codCidadao'])){
        $cidadao->setCodCidadao($_POST['codCidadao']);
        $cidadao->carregar();

        $sexo->setCodSexo($cidadao->getCodSexo());
        $sexo->carregar();

        $escolaridade->setCodEscolaridade($cidadao->getCodEscolaridade());
        $escolaridade->carregar();
    }

    ?>
    <div id="receituario1"></div>
    <div id="saida" class="saida"></div>
    <div id="receituario2">
        <script type="text/javascript">
            $().ready(function () {
                $('#btnAddReceituario').click(function () {
                    $('#receituario1').html('');
                    overlayStart();
                    $.post("frm/cadastrarReceituario.php", {codCidadao:'<?=$cidadao->getCodCidadao();?>'}, function (resultado) {
                        $('#receituario1').html(resultado);
                        overlayStop();
                    });
                });

                $('.editarReceituario').click(function () {
                    $('#receituario1').html('');
                    overlayStart();
                    $.post("frm/editarReceituario.php", {codReceituario: this.id,codCidadao:'<?=$cidadao->getCodCidadao();?>'}, function (resultado) {
                        $('#receituario1').html(resultado);
                        overlayStop();
                    });
                });
                $('.excluirReceituario').click(function () {
                    var codReceituario = this.id;
                    $('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este Receituario?');
                    $('#modalExclusao').modal("show");
                    $('#modalExclusaoDelete').on('click', function (e) {
                        overlayStart();
                        $.ajax({
                            method: 'POST',
                            url: "php/excluirReceituario.php",
                            data: {
                                codReceituario: codReceituario,
                                btnExcluirReceituario: '1'
                            },
                            dataType: "json",
                            complete: function (data, status) {
                                if (status === 'error' || !data.responseText) {
                                    console.log(data);
                                    $('.saida').html(data.responseText);
                                    overlayStop();
                                } else {
                                    $('.saida').html(data.responseText);
                                    $('#linhaReceituario' + codReceituario).addClass('hide');
                                    overlayStop();
                                }
                            }
                        });
                    });
                });
                $('.listarPrescricao').click(function () {
                    $('#receituario1').html('');
                    overlayStart();
                    $.post("frm/listarPrescricao.php", {codReceituario: this.id,codCidadao:'<?=$cidadao->getCodCidadao();?>'}, function (resultado) {
                        $('#receituario1').html(resultado);
                        overlayStop();
                    });
                });
                $('.clonarReceituario').click(function () {
                    $('#receituario1').html('');
                    var codReceituario = this.id;
                    overlayStart();
                    $.ajax({
                        method: 'POST',
                        url: "php/clonarReceituario.php",
                        data: {
                            codReceituario:codReceituario,
                            codCidadao:'<?=$cidadao->getCodCidadao();?>',
                            btnCadastrarReceituario:1
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
                                $('#receituario1').html('');
                                $('#receituario2').html('');

                                $.post("frm/listarReceituario.php", {codReceituario: codReceituario,codCidadao:'<?=$cidadao->getCodCidadao();?>'}, function (resultado2) {
                                    $('#receituario2').html(resultado2);
                                });
                            }
                        }
                    });
                });
                var codReceituario = '<?=$codReceituario;?>';
                if(codReceituario){
                    $.post("frm/listarPrescricao.php", {codReceituario: codReceituario,codCidadao:'<?=$cidadao->getCodCidadao();?>',cadastrarPrescricao:1}, function (resultado) {
                        $('#receituario1').html(resultado);
                    });
                }
                $('#dinamicReceituario').DataTable({
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
                        <? if (isset($_SESSION['PERMISSOES']['cadastrarReceituario'])) { ?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddReceituario"
                                    name="btnAddReceituario">Cadastrar Receituario
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
                        <h4 class="box-title">Receituários do cidadão <?=$cidadao->getNome();?></h4>
                    </div>
                    <div class="card-body">
                        <table id="dinamicReceituario"
                               class="dynamic-table table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Código do receituário</th>
                                <th>Usuario</th>
                                <th>Rodada</th>
                                <th>Data de Inclusão</th>
                                <th>Prescrição</th>
                                <th>Motivo da Consulta</th>
                                <th>Texto gerado pela LLM</th>
                                <th>Similaridade com o texto padrão</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $estaReceituario = new Classe\Receituario();
                            $colReceituario = new Config\phpCollection();
                            $colReceituario = $estaReceituario->carregarTodosCidadaoPrompt($cidadao->getCodCidadao(),$codPrompt);
                            if ($colReceituario->length > 0) {
                                $aux = 1;
                                do {
                                    ?>
                                    <tr id='linhaReceituario<?= $colReceituario->current()->getCodReceituario(); ?>'>
                                        <td><?= $colReceituario->current()->getCodReceituario(); ?></td>
                                        <td><?= $colReceituario->current()->getCodUsuario()==$_SESSION['CODIGOUSUARIO']?$_SESSION['NOMEUSUARIO']:'*****'; ?></td>
                                        <?
                                        //PROMPT
                                        $newPrompt = new \Classe\Prompt();
                                        $newPrompt->setCodPrompt($colReceituario->current()->getCodPrompt());
                                        $newPrompt->carregar();
                                        ?>
                                        <td><?= $newPrompt->getRodada();?></td>
                                        <td><?= \Config\Tempo::ConverteData($colReceituario->current()->getDataInclusao()); ?></td>
                                        <?
                                        //PRESCRIÇÃO
                                        $estaPrescricao = new Classe\Prescricao();
                                        $texto = $estaPrescricao->gerarTextoPrescricao(null,$colReceituario->current()->getCodReceituario());

                                        ?>
                                        <td><?= $texto; ?></td>
                                        <td><?= $colReceituario->current()->getMotivoConsulta(); ?></td>
                                        <td><?= $colReceituario->current()->getTextoSaida(); ?></td>
                                        <td><?= $colReceituario->current()->getSimilaridade()."%"; ?></td>
                                        <td>
                                            <? if (isset($_SESSION['PERMISSOES']['editarReceituario']) /*&& $colReceituario->current()->getCodUsuario()==$_SESSION['CODIGOUSUARIO']*/) {
                                                ?><a style="cursor:pointer" href="#" title="Editar Receituario"
                                                     class="editarReceituario "
                                                     id="<?= $colReceituario->current()->getCodReceituario(); ?>"><i
                                                            class="ti ti-panel"></i>LLM</a><br><br><?
                                            } ?>
                                            <? if (isset($_SESSION['PERMISSOES']['excluirReceituario']) && $colReceituario->current()->getCodUsuario()==$_SESSION['CODIGOUSUARIO']) {
                                                ?><a style="cursor:pointer" href="#" Title="Excluir Receituario"
                                                     class="excluirReceituario "
                                                     id="<?= $colReceituario->current()->getCodReceituario(); ?>"><i
                                                            class="ti ti-git-pull-request-closed"></i>Excluir Receituario</a><br><br><?
                                            } ?>
                                            <? if (isset($_SESSION['PERMISSOES']['cadastrarReceituario'])) {
                                                ?><a style="cursor:pointer" href="#" Title="Clonar Receituario"
                                                     class="clonarReceituario "
                                                     id="<?= $colReceituario->current()->getCodReceituario(); ?>"><i
                                                            class="fa fa-clone fa-lg"></i>Clonar Receituario</i></a><br><br><?
                                            } ?>
                                            <? if (isset($_SESSION['PERMISSOES']['listarPrescricao']) && $colReceituario->current()->getCodUsuario()==$_SESSION['CODIGOUSUARIO'] && !$colReceituario->current()->getTextoSaida()) {
                                                ?><a style="cursor:pointer" href="#" Title="Listar Prescrições"
                                                     class="listarPrescricao"
                                                     id="<?= $colReceituario->current()->getCodReceituario(); ?>"><i
                                                            class="ti ti-list"></i>Listar Prescrições</a><br><?
                                            } ?>
                                        </td>
                                    </tr>
                                    <?
                                } while ($colReceituario->has_next());
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
