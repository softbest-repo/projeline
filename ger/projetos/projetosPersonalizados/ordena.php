<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codProjetoPersonalizado = $_POST['codProjetoPersonalizado'];
	$codOrdenacaoProjetoPersonalizado = $_POST['codOrdenacaoProjetoPersonalizado'];
		
	$sql =  "UPDATE projetosPersonalizados SET codOrdenacaoProjetoPersonalizado = '".$codOrdenacaoProjetoPersonalizado."' WHERE codProjetoPersonalizado = '".$codProjetoPersonalizado."'";
	$result = $conn->query($sql);
?>
