<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class V3Receituario
    {
        private $banco;
        private $tabela = "v3Receituario";

        private $codReceituarioV3;
        private $codParticipante;
        private $codPrompt;
        private $codContexto;
        private $dataInclusao;
        private $dataEdicao;
        private $codMedicamento;
        private $codViaAdministracao;
        private $codUnidadeMedida;
        private $recomendacoes;
        private $posologia;
        private $inicioTratamento;
        private $textoEntrada;
        private $textoSaida;
        private $feedback_confianca;
        private $feedback_sus_correto;
        private $feedback_sus_incorreto;
        private $feedback_sus_relevante;
        private $feedback_sus_irrelevante;
        private $feedback_sus_clara;
        private $feedback_sus_naoclara;
        private $feedback_sus_compreensivel;
        private $feedback_sus_incompreensivel;
        private $feedback_sus_util;
        private $feedback_sus_inutil;
        private $feedback_errosLLM;
        private $feedback_textoLivre;
        private $nota_sus;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodReceituarioV3($codReceituarioV3)
        {
            $this->codReceituarioV3 = $codReceituarioV3;
        }
        public function getCodReceituarioV3()
        {
            return $this->codReceituarioV3;
        }

        public function setCodParticipante($codParticipante)
        {
            $this->codParticipante = $codParticipante;
        }
        public function getCodParticipante()
        {
            return $this->codParticipante;
        }

        public function setCodPrompt($codPrompt)
        {
            $this->codPrompt = $codPrompt;
        }
        public function getCodPrompt()
        {
            return $this->codPrompt;
        }

        public function setCodContexto($codContexto)
        {
            $this->codContexto = $codContexto;
        }
        public function getCodContexto()
        {
            return $this->codContexto;
        }

        public function setDataInclusao($dataInclusao)
        {
            $this->dataInclusao = $dataInclusao;
        }
        public function getDataInclusao()
        {
            return $this->dataInclusao;
        }

        public function setDataEdicao($dataEdicao)
        {
            $this->dataEdicao = $dataEdicao;
        }
        public function getDataEdicao()
        {
            return $this->dataEdicao;
        }

        public function setCodMedicamento($codMedicamento)
        {
            $this->codMedicamento = $codMedicamento;
        }
        public function getCodMedicamento()
        {
            return $this->codMedicamento;
        }

        public function setCodViaAdministracao($codViaAdministracao)
        {
            $this->codViaAdministracao = $codViaAdministracao;
        }
        public function getCodViaAdministracao()
        {
            return $this->codViaAdministracao;
        }

        public function setCodUnidadeMedida($codUnidadeMedida)
        {
            $this->codUnidadeMedida = $codUnidadeMedida;
        }
        public function getCodUnidadeMedida()
        {
            return $this->codUnidadeMedida;
        }

        public function setRecomendacoes($recomendacoes)
        {
            $this->recomendacoes = $recomendacoes;
        }
        public function getRecomendacoes()
        {
            return $this->recomendacoes;
        }

        public function setPosologia($posologia)
        {
            $this->posologia = $posologia;
        }
        public function getPosologia()
        {
            return $this->posologia;
        }

        public function setInicioTratamento($inicioTratamento)
        {
            $this->inicioTratamento = $inicioTratamento;
        }
        public function getInicioTratamento()
        {
            return $this->inicioTratamento;
        }

        public function setTextoEntrada($textoEntrada)
        {
            $this->textoEntrada = $textoEntrada;
        }
        public function getTextoEntrada()
        {
            return $this->textoEntrada;
        }

        public function setTextoSaida($textoSaida)
        {
            $this->textoSaida = $textoSaida;
        }
        public function getTextoSaida()
        {
            return $this->textoSaida;
        }

        public function setFeedback_confianca($feedback_confianca)
        {
            $this->feedback_confianca = $feedback_confianca;
        }
        public function getFeedback_confianca()
        {
            return $this->feedback_confianca;
        }

        public function setFeedback_sus_correto($feedback_sus_correto)
        {
            $this->feedback_sus_correto = $feedback_sus_correto;
        }
        public function getFeedback_sus_correto()
        {
            return $this->feedback_sus_correto;
        }

        public function setFeedback_sus_incorreto($feedback_sus_incorreto)
        {
            $this->feedback_sus_incorreto = $feedback_sus_incorreto;
        }
        public function getFeedback_sus_incorreto()
        {
            return $this->feedback_sus_incorreto;
        }

        public function setFeedback_sus_relevante($feedback_sus_relevante)
        {
            $this->feedback_sus_relevante = $feedback_sus_relevante;
        }
        public function getFeedback_sus_relevante()
        {
            return $this->feedback_sus_relevante;
        }

        public function setFeedback_sus_irrelevante($feedback_sus_irrelevante)
        {
            $this->feedback_sus_irrelevante = $feedback_sus_irrelevante;
        }
        public function getFeedback_sus_irrelevante()
        {
            return $this->feedback_sus_irrelevante;
        }

        public function setFeedback_sus_clara($feedback_sus_clara)
        {
            $this->feedback_sus_clara = $feedback_sus_clara;
        }
        public function getFeedback_sus_clara()
        {
            return $this->feedback_sus_clara;
        }

        public function setFeedback_sus_naoclara($feedback_sus_naoclara)
        {
            $this->feedback_sus_naoclara = $feedback_sus_naoclara;
        }
        public function getFeedback_sus_naoclara()
        {
            return $this->feedback_sus_naoclara;
        }

        public function setFeedback_sus_compreensivel($feedback_sus_compreensivel)
        {
            $this->feedback_sus_compreensivel = $feedback_sus_compreensivel;
        }
        public function getFeedback_sus_compreensivel()
        {
            return $this->feedback_sus_compreensivel;
        }

        public function setFeedback_sus_incompreensivel($feedback_sus_incompreensivel)
        {
            $this->feedback_sus_incompreensivel = $feedback_sus_incompreensivel;
        }
        public function getFeedback_sus_incompreensivel()
        {
            return $this->feedback_sus_incompreensivel;
        }

        public function setFeedback_sus_util($feedback_sus_util)
        {
            $this->feedback_sus_util = $feedback_sus_util;
        }
        public function getFeedback_sus_util()
        {
            return $this->feedback_sus_util;
        }

        public function setFeedback_sus_inutil($feedback_sus_inutil)
        {
            $this->feedback_sus_inutil = $feedback_sus_inutil;
        }
        public function getFeedback_sus_inutil()
        {
            return $this->feedback_sus_inutil;
        }

        public function setFeedback_errosLLM($feedback_errosLLM)
        {
            $this->feedback_errosLLM = $feedback_errosLLM;
        }
        public function getFeedback_errosLLM()
        {
            return $this->feedback_errosLLM;
        }

        public function setFeedback_textoLivre($feedback_textoLivre)
        {
            $this->feedback_textoLivre = $feedback_textoLivre;
        }
        public function getFeedback_textoLivre()
        {
            return $this->feedback_textoLivre;
        }

        public function setNota_sus($nota_sus)
        {
            $this->nota_sus = $nota_sus;
        }
        public function getNota_sus()
        {
            return $this->nota_sus;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codParticipante,codPrompt,codContexto,dataInclusao,dataEdicao,codMedicamento,codViaAdministracao,codUnidadeMedida,recomendacoes,posologia,inicioTratamento,textoEntrada,textoSaida,feedback_confianca,feedback_sus_correto,feedback_sus_incorreto,feedback_sus_relevante,feedback_sus_irrelevante,feedback_sus_clara,feedback_sus_naoclara,feedback_sus_compreensivel,feedback_sus_incompreensivel,feedback_sus_util,feedback_sus_inutil,feedback_errosLLM,feedback_textoLivre,nota_sus) VALUES (:codParticipante,:codPrompt,:codContexto,:dataInclusao,:dataEdicao,:codMedicamento,:codViaAdministracao,:codUnidadeMedida,:recomendacoes,:posologia,:inicioTratamento,:textoEntrada,:textoSaida,:feedback_confianca,:feedback_sus_correto,:feedback_sus_incorreto,:feedback_sus_relevante,:feedback_sus_irrelevante,:feedback_sus_clara,:feedback_sus_naoclara,:feedback_sus_compreensivel,:feedback_sus_incompreensivel,:feedback_sus_util,:feedback_sus_inutil,:feedback_errosLLM,:feedback_textoLivre,:nota_sus);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codParticipante", $this->getCodParticipante());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":dataEdicao", $this->getDataEdicao());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":recomendacoes", $this->getRecomendacoes());
                $sql->bindValue(":posologia", $this->getPosologia());
                $sql->bindValue(":inicioTratamento", $this->getInicioTratamento());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":feedback_confianca", $this->getFeedback_confianca());
                $sql->bindValue(":feedback_sus_correto", $this->getFeedback_sus_correto());
                $sql->bindValue(":feedback_sus_incorreto", $this->getFeedback_sus_incorreto());
                $sql->bindValue(":feedback_sus_relevante", $this->getFeedback_sus_relevante());
                $sql->bindValue(":feedback_sus_irrelevante", $this->getFeedback_sus_irrelevante());
                $sql->bindValue(":feedback_sus_clara", $this->getFeedback_sus_clara());
                $sql->bindValue(":feedback_sus_naoclara", $this->getFeedback_sus_naoclara());
                $sql->bindValue(":feedback_sus_compreensivel", $this->getFeedback_sus_compreensivel());
                $sql->bindValue(":feedback_sus_incompreensivel", $this->getFeedback_sus_incompreensivel());
                $sql->bindValue(":feedback_sus_util", $this->getFeedback_sus_util());
                $sql->bindValue(":feedback_sus_inutil", $this->getFeedback_sus_inutil());
                $sql->bindValue(":feedback_errosLLM", $this->getFeedback_errosLLM());
                $sql->bindValue(":feedback_textoLivre", $this->getFeedback_textoLivre());
                $sql->bindValue(":nota_sus", $this->getNota_sus());
                $sql->execute();
                $this->setCodReceituarioV3(MySql::ultimoCodigoInserido());
                return "V3Receituario incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir V3Receituario". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codParticipante = :codParticipante, codPrompt = :codPrompt, codContexto = :codContexto, dataInclusao = :dataInclusao, dataEdicao = :dataEdicao,codMedicamento = :codMedicamento, codViaAdministracao = :codViaAdministracao, codUnidadeMedida = :codUnidadeMedida, recomendacoes = :recomendacoes, posologia = :posologia, inicioTratamento = :inicioTratamento, textoEntrada = :textoEntrada, textoSaida = :textoSaida, feedback_confianca = :feedback_confianca, feedback_sus_correto = :feedback_sus_correto, feedback_sus_incorreto = :feedback_sus_incorreto, feedback_sus_relevante = :feedback_sus_relevante, feedback_sus_irrelevante = :feedback_sus_irrelevante, feedback_sus_clara = :feedback_sus_clara, feedback_sus_naoclara = :feedback_sus_naoclara, feedback_sus_compreensivel = :feedback_sus_compreensivel, feedback_sus_incompreensivel = :feedback_sus_incompreensivel, feedback_sus_util = :feedback_sus_util, feedback_sus_inutil = :feedback_sus_inutil, feedback_errosLLM = :feedback_errosLLM, feedback_textoLivre = :feedback_textoLivre, nota_sus = :nota_sus WHERE codReceituarioV3 = :codReceituarioV3;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV3", $this->getCodReceituarioV3());
                $sql->bindValue(":codParticipante", $this->getCodParticipante());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":dataEdicao", $this->getDataEdicao());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":recomendacoes", $this->getRecomendacoes());
                $sql->bindValue(":posologia", $this->getPosologia());
                $sql->bindValue(":inicioTratamento", $this->getInicioTratamento());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":feedback_confianca", $this->getFeedback_confianca());
                $sql->bindValue(":feedback_sus_correto", $this->getFeedback_sus_correto());
                $sql->bindValue(":feedback_sus_incorreto", $this->getFeedback_sus_incorreto());
                $sql->bindValue(":feedback_sus_relevante", $this->getFeedback_sus_relevante());
                $sql->bindValue(":feedback_sus_irrelevante", $this->getFeedback_sus_irrelevante());
                $sql->bindValue(":feedback_sus_clara", $this->getFeedback_sus_clara());
                $sql->bindValue(":feedback_sus_naoclara", $this->getFeedback_sus_naoclara());
                $sql->bindValue(":feedback_sus_compreensivel", $this->getFeedback_sus_compreensivel());
                $sql->bindValue(":feedback_sus_incompreensivel", $this->getFeedback_sus_incompreensivel());
                $sql->bindValue(":feedback_sus_util", $this->getFeedback_sus_util());
                $sql->bindValue(":feedback_sus_inutil", $this->getFeedback_sus_inutil());
                $sql->bindValue(":feedback_errosLLM", $this->getFeedback_errosLLM());
                $sql->bindValue(":feedback_textoLivre", $this->getFeedback_textoLivre());
                $sql->bindValue(":nota_sus", $this->getNota_sus());
                $sql->execute();
                return "V3Receituario alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar V3Receituario". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV3 = :codReceituarioV3;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV3", $this->getCodReceituarioV3());
                $sql->execute();
                return "V3Receituario excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir V3Receituario" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV3 = :codReceituarioV3 LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV3", $this->getCodReceituarioV3());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codReceituarioV3']) && !empty($row['codReceituarioV3'])) {
                    $this->setCodReceituarioV3($row['codReceituarioV3']);
                    $this->setCodParticipante($row['codParticipante']);
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setCodContexto($row['codContexto']);
                    $this->setDataInclusao($row['dataInclusao']);
                    $this->setDataEdicao($row['dataEdicao']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setRecomendacoes($row['recomendacoes']);
                    $this->setPosologia($row['posologia']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setTextoEntrada($row['textoEntrada']);
                    $this->setTextoSaida($row['textoSaida']);
                    $this->setFeedback_confianca($row['feedback_confianca']);
                    $this->setFeedback_sus_correto($row['feedback_sus_correto']);
                    $this->setFeedback_sus_incorreto($row['feedback_sus_incorreto']);
                    $this->setFeedback_sus_relevante($row['feedback_sus_relevante']);
                    $this->setFeedback_sus_irrelevante($row['feedback_sus_irrelevante']);
                    $this->setFeedback_sus_clara($row['feedback_sus_clara']);
                    $this->setFeedback_sus_naoclara($row['feedback_sus_naoclara']);
                    $this->setFeedback_sus_compreensivel($row['feedback_sus_compreensivel']);
                    $this->setFeedback_sus_incompreensivel($row['feedback_sus_incompreensivel']);
                    $this->setFeedback_sus_util($row['feedback_sus_util']);
                    $this->setFeedback_sus_inutil($row['feedback_sus_inutil']);
                    $this->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $this->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $this->setNota_sus($row['nota_sus']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o V3Receituario" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codReceituarioV3'] = $this->getCodReceituarioV3();
                $array['codParticipante'] = $this->getCodParticipante();
                $array['codPrompt'] = $this->getCodPrompt();
                $array['codContexto'] = $this->getCodContexto();
                $array['dataInclusao'] = $this->getDataInclusao();
                $array['dataEdicao'] = $this->getDataEdicao();
                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['codUnidadeMedida'] = $this->getCodUnidadeMedida();
                $array['recomendacoes'] = $this->getRecomendacoes();
                $array['posologia'] = $this->getPosologia();
                $array['inicioTratamento'] = $this->getInicioTratamento();
                $array['textoEntrada'] = $this->getTextoEntrada();
                $array['textoSaida'] = $this->getTextoSaida();
                $array['feedback_confianca'] = $this->getFeedback_confianca();
                $array['feedback_sus_correto'] = $this->getFeedback_sus_correto();
                $array['feedback_sus_incorreto'] = $this->getFeedback_sus_incorreto();
                $array['feedback_sus_relevante'] = $this->getFeedback_sus_relevante();
                $array['feedback_sus_irrelevante'] = $this->getFeedback_sus_irrelevante();
                $array['feedback_sus_clara'] = $this->getFeedback_sus_clara();
                $array['feedback_sus_naoclara'] = $this->getFeedback_sus_naoclara();
                $array['feedback_sus_compreensivel'] = $this->getFeedback_sus_compreensivel();
                $array['feedback_sus_incompreensivel'] = $this->getFeedback_sus_incompreensivel();
                $array['feedback_sus_util'] = $this->getFeedback_sus_util();
                $array['feedback_sus_inutil'] = $this->getFeedback_sus_inutil();
                $array['feedback_errosLLM'] = $this->getFeedback_errosLLM();
                $array['feedback_textoLivre'] = $this->getFeedback_textoLivre();
                $array['nota_sus'] = $this->getNota_sus();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o V3Receituario" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCriterio($criterio,$descricao)
        {
            try {
                $colObjeto = new phpCollection();
                if($criterio) $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE ".$criterio." = :".$criterio.";";
                else $query = "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                if($criterio) $sql->bindValue(":".$criterio, $descricao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new V3Receituario();
                    $esteObjeto->setCodReceituarioV3($row['codReceituarioV3']);
                    $esteObjeto->setCodParticipante($row['codParticipante']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setDataEdicao($row['dataEdicao']);
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $esteObjeto->setRecomendacoes($row['recomendacoes']);
                    $esteObjeto->setPosologia($row['posologia']);
                    $esteObjeto->setInicioTratamento($row['inicioTratamento']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_sus_correto($row['feedback_sus_correto']);
                    $esteObjeto->setFeedback_sus_incorreto($row['feedback_sus_incorreto']);
                    $esteObjeto->setFeedback_sus_relevante($row['feedback_sus_relevante']);
                    $esteObjeto->setFeedback_sus_irrelevante($row['feedback_sus_irrelevante']);
                    $esteObjeto->setFeedback_sus_clara($row['feedback_sus_clara']);
                    $esteObjeto->setFeedback_sus_naoclara($row['feedback_sus_naoclara']);
                    $esteObjeto->setFeedback_sus_compreensivel($row['feedback_sus_compreensivel']);
                    $esteObjeto->setFeedback_sus_incompreensivel($row['feedback_sus_incompreensivel']);
                    $esteObjeto->setFeedback_sus_util($row['feedback_sus_util']);
                    $esteObjeto->setFeedback_sus_inutil($row['feedback_sus_inutil']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $esteObjeto->setNota_sus($row['nota_sus']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os V3Receituarios" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboV3Receituario",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o v3Receituario'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codReceituarioV3'] || ( is_array($selecionado) && in_array($row['codReceituarioV3'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codReceituarioV3']."'>".$row['codParticipante']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo V3Receituario" . $e->getMessage(),1);
            }
        }
    }
}