<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class FormaFarmaceutica
    {
        private $banco;
        private $tabela = "formaFarmaceutica";

        private $codFormaFarmaceutica;
        private $formaFarmaceutica;
        private $formaFarmaceuticaFiltro;
        private $ativo;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodFormaFarmaceutica($codFormaFarmaceutica)
        {
            $this->codFormaFarmaceutica = $codFormaFarmaceutica;
        }
        public function getCodFormaFarmaceutica()
        {
            return $this->codFormaFarmaceutica;
        }

        public function setFormaFarmaceutica($formaFarmaceutica)
        {
            $this->formaFarmaceutica = $formaFarmaceutica;
        }
        public function getFormaFarmaceutica()
        {
            return $this->formaFarmaceutica;
        }

        public function setFormaFarmaceuticaFiltro($formaFarmaceuticaFiltro)
        {
            $this->formaFarmaceuticaFiltro = $formaFarmaceuticaFiltro;
        }
        public function getFormaFarmaceuticaFiltro()
        {
            return $this->formaFarmaceuticaFiltro;
        }

        public function setAtivo($ativo)
        {
            $this->ativo = $ativo;
        }
        public function getAtivo()
        {
            return $this->ativo;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (formaFarmaceutica,formaFarmaceuticaFiltro,ativo) VALUES (:formaFarmaceutica,:formaFarmaceuticaFiltro,:ativo);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":formaFarmaceutica", $this->getFormaFarmaceutica());
                $sql->bindValue(":formaFarmaceuticaFiltro", $this->getFormaFarmaceuticaFiltro());
                $sql->bindValue(":ativo", $this->getAtivo());
                $sql->execute();
                $this->setCodFormaFarmaceutica(MySql::ultimoCodigoInserido());
                return "FormaFarmaceutica incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir FormaFarmaceutica". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET formaFarmaceutica = :formaFarmaceutica, formaFarmaceuticaFiltro = :formaFarmaceuticaFiltro, ativo = :ativo WHERE codFormaFarmaceutica = :codFormaFarmaceutica;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codFormaFarmaceutica", $this->getCodFormaFarmaceutica());
                $sql->bindValue(":formaFarmaceutica", $this->getFormaFarmaceutica());
                $sql->bindValue(":formaFarmaceuticaFiltro", $this->getFormaFarmaceuticaFiltro());
                $sql->bindValue(":ativo", $this->getAtivo());
                $sql->execute();
                return "FormaFarmaceutica alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar FormaFarmaceutica". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codFormaFarmaceutica = :codFormaFarmaceutica;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codFormaFarmaceutica", $this->getCodFormaFarmaceutica());
                $sql->execute();
                return "FormaFarmaceutica excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir FormaFarmaceutica" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codFormaFarmaceutica = :codFormaFarmaceutica LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codFormaFarmaceutica", $this->getCodFormaFarmaceutica());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codFormaFarmaceutica']) && !empty($row['codFormaFarmaceutica'])) {
                    $this->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                    $this->setFormaFarmaceutica($row['formaFarmaceutica']);
                    $this->setFormaFarmaceuticaFiltro($row['formaFarmaceuticaFiltro']);
                    $this->setAtivo($row['ativo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o FormaFarmaceutica" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codFormaFarmaceutica'] = $this->getCodFormaFarmaceutica();
                $array['formaFarmaceutica'] = $this->getFormaFarmaceutica();
                $array['formaFarmaceuticaFiltro'] = $this->getFormaFarmaceuticaFiltro();
                $array['ativo'] = $this->getAtivo();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o FormaFarmaceutica" . $e->getMessage(),1);
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
                    $esteObjeto = new FormaFarmaceutica();
                    $esteObjeto->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                    $esteObjeto->setFormaFarmaceutica($row['formaFarmaceutica']);
                    $esteObjeto->setFormaFarmaceuticaFiltro($row['formaFarmaceuticaFiltro']);
                    $esteObjeto->setAtivo($row['ativo']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os FormaFarmaceuticas" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboFormaFarmaceutica",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o formaFarmaceutica'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codFormaFarmaceutica'] || ( is_array($selecionado) && in_array($row['codFormaFarmaceutica'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codFormaFarmaceutica']."'>".$row['formaFarmaceutica']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo FormaFarmaceutica" . $e->getMessage(),1);
            }
        }
    }
}