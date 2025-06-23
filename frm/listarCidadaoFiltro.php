<?php require_once("../config/config.php"); ?>
<? if (isset($_SESSION['PERMISSOES']['listarCidadao'])) {

    $mostrarTodosCidadaos = 1;
    switch ($_POST['radioMostrarCidadao'])
    {
        case 'mostrarMeusCidadaos':
            $mostrarTodosCidadaos = 2;
            break;
        case 'mostrarMeusReceituarios':
            $mostrarTodosCidadaos = 3;
            break;
    }

    $prompt = 1;
    if(isset($_POST['cboPrompt']) && !empty($_POST['cboPrompt'])){
        $prompt = $_POST['cboPrompt'];
    }

?>
<script>
    $().ready(function () {
        $('#btnAddCidadao').click(function () {
            $('#cidadao1').html('');
            overlayStart();
            $.post("frm/cadastrarCidadao.php", {}, function (resultado) {
                $('#cidadao1').html(resultado);
                overlayStop();
            });
        });
        $('.editarCidadao').click(function () {
            $('#cidadao1').html('');
            overlayStart();
            $.post("frm/editarCidadao.php", {codCidadao: this.id}, function (resultado) {
                $('#cidadao1').html(resultado);
                overlayStop();
            });
        });
        $('.excluirCidadao').click(function () {
            var codCidadao = this.id;
            $('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este Cidadao?');
            $('#modalExclusao').modal("show");
            $('#modalExclusaoDelete').on('click', function (e) {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/excluirCidadao.php",
                    data: {
                        codCidadao: codCidadao,
                        btnExcluirCidadao: '1'
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseText);
                            overlayStop();
                        } else {
                            $('.saida').html(data.responseText);
                            $('#linhaCidadao' + codCidadao).addClass('hide');
                            overlayStop();
                        }
                    }
                });
            });
        });
        $('.listarReceituario').click(function () {
            $('#cidadao1').html('');
            overlayStart();
            $.post("frm/listarReceituario.php", {codCidadao: this.id, codPrompt: '<?=$prompt;?>'}, function (resultado) {
                $('#cidadao1').html(resultado);
                overlayStop();
            });
        });
        $('#dinamicCidadao').DataTable({
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
<div class="card">
    <div class="card-header">
        <h4 class="box-title">Cidadãos</h4>
    </div>
    <div class="card-body">
        <table id="dinamicCidadao" class="dynamic-table table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Código do Cidadão</th>
                <th>Usuário Responsável</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Escolaridade</th>
                <th>Sexo</th>
                <th>Prescrições</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            <?
            $estaCidadao = new Classe\Cidadao();
            $colCidadao = new Config\phpCollection();
            if($mostrarTodosCidadaos == 1) $colCidadao = $estaCidadao->carregarTodosReceituario(null, $prompt, false);
            else if($mostrarTodosCidadaos == 2) $colCidadao = $estaCidadao->carregarTodosReceituario($_SESSION['CODIGOUSUARIO'], $prompt,false);
            else if($mostrarTodosCidadaos == 3) $colCidadao = $estaCidadao->carregarTodosReceituario($_SESSION['CODIGOUSUARIO'], $prompt, true);
            if ($colCidadao->length > 0) {
                $aux = 1;
                do {
                    ?>
                    <tr id='linhaCidadao<?= $colCidadao->current()->getCodCidadao(); ?>'>
                        <td><?= $colCidadao->current()->getCodCidadao(); ?></td>
                        <td><?= $colCidadao->current()->getCodUsuario()==$_SESSION['CODIGOUSUARIO']?$_SESSION['NOMEUSUARIO']:'*****'; ?></td>
                        <td><?= $colCidadao->current()->getNome(); ?></td>
                        <td><?= $colCidadao->current()->getIdade(); ?></td>
                        <?php
                        $foreingEscolaridade = new Classe\Escolaridade();
                        $foreingEscolaridade->setCodEscolaridade($colCidadao->current()->getCodEscolaridade());
                        $foreingEscolaridade->carregar();
                        ?>
                        <td><?= $foreingEscolaridade->getEscolaridade(); ?></td>
                        <?php
                        $foreingSexo = new Classe\Sexo();
                        $foreingSexo->setCodSexo($colCidadao->current()->getCodSexo());
                        $foreingSexo->carregar();
                        ?>
                        <td><?= $foreingSexo->getNome(); ?></td>
                        <?
                        $texto = "";

                        $estaReceituario = new Classe\Receituario();
                        $colReceituario = new Config\phpCollection();
                        $colReceituario = $estaReceituario->carregarTodosCidadaoPrompt($colCidadao->current()->getCodCidadao(),$prompt);
                        if ($colReceituario->length > 0) {
                            do {
                                //PRESCRIÇÃO
                                $estaPrescricao = new Classe\Prescricao();
                                $saidaTextoPrescricao = $estaPrescricao->gerarTextoPrescricao($colReceituario->current()->getCodReceituario());

                                if($saidaTextoPrescricao)
                                {
                                    $texto .= $saidaTextoPrescricao;
                                }
                            } while ($colReceituario->has_next());
                        }

                        ?>
                        <td><?= $texto; ?></td>
                        <td>
                            <? if (isset($_SESSION['PERMISSOES']['editarCidadao'])) {
                                ?><a style="cursor:pointer" href="#" title="Editar Cidadao"
                                     class="editarCidadao "
                                     id="<?= $colCidadao->current()->getCodCidadao(); ?>"><i
                                        class="ti ti-pencil"></i>Editar Cidadão</a><br><?
                            } ?>
                            <? if (isset($_SESSION['PERMISSOES']['excluirCidadao'])) {
                                ?><a style="cursor:pointer" href="#" Title="Excluir Cidadao"
                                     class="excluirCidadao "
                                     id="<?= $colCidadao->current()->getCodCidadao(); ?>"><i
                                        class="ti ti-git-pull-request-closed">Excluir Cidadão</i></a><br><?
                            } ?>
                            <? if (isset($_SESSION['PERMISSOES']['listarReceituario'])) {
                                ?><a style="cursor:pointer" href="#" Title="Listar Receiturario"
                                     class="listarReceituario "
                                     id="<?= $colCidadao->current()->getCodCidadao(); ?>"><i
                                        class="ti ti-list">Listar Receiturários</i></a><?
                            } ?>
                        </td>
                    </tr>
                    <?
                } while ($colCidadao->has_next());
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
}?>