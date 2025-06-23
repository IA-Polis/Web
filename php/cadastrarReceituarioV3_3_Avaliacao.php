<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_POST['codReceituarioV3'])){
    //print_r($_POST);
    if(isset($_POST['btnEditarReceituario']))
    {
        $newReceituario = new Classe\V3Receituario();
        $newReceituario->setCodReceituarioV3($_POST['codReceituarioV3']);
        $newReceituario->carregar();

        if(isset($_POST['txtFeedback_confianca']) && !empty($_POST['txtFeedback_confianca'])) $newReceituario->setFeedback_confianca($_POST['txtFeedback_confianca']);
        else  $newReceituario->setFeedback_confianca(0);

        if(isset($_POST['txtFeedback_sus_correto']) && !empty($_POST['txtFeedback_sus_correto'])) $newReceituario->setFeedback_sus_correto($_POST['txtFeedback_sus_correto']);
        if(isset($_POST['txtFeedback_sus_incorreto']) && !empty($_POST['txtFeedback_sus_incorreto'])) $newReceituario->setFeedback_sus_incorreto($_POST['txtFeedback_sus_incorreto']);
        if(isset($_POST['txtFeedback_sus_relevante']) && !empty($_POST['txtFeedback_sus_relevante'])) $newReceituario->setFeedback_sus_relevante($_POST['txtFeedback_sus_relevante']);
        if(isset($_POST['txtFeedback_sus_irrelevante']) && !empty($_POST['txtFeedback_sus_irrelevante'])) $newReceituario->setFeedback_sus_irrelevante($_POST['txtFeedback_sus_irrelevante']);
        if(isset($_POST['txtFeedback_sus_clara']) && !empty($_POST['txtFeedback_sus_clara'])) $newReceituario->setFeedback_sus_clara($_POST['txtFeedback_sus_clara']);
        if(isset($_POST['txtFeedback_sus_naoclara']) && !empty($_POST['txtFeedback_sus_naoclara'])) $newReceituario->setFeedback_sus_naoclara($_POST['txtFeedback_sus_naoclara']);
        if(isset($_POST['txtFeedback_sus_compreensivel']) && !empty($_POST['txtFeedback_sus_compreensivel'])) $newReceituario->setFeedback_sus_compreensivel($_POST['txtFeedback_sus_compreensivel']);
        if(isset($_POST['txtFeedback_sus_incompreensivel']) && !empty($_POST['txtFeedback_sus_incompreensivel'])) $newReceituario->setFeedback_sus_incompreensivel($_POST['txtFeedback_sus_incompreensivel']);
        if(isset($_POST['txtFeedback_sus_util']) && !empty($_POST['txtFeedback_sus_util'])) $newReceituario->setFeedback_sus_util($_POST['txtFeedback_sus_util']);
        if(isset($_POST['txtFeedback_sus_inutil']) && !empty($_POST['txtFeedback_sus_inutil'])) $newReceituario->setFeedback_sus_inutil($_POST['txtFeedback_sus_inutil']);

        if(isset($_POST['txtFeedback_textoLivre']) && !empty($_POST['txtFeedback_textoLivre'])) $newReceituario->setFeedback_textoLivre($_POST['txtFeedback_textoLivre']);
        else  $newReceituario->setFeedback_textoLivre(0);
        if(isset($_POST['txtFeedback_errosLlm']) && !empty($_POST['txtFeedback_errosLlm'])) $newReceituario->setFeedback_errosLLM($_POST['txtFeedback_errosLlm']);
        else  $newReceituario->setFeedback_errosLLM(0);

        if (
            isset($_POST['txtFeedback_sus_correto']) && !empty($_POST['txtFeedback_sus_correto']) &&
            isset($_POST['txtFeedback_sus_incorreto']) && !empty($_POST['txtFeedback_sus_incorreto']) &&
            isset($_POST['txtFeedback_sus_relevante']) && !empty($_POST['txtFeedback_sus_relevante']) &&
            isset($_POST['txtFeedback_sus_irrelevante']) && !empty($_POST['txtFeedback_sus_irrelevante']) &&
            isset($_POST['txtFeedback_sus_clara']) && !empty($_POST['txtFeedback_sus_clara']) &&
            isset($_POST['txtFeedback_sus_naoclara']) && !empty($_POST['txtFeedback_sus_naoclara']) &&
            isset($_POST['txtFeedback_sus_compreensivel']) && !empty($_POST['txtFeedback_sus_compreensivel']) &&
            isset($_POST['txtFeedback_sus_incompreensivel']) && !empty($_POST['txtFeedback_sus_incompreensivel']) &&
            isset($_POST['txtFeedback_sus_util']) && !empty($_POST['txtFeedback_sus_util']) &&
            isset($_POST['txtFeedback_sus_inutil']) && !empty($_POST['txtFeedback_sus_inutil'])
        )
        {
            try
            {
                /*CALCULO DA PONTUACAO FINAL
                Para as respostas ímpares (1, 3, 5, 7), subtraia 1 da pontuação que o usuário atribuiu à resposta.
                Para as respostas pares (2, 4, 6, 8), diminua a pontuação que o usuário atribuiu de 5(5-x).
                Depois, some todos os valores das dez perguntas, e multiplique por 2,5.*/

                $totalImpares = 0;
                $totalImpares += ($_POST['txtFeedback_sus_correto'] - 1);
                $totalImpares += ($_POST['txtFeedback_sus_relevante'] - 1);
                $totalImpares += ($_POST['txtFeedback_sus_clara'] - 1);
                $totalImpares += ($_POST['txtFeedback_sus_compreensivel'] - 1);
                $totalImpares += ($_POST['txtFeedback_sus_util'] - 1);

                $totalPares = 0;
                $totalPares += (5 - $_POST['txtFeedback_sus_incorreto']);
                $totalPares += (5 - $_POST['txtFeedback_sus_irrelevante']);
                $totalPares += (5 - $_POST['txtFeedback_sus_naoclara']);
                $totalPares += (5 - $_POST['txtFeedback_sus_incompreensivel']);
                $totalPares += (5 - $_POST['txtFeedback_sus_inutil']);

                $newReceituario->setDataEdicao(date('Y-m-d H:i:s'));
                $newReceituario->setNota_sus(($totalPares+$totalImpares)*2.5);

                $newReceituario->salvar();

                $saida = "<div class='alert alert-success alert-dismissable'>Avaliação armazenado com sucesso</div>";
                $rest->response($saida,200);
            }
            catch (Exception $exception)
            {
                $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";

                $stringComQuebraDeLinha = strip_tags(html_entity_decode(str_replace('<br>', "\n", $exception->getMessage())));
                Config\Pushover::enviaPush("Etapa Avaliação\n\nUsuário com receituário ".$newReceituario->getCodReceituarioV3()." não conseguiu avançar pelo erro: \n\n".$stringComQuebraDeLinha,"Problemas na rodada externa IAPOLIS");

                $rest->response($saida,500);
            }
        }
        else
        {
            $saida = '';

            if(!isset($_POST['txtFeedback_sus_correto']) || empty($_POST['txtFeedback_sus_correto'])) $saida .= '<br>Questão de "As orientações apresentadas estão corretas, de acordo com o que é amplamente aceito na área da saúde."';
            if(!isset($_POST['txtFeedback_sus_incorreto']) || empty($_POST['txtFeedback_sus_incorreto'])) $saida .= '<br>Questão "As orientações geradas contêm informações prejudiciais ou incorretas sobre o uso dos medicamentos."';
            if(!isset($_POST['txtFeedback_sus_relevante']) || empty($_POST['txtFeedback_sus_relevante'])) $saida .= '<br>Questão "As orientações cobrem os aspectos relevantes para o uso correto do medicamento."';
            if(!isset($_POST['txtFeedback_sus_irrelevante']) || empty($_POST['txtFeedback_sus_irrelevante'])) $saida .= '<br>Questão "As orientações não incluem informações suficientes para que a pessoa (cidadão) faça o uso correto do medicamento."';
            if(!isset($_POST['txtFeedback_sus_clara']) || empty($_POST['txtFeedback_sus_clara'])) $saida .= '<br>Questão "As orientações são suficientemente claras para a pessoa (cidadão) tomar/usar corretamente o medicamento."';
            if(!isset($_POST['txtFeedback_sus_naoclara']) || empty($_POST['txtFeedback_sus_naoclara'])) $saida .= '<br>Questão "As orientações apresentam informações desorganizadas e difíceis para a pessoa (cidadão) entender."';
            if(!isset($_POST['txtFeedback_sus_compreensivel']) || empty($_POST['txtFeedback_sus_compreensivel'])) $saida .= '<br>Questão "As orientações são escritas de forma acessível e compreensível para a pessoa (cidadão)."';
            if(!isset($_POST['txtFeedback_sus_incompreensivel']) || empty($_POST['txtFeedback_sus_incompreensivel'])) $saida .= '<br>Questão "As orientações abordam a pessoa (cidadão) de forma técnica demais."';
            if(!isset($_POST['txtFeedback_sus_util']) || empty($_POST['txtFeedback_sus_util'])) $saida .= '<br>Questão "As orientações sugeridas são úteis para complementar a receita que eu elaborei."';
            if(!isset($_POST['txtFeedback_sus_inutil']) || empty($_POST['txtFeedback_sus_inutil'])) $saida .= '<br>Questão "Minha receita não melhorou com as orientações sugeridas."';


            $saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: ".$saida."</div>";
            $rest->response($saida,400);
        }
    }
}
else
{
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response($saida,401);
}
?>
