<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class UnidadeMedida
    {
        private $banco;
        private $tabela = "unidadeMedida";

        private $codUnidadeMedida;
        private $unidadeMedidaSG;
        private $unidadeMedidaFiltro;
        private $unidadeMedida;
        private $unidadeMedidaPlural;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodUnidadeMedida($codUnidadeMedida)
        {
            $this->codUnidadeMedida = $codUnidadeMedida;
        }
        public function getCodUnidadeMedida()
        {
            return $this->codUnidadeMedida;
        }

        public function setUnidadeMedidaSG($unidadeMedidaSG)
        {
            $this->unidadeMedidaSG = $unidadeMedidaSG;
        }
        public function getUnidadeMedidaSG()
        {
            return $this->unidadeMedidaSG;
        }

        public function setUnidadeMedidaFiltro($unidadeMedidaFiltro)
        {
            $this->unidadeMedidaFiltro = $unidadeMedidaFiltro;
        }
        public function getUnidadeMedidaFiltro()
        {
            return $this->unidadeMedidaFiltro;
        }

        public function setUnidadeMedida($unidadeMedida)
        {
            $this->unidadeMedida = $unidadeMedida;
        }
        public function getUnidadeMedida()
        {
            return $this->unidadeMedida;
        }

        public function setUnidadeMedidaPlural($unidadeMedidaPlural)
        {
            $this->unidadeMedidaPlural = $unidadeMedidaPlural;
        }
        public function getUnidadeMedidaPlural()
        {
            return $this->unidadeMedidaPlural;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (unidadeMedidaSG,unidadeMedidaFiltro,unidadeMedida,unidadeMedidaPlural) VALUES (:unidadeMedidaSG,:unidadeMedidaFiltro,:unidadeMedida,:unidadeMedidaPlural);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":unidadeMedidaSG", $this->getUnidadeMedidaSG());
                $sql->bindValue(":unidadeMedidaFiltro", $this->getUnidadeMedidaFiltro());
                $sql->bindValue(":unidadeMedida", $this->getUnidadeMedida());
                $sql->bindValue(":unidadeMedidaPlural", $this->getUnidadeMedidaPlural());
                $sql->execute();
                $this->setCodUnidadeMedida(MySql::ultimoCodigoInserido());
                return "UnidadeMedida incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir UnidadeMedida". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET unidadeMedidaSG = :unidadeMedidaSG, unidadeMedidaFiltro = :unidadeMedidaFiltro, unidadeMedida = :unidadeMedida, unidadeMedidaPlural = :unidadeMedidaPlural WHERE codUnidadeMedida = :codUnidadeMedida;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":unidadeMedidaSG", $this->getUnidadeMedidaSG());
                $sql->bindValue(":unidadeMedidaFiltro", $this->getUnidadeMedidaFiltro());
                $sql->bindValue(":unidadeMedida", $this->getUnidadeMedida());
                $sql->bindValue(":unidadeMedidaPlural", $this->getUnidadeMedidaPlural());
                $sql->execute();
                return "UnidadeMedida alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar UnidadeMedida". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codUnidadeMedida = :codUnidadeMedida;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->execute();
                return "UnidadeMedida excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir UnidadeMedida" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codUnidadeMedida = :codUnidadeMedida LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codUnidadeMedida']) && !empty($row['codUnidadeMedida'])) {
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setUnidadeMedidaSG($row['unidadeMedidaSG']);
                    $this->setUnidadeMedidaFiltro($row['unidadeMedidaFiltro']);
                    $this->setUnidadeMedida($row['unidadeMedida']);
                    $this->setUnidadeMedidaPlural($row['unidadeMedidaPlural']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o UnidadeMedida" . $e->getMessage(),1);
            }
        }

        public function carregarPelaUnidadeMedidaSG()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE unidadeMedidaSG LIKE :unidadeMedidaSG OR unidadeMedidaFiltro LIKE :unidadeMedidaSG OR unidadeMedidaPlural LIKE :unidadeMedidaSG LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":unidadeMedidaSG", "%".$this->getUnidadeMedidaSG()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codUnidadeMedida']) && !empty($row['codUnidadeMedida'])) {
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setUnidadeMedidaSG($row['unidadeMedidaSG']);
                    $this->setUnidadeMedidaFiltro($row['unidadeMedidaFiltro']);
                    $this->setUnidadeMedida($row['unidadeMedida']);
                    $this->setUnidadeMedidaPlural($row['unidadeMedidaPlural']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o UnidadeMedida" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codUnidadeMedida'] = $this->getCodUnidadeMedida();
                $array['unidadeMedidaSG'] = $this->getUnidadeMedidaSG();
                $array['unidadeMedidaFiltro'] = $this->getUnidadeMedidaFiltro();
                $array['unidadeMedida'] = $this->getUnidadeMedida();
                $array['unidadeMedidaPlural'] = $this->getUnidadeMedidaPlural();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o UnidadeMedida" . $e->getMessage(),1);
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
                    $esteObjeto = new UnidadeMedida();
                    $esteObjeto->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $esteObjeto->setUnidadeMedidaSG($row['unidadeMedidaSG']);
                    $esteObjeto->setUnidadeMedidaFiltro($row['unidadeMedidaFiltro']);
                    $esteObjeto->setUnidadeMedida($row['unidadeMedida']);
                    $esteObjeto->setUnidadeMedidaPlural($row['unidadeMedidaPlural']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os UnidadeMedidas" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboUnidadeMedida",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione a unidade de medida'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codUnidadeMedida'] || ( is_array($selecionado) && in_array($row['codUnidadeMedida'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codUnidadeMedida']."'>".$row['unidadeMedida']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo UnidadeMedida" . $e->getMessage(),1);
            }
        }
    }
}