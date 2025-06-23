<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['cadastrarCidadao'])){?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            reforcoStandardSelect();
            $('#cadastrarCidadao').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/cadastrarCidadao.php",
                    data:{
                        txtNome: $('#txtNome').val(),
                        txtIdade: $('#txtIdade').val(),
                        cboSexo: $('#cboSexo').val(),
                        cboEscolaridade: $('#cboEscolaridade').val(),
                        btnCadastrarCidadao: '1'
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
                            $('#cidadao1').html('');
                            $('#cidadao2').html('');
                            $.post("frm/listarCidadao.php",{}, function(resultado2){$('#cidadao2').html(resultado2);});
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
                        <h4 class="box-title"> Cadastrar Cidadão</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class="form-control-label">Nome</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                    <input type='text' class='form-control' id='txtNome' name='txtNome' placeholder='Nome' value=''/>
                                    <small class="form-text text-muted">Nome completo</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class="form-control-label">Idade</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                    <input type='number' class='form-control' id='txtIdade' name='txtIdade' placeholder='Idade' value=''/>
                                    <small class="form-text text-muted">(Em anos)</small>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Sexo</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboSexo = new Classe\Sexo();
                                echo $comboSexo->combo('','cboSexo','');
                                ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Escolaridade</label>
                            </div>
                            <div class="col col-12 col-md-9">
                                <?php
                                $comboEscolaridade = new Classe\Escolaridade();
                                echo $comboEscolaridade->combo('','cboEscolaridade','');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarCidadao" name="cadastrarCidadao">Salvar cadastro</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
