<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?if(isset($_SESSION['PERMISSOES']['listarReceituario'])){?>
    <br><br><br>
    <div id="saida"></div>
    <div id="receituarioV21"></div>
    <div id="receituarioV22">
        <script type="text/javascript">
            var arrayReceituariosV2 = [];
            var receituarioV2Atual = [];
            <?
            $estaReceituarioV2 = new \Classe\ReceituarioV2();
            $colReceituarioV2 = new \Config\phpCollection();
            $colReceituarioV2 = $estaReceituarioV2->carregarTodosPadraoUsuario();
            $encontrouNaoFeito = false;
            $receituarioV2Atual = [];
            $aux =1;
            if($colReceituarioV2->length){
            do{
                ?>
                arrayReceituariosV2.push("<?=$colReceituarioV2->current()->getCodReceituarioV2();?>");
                <?
                if(is_null($colReceituarioV2->current()->getFeedback_adequacao()) && !$encontrouNaoFeito){
                    $encontrouNaoFeito = true;
                    $receituarioV2Atual[0] = $colReceituarioV2->current()->getCodReceituarioV2();
                    $receituarioV2Atual[1] = $aux;
                }
                $aux++;
            }while($colReceituarioV2->has_next());
            }

            if(empty($receituarioV2Atual[0])){
                $colReceituarioV2->rewind();
                $receituarioV2Atual[0] = $colReceituarioV2->current()->getCodReceituarioV2();
                $receituarioV2Atual[1] = 1;
            }

            ?>


            receituarioV2Atual[0] = "<?=$receituarioV2Atual[0];?>";
            receituarioV2Atual[1] = "<?=$receituarioV2Atual[1];?>";

            console.log(receituarioV2Atual);

            $().ready(function()
            {


                $(document).off('click', '.anterior');
                $(document).on('click',".anterior", function(){
                    $('#receituarioV2Atual').html('');
                    overlayStart();
                    receituarioV2Atual = getAnterior(receituarioV2Atual[0]);
                    //console.log(receituarioV2Atual);
                    $.post("frm/editarReceituarioV2.php", {codReceituarioV2:receituarioV2Atual[0],totalItens:arrayReceituariosV2.length,numeroItemAtual:receituarioV2Atual[1]}, function(resultado){
                        $('#receituarioV2Atual').html(resultado);
                        overlayStop();
                    });
                });

                $(document).off('click', '.proximoItem');
                $(document).on('click',".proximoItem", function(){
                    $('#receituarioV2Atual').html('');
                    overlayStart();
                    receituarioV2Atual = getProximo(receituarioV2Atual[0]);
                    console.log(receituarioV2Atual);
                    $.post("frm/editarReceituarioV2.php",{codReceituarioV2:receituarioV2Atual[0],totalItens:arrayReceituariosV2.length,numeroItemAtual:receituarioV2Atual[1]}, function(resultado){
                        $('#receituarioV2Atual').html(resultado);
                        overlayStop();
                    });
                });

                overlayStart();
                $('#receituarioV2Atual').html("");


                $.post("frm/editarReceituarioV2.php",{codReceituarioV2:receituarioV2Atual[0],totalItens:arrayReceituariosV2.length,numeroItemAtual:receituarioV2Atual[1]}, function(resultado){
                    $('#receituarioV2Atual').html(resultado);
                    overlayStop();
                });
            });

            function getAnterior(itemAtual){
                //console.log(itemAtual);
                for(aux=0;aux<arrayReceituariosV2.length;aux++){
                    if(arrayReceituariosV2[aux] == itemAtual){
                        console.log(aux);
                        if(aux-1 >= 0)
                        {
                            var saida = [];
                            saida[0] = arrayReceituariosV2[aux-1];
                            saida[1] = aux;
                            return saida;
                        }
                        else{
                            var saida = [];
                            saida[0] = arrayReceituariosV2[arrayReceituariosV2.length-1];
                            saida[1] = arrayReceituariosV2.length;
                            return saida;
                        }
                    }
                }
            }

            function getProximo(itemAtual){
                for(aux=0;aux<arrayReceituariosV2.length;aux++){
                    if(arrayReceituariosV2[aux] == itemAtual){
                        if(aux+1 < arrayReceituariosV2.length){
                            var saida = [];
                            saida[0] = arrayReceituariosV2[aux+1];
                            saida[1] = aux+2;
                            return saida;
                        }
                        else{
                            var saida = [];
                            saida[0] = arrayReceituariosV2[0];
                            saida[1] = 1;
                            return saida;
                        }
                    }
                }
            }
        </script>
        <div class="row">
            <div class="col-lg-12" id="receituarioV2Atual">

            </div>
        </div>
    </div>
<?}else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";?>
