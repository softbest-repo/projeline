<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codOrcamento = $_POST['codOrcamento'];
	$codOrdenacaoOrcamento = $_POST['codOrdenacaoOrcamento'];
	
	$sqlCons = "SELECT * FROM orcamentos WHERE codOrcamento = '".$codOrcamento."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE orcamentos SET codOrdenacaoOrcamento = '".$codOrdenacaoOrcamento."' WHERE codOrcamento = '".$codOrcamento."'";
	$result = $conn->query($sql);
?>
