<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class PictogramaAvaliacaoCompreensibilidade
    {
        private $banco;
        private $tabela = "pictogramaAvaliacaoCompreensibilidade";

        private $codPictogramaAvaliacaoCompreensibilidade;
        private $codUsuario;
        private $codPictograma;
        private $significado;
        private $entendimento;
        private $dataInclusao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictogramaAvaliacaoCompreensibilidade($codPictogramaAvaliacaoCompreensibilidade)
        {
            $this->codPictogramaAvaliacaoCompreensibilidade = $codPictogramaAvaliacaoCompreensibilidade;
        }
        public function getCodPictogramaAvaliacaoCompreensibilidade()
        {
            return $this->codPictogramaAvaliacaoCompreensibilidade;
        }

        public function setCodUsuario($codUsuario)
        {
            $this->codUsuario = $codUsuario;
        }
        public function getCodUsuario()
        {
            return $this->codUsuario;
        }

        public function setCodPictograma($codPictograma)
        {
            $this->codPictograma = $codPictograma;
        }
        public function getCodPictograma()
        {
            return $this->codPictograma;
        }

        public function setSignificado($significado)
        {
            $this->significado = $significado;
        }
        public function getSignificado()
        {
            return $this->significado;
        }

        public function setEntendimento($entendimento)
        {
            $this->entendimento = $entendimento;
        }
        public function getEntendimento()
        {
            return $this->entendimento;
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
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codUsuario,codPictograma,significado,entendimento,dataInclusao) VALUES (:codUsuario,:codPictograma,:significado,:entendimento,:dataInclusao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":significado", $this->getSignificado());
                $sql->bindValue(":entendimento", $this->getEntendimento());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->execute();
                $this->setCodPictogramaAvaliacaoCompreensibilidade(MySql::ultimoCodigoInserido());
                return "PictogramaAvaliacaoCompreensibilidade incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir PictogramaAvaliacaoCompreensibilidade". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codUsuario = :codUsuario, codPictograma = :codPictograma, significado = :significado, entendimento = :entendimento, dataInclusao = :dataInclusao WHERE codPictogramaAvaliacaoCompreensibilidade = :codPictogramaAvaliacaoCompreensibilidade;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoCompreensibilidade", $this->getCodPictogramaAvaliacaoCompreensibilidade());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":significado", $this->getSignificado());
                $sql->bindValue(":entendimento", $this->getEntendimento());
                $sql->bindValue(":dataInclusao", $this->getDataInclusao());
                $sql->execute();
                return "PictogramaAvaliacaoCompreensibilidade alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar PictogramaAvaliacaoCompreensibilidade". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoCompreensibilidade = :codPictogramaAvaliacaoCompreensibilidade;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoCompreensibilidade", $this->getCodPictogramaAvaliacaoCompreensibilidade());
                $sql->execute();
                return "PictogramaAvaliacaoCompreensibilidade excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir PictogramaAvaliacaoCompreensibilidade" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaAvaliacaoCompreensibilidade = :codPictogramaAvaliacaoCompreensibilidade LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaAvaliacaoCompreensibilidade", $this->getCodPictogramaAvaliacaoCompreensibilidade());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaAvaliacaoCompreensibilidade']) && !empty($row['codPictogramaAvaliacaoCompreensibilidade'])) {
                    $this->setCodPictogramaAvaliacaoCompreensibilidade($row['codPictogramaAvaliacaoCompreensibilidade']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setSignificado($row['significado']);
                    $this->setEntendimento($row['entendimento']);
                    $this->setDataInclusao($row['dataInclusao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoCompreensibilidade" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictogramaAvaliacaoCompreensibilidade'] = $this->getCodPictogramaAvaliacaoCompreensibilidade();
                $array['codUsuario'] = $this->getCodUsuario();
                $array['codPictograma'] = $this->getCodPictograma();
                $array['significado'] = $this->getSignificado();
                $array['entendimento'] = $this->getEntendimento();
                $array['dataInclusao'] = $this->getDataInclusao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaAvaliacaoCompreensibilidade" . $e->getMessage(),1);
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
                    $esteObjeto = new PictogramaAvaliacaoCompreensibilidade();
                    $esteObjeto->setCodPictogramaAvaliacaoCompreensibilidade($row['codPictogramaAvaliacaoCompreensibilidade']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodPictograma($row['codPictograma']);
                    $esteObjeto->setSignificado($row['significado']);
                    $esteObjeto->setEntendimento($row['entendimento']);
                    $esteObjeto->setDataInclusao($row['dataInclusao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os PictogramaAvaliacaoCompreensibilidades" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPictogramaAvaliacaoCompreensibilidade",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictogramaAvaliacaoCompreensibilidade'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPictogramaAvaliacaoCompreensibilidade'] || ( is_array($selecionado) && in_array($row['codPictogramaAvaliacaoCompreensibilidade'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPictogramaAvaliacaoCompreensibilidade']."'>".$row['codUsuario']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo PictogramaAvaliacaoCompreensibilidade" . $e->getMessage(),1);
            }
        }
    }
}