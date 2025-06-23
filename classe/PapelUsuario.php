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

	class PapelUsuario
	{
		private $banco;
		private $tabela = "papelUsuario";

		private $codPapelUsuario;
		private $codPapel;
		private $codUsuario;
		
		function __construct() {
			$this->banco = $GLOBALS['MYSQL_BANCO'];
		}

		public function setCodPapelUsuario($codPapelUsuario)
		{
			$this->codPapelUsuario = $codPapelUsuario;
		}

		public function getCodPapelUsuario()
		{
			return $this->codPapelUsuario;
		}

		public function setCodPapel($codPapel)
		{
			$this->codPapel = $codPapel;
		}

		public function getCodPapel()
		{
			return $this->codPapel;
		}

		public function setCodUsuario($codUsuario)
		{
			$this->codUsuario = $codUsuario;
		}

		public function getCodUsuario()
		{
			return $this->codUsuario;
		}

		public function incluir()
		{
			try {
				$query = "INSERT INTO " . $this->banco . "." . $this->tabela . " (codPapelUsuario,codPapel,codUsuario) VALUES (:codPapelUsuario,:codPapel,:codUsuario);";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelUsuario", $this->getCodPapelUsuario());
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->execute();
				$this->setCodPapel(MySql::ultimoCodigoInserido());
				return "Papel do Usuário incluido com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  incluir o Papel do Usuário. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function salvar()
		{
			try {
				$query = "UPDATE " . $this->banco . "." . $this->tabela . " SET codPapel = :codPapel, codUsuario = :codUsuario WHERE codPapelUsuario = :codPapelUsuario;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelUsuario", $this->getCodPapelUsuario());
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->execute();
				return "Papel do Usuário alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar salvar o Papel do Usuário. " . $e->getMessage(), 1);
			}
		}

		public function excluir()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codPapelUsuario = :codPapelUsuario;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelUsuario", $this->getCodPapelUsuario());
				$sql->execute();
				return "Papel do usuário excluido com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir o Papel. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function excluirUsuario()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codUsuario = :codUsuario;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->execute();
				return "Papeis do usuário excluidos com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir o Papel. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function carregar()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codPapelUsuario = :codPapelUsuario  LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapelUsuario", $this->getCodPapelUsuario());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codPapelUsuario']) && !empty($row['codPapelUsuario'])) {
					$this->setCodPapelUsuario($row['codPapelUsuario']);
					$this->setCodPapel($row['codPapel']);
					$this->setCodUsuario($row['codUsuario']);
				}
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Papel do Usuário. Erro MySQL: " . $e->getMessage(), 1);
			}
		}
		
		public function verificarFuncionalidade($nomeFuncionalidade)
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " as pu, " . $this->banco . ".papelFuncionalidade as pf," . $this->banco . ".funcionalidade as f 
				WHERE pu.codUsuario = :codUsuario AND pf.codPapel = pu.codPapel AND f.codFuncionalidade = pf.codFuncionalidade AND f.nome = :funcionalidade LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codUsuario", $this->getCodUsuario());
				$sql->bindValue(":funcionalidade", $nomeFuncionalidade);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codPapelUsuario']) && !empty($row['codPapelUsuario'])) return true;
				else return false;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Papel do Usuário. Erro MySQL: " . $e->getMessage(), 1);
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
					$esteObjeto = new PapelUsuario();
					$esteObjeto->setCodPapelUsuario($row['codPapelUsuario']);
					$esteObjeto->setCodPapel($row['codPapel']);
					$esteObjeto->setCodUsuario($row['codUsuario']);
					$colObjeto->add($aux, $esteObjeto);
					$aux++;
				}
				return $colObjeto;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar todas os Papeis do Usuário. Erro MySQL: " . $e->getMessage(), 1);
			}
		}
	}
}