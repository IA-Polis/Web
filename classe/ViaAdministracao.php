<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class ViaAdministracao
    {
        private $banco;
        private $tabela = "viaAdministracao";

        private $codViaAdministracao;
        private $viaAdministracao;
        private $viaAdministracaoFiltro;
        private $ordem;

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

        public function setViaAdministracao($viaAdministracao)
        {
            $this->viaAdministracao = $viaAdministracao;
        }
        public function getViaAdministracao()
        {
            return $this->viaAdministracao;
        }

        public function setViaAdministracaoFiltro($viaAdministracaoFiltro)
        {
            $this->viaAdministracaoFiltro = $viaAdministracaoFiltro;
        }
        public function getViaAdministracaoFiltro()
        {
            return $this->viaAdministracaoFiltro;
        }

        public function setOrdem($ordem)
        {
            $this->ordem = $ordem;
        }
        public function getOrdem()
        {
            return $this->ordem;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (viaAdministracao,viaAdministracaoFiltro,ordem) VALUES (:viaAdministracao,:viaAdministracaoFiltro,:ordem);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":viaAdministracao", $this->getViaAdministracao());
                $sql->bindValue(":viaAdministracaoFiltro", $this->getViaAdministracaoFiltro());
                $sql->bindValue(":ordem", $this->getOrdem());
                $sql->execute();
                $this->setCodViaAdministracao(MySql::ultimoCodigoInserido());
                return "ViaAdministracao incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir ViaAdministracao". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET viaAdministracao = :viaAdministracao, viaAdministracaoFiltro = :viaAdministracaoFiltro, ordem = :ordem WHERE codViaAdministracao = :codViaAdministracao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":viaAdministracao", $this->getViaAdministracao());
                $sql->bindValue(":viaAdministracaoFiltro", $this->getViaAdministracaoFiltro());
                $sql->bindValue(":ordem", $this->getOrdem());
                $sql->execute();
                return "ViaAdministracao alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar ViaAdministracao". $e->getMessage(),1);
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
                return "ViaAdministracao excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir ViaAdministracao" . $e->getMessage(),1);
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
                    $this->setViaAdministracao($row['viaAdministracao']);
                    $this->setViaAdministracaoFiltro($row['viaAdministracaoFiltro']);
                    $this->setOrdem($row['ordem']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ViaAdministracao" . $e->getMessage(),1);
            }
        }

        public function carregarPelaViaAdministracao()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE viaAdministracao LIKE :viaAdministracao OR viaAdministracaoFiltro LIKE :viaAdministracao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":viaAdministracao", "%".$this->getViaAdministracao()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codViaAdministracao']) && !empty($row['codViaAdministracao'])) {
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setViaAdministracao($row['viaAdministracao']);
                    $this->setViaAdministracaoFiltro($row['viaAdministracaoFiltro']);
                    $this->setOrdem($row['ordem']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ViaAdministracao" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['viaAdministracao'] = $this->getViaAdministracao();
                $array['viaAdministracaoFiltro'] = $this->getViaAdministracaoFiltro();
                $array['ordem'] = $this->getOrdem();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o ViaAdministracao" . $e->getMessage(),1);
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
                    $esteObjeto = new ViaAdministracao();
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setViaAdministracao($row['viaAdministracao']);
                    $esteObjeto->setViaAdministracaoFiltro($row['viaAdministracaoFiltro']);
                    $esteObjeto->setOrdem($row['ordem']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os ViaAdministracaos" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboViaAdministracao",$multiplo = '',$listaVia = "")
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione a via de administração'>";
                if($listaVia) $listaVia = " AND codViaAdministracao IN (".$listaVia.")";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE 1=1 $listaVia;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codViaAdministracao'] || ( is_array($selecionado) && in_array($row['codViaAdministracao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codViaAdministracao']."'>".$row['viaAdministracao']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo ViaAdministracao" . $e->getMessage(),1);
            }
        }
    }
}