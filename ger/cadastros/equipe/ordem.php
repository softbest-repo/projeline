<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codEquipe = $_POST['codEquipe'];
	$codOrdenacaoEquipe = $_POST['codOrdenacaoEquipe'];
	
	$sqlCons = "SELECT * FROM equipe WHERE codEquipe = '".$codEquipe."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE equipe SET codOrdenacaoEquipe = '".$codOrdenacaoEquipe."' WHERE codEquipe = '".$codEquipe."'";
	$result = $conn->query($sql);
?>
