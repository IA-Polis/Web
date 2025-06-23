<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class MedicamentoInteracaoPrejudicial
    {
        private $banco;
        private $tabela = "medicamentoInteracaoPrejudicial";

        private $codMedicamento;
        private $codInteracaoPrejudicial;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodMedicamento($codMedicamento)
        {
            $this->codMedicamento = $codMedicamento;
        }
        public function getCodMedicamento()
        {
            return $this->codMedicamento;
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
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codMedicamento,codInteracaoPrejudicial) VALUES (:codMedicamento,:codInteracaoPrejudicial);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->execute();
                $this->setCodMedicamento(MySql::ultimoCodigoInserido());
                return "MedicamentoInteracaoPrejudicial incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir MedicamentoInteracaoPrejudicial". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->execute();
                return "MedicamentoInteracaoPrejudicial excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir MedicamentoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codInteracaoPrejudicial = :codInteracaoPrejudicial AND codMedicamento = :codMedicamento LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":codInteracaoPrejudicial", $this->getCodInteracaoPrejudicial());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                }else{
                    $this->setCodMedicamento(null);
                    $this->setCodInteracaoPrejudicial(null);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['codInteracaoPrejudicial'] = $this->getCodInteracaoPrejudicial();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o MedicamentoInteracaoPrejudicial" . $e->getMessage(),1);
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
                    $esteObjeto = new MedicamentoInteracaoPrejudicial();
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setCodInteracaoPrejudicial($row['codInteracaoPrejudicial']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os MedicamentoInteracaoPrejudicials" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboMedicamentoInteracaoPrejudicial",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o medicamentoInteracaoPrejudicial'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codMedicamento'] || ( is_array($selecionado) && in_array($row['codMedicamento'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codMedicamento']."'>".$row['codInteracaoPrejudicial']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo MedicamentoInteracaoPrejudicial" . $e->getMessage(),1);
            }
        }
    }
}