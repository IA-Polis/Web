<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {

    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception;

    class Pictograma
    {
        private $banco;
        private $tabela = "pictograma";

        private $codPictograma;
        private $codPictogramaCategoria;
        private $codSugestaoHorario;
        private $codViaAdministracao;
        private $codUnidadeMedida;
        private $arquivo;
        private $tipo;
        private $estado;
        private $referente;

        function __construct()
        {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPictograma($codPictograma)
        {
            $this->codPictograma = $codPictograma;
        }

        public function getCodPictograma()
        {
            return $this->codPictograma;
        }

        public function setCodPictogramaCategoria($codPictogramaCategoria)
        {
            $this->codPictogramaCategoria = $codPictogramaCategoria;
        }

        public function getCodPictogramaCategoria()
        {
            return $this->codPictogramaCategoria;
        }

        public function setCodSugestaoHorario($codSugestaoHorario)
        {
            $this->codSugestaoHorario = $codSugestaoHorario;
        }

        public function getCodSugestaoHorario()
        {
            return $this->codSugestaoHorario;
        }

        public function setCodViaAdministracao($codViaAdministracao)
        {
            $this->codViaAdministracao = $codViaAdministracao;
        }

        public function getCodViaAdministracao()
        {
            return $this->codViaAdministracao;
        }

        public function setCodUnidadeMedida($codUnidadeMedida)
        {
            $this->codUnidadeMedida = $codUnidadeMedida;
        }

        public function getCodUnidadeMedida()
        {
            return $this->codUnidadeMedida;
        }

        public function setArquivo($arquivo)
        {
            $this->arquivo = $arquivo;
        }

        public function getArquivo()
        {
            return $this->arquivo;
        }

        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }

        public function getTipo()
        {
            return $this->tipo;
        }

        public function setEstado($estado)
        {
            $this->estado = $estado;
        }

        public function getEstado()
        {
            return $this->estado;
        }

        public function setReferente($referente)
        {
            $this->referente = $referente;
        }

        public function getReferente()
        {
            return $this->referente;
        }

        public function incluir()
        {
            try {
                $query = "INSERT INTO " . $this->banco . "." . $this->tabela . " (codPictogramaCategoria,codSugestaoHorario,codViaAdministracao,codUnidadeMedida,arquivo,tipo,estado,referente) VALUES (:codPictogramaCategoria,:codSugestaoHorario,:codViaAdministracao,:codUnidadeMedida,:arquivo,:tipo,:estado,:referente);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictogramaCategoria", $this->getCodPictogramaCategoria());
                $sql->bindValue(":codSugestaoHorario", $this->getCodSugestaoHorario());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":arquivo", $this->getArquivo());
                $sql->bindValue(":tipo", $this->getTipo());
                $sql->bindValue(":estado", $this->getEstado());
                $sql->bindValue(":referente", $this->getReferente());
                $sql->execute();
                $this->setCodPictograma(MySql::ultimoCodigoInserido());
                return "Pictograma incluido com sucesso!";
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Pictograma" . $e->getMessage(), 1);
            }
        }

        public function salvar()
        {
            try {
                $query = "UPDATE " . $this->banco . "." . $this->tabela . " SET codPictogramaCategoria = :codPictogramaCategoria, codSugestaoHorario = :codSugestaoHorario, codViaAdministracao = :codViaAdministracao, codUnidadeMedida = :codUnidadeMedida, arquivo = :arquivo, tipo = :tipo, estado = :estado, referente = :referente WHERE codPictograma = :codPictograma;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->bindValue(":codPictogramaCategoria", $this->getCodPictogramaCategoria());
                $sql->bindValue(":codSugestaoHorario", $this->getCodSugestaoHorario());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":arquivo", $this->getArquivo());
                $sql->bindValue(":tipo", $this->getTipo());
                $sql->bindValue(":estado", $this->getEstado());
                $sql->bindValue(":referente", $this->getReferente());
                $sql->execute();
                return "Pictograma alterado com sucesso!";
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Pictograma" . $e->getMessage(), 1);
            }
        }

        public function excluir()
        {
            try {
                $query = "DELETE FROM " . $this->banco . "." . $this->tabela . " WHERE codPictograma = :codPictograma;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->execute();
                return "Pictograma excluido com sucesso!";
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Pictograma" . $e->getMessage(), 1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE codPictograma = :codPictograma LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPictograma", $this->getCodPictograma());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if (isset($row['codPictograma']) && !empty($row['codPictograma'])) {
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $this->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setArquivo($row['arquivo']);
                    $this->setTipo($row['tipo']);
                    $this->setEstado($row['estado']);
                    $this->setReferente($row['referente']);

                }
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Pictograma" . $e->getMessage(), 1);
            }
        }

        public function carregarPeloArquivo()
        {
            try {
                $query = "SELECT * FROM " . $this->banco . "." . $this->tabela . " WHERE arquivo = :arquivo LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":arquivo", $this->getArquivo());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if (isset($row['codPictograma']) && !empty($row['codPictograma'])) {
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $this->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setArquivo($row['arquivo']);
                    $this->setTipo($row['tipo']);
                    $this->setEstado($row['estado']);
                    $this->setReferente($row['referente']);
                }
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Pictograma" . $e->getMessage(), 1);
            }
        }

        public function carregarItemMenosAvaliadoExterno()
        {
            try {
                $query = "SELECT p.*
                FROM " . $this->banco . "." . $this->tabela . " as p
                WHERE p.codPictograma IN (
                  SELECT o.codPictograma
                  FROM " . $this->banco . ".pictogramaAvaliacaoExternaOpcao o
                  LEFT JOIN " . $this->banco . ".pictogramaAvaliacaoExternaItem i 
                    ON o.codPictograma = i.codPictograma
                  GROUP BY o.codPictograma
                  HAVING COUNT(i.codPictogramaAvaliacaoExternaItem) = (
                    SELECT MIN(cnt)
                    FROM (
                      SELECT COUNT(i2.codPictogramaAvaliacaoExternaItem) AS cnt
                      FROM " . $this->banco . ".pictogramaAvaliacaoExternaOpcao o2
                      LEFT JOIN " . $this->banco . ".pictogramaAvaliacaoExternaItem i2 
                        ON o2.codPictograma = i2.codPictograma
                      GROUP BY o2.codPictograma
                    ) AS sub
                  )
                )";

                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if (isset($row['codPictograma']) && !empty($row['codPictograma'])) {
                    $this->setCodPictograma($row['codPictograma']);
                    $this->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $this->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setArquivo($row['arquivo']);
                    $this->setTipo($row['tipo']);
                    $this->setEstado($row['estado']);
                    $this->setReferente($row['referente']);
                }
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Pictograma" . $e->getMessage(), 1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPictograma'] = $this->getCodPictograma();
                $array['codPictogramaCategoria'] = $this->getCodPictogramaCategoria();
                $array['codSugestaoHorario'] = $this->getCodSugestaoHorario();
                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['codUnidadeMedida'] = $this->getCodUnidadeMedida();
                $array['arquivo'] = $this->getArquivo();
                $array['tipo'] = $this->getTipo();
                $array['estado'] = $this->getEstado();
                $array['referente'] = $this->getReferente();

                return $array;
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Pictograma" . $e->getMessage(), 1);
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
                    $esteObjeto = new Pictograma();
                    $esteObjeto->setCodPictograma($row['codPictograma']);
                    $esteObjeto->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $esteObjeto->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $esteObjeto->setArquivo($row['arquivo']);
                    $esteObjeto->setTipo($row['tipo']);
                    $esteObjeto->setEstado($row['estado']);
                    $esteObjeto->setReferente($row['referente']);
                    $colObjeto->add($aux, $esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Pictogramas" . $e->getMessage(), 1);
            }
        }

        public function carregarRandonMenosFrequenteAvaliacaoCopreensibilidade($quantidade)
        {
            try {
                $colObjeto = new phpCollection();
                $query = "
                SELECT *, p.codPictograma as codPictograma
                    FROM " . $this->banco . "." . $this->tabela . " p
                    LEFT JOIN (
                        SELECT codPictograma, COUNT(*) AS total_avaliacoes
                        FROM " . $this->banco . ".pictogramaAvaliacaoCompreensibilidade
                        GROUP BY codPictograma
                    ) pac ON p.codPictograma = pac.codPictograma
                    WHERE estado = 'Ativo' 
                    ORDER BY COALESCE(pac.total_avaliacoes, 0) ASC, RAND()
                    LIMIT $quantidade;
                ";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while ($row = $sql->fetch()) {
                    $esteObjeto = new Pictograma();
                    $esteObjeto->setCodPictograma($row['codPictograma']);
                    $esteObjeto->setCodPictogramaCategoria($row['codPictogramaCategoria']);
                    $esteObjeto->setCodSugestaoHorario($row['codSugestaoHorario']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $esteObjeto->setArquivo($row['arquivo']);
                    $esteObjeto->setTipo($row['tipo']);
                    $esteObjeto->setEstado($row['estado']);
                    $esteObjeto->setReferente($row['referente']);
                    $colObjeto->add($aux, $esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Pictogramas" . $e->getMessage(), 1);
            }
        }

        public function combo($selecionado = '', $cboID = "cboPictograma", $multiplo = '')
        {
            try {
                if ($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o pictograma'>";
                $query = "SELECT * FROM " . $this->banco . "." . $this->tabela . ";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida .= "<option label='default'></option>";
                while ($row = $sql->fetch()) {
                    $saida .= "<option ";
                    if ($selecionado == $row['codPictograma'] || (is_array($selecionado) && in_array($row['codPictograma'], $selecionado))) $saida .= "selected ";
                    $saida .= "value='" . $row['codPictograma'] . "'>" . $row['codPictogramaCategoria'] . "</option>";
                }
                $saida .= "</select>";
                return $saida;
            } catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Pictograma" . $e->getMessage(), 1);
            }
        }
    }
}