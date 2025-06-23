<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?if(isset($_SESSION['PERMISSOES']['listarReceituario'])){?>
    <br><br><br>
    <div id="saida"></div>
    <div id="pictogramaAvaliacaoCompreensibilidade1"></div>
    <div id="pictogramaAvaliacaoCompreensibilidade2">
        <script type="text/javascript">
            var arrayPictogramaAvaliacaoCompreensibilidade = [];
            var pictogramaAvaliacaoCompreensibilidadeAtual = [];
            <?
            $estaPictogramaAvaliacaoCompreensibilidade = new \Classe\PictogramaAvaliacaoCompreensibilidade();
            $colPictogramaAvaliacaoCompreensibilidade = new \Config\phpCollection();
            $colPictogramaAvaliacaoCompreensibilidade = $estaPictogramaAvaliacaoCompreensibilidade->carregarTodosCriterio('codUsuario',$_SESSION['CODIGOUSUARIO']);
            $encontrouNaoFeito = false;
            $pictogramaAvaliacaoCompreensibilidadeAtual = [];
            $aux =1;
            if($colPictogramaAvaliacaoCompreensibilidade->length){
            do{
                ?>
                arrayPictogramaAvaliacaoCompreensibilidade.push("<?=$colPictogramaAvaliacaoCompreensibilidade->current()->getCodPictogramaAvaliacaoCompreensibilidade();?>");
                <?
                if(is_null($colPictogramaAvaliacaoCompreensibilidade->current()->getSignificado()) && !$encontrouNaoFeito){
                    $encontrouNaoFeito = true;
                    $pictogramaAvaliacaoCompreensibilidadeAtual[0] = $colPictogramaAvaliacaoCompreensibilidade->current()->getCodPictogramaAvaliacaoCompreensibilidade();
                    $pictogramaAvaliacaoCompreensibilidadeAtual[1] = $aux;
                }
                $aux++;
            }while($colPictogramaAvaliacaoCompreensibilidade->has_next());
            }

            if(empty($pictogramaAvaliacaoCompreensibilidadeAtual[0])){
                $colPictogramaAvaliacaoCompreensibilidade->rewind();
                $pictogramaAvaliacaoCompreensibilidadeAtual[0] = $colPictogramaAvaliacaoCompreensibilidade->current()->getCodPictogramaAvaliacaoCompreensibilidade();
                $pictogramaAvaliacaoCompreensibilidadeAtual[1] = 1;
            }

            ?>


            pictogramaAvaliacaoCompreensibilidadeAtual[0] = "<?=$pictogramaAvaliacaoCompreensibilidadeAtual[0];?>";
            pictogramaAvaliacaoCompreensibilidadeAtual[1] = "<?=$pictogramaAvaliacaoCompreensibilidadeAtual[1];?>";

            console.log(pictogramaAvaliacaoCompreensibilidadeAtual);

            $().ready(function()
            {


                $(document).off('click', '.anterior');
                $(document).on('click',".anterior", function(){
                    $('#pictogramaAvaliacaoCompreensibilidadeAtual').html('');
                    overlayStart();
                    pictogramaAvaliacaoCompreensibilidadeAtual = getAnterior(pictogramaAvaliacaoCompreensibilidadeAtual[0]);
                    //console.log(pictogramaAvaliacaoCompreensibilidadeAtual);
                    $.post("frm/pictograma_testeCompreensibilidade_editar.php", {codPictogramaAvaliacaoCompreensibilidade:pictogramaAvaliacaoCompreensibilidadeAtual[0],totalItens:arrayPictogramaAvaliacaoCompreensibilidade.length,numeroItemAtual:pictogramaAvaliacaoCompreensibilidadeAtual[1]}, function(resultado){
                        $('#pictogramaAvaliacaoCompreensibilidadeAtual').html(resultado);
                        overlayStop();
                    });
                });

                $(document).off('click', '.proximoItem');
                $(document).on('click',".proximoItem", function(){
                    $('#pictogramaAvaliacaoCompreensibilidadeAtual').html('');
                    overlayStart();
                    pictogramaAvaliacaoCompreensibilidadeAtual = getProximo(pictogramaAvaliacaoCompreensibilidadeAtual[0]);
                    console.log(pictogramaAvaliacaoCompreensibilidadeAtual);
                    $.post("frm/pictograma_testeCompreensibilidade_editar.php",{codPictogramaAvaliacaoCompreensibilidade:pictogramaAvaliacaoCompreensibilidadeAtual[0],totalItens:arrayPictogramaAvaliacaoCompreensibilidade.length,numeroItemAtual:pictogramaAvaliacaoCompreensibilidadeAtual[1]}, function(resultado){
                        $('#pictogramaAvaliacaoCompreensibilidadeAtual').html(resultado);
                        overlayStop();
                    });
                });

                overlayStart();
                $('#pictogramaAvaliacaoCompreensibilidadeAtual').html("");


                $.post("frm/pictograma_testeCompreensibilidade_editar.php",{codPictogramaAvaliacaoCompreensibilidade:pictogramaAvaliacaoCompreensibilidadeAtual[0],totalItens:arrayPictogramaAvaliacaoCompreensibilidade.length,numeroItemAtual:pictogramaAvaliacaoCompreensibilidadeAtual[1]}, function(resultado){
                    $('#pictogramaAvaliacaoCompreensibilidadeAtual').html(resultado);
                    overlayStop();
                });
            });

            function getAnterior(itemAtual){
                //console.log(itemAtual);
                for(aux=0;aux<arrayPictogramaAvaliacaoCompreensibilidade.length;aux++){
                    if(arrayPictogramaAvaliacaoCompreensibilidade[aux] == itemAtual){
                        console.log(aux);
                        if(aux-1 >= 0)
                        {
                            var saida = [];
                            saida[0] = arrayPictogramaAvaliacaoCompreensibilidade[aux-1];
                            saida[1] = aux;
                            return saida;
                        }
                        else{
                            var saida = [];
                            saida[0] = arrayPictogramaAvaliacaoCompreensibilidade[arrayPictogramaAvaliacaoCompreensibilidade.length-1];
                            saida[1] = arrayPictogramaAvaliacaoCompreensibilidade.length;
                            return saida;
                        }
                    }
                }
            }

            function getProximo(itemAtual){
                for(aux=0;aux<arrayPictogramaAvaliacaoCompreensibilidade.length;aux++){
                    if(arrayPictogramaAvaliacaoCompreensibilidade[aux] == itemAtual){
                        if(aux+1 < arrayPictogramaAvaliacaoCompreensibilidade.length){
                            var saida = [];
                            saida[0] = arrayPictogramaAvaliacaoCompreensibilidade[aux+1];
                            saida[1] = aux+2;
                            return saida;
                        }
                        else{
                            var saida = [];
                            saida[0] = arrayPictogramaAvaliacaoCompreensibilidade[0];
                            saida[1] = 1;
                            return saida;
                        }
                    }
                }
            }
        </script>
        <div class="row">
            <div class="col-lg-12" id="pictogramaAvaliacaoCompreensibilidadeAtual">

            </div>
        </div>
    </div>
<?}else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";?>
