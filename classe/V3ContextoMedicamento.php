<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception;

    class V3ContextoMedicamento
    {
        private $banco;
        private $tabela = "v3ContextoMedicamento";

        private $codContexto;
        private $codMedicamento;
        private $codViaAdministracao;
        private $textoRag;

        private $textoRagSumarizado;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodContexto($codContexto)
        {
            $this->codContexto = $codContexto;
        }
        public function getCodContexto()
        {
            return $this->codContexto;
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

        public function setTextoRag($textoRag)
        {
            $this->textoRag = $textoRag;
        }
        public function getTextoRag()
        {
            return $this->textoRag;
        }

        public function setTextoRagSumarizado($textoRagSumarizado)
        {
            $this->textoRagSumarizado = $textoRagSumarizado;
        }
        public function getTextoRagSumarizado()
        {
            return $this->textoRagSumarizado;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codContexto,codMedicamento,codViaAdministracao,textoRag,textoRagSumarizado) VALUES (:codContexto,:codMedicamento,:codViaAdministracao,:textoRag,:textoRagSumarizado);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":textoRag", $this->getTextoRag());
                $sql->bindValue(":textoRagSumarizado", $this->getTextoRagSumarizado());

                $sql->execute();
                $this->setCodContexto(MySql::ultimoCodigoInserido());
                return "ContextoMedicamento incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir ContextoMedicamento". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET  textoRag = :textoRag, textoRagSumarizado = :textoRagSumarizado WHERE codContexto = :codContexto AND codMedicamento = :codMedicamento AND codViaAdministracao = :codViaAdministracao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":textoRag", $this->getTextoRag());
                $sql->bindValue(":textoRagSumarizado", $this->getTextoRagSumarizado());

                $sql->execute();
                return "ContextoMedicamento alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar ContextoMedicamento". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codContexto = :codContexto;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->execute();
                return "ContextoMedicamento excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir ContextoMedicamento" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codContexto = :codContexto AND codMedicamento = :codMedicamento AND  codViaAdministracao = :codViaAdministracao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codContexto']) && !empty($row['codContexto'])) {
                    $this->setCodContexto($row['codContexto']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setTextoRag($row['textoRag']);
                    $this->setTextoRagSumarizado($row['textoRagSumarizado']);
                }else{
                    $this->setCodContexto("");
                    $this->setCodMedicamento("");
                    $this->setCodViaAdministracao("");
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ContextoMedicamento" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codContexto'] = $this->getCodContexto();
                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['textoRag'] = $this->getTextoRag();
                $array['textoRagSumarizado'] = $this->getTextoRagSumarizado();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ContextoMedicamento" . $e->getMessage(),1);
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
                    $esteObjeto = new V3ContextoMedicamento();
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setTextoRag($row['textoRag']);
                    $esteObjeto->setTextoRagSumarizado($row['textoRagSumarizado']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os ContextoMedicamentos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboContextoMedicamento",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o contextoMedicamento'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>";
                while($row = $sql->fetch()){
                    $saida	.= "<option ";
                    if ($selecionado == $row['codContexto'] || ( is_array($selecionado) && in_array($row['codContexto'],$selecionado)))	$saida	.= "selected ";
                    $saida	.= "value='".$row['codContexto']."'>".$row['codMedicamento']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo ContextoMedicamento" . $e->getMessage(),1);
            }
        }
    }
}