<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codBannerPromocao = $_POST['codBannerPromocao'];
	$codOrdenacaoBannerPromocao = $_POST['codOrdenacaoBannerPromocao'];
	
	$sqlCons = "SELECT * FROM bannersPromocoes WHERE codBannerPromocao = '".$codBannerPromocao."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE bannersPromocoes SET codOrdenacaoBannerPromocao = '".$codOrdenacaoBannerPromocao."' WHERE codBannerPromocao = '".$codBannerPromocao."'";
	$result = $conn->query($sql);
?>
