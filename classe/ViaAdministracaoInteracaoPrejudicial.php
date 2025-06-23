<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class ViaAdministracaoInteracaoPrejudicial
    {
        private $banco;
        private $tabela = "viaAdministracaoInteracaoPrejudicial";

        private $codViaAdministracao;
        private $codInteracaoPrejudicial;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodViaAdministracao($codViaAdministracao)
        {
            $this->codViaAdministracao = $codViaAdministracao;
        }
        public function getCodViaAdministracao()
        {
            return $this->codViaAdministracao;
        }

        public function setCodInteracaoPrejudicial($codInteracaoPrejudicial)
        {
            $this->codInteracaoPrejudicial = $codInteracaoPrejudicial;
        }
        public function getCodInteracaoPrejudicial()
        {
            return $this->codInteracaoPrejudicial;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codInteracaoPrejudicial) VALUES (:codInteracaoPrejudicial);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->execute();
                $this->setCodViaAdministracao(MySql::ultimoCodigoInserido());
                return "ViaAdministracaoInteracaoPrejudicial incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir ViaAdministracaoInteracaoPrejudicial". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codInteracaoPrejudicial = :codInteracaoPrejudicial WHERE codViaAdministracao = :codViaAdministracao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->execute();
                return "ViaAdministracaoInteracaoPrejudicial alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar ViaAdministracaoInteracaoPrejudicial". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codViaAdministracao = :codViaAdministracao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->execute();
                return "ViaAdministracaoInteracaoPrejudicial excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir ViaAdministracaoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codViaAdministracao = :codViaAdministracao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codViaAdministracao']) && !empty($row['codViaAdministracao'])) {
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ViaAdministracaoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['codInteracaoPrejudicial'] = $this->getCodInteracaoPrejudicial();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ViaAdministracaoInteracaoPrejudicial" . $e->getMessage(),1);
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
                    $esteObjeto = new ViaAdministracaoInteracaoPrejudicial();
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os ViaAdministracaoInteracaoPrejudicials" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboViaAdministracaoInteracaoPrejudicial",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o viaAdministracaoInteracaoPrejudicial'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codViaAdministracao'] || ( is_array($selecionado) && in_array($row['codViaAdministracao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codViaAdministracao']."'>".$row['codInteracaoPrejudicial']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo ViaAdministracaoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }
    }
}