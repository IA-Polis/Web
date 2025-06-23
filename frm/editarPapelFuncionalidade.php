<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['editarPapelFuncionalidade'])){?>
<?php
    if($_POST['codPapelFuncionalidade'])
    {
        $carregarPapelFuncionalidade = new Classe\PapelFuncionalidade();
        $carregarPapelFuncionalidade->setCodPapelFuncionalidade($_POST['codPapelFuncionalidade']);
        $carregarPapelFuncionalidade->carregar();
        $_POST['cboPapel'] = $carregarPapelFuncionalidade->getCodPapel();
        $_POST['cboFuncionalidade'] = $carregarPapelFuncionalidade->getCodFuncionalidade();
    }
?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){ e.preventDefault(); return false;});
            $('.saida').html("");
            $('#editarPapelFuncionalidade').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/editarPapelFuncionalidade.php",
                    data:{
                        codPapelFuncionalidade: $('#codPapelFuncionalidade').val(),
                        cboPapel: $('#cboPapel').val(),
                        cboFuncionalidade: $('#cboFuncionalidade').val(),
                        btnEditarPapelFuncionalidade: '1'
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
                            $('#papelFuncionalidade1').html('');
                            $('#papelFuncionalidade2').html('');
                            $.post("frm/listarPapelFuncionalidade.php",{}, function(resultado2){$('#papelFuncionalidade2').html(resultado2);});
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
                        <h4 class="box-title"> Editar PapelFuncionalidade</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codPapelFuncionalidade" type="hidden" id="codPapelFuncionalidade" value="<?=$_POST['codPapelFuncionalidade'];?>">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Papel</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboPapel = new Classe\Papel();
                                echo $comboPapel->combo($_POST['cboPapel'],'cboPapel','');
                                ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Funcionalidade</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboFuncionalidade = new Classe\Funcionalidade();
                                echo $comboFuncionalidade->combo($_POST['cboFuncionalidade'],'cboFuncionalidade','');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarPapelFuncionalidade" name="editarPapelFuncionalidade">Salvar edição</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
