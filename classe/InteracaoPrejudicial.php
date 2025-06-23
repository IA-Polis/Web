<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class InteracaoPrejudicial
    {
        private $banco;
        private $tabela = "interacaoPrejudicial";

        private $codInteracaoPrejudicial;
        private $nome;
        private $textoSubstituicao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodInteracaoPrejudicial($codInteracaoPrejudicial)
        {
            $this->codInteracaoPrejudicial = $codInteracaoPrejudicial;
        }
        public function getCodInteracaoPrejudicial()
        {
            return $this->codInteracaoPrejudicial;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }
        public function getNome()
        {
            return $this->nome;
        }

        public function setTextoSubstituicao($textoSubstituicao)
        {
            $this->textoSubstituicao = $textoSubstituicao;
        }
        public function getTextoSubstituicao()
        {
            return $this->textoSubstituicao;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (nome,textoSubstituicao) VALUES (:nome,:textoSubstituicao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":textoSubstituicao", $this->getTextoSubstituicao());
                $sql->execute();
                $this->setCodInteracaoPrejudicial(MySql::ultimoCodigoInserido());
                return "InteracaoPrejudicial incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir InteracaoPrejudicial". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome, textoSubstituicao = :textoSubstituicao WHERE codInteracaoPrejudicial = :codInteracaoPrejudicial;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":textoSubstituicao", $this->getTextoSubstituicao());
                $sql->execute();
                return "InteracaoPrejudicial alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar InteracaoPrejudicial". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codInteracaoPrejudicial = :codInteracaoPrejudicial;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->execute();
                return "InteracaoPrejudicial excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir InteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codInteracaoPrejudicial = :codInteracaoPrejudicial LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codInteracaoPrejudicial']) && !empty($row['codInteracaoPrejudicial'])) {
                    $this->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                    $this->setNome($row['nome']);
                    $this->setTextoSubstituicao($row['textoSubstituicao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o InteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codInteracaoPrejudicial'] = $this->getCodInteracaoPrejudicial();
                $array['nome'] = $this->getNome();
                $array['textoSubstituicao'] = $this->getTextoSubstituicao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o InteracaoPrejudicial" . $e->getMessage(),1);
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
                    $esteObjeto = new InteracaoPrejudicial();
                    $esteObjeto->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setTextoSubstituicao($row['textoSubstituicao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os InteracaoPrejudicials" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboInteracaoPrejudicial",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o interacaoPrejudicial'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codInteracaoPrejudicial'] || ( is_array($selecionado) && in_array($row['codInteracaoPrejudicial'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codInteracaoPrejudicial']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo InteracaoPrejudicial" . $e->getMessage(),1);
            }
        }
    }
}