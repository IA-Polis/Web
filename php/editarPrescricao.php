<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");
$rest = new Config\REST();
if(isset($_SESSION['PERMISSOES']['editarPrescricao'])){
    if(isset($_POST['btnEditarPrescricao']))
    {
        $newPrescricao = new Classe\Prescricao();
        $newPrescricao->setCodPrescricao($_POST['cboPrescricao']);
        $newPrescricao->carregar();
        if(isset($_POST['cboReceituario'])) $newPrescricao->setCodReceituario($_POST['cboReceituario']);
        if(isset($_POST['cboViaAdministracao'])) $newPrescricao->setCodViaAdministracao($_POST['cboViaAdministracao']);
        if(isset($_POST['cboUnidadeMedida'])) $newPrescricao->setCodUnidadeMedida($_POST['cboUnidadeMedida']);
        if(isset($_POST['cboMedicamento'])) $newPrescricao->setCodMedicamento($_POST['cboMedicamento']);
        if(isset($_POST['txtQuantidadeDose'])) $newPrescricao->setQuantidadeDose($_POST['txtQuantidadeDose']);
        if(isset($_POST['txtQuantidadeSolicitada'])) $newPrescricao->setQuantidadeSolicitada($_POST['txtQuantidadeSolicitada']);
        if(isset($_POST['txtInicioTratamento'])) $newPrescricao->setInicioTratamento($_POST['txtInicioTratamento']);
        if(isset($_POST['txtConclusaoTratamento'])) $newPrescricao->setConclusaoTratamento($_POST['txtConclusaoTratamento']);
        if(isset($_POST['txtPosologia'])) $newPrescricao->setPosologia($_POST['txtPosologia']);
        if(isset($_POST['txtRecomendacoes'])) $newPrescricao->setRecomendacoes($_POST['txtRecomendacoes']);
        if (
            isset($_POST['cboReceituario']) && !empty($_POST['cboReceituario']) && 
            isset($_POST['cboViaAdministracao']) && !empty($_POST['cboViaAdministracao']) && 
            isset($_POST['cboUnidadeMedida']) && !empty($_POST['cboUnidadeMedida']) && 
            isset($_POST['cboMedicamento']) && !empty($_POST['cboMedicamento']) && 
            isset($_POST['txtQuantidadeDose']) && !empty($_POST['txtQuantidadeDose']) && 
            isset($_POST['txtQuantidadeSolicitada']) && !empty($_POST['txtQuantidadeSolicitada']) && 
            isset($_POST['txtInicioTratamento']) && !empty($_POST['txtInicioTratamento']) &&
            isset($_POST['txtPosologia']) && !empty($_POST['txtPosologia'])
        )
        {
            try
            {
                $saida = "<div class='alert alert-success alert-dismissable'>".$newPrescricao->salvar()."</div>";
                $rest->response($saida,200);
            }
            catch (Exception $exception)
            {
                $saida = "<div class='alert alert-danger alert-dismissable'>".$exception->getMessage()."</div>";
                $rest->response($saida,500);
            }
        }
        else
        {
            $saida = '';
            if(!isset($_POST['cboReceituario']) || empty($_POST['cboReceituario'])) $saida .= ' Receituario';
            if(!isset($_POST['cboViaAdministracao']) || empty($_POST['cboViaAdministracao'])) $saida .= ' Via de Administração';
            if(!isset($_POST['cboUnidadeMedida']) || empty($_POST['cboUnidadeMedida'])) $saida .= ' Unidade de Medida';
            if(!isset($_POST['cboMedicamento']) || empty($_POST['cboMedicamento'])) $saida .= ' Medicamento';
            if(!isset($_POST['txtQuantidadeDose']) || empty($_POST['txtQuantidadeDose'])) $saida .= ' Quantidade da Dose';
            if(!isset($_POST['txtQuantidadeSolicitada']) || empty($_POST['txtQuantidadeSolicitada'])) $saida .= ' Quantidade Solicitada';
            if(!isset($_POST['txtInicioTratamento']) || empty($_POST['txtInicioTratamento'])) $saida .= ' Inicio do Tratamento';
            if(!isset($_POST['txtPosologia']) || empty($_POST['txtPosologia'])) $saida .= ' Posologia';
            $saida = "<div class='alert alert-danger alert-dismissable'>Campos obrigatórios não prenchidos: ".$saida."</div>";
            $rest->response($saida,400);
        }
    }
}
else
{
    $saida = "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";
    $rest->response($saida,401);
}
?>
