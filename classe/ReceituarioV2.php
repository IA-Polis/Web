<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class ReceituarioV2
    {
        private $banco;
        private $tabela = "receituarioV2";

        private $codReceituarioV2;
        private $codPrompt;
        private $codUsuario;
        private $codCidadao;
        private $dataInclusao;
        private $motivoConsulta;
        private $textoEntrada;
        private $textoEntradaSistema;
        private $textoSaida;
        private $textoSaidaModificado;
        private $similaridade;
        private $feedback_adequacao;
        private $feedback_clareza;
        private $feedback_personalizacao;
        private $feedback_comparacao;
        private $feedback_errosLLM;
        private $feedback_confianca;
        private $feedback_textoLivre;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodReceituarioV2($codReceituarioV2)
        {
            $this->codReceituarioV2 = $codReceituarioV2;
        }
        public function getCodReceituarioV2()
        {
            return $this->codReceituarioV2;
        }

        public function setCodPrompt($codPrompt)
        {
            $this->codPrompt = $codPrompt;
        }
        public function getCodPrompt()
        {
            return $this->codPrompt;
        }

        public function setCodUsuario($codUsuario)
        {
            $this->codUsuario = $codUsuario;
        }
        public function getCodUsuario()
        {
            return $this->codUsuario;
        }

        public function setCodCidadao($codCidadao)
        {
            $this->codCidadao = $codCidadao;
        }
        public function getCodCidadao()
        {
            return $this->codCidadao;
        }

        public function setDataInclusao($dataInclusao)
        {
            $this->dataInclusao = $dataInclusao;
        }
        public function getDataInclusao()
        {
            return $this->dataInclusao;
        }

        public function setMotivoConsulta($motivoConsulta)
        {
            $this->motivoConsulta = $motivoConsulta;
        }
        public function getMotivoConsulta()
        {
            return $this->motivoConsulta;
        }

        public function setTextoEntrada($textoEntrada)
        {
            $this->textoEntrada = $textoEntrada;
        }
        public function getTextoEntrada()
        {
            return $this->textoEntrada;
        }

        public function setTextoEntradaSistema($textoEntradaSistema)
        {
            $this->textoEntradaSistema = $textoEntradaSistema;
        }
        public function getTextoEntradaSistema()
        {
            return $this->textoEntradaSistema;
        }

        public function setTextoSaida($textoSaida)
        {
            $this->textoSaida = $textoSaida;
        }
        public function getTextoSaida()
        {
            return $this->textoSaida;
        }

        public function setTextoSaidaModificado($textoSaidaModificado)
        {
            $this->textoSaidaModificado = $textoSaidaModificado;
        }
        public function getTextoSaidaModificado()
        {
            return $this->textoSaidaModificado;
        }

        public function setSimilaridade($similaridade)
        {
            $this->similaridade = $similaridade;
        }
        public function getSimilaridade()
        {
            return $this->similaridade;
        }

        public function setFeedback_adequacao($feedback_adequacao)
        {
            $this->feedback_adequacao = $feedback_adequacao;
        }
        public function getFeedback_adequacao()
        {
            return $this->feedback_adequacao;
        }

        public function setFeedback_clareza($feedback_clareza)
        {
            $this->feedback_clareza = $feedback_clareza;
        }
        public function getFeedback_clareza()
        {
            return $this->feedback_clareza;
        }

        public function setFeedback_personalizacao($feedback_personalizacao)
        {
            $this->feedback_personalizacao = $feedback_personalizacao;
        }
        public function getFeedback_personalizacao()
        {
            return $this->feedback_personalizacao;
        }

        public function setFeedback_comparacao($feedback_comparacao)
        {
            $this->feedback_comparacao = $feedback_comparacao;
        }
        public function getFeedback_comparacao()
        {
            return $this->feedback_comparacao;
        }

        public function setFeedback_errosLLM($feedback_errosLLM)
        {
            $this->feedback_errosLLM = $feedback_errosLLM;
        }
        public function getFeedback_errosLLM()
        {
            return $this->feedback_errosLLM;
        }

        public function setFeedback_confianca($feedback_confianca)
        {
            $this->feedback_confianca = $feedback_confianca;
        }
        public function getFeedback_confianca()
        {
            return $this->feedback_confianca;
        }

        public function setFeedback_textoLivre($feedback_textoLivre)
        {
            $this->feedback_textoLivre = $feedback_textoLivre;
        }
        public function getFeedback_textoLivre()
        {
            return $this->feedback_textoLivre;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codPrompt,codUsuario,codCidadao,dataInclusao,motivoConsulta,textoEntrada,textoEntradaSistema,textoSaida,textoSaidaModificado,similaridade,feedback_adequacao,feedback_clareza,feedback_personalizacao,feedback_comparacao,feedback_errosLLM,feedback_confianca,feedback_textoLivre) VALUES (:codPrompt,:codUsuario,:codCidadao,:dataInclusao,:motivoConsulta,:textoEntrada,:textoEntradaSistema,:textoSaida,:textoSaidaModificado,:similaridade,:feedback_adequacao,:feedback_clareza,:feedback_personalizacao,:feedback_comparacao,:feedback_errosLLM,:feedback_confianca,:feedback_textoLivre);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":motivoConsulta", $this->getMotivoConsulta());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoEntradaSistema", $this->getTextoEntradaSistema());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":textoSaidaModificado", $this->getTextoSaidaModificado());
                $sql->bindValue(":similaridade", $this->getSimilaridade());
                $sql->bindValue(":feedback_adequacao", $this->getFeedback_adequacao());
                $sql->bindValue(":feedback_clareza", $this->getFeedback_clareza());
                $sql->bindValue(":feedback_personalizacao", $this->getFeedback_personalizacao());
                $sql->bindValue(":feedback_comparacao", $this->getFeedback_comparacao());
                $sql->bindValue(":feedback_errosLLM", $this->getFeedback_errosLLM());
                $sql->bindValue(":feedback_confianca", $this->getFeedback_confianca());
                $sql->bindValue(":feedback_textoLivre", $this->getFeedback_textoLivre());
                $sql->execute();
                $this->setCodReceituarioV2(MySql::ultimoCodigoInserido());
                return "ReceituarioV2 incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir ReceituarioV2". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codPrompt = :codPrompt, codUsuario = :codUsuario, codCidadao = :codCidadao, dataInclusao = :dataInclusao, motivoConsulta = :motivoConsulta, textoEntrada = :textoEntrada, textoEntradaSistema = :textoEntradaSistema, textoSaida = :textoSaida, textoSaidaModificado = :textoSaidaModificado, similaridade = :similaridade, feedback_adequacao = :feedback_adequacao, feedback_clareza = :feedback_clareza, feedback_personalizacao = :feedback_personalizacao, feedback_comparacao = :feedback_comparacao, feedback_errosLLM = :feedback_errosLLM, feedback_confianca = :feedback_confianca, feedback_textoLivre = :feedback_textoLivre WHERE codReceituarioV2 = :codReceituarioV2;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV2", $this->getCodReceituarioV2());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":motivoConsulta", $this->getMotivoConsulta());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoEntradaSistema", $this->getTextoEntradaSistema());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":textoSaidaModificado", $this->getTextoSaidaModificado());
                $sql->bindValue(":similaridade", $this->getSimilaridade());
                $sql->bindValue(":feedback_adequacao", $this->getFeedback_adequacao());
                $sql->bindValue(":feedback_clareza", $this->getFeedback_clareza());
                $sql->bindValue(":feedback_personalizacao", $this->getFeedback_personalizacao());
                $sql->bindValue(":feedback_comparacao", $this->getFeedback_comparacao());
                $sql->bindValue(":feedback_errosLLM", $this->getFeedback_errosLLM());
                $sql->bindValue(":feedback_confianca", $this->getFeedback_confianca());
                $sql->bindValue(":feedback_textoLivre", $this->getFeedback_textoLivre());
                $sql->execute();
                return "ReceituarioV2 alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar ReceituarioV2". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV2 = :codReceituarioV2;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV2", $this->getCodReceituarioV2());
                $sql->execute();
                return "ReceituarioV2 excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir ReceituarioV2" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV2 = :codReceituarioV2 LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV2", $this->getCodReceituarioV2());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codReceituarioV2']) && !empty($row['codReceituarioV2'])) {
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodCidadao($row['codCidadao']);
                    $this->setDataInclusao($row['dataInclusao']);
                    $this->setMotivoConsulta($row['motivoConsulta']);
                    $this->setTextoEntrada($row['textoEntrada']);
                    $this->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $this->setTextoSaida($row['textoSaida']);
                    $this->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $this->setSimilaridade($row['similaridade']);
                    $this->setFeedback_adequacao($row['feedback_adequacao']);
                    $this->setFeedback_clareza($row['feedback_clareza']);
                    $this->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $this->setFeedback_comparacao($row['feedback_comparacao']);
                    $this->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $this->setFeedback_confianca($row['feedback_confianca']);
                    $this->setFeedback_textoLivre($row['feedback_textoLivre']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ReceituarioV2" . $e->getMessage(),1);
            }
        }

        public function carregarCidadaoPrompt($codCidadao, $codPrompt)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao = :codCidadao AND codPrompt = :codPrompt ORDER BY codReceituarioV2 LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $codCidadao);
                $sql->bindValue(":codPrompt", $codPrompt);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codReceituarioV2']) && !empty($row['codReceituarioV2'])) {
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodCidadao($row['codCidadao']);
                    $this->setDataInclusao($row['dataInclusao']);
                    $this->setMotivoConsulta($row['motivoConsulta']);
                    $this->setTextoEntrada($row['textoEntrada']);
                    $this->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $this->setTextoSaida($row['textoSaida']);
                    $this->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $this->setSimilaridade($row['similaridade']);
                    $this->setFeedback_adequacao($row['feedback_adequacao']);
                    $this->setFeedback_clareza($row['feedback_clareza']);
                    $this->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $this->setFeedback_comparacao($row['feedback_comparacao']);
                    $this->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $this->setFeedback_confianca($row['feedback_confianca']);
                    $this->setFeedback_textoLivre($row['feedback_textoLivre']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Receituario" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codReceituarioV2'] = $this->getCodReceituarioV2();
                $array['codPrompt'] = $this->getCodPrompt();
                $array['codUsuario'] = $this->getCodUsuario();
                $array['codCidadao'] = $this->getCodCidadao();
                $array['dataInclusao'] = $this->getDataInclusao();
                $array['motivoConsulta'] = $this->getMotivoConsulta();
                $array['textoEntrada'] = $this->getTextoEntrada();
                $array['textoEntradaSistema'] = $this->getTextoEntradaSistema();
                $array['textoSaida'] = $this->getTextoSaida();
                $array['textoSaidaModificado'] = $this->getTextoSaidaModificado();
                $array['similaridade'] = $this->getSimilaridade();
                $array['feedback_adequacao'] = $this->getFeedback_adequacao();
                $array['feedback_clareza'] = $this->getFeedback_clareza();
                $array['feedback_personalizacao'] = $this->getFeedback_personalizacao();
                $array['feedback_comparacao'] = $this->getFeedback_comparacao();
                $array['feedback_errosLLM'] = $this->getFeedback_errosLLM();
                $array['feedback_confianca'] = $this->getFeedback_confianca();
                $array['feedback_textoLivre'] = $this->getFeedback_textoLivre();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ReceituarioV2" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCriterio($criterio,$descricao, $orderBy = "codReceituarioV2")
        {
            try {
                $colObjeto = new phpCollection();
                if($criterio) $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE ".$criterio." = :".$criterio." ORDER BY ".$orderBy.";";
                else $query = "SELECT * FROM ".$this->banco.".".$this->tabela." ORDER BY ".$orderBy.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                if($criterio) $sql->bindValue(":".$criterio, $descricao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os ReceituarioV2s" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCidadaoPrompt($codCidadao,$codPrompt)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao = :codCidadao AND codPrompt = :codPrompt ORDER BY codPrompt;";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $codCidadao);
                $sql->bindValue(":codPrompt", $codPrompt);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosSemPrescricao()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV2 NOT IN (SELECT codReceituarioV2 FROM ".$this->banco.".prescricao WHERE codReceituarioV2 IS NOT NULL);";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCriterioSemTextoEntrada()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE textoEntrada IS NULL;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCriterioSemSimilaridade()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE similaridade IS NULL;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosPromptRandom($codPrompt,$codPromptNew = null)
        {
            try {
                $colObjeto = new phpCollection();
                if($codPromptNew) $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt AND codCidadao NOT IN (SELECT codCidadao FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt2) ORDER BY RAND();";
                else $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt ORDER BY RAND();";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $codPrompt);
                if($codPromptNew) $sql->bindValue(":codPrompt2", $codPromptNew);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosPromptRandomComBula($codPrompt,$codPromptNew)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt AND codCidadao NOT IN (SELECT codCidadao FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt2) AND codReceituario IN (SELECT codReceituario FROM ".$this->banco.".prescricao WHERE codMedicamento IN (SELECT codMedicamento FROM ".$this->banco.".medicamentoAnvisa)) ORDER BY RAND();";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $codPrompt);
                $sql->bindValue(":codPrompt2", $codPromptNew);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosPadraoUsuario()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codUsuario = :codUsuario AND codPrompt IN (SELECT codPrompt FROM ".$this->banco.".prompt WHERE padrao = 1) ORDER BY codReceituarioV2;";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUsuario", $_SESSION['CODIGOUSUARIO']);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function carregarTodosCidadaoUsuario($codCidadao, $codUsuario)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codUsuario = :codUsuario AND codCidadao = :codCidadao;";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUsuario", $codUsuario);
                $sql->bindValue(":codCidadao", $codCidadao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new ReceituarioV2();
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoEntradaSistema($row['textoEntradaSistema']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacao($row['feedback_adequacao']);
                    $esteObjeto->setFeedback_clareza($row['feedback_clareza']);
                    $esteObjeto->setFeedback_personalizacao($row['feedback_personalizacao']);
                    $esteObjeto->setFeedback_comparacao($row['feedback_comparacao']);
                    $esteObjeto->setFeedback_errosLLM($row['feedback_errosLLM']);
                    $esteObjeto->setFeedback_confianca($row['feedback_confianca']);
                    $esteObjeto->setFeedback_textoLivre($row['feedback_textoLivre']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Receituarios" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboReceituarioV2",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o receituarioV2'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codReceituarioV2'] || ( is_array($selecionado) && in_array($row['codReceituarioV2'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codReceituarioV2']."'>".$row['codPrompt']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo ReceituarioV2" . $e->getMessage(),1);
            }
        }
    }
}