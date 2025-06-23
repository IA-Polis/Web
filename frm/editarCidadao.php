<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['editarCidadao'])){?>
<?php
    if($_POST['codCidadao'])
    {
        $carregarCidadao = new Classe\Cidadao();
        $carregarCidadao->setCodCidadao($_POST['codCidadao']);
        $carregarCidadao->carregar();
        $_POST['txtNome'] = $carregarCidadao->getNome();
        $_POST['txtIdade'] = $carregarCidadao->getIdade();
        $_POST['cboSexo'] = $carregarCidadao->getCodSexo();
        $_POST['cboUsuario'] = $carregarCidadao->getCodUsuario();
        $_POST['cboEscolaridade'] = $carregarCidadao->getCodEscolaridade();
    }
?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){ e.preventDefault(); return false;});
            $('.saida').html("");
            reforcoStandardSelect();
            $('#editarCidadao').click(function() {
                overlayStart();
                $.ajax({
                    method: 'POST',
                    url: "php/editarCidadao.php",
                    data:{
                        codCidadao: $('#codCidadao').val(),
                        txtNome: $('#txtNome').val(),
                        txtIdade: $('#txtIdade').val(),
                        cboSexo: $('#cboSexo').val(),
                        cboEscolaridade: $('#cboEscolaridade').val(),
                        btnEditarCidadao: '1'
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
                        <h4 class="box-title"> Editar Cidadao</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codCidadao" type="hidden" id="codCidadao" value="<?=$_POST['codCidadao'];?>">
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <small class="form-text text-muted">Nome</small>
                                <input type='text' class='form-control' id='txtNome' name='txtNome' placeholder='Nome'value="<?=$_POST['txtNome'];?>"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <small class="form-text text-muted">Idade</small>
                                <input type='number' class='form-control' id='txtIdade' name='txtIdade' placeholder='Idade'value="<?=$_POST['txtIdade'];?>"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <small class="form-text text-muted">Sexto</small>
                                <?php
                                $comboSexo = new Classe\Sexo();
                                echo $comboSexo->combo($_POST['cboSexo'],'cboSexo','');
                                ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <small class="form-text text-muted">Escolaridade</small>
                                <?php
                                $comboEscolaridade = new Classe\Escolaridade();
                                echo $comboEscolaridade->combo($_POST['cboEscolaridade'],'cboEscolaridade','');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-sm" id="editarCidadao" name="editarCidadao">Salvar edição</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
