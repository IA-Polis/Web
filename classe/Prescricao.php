<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro

namespace Classe {
    use Config\phpCollection as phpCollection;
    use Config\MySql as MySql;
    use PDO as PDO;
    use Exception as Exception; 

    class Prescricao
    {
        private $banco;
        private $tabela = "prescricao";

        private $codPrescricao;
        private $codReceituario;
        private $codReceituarioV2;
        private $codViaAdministracao;
        private $codUnidadeMedida;
        private $codMedicamento;
        private $quantidadeDose;
        private $quantidadeSolicitada;
        private $inicioTratamento;
        private $conclusaoTratamento;
        private $posologia;
        private $usoContinuo;


        function __construct() {
            $this->banco = $GLOBALS['MYSQL_BANCO'];
        }

        public function setCodPrescricao($codPrescricao)
        {
            $this->codPrescricao = $codPrescricao;
        }
        public function getCodPrescricao()
        {
            return $this->codPrescricao;
        }

        public function setCodReceituario($codReceituario)
        {
            $this->codReceituario = $codReceituario;
        }
        public function getCodReceituario()
        {
            return $this->codReceituario;
        }

        public function setCodReceituarioV2($codReceituarioV2)
        {
            $this->codReceituarioV2 = $codReceituarioV2;
        }
        public function getCodReceituarioV2()
        {
            return $this->codReceituarioV2;
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

        public function setCodMedicamento($codMedicamento)
        {
            $this->codMedicamento = $codMedicamento;
        }
        public function getCodMedicamento()
        {
            return $this->codMedicamento;
        }

        public function setQuantidadeDose($quantidadeDose)
        {
            $this->quantidadeDose = $quantidadeDose;
        }
        public function getQuantidadeDose()
        {
            return $this->quantidadeDose;
        }

        public function setQuantidadeSolicitada($quantidadeSolicitada)
        {
            $this->quantidadeSolicitada = $quantidadeSolicitada;
        }
        public function getQuantidadeSolicitada()
        {
            return $this->quantidadeSolicitada;
        }

        public function setInicioTratamento($inicioTratamento)
        {
            $this->inicioTratamento = $inicioTratamento;
        }
        public function getInicioTratamento()
        {
            return $this->inicioTratamento;
        }

        public function setConclusaoTratamento($conclusaoTratamento)
        {
            $this->conclusaoTratamento = $conclusaoTratamento;
        }
        public function getConclusaoTratamento()
        {
            return $this->conclusaoTratamento;
        }

        public function setPosologia($posologia)
        {
            $this->posologia = $posologia;
        }
        public function getPosologia()
        {
            return $this->posologia;
        }

        public function setUsoContinuo($usoContinuo)
        {
            $this->usoContinuo = $usoContinuo;
        }
        public function getUsoContinuo()
        {
            return $this->usoContinuo;
        }

        public function incluir()
        {
            try {
                $query	= "INSERT INTO ".$this->banco.".".$this->tabela." (codReceituario,codReceituarioV2,codViaAdministracao,codUnidadeMedida,codMedicamento,quantidadeDose,quantidadeSolicitada,inicioTratamento,conclusaoTratamento,posologia,usoContinuo) VALUES (:codReceituario,:codReceituarioV2,:codViaAdministracao,:codUnidadeMedida,:codMedicamento,:quantidadeDose,:quantidadeSolicitada,:inicioTratamento,:conclusaoTratamento,:posologia,:usoContinuo);";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituario", $this->getCodReceituario());
                $sql->bindValue(":codReceituarioV2", $this->getCodReceituarioV2());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":quantidadeDose", $this->getQuantidadeDose());
                $sql->bindValue(":quantidadeSolicitada", $this->getQuantidadeSolicitada());
                $sql->bindValue(":inicioTratamento", $this->getInicioTratamento());
                $sql->bindValue(":conclusaoTratamento", $this->getConclusaoTratamento());
                $sql->bindValue(":posologia", $this->getPosologia());
                $sql->bindValue(":usoContinuo", $this->getUsoContinuo());
                $sql->execute();
                $this->setCodPrescricao(MySql::ultimoCodigoInserido());
                return "Prescricao incluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar  incluir Prescricao". $e->getMessage(),1);
            }
        }

        public function salvar()
        {
            try {
                $query	= "UPDATE ".$this->banco.".".$this->tabela." SET codReceituario = :codReceituario, codReceituarioV2 = :codReceituarioV2, codViaAdministracao = :codViaAdministracao, codUnidadeMedida = :codUnidadeMedida, codMedicamento = :codMedicamento, quantidadeDose = :quantidadeDose, quantidadeSolicitada = :quantidadeSolicitada, inicioTratamento = :inicioTratamento, conclusaoTratamento = :conclusaoTratamento, posologia = :posologia, usoContinuo = :usoContinuo WHERE codPrescricao = :codPrescricao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrescricao", $this->getCodPrescricao());
                $sql->bindValue(":codReceituario", $this->getCodReceituario());
                $sql->bindValue(":codReceituarioV2", $this->getCodReceituarioV2());
                $sql->bindValue(":codViaAdministracao", $this->getCodViaAdministracao());
                $sql->bindValue(":codUnidadeMedida", $this->getCodUnidadeMedida());
                $sql->bindValue(":codMedicamento", $this->getCodMedicamento());
                $sql->bindValue(":quantidadeDose", $this->getQuantidadeDose());
                $sql->bindValue(":quantidadeSolicitada", $this->getQuantidadeSolicitada());
                $sql->bindValue(":inicioTratamento", $this->getInicioTratamento());
                $sql->bindValue(":conclusaoTratamento", $this->getConclusaoTratamento());
                $sql->bindValue(":posologia", $this->getPosologia());
                $sql->bindValue(":usoContinuo", $this->getUsoContinuo());
                $sql->execute();
                return "Prescricao alterado com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar alterar Prescricao". $e->getMessage(),1);
            }
        }

        public function excluir()
        {
            try{
                $query = "DELETE FROM ".$this->banco.".".$this->tabela." WHERE codPrescricao = :codPrescricao;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrescricao", $this->getCodPrescricao());
                $sql->execute();
                return "Prescricao excluido com sucesso!";
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar excluir Prescricao" . $e->getMessage(),1);
            }
        }

        public function carregar()
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codPrescricao = :codPrescricao LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codPrescricao", $this->getCodPrescricao());
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrescricao']) && !empty($row['codPrescricao'])) {
                    $this->setCodPrescricao($row['codPrescricao']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setQuantidadeDose($row['quantidadeDose']);
                    $this->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setConclusaoTratamento($row['conclusaoTratamento']);
                    $this->setPosologia($row['posologia']);
                    $this->setUsoContinuo($row['usoContinuo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
            }
        }

        public function carregarUltimaPrescricaoPaciente($codCidadao)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituario = (SELECT codReceituario FROM ".$this->banco.".receituario WHERE codCidadao = :codCidadao ORDER BY codReceituario DESC LIMIT 1 ) LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $codCidadao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrescricao']) && !empty($row['codPrescricao'])) {
                    $this->setCodPrescricao($row['codPrescricao']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setQuantidadeDose($row['quantidadeDose']);
                    $this->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setConclusaoTratamento($row['conclusaoTratamento']);
                    $this->setPosologia($row['posologia']);
                    $this->setUsoContinuo($row['usoContinuo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
            }
        }

        public function carregarUltimaPrescricaoPacienteV2($codCidadao)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV2 IN (SELECT codReceituarioV2 FROM ".$this->banco.".receituarioV2 WHERE codCidadao = :codCidadao ORDER BY codReceituarioV2 DESC) LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codCidadao", $codCidadao);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrescricao']) && !empty($row['codPrescricao'])) {
                    $this->setCodPrescricao($row['codPrescricao']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setQuantidadeDose($row['quantidadeDose']);
                    $this->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setConclusaoTratamento($row['conclusaoTratamento']);
                    $this->setPosologia($row['posologia']);
                    $this->setUsoContinuo($row['usoContinuo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
            }
        }

        public function carregarPrescricaoV2($codReceituarioV2)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codReceituarioV2 = :codReceituarioV2 ORDER BY codPrescricao DESC LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codReceituarioV2", $codReceituarioV2);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrescricao']) && !empty($row['codPrescricao'])) {
                    $this->setCodPrescricao($row['codPrescricao']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setQuantidadeDose($row['quantidadeDose']);
                    $this->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setConclusaoTratamento($row['conclusaoTratamento']);
                    $this->setPosologia($row['posologia']);
                    $this->setUsoContinuo($row['usoContinuo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
            }
        }

        public function inferirPrescricao($codMedicamento, $idade, $codSexo)
        {
            try {
                $query = "SELECT * FROM ".$this->banco.".".$this->tabela." WHERE codMedicamento = :codMedicamento AND codReceituario IN (SELECT codReceituario FROM receituario as r, cidadao as c WHERE c.codCidadao = r.codCidadao AND c.idade = :idade AND c.codSexo = :codSexo) LIMIT 1;";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->bindValue(":codMedicamento", $codMedicamento);
                $sql->bindValue(":idade", $idade);
                $sql->bindValue(":codSexo", $codSexo);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $row = $sql->fetch();
                if(isset($row['codPrescricao']) && !empty($row['codPrescricao'])) {
                    $this->setCodPrescricao($row['codPrescricao']);
                    $this->setCodReceituario($row['codReceituario']);
                    $this->setCodReceituarioV2($row['codReceituarioV2']);
                    $this->setCodViaAdministracao($row['codViaAdministracao']);
                    $this->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $this->setCodMedicamento($row['codMedicamento']);
                    $this->setQuantidadeDose($row['quantidadeDose']);
                    $this->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $this->setInicioTratamento($row['inicioTratamento']);
                    $this->setConclusaoTratamento($row['conclusaoTratamento']);
                    $this->setPosologia($row['posologia']);
                    $this->setUsoContinuo($row['usoContinuo']);
                }
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
            }
        }

        public function carregarArray()
        {
            try {
                $array = [];

                $array['codPrescricao'] = $this->getCodPrescricao();
                $array['codReceituario'] = $this->getCodReceituario();
                $array['codReceituarioV2'] = $this->getCodReceituarioV2();
                $array['codViaAdministracao'] = $this->getCodViaAdministracao();
                $array['codUnidadeMedida'] = $this->getCodUnidadeMedida();
                $array['codMedicamento'] = $this->getCodMedicamento();
                $array['quantidadeDose'] = $this->getQuantidadeDose();
                $array['quantidadeSolicitada'] = $this->getQuantidadeSolicitada();
                $array['inicioTratamento'] = $this->getInicioTratamento();
                $array['conclusaoTratamento'] = $this->getConclusaoTratamento();
                $array['posologia'] = $this->getPosologia();
                $array['usoContinuo'] = $this->getUsoContinuo();

                return $array;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar o Prescricao" . $e->getMessage(),1);
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
                    $esteObjeto = new Prescricao();
                    $esteObjeto->setCodPrescricao($row['codPrescricao']);
                    $esteObjeto->setCodReceituario($row['codReceituario']);
                    $esteObjeto->setCodReceituarioV2($row['codReceituarioV2']);
                    $esteObjeto->setCodViaAdministracao($row['codViaAdministracao']);
                    $esteObjeto->setCodUnidadeMedida($row['codUnidadeMedida']);
                    $esteObjeto->setCodMedicamento($row['codMedicamento']);
                    $esteObjeto->setQuantidadeDose($row['quantidadeDose']);
                    $esteObjeto->setQuantidadeSolicitada($row['quantidadeSolicitada']);
                    $esteObjeto->setInicioTratamento($row['inicioTratamento']);
                    $esteObjeto->setConclusaoTratamento($row['conclusaoTratamento']);
                    $esteObjeto->setPosologia($row['posologia']);
                    $esteObjeto->setUsoContinuo($row['usoContinuo']);
                    $colObjeto->add($aux,$esteObjeto);
                    $aux++;
                }
                return $colObjeto;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar todos os Prescricaos" . $e->getMessage(),1);
            }
        }

        public function gerarTextoPrescricao($codReceituario,$codReceituarioV2 = null,$html = true){
            if($codReceituario)$colPrescricao = $this->carregarTodosCriterio('codReceituario', $codReceituario);
            else if($codReceituarioV2)$colPrescricao = $this->carregarTodosCriterio('codReceituarioV2', $codReceituarioV2);
            $texto = "";

            if ($colPrescricao->length > 0) {
                $aux2 = 1;
                if($html) $texto .= "Medicamentos<br>";
                else $texto .= "\n\nMedicamentos\n";
                do {

                    $medicamento = new \Classe\Medicamento();
                    $medicamento->setCodMedicamento($colPrescricao->current()->getCodMedicamento());
                    $medicamento->carregar();

                    $formaFarmaceutica = new \Classe\FormaFarmaceutica();
                    $formaFarmaceutica->setCodFormaFarmaceutica($medicamento->getCodFormaFarmaceutica());
                    $formaFarmaceutica->carregar();

                    $viaAdmininistracao = new \Classe\ViaAdministracao();
                    $viaAdmininistracao->setCodViaAdministracao($colPrescricao->current()->getCodViaAdministracao());
                    $viaAdmininistracao->carregar();

                    $unidadeMedida = new \Classe\UnidadeMedida();
                    $unidadeMedida->setCodUnidadeMedida($colPrescricao->current()->getCodUnidadeMedida());
                    $unidadeMedida->carregar();

                    $usoContinuo = "";
                    if($colPrescricao->current()->getUsoContinuo()) $usoContinuo = " uso contínuo ";

                    if($html) $texto .= "<b>" . $medicamento->getNoPrincipioAtivo() . " " . $medicamento->getConcentracao() . " ".$medicamento->getUnidadeFornecimento()." ".$formaFarmaceutica->getFormaFarmaceutica()." ".$usoContinuo."</b><br>";
                    else $texto .= $medicamento->getNoPrincipioAtivo() . " " . $medicamento->getConcentracao() . " ".$medicamento->getUnidadeFornecimento()." ".$formaFarmaceutica->getFormaFarmaceutica()." ".$usoContinuo."\n";
                    if ($colPrescricao->current()->getQuantidadeSolicitada() > 1){
                        if($html) $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedidaPlural() . "<br>";
                        else $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedidaPlural() . "\n";
                    }
                    else{
                        if($html) $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedidaPlural() . "<br>";
                        $texto .= $colPrescricao->current()->getQuantidadeSolicitada() . " " . $unidadeMedida->getUnidadeMedidaPlural() . "\n";
                    }

                    if($html) $texto .= "<br>Via de administração: " .$viaAdmininistracao->getViaAdministracao();
                    else $texto .= "\nVia de administração: " .$viaAdmininistracao->getViaAdministracao();

                    if($html) $texto .= "<br>Posologia:<br>" . $colPrescricao->current()->getPosologia() . "<br>";
                    else $texto .= "\nPosologia:\n" . $colPrescricao->current()->getPosologia() . "\n";

                } while ($colPrescricao->has_next());
            }

            return $texto;
        }

        public function combo($selecionado='',$cboID = "cboPrescricao",$multiplo = '')
        {
            try{
                if($multiplo) $multiplo = '[] multiple';
                $saida = "<select class='standardSelect' id=$cboID name=$cboID $multiplo data-placeholder='Selecione o prescricao'>";
                $query= "SELECT * FROM ".$this->banco.".".$this->tabela.";";
                $conexao = MySql::getInstancia();
                $sql = $conexao->prepare($query);
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $saida	.= "<option label='default'></option>"; 
                while($row = $sql->fetch()){
                        $saida	.= "<option ";
                        if ($selecionado == $row['codPrescricao'] || ( is_array($selecionado) && in_array($row['codPrescricao'],$selecionado)))	$saida	.= "selected ";
                        $saida	.= "value='".$row['codPrescricao']."'>".$row['codReceituario']."</option>";
                }
                $saida .="</select>";
                return $saida;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro ao tentar carregar combo Prescricao" . $e->getMessage(),1);
            }
        }
    }
}