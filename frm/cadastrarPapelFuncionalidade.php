<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['cadastrarPapelFuncionalidade'])){?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            $('#cadastrarPapelFuncionalidade').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/cadastrarPapelFuncionalidade.php",
                    data:{
                        cboPapel: $('#cboPapel').val(),
                        cboFuncionalidade: $('#cboFuncionalidade').val(),
                        btnCadastrarPapelFuncionalidade: '1'
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseText);
                            overlayStop();
                        }
                        else{
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
                        <h4 class="box-title"> Cadastrar PapelFuncionalidade</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Papel</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboPapel = new Classe\Papel();
                                echo $comboPapel->combo('','cboPapel','');
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
                                echo $comboFuncionalidade->combo('','cboFuncionalidade','');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarPapelFuncionalidade" name="cadastrarPapelFuncionalidade">Salvar cadastro</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
