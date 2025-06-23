<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class V3Contexto
    {
        private $banco;
        private $tabela = "v3Contexto";

        private $codContexto;
        private $texto;
        private $cidadaoNome;
        private $cidadaoSexo;
        private $codTipoParticipante;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodContexto($codContexto)
        {
            $this->codContexto = $codContexto;
        }
        public function getCodContexto()
        {
            return $this->codContexto;
        }

        public function setTexto($texto)
        {
            $this->texto = $texto;
        }
        public function getTexto()
        {
            return $this->texto;
        }

        public function setCidadaoNome($cidadaoNome)
        {
            $this->cidadaoNome = $cidadaoNome;
        }
        public function getCidadaoNome()
        {
            return $this->cidadaoNome;
        }

        public function setCidadaoSexo($cidadaoSexo)
        {
            $this->cidadaoSexo = $cidadaoSexo;
        }
        public function getCidadaoSexo()
        {
            return $this->cidadaoSexo;
        }

        public function setCodTipoParticipante($codTipoParticipante)
        {
            $this->codTipoParticipante = $codTipoParticipante;
        }
        public function getCodTipoParticipante()
        {
            return $this->codTipoParticipante;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (texto,cidadaoNome,cidadaoSexo,codTipoParticipante) VALUES (:texto,:cidadaoNome,:cidadaoSexo,:codTipoParticipante);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":texto", $this->getTexto());
                $sql->bindValue(":cidadaoNome", $this->getCidadaoNome());
                $sql->bindValue(":cidadaoSexo", $this->getCidadaoSexo());
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->execute();
                $this->setCodContexto(MySql::ultimoCodigoInserido());
                return "V3Contexto incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir V3Contexto". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET texto = :texto, cidadaoNome = :cidadaoNome, cidadaoSexo = :cidadaoSexo, codTipoParticipante = :codTipoParticipante WHERE codContexto = :codContexto;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->bindValue(":texto", $this->getTexto());
                $sql->bindValue(":cidadaoNome", $this->getCidadaoNome());
                $sql->bindValue(":cidadaoSexo", $this->getCidadaoSexo());
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->execute();
                return "V3Contexto alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar V3Contexto". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codContexto = :codContexto;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->execute();
                return "V3Contexto excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir V3Contexto" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codContexto = :codContexto LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codContexto", $this->getCodContexto());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codContexto']) && !empty($row['codContexto'])) {
                    $this->setCodContexto($row['codContexto']);
                    $this->setTexto($row['texto']);
                    $this->setCidadaoNome($row['cidadaoNome']);
                    $this->setCidadaoSexo($row['cidadaoSexo']);
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o V3Contexto" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codContexto'] = $this->getCodContexto();
                $array['texto'] = $this->getTexto();
                $array['cidadaoNome'] = $this->getCidadaoNome();
                $array['cidadaoSexo'] = $this->getCidadaoSexo();
                $array['codTipoParticipante'] = $this->getCodTipoParticipante();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o V3Contexto" . $e->getMessage(),1);
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
                    $esteObjeto = new V3Contexto();
                    $esteObjeto->setCodContexto($row['codContexto']);
                    $esteObjeto->setTexto($row['texto']);
                    $esteObjeto->setCidadaoNome($row['cidadaoNome']);
                    $esteObjeto->setCidadaoSexo($row['cidadaoSexo']);
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os V3Contextos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboV3Contexto",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o v3Contexto'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codContexto'] || ( is_array($selecionado) && in_array($row['codContexto'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codContexto']."'>".$row['texto']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo V3Contexto" . $e->getMessage(),1);
            }
        }
    }
}