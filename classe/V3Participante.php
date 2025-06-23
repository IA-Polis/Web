<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class V3Participante
    {
        private $banco;
        private $tabela = "v3Participante";

        private $codParticipante;
        private $codTipoParticipante;
        private $nome;
        private $email;
        private $telefone;
        private $token;
        private $numero;
        private $feedback_preocupacoes;
        private $feedback_preocupacoes_outros;
        private $feedback_desvantagens;
        private $feedback_vantagens;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodParticipante($codParticipante)
        {
            $this->codParticipante = $codParticipante;
        }
        public function getCodParticipante()
        {
            return $this->codParticipante;
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

        public function setEmail($email)
        {
            $this->email = $email;
        }
        public function getEmail()
        {
            return $this->email;
        }

        public function setTelefone($telefone)
        {
            $this->telefone = $telefone;
        }
        public function getTelefone()
        {
            return $this->telefone;
        }

        public function setToken($token)
        {
            $this->token = $token;
        }
        public function getToken()
        {
            return $this->token;
        }

        public function setNumero($numero)
        {
            $this->numero = $numero;
        }
        public function getNumero()
        {
            return $this->numero;
        }

        public function setFeedback_preocupacoes($feedback_preocupacoes)
        {
            $this->feedback_preocupacoes = $feedback_preocupacoes;
        }
        public function getFeedback_preocupacoes()
        {
            return $this->feedback_preocupacoes;
        }

        public function setFeedback_preocupacoes_outros($feedback_preocupacoes_outros)
        {
            $this->feedback_preocupacoes_outros = $feedback_preocupacoes_outros;
        }
        public function getFeedback_preocupacoes_outros()
        {
            return $this->feedback_preocupacoes_outros;
        }

        public function setFeedback_desvantagens($feedback_desvantagens)
        {
            $this->feedback_desvantagens = $feedback_desvantagens;
        }
        public function getFeedback_desvantagens()
        {
            return $this->feedback_desvantagens;
        }

        public function setFeedback_vantagens($feedback_vantagens)
        {
            $this->feedback_vantagens = $feedback_vantagens;
        }
        public function getFeedback_vantagens()
        {
            return $this->feedback_vantagens;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codTipoParticipante,nome,email,telefone,token,numero,feedback_preocupacoes,feedback_preocupacoes_outros,feedback_desvantagens,feedback_vantagens) VALUES (:codTipoParticipante,:nome,:email,:telefone,:token,:numero,:feedback_preocupacoes,:feedback_preocupacoes_outros,:feedback_desvantagens,:feedback_vantagens);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":email", $this->getEmail());
                $sql->bindValue(":telefone", $this->getTelefone());
                $sql->bindValue(":token", $this->getToken());
                $sql->bindValue(":numero", $this->getNumero());
                $sql->bindValue(":feedback_preocupacoes", $this->getFeedback_preocupacoes());
                $sql->bindValue(":feedback_preocupacoes_outros", $this->getFeedback_preocupacoes_outros());
                $sql->bindValue(":feedback_desvantagens", $this->getFeedback_desvantagens());
                $sql->bindValue(":feedback_vantagens", $this->getFeedback_vantagens());
                $sql->execute();
                $this->setCodParticipante(MySql::ultimoCodigoInserido());
                return "Participante incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Participante". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codTipoParticipante = :codTipoParticipante, nome = :nome, email = :email, telefone = :telefone, token = :token, numero = :numero, feedback_preocupacoes = :feedback_preocupacoes, feedback_preocupacoes_outros = :feedback_preocupacoes_outros, feedback_desvantagens = :feedback_desvantagens, feedback_vantagens = :feedback_vantagens WHERE codParticipante = :codParticipante;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codParticipante", $this->getCodParticipante());
                $sql->bindValue(":codTipoParticipante", $this->getCodTipoParticipante());
                $sql->bindValue(":nome", $this->getNome());
                $sql->bindValue(":email", $this->getEmail());
                $sql->bindValue(":telefone", $this->getTelefone());
                $sql->bindValue(":token", $this->getToken());
                $sql->bindValue(":numero", $this->getNumero());
                $sql->bindValue(":feedback_preocupacoes", $this->getFeedback_preocupacoes());
                $sql->bindValue(":feedback_preocupacoes_outros", $this->getFeedback_preocupacoes_outros());
                $sql->bindValue(":feedback_desvantagens", $this->getFeedback_desvantagens());
                $sql->bindValue(":feedback_vantagens", $this->getFeedback_vantagens());
                $sql->execute();
                return "Participante alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Participante". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codParticipante = :codParticipante;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codParticipante", $this->getCodParticipante());
                $sql->execute();
                return "Participante excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Participante" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codParticipante = :codParticipante LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codParticipante", $this->getCodParticipante());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codParticipante']) && !empty($row['codParticipante'])) {
                    $this->setCodParticipante($row['codParticipante']);
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                    $this->setNome($row['nome']);
                    $this->setEmail($row['email']);
                    $this->setTelefone($row['telefone']);
                    $this->setToken($row['token']);
                    $this->setNumero($row['numero']);
                    $this->setFeedback_preocupacoes($row['feedback_preocupacoes']);
                    $this->setFeedback_preocupacoes_outros($row['feedback_preocupacoes_outros']);
                    $this->setFeedback_desvantagens($row['feedback_desvantagens']);
                    $this->setFeedback_vantagens($row['feedback_vantagens']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Participante" . $e->getMessage(),1);
            }
        }

        public function carregarPeloToken()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE token = :token LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":token", $this->getToken());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codParticipante']) && !empty($row['codParticipante'])) {
                    $this->setCodParticipante($row['codParticipante']);
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                    $this->setNome($row['nome']);
                    $this->setEmail($row['email']);
                    $this->setTelefone($row['telefone']);
                    $this->setToken($row['token']);
                    $this->setNumero($row['numero']);
                    $this->setFeedback_preocupacoes($row['feedback_preocupacoes']);
                    $this->setFeedback_preocupacoes_outros($row['feedback_preocupacoes_outros']);
                    $this->setFeedback_desvantagens($row['feedback_desvantagens']);
                    $this->setFeedback_vantagens($row['feedback_vantagens']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Participante" . $e->getMessage(),1);
            }
        }

        public function carregarPeloEmail()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE email = :email LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":email", $this->getEmail());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codParticipante']) && !empty($row['codParticipante'])) {
                    $this->setCodParticipante($row['codParticipante']);
                    $this->setCodTipoParticipante($row['codTipoParticipante']);
                    $this->setNome($row['nome']);
                    $this->setEmail($row['email']);
                    $this->setTelefone($row['telefone']);
                    $this->setToken($row['token']);
                    $this->setNumero($row['numero']);
                    $this->setFeedback_preocupacoes($row['feedback_preocupacoes']);
                    $this->setFeedback_preocupacoes_outros($row['feedback_preocupacoes_outros']);
                    $this->setFeedback_desvantagens($row['feedback_desvantagens']);
                    $this->setFeedback_vantagens($row['feedback_vantagens']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Participante" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codParticipante'] = $this->getCodParticipante();
                $array['codTipoParticipante'] = $this->getCodTipoParticipante();
                $array['nome'] = $this->getNome();
                $array['email'] = $this->getEmail();
                $array['telefone'] = $this->getTelefone();
                $array['token'] = $this->getToken();
                $array['numero'] = $this->getNumero();
                $array['feedback_preocupacoes'] = $this->getFeedback_preocupacoes();
                $array['feedback_preocupacoes_outros'] = $this->getFeedback_preocupacoes_outros();
                $array['feedback_desvantagens'] = $this->getFeedback_desvantagens();
                $array['feedback_vantagens'] = $this->getFeedback_vantagens();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Participante" . $e->getMessage(),1);
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
                    $esteObjeto = new V3Participante();
                    $esteObjeto->setCodParticipante($row['codParticipante']);
                    $esteObjeto->setCodTipoParticipante($row['codTipoParticipante']);
                    $esteObjeto->setNome($row['nome']);
                    $esteObjeto->setEmail($row['email']);
                    $esteObjeto->setTelefone($row['telefone']);
                    $esteObjeto->setToken($row['token']);
                    $esteObjeto->setNumero($row['numero']);
                    $esteObjeto->setFeedback_preocupacoes($row['feedback_preocupacoes']);
                    $esteObjeto->setFeedback_preocupacoes_outros($row['feedback_preocupacoes_outros']);
                    $esteObjeto->setFeedback_desvantagens($row['feedback_desvantagens']);
                    $esteObjeto->setFeedback_vantagens($row['feedback_vantagens']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Participantes" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboParticipante",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o participante'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codParticipante'] || ( is_array($selecionado) && in_array($row['codParticipante'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codParticipante']."'>".$row['codTipoParticipante']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Participante" . $e->getMessage(),1);
            }
        }
    }
}