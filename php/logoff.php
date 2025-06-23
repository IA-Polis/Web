<?php
// Autor: Isaias
// Gerada em 23/12/2016 18:24:15
// Última atualização em 23/12/2016 18:24:15
// Gerada pela classe GeradorClasses C# versão 3.1.0.0
?>
<?php require_once("../config/config.php");
$_SESSION['LOGADO'] = false;
$_SESSION['NOMEUSUARIO'] = '';
$_SESSION['CODIGOUSUARIO'] = '';
$_SESSION['TIPOACESSO'] = '';
$_SESSION['CARRINHO'] = '';
session_unset();
session_destroy();
session_start();
?>