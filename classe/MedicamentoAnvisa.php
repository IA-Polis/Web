<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class MedicamentoAnvisa
    {
        private $banco;
        private $tabela = "medicamentoAnvisa";

        private $codMedicamento;
        private $idProduto;
        private $principal;
        private $codViaAdministracao;
        private $errado;
        private $rag;
        private $ragSumarizado;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodMedicamento($codMedicamento)
        {
            $this->codMedicamento = $codMedicamento;
        }
        public function getCodMedicamento()
        {
            return $this->codMedicamento;
        }

        public function setIdProduto($idProduto)
        {
            $this->idProduto = $idProduto;
        }
        public function getIdProduto()
        {
            return $this->idProduto;
        }

        public function setPrincipal($principal)
        {
            $this->principal = $principal;
        }
        public function getPrincipal()
        {
            return $this->principal;
        }

        public function setCodViaAdministracao($codViaAdministracao)
        {
            $this->codViaAdministracao = $codViaAdministracao;
        }
        public function getCodViaAdministracao()
        {
            return $this->codViaAdministracao;
        }

        public function setErrado($errado)
        {
            $this->errado = $errado;
        }
        public function getErrado()
        {
            return $this->errado;
        }

        public function setRag($rag)
        {
            $this->rag = $rag;
        }
        public function getRag()
        {
            return $this->rag;
        }

        public function setRagSumarizado($ragSumarizado)
        {
            $this->ragSumarizado = $ragSumarizado;
        }
        public function getRagSumarizado()
        {
            return $this->ragSumarizado;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (idProduto,codMedicamento,principal,codViaAdministracao,errado,rag,ragSumarizado) VALUES (:idProduto,:codMedicamento,:principal,:codViaAdministracao,:errado,:rag,:ragSumarizado);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->bindValue(":principal", $this->getPrincipal());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":errado", $this->getErrado());
                $sql->bindValue(":rag", $this->getRag());
                $sql->bindValue(":ragSumarizado", $this->getRagSumarizado());

                $sql->execute();
                $this->setCodMedicamento(MySql::ultimoCodigoInserido());
                return "MedicamentoAnvisa incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir MedicamentoAnvisa". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET idProduto = :idProduto, principal = :principal, codViaAdministracao = :codViaAdministracao, errado = :errado, rag = :rag, ragSumarizado = :ragSumarizado WHERE codMedicamento = :codMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->bindValue(":principal", $this->getPrincipal());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":errado", $this->getErrado());
                $sql->bindValue(":rag", $this->getRag());
                $sql->bindValue(":ragSumarizado", $this->getRagSumarizado());
                $sql->execute();
                return "MedicamentoAnvisa alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar MedicamentoAnvisa". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->execute();
                return "MedicamentoAnvisa excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir MedicamentoAnvisa" . $e->getMessage(),1);
            }
        }

        public function carregar($listaAnvisa = null)
        {
            try {
                if($listaAnvisa) $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento AND idProduto IN (".implode(',',$listaAnvisa).") ORDER BY principal desc, idProduto  LIMIT 1;";
                else $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento ORDER BY principal desc, idProduto  LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setIdProduto($row['idProduto']);
                    $this->setPrincipal($row['principal']);
					$this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setErrado($row['errado']);
                    $this->setRag($row['rag']);
                    $this->setRagSumarizado($row['ragSumarizado']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoAnvisa" . $e->getMessage(),1);
            }
        }

        public function carregarPrincipal($codMedicamento)
        {
            try {

                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento AND principal = 1 ORDER BY principal desc, idProduto  LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $codMedicamento);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setIdProduto($row['idProduto']);
                    $this->setPrincipal($row['principal']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setErrado($row['errado']);
                    $this->setRag($row['rag']);
                    $this->setRagSumarizado($row['ragSumarizado']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoAnvisa" . $e->getMessage(),1);
            }
        }

        public function existe()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento AND idProduto = :idProduto LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    return true;
                }else return false;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoAnvisa" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['idProduto'] = $this->getIdProduto();
                $array['principal'] = $this->getPrincipal();
                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['errado'] = $this->getErrado();
                $array['rag'] = $this->getRag();
                $array['ragSumarizado'] = $this->getRagSumarizado();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoAnvisa" . $e->getMessage(),1);
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
                    $esteObjeto = new MedicamentoAnvisa();
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setIdProduto($row['idProduto']);
                    $esteObjeto->setPrincipal($row['principal']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setErrado($row['errado']);
                    $esteObjeto->setRag($row['rag']);
                    $esteObjeto->setRagSumarizado($row['ragSumarizado']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os MedicamentoAnvisas" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboMedicamentoAnvisa",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o medicamentoAnvisa'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codMedicamento'] || ( is_array($selecionado) && in_array($row['codMedicamento'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codMedicamento']."'>".$row['idProduto']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo MedicamentoAnvisa" . $e->getMessage(),1);
            }
        }
    }
}