<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class SugestaoHorario
    {
        private $banco;
        private $tabela = "sugestaoHorario";

        private $codSugestaoHorario;
        private $nome;
        private $retorno;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodSugestaoHorario($codSugestaoHorario)
        {
            $this->codSugestaoHorario = $codSugestaoHorario;
        }
        public function getCodSugestaoHorario()
        {
            return $this->codSugestaoHorario;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }
        public function getNome()
        {
            return $this->nome;
        }

        public function setRetorno($retorno)
        {
            $this->retorno = $retorno;
        }
        public function getRetorno()
        {
            return $this->retorno;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (nome,retorno) VALUES (:nome,:retorno);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":retorno", $this->getRetorno());
                $sql->execute();
                $this->setCodSugestaoHorario(MySql::ultimoCodigoInserido());
                return "SugestaoHorario incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir SugestaoHorario". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome, retorno = :retorno WHERE codSugestaoHorario = :codSugestaoHorario;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSugestaoHorario", $this->getCodSugestaoHorario());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":retorno", $this->getRetorno());
                $sql->execute();
                return "SugestaoHorario alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar SugestaoHorario". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codSugestaoHorario = :codSugestaoHorario;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSugestaoHorario", $this->getCodSugestaoHorario());
                $sql->execute();
                return "SugestaoHorario excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir SugestaoHorario" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codSugestaoHorario = :codSugestaoHorario LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codSugestaoHorario", $this->getCodSugestaoHorario());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codSugestaoHorario']) && !empty($row['codSugestaoHorario'])) {
                    $this->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $this->setNome($row['nome']);
                    $this->setRetorno($row['retorno']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o SugestaoHorario" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codSugestaoHorario'] = $this->getCodSugestaoHorario();
                $array['nome'] = $this->getNome();
                $array['retorno'] = $this->getRetorno();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o SugestaoHorario" . $e->getMessage(),1);
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
                    $esteObjeto = new SugestaoHorario();
                    $esteObjeto->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setRetorno($row['retorno']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os SugestaoHorarios" . $e->getMessage(),1);
            }
        }

        public function buscarPeloNome($texto)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    if (strpos($texto, $row['nome']) !== false) {
                        $this->setCodSugestaoHorario($row['codSugestaoHorario']);
                        $this->setNome($row['nome']);
                        $this->setRetorno($row['retorno']);
                        return $colObjeto;
                    }
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os SugestaoHorarios" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboSugestaoHorario",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o sugestaoHorario'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codSugestaoHorario'] || ( is_array($selecionado) && in_array($row['codSugestaoHorario'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codSugestaoHorario']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo SugestaoHorario" . $e->getMessage(),1);
            }
        }
    }
}