<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class V3Distribuicao
    {
        private $banco;
        private $tabela = "v3Distribuicao";

        private $codDistribuicao;
        private $codPrompt;
        private $codTipoParticipante;
        private $codContexto;
        private $numero;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodDistribuicao($codDistribuicao)
        {
            $this->codDistribuicao = $codDistribuicao;
        }
        public function getCodDistribuicao()
        {
            return $this->codDistribuicao;
        }

        public function setCodPrompt($codPrompt)
        {
            $this->codPrompt = $codPrompt;
        }
        public function getCodPrompt()
        {
            return $this->codPrompt;
        }

        public function setCodTipoParticipante($codTipoParticipante)
        {
            $this->codTipoParticipante = $codTipoParticipante;
        }
        public function getCodTipoParticipante()
        {
            return $this->codTipoParticipante;
        }

        public function setCodContexto($codContexto)
        {
            $this->codContexto = $codContexto;
        }
        public function getCodContexto()
        {
            return $this->codContexto;
        }

        public function setNumero($numero)
        {
            $this->numero = $numero;
        }
        public function getNumero()
        {
            return $this->numero;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codPrompt,codTipoParticipante,codContexto,numero) VALUES (:codPrompt,:codTipoParticipante,:codContexto,:numero);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":numero", $this->getNumero());
                $sql->execute();
                $this->setCodDistribuicao(MySql::ultimoCodigoInserido());
                return "Distribuicao incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Distribuicao". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codPrompt = :codPrompt, codTipoParticipante = :codTipoParticipante, codContexto = :codContexto, numero = :numero WHERE codDistribuicao = :codDistribuicao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codDistribuicao", $this->getCodDistribuicao());
                $sql->bindValue(":codPrompt", $this->getCodPrompt());
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":numero", $this->getNumero());
                $sql->execute();
                return "Distribuicao alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Distribuicao". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codDistribuicao = :codDistribuicao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codDistribuicao", $this->getCodDistribuicao());
                $sql->execute();
                return "Distribuicao excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Distribuicao" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codDistribuicao = :codDistribuicao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codDistribuicao", $this->getCodDistribuicao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codDistribuicao']) && !empty($row['codDistribuicao'])) {
                    $this->setCodDistribuicao($row['codDistribuicao']);
                    $this->setCodPrompt($row['codPrompt']);
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                    $this->setCodContexto($row['codContexto']);
                    $this->setNumero($row['numero']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Distribuicao" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codDistribuicao'] = $this->getCodDistribuicao();
                $array['codPrompt'] = $this->getCodPrompt();
                $array['codTipoParticipante'] = $this->getCodTipoParticipante();
                $array['codContexto'] = $this->getCodContexto();
                $array['numero'] = $this->getNumero();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Distribuicao" . $e->getMessage(),1);
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
                    $esteObjeto = new Distribuicao();
                    $esteObjeto->setCodDistribuicao($row['codDistribuicao']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setNumero($row['numero']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Distribuicaos" . $e->getMessage(),1);
            }
        }

        public function carregarListaProximo($codTipoParticipante){
            try {
                $colObjeto = new phpCollection();
                $query = "
                        SELECT 
                            *
                        FROM
                            ".$this->banco.".".$this->tabela."
                        WHERE
                            codTipoParticipante = :codTipoParticipante
                                AND numero = (SELECT 
                                    d.numero
                                FROM
                                    ".$this->banco.".".$this->tabela." d
                                        LEFT JOIN
                                    (SELECT 
                                        numero, COUNT(*) AS frequencia
                                    FROM
                                        ".$this->banco.".v3Participante
                                    WHERE
                                        codTipoParticipante = :codTipoParticipante
                                    GROUP BY numero) p ON d.numero = p.numero
                                WHERE
                                    d.codTipoParticipante = :codTipoParticipante
                                ORDER BY COALESCE(p.frequencia, 0) ASC , d.numero ASC
                                LIMIT 1) 
                                ORDER BY RAND();
                ";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codTipoParticipante", $codTipoParticipante);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new V3Distribuicao();
                    $esteObjeto->setCodDistribuicao($row['codDistribuicao']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setNumero($row['numero']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Distribuicaos" . $e->getMessage(),1);
            }
        }

        public function carregarPeloNumero($numero,$codTipoParticipante)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE numero = :numero AND codTipoParticipante = :codTipoParticipante;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":numero", $numero);
                $sql->bindValue(":codTipoParticipante", $codTipoParticipante);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new V3Distribuicao();
                    $esteObjeto->setCodDistribuicao($row['codDistribuicao']);
                    $esteObjeto->setCodPrompt($row['codPrompt']);
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setNumero($row['numero']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Distribuicaos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboDistribuicao",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o distribuicao'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codDistribuicao'] || ( is_array($selecionado) && in_array($row['codDistribuicao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codDistribuicao']."'>".$row['codPrompt']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Distribuicao" . $e->getMessage(),1);
            }
        }
    }
}