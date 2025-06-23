<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class PictogramaAvaliacaoExternaOpcao
    {
        private $banco;
        private $tabela = "pictogramaAvaliacaoExternaOpcao";

        private $codPictogramaAvaliacaoExternaOpcao;
        private $codPictograma;
        private $texto;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictogramaAvaliacaoExternaOpcao($codPictogramaAvaliacaoExternaOpcao)
        {
            $this->codPictogramaAvaliacaoExternaOpcao = $codPictogramaAvaliacaoExternaOpcao;
        }
        public function getCodPictogramaAvaliacaoExternaOpcao()
        {
            return $this->codPictogramaAvaliacaoExternaOpcao;
        }

        public function setCodPictograma($codPictograma)
        {
            $this->codPictograma = $codPictograma;
        }
        public function getCodPictograma()
        {
            return $this->codPictograma;
        }

        public function setTexto($texto)
        {
            $this->texto = $texto;
        }
        public function getTexto()
        {
            return $this->texto;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codPictograma,texto) VALUES (:codPictograma,:texto);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":texto", $this->getTexto());
                $sql->execute();
                $this->setCodPictogramaAvaliacaoExternaOpcao(MySql::ultimoCodigoInserido());
                return "PictogramaAvaliacaoExternaOpcao incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir PictogramaAvaliacaoExternaOpcao". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codPictograma = :codPictograma, texto = :texto WHERE codPictogramaAvaliacaoExternaOpcao = :codPictogramaAvaliacaoExternaOpcao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaOpcao", $this->getCodPictogramaAvaliacaoExternaOpcao());
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":texto", $this->getTexto());
                $sql->execute();
                return "PictogramaAvaliacaoExternaOpcao alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar PictogramaAvaliacaoExternaOpcao". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExternaOpcao = :codPictogramaAvaliacaoExternaOpcao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaOpcao", $this->getCodPictogramaAvaliacaoExternaOpcao());
                $sql->execute();
                return "PictogramaAvaliacaoExternaOpcao excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir PictogramaAvaliacaoExternaOpcao" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExternaOpcao = :codPictogramaAvaliacaoExternaOpcao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExternaOpcao", $this->getCodPictogramaAvaliacaoExternaOpcao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaAvaliacaoExternaOpcao']) && !empty($row['codPictogramaAvaliacaoExternaOpcao'])) {
                    $this->setCodPictogramaAvaliacaoExternaOpcao($row['codPictogramaAvaliacaoExternaOpcao']);
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setTexto($row['texto']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExternaOpcao" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictogramaAvaliacaoExternaOpcao'] = $this->getCodPictogramaAvaliacaoExternaOpcao();
                $array['codPictograma'] = $this->getCodPictograma();
                $array['texto'] = $this->getTexto();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExternaOpcao" . $e->getMessage(),1);
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
                    $esteObjeto = new PictogramaAvaliacaoExternaOpcao();
                    $esteObjeto->setCodPictogramaAvaliacaoExternaOpcao($row['codPictogramaAvaliacaoExternaOpcao']);
                    $esteObjeto->setCodPictograma($row['codPictograma']);
                    $esteObjeto->setTexto($row['texto']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os PictogramaAvaliacaoExternaOpcaos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPictogramaAvaliacaoExternaOpcao",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictogramaAvaliacaoExternaOpcao'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPictogramaAvaliacaoExternaOpcao'] || ( is_array($selecionado) && in_array($row['codPictogramaAvaliacaoExternaOpcao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPictogramaAvaliacaoExternaOpcao']."'>".$row['codPictograma']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo PictogramaAvaliacaoExternaOpcao" . $e->getMessage(),1);
            }
        }
    }
}