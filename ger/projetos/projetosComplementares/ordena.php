<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codProjetoComplementar = $_POST['codProjetoComplementar'];
	$codOrdenacaoProjetoComplementar = $_POST['codOrdenacaoProjetoComplementar'];
		
	$sql =  "UPDATE projetosComplementares SET codOrdenacaoProjetoComplementar = '".$codOrdenacaoProjetoComplementar."' WHERE codProjetoComplementar = '".$codProjetoComplementar."'";
	$result = $conn->query($sql);
?>
