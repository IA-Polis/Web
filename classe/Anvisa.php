<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Anvisa
    {
        private $banco;
        private $tabela = "anvisa";

        private $idProduto;
        private $numeroRegistro;
        private $nomeProduto;
        private $principioAtivo;
        private $numProcesso;
        private $categoriaRegulatoria;
        private $apresentacao;
        private $principiosAtivos;
        private $viasAdministracao;
        private $razaoSocial;
        private $cnpj;
        private $dataRegistro;
        private $dataVencimentoRegistro;
        private $dataAtualizacao;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setIdProduto($idProduto)
        {
            $this->idProduto = $idProduto;
        }
        public function getIdProduto()
        {
            return $this->idProduto;
        }

        public function setNumeroRegistro($numeroRegistro)
        {
            $this->numeroRegistro = $numeroRegistro;
        }
        public function getNumeroRegistro()
        {
            return $this->numeroRegistro;
        }

        public function setNomeProduto($nomeProduto)
        {
            $this->nomeProduto = $nomeProduto;
        }
        public function getNomeProduto()
        {
            return $this->nomeProduto;
        }

        public function setPrincipioAtivo($principioAtivo)
        {
            $this->principioAtivo = $principioAtivo;
        }
        public function getPrincipioAtivo()
        {
            return $this->principioAtivo;
        }

        public function setNumProcesso($numProcesso)
        {
            $this->numProcesso = $numProcesso;
        }
        public function getNumProcesso()
        {
            return $this->numProcesso;
        }

        public function setCategoriaRegulatoria($categoriaRegulatoria)
        {
            $this->categoriaRegulatoria = $categoriaRegulatoria;
        }
        public function getCategoriaRegulatoria()
        {
            return $this->categoriaRegulatoria;
        }

        public function setApresentacao($apresentacao)
        {
            $this->apresentacao = $apresentacao;
        }
        public function getApresentacao()
        {
            return $this->apresentacao;
        }

        public function setPrincipiosAtivos($principiosAtivos)
        {
            $this->principiosAtivos = $principiosAtivos;
        }
        public function getPrincipiosAtivos()
        {
            return $this->principiosAtivos;
        }

        public function setViasAdministracao($viasAdministracao)
        {
            $this->viasAdministracao = $viasAdministracao;
        }
        public function getViasAdministracao()
        {
            return $this->viasAdministracao;
        }

        public function setRazaoSocial($razaoSocial)
        {
            $this->razaoSocial = $razaoSocial;
        }
        public function getRazaoSocial()
        {
            return $this->razaoSocial;
        }

        public function setCnpj($cnpj)
        {
            $this->cnpj = $cnpj;
        }
        public function getCnpj()
        {
            return $this->cnpj;
        }

        public function setDataRegistro($dataRegistro)
        {
            $this->dataRegistro = $dataRegistro;
        }
        public function getDataRegistro()
        {
            return $this->dataRegistro;
        }

        public function setDataVencimentoRegistro($dataVencimentoRegistro)
        {
            $this->dataVencimentoRegistro = $dataVencimentoRegistro;
        }
        public function getDataVencimentoRegistro()
        {
            return $this->dataVencimentoRegistro;
        }

        public function setDataAtualizacao($dataAtualizacao)
        {
            $this->dataAtualizacao = $dataAtualizacao;
        }
        public function getDataAtualizacao()
        {
            return $this->dataAtualizacao;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (numeroRegistro,nomeProduto,principioAtivo,numProcesso,categoriaRegulatoria,apresentacao,principiosAtivos,viasAdministracao,razaoSocial,cnpj,dataRegistro,dataVencimentoRegistro,dataAtualizacao) VALUES (:numeroRegistro,:nomeProduto,:principioAtivo,:numProcesso,:categoriaRegulatoria,:apresentacao,:principiosAtivos,:viasAdministracao,:razaoSocial,:cnpj,:dataRegistro,:dataVencimentoRegistro,:dataAtualizacao);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":numeroRegistro", $this->getNumeroRegistro());
                $sql->bindValue(":nomeProduto", $this->getNomeProduto());
                $sql->bindValue(":principioAtivo", $this->getPrincipioAtivo());
                $sql->bindValue(":numProcesso", $this->getNumProcesso());
                $sql->bindValue(":categoriaRegulatoria", $this->getCategoriaRegulatoria());
                $sql->bindValue(":apresentacao", $this->getApresentacao());
                $sql->bindValue(":principiosAtivos", $this->getPrincipiosAtivos());
                $sql->bindValue(":viasAdministracao", $this->getViasAdministracao());
                $sql->bindValue(":razaoSocial", $this->getRazaoSocial());
                $sql->bindValue(":cnpj", $this->getCnpj());
                $sql->bindValue(":dataRegistro", $this->getDataRegistro());
                $sql->bindValue(":dataVencimentoRegistro", $this->getDataVencimentoRegistro());
                $sql->bindValue(":dataAtualizacao", $this->getDataAtualizacao());
                $sql->execute();
                $this->setIdProduto(MySql::ultimoCodigoInserido());
                return "Anvisa incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Anvisa". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET numeroRegistro = :numeroRegistro, nomeProduto = :nomeProduto, principioAtivo = :principioAtivo, numProcesso = :numProcesso, categoriaRegulatoria = :categoriaRegulatoria, apresentacao = :apresentacao, principiosAtivos = :principiosAtivos, viasAdministracao = :viasAdministracao, razaoSocial = :razaoSocial, cnpj = :cnpj, dataRegistro = :dataRegistro, dataVencimentoRegistro = :dataVencimentoRegistro, dataAtualizacao = :dataAtualizacao WHERE idProduto = :idProduto;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->bindValue(":numeroRegistro", $this->getNumeroRegistro());
                $sql->bindValue(":nomeProduto", $this->getNomeProduto());
                $sql->bindValue(":principioAtivo", $this->getPrincipioAtivo());
                $sql->bindValue(":numProcesso", $this->getNumProcesso());
                $sql->bindValue(":categoriaRegulatoria", $this->getCategoriaRegulatoria());
                $sql->bindValue(":apresentacao", $this->getApresentacao());
                $sql->bindValue(":principiosAtivos", $this->getPrincipiosAtivos());
                $sql->bindValue(":viasAdministracao", $this->getViasAdministracao());
                $sql->bindValue(":razaoSocial", $this->getRazaoSocial());
                $sql->bindValue(":cnpj", $this->getCnpj());
                $sql->bindValue(":dataRegistro", $this->getDataRegistro());
                $sql->bindValue(":dataVencimentoRegistro", $this->getDataVencimentoRegistro());
                $sql->bindValue(":dataAtualizacao", $this->getDataAtualizacao());
                $sql->execute();
                return "Anvisa alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Anvisa". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE idProduto = :idProduto;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->execute();
                return "Anvisa excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Anvisa" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE idProduto = :idProduto LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":idProduto", $this->getIdProduto());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['idProduto']) && !empty($row['idProduto'])) {
                    $this->setIdProduto($row['idProduto']);
                    $this->setNumeroRegistro($row['numeroRegistro']);
                    $this->setNomeProduto($row['nomeProduto']);
                    $this->setPrincipioAtivo($row['principioAtivo']);
                    $this->setNumProcesso($row['numProcesso']);
                    $this->setCategoriaRegulatoria($row['categoriaRegulatoria']);
                    $this->setApresentacao($row['apresentacao']);
                    $this->setPrincipiosAtivos($row['principiosAtivos']);
                    $this->setViasAdministracao($row['viasAdministracao']);
                    $this->setRazaoSocial($row['razaoSocial']);
                    $this->setCnpj($row['cnpj']);
                    $this->setDataRegistro($row['dataRegistro']);
                    $this->setDataVencimentoRegistro($row['dataVencimentoRegistro']);
                    $this->setDataAtualizacao($row['dataAtualizacao']);
                }else{
                    $this->setIdProduto(null);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Anvisa" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['idProduto'] = $this->getIdProduto();
                $array['numeroRegistro'] = $this->getNumeroRegistro();
                $array['nomeProduto'] = $this->getNomeProduto();
                $array['principioAtivo'] = $this->getPrincipioAtivo();
                $array['numProcesso'] = $this->getNumProcesso();
                $array['categoriaRegulatoria'] = $this->getCategoriaRegulatoria();
                $array['apresentacao'] = $this->getApresentacao();
                $array['principiosAtivos'] = $this->getPrincipiosAtivos();
                $array['viasAdministracao'] = $this->getViasAdministracao();
                $array['razaoSocial'] = $this->getRazaoSocial();
                $array['cnpj'] = $this->getCnpj();
                $array['dataRegistro'] = $this->getDataRegistro();
                $array['dataVencimentoRegistro'] = $this->getDataVencimentoRegistro();
                $array['dataAtualizacao'] = $this->getDataAtualizacao();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Anvisa" . $e->getMessage(),1);
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
                    $esteObjeto = new Anvisa();
                    $esteObjeto->setIdProduto($row['idProduto']);
                    $esteObjeto->setNumeroRegistro($row['numeroRegistro']);
                    $esteObjeto->setNomeProduto($row['nomeProduto']);
                    $esteObjeto->setPrincipioAtivo($row['principioAtivo']);
                    $esteObjeto->setNumProcesso($row['numProcesso']);
                    $esteObjeto->setCategoriaRegulatoria($row['categoriaRegulatoria']);
                    $esteObjeto->setApresentacao($row['apresentacao']);
                    $esteObjeto->setPrincipiosAtivos($row['principiosAtivos']);
                    $esteObjeto->setViasAdministracao($row['viasAdministracao']);
                    $esteObjeto->setRazaoSocial($row['razaoSocial']);
                    $esteObjeto->setCnpj($row['cnpj']);
                    $esteObjeto->setDataRegistro($row['dataRegistro']);
                    $esteObjeto->setDataVencimentoRegistro($row['dataVencimentoRegistro']);
                    $esteObjeto->setDataAtualizacao($row['dataAtualizacao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Anvisas" . $e->getMessage(),1);
            }
        }

        public function busca($viasAdministracao)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE viasAdministracao LIKE CONCAT('%',:viasAdministracao, '%') LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":viasAdministracao", $viasAdministracao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Anvisa();
                    $esteObjeto->setIdProduto($row['idProduto']);
                    $esteObjeto->setNumeroRegistro($row['numeroRegistro']);
                    $esteObjeto->setNomeProduto($row['nomeProduto']);
                    $esteObjeto->setPrincipioAtivo($row['principioAtivo']);
                    $esteObjeto->setNumProcesso($row['numProcesso']);
                    $esteObjeto->setCategoriaRegulatoria($row['categoriaRegulatoria']);
                    $esteObjeto->setApresentacao($row['apresentacao']);
                    $esteObjeto->setPrincipiosAtivos($row['principiosAtivos']);
                    $esteObjeto->setViasAdministracao($row['viasAdministracao']);
                    $esteObjeto->setRazaoSocial($row['razaoSocial']);
                    $esteObjeto->setCnpj($row['cnpj']);
                    $esteObjeto->setDataRegistro($row['dataRegistro']);
                    $esteObjeto->setDataVencimentoRegistro($row['dataVencimentoRegistro']);
                    $esteObjeto->setDataAtualizacao($row['dataAtualizacao']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Anvisa" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboAnvisa",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o anvisa'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['idProduto'] || ( is_array($selecionado) && in_array($row['idProduto'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['idProduto']."'>".$row['numeroRegistro']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Anvisa" . $e->getMessage(),1);
            }
        }
    }
}