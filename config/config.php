<?php
session_start();
$_SESSION['discard_after'] = time() + 3600;
require_once('configSemSessao.php');
?>