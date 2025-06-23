<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class PictogramaCategoria
    {
        private $banco;
        private $tabela = "pictogramaCategoria";

        private $codPictogramaCategoria;
        private $nome;
        private $descricao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictogramaCategoria($codPictogramaCategoria)
        {
            $this->codPictogramaCategoria = $codPictogramaCategoria;
        }
        public function getCodPictogramaCategoria()
        {
            return $this->codPictogramaCategoria;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }
        public function getNome()
        {
            return $this->nome;
        }

        public function setDescricao($descricao)
        {
            $this->descricao = $descricao;
        }
        public function getDescricao()
        {
            return $this->descricao;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (nome,descricao) VALUES (:nome,:descricao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":descricao", $this->getDescricao());
                $sql->execute();
                $this->setCodPictogramaCategoria(MySql::ultimoCodigoInserido());
                return "PictogramaCategoria incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir PictogramaCategoria". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome, descricao = :descricao WHERE codPictogramaCategoria = :codPictogramaCategoria;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaCategoria", $this->getCodPictogramaCategoria());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":descricao", $this->getDescricao());
                $sql->execute();
                return "PictogramaCategoria alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar PictogramaCategoria". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaCategoria = :codPictogramaCategoria;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaCategoria", $this->getCodPictogramaCategoria());
                $sql->execute();
                return "PictogramaCategoria excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir PictogramaCategoria" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPictogramaCategoria = :codPictogramaCategoria LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaCategoria", $this->getCodPictogramaCategoria());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaCategoria']) && !empty($row['codPictogramaCategoria'])) {
                    $this->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $this->setNome($row['nome']);
                    $this->setDescricao($row['descricao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaCategoria" . $e->getMessage(),1);
            }
        }

        public function carregarPeloNome()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE nome = :nome LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPictogramaCategoria']) && !empty($row['codPictogramaCategoria'])) {
                    $this->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $this->setNome($row['nome']);
                    $this->setDescricao($row['descricao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaCategoria" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictogramaCategoria'] = $this->getCodPictogramaCategoria();
                $array['nome'] = $this->getNome();
                $array['descricao'] = $this->getDescricao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o PictogramaCategoria" . $e->getMessage(),1);
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
                    $esteObjeto = new PictogramaCategoria();
                    $esteObjeto->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setDescricao($row['descricao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os PictogramaCategorias" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPictogramaCategoria",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictogramaCategoria'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPictogramaCategoria'] || ( is_array($selecionado) && in_array($row['codPictogramaCategoria'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPictogramaCategoria']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo PictogramaCategoria" . $e->getMessage(),1);
            }
        }
    }
}