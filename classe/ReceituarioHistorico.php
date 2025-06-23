<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class ReceituarioHistorico
    {
        private $banco;
        private $tabela = "receituarioHistorico";

        private $codReceituarioHistorico;
        private $codReceituario;
        private $codPrompt;
        private $codUsuario;
        private $codCidadao;
        private $dataInclusao;
        private $motivoConsulta;
        private $textoEntrada;
        private $textoSaida;
        private $textoSaidaModificado;
        private $similaridade;
        private $feedback_adequacaoOrientacao;
        private $feedback_adequacaoOrientacao_justificativa;
        private $feedback_aceitabilidade;
        private $feedback_aceitabilidade_justificativa;
        private $feedback_orientacoes;
        private $feedback_orientacoes_justificativa;
        private $feedback_llm;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodReceituarioHistorico($codReceituarioHistorico)
        {
            $this->codReceituarioHistorico = $codReceituarioHistorico;
        }
        public function getCodReceituarioHistorico()
        {
            return $this->codReceituarioHistorico;
        }

        public function setCodReceituario($codReceituario)
        {
            $this->codReceituario = $codReceituario;
        }
        public function getCodReceituario()
        {
            return $this->codReceituario;
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

        public function setFeedback_adequacaoOrientacao($feedback_adequacaoOrientacao)
        {
            $this->feedback_adequacaoOrientacao = $feedback_adequacaoOrientacao;
        }
        public function getFeedback_adequacaoOrientacao()
        {
            return $this->feedback_adequacaoOrientacao;
        }

        public function setFeedback_adequacaoOrientacao_justificativa($feedback_adequacaoOrientacao_justificativa)
        {
            $this->feedback_adequacaoOrientacao_justificativa = $feedback_adequacaoOrientacao_justificativa;
        }
        public function getFeedback_adequacaoOrientacao_justificativa()
        {
            return $this->feedback_adequacaoOrientacao_justificativa;
        }

        public function setFeedback_aceitabilidade($feedback_aceitabilidade)
        {
            $this->feedback_aceitabilidade = $feedback_aceitabilidade;
        }
        public function getFeedback_aceitabilidade()
        {
            return $this->feedback_aceitabilidade;
        }

        public function setFeedback_aceitabilidade_justificativa($feedback_aceitabilidade_justificativa)
        {
            $this->feedback_aceitabilidade_justificativa = $feedback_aceitabilidade_justificativa;
        }
        public function getFeedback_aceitabilidade_justificativa()
        {
            return $this->feedback_aceitabilidade_justificativa;
        }

        public function setFeedback_orientacoes($feedback_orientacoes)
        {
            $this->feedback_orientacoes = $feedback_orientacoes;
        }
        public function getFeedback_orientacoes()
        {
            return $this->feedback_orientacoes;
        }

        public function setFeedback_orientacoes_justificativa($feedback_orientacoes_justificativa)
        {
            $this->feedback_orientacoes_justificativa = $feedback_orientacoes_justificativa;
        }
        public function getFeedback_orientacoes_justificativa()
        {
            return $this->feedback_orientacoes_justificativa;
        }

        public function setFeedback_llm($feedback_llm)
        {
            $this->feedback_llm = $feedback_llm;
        }
        public function getFeedback_llm()
        {
            return $this->feedback_llm;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codReceituario,codPrompt,codUsuario,codCidadao,dataInclusao,motivoConsulta,textoEntrada,textoSaida,textoSaidaModificado,similaridade,feedback_adequacaoOrientacao,feedback_adequacaoOrientacao_justificativa,feedback_aceitabilidade,feedback_aceitabilidade_justificativa,feedback_orientacoes,feedback_orientacoes_justificativa,feedback_llm) VALUES (:codReceituario,:codPrompt,:codUsuario,:codCidadao,:dataInclusao,:motivoConsulta,:textoEntrada,:textoSaida,:textoSaidaModificado,:similaridade,:feedback_adequacaoOrientacao,:feedback_adequacaoOrientacao_justificativa,:feedback_aceitabilidade,:feedback_aceitabilidade_justificativa,:feedback_orientacoes,:feedback_orientacoes_justificativa,:feedback_llm);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituario", $this->getCodReceituario());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":motivoConsulta", $this->getMotivoConsulta());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":textoSaidaModificado", $this->getTextoSaidaModificado());
                $sql->bindValue(":similaridade", $this->getSimilaridade());
                $sql->bindValue(":feedback_adequacaoOrientacao", $this->getFeedback_adequacaoOrientacao());
                $sql->bindValue(":feedback_adequacaoOrientacao_justificativa", $this->getFeedback_adequacaoOrientacao_justificativa());
                $sql->bindValue(":feedback_aceitabilidade", $this->getFeedback_aceitabilidade());
                $sql->bindValue(":feedback_aceitabilidade_justificativa", $this->getFeedback_aceitabilidade_justificativa());
                $sql->bindValue(":feedback_orientacoes", $this->getFeedback_orientacoes());
                $sql->bindValue(":feedback_orientacoes_justificativa", $this->getFeedback_orientacoes_justificativa());
                $sql->bindValue(":feedback_llm", $this->getFeedback_llm());
                $sql->execute();
                $this->setCodReceituarioHistorico(MySql::ultimoCodigoInserido());
                return "ReceituarioHistorico incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir ReceituarioHistorico". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codReceituario = :codReceituario, codPrompt = :codPrompt, codUsuario = :codUsuario, codCidadao = :codCidadao, dataInclusao = :dataInclusao, motivoConsulta = :motivoConsulta, textoEntrada = :textoEntrada, textoSaida = :textoSaida, textoSaidaModificado = :textoSaidaModificado, similaridade = :similaridade, feedback_adequacaoOrientacao = :feedback_adequacaoOrientacao, feedback_adequacaoOrientacao_justificativa = :feedback_adequacaoOrientacao_justificativa, feedback_aceitabilidade = :feedback_aceitabilidade, feedback_aceitabilidade_justificativa = :feedback_aceitabilidade_justificativa, feedback_orientacoes = :feedback_orientacoes, feedback_orientacoes_justificativa = :feedback_orientacoes_justificativa, feedback_llm = :feedback_llm WHERE codReceituarioHistorico = :codReceituarioHistorico;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioHistorico", $this->getCodReceituarioHistorico());
                $sql->bindValue(":codReceituario", $this->getCodReceituario());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->bindValue(":motivoConsulta", $this->getMotivoConsulta());
                $sql->bindValue(":textoEntrada", $this->getTextoEntrada());
                $sql->bindValue(":textoSaida", $this->getTextoSaida());
                $sql->bindValue(":textoSaidaModificado", $this->getTextoSaidaModificado());
                $sql->bindValue(":similaridade", $this->getSimilaridade());
                $sql->bindValue(":feedback_adequacaoOrientacao", $this->getFeedback_adequacaoOrientacao());
                $sql->bindValue(":feedback_adequacaoOrientacao_justificativa", $this->getFeedback_adequacaoOrientacao_justificativa());
                $sql->bindValue(":feedback_aceitabilidade", $this->getFeedback_aceitabilidade());
                $sql->bindValue(":feedback_aceitabilidade_justificativa", $this->getFeedback_aceitabilidade_justificativa());
                $sql->bindValue(":feedback_orientacoes", $this->getFeedback_orientacoes());
                $sql->bindValue(":feedback_orientacoes_justificativa", $this->getFeedback_orientacoes_justificativa());
                $sql->bindValue(":feedback_llm", $this->getFeedback_llm());
                $sql->execute();
                return "ReceituarioHistorico alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar ReceituarioHistorico". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioHistorico = :codReceituarioHistorico;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioHistorico", $this->getCodReceituarioHistorico());
                $sql->execute();
                return "ReceituarioHistorico excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir ReceituarioHistorico" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioHistorico = :codReceituarioHistorico LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioHistorico", $this->getCodReceituarioHistorico());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codReceituarioHistorico']) && !empty($row['codReceituarioHistorico'])) {
                    $this->setCodReceituarioHistorico($row['codReceituarioHistorico']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodCidadao($row['codCidadao']);
                    $this->setDataInclusao($row['dataInclusao']);
                    $this->setMotivoConsulta($row['motivoConsulta']);
                    $this->setTextoEntrada($row['textoEntrada']);
                    $this->setTextoSaida($row['textoSaida']);
                    $this->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $this->setSimilaridade($row['similaridade']);
                    $this->setFeedback_adequacaoOrientacao($row['feedback_adequacaoOrientacao']);
                    $this->setFeedback_adequacaoOrientacao_justificativa($row['feedback_adequacaoOrientacao_justificativa']);
                    $this->setFeedback_aceitabilidade($row['feedback_aceitabilidade']);
                    $this->setFeedback_aceitabilidade_justificativa($row['feedback_aceitabilidade_justificativa']);
                    $this->setFeedback_orientacoes($row['feedback_orientacoes']);
                    $this->setFeedback_orientacoes_justificativa($row['feedback_orientacoes_justificativa']);
                    $this->setFeedback_llm($row['feedback_llm']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ReceituarioHistorico" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codReceituarioHistorico'] = $this->getCodReceituarioHistorico();
                $array['codReceituario'] = $this->getCodReceituario();
                $array['codPrompt'] = $this->getCodPrompt();
                $array['codUsuario'] = $this->getCodUsuario();
                $array['codCidadao'] = $this->getCodCidadao();
                $array['dataInclusao'] = $this->getDataInclusao();
                $array['motivoConsulta'] = $this->getMotivoConsulta();
                $array['textoEntrada'] = $this->getTextoEntrada();
                $array['textoSaida'] = $this->getTextoSaida();
                $array['textoSaidaModificado'] = $this->getTextoSaidaModificado();
                $array['similaridade'] = $this->getSimilaridade();
                $array['feedback_adequacaoOrientacao'] = $this->getFeedback_adequacaoOrientacao();
                $array['feedback_adequacaoOrientacao_justificativa'] = $this->getFeedback_adequacaoOrientacao_justificativa();
                $array['feedback_aceitabilidade'] = $this->getFeedback_aceitabilidade();
                $array['feedback_aceitabilidade_justificativa'] = $this->getFeedback_aceitabilidade_justificativa();
                $array['feedback_orientacoes'] = $this->getFeedback_orientacoes();
                $array['feedback_orientacoes_justificativa'] = $this->getFeedback_orientacoes_justificativa();
                $array['feedback_llm'] = $this->getFeedback_llm();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ReceituarioHistorico" . $e->getMessage(),1);
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
                    $esteObjeto = new ReceituarioHistorico();
                    $esteObjeto->setCodReceituarioHistorico($row['codReceituarioHistorico']);
                    $esteObjeto->setCodReceituario($row['codReceituario']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $esteObjeto->setMotivoConsulta($row['motivoConsulta']);
                    $esteObjeto->setTextoEntrada($row['textoEntrada']);
                    $esteObjeto->setTextoSaida($row['textoSaida']);
                    $esteObjeto->setTextoSaidaModificado($row['textoSaidaModificado']);
                    $esteObjeto->setSimilaridade($row['similaridade']);
                    $esteObjeto->setFeedback_adequacaoOrientacao($row['feedback_adequacaoOrientacao']);
                    $esteObjeto->setFeedback_adequacaoOrientacao_justificativa($row['feedback_adequacaoOrientacao_justificativa']);
                    $esteObjeto->setFeedback_aceitabilidade($row['feedback_aceitabilidade']);
                    $esteObjeto->setFeedback_aceitabilidade_justificativa($row['feedback_aceitabilidade_justificativa']);
                    $esteObjeto->setFeedback_orientacoes($row['feedback_orientacoes']);
                    $esteObjeto->setFeedback_orientacoes_justificativa($row['feedback_orientacoes_justificativa']);
                    $esteObjeto->setFeedback_llm($row['feedback_llm']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os ReceituarioHistoricos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboReceituarioHistorico",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o receituarioHistorico'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codReceituarioHistorico'] || ( is_array($selecionado) && in_array($row['codReceituarioHistorico'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codReceituarioHistorico']."'>".$row['codReceituario']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo ReceituarioHistorico" . $e->getMessage(),1);
            }
        }
    }
}