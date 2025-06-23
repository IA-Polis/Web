<?php
require_once("config/config.php");
if (!isset($_SESSION['LOGADO']) || !$_SESSION['LOGADO']) header("Location: http://" . $GLOBALS['NOMESERVIDOR'] . "/index.php");
require_once("config/cabecalho.php");
?>
    <div class="loading"></div>
    <div class="container-fluid block_gr"></div>
<?php require_once("config/rodape.php"); ?>