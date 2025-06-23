<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class PictogramaAvaliacaoExternaItem
    {
        private $banco;
        private $tabela = "pictogramaAvaliacaoExternaItem";

        private $codPictogramaAvaliacaoExternaItem;
        private $codPictogramaAvaliacaoExterna;
        private $codPictograma;
        private $codPictogramaAvaliacaoExternaOpcao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictogramaAvaliacaoExternaItem($codPictogramaAvaliacaoExternaItem)
        {
            $this->codPictogramaAvaliacaoExternaItem = $codPictogramaAvaliacaoExternaItem;
        }
        public function getCodPictogramaAvaliacaoExternaItem()
        {
            return $this->codPictogramaAvaliacaoExternaItem;
        }

        public function setCodPictogramaAvaliacaoExterna($codPictogramaAvaliacaoExterna)
        {
            $this->codPictogramaAvaliacaoExterna = $codPictogramaAvaliacaoExterna;
        }
        public function getCodPictogramaAvaliacaoExterna()
        {
            return $this->codPictogramaAvaliacaoExterna;
        }

        public function setCodPictograma($codPictograma)
        {
            $this->codPictograma = $codPictograma;
        }
        public function getCodPictograma()
        {
            return $this->codPictograma;
        }

        public function setCodPictogramaAvaliacaoExternaOpcao($codPictogramaAvaliacaoExternaOpcao)
        {
            $this->codPictogramaAvaliacaoExternaOpcao = $codPictogramaAvaliacaoExternaOpcao;
        }
        public function getCodPictogramaAvaliacaoExternaOpcao()
        {
            return $this->codPictogramaAvaliacaoExternaOpcao;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codPictogramaAvaliacaoExterna,codPictograma,codPictogramaAvaliacaoExternaOpcao) VALUES (:codPictogramaAvaliacaoExterna,:codPictograma,:codPictogramaAvaliacaoExternaOpcao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExterna", $this->getCodPictogramaAvaliacaoExterna());
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":codPictogramaAvaliacaoExternaOpcao", $this->getCodPictogramaAvaliacaoExternaOpcao());
                $sql->execute();
                $this->setCodPictogramaAvaliacaoExternaItem(MySql::ultimoCodigoInserido());
                return "Opção incluida com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir PictogramaAvaliacaoExternaItem". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codPictogramaAvaliacaoExterna = :codPictogramaAvaliacaoExterna, codPictograma = :codPictograma, codPictogramaAvaliacaoExternaOpcao = :codPictogramaAvaliacaoExternaOpcao WHERE codPictogramaAvaliacaoExternaItem = :codPictogramaAvaliacaoExternaItem;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaItem", $this->getCodPictogramaAvaliacaoExternaItem());
                $sql->bindValue(":codPictogramaAvaliacaoExterna", $this->getCodPictogramaAvaliacaoExterna());
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":codPictogramaAvaliacaoExternaOpcao", $this->getCodPictogramaAvaliacaoExternaOpcao());
                $sql->execute();
                return "PictogramaAvaliacaoExternaItem alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar PictogramaAvaliacaoExternaItem". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExternaItem = :codPictogramaAvaliacaoExternaItem;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaItem", $this->getCodPictogramaAvaliacaoExternaItem());
                $sql->execute();
                return "PictogramaAvaliacaoExternaItem excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir PictogramaAvaliacaoExternaItem" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExternaItem = :codPictogramaAvaliacaoExternaItem LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaItem", $this->getCodPictogramaAvaliacaoExternaItem());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaAvaliacaoExternaItem']) && !empty($row['codPictogramaAvaliacaoExternaItem'])) {
                    $this->setCodPictogramaAvaliacaoExternaItem($row['codPictogramaAvaliacaoExternaItem']);
                    $this->setCodPictogramaAvaliacaoExterna($row['codPictogramaAvaliacaoExterna']);
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setCodPictogramaAvaliacaoExternaOpcao($row['codPictogramaAvaliacaoExternaOpcao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExternaItem" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictogramaAvaliacaoExternaItem'] = $this->getCodPictogramaAvaliacaoExternaItem();
                $array['codPictogramaAvaliacaoExterna'] = $this->getCodPictogramaAvaliacaoExterna();
                $array['codPictograma'] = $this->getCodPictograma();
                $array['codPictogramaAvaliacaoExternaOpcao'] = $this->getCodPictogramaAvaliacaoExternaOpcao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExternaItem" . $e->getMessage(),1);
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
                    $esteObjeto = new PictogramaAvaliacaoExternaItem();
                    $esteObjeto->setCodPictogramaAvaliacaoExternaItem($row['codPictogramaAvaliacaoExternaItem']);
                    $esteObjeto->setCodPictogramaAvaliacaoExterna($row['codPictogramaAvaliacaoExterna']);
                    $esteObjeto->setCodPictograma($row['codPictograma']);
                    $esteObjeto->setCodPictogramaAvaliacaoExternaOpcao($row['codPictogramaAvaliacaoExternaOpcao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os PictogramaAvaliacaoExternaItems" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPictogramaAvaliacaoExternaItem",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictogramaAvaliacaoExternaItem'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPictogramaAvaliacaoExternaItem'] || ( is_array($selecionado) && in_array($row['codPictogramaAvaliacaoExternaItem'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPictogramaAvaliacaoExternaItem']."'>".$row['codPictogramaAvaliacaoExterna']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo PictogramaAvaliacaoExternaItem" . $e->getMessage(),1);
            }
        }
    }
}