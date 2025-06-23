<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarReceituario'])){
    if(isset($_POST['btnEditarReceituario']))
    {
        try {


            if(!isset($_POST['codReceituario']) || empty($_POST['codReceituario'])) throw new Exception("Receituário não encontrado");
            if(!isset($_POST['txtMotivoConsulta']) || empty($_POST['txtMotivoConsulta'])) throw new Exception("Preencha o motivo da consulta");

            $receituario = new Classe\Receituario();
            $receituario->setCodReceituario($_POST['codReceituario']);
            $receituario->carregar();

            if(empty($receituario->getMotivoConsulta())){
                $receituario->setMotivoConsulta($_POST['txtMotivoConsulta']);
                $receituario->salvar();
            }

            $prompt = new \Classe\Prompt();
            if(isset($_POST['codPrompt']) && !empty($_POST['codPrompt']))
            {
                $prompt->setCodPrompt($_POST['codPrompt']);
                $prompt->carregar();
            }else if(isset($_POST['prompt']) && !empty($_POST['prompt']))
            {
                $prompt->setImput($_POST['prompt']);
                $prompt->setPadrao(0);
                $prompt->incluir();
            }

            $estaPrescricao = new Classe\Prescricao();
            $saidaTextoPrescricao = $estaPrescricao->gerarTextoPrescricao($receituario->getCodReceituario());

            $cidadao = new \Classe\Cidadao();
            $sexo = new \Classe\Sexo();
            $escolaridade = new \Classe\Escolaridade();
            $cidadao->setCodCidadao($receituario->getCodCidadao());
            $cidadao->carregar();

            $sexo->setCodSexo($cidadao->getCodSexo());
            $sexo->carregar();

            $escolaridade->setCodEscolaridade($cidadao->getCodEscolaridade());
            $escolaridade->carregar();

            // = "Nome:".$cidadao->getNome()."<br>Sexo:".$sexo->getNome()."<br>Escolaridade:".$escolaridade->getEscolaridade();

            $texto = "";
            //$texto .= $cidadaoTexto;
            $texto .= "<br>Motivo da consulta:<br>" . $receituario->getMotivoConsulta() . "<br>";


            if ($saidaTextoPrescricao) {
                $aux2 = 1;
                $texto .= $saidaTextoPrescricao;


                $openaiClient = \Tectalic\OpenAi\Manager::build(
                    new \GuzzleHttp\Client(),
                    new \Tectalic\OpenAi\Authentication($GLOBALS['OPENAI'])
                );

                $response = $openaiClient->chatCompletions()->create(
                    new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest([
                        'temperature' => 0,
                        'model' => 'gpt-4-turbo',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => $prompt->getImput()
                            ], [
                                'role' => 'user',
                                'content' => $texto
                            ],
                        ],
                    ])
                )->toModel();

                if (!empty($response->choices[0]->message->content)) {
                    $receituario->setTextoEntrada($texto);
                    $receituario->setTextoSaida($response->choices[0]->message->content);
                    $receituario->setTextoSaidaModificado($response->choices[0]->message->content);
                    $receituario->setCodPrompt($prompt->getCodPrompt());

                    $arrayEntrada = array($receituario->getTextoSaida(),$receituario->getTextoSaidaModificado());

                    $responseSimilarity = $openaiClient->embeddings()->create(
                        new \Tectalic\OpenAi\Models\Embeddings\CreateRequest([
                            'input' => $arrayEntrada,
                            'model' => 'text-embedding-3-large'
                        ])
                    )->toModel();

                    //print_r($response);

                    // Supondo que $resp['data'] seja um array associativo pré-existente
                    $li = array();
                    foreach ($responseSimilarity->data as $ele) {
                        $li[] = $ele->embedding;
                    }

                    // Suponha que $arrayEntrada seja um array de strings e $response->data contém embeddings correspondentes
                    // Cálculo da porcentagem de similaridade entre textos
                    $similarityPercentage = 0;
                    for ($i = 0; $i < count($arrayEntrada) - 1; $i++) {
                        for ($j = $i + 1; $j < count($responseSimilarity->data); $j++) {
                            // O produto escalar pode ser computado se as embeddings são arrays numéricos
                            $dotProduct = 0;
                            for ($k = 0; $k < count($responseSimilarity->data[$i]->embedding); $k++) {
                                $dotProduct += $responseSimilarity->data[$i]->embedding[$k] * $responseSimilarity->data[$j]->embedding[$k];
                            }
                            $similarityPercentage = $dotProduct * 100;
                            echo "text similarity percentage between " . $i . " and " . $j . " is " . $similarityPercentage . "\n";
                        }
                    }

                    $receituario->setSimilaridade($similarityPercentage);

                    $receituario->salvar();
                }else{
                    throw new Exception("Tivemos um problema ao gerar o GPT");
                }
            }else{
                throw new Exception("Receituário sem prescrições. Cadastre pelo menos uma prescrição.");
            }


            $saida['saida'] = "<div class='alert alert-success alert-dismissable'>GPT gerado com sucesso</div>";
            $saida['textoGPT'] = $response->choices[0]->message->content;
            $saida['textoEntrada'] = $texto;
            $rest->response(json_encode($saida), 200);

        }catch (Exception $ex){
            $saida['saida'] = "<div class='alert alert-danger alert-dismissable'>".$ex->getMessage()."</div>";
            $rest->response(json_encode($saida),500);
        }
    }
}
else
{
    $saida = [];
    $saida['saida'] = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response(json_encode($saida),401);
}
?>
