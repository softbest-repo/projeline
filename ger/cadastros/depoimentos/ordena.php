<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codDepoimento = $_POST['codDepoimento'];
	$codOrdenacaoDepoimento = $_POST['codOrdenacaoDepoimento'];
		
	$sql =  "UPDATE depoimentos SET codOrdenacaoDepoimento = '".$codOrdenacaoDepoimento."' WHERE codDepoimento = '".$codDepoimento."'";
	$result = $conn->query($sql);
?>
