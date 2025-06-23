<?
// Autor: Isaias

namespace Classe {

	use Config\phpCollection as phpCollection;
	use Config\MySql as MySql;
	use PDO as PDO;
	use Exception as Exception;

	class Usuario
	{
		private $banco;
		private $tabela = "usuario";

		private $codUsuario;
		private $login;
		private $senha;
		private $nome;
		private $verificado;
		private $trocaSenha;
		private $imagem;
		private $token;
		private $pushIDAndroid;
		private $pushIDIOS;
		private $receberNotificacao;

		function __construct() {
			$this->banco = $GLOBALS['MYSQL_BANCO'];
		}

		public function setCodUsuario($codUsuario)
		{
			$this->codUsuario = $codUsuario;
		}

		public function getCodUsuario()
		{
			return $this->codUsuario;
		}

		public function setLogin($login)
		{
			$this->login = $login;
		}

		public function getLogin()
		{
			return $this->login;
		}

		public function setSenha($senha)
		{
			if (!$senha) $senha = uniqid();
			$this->senha = md5($senha);
		}

		public function getSenha()
		{
			return $this->senha;
		}

		public function setNome($nome)
		{
			$this->nome = $nome;
		}

		public function getNome()
		{
			return $this->nome;
		}

		public function setVerificado($verificado)
		{
			$this->verificado = $verificado;
		}

		public function getVerificado()
		{
			return $this->verificado;
		}

		public function setTrocaSenha($trocaSenha)
		{
			$this->trocaSenha = $trocaSenha;
		}

		public function getTrocaSenha()
		{
			return $this->trocaSenha;
		}
	
		public function setImagem($imagem)
		{
			$this->imagem = $imagem;
		}
		public function getImagem()
		{
			return $this->imagem;
		}

		public function setToken($token)
		{
			$this->token = $token;
		}

		public function getToken()
		{
			return $this->token;
		}

		public function setReceberNotificacao($receberNotificacao)
		{
			$this->receberNotificacao = $receberNotificacao;
		}

		public function getReceberNotificacao()
		{
			return $this->receberNotificacao;
		}

		public function setPushIDAndroid($pushIDAndroid)
		{
			$this->pushIDAndroid = $pushIDAndroid;
		}

		public function getPushIDAndroid()
		{
			return $this->pushIDAndroid;
		}

		public function setPushIDIOS($pushIDIOS)
		{
			$this->pushIDIOS = $pushIDIOS;
		}

		public function getPushIDIOS()
		{
			return $this->pushIDIOS;
		}

		public function setFacebookEmail($facebookEmail)
		{
			$this->facebookEmail = $facebookEmail;
		}

		public function getFacebookEmail()
		{
			return $this->facebookEmail;
		}

		public function incluir()
		{
			try {
				$query = "INSERT INTO " . $this->banco . "." . $this->tabela . " (login,senha,nome,verificado,trocaSenha,imagem,token,pushIDAndroid,pushIDIOS,receberNotificacao) VALUES (:login,:senha,:nome,:verificado,:trocaSenha,:imagem,:token,:pushIDAndroid,:pushIDIOS,:receberNotificacao);";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":login", $this->getLogin());
				$sql->bindValue(":senha", $this->getSenha());
				$sql->bindValue(":nome", $this->getNome());
				$sql->bindValue(":verificado", $this->getVerificado());
				$sql->bindValue(":trocaSenha", $this->getTrocaSenha());
				$sql->bindValue(":imagem", $this->getImagem());
				$sql->bindValue(":token", $this->getToken());
				$sql->bindValue(":pushIDAndroid", $this->getPushIDAndroid());
				$sql->bindValue(":pushIDIOS", $this->getPushIDIOS());
				$sql->bindValue(":receberNotificacao", $this->getReceberNotificacao());
				$sql->execute();
				$this->setCodUsuario(MySql::ultimoCodigoInserido());
				return "Usuario incluido com sucesso!";
			} catch (Exception $e) {
				if ($sql->errorInfo()[1] == 1062) throw new Exception("Usuário já existe.", 1062);
				else throw new Exception("Ocorreu um erro ao tentar  incluir o Usuario" . $sql->errorInfo()[1] . $e->getMessage(), 1);
			}
		}

		public function salvar($comSenha = '')
		{

			try {
				if ($comSenha) $query =
					"UPDATE " . $this->banco . "." . $this->tabela . " 
					SET 
					login = :login, 
					senha = :senha,
					nome = :nome, 
					verificado = :verificado, 
					trocaSenha = :trocaSenha, 
					imagem = :imagem, 
					token = :token,
					pushIDAndroid = :pushIDAndroid,
					pushIDIOS = :pushIDIOS, 
					receberNotificacao = :receberNotificacao 
					WHERE codUsuario = :codUsuario;";
				else $query =
					"UPDATE " . $this->banco . "." . $this->tabela . " 
					SET 
					login = :login, 
					nome = :nome, 
					verificado = :verificado, 
					trocaSenha = :trocaSenha, 
					imagem = :imagem, 
					token = :token,
					pushIDAndroid = :pushIDAndroid,
					pushIDIOS = :pushIDIOS, 
					receberNotificacao = :receberNotificacao 
					WHERE codUsuario = :codUsuario;";
				//echo  $query;
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->bindValue(":login", $this->getLogin());
				$sql->bindValue(":nome", $this->getNome());
				$sql->bindValue(":verificado", $this->getVerificado());
				$sql->bindValue(":trocaSenha", $this->getTrocaSenha());
				$sql->bindValue(":imagem", $this->getImagem());
				$sql->bindValue(":token", $this->getToken());
				$sql->bindValue(":pushIDAndroid", $this->getPushIDAndroid());
				$sql->bindValue(":pushIDIOS", $this->getPushIDIOS());
				$sql->bindValue(":receberNotificacao", $this->getReceberNotificacao());
				if ($comSenha) $sql->bindValue(":senha", $this->getSenha());
				$sql->execute();
				return "Usuario alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  alterar Usuario" . $e->getMessage(), 1);
			}
		}

		public function excluir()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codUsuario = :codUsuario;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->execute();
				return "Usuario excluido com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar Excluir Usuario" . $e->getMessage(), 1);
			}
		}

		public function carregar()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codUsuario = :codUsuario LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codUsuario']) && !empty($row['codUsuario'])) {
					$this->setCodUsuario($row['codUsuario']);
					$this->setLogin($row['login']);
					$this->setSenha($row['senha']);
					$this->setNome($row['nome']);
					$this->setVerificado($row['verificado']);
					$this->setTrocaSenha($row['trocaSenha']);
					$this->setImagem($row['imagem']);
					$this->setToken($row['token']);
					$this->setPushIDAndroid($row['pushIDAndroid']);
					$this->setPushIDIOS($row['pushIDIOS']);
					$this->setReceberNotificacao($row['receberNotificacao']);
				}

				$this->setToken($row['token']);
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Usuario" . $e->getMessage(), 1);
			}
		}
		
		public function carregarArray(){
			$usuario = $this;
			$array = [];
			$array['status'] = "200";
			$array['title'] = "Successful";
			$array['codUsuario'] = $usuario->getCodUsuario();
			$array['nome'] = $usuario->getNome();
			$array['login'] = $usuario->getLogin();			
			if($usuario->getImagem()) $array['imagem'] = $GLOBALS['CAMINHOHTML']."images/avatar/".$usuario->getImagem();
			$array['verificado'] = $usuario->getVerificado();
			$array['token'] = $usuario->getToken();
			$array['pushIDAndroid'] = $this->getPushIDAndroid();
			$array['pushIDIOS'] = $this->getPushIDIOS();
			$array['receberNotificacao'] = $this->gtReceberNotificacao();
			return $array;
		}

		public function carregarTodosCriterio($criterio, $descricao)
		{
			try {
				$colObjeto = new phpCollection();
				if ($criterio) $query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE " . $criterio . " = :" . $criterio . ";";
				else $query = "SELECT * FROM " . $this->banco . "." . $this->tabela . ";";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
                if ($criterio) $sql->bindValue(":" . $criterio, $descricao);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$aux = 0;
				while ($row = $sql->fetch()) {
					$esteObjeto = new Usuario();
					$esteObjeto->setCodUsuario($row['codUsuario']);
					$esteObjeto->setLogin($row['login']);
					$esteObjeto->setSenha($row['senha']);
					$esteObjeto->setNome($row['nome']);
					$esteObjeto->setVerificado($row['verificado']);
					$esteObjeto->setTrocaSenha($row['trocaSenha']);
					$esteObjeto->setImagem($row['imagem']);
					$esteObjeto->setToken($row['token']);
					$esteObjeto->setPushIDAndroid($row['pushIDAndroid']);
					$esteObjeto->setPushIDIOS($row['pushIDIOS']);
					$esteObjeto->setReceberNotificacao($row['receberNotificacao']);
					$colObjeto->add($aux, $esteObjeto);
					$aux++;
				}
				return $colObjeto;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar carregar todos os Usuario" . $e->getMessage(), 1);
			}
		}

		public function verificarLoginSenha($login, $senha)
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE login = :login AND senha = :senha;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				if ($senha) $sql->bindValue(":senha", md5($senha));
				if ($login) $sql->bindValue(":login", $login);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codUsuario']) && !empty($row['codUsuario'])) {
					$this->setCodUsuario($row['codUsuario']);
					$this->setLogin($row['login']);
					$this->setSenha($row['senha']);
					$this->setNome($row['nome']);
					$this->setVerificado($row['verificado']);
					$this->setTrocaSenha($row['trocaSenha']);
					$this->setImagem($row['imagem']);
					$this->setToken($row['token']);
					$this->setPushIDAndroid($row['pushIDAndroid']);
					$this->setPushIDIOS($row['pushIDIOS']);
					$this->setReceberNotificacao($row['receberNotificacao']);
				}

				if (isset($row['codUsuario']) && !empty($row['codUsuario'])) return 1;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar autenticar Usuario!" . $e->getMessage(), 1);
			}
		}

		public function verificarLogin($login)
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE login = :login;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				if ($login) $sql->bindValue(":login", $login);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codUsuario']) && !empty($row['codUsuario'])) {
					$this->setCodUsuario($row['codUsuario']);
					$this->setLogin($row['login']);
					$this->setSenha($row['senha']);
					$this->setNome($row['nome']);
					$this->setVerificado($row['verificado']);
					$this->setTrocaSenha($row['trocaSenha']);
					$this->setImagem($row['imagem']);
					$this->setToken($row['token']);
					$this->setPushIDAndroid($row['pushIDAndroid']);
					$this->setPushIDIOS($row['pushIDIOS']);
					$this->setReceberNotificacao($row['receberNotificacao']);
				}

				if (isset($row['codUsuario']) && !empty($row['codUsuario'])) return 1;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar autenticar Usuario!" . $e->getMessage(), 1);
			}
		}

		public function verificarToken($token)
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE token = :token;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":token", $token);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codUsuario']) && !empty($row['codUsuario'])) {
					$this->setCodUsuario($row['codUsuario']);
					$this->setLogin($row['login']);
					$this->setSenha($row['senha']);
					$this->setNome($row['nome']);
					$this->setVerificado($row['verificado']);
					$this->setTrocaSenha($row['trocaSenha']);
					$this->setImagem($row['imagem']);
					$this->setToken($row['token']);
					$this->setPushIDAndroid($row['pushIDAndroid']);
					$this->setPushIDIOS($row['pushIDIOS']);
					$this->setReceberNotificacao($row['receberNotificacao']);
				}

				if (isset($row['codUsuario']) && !empty($row['codUsuario'])) return 1;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar autenticar Usuario!" . $e->getMessage(), 1);
			}
		}

		public function verificarUid($uid)
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE trocaSenha = :trocaSenha;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				if ($uid) $sql->bindValue(":trocaSenha", $uid);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codUsuario']) && !empty($row['codUsuario'])) {
					$this->setCodUsuario($row['codUsuario']);
					$this->setLogin($row['login']);
					$this->setSenha($row['senha']);
					$this->setNome($row['nome']);
					$this->setVerificado($row['verificado']);
					$this->setTrocaSenha($row['trocaSenha']);
					$this->setImagem($row['imagem']);
					$this->setToken($row['token']);
					$this->setPushIDAndroid($row['pushIDAndroid']);
					$this->setPushIDIOS($row['pushIDIOS']);
					$this->setReceberNotificacao($row['receberNotificacao']);
				}

				if (isset($row['codUsuario']) && !empty($row['codUsuario'])) return 1;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar autenticar Usuario!" . $e->getMessage(), 1);
			}
		}

		public function trocarToken()
		{
			try {

				$query = "UPDATE " . $this->banco . "." . $this->tabela . " SET token = :token WHERE codUsuario = :codUsuario;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$uniqId = uniqid();
				$sql->bindValue(":token", $uniqId);
				$sql->execute();
				$this->setToken($uniqId);
				return "Usuario alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  alterar Usuario" . $e->getMessage(), 1);
			}
		}

		public function combo($selecionado, $cboID = "cboUsuario", $multiplo = '')
		{
			try {
				if ($multiplo) $multiplo = '[] multiple';
				$saida = "<select class='standardSelect' id=$cboID name=$cboID$multiplo data-placeholder='Selecione o usuário'>";
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . ";";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$saida	.= "<option label='default'></option>";                 
				while ($row = $sql->fetch()) {
					$saida .= "<option ";
					if ($selecionado == $row['codUsuario'] || (is_array($selecionado) && in_array($row['codUsuario'], $selecionado))) $saida .= "selected ";
					$saida .= "value='" . $row['codUsuario'] . "'>" . $row['nome'] . "</option>";
				}
				$saida .= "</select>";
				return $saida;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar combo Usuario" . $e->getMessage(), 1);
			}
		}
	}
}