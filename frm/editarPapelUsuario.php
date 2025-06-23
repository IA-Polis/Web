<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['editarPapelUsuario'])){?>
<?php
    if($_POST['codPapelUsuario'])
    {
        $carregarPapelUsuario = new Classe\PapelUsuario();
        $carregarPapelUsuario->setCodPapelUsuario($_POST['codPapelUsuario']);
        $carregarPapelUsuario->carregar();
        $_POST['cboUsuario'] = $carregarPapelUsuario->getCodUsuario();
        $_POST['cboPapel'] = $carregarPapelUsuario->getCodPapel();
    }
?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){ e.preventDefault(); return false;});
            $('.saida').html("");
            $('#editarPapelUsuario').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/editarPapelUsuario.php",
                    data:{
                        codPapelUsuario: $('#codPapelUsuario').val(),
                        cboUsuario: $('#cboUsuario').val(),
                        cboPapel: $('#cboPapel').val(),
                        btnEditarPapelUsuario: '1'
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
                            $('#papelUsuario1').html('');
                            $('#papelUsuario2').html('');
                            $.post("frm/listarPapelUsuario.php",{}, function(resultado2){$('#papelUsuario2').html(resultado2);});
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
                        <h4 class="box-title"> Editar PapelUsuario</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codPapelUsuario" type="hidden" id="codPapelUsuario" value="<?=$_POST['codPapelUsuario'];?>">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Usuario</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboUsuario = new Classe\Usuario();
                                echo $comboUsuario->combo($_POST['cboUsuario'],'cboUsuario','');
                                ?>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarPapelUsuario" name="editarPapelUsuario">Salvar edição</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
