<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class PictogramaAvaliacaoExterna
    {
        private $banco;
        private $tabela = "pictogramaAvaliacaoExterna";

        private $codPictogramaAvaliacaoExterna;
        private $idade;
        private $genero;
        private $escolaridade;
        private $dataInclusao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictogramaAvaliacaoExterna($codPictogramaAvaliacaoExterna)
        {
            $this->codPictogramaAvaliacaoExterna = $codPictogramaAvaliacaoExterna;
        }
        public function getCodPictogramaAvaliacaoExterna()
        {
            return $this->codPictogramaAvaliacaoExterna;
        }

        public function setIdade($idade)
        {
            $this->idade = $idade;
        }
        public function getIdade()
        {
            return $this->idade;
        }

        public function setGenero($genero)
        {
            $this->genero = $genero;
        }
        public function getGenero()
        {
            return $this->genero;
        }

        public function setEscolaridade($escolaridade)
        {
            $this->escolaridade = $escolaridade;
        }
        public function getEscolaridade()
        {
            return $this->escolaridade;
        }

        public function setDataInclusao($dataInclusao)
        {
            $this->dataInclusao = $dataInclusao;
        }
        public function getDataInclusao()
        {
            return $this->dataInclusao;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (idade,genero,escolaridade,dataInclusao) VALUES (:idade,:genero,:escolaridade,:dataInclusao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":idade", $this->getIdade());
                $sql->bindValue(":genero", $this->getGenero());
                $sql->bindValue(":escolaridade", $this->getEscolaridade());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->execute();
                $this->setCodPictogramaAvaliacaoExterna(MySql::ultimoCodigoInserido());
                return "PictogramaAvaliacaoExterna incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir PictogramaAvaliacaoExterna". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET idade = :idade, genero = :genero, escolaridade = :escolaridade, dataInclusao = :dataInclusao WHERE codPictogramaAvaliacaoExterna = :codPictogramaAvaliacaoExterna;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExterna", $this->getCodPictogramaAvaliacaoExterna());
                $sql->bindValue(":idade", $this->getIdade());
                $sql->bindValue(":genero", $this->getGenero());
                $sql->bindValue(":escolaridade", $this->getEscolaridade());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->execute();
                return "PictogramaAvaliacaoExterna alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar PictogramaAvaliacaoExterna". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExterna = :codPictogramaAvaliacaoExterna;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExterna", $this->getCodPictogramaAvaliacaoExterna());
                $sql->execute();
                return "PictogramaAvaliacaoExterna excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir PictogramaAvaliacaoExterna" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoExterna = :codPictogramaAvaliacaoExterna LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoExterna", $this->getCodPictogramaAvaliacaoExterna());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaAvaliacaoExterna']) && !empty($row['codPictogramaAvaliacaoExterna'])) {
                    $this->setCodPictogramaAvaliacaoExterna($row['codPictogramaAvaliacaoExterna']);
                    $this->setIdade($row['idade']);
                    $this->setGenero($row['genero']);
                    $this->setEscolaridade($row['escolaridade']);
                    $this->setDataInclusao($row['dataInclusao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExterna" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictogramaAvaliacaoExterna'] = $this->getCodPictogramaAvaliacaoExterna();
                $array['idade'] = $this->getIdade();
                $array['genero'] = $this->getGenero();
                $array['escolaridade'] = $this->getEscolaridade();
                $array['dataInclusao'] = $this->getDataInclusao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoExterna" . $e->getMessage(),1);
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
                    $esteObjeto = new PictogramaAvaliacaoExterna();
                    $esteObjeto->setCodPictogramaAvaliacaoExterna($row['codPictogramaAvaliacaoExterna']);
                    $esteObjeto->setIdade($row['idade']);
                    $esteObjeto->setGenero($row['genero']);
                    $esteObjeto->setEscolaridade($row['escolaridade']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os PictogramaAvaliacaoExternas" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPictogramaAvaliacaoExterna",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictogramaAvaliacaoExterna'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPictogramaAvaliacaoExterna'] || ( is_array($selecionado) && in_array($row['codPictogramaAvaliacaoExterna'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPictogramaAvaliacaoExterna']."'>".$row['idade']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo PictogramaAvaliacaoExterna" . $e->getMessage(),1);
            }
        }
    }
}