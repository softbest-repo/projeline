<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codComparativo = $_POST['codComparativo'];
	$codOrdenacaoComparativo = $_POST['codOrdenacaoComparativo'];
	
	$sqlCons = "SELECT * FROM comparativos WHERE codComparativo = '".$codComparativo."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE comparativos SET codOrdenacaoComparativo = '".$codOrdenacaoComparativo."' WHERE codComparativo = '".$codComparativo."'";
	$result = $conn->query($sql);
?>
