<?php
if($_POST['conteudo'])
{
	$tmp = explode(";base64", $_POST['conteudo']);
	$data = base64_decode($tmp[1]);
	$nomeArquivo = uniqid();
	if($_POST['extensao']) $nomeArquivo = $nomeArquivo.".".$_POST['extensao'];
	$saida = file_put_contents("/tmp/".$nomeArquivo,  $data , LOCK_EX);
	if($saida) echo $nomeArquivo;
}
?>