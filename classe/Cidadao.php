<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Cidadao
    {
        private $banco;
        private $tabela = "cidadao";

        private $codCidadao;
        private $nome;
        private $idade;
        private $codSexo;
        private $codUsuario;
        private $codEscolaridade;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodCidadao($codCidadao)
        {
            $this->codCidadao = $codCidadao;
        }
        public function getCodCidadao()
        {
            return $this->codCidadao;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }
        public function getNome()
        {
            return $this->nome;
        }

        public function setIdade($idade)
        {
            $this->idade = $idade;
        }
        public function getIdade()
        {
            return $this->idade;
        }

        public function setCodSexo($codSexo)
        {
            $this->codSexo = $codSexo;
        }
        public function getCodSexo()
        {
            return $this->codSexo;
        }

        public function setCodUsuario($codUsuario)
        {
            $this->codUsuario = $codUsuario;
        }
        public function getCodUsuario()
        {
            return $this->codUsuario;
        }

        public function setCodEscolaridade($codEscolaridade)
        {
            $this->codEscolaridade = $codEscolaridade;
        }
        public function getCodEscolaridade()
        {
            return $this->codEscolaridade;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (nome,idade,codSexo,codUsuario,codEscolaridade) VALUES (:nome,:idade,:codSexo,:codUsuario,:codEscolaridade);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":idade", $this->getIdade());
                $sql->bindValue(":codSexo", $this->getCodSexo());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codEscolaridade", $this->getCodEscolaridade());
                $sql->execute();
                $this->setCodCidadao(MySql::ultimoCodigoInserido());
                return "Cidadão incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Cidadão". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET nome = :nome, idade = :idade, codSexo = :codSexo, codUsuario = :codUsuario, codEscolaridade = :codEscolaridade WHERE codCidadao = :codCidadao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":idade", $this->getIdade());
                $sql->bindValue(":codSexo", $this->getCodSexo());
                $sql->bindValue(":codUsuario", $this->getCodUsuario());
                $sql->bindValue(":codEscolaridade", $this->getCodEscolaridade());
                $sql->execute();
                return "Cidadão alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Cidadão". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codCidadao = :codCidadao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->execute();
                return "Cidadão excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao = :codCidadao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $this->getCodCidadao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codCidadao']) && !empty($row['codCidadao'])) {
                    $this->setCodCidadao($row['codCidadao']);
                    $this->setNome($row['nome']);
                    $this->setIdade($row['idade']);
                    $this->setCodSexo($row['codSexo']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodEscolaridade($row['codEscolaridade']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregarPeloNome()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE nome = :nome LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":nome", $this->getNome());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codCidadao']) && !empty($row['codCidadao'])) {
                    $this->setCodCidadao($row['codCidadao']);
                    $this->setNome($row['nome']);
                    $this->setIdade($row['idade']);
                    $this->setCodSexo($row['codSexo']);
                    $this->setCodUsuario($row['codUsuario']);
                    $this->setCodEscolaridade($row['codEscolaridade']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codCidadao'] = $this->getCodCidadao();
                $array['nome'] = $this->getNome();
                $array['idade'] = $this->getIdade();
                $array['codSexo'] = $this->getCodSexo();
                $array['codUsuario'] = $this->getCodUsuario();
                $array['codEscolaridade'] = $this->getCodEscolaridade();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Cidadao" . $e->getMessage(),1);
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
                    $esteObjeto = new Cidadao();
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setIdade($row['idade']);
                    $esteObjeto->setCodSexo($row['codSexo']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodEscolaridade($row['codEscolaridade']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregarTodosQueEstaoNaV2($arrayPrompt)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao IN (SELECT codCidadao FROM ".$this->banco.".receituarioV2 WHERE codPrompt IN (".implode(",",$arrayPrompt).") );";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Cidadao();
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setIdade($row['idade']);
                    $esteObjeto->setCodSexo($row['codSexo']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodEscolaridade($row['codEscolaridade']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregarTodosReceituario($codUsuario, $codPrompt = null, $usuarioReceituario = true)
        {
            try {
                $colObjeto = new phpCollection();
                $sql = "";
                $sqlBase = "";
                if($codPrompt) $sql = " AND codPrompt = :codPrompt ";
                if($usuarioReceituario && $codUsuario) $sql .= " AND codUsuario = :codUsuario ";
                else if($codUsuario) $sqlBase = " AND codUsuario = :codUsuario ";
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao IN (SELECT codCidadao FROM ".$this->banco.".receituario WHERE 1=1 $sql) AND 1=1 $sqlBase;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                if($codUsuario) $sql->bindValue(":codUsuario", $codUsuario);
                if($codPrompt) $sql->bindValue(":codPrompt", $codPrompt);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Cidadao();
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setIdade($row['idade']);
                    $esteObjeto->setCodSexo($row['codSexo']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodEscolaridade($row['codEscolaridade']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Cidadão" . $e->getMessage(),1);
            }
        }

        public function carregarTodosReceituarioV2($codUsuario, $codPrompt = null, $usuarioReceituario = true)
        {
            try {
                $colObjeto = new phpCollection();
                $sql = "";
                $sqlBase = "";
                if($codPrompt) $sql = " AND codPrompt = :codPrompt ";
                if($usuarioReceituario && $codUsuario) $sql .= " AND codUsuario = :codUsuario ";
                else if($codUsuario) $sqlBase = " AND codUsuario = :codUsuario ";
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codCidadao IN (SELECT codCidadao FROM ".$this->banco.".receituarioV2 WHERE 1=1 $sql) AND 1=1 $sqlBase;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                if($codUsuario) $sql->bindValue(":codUsuario", $codUsuario);
                if($codPrompt) $sql->bindValue(":codPrompt", $codPrompt);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Cidadao();
                    $esteObjeto->setCodCidadao($row['codCidadao']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setIdade($row['idade']);
                    $esteObjeto->setCodSexo($row['codSexo']);
                    $esteObjeto->setCodUsuario($row['codUsuario']);
                    $esteObjeto->setCodEscolaridade($row['codEscolaridade']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Cidadão" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboCidadao",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o cidadao'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codCidadao'] || ( is_array($selecionado) && in_array($row['codCidadao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codCidadao']."'>".$row['nome']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Cidadão" . $e->getMessage(),1);
            }
        }
    }
}