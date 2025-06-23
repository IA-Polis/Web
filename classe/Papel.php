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

	class Papel
	{
		private $banco;
		private $tabela = "papel";

		private $codPapel;
		private $nome;
		private $descricao;
		
		function __construct() {
			$this->banco = $GLOBALS['MYSQL_BANCO'];
		}

		public function setCodPapel($codPapel)
		{
			$this->codPapel = $codPapel;
		}

		public function getCodPapel()
		{
			return $this->codPapel;
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
				$this->setCodPapel(MySql::ultimoCodigoInserido());
				return "Papel incluido com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar  incluir o Papel. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function salvar()
		{
			try {
				$query = "UPDATE " . $this->banco . "." . $this->tabela . " SET nome = :nome, descricao = :descricao WHERE codPapel = :codPapel;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->bindValue(":nome", $this->getNome());
				$sql->bindValue(":descricao", $this->getDescricao());
				$sql->execute();
				return "Papel alterado com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar salvar o Papel. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function excluir()
		{
			try {
				$query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codPapel = :codPapel;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->execute();
				return "Papel excluida com sucesso!";
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar excluir o Papel. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function carregar()
		{
			try {
				$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codPapel = :codPapel  LIMIT 1;";
				$conexao = MySql::getInstancia();
				$sql = $conexao->prepare($query);
				$sql->bindValue(":codPapel", $this->getCodPapel());
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				$row = $sql->fetch();
				if(isset($row['codPapel']) && !empty($row['codPapel'])) {
					$this->setCodPapel($row['codPapel']);
					$this->setNome($row['nome']);
					$this->setDescricao($row['descricao']);
				}
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar o Papel. Erro MySQL: " . $e->getMessage(), 1);
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
					$esteObjeto = new Papel();
					$esteObjeto->setCodPapel($row['codPapel']);
					$esteObjeto->setNome($row['nome']);
					$esteObjeto->setDescricao($row['descricao']);
					$colObjeto->add($aux, $esteObjeto);
					$aux++;
				}
				return $colObjeto;
			} catch (Exception $e) {
				throw new Exception("Ocorreu um erro ao tentar carregar todas os Papeis. Erro MySQL: " . $e->getMessage(), 1);
			}
		}

		public function combo($selecionado, $cboID = "cboPapel", $multiplo = '')
		{
			if ($multiplo) $multiplo = '[] multiple';
			$saida = "<select class='form-control input-sm' id=$cboID name=$cboID$multiplo>";
			$query = "SELECT * FROM " . $this->banco . "." . $this->tabela . ";";
			$conexao = MySql::getInstancia();
			$sql = $conexao->prepare($query);
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$result = $sql->execute();
			if ($result) {
				if (!$multiplo) $saida .= "<option>Selecione o papel</option>";
				while ($row = $sql->fetch()) {
					$saida .= "<option ";
					if ($selecionado == $row['codPapel'] || (is_array($selecionado) && in_array($row['codPapel'], $selecionado))) $saida .= "selected ";
					$saida .= "value='" . $row['codPapel'] . "'>" . $row['nome'] . "</option>";
				}
			} else throw new Exception("Ocorreu um erro ao tentar carregar combo de papel!" . mysql_error(), 1);
			$saida .= "</select>";
			return $saida;
		}
	}
}