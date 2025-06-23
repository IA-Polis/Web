<?php
// Autor: Isaias
// Gerada em 30/01/2019 12:34:42
// Última atualização em 30/01/2019 12:34:42
// Versão 3.6.0.0
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['editarPapel'])){?>
<?php
    if($_POST['codPapel'])
    {
        $carregarPapel = new Classe\Papel();
        $carregarPapel->setCodPapel($_POST['codPapel']);
        $carregarPapel->carregar();
        $_POST['txtNome'] = $carregarPapel->getNome();
        $_POST['txtDescricao'] = $carregarPapel->getDescricao();
    }
?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){ e.preventDefault(); return false;});
            $('.saida').html("");
            $('#editarPapel').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/editarPapel.php",
                    data:{
                        codPapel: $('#codPapel').val(),
                        txtNome: $('#txtNome').val(),
                        txtDescricao: $('#txtDescricao').val(),
                        btnEditarPapel: '1'
                    },
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseText);
                            overlayStop();
                        }
                        else {
                            $('.saida').html(data.responseText);
                            overlayStop();
                            $('#papel1').html('');
                            $('#papel2').html('');
                            $.post("frm/listarPapel.php",{}, function(resultado2){$('#papel2').html(resultado2);});
                        }
                    }
                });
            });
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                        <h4 class="box-title"> Editar Papel</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codPapel" type="hidden" id="codPapel" value="<?=$_POST['codPapel'];?>">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class="form-control-label">Nome</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                    <input type='text' class='form-control' id='txtNome' name='txtNome' placeholder='Nome'value="<?=$_POST['txtNome'];?>"/>
                                    <small class="form-text text-muted">Nome</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class="form-control-label">Descricao</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                    <input type='text' class='form-control' id='txtDescricao' name='txtDescricao' placeholder='Descricao'value="<?=$_POST['txtDescricao'];?>"/>
                                    <small class="form-text text-muted">Descricao</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarPapel" name="editarPapel">Salvar edição</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
