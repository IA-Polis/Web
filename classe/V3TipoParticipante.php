<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class V3TipoParticipante
    {
        private $banco;
        private $tabela = "v3TipoParticipante";

        private $codTipoParticipante;
        private $nome;
        private $descricao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodTipoParticipante($codTipoParticipante)
        {
            $this->codTipoParticipante = $codTipoParticipante;
        }
        public function getCodTipoParticipante()
        {
            return $this->codTipoParticipante;
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
                $this->setCodTipoParticipante(MySql::ultimoCodigoInserido());
                return "TipoParticipante incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir TipoParticipante". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome, descricao = :descricao WHERE codTipoParticipante = :codTipoParticipante;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":descricao", $this->getDescricao());
                $sql->execute();
                return "TipoParticipante alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar TipoParticipante". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codTipoParticipante = :codTipoParticipante;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->execute();
                return "TipoParticipante excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir TipoParticipante" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codTipoParticipante = :codTipoParticipante LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codTipoParticipante']) && !empty($row['codTipoParticipante'])) {
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                    $this->setNome($row['nome']);
                    $this->setDescricao($row['descricao']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o TipoParticipante" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codTipoParticipante'] = $this->getCodTipoParticipante();
                $array['nome'] = $this->getNome();
                $array['descricao'] = $this->getDescricao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o TipoParticipante" . $e->getMessage(),1);
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
                    $esteObjeto = new TipoParticipante();
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setDescricao($row['descricao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os TipoParticipantes" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboTipoParticipante",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o tipoParticipante'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codTipoParticipante'] || ( is_array($selecionado) && in_array($row['codTipoParticipante'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codTipoParticipante']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo TipoParticipante" . $e->getMessage(),1);
            }
        }
    }
}