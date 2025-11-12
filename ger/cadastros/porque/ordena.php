<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codAtuacao = $_POST['codPorque'];
	$codOrdenacaoPorque = $_POST['codOrdenacaoPorque'];
		
	$sql =  "UPDATE porque SET codOrdenacaoPorque = '".$codOrdenacaoPorque."' WHERE codPorque = '".$codPorque."'";
	$result = $conn->query($sql);
?>
