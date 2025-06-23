<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Medicamento
    {
        private $banco;
        private $tabela = "medicamento";

        private $codMedicamento;
        private $noPrincipioAtivo;
        private $concentracao;
        private $unidadeFornecimento;
        private $noPrincipioAtivoFiltro;
        private $codFormaFarmaceutica;

        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodMedicamento($codMedicamento)
        {
            $this->codMedicamento = $codMedicamento;
        }
        public function getCodMedicamento()
        {
            return $this->codMedicamento;
        }

        public function setNoPrincipioAtivo($noPrincipioAtivo)
        {
            $this->noPrincipioAtivo = $noPrincipioAtivo;
        }
        public function getNoPrincipioAtivo()
        {
            return $this->noPrincipioAtivo;
        }

        public function setConcentracao($concentracao)
        {
            $this->concentracao = $concentracao;
        }
        public function getConcentracao()
        {
            return $this->concentracao;
        }

        public function setUnidadeFornecimento($unidadeFornecimento)
        {
            $this->unidadeFornecimento = $unidadeFornecimento;
        }
        public function getUnidadeFornecimento()
        {
            return $this->unidadeFornecimento;
        }

        public function setNoPrincipioAtivoFiltro($noPrincipioAtivoFiltro)
        {
            $this->noPrincipioAtivoFiltro = $noPrincipioAtivoFiltro;
        }
        public function getNoPrincipioAtivoFiltro()
        {
            return $this->noPrincipioAtivoFiltro;
        }

        public function setCodFormaFarmaceutica($codFormaFarmaceutica)
        {
            $this->codFormaFarmaceutica = $codFormaFarmaceutica;
        }
        public function getCodFormaFarmaceutica()
        {
            return $this->codFormaFarmaceutica;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (noPrincipioAtivo,concentracao,unidadeFornecimento,noPrincipioAtivoFiltro,codFormaFarmaceutica) VALUES (:noPrincipioAtivo,:concentracao,:unidadeFornecimento,:noPrincipioAtivoFiltro,:codFormaFarmaceutica);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":noPrincipioAtivo", $this->getNoPrincipioAtivo());
                $sql->bindValue(":concentracao", $this->getConcentracao());
                $sql->bindValue(":unidadeFornecimento", $this->getUnidadeFornecimento());
                $sql->bindValue(":noPrincipioAtivoFiltro", $this->getNoPrincipioAtivoFiltro());
                $sql->bindValue(":codFormaFarmaceutica", $this->getCodFormaFarmaceutica());
                $sql->execute();
                $this->setCodMedicamento(MySql::ultimoCodigoInserido());
                return "Medicamento incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Medicamento". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET noPrincipioAtivo = :noPrincipioAtivo, concentracao = :concentracao, unidadeFornecimento = :unidadeFornecimento, noPrincipioAtivoFiltro = :noPrincipioAtivoFiltro, codFormaFarmaceutica = :codFormaFarmaceutica WHERE codMedicamento = :codMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":noPrincipioAtivo", $this->getNoPrincipioAtivo());
                $sql->bindValue(":concentracao", $this->getConcentracao());
                $sql->bindValue(":unidadeFornecimento", $this->getUnidadeFornecimento());
                $sql->bindValue(":noPrincipioAtivoFiltro", $this->getNoPrincipioAtivoFiltro());
                $sql->bindValue(":codFormaFarmaceutica", $this->getCodFormaFarmaceutica());
                $sql->execute();
                return "Medicamento alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Medicamento". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->execute();
                return "Medicamento excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Medicamento" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $this->setConcentracao($row['concentracao']);
                    $this->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $this->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $this->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Medicamento" . $e->getMessage(),1);
            }
        }

        public function carregarPeloNoPrincipioAtivoFiltro()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE REPLACE(noPrincipioAtivoFiltro, ' ', '') LIKE REPLACE(:noPrincipioAtivoFiltro, ' ', '') LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":noPrincipioAtivoFiltro", "%".$this->getNoPrincipioAtivoFiltro()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $this->setConcentracao($row['concentracao']);
                    $this->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $this->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $this->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Medicamento" . $e->getMessage(),1);
            }
        }

        public function carregarPeloNoPrincipioAtivoConcentracaoFormaFarmaceutia($principioAtivo,$concentracao,$unidadeFornecimento,$formaFarmaceutica)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE noPrincipioAtivo = :noPrincipioAtivo AND concentracao = :concentracao AND unidadeFornecimento = :unidadeFornecimento AND codFormaFarmaceutica = (SELECT codFormaFarmaceutica FROM ".$this->banco.".formaFarmaceutica WHERE formaFarmaceutica = :formaFarmaceutica)  LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":noPrincipioAtivo", $principioAtivo);
                $sql->bindValue(":concentracao", $concentracao);
                $sql->bindValue(":unidadeFornecimento", $unidadeFornecimento);
                $sql->bindValue(":formaFarmaceutica", $formaFarmaceutica);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codMedicamento']) && !empty($row['codMedicamento'])) {
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $this->setConcentracao($row['concentracao']);
                    $this->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $this->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $this->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Medicamento" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['noPrincipioAtivo'] = $this->getNoPrincipioAtivo();
                $array['concentracao'] = $this->getConcentracao();
                $array['unidadeFornecimento'] = $this->getUnidadeFornecimento();
                $array['noPrincipioAtivoFiltro'] = $this->getNoPrincipioAtivoFiltro();
                $array['codFormaFarmaceutica'] = $this->getCodFormaFarmaceutica();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Medicamento" . $e->getMessage(),1);
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
                    $esteObjeto = new Medicamento();
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $esteObjeto->setConcentracao($row['concentracao']);
                    $esteObjeto->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $esteObjeto->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $esteObjeto->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Medicamentos" . $e->getMessage(),1);
            }
        }

        public function carregarTodosSemAnvisa()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento NOT IN (SELECT codMedicamento FROM ".$this->banco.".medicamentoAnvisa WHERE principal = 0);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);

                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Medicamento();
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $esteObjeto->setConcentracao($row['concentracao']);
                    $esteObjeto->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $esteObjeto->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $esteObjeto->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Medicamentos" . $e->getMessage(),1);
            }
        }

        public function carregarTodosPrincipioAtivo()
        {
            try {
                $colObjeto = new phpCollection();
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE noPrincipioAtivoFiltro LIKE :noPrincipioAtivoFiltro;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":noPrincipioAtivoFiltro", "%".$this->getNoPrincipioAtivoFiltro()."%");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $aux = 0;
                while($row = $sql->fetch()) {
                    $esteObjeto = new Medicamento();
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setNoPrincipioAtivo($row['noPrincipioAtivo']);
                    $esteObjeto->setConcentracao($row['concentracao']);
                    $esteObjeto->setUnidadeFornecimento($row['unidadeFornecimento']);
                    $esteObjeto->setNoPrincipioAtivoFiltro($row['noPrincipioAtivoFiltro']);
                    $esteObjeto->setCodFormaFarmaceutica($row['codFormaFarmaceutica']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Medicamento" . $e->getMessage(),1);
            }
        }

        public function combo($selecionado='',$cboID = "cboMedicamento",$multiplo = '',$listaMedicamento = "")
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o medicamento'>";
                if($listaMedicamento) $listaMedicamento = " AND codMedicamento IN (".$listaMedicamento.")";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE 1=1 $listaMedicamento;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codMedicamento'] || ( is_array($selecionado) && in_array($row['codMedicamento'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codMedicamento']."'>".$row['noPrincipioAtivo']." ".$row['concentracao']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Medicamento" . $e->getMessage(),1);
            }
        }
    }
}