<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>


<script type="text/javascript">
    $().ready(function () {
        $("form").submit(function (e) {
            e.preventDefault();
            return false;
        });

        $('#cadastrarApresentacao').click(function() {
            overlayStart();
            $.ajax({
                method: 'POST',
                url: "php/pictograma_avaliacaoExterna_apresentacao.php",
                data:{
                    txtApresentacao_idade: $("input[type='radio'][name=txtApresentacao_idade]:checked").val(),
                    txtApresentacao_genero: $("input[type='radio'][name=txtApresentacao_genero]:checked").val(),
                    txtApresentacao_escolaridade: $("input[type='radio'][name=txtApresentacao_escolaridade]:checked").val(),
                    btnPictograma_avaliacaoExterna_apresentacao: '1'
                },
                complete: function (data, status) {
                    if (status === 'error' || !data.responseText) {
                        console.log("ERROR_apresentacao");
                        console.log(data);
                        $('.saida').html(data.responseText);
                        overlayStop();
                    }
                    else {
                        $('.saida').html(data.responseText);
                        console.log("proximaEtapaPictograma_apresentacao");
                        overlayStop();
                        $(".proximaEtapaApresentacao").trigger("click");
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
                <h4 class="box-title">Teste de associação símbolo-referente (ISO 9186-3:2018)</h4>
            </div>
            <div class="card-body card-block">
                <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <input name="proximaEtapaApresentacao" type="hidden" id="proximaEtapaApresentacao" class="proximaEtapaApresentacao" value="1">
                    <div class="row">
                        <div class="col-sm-12">
                            <p><strong>Instru&ccedil;&otilde;es</strong></p>
                            <p>Gostar&iacute;amos que voc&ecirc; nos ajudasse a avaliar alguns s&iacute;mbolos propostos (pictogramas) para facilitar a compreens&atilde;o de receitas de medicamentos.</p>
                            <p>Voc&ecirc; pode nos ajudar a verificar se estes s&iacute;mbolos s&atilde;o bem compreendidos indicando o que voc&ecirc; considera que cada s&iacute;mbolo significa.</p>
                            <p>Em cada p&aacute;gina mostraremos um s&iacute;mbolo que pode ser encontrado em receitas de medicamentos e, abaixo do s&iacute;mbolo, uma lista de significados poss&iacute;veis para este s&iacute;mbolo.</p>
                            <p>Antes disso, precisamos saber um pouquinho</p>
                            <p>&nbsp;</p>
                            <p><strong>Perfil do respondente</strong></p>
                            <p>Sua participa&ccedil;&atilde;o nesta pesquisa &eacute; an&ocirc;nima, mas gostar&iacute;amos de saber o perfil dos respondentes para entendermos at&eacute; que ponto o conjunto de pessoas que respondem reflete a popula&ccedil;&atilde;o do pa&iacute;s.</p>
                            <p>Voc&ecirc; &eacute; livre para se recusar a responder a qualquer pergunta, mas gostar&iacute;amos de conhecer o seu perfil.</p>
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <b>Idade</b>
                                    <div class="row form-group">
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_idade" id='txtApresentacao_idade_1'
                                                   name='txtApresentacao_idade'
                                                   placeholder=''
                                                   value='1'/>
                                            <label for="txtApresentacao_idade_1">de 15 a 30</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">

                                            <input type='radio' class="apresentacao_idade" id='txtApresentacao_idade_2'
                                                   name='txtApresentacao_idade'
                                                   placeholder=''
                                                   value='2'/>
                                            <label for="txtApresentacao_idade_2">de 31 a 50</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">

                                            <input type='radio' class="apresentacao_idade" id='txtApresentacao_idade_3'
                                                   name='txtApresentacao_idade'
                                                   placeholder=''
                                                   value='3'/>
                                            <label for="txtApresentacao_idade_3">mais de 50</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <b>G&ecirc;nero</b>
                                    <div class="row form-group">
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_genero" id='txtApresentacao_genero_1'
                                                   name='txtApresentacao_genero'
                                                   placeholder=''
                                                   value='1'/>
                                            <label for="txtApresentacao_genero_1">Feminino</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">

                                            <input type='radio' class="apresentacao_genero" id='txtApresentacao_genero_2'
                                                   name='txtApresentacao_genero'
                                                   placeholder=''
                                                   value='2'/>
                                            <label for="txtApresentacao_genero_2">Masculino</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <b>Escolaridade</b>
                                    <div class="row form-group">
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_1'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='1'/>
                                            <label for="txtApresentacao_escolaridade_1">não terminou o fundamental</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_2'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='2'/>
                                            <label for="txtApresentacao_escolaridade_2">terminou o fundamental</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_3'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='3'/>
                                            <label for="txtApresentacao_escolaridade_3">terminou o ensino médio</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_4'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='4'/>
                                            <label for="txtApresentacao_escolaridade_4">terminou ensino médico e formação técnica</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_5'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='5'/>
                                            <label for="txtApresentacao_escolaridade_5">terminou curso superior</label>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <input type='radio' class="apresentacao_escolaridade" id='txtApresentacao_escolaridade_6'
                                                   name='txtApresentacao_escolaridade'
                                                   placeholder=''
                                                   value='6'/>
                                            <label for="txtApresentacao_escolaridade_6">terminou pós-graduação</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12"><button id="cadastrarApresentacao" class="btn btn-primary btn-block cadastrarApresentacao w-100" name="cadastrarApresentacao" type="submit">Iniciar Avalia&ccedil;&atilde;o </button></div>
                        </div>
                </form>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
</div>
