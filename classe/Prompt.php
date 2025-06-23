<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception;

    class Prompt
    {
        private $banco;
        private $tabela = "prompt";

        private $codPrompt;
        private $imput;
        private $padrao;
        private $observacoes;
        private $rodada;
        private $tipo;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPrompt($codPrompt)
        {
            $this->codPrompt = $codPrompt;
        }
        public function getCodPrompt()
        {
            return $this->codPrompt;
        }

        public function setImput($imput)
        {
            $this->imput = $imput;
        }
        public function getImput()
        {
            return $this->imput;
        }

        public function setPadrao($padrao)
        {
            $this->padrao = $padrao;
        }
        public function getPadrao()
        {
            return $this->padrao;
        }

        public function setObservacoes($observacoes)
        {
            $this->observacoes = $observacoes;
        }
        public function getObservacoes()
        {
            return $this->observacoes;
        }

        public function setRodada($rodada)
        {
            $this->rodada = $rodada;
        }
        public function getRodada()
        {
            return $this->rodada;
        }

        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }
        public function getTipo()
        {
            return $this->tipo;
        }



        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (imput,padrao,observacoes,rodada,tipo) VALUES (:imput,:padrao,:observacoes,:rodada,:tipo);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":imput", $this->getImput());
                $sql->bindValue(":padrao", $this->getPadrao());
                $sql->bindValue(":observacoes", $this->getObservacoes());
                $sql->bindValue(":rodada", $this->getRodada());
                $sql->bindValue(":tipo", $this->getTipo());
                $sql->execute();
                $this->setCodPrompt(MySql::ultimoCodigoInserido());
                return "Prompt incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Prompt". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET imput = :imput, padrao = :padrao, observacoes = :observacoes, rodada = :rodada, tipo = :tipo WHERE codPrompt = :codPrompt;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":imput", $this->getImput());
                $sql->bindValue(":padrao", $this->getPadrao());
                $sql->bindValue(":observacoes", $this->getObservacoes());
                $sql->bindValue(":rodada", $this->getRodada());
                $sql->bindValue(":tipo", $this->getTipo());
                $sql->execute();
                return "Prompt alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Prompt". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->execute();
                return "Prompt excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Prompt" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrompt = :codPrompt LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrompt']) && !empty($row['codPrompt'])) {
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setImput($row['imput']);
                    $this->setPadrao($row['padrao']);
                    $this->setObservacoes($row['observacoes']);
                    $this->setRodada($row['rodada']);
                    $this->setTipo($row['tipo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prompt" . $e->getMessage(),1);
            }
        }
        public function carregarPadrao()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE padrao = 1 LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrompt']) && !empty($row['codPrompt'])) {
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setImput($row['imput']);
                    $this->setPadrao($row['padrao']);
                    $this->setObservacoes($row['observacoes']);
                    $this->setRodada($row['rodada']);
                    $this->setTipo($row['tipo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prompt" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPrompt'] = $this->getCodPrompt();
                $array['imput'] = $this->getImput();
                $array['padrao'] = $this->getPadrao();
                $array['observacoes'] = $this->getObservacoes();
                $array['rodada'] = $this->getRodada();
                $array['tipo'] = $this->getTipo();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prompt" . $e->getMessage(),1);
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
                    $esteObjeto = new Prompt();
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setImput($row['imput']);
                    $esteObjeto->setPadrao($row['padrao']);
                    $esteObjeto->setObservacoes($row['observacoes']);
                    $esteObjeto->setRodada($row['rodada']);
                    $esteObjeto->setTipo($row['tipo']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Prompts" . $e->getMessage(),1);
            }
        }

        public function carregarTodosV2()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrompt IN (SELECT codPrompt FROM ".$this->banco.".receituarioV2);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);

                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Prompt();
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setImput($row['imput']);
                    $esteObjeto->setPadrao($row['padrao']);
                    $esteObjeto->setObservacoes($row['observacoes']);
                    $esteObjeto->setRodada($row['rodada']);
                    $esteObjeto->setTipo($row['tipo']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Prompts" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboPrompt",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o prompt'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>";
                while($row = $sql->fetch()){
                    $saida	.= "<option ";
                    if ($selecionado == $row['codPrompt'] || ( is_array($selecionado) && in_array($row['codPrompt'],$selecionado)))	$saida	.= "selected ";
                    $saida	.= "value='".$row['codPrompt']."'>".$row['rodada']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Prompt" . $e->getMessage(),1);
            }
        }
    }
}