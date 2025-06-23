<?php
// Autor: Isaias
// Gerada em 30/01/2019 12:34:42
// Última atualização em 30/01/2019 12:34:42
// Versão 3.6.0.0
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['editarFuncionalidade'])){?>
<?php
    if($_POST['codFuncionalidade'])
    {
        $carregarFuncionalidade = new Classe\Funcionalidade();
        $carregarFuncionalidade->setCodFuncionalidade($_POST['codFuncionalidade']);
        $carregarFuncionalidade->carregar();
        $_POST['txtNome'] = $carregarFuncionalidade->getNome();
        $_POST['txtDescricao'] = $carregarFuncionalidade->getDescricao();
    }
?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){ e.preventDefault(); return false;});
            $('.saida').html("");
            $('#editarFuncionalidade').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/editarFuncionalidade.php",
                    data:{
                        codFuncionalidade: $('#codFuncionalidade').val(),
                        txtNome: $('#txtNome').val(),
                        txtDescricao: $('#txtDescricao').val(),
                        btnEditarFuncionalidade: '1'
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
                            $('#funcionalidade1').html('');
                            $('#funcionalidade2').html('');
                            $.post("frm/listarFuncionalidade.php",{}, function(resultado2){$('#funcionalidade2').html(resultado2);});
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
                        <h4 class="box-title"> Editar Funcionalidade</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codFuncionalidade" type="hidden" id="codFuncionalidade" value="<?=$_POST['codFuncionalidade'];?>">
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
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarFuncionalidade" name="editarFuncionalidade">Salvar edição</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
