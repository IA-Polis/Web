<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?php if(isset($_SESSION['PERMISSOES']['cadastrarReceituario'])){?>
    <script type="text/javascript">
        $().ready(function()
        {
            $("form").submit(function(e){
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            $.ajax({
                method: 'POST',
                url: "php/cadastrarReceituario.php",
                data:{
                    codCidadao:'<?=$_POST['codCidadao'];?>',
                    btnCadastrarReceituario: '1'
                },
                dataType: "json",
                complete: function (data, status) {
                    if (status === 'error' || !data.responseText) {
                        console.log(data);
                        $('.saida').html(data.responseJSON.saida);
                        overlayStop();
                    }
                    else{
                        $('.saida').html(data.responseJSON.saida);
                        overlayStop();
                        $('#receituario1').html('');
                        $('#receituario2').html('');
                        $.post("frm/listarReceituario.php",{codReceituario:data.responseJSON.codReceituario,codCidadao:'<?=$_POST['codCidadao'];?>'}, function(resultado2){$('#receituario2').html(resultado2);});
                    }
                }
            });
        });
    </script>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
