<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codBannerPromocao = $_POST['codBannerPromocao'];
	$codOrdenacaoBannerPromocao = $_POST['codOrdenacaoBannerPromocao'];
		
	$sql =  "UPDATE bannersPromocoes SET codOrdenacaoBannerPromocao = '".$codOrdenacaoBannerPromocao."' WHERE codBannerPromocao = '".$codBannerPromocao."'";
	$result = $conn->query($sql);
?>
