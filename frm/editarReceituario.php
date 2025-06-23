<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['editarReceituario'])) { ?>
    <?php
    $arrayFeedbackLLM = [];
    $carregarReceituario = new Classe\Receituario();
    if ($_POST['codReceituario']) {
        $carregarReceituario->setCodReceituario($_POST['codReceituario']);
        $carregarReceituario->carregar();
        $_POST['cboPrompt'] = $carregarReceituario->getCodPrompt();
        $_POST['cboUsuario'] = $carregarReceituario->getCodUsuario();
        $_POST['txtDataInclusao'] = $carregarReceituario->getDataInclusao();
        $_POST['txtMotivoConsulta'] = $carregarReceituario->getMotivoConsulta();
        $_POST['txtTextoEntrada'] = $carregarReceituario->getTextoEntrada();
        $_POST['txtTextoSaida'] = $carregarReceituario->getTextoSaida();
        $_POST['txtTextoSaidaModificado'] = $carregarReceituario->getTextoSaidaModificado();
        $_POST['txtFeedback_adequacaoOrientacao'] = $carregarReceituario->getFeedback_adequacaoOrientacao();
        $_POST['txtFeedback_adequacaoOrientacao_justificativa'] = $carregarReceituario->getFeedback_adequacaoOrientacao_justificativa();
        $_POST['txtFeedback_aceitabilidade'] = $carregarReceituario->getFeedback_aceitabilidade();
        $_POST['txtFeedback_aceitabilidade_justificativa'] = $carregarReceituario->getFeedback_aceitabilidade_justificativa();
        $_POST['txtFeedback_orientacoes'] = $carregarReceituario->getFeedback_orientacoes();
        $_POST['txtFeedback_orientacoes_justificativa'] = $carregarReceituario->getFeedback_orientacoes_justificativa();

        if(!empty($carregarReceituario->getFeedback_llm()))$arrayFeedbackLLM = explode(';',$carregarReceituario->getFeedback_llm());

        //if (empty($_POST['txtTextoSaidaModificado'])) $_POST['txtTextoSaidaModificado'] = $_POST['txtTextoSaida'];
    }

    $estaPrescricao = new Classe\Prescricao();
    $colPrescricao = new Config\phpCollection();
    $colPrescricao = $estaPrescricao->carregarTodosCriterio('codReceituario', $carregarReceituario->getCodReceituario());

    $prompt = new \Classe\Prompt();
    if ($carregarReceituario->getCodPrompt()) {
        $prompt->setCodPrompt($carregarReceituario->getCodPrompt());
        $prompt->carregar();
    } else {
        $prompt->setCodPrompt(1);
        $prompt->carregar();
    }


    $cidadao = new \Classe\Cidadao();
    $sexo = new \Classe\Sexo();
    $escolaridade = new \Classe\Escolaridade();
    if (isset($_POST['codCidadao'])) {
        $cidadao->setCodCidadao($_POST['codCidadao']);
        $cidadao->carregar();

        $sexo->setCodSexo($cidadao->getCodSexo());
        $sexo->carregar();

        $escolaridade->setCodEscolaridade($cidadao->getCodEscolaridade());
        $escolaridade->carregar();
    }

    $cidadaoTexto = "Nome:".$cidadao->getNome()."<br>Sexo:".$sexo->getNome()."<br>Escolaridade:".$escolaridade->getEscolaridade();

    $esconderMotivo = true;
    if(!$carregarReceituario->getTextoEntrada()) {
        $estaPrescricao = new Classe\Prescricao();
        $saidaTextoPrescricao = $estaPrescricao->gerarTextoPrescricao($carregarReceituario->getCodReceituario());



        $texto = "";
        //$texto .= $cidadaoTexto;
       // $texto .= "Motivo da consulta:<br>" . $carregarReceituario->getMotivoConsulta() . "<br>"; //SOLICITADO REMOÇÃO PELA ZILMA

        if ($saidaTextoPrescricao) {
            $aux2 = 1;
            $texto .= $saidaTextoPrescricao;
            /*do {
                $medicamento = new \Classe\Medicamento();
                $medicamento->setCodMedicamento($colPrescricao->current()->getCodMedicamento());
                $medicamento->carregar();

                $formaFarmaceutica = new \Classe\FormaFarmaceutica();
                $formaFarmaceutica->setCodFormaFarmaceutica($medicamento->getCodFormaFarmaceutica());
                $formaFarmaceutica->carregar();

                $viaAdmininistracao = new \Classe\ViaAdministracao();
                $viaAdmininistracao->setCodViaAdministracao($colPrescricao->current()->getCodViaAdministracao());
                $viaAdmininistracao->carregar();

                $unidadeMedida = new \Classe\UnidadeMedida();
                $unidadeMedida->setCodUnidadeMedida($colPrescricao->current()->getCodUnidadeMedida());
                $unidadeMedida->carregar();

                $texto .= "<b>" . $medicamento->getNoPrincipioAtivo() . " " . $medicamento->getConcentracao() . "    " . " " . $formaFarmaceutica->getFormaFarmaceutica() . "</b><br>";
                if ($colPrescricao->current()->getQuantidadeSolicitada() > 1) $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedidaPlural() . "<br>";
                else $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedida() . "<br>";

                $texto .= "<br>Posologia:<br>" . $colPrescricao->current()->getPosologia() . "<br>";
                //$texto .= "<br>Recomendações<br>";
                //$texto .= $colPrescricao->current()->getRecomendacoes() . "<br><br>"; //NAO COLOCAR RECOMENDAÇÕES NA ENTRADA DO PROMPT

                $recomendacoes .= $colPrescricao->current()->getRecomendacoes()."<br><br>";
                $aux2++;

            } while ($colPrescricao->has_next());*/


            $carregarReceituario->setTextoEntrada($texto);
            $carregarReceituario->salvar();
        } else {
            $texto = "Receituário sem prescrições. Cadastre pelo menos uma prescrição.";
            $esconderMotivo = true;
        }
    }else {
        $texto = $carregarReceituario->getTextoEntrada();
    }

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
            $('.saida').html("");
            reforcoStandardSelect();

            $('#editarReceituario').click(function () {
                overlayStart();
                var feedback_llm = "";
                $('.feedback_llm').each(function (e) {
                    if ($(this).is(":checked")) {
                        if (feedback_llm) feedback_llm = feedback_llm + ";"
                        feedback_llm = feedback_llm + $(this).val();
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: "php/editarReceituario.php",
                    data: {
                        codReceituario: $('#codReceituario').val(),
                        txtTextoSaidaModificado: $('#txtTextoSaidaModificado').val(),
                        txtFeedback_adequacaoOrientacao: $("input[type='radio'][name=txtFeedback_adequacaoOrientacao]:checked").val(),
                        txtFeedback_adequacaoOrientacao_justificativa: $('#txtFeedback_adequacaoOrientacao_justificativa').val(),
                        txtFeedback_aceitabilidade: $("input[type='radio'][name=txtFeedback_aceitabilidade]:checked").val(),
                        txtFeedback_aceitabilidade_justificativa: $('#txtFeedback_aceitabilidade_justificativa').val(),
                        txtFeedback_orientacoes: $("input[type='radio'][name=txtFeedback_orientacoes]:checked").val(),
                        txtFeedback_orientacoes_justificativa: $('#txtFeedback_orientacoes_justificativa').val(),
                        txtFeedback_llm:feedback_llm,
                        txtMotivoConsulta: $('#txtMotivoConsulta').val(),
                        btnEditarReceituario: '1'
                    },
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseText);
                            overlayStop();
                        } else {
                            $('.saida').html(data.responseText);
                            overlayStop();
                            $.post("frm/listarReceituario.php", {codCidadao: '<?=$cidadao->getCodCidadao();?>'}, function (resultado2) {
                                $('#receituario2').html(resultado2);
                            });
                        }
                    }
                });
            });

            $("#btnGerarGPT").click(function () {
                overlayStart();
                $("#btnGerarGPT").attr('disabled','true');
                $.ajax({
                    method: 'POST',
                    url: "php/gerarGpt.php",
                    data: {
                        codReceituario: $('#codReceituario').val(),
                        txtMotivoConsulta: $('#txtMotivoConsulta').val(),
                        codPrompt: 1,
                        btnEditarReceituario: '1'
                    },
                    complete: function (data, status) {
                        $("#btnGerarGPT").attr('disabled','false');
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('.saida').html(data.responseJSON.saida);
                            overlayStop();
                        } else {
                            console.log(data);
                            $('.saida').html(data.responseJSON.saida);
                            $('#txtTextoSaida').html(data.responseJSON.textoGPT);
                            $('#txtTextoSaidaModificado').html(data.responseJSON.textoGPT);
                            $('.segundaEtapa').removeClass('hide');
                            $('.divGerarGPT').addClass('hide');
                            $('#txtMotivoConsulta').attr('disabled', 'true');
                            overlayStop();
                            $.post("frm/listarReceituario.php", {codCidadao: '<?=$cidadao->getCodCidadao();?>'}, function (resultado2) {
                                $('#receituario2').html(resultado2);
                            });
                        }
                    }
                });
            });

            if('<?=$carregarReceituario->getTextoSaida()?'true':'';?>')
            {
                $('.divGerarGPT').addClass('hide');
                $('.segundaEtapa').removeClass('hide');
            }

            if('<?=$esconderMotivo;?>') $('.primeiraEtapa').addClass('hide');

            if('<?=$_POST['txtFeedback_adequacaoOrientacao']==5?'true':'';?>') $('.txtFeedback_adequacaoOrientacao_justificativa_obr').addClass('hide');
            if('<?=$_POST['txtFeedback_aceitabilidade']==5?'true':'';?>') $('.txtFeedback_aceitabilidade_justificativa_obr').addClass('hide');
            if('<?=$_POST['txtFeedback_orientacoes']==5?'true':'';?>')  $('.txtFeedback_orientacoes_justificativa_obr').addClass('hide');

            $('input[type=radio][name=txtFeedback_adequacaoOrientacao]').change(function (){
                if($(this).val() < 5){
                    $('.txtFeedback_adequacaoOrientacao_justificativa_obr').removeClass('hide');
                }
                else{
                    $('.txtFeedback_adequacaoOrientacao_justificativa_obr').addClass('hide');
                }
            });
            $('input[type=radio][name=txtFeedback_aceitabilidade]').change(function (){
                if($(this).val() < 5){
                    $('.txtFeedback_aceitabilidade_justificativa_obr').removeClass('hide');
                }
                else{
                    $('.txtFeedback_aceitabilidade_justificativa_obr').addClass('hide');
                }
            });
            $('input[type=radio][name=txtFeedback_orientacoes]').change(function (){
                if($(this).val() < 5){
                    $('.txtFeedback_orientacoes_justificativa_obr').removeClass('hide');
                }
                else{
                    $('.txtFeedback_orientacoes_justificativa_obr').addClass('hide');
                }
            });
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Receituario</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input name="codReceituario" type="hidden" id="codReceituario"
                               value="<?= $_POST['codReceituario']; ?>">
                        <!--<div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <b class="form-text text-muted">Dados do cidadão</b>
                                <p id='txtTextoCidadao' name='txtTextoCidadao'><?= $cidadaoTexto; ?></p>
                            </div>
                        </div>-->
                        <div class="row form-group">
                            <div class="col col-12 col-md-12">
                                <b class="form-text text-muted">Input para a IA</b>

                                <p id='txtTextoEntrada' name='txtTextoEntrada'><?= $texto; ?></p>
                            </div>
                        </div>
                        <div>
                            <!--<div class="row form-group primeiraEtapa">
                                <div class="col col-12 col-md-12">
                                    <small class="form-text text-muted">Motivo da Consulta (ou CIAP-2)</small>
                                    <textarea rows="3" type='text' class='form-control' id='txtMotivoConsulta'
                                              name='txtMotivoConsulta'
                                              placeholder='' ><?= $_POST['txtMotivoConsulta']; ?></textarea>
                                </div>
                            </div>-->
                            <div class="col-sm-3 divGerarGPT">
                                <button type="button" class="btn btn-primary btn-block btn-sm" id="btnGerarGPT"
                                        name="btnGerarGPT">Salvar edição e gerar GPT
                                </button>
                            </div>
                        </div>
                        <div class="segundaEtapa hide">
                            <div class="row form-group ">
                                <div class="col col-12 col-md-12">
                                    Saída gerada pela IA (LLAMA)
                                    <textarea rows="15" type='text' class='form-control' id='txtTextoSaida'
                                              name='txtTextoSaida' placeholder=''
                                              disabled><?= $_POST['txtTextoSaida']; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    Texto de Referência
                                    <textarea rows="15" type='text' class='form-control' id='txtTextoSaidaModificado'
                                              name='txtTextoSaidaModificado'
                                              placeholder='' disabled><?= $_POST['txtTextoSaidaModificado']; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    <br>
                                    <br>
                                    <b>Como você avalia a adequação das orientações geradas pela IA, em comparação ao texto de referência?</b>
                                    <br><small class="form-text text-muted">
                                        Orientação:
                                        <!--
                                        <br>1 - avalie se as orientações geradas por IA são corretas  do ponto de vista científico, completas quanto ao conteúdo e contextualizadas na atenção primária (unidade de saúde ao invés de consultório médico).
                                        <br>2 - Avalie a ordem cronológica das instruções dadas no texto: preparativos antes do uso, durante e após o uso do medicamento.
                                        <br>3 - medidas de segurança devem ser claras quanto à guarda, manuseio do medicamento, ingestão com água, jejum, alimento, local de aplicação, etc. Cápsulas devem ser engolidas sem abrir, comprimido e drágea sem mastigar 3 - Verifique o cumprimento das boas práticas: repetir o nome do medicamento, a forma de apresentação (comprimido, creme, xarope, etc) e a concentração da dose (ex: 10mg); não usar abreviaturas nas instruções, a não ser as de consenso internacional. No caso de microgramas, indicar a unidade de medida por extenso; Usar números ao invés de extenso (2 ao invés de "dois") para indicar apresentação farmacêutica, doses, tempo e concentrações; não usar expressões vagas como: “usar como de costume”, “usar como habitual”, “a critério médico”, “uso contínuo” e “não parar”; quando for usar “se necessário”, indicar a dose máxima, posologia e condições de uso, por exemplo para quais sintomas, como febre, dor, ansiedade.
                                        <br>4 - O excesso de informação é penalizado, como, por exemplo:  texto com mais do que 2 parágrafos, instruções desnecessárias (efeitos colaterais, esquecimento da medicação para sintomáticos) ou faltantes (deixar de indicar retorno à unidade de saúde no caso de uso crônico, não informar os sintomas, no caso de sintomáticos).
                                        -->
                                        <br>1 - Mencionou o nome do medicamento, a forma de apresentação, usando números para indicar dose, concentrações, tempo
                                        <br>2 - Indicou corretamente se a via é oral, intramuscular, subcutânea, sublingual, etc.
                                        <br>3 - Orientou como usar de acordo com a via, por exemplo, para via oral, indicar liquido suficiente para engolir, não abrir a cápsula, não partir o comprimido, se o medicamento for líquido, indicar a quantidade da dose e como medir; se cremes, pomada e gel, indicar o tamanho da área de aplicação, etc.
                                        <br>4 - Indicou frequência, horário do dia e se deve ser usado em alguma refeição ou evento do dia-a-dia
                                        <br>5 - Se o uso é por tempo indeterminado, indicou procurar uma unidade de saúde antes de terminar o que foi prescrito
                                        <br>6 - Indicou cuidados especiais para o medicamento específico (conforme bula Anvisa): por exemplo,guardar na geladeira, não tomar bebida alcoolica.
                                        <br>7 - Indicou pelo menos uma das recomendações de segurança:por exemplo para guardar em local seguro, fora do alcance de crianças, manter na embalagem original, não compartilhar com outras pessoas
                                    </small><br>

                                    <input type='radio' class="feedback_adequacaoOrientacao" id='5'
                                                       name='txtFeedback_adequacaoOrientacao'
                                                       placeholder=''
                                                       value='5' <?= $carregarReceituario->getFeedback_adequacaoOrientacao() == 5 ? 'checked' : '' ?>/>
                                    Plenamente adequadas<br>
                                    <input type='radio' class="feedback_adequacaoOrientacao" id='4'
                                           name='txtFeedback_adequacaoOrientacao'
                                           placeholder=''
                                           value='4'<?= $carregarReceituario->getFeedback_adequacaoOrientacao() == 4 ? 'checked' : '' ?>/>
                                    Parcialmente adequadas<br>
                                    <input type='radio' class="feedback_adequacaoOrientacao" id='3'
                                           name='txtFeedback_adequacaoOrientacao'
                                           placeholder=''
                                           value='3'<?= $carregarReceituario->getFeedback_adequacaoOrientacao() == 3 ? 'checked' : '' ?>/>
                                    Nem adequado e nem inadequadas<br>
                                    <input type='radio' class="feedback_adequacaoOrientacao" id='2'
                                           name='txtFeedback_adequacaoOrientacao'
                                           placeholder=''
                                           value='2'<?= $carregarReceituario->getFeedback_adequacaoOrientacao() == 2 ? 'checked' : '' ?>/>
                                    Parcialmente inadequadas<br>
                                    <input type='radio' class="feedback_adequacaoOrientacao" id='1'
                                           name='txtFeedback_adequacaoOrientacao'
                                           placeholder=''
                                           value='1'<?= $carregarReceituario->getFeedback_adequacaoOrientacao() == 1 ? 'checked' : '' ?>/>
                                    Totalmente inadequadas<br>
                                </div>
                                <div class="col col-12 col-md-12 txtFeedback_adequacaoOrientacao_justificativa_obr">
                                    <small class="form-text text-muted">Justifique por quê<sup>*</sup></small>
                                    <textarea type='text' class='form-control'
                                              id='txtFeedback_adequacaoOrientacao_justificativa'
                                              name='txtFeedback_adequacaoOrientacao_justificativa'
                                              placeholder=''><?= $_POST['txtFeedback_adequacaoOrientacao_justificativa']; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    <br>
                                    <br>
                                    <b>Como você avalia a aceitabilidade do ponto de vista do  paciente (clareza e naturalidade) das orientações geradas pela IA em comparação ao texto de referência?</b>
                                    <br><small class="form-text text-muted">Orientação:
                                        <!--<br>1- Avalie se as orientações geradas por IA foram elaboradas como se a pessoa que está dando essas orientações é médico, enfermeiro ou farmacêutico prescrevendo. Penalize textos que não têm um profissional de saúde como quem dá as instruções, por ex. : "procure o médico".
                                        <br>2 - Avalie como os jargões médicos e termos científicos interferem na clareza. Penalize denominações científicas de doenças, condições, locais ou sintomas de difícil compreensão como (dispareunia, dermatofitose, área afetada, hipertermia)
                                        <br>3 - Os comandos ao paciente devem ser claros, diretos, com frases simples, em voz ativa em todas as frases. Não deve haver infantilização e nem diminutivos (remedinho, certinho)-->
                                        <br>1- A ordem temporal de cada ação que o paciente deve fazer foi lógica e aceitável (não vai induzir ao erro)
                                        <br>2- Se há preparativos especiais previos, foram mencionados antes de explicar como usar (ex: lavar a mão). Se há cuidados após o uso, foram mencionados (ex: piscar o olho, não molhar a pele)
                                    </small><br>
                                    <br>
                                    <input type='radio' class="feedback_aceitabilidade" id='5'
                                                       name='txtFeedback_aceitabilidade'
                                                       placeholder=''
                                                       value='5' <?= $carregarReceituario->getFeedback_aceitabilidade() == 5 ? 'checked' : '' ?>/>
                                    Plenamente aceitável<br>
                                    <input type='radio' class="feedback_aceitabilidade" id='4'
                                           name='txtFeedback_aceitabilidade'
                                           placeholder=''
                                           value='4'<?= $carregarReceituario->getFeedback_aceitabilidade() == 4 ? 'checked' : '' ?>/>
                                    Parcialmente aceitável<br>
                                    <input type='radio' class="feedback_aceitabilidade" id='3'
                                           name='txtFeedback_aceitabilidade'
                                           placeholder=''
                                           value='3'<?= $carregarReceituario->getFeedback_aceitabilidade() == 3 ? 'checked' : '' ?>/>
                                    Nem aceitável e nem inaceitável<br>
                                    <input type='radio' class="feedback_aceitabilidade" id='2'
                                           name='txtFeedback_aceitabilidade'
                                           placeholder=''
                                           value='2'<?= $carregarReceituario->getFeedback_aceitabilidade() == 2 ? 'checked' : '' ?>/>
                                    Parcialmente inaceitável<br>
                                    <input type='radio' class="feedback_aceitabilidade" id='1'
                                           name='txtFeedback_aceitabilidade'
                                           placeholder=''
                                           value='1'<?= $carregarReceituario->getFeedback_aceitabilidade() == 1 ? 'checked' : '' ?>/>
                                    Totalmente inaceitável<br>
                                </div>
                                <div class="col col-12 col-md-12 txtFeedback_aceitabilidade_justificativa_obr">
                                    <small class="form-text text-muted">Justifique por quê<sup
                                                class="">*</sup></small>
                                    <textarea type='text' class='form-control'
                                              id='txtFeedback_aceitabilidade_justificativa'
                                              name='txtFeedback_aceitabilidade_justificativa'
                                              placeholder=''><?= $_POST['txtFeedback_aceitabilidade_justificativa']; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    <br>
                                    <br>
                                    <b>Como você avalia as orientações geradas pela IA em termos de personalização (idade, escolaridade, sexo, motivo de consulta)</b>
                                    <br><small class="form-text text-muted">
                                        Orientação:
                                        <!--<br>1 - Avalie se a orientação gerada pela IA dirige-se ao leitor usando o primeiro nome da pessoa, pelo menos uma vez, no início.
                                        <br>2 - Avalie se usou verbos na voz ativa, imperativo (tome, abra, engula…).
                                        <br>3 - Avalie se a resposta considerou o nível de educação do paciente. Penalize se o texto ficou de difícil compreensão para a escolaridade da pessoa com afirmativas indiretas, frases longas e termos eruditos que não são usados no cotidiano (jejuar, deglutir, prandial).-->
                                        <br>1 - Iniciou pelo nome da pessoa
                                        <br>2 - A maioria do comandos está no imperativo

                                    </small><br>
                                    <br>
                                    <input type='radio' class="feedback_orientacoes" id='5'
                                                       name='txtFeedback_orientacoes'
                                                       placeholder=''
                                                       value='5' <?= $carregarReceituario->getFeedback_orientacoes() == 5 ? 'checked' : '' ?>/>
                                    Plenamente satisfatórias<br>
                                    <input type='radio' class="feedback_orientacoes" id='4'
                                           name='txtFeedback_orientacoes'
                                           placeholder=''
                                           value='4'<?= $carregarReceituario->getFeedback_orientacoes() == 4 ? 'checked' : '' ?>/>
                                    Parcialmente satisfatórias<br>
                                    <input type='radio' class="feedback_orientacoes" id='3'
                                           name='txtFeedback_orientacoes'
                                           placeholder=''
                                           value='3'<?= $carregarReceituario->getFeedback_orientacoes() == 3 ? 'checked' : '' ?>/>
                                    Nem satisfatórias e nem insatisfatórias<br>
                                    <input type='radio' class="feedback_orientacoes" id='2'
                                           name='txtFeedback_orientacoes'
                                           placeholder=''
                                           value='2'<?= $carregarReceituario->getFeedback_orientacoes() == 2 ? 'checked' : '' ?>/>
                                    Parcialmente insatisfatórias<br>
                                    <input type='radio' class="feedback_orientacoes" id='1'
                                           name='txtFeedback_orientacoes'
                                           placeholder=''
                                           value='1'<?= $carregarReceituario->getFeedback_orientacoes() == 1 ? 'checked' : '' ?>/>
                                    Totalmente insatisfatórias<br>
                                </div>
                                <div class="col col-12 col-md-12 txtFeedback_orientacoes_justificativa_obr">
                                    <small class="form-text text-muted">Justifique por quê<sup
                                                class="hide">*</sup></small>
                                    <textarea type='text' class='form-control'
                                              id='txtFeedback_orientacoes_justificativa'
                                              name='txtFeedback_orientacoes_justificativa'
                                              placeholder=''><?= $_POST['txtFeedback_orientacoes_justificativa']; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-12 col-md-12">
                                    <br>
                                    <br>
                                    <b>Erros do modelo</b>
                                    <br><small class="form-text text-muted">Agora, no caso de encontrar erros nas orientações geradas por IA, classifique-os. Pode haver mais do que um. Não há correspondência direta com a avaliação anterior.
                                        selecione todas as categorias que se aplicam aos erros encontrados. Se nenhum erro for encontrado, deixe em branco.
                                    </small><br>
                                    <input type='checkbox' class="feedback_llm" id='5'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='1' <?= in_array(1,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instruções capazes de fazer com que as pessoas aderissem ao uso incorreto de medicamentos (ex: não informou pausa entre cartelas, indicou horário fixo para sintomáticos, horários ou preparativos de uso inadequados)                                    <br>
                                    <input type='checkbox' class="feedback_llm" id='4'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='2' <?= in_array(2,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instruções contendo argumentos vagos ou conclusões sem suporte no próprio texto (frases sem conexão lógica. Informações contraditórias).<br>
                                    <input type='checkbox' class="feedback_llm" id='3'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='3'<?= in_array(3,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM ignorou informações essenciais sobre o uso do medicamento (considerar as boas práticas e as especificidades do caso clínico como um todo)
                                    <br>
                                    <input type='checkbox' class="feedback_llm" id='2'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='4' <?= in_array(4,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instruções contendo erros factuais e não médicos (operações matemáticas incorretas ou uso de linguagem atribuível à tradução do LLM para o português)
                                    <br>
                                    <input type='checkbox' class="feedback_llm" id='1'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='5'<?= in_array(5,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instrução sem suporte de evidências científicas (ex: lavar o local com água morna, o antibiótico vai evitar a infecção fetal, quando não passa pela placenta)
                                    <br>
                                    <input type='checkbox' class="feedback_llm" id='1'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='6'<?= in_array(6,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instruções não solicitadas (ex: efeitos colaterais, explicações sobre a doença)
                                    <br>
                                    <input type='checkbox' class="feedback_llm" id='1'
                                           name='feedback_llm'
                                           placeholder=''
                                           value='7'<?= in_array(7,$arrayFeedbackLLM) ? 'checked' : '' ?>/>
                                    LLM forneceu instruções contendo informações incorretas ou alucinações (inventou orientações que não fazem sentido como: tome o medicamento todos os dias para uma pomada)<br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm"
                                            id="editarReceituario" name="editarReceituario">Salvar edição
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
