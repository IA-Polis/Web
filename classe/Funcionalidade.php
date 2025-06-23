<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 15/10/2018 10:45:00 - INCLUSAO DE NAMESPACE
// Atualização em 11/03/2016 13:51:00 - INCLUSAO DE PDO
// Gerada pela classe GeradorClasses C# versão 1.6.1.9

namespace Classe {

	use Config\phpCollection as phpCollection;
	use Config\MySql as MySql;
	use PDO as PDO;
	use Exception as Exception;

	class Funcionalidade
	{
		private $banco;
		private $tabela = "funcionalidade";

		private $codFuncionalidade;
		private $nome;
		private $descricao;
		
		function __construct() {
			$this->banco = $GLOBALS['MYSQL_BANCO'];
		}

		public function setCodFuncionalidade($codFuncionalidade)
		{
			$this->codFuncionalidade = $codFuncionalidade;
		}

		public function getCodFuncionalidade()
		{
			return $this->codFuncionalidade;
		}

		public function setNome($nome)
		{
			$this->nome = $nome;
		}

		public function getNome()
		{
			return $this->nome;
		}

		public function setDescricao($descricao)
		{
			$this->descricao = $descricao;
		}

		public function getDescricao()
		{
			return $this->descricao;
		}

		public function incluir()
		{
			try {
				$query = "INSERT INTO " . $this->banco . "." . $this->tabela . " (nome,descricao) VALUES (:nome,:descricao);";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":nome", $this->getNome());
				$sql->bindValue(":descricao", $this->getDescricao());
				$sql->execute();
				$this->setCodFuncionalidade(MySql::ultimoCodigoInserido());
				return "Funcionalidade incluida com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  incluir a Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function salvar()
		{
			try {
				$query = "UPDATE " . $this->banco . "." . $this->tabela . " SET nome = :nome, descricao = :descricao WHERE codFuncionalidade = :codFuncionalidade;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->bindValue(":nome", $this->getNome());
				$sql->bindValue(":descricao", $this->getDescricao());
				$sql->execute();
				return "Funcionalidade alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar salvar a Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function excluir()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codFuncionalidade = :codFuncionalidade;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->execute();
				return "Funcionalidade excluida com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir a Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function carregar()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codFuncionalidade = :codFuncionalidade  LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codFuncionalidade']) && !empty($row['codFuncionalidade'])) {
					$this->setCodFuncionalidade($row['codFuncionalidade']);
					$this->setNome($row['nome']);
					$this->setDescricao($row['descricao']);
				}
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar a Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
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
					$esteObjeto = new Funcionalidade();
					$esteObjeto->setCodFuncionalidade($row['codFuncionalidade']);
					$esteObjeto->setNome($row['nome']);
					$esteObjeto->setDescricao($row['descricao']);
					$colObjeto->add($aux, $esteObjeto);
					$aux++;
				}
				return $colObjeto;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar todas as Funcionalidades. Erro MySQL: " . $e->getMessage(), 1);
			}
		}
	}
}