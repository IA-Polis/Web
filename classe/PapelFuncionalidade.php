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

	class PapelFuncionalidade
	{
		private $banco;
		private $tabela = "papelFuncionalidade";

		private $codPapelFuncionalidade;
		private $codPapel;
		private $codFuncionalidade;
		
		function __construct() {
			$this->banco = $GLOBALS['MYSQL_BANCO'];
		}

		public function setCodPapelFuncionalidade($codPapelFuncionalidade)
		{
			$this->codPapelFuncionalidade = $codPapelFuncionalidade;
		}

		public function getCodPapelFuncionalidade()
		{
			return $this->codPapelFuncionalidade;
		}

		public function setCodPapel($codPapel)
		{
			$this->codPapel = $codPapel;
		}

		public function getCodPapel()
		{
			return $this->codPapel;
		}

		public function setCodFuncionalidade($codFuncionalidade)
		{
			$this->codFuncionalidade = $codFuncionalidade;
		}

		public function getCodFuncionalidade()
		{
			return $this->codFuncionalidade;
		}

		public function incluir()
		{
			try {
				$query = "INSERT INTO " . $this->banco . "." . $this->tabela . " (codPapelFuncionalidade,codPapel,codFuncionalidade) VALUES (:codPapelFuncionalidade,:codPapel,:codFuncionalidade);";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelFuncionalidade", $this->getCodPapelFuncionalidade());
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->execute();
				$this->setCodPapelFuncionalidade(MySql::ultimoCodigoInserido());
				return "Papel/Funcionalidade incluido com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  incluir o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function salvar()
		{
			try {
				$query = "UPDATE " . $this->banco . "." . $this->tabela . " SET codPapel = :codPapel, codFuncionalidade = :codFuncionalidade WHERE codPapelFuncionalidade = :codPapelFuncionalidade;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->bindValue(":codPapelFuncionalidade", $this->getCodPapelFuncionalidade());
				$sql->execute();
				return "Papel/Funcionalidade alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar salvar o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function excluir()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codPapelFuncionalidade = :codPapelFuncionalidade;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelFuncionalidade", $this->getCodPapelFuncionalidade());
				$sql->execute();
				return "Papel/Funcionalidade excluida com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function excluirPeloPapel()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codPapel = :codPapel;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->execute();
				return "Papel/Funcionalidade excluida com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function carregar()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codPapelFuncionalidade = :codPapelFuncionalidade  LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelFuncionalidade", $this->getCodPapelFuncionalidade());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codPapelFuncionalidade']) && !empty($row['codPapelFuncionalidade'])) {
					$this->setCodPapelFuncionalidade($row['codPapelFuncionalidade']);
					$this->setCodPapel($row['codPapel']);
					$this->setCodFuncionalidade($row['codFuncionalidade']);
				}
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function carregarPeloPapelFuncionalidade()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codPapel = :codPapel AND codFuncionalidade = :codFuncionalidade  LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codFuncionalidade", $this->getCodFuncionalidade());
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codPapelFuncionalidade']) && !empty($row['codPapelFuncionalidade'])) {
					$this->setCodPapelFuncionalidade($row['codPapelFuncionalidade']);
					$this->setCodPapel($row['codPapel']);
					$this->setCodFuncionalidade($row['codFuncionalidade']);
				}
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
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
				$sql->bindValue(":" . $criterio, $descricao);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$aux = 0;
				while ($row = $sql->fetch()) {
					$esteObjeto = new PapelFuncionalidade();
					$esteObjeto->setCodPapelFuncionalidade($row['codPapelFuncionalidade']);
					$esteObjeto->setCodPapel($row['codPapel']);
					$esteObjeto->setCodFuncionalidade($row['codFuncionalidade']);
					$colObjeto->add($aux, $esteObjeto);
					$aux++;
				}
				return $colObjeto;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar todas os Papel/Funcionalidade. Erro MySQL: " . $e->getMessage(), 1);
			}
		}
	}
}