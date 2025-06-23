<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Escolaridade
    {
        private $banco;
        private $tabela = "escolaridade";

        private $codEscolaridade;
        private $escolaridade;
        private $escolaridadeFiltro;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodEscolaridade($codEscolaridade)
        {
            $this->codEscolaridade = $codEscolaridade;
        }
        public function getCodEscolaridade()
        {
            return $this->codEscolaridade;
        }

        public function setEscolaridade($escolaridade)
        {
            $this->escolaridade = $escolaridade;
        }
        public function getEscolaridade()
        {
            return $this->escolaridade;
        }

        public function setEscolaridadeFiltro($escolaridadeFiltro)
        {
            $this->escolaridadeFiltro = $escolaridadeFiltro;
        }
        public function getEscolaridadeFiltro()
        {
            return $this->escolaridadeFiltro;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (escolaridade,escolaridadeFiltro) VALUES (:escolaridade,:escolaridadeFiltro);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":escolaridade", $this->getEscolaridade());
                $sql->bindValue(":escolaridadeFiltro", $this->getEscolaridadeFiltro());
                $sql->execute();
                $this->setCodEscolaridade(MySql::ultimoCodigoInserido());
                return "Escolaridade incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Escolaridade". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET escolaridade = :escolaridade, escolaridadeFiltro = :escolaridadeFiltro WHERE codEscolaridade = :codEscolaridade;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codEscolaridade", $this->getCodEscolaridade());
                $sql->bindValue(":escolaridade", $this->getEscolaridade());
                $sql->bindValue(":escolaridadeFiltro", $this->getEscolaridadeFiltro());
                $sql->execute();
                return "Escolaridade alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Escolaridade". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codEscolaridade = :codEscolaridade;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codEscolaridade", $this->getCodEscolaridade());
                $sql->execute();
                return "Escolaridade excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Escolaridade" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codEscolaridade = :codEscolaridade LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codEscolaridade", $this->getCodEscolaridade());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codEscolaridade']) && !empty($row['codEscolaridade'])) {
                    $this->setCodEscolaridade($row['codEscolaridade']);
                    $this->setEscolaridade($row['escolaridade']);
                    $this->setEscolaridadeFiltro($row['escolaridadeFiltro']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Escolaridade" . $e->getMessage(),1);
            }
        }

        public function carregarPelaEscolaridade()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE escolaridade LIKE :escolaridade LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":escolaridade","%".$this->getEscolaridade()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codEscolaridade']) && !empty($row['codEscolaridade'])) {
                    $this->setCodEscolaridade($row['codEscolaridade']);
                    $this->setEscolaridade($row['escolaridade']);
                    $this->setEscolaridadeFiltro($row['escolaridadeFiltro']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Escolaridade" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codEscolaridade'] = $this->getCodEscolaridade();
                $array['escolaridade'] = $this->getEscolaridade();
                $array['escolaridadeFiltro'] = $this->getEscolaridadeFiltro();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Escolaridade" . $e->getMessage(),1);
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
                    $esteObjeto = new Escolaridade();
                    $esteObjeto->setCodEscolaridade($row['codEscolaridade']);
                    $esteObjeto->setEscolaridade($row['escolaridade']);
                    $esteObjeto->setEscolaridadeFiltro($row['escolaridadeFiltro']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Escolaridades" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboEscolaridade",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o escolaridade'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codEscolaridade'] || ( is_array($selecionado) && in_array($row['codEscolaridade'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codEscolaridade']."'>".$row['escolaridade']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Escolaridade" . $e->getMessage(),1);
            }
        }
    }
}