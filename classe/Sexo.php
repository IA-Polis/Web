<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Sexo
    {
        private $banco;
        private $tabela = "sexo";

        private $codSexo;
        private $nome;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodSexo($codSexo)
        {
            $this->codSexo = $codSexo;
        }
        public function getCodSexo()
        {
            return $this->codSexo;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }
        public function getNome()
        {
            return $this->nome;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (nome) VALUES (:nome);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->execute();
                $this->setCodSexo(MySql::ultimoCodigoInserido());
                return "Sexo incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Sexo". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome WHERE codSexo = :codSexo;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSexo", $this->getCodSexo());
                $sql->bindValue(":nome", $this->getNome());
                $sql->execute();
                return "Sexo alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Sexo". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codSexo = :codSexo;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSexo", $this->getCodSexo());
                $sql->execute();
                return "Sexo excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Sexo" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codSexo = :codSexo LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSexo", $this->getCodSexo());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codSexo']) && !empty($row['codSexo'])) {
                    $this->setCodSexo($row['codSexo']);
                    $this->setNome($row['nome']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Sexo" . $e->getMessage(),1);
            }
        }

        public function carregarPeloSexo()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE nome LIKE :nome LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", "%".$this->getNome()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codSexo']) && !empty($row['codSexo'])) {
                    $this->setCodSexo($row['codSexo']);
                    $this->setNome($row['nome']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Sexo" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codSexo'] = $this->getCodSexo();
                $array['nome'] = $this->getNome();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Sexo" . $e->getMessage(),1);
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
                    $esteObjeto = new Sexo();
                    $esteObjeto->setCodSexo($row['codSexo']);
                    $esteObjeto->setNome($row['nome']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Sexos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboSexo",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o sexo'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codSexo'] || ( is_array($selecionado) && in_array($row['codSexo'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codSexo']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Sexo" . $e->getMessage(),1);
            }
        }
    }
}