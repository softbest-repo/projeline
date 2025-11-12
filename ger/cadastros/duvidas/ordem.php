<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codDuvida = $_POST['codDuvida'];
	$codOrdenacaoDuvida = $_POST['codOrdenacaoDuvida'];
	
	$sqlCons = "SELECT * FROM duvidas WHERE codDuvida = '".$codDuvida."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE duvidas SET codOrdenacaoDuvida = '".$codOrdenacaoDuvida."' WHERE codDuvida = '".$codDuvida."'";
	$result = $conn->query($sql);
?>
