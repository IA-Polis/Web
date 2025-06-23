<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");

try {
    $rest = new Config\REST();
    if (isset($_POST['codReceituarioV3'])) {
        if (isset($_POST['btnCadastrarPrescricao'])) {
            $newReceituarioV3 = new Classe\V3Receituario();
            $newReceituarioV3->setCodReceituarioV3($_POST['codReceituarioV3']);
            $newReceituarioV3->carregar();

            if (
                isset($_POST['cboViaAdministracao']) && !empty($_POST['cboViaAdministracao']) &&
                isset($_POST['cboUnidadeMedida']) && !empty($_POST['cboUnidadeMedida']) &&
                isset($_POST['cboMedicamento']) && !empty($_POST['cboMedicamento']) &&
                isset($_POST['txtQuantidadeDose']) && !empty($_POST['txtQuantidadeDose']) &&
                isset($_POST['txtQuantidadeSolicitada']) && !empty($_POST['txtQuantidadeSolicitada']) &&
                isset($_POST['txtInicioTratamento']) && !empty($_POST['txtInicioTratamento']) &&
                isset($_POST['txtPosologia']) && !empty($_POST['txtPosologia'])
            ) {
                try {
                    $texto = "";

                    $contexto = new \Classe\V3Contexto();
                    $contexto->setCodContexto($newReceituarioV3->getCodContexto());
                    $contexto->carregar();
                    $texto .= "Nome: ".$contexto->getCidadaoNome()."\n";
                    $texto .= "Sexo: ".$contexto->getCidadaoSexo()."\n";

                    $medicamento = new \Classe\Medicamento();
                    $medicamento->setCodMedicamento($_POST['cboMedicamento']);
                    $medicamento->carregar();

                    $formaFarmaceutica = new \Classe\FormaFarmaceutica();
                    $formaFarmaceutica->setCodFormaFarmaceutica($medicamento->getCodFormaFarmaceutica());
                    $formaFarmaceutica->carregar();

                    $viaAdmininistracao = new \Classe\ViaAdministracao();
                    $viaAdmininistracao->setCodViaAdministracao($_POST['cboViaAdministracao']);
                    $viaAdmininistracao->carregar();

                    $unidadeMedida = new \Classe\UnidadeMedida();
                    $unidadeMedida->setCodUnidadeMedida($_POST['cboUnidadeMedida']);
                    $unidadeMedida->carregar();

                    $usoContinuo = "";
                    if (empty($_POST['txtConclusaoTratamento'])) $usoContinuo = " uso contínuo ";

                    $texto .= "\nMedicamento:\n";
                    $texto .= $medicamento->getNoPrincipioAtivo() . " " . $medicamento->getConcentracao() . " " . $medicamento->getUnidadeFornecimento() . " " . $formaFarmaceutica->getFormaFarmaceutica() . " " . $usoContinuo . "\n";

                    if ($_POST['txtQuantidadeSolicitada'] > 1) {
                        $texto .= $_POST['txtQuantidadeSolicitada'] . " " . $unidadeMedida->getUnidadeMedidaPlural() . "\n";
                    } else {
                        $texto .= $_POST['txtQuantidadeSolicitada'] . " " . $unidadeMedida->getUnidadeMedidaPlural() . "\n";
                    }

                    $texto .= "\nVia de administração: " . $viaAdmininistracao->getViaAdministracao();
                    $texto .= "\nPosologia:\n" . $_POST['txtPosologia'] . "\n";

                    $newReceituarioV3->setTextoEntrada($texto);
                    $newReceituarioV3->setRecomendacoes($_POST['txtRecomendacoes']);
                    $newReceituarioV3->setCodMedicamento($_POST['cboMedicamento']);
                    $newReceituarioV3->setCodViaAdministracao($_POST['cboViaAdministracao']);
                    $newReceituarioV3->setCodUnidadeMedida($_POST['cboUnidadeMedida']);
                    $newReceituarioV3->setPosologia($_POST['txtPosologia']);
                    $newReceituarioV3->setInicioTratamento($_POST['txtInicioTratamento']);

                    $prompt = new \Classe\Prompt();
                    $prompt->setCodPrompt($newReceituarioV3->getCodPrompt());
                    $prompt->carregar();

                    $error = false;
                    $textoException = "";
                    $tentativa = 0;
                    do {
                        try {
                            if ($prompt->getTipo() == "OpenAi") {
                                $newReceituarioV3->setTextoSaida(\Config\OpenAI::completions($prompt->getImput(), $texto));
                            } else if ($prompt->getTipo() == "Llama") {
                                $newReceituarioV3->setTextoSaida(saidaEspecialLLhama($texto,\Config\DeepInfra::completionES($prompt->getImput(), $texto)));
                            } else if ($prompt->getTipo() == "Llama RAG") {
                                $contextoMedicamento = new \Classe\V3ContextoMedicamento();
                                $contextoMedicamento->setCodContexto($newReceituarioV3->getCodContexto());
                                $contextoMedicamento->setCodMedicamento($_POST['cboMedicamento']);
                                $contextoMedicamento->setCodViaAdministracao($_POST['cboViaAdministracao']);
                                $contextoMedicamento->carregar();
                                $newReceituarioV3->setTextoSaida(saidaEspecialLLhama($texto,\Config\DeepInfra::completionESR($prompt->getImput(), $texto, $contextoMedicamento->getTextoRagSumarizado())));
                            }
                            $error = false;
                        } catch (Exception $e) {
                            sleep(1);
                            $newReceituarioV3->setTextoSaida("");
                            $textoException = $e->getMessage();
                            $error = true;
                            $tentativa++;
                        }
                    } while ($error && $tentativa < 3);

                    if ($error) {
                        throw new Exception("Erro temporário por indisponibilidade do software de inteligência artificial.<br><br><b>Tente mais tarde</b> ou envie mensagem para iapolis@medicina.ufmg.br ou Whatsapp <a href='https://wa.me/553134099928'>https://wa.me/553134099928</a>.<br>".$textoException);
                    }

                    if(!empty($newReceituarioV3->getTextoSaida())) $newReceituarioV3->salvar();
                    else throw new Exception("Erro temporário por indisponibilidade do software de inteligência artificial.<br><br><b>Tente mais tarde</b> ou envie mensagem para iapolis@medicina.ufmg.br ou Whatsapp <a href='https://wa.me/553134099928'>https://wa.me/553134099928</a>.");

                    $saida = "<div class='alert alert-success alert-dismissable'>Prescrição armazenada com sucesso!</div>";

                    $rest->response($saida, 200);
                } catch (Exception $exception) {
                    $saida = "<div class='alert alert-danger alert-dismissable'>" . $exception->getMessage() . "</div>";

                    $stringComQuebraDeLinha = strip_tags(html_entity_decode(str_replace('<br>', "<br>", $exception->getMessage())));
                    Config\Pushover::enviaPush("Etapa Prescrição\n\nUsuário com receituário ".$newReceituarioV3->getCodReceituarioV3()." não conseguiu avançar pelo erro: \n\n".$stringComQuebraDeLinha,"Problemas na rodada externa IAPOLIS");
                    $rest->response($saida, 500);
                }
            } else {
                $saida = '';
                if (!isset($_POST['cboViaAdministracao']) || empty($_POST['cboViaAdministracao'])) $saida .= '<br>Via de Administração';
                if (!isset($_POST['cboUnidadeMedida']) || empty($_POST['cboUnidadeMedida'])) $saida .= '<br>Unidade de Medida';
                if (!isset($_POST['cboMedicamento']) || empty($_POST['cboMedicamento'])) $saida .= '<br>Medicamento';
                if (!isset($_POST['txtQuantidadeDose']) || empty($_POST['txtQuantidadeDose'])) $saida .= '<br>Quantidade da Dose';
                if (!isset($_POST['txtQuantidadeSolicitada']) || empty($_POST['txtQuantidadeSolicitada'])) $saida .= '<br>Quantidade Solicitada';
                if (!isset($_POST['txtInicioTratamento']) || empty($_POST['txtInicioTratamento'])) $saida .= '<br>Inicio do Tratamento';
                if (!isset($_POST['txtPosologia']) || empty($_POST['txtPosologia'])) $saida .= '<br>Posologia';
                $saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: " . $saida . "</div>";
                $rest->response($saida, 400);
            }
        }
    } else {
        $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
        $rest->response($saida, 401);
    }


} catch (Exception $exception) {
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Clique novamente para gerar ou entre em contato por e-mail: iapolis@medicina.ufmg.br</p></div>";
    $rest->response(json_encode($saida), 401);
}

function saidaEspecialLLhama($textoEntrada,$textoSaida){


    //COLOCANDO SUGESTAO DE HORARIO
    $sugestaoHorario = new \Classe\SugestaoHorario();
    $sugestaoHorario->buscarPeloNome($textoEntrada);
    if($sugestaoHorario->getCodSugestaoHorario()){
        $textoSaida .= "\n".$sugestaoHorario->getRetorno();
    }

    //COLOCANDO INTERAÇÃO PREJUDICIAL
    $medicamentoInteracao = new \Classe\MedicamentoInteracaoPrejudicial();
    $colInteracaoPrejudicial = new \Config\phpCollection();
    $colInteracaoPrejudicial = $medicamentoInteracao->carregarTodosCriterio('codMedicamento', $_POST['cboMedicamento']);
    $textoInteracaoPrejudicial = "";

    if ($colInteracaoPrejudicial->length) {
        do {
            $interacao = new \Classe\InteracaoPrejudicial();
            $interacao->setCodInteracaoPrejudicial($colInteracaoPrejudicial->current()->getCodInteracaoPrejudicial());
            $interacao->carregar();

            $textoInteracaoPrejudicial .=  $interacao->getTextoSubstituicao();
        } while ($colInteracaoPrejudicial->has_next());
    }

    if(!empty($textoInteracaoPrejudicial))$textoSaida .= "\n".$textoInteracaoPrejudicial;

    return $textoSaida;
}

?>
